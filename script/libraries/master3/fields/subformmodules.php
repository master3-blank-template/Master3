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

class JFormFieldSubformModules extends \JFormFieldSubform
{
    protected $type = 'subformmodules';

    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        if (!parent::setup($element, $value, $group)) {
            return false;
        }

        $fields = $this->getFormFields();
        $modules = $this->getModules();
        $outValues = [];

        foreach ($modules as $key => $module) {
            $originRow = '';

            if ($this->value) {
                foreach ($this->value as $originValue) {
                    if ($originValue['form']['id'] == $module->id) {
                        $originRow = $originValue['form'];
                    }
                }
            } else {
                $originRow = [
                    'id' => 0,
                    'display' => '',
                    'moduleBox' => 'uk-panel',
                    'modulePadding' => '',
                    'moduleAlign' => '',
                    'moduleClass' => '',
                    'titleTag' => 'module',
                    'titleClass' => '',
                    'titleLink' => ''
                ];
            }

            foreach ($fields as $field) {
                $fieldValue = '';

                if ($field === 'id') {
                    $fieldValue = $module->id;
                } elseif ($field === 'name') {
                    $fieldValue = $module->title;
                } elseif ($field === 'type') {
                    $fieldValue = $module->module;
                } elseif ($field === 'position') {
                    $fieldValue = $module->position;
                } elseif ($field === 'lang') {
                    $fieldValue = $module->language;
                } elseif ($originRow && $originRow['id'] === $module->id) {
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
        $xmlFields = (array) $xml->fields;

        $fields = [];
        foreach ($xmlFields['fieldset'] as $fieldset) {
            foreach ($fieldset->field as $field) {
                $fields[] = $field->attributes()->name->__toString();
            }
        }

        return $fields;
    }

    protected function getModules()
    {
        $groups = implode(',', Factory::getUser()->getAuthorisedViewLevels());

        $db = Factory::getDbo();
        $date = Factory::getDate();
        $now = $date->toSql();
        $nullDate = $db->getNullDate();

        $query = $db->getQuery(true)
            ->select('distinct(m.id), m.title, m.module, m.position, m.language')
            ->from('#__modules AS m')
            ->join('LEFT', '#__modules_menu AS mm ON mm.moduleid = m.id')
            ->join('LEFT', '#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id')
            ->where('m.published = 1')
            ->where('e.enabled = 1')
            ->where('(m.publish_up = ' . $db->quote($nullDate) . ' OR m.publish_up <= ' . $db->quote($now) . ' OR m.publish_up is null)')
            ->where('(m.publish_down = ' . $db->quote($nullDate) . ' OR m.publish_down >= ' . $db->quote($now) . ' OR m.publish_down is null)')
            ->where('m.access IN (' . $groups . ')')
            ->where('m.client_id = 0')
            ->order('m.position, m.ordering, m.id');

        try {
            $modules = $db->setQuery($query)->loadObjectList();
        } catch (RuntimeException $e) {
            Log::add(Text::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $e->getMessage()), Log::WARNING, 'jerror');
            return [];
        }

        return $modules;
    }
}
