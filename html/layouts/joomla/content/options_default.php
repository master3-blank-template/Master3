<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\FormHelper;

?>

<fieldset class="<?php echo !empty($displayData->formclass) ? $displayData->formclass : 'form-horizontal'; ?>">
    <legend><?php echo $displayData->name; ?></legend>
    <?php if (!empty($displayData->description)) { ?>
        <p><?php echo $displayData->description; ?></p>
    <?php
    }
    $fieldsnames = explode(',', $displayData->fieldsname);
    foreach ($fieldsnames as $fieldname) {
        foreach ($displayData->form->getFieldset($fieldname) as $field) {
            $datashowon = '';
            $groupClass = $field->type === 'Spacer' ? ' field-spacer' : '';
            if ($field->showon) {
                HTMLHelper::_('jquery.framework');
                HTMLHelper::_('script', 'jui/cms.js', array('version' => 'auto', 'relative' => true));
                $datashowon = ' data-showon=\'' . json_encode(FormHelper::parseShowOnConditions($field->showon, $field->formControl, $field->group)) . '\'';
            }
            ?>
            <div class="uk-form-stacked uk-margin <?php echo $groupClass; ?>"<?php echo $datashowon; ?>>
                <?php if (!isset($displayData->showlabel) || $displayData->showlabel) { ?>
                    <div class="uk-form-label"><?php echo $field->label; ?></div>
                <?php } ?>
                <div class="uk-form-controls"><?php echo $field->input; ?></div>
            </div>
        <?php
        }
    }
    ?>
</fieldset>
