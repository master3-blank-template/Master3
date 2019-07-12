<?php
/**
 * @package     Joomla.Site
 * @subpackage  Form
 * 
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov (AlekVolsk). All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Form\FormField;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');

class JFormFieldVersions extends FormField
{
    protected $type = 'versions';

    protected function getInput()
    {
        $template_name = \Master3Config::getTemplateName();
        $templatePath = JPATH_ROOT . "/templates/{$template_name}/";

        $xmlFiles = [
            'templateDetails.xml',
            'uikit/uikit.xml'
        ];

        $out = '<dl>';

        foreach ($xmlFiles as $file) {
            $filePath = realpath(Path::clean($templatePath . $file));
            $xml = @simplexml_load_file($filePath);
            if ($xml) {
                $xml = (array)$xml;

                $tag = 'span';
                $href = '';

                $title = [];
                $title[] = $xml['author'];
                if (isset($xml['authorUrl'])) {
                    $title[] = $xml['authorUrl'];
                    $tag = 'a';
                    $href = ' href="' . $xml['authorUrl'] . '" target="_blank"';
                }
                if (isset($xml['license'])) {
                    $title[] = $xml['license'];
                }
                $title = $title ? ' title="' . implode('<br>', $title) . '" class="hasTooltip"' : '';

                $out .= '<dt><strong><' . $tag . $href . $title . '>' . $xml['name'] . '</' . $tag . '></strong>:</dt><dd>' . $xml['version'] . '</dd>';
            }
        }

        $out .= '</dl>';

        return $out;
    }
}