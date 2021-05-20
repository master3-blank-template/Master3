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

FormHelper::loadFieldClass('subform');

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');

class JFormFieldSubformFiles extends \JFormFieldSubform
{
    protected $type = 'subformfiles';

    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        if (!parent::setup($element, $value, $group)) {
            return false;
        }

        $fields = $this->getFormFields();
        $files = $this->getFiles();
        $outValues = [];

        foreach ($files as $key => $file) {
            $originRow = '';

            if ($this->value) {
                foreach ($this->value as $originValue) {
                    if ($originValue['form']['fName'] == $file) {
                        $originRow = $originValue['form'];
                    }
                }
            } else {
                $originRow = [
                    'fName' => '',
                    'fInclude' => false
                ];
            }

            foreach ($fields as $field) {
                $fieldValue = '';

                if ($field === 'fName') {
                    $fieldValue = $file;
                } elseif ($originRow && $originRow['fName'] === $file) {
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

    protected function getFiles()
    {
        $files = [];

        $templateName = \Master3Config::getTemplateName();

        $filePath = realpath(Path::clean(JPATH_ROOT . "/templates/{$templateName}/" . $this->getAttribute('folder')));

        $list = glob($filePath . DIRECTORY_SEPARATOR . '*.*');

        if (is_array($list)) {
            foreach ($list as $listItem) {
                $files[] = basename($listItem);
            }
        }

        $tmp_key = false;
        foreach ($files as $k => $file) {
            if (strpos($file, 'custom.') !== false) {
                $tmp_key = $k;
                break;
            }
        }

        if ($tmp_key !== false) {
            $tmp = $files[$tmp_key];
            unset($files[$tmp_key]);
            $files = array_values($files);
            $files[] = $tmp;
        }

        return $files;
    }
}
