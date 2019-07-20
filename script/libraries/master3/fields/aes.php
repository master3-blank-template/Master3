<?php
/**
 * @package     Joomla.Site
 * @subpackage  Form
 * 
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov (AlekVolsk). All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
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

        if ((int)$this->element['styles'] == true) {
            HTMLHelper::stylesheet('media/master3/aes/aes.css', ['version' => 'auto']);
        }

        if ((int)$this->element['script'] == true) {
            HTMLHelper::script('media/master3/aes/aes.js', ['version' => 'auto']);
        }
        
        return '';
    }
}