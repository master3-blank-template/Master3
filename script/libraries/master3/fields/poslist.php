<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Form\FormHelper;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');

FormHelper::loadFieldClass('List');

class JFormFieldPoslist extends \JFormFieldList
{
    protected $type = 'poslist';

    protected static $options = array();

    protected function getOptions()
    {
        $hash = md5($this->element);

        $postype = $this->element->attributes()['postype'];
        if ($postype) {
            $postype = $postype->__toString();
        }

        if (!isset(static::$options[$hash])) {
            static::$options[$hash] = parent::getOptions();
            $options = [];
            $list = $this->getPositions($postype);
            if (count($list)) {
                foreach ($list as $k => $item) {
                    $options[$k] = new stdClass;
                    $options[$k]->text = $item;
                    $options[$k]->value = $item;
                }
                static::$options[$hash] = array_merge(static::$options[$hash], $options);
            }
        }
        return static::$options[$hash];
    }

    protected function getPositions($postype = '')
    {
        $positions = [];

        $templateName = \Master3Config::getTemplateName();

        $filePath = realpath(Path::clean(JPATH_ROOT . "/templates/{$templateName}/" . 'templateDetails.xml'));

        if (is_file($filePath)) {
            $xml = simplexml_load_file($filePath);

            if (!$xml) {
                return false;
            }

            if ($xml->getName() != 'extension' && $xml->getName() != 'metafile') {
                unset($xml);
                return false;
            }

            foreach ($xml->positions[0]->position as $position) {
                if ($postype) {
                    if (isset($position[$postype])) {
                        $positions[] = $position->__toString();
                    }
                } else {
                    $positions[] = $position->__toString();
                }
            }
        }

        return array_values(array_unique($positions));
    }
}
