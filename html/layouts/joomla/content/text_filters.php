<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
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
            echo '<div>' . $field->input . '</div>';
        }
    }
    ?>
</fieldset>
