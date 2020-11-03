<?php defined('JPATH_PLATFORM') or die;
/**
 * @package     Joomla.Site
 * @subpackage  Form
 *
 * @copyright   Copyright (C) Aleksey A. Morozov (AlekVolsk). All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\FormField;

class JFormFieldAes extends FormField
{
    protected $type = 'aes';

    protected function getLabel()
    {
        return '';
    }

    protected function getInput()
    {
        if (Factory::getApplication()->isClient('administrator') === false) {
            return '';
        }

        if ((bool) $this->element['styles']) {
            HTMLHelper::stylesheet('media/master3/aes/aes.css', ['version' => 'auto']);
        }

        if ((bool) $this->element['script']) {
            HTMLHelper::script('media/master3/aes/aes.js', ['version' => 'auto']);
        }

        return '';
    }
}
