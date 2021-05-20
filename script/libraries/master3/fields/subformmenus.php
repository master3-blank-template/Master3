<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Language\Text;
use Symfony\Component\Yaml\Exception\RuntimeException;
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('subform');

class JFormFieldSubformMenus extends \JFormFieldSubform
{
    protected $type = 'subformmenus';

    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        if (!parent::setup($element, $value, $group)) {
            return false;
        }

        $fields = $this->getFormFields();
        $menuItems = $this->getMenuItems();
        $outValues = [];

        foreach ($menuItems as $key => $item) {
            $originRow = '';

            if ($this->value) {
                foreach ($this->value as $originValue) {
                    if ($originValue['form']['menuid'] == $item->id) {
                        $originRow = $originValue['form'];
                    }
                }
            } else {
                $originRow = [
                    'menuid' => 0,
                    'gridColumns' => 1,
                    'subtitle' => ''
                ];
            }

            foreach ($fields as $field) {
                $fieldValue = '';

                if ($field === 'menuid') {
                    $fieldValue = $item->id;
                } elseif ($field === 'menutitle') {
                    $fieldValue = $item->name;
                } elseif ($field === 'itemtitle') {
                    $fieldValue = $item->title;
                } elseif ($originRow && $originRow['menuid'] === $item->id) {
                    $fieldValue = isset($originRow[$field]) ? $originRow[$field] : null;
                }

                if ($fieldValue !== null) {
                    $outValues[$this->fieldname . $key]['form'][$field] = $fieldValue;
                }
            }
        }

        $this->value = $outValues;

        return true;
    }

    protected function getFormFields()
    {
        $xml = simplexml_load_file($this->formsource);
        $xmlFields = (array)$xml->fields;

        $fields = [];
        foreach ($xmlFields['fieldset'] as $field) {
            $fields[] = $field->attributes()->name->__toString();
        }

        return $fields;
    }

    protected function getMenuItems()
    {
        $db = Factory::getDbo();

        $query = $db->getQuery(true)
            ->select('m.id, m.title, mt.title as name')
            ->from('#__menu AS m')
            ->join('LEFT', '#__menu_types AS mt ON mt.menutype = m.menutype')
            ->where('m.published = 1')
            ->where('m.level = 1')
            ->where('m.client_id = 0')
            ->where('mt.client_id = 0')
            ->order('mt.id, m.lft');

        try {
            $items = $db->setQuery($query)->loadObjectList();
        } catch (RuntimeException $e) {
            Log::add(Text::sprintf('JLIB_APPLICATION_ERROR_item_LOAD', $e->getMessage()), Log::WARNING, 'jerror');
            return [];
        }

        return $items;
    }
}
