<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
HTMLHelper::register('users.spacer', ['HTMLHelperUsers', 'spacer']);

$fieldsets = $this->form->getFieldsets();

if (isset($fieldsets['core'])) {
    unset($fieldsets['core']);
}

if (isset($fieldsets['params'])) {
    unset($fieldsets['params']);
}

$tmp = isset($this->data->jcfields) ? $this->data->jcfields : [];
$customFields = [];

foreach ($tmp as $customField) {
    $customFields[$customField->name] = $customField;
}

foreach ($fieldsets as $group => $fieldset) {
    $fields = $this->form->getFieldset($group);
    if (count($fields)) {
        if (isset($fieldset->label) && ($legend = trim(Text::_($fieldset->label))) !== '') {
?>
<legend class="uk-h4 uk-text-primary"><?php echo $legend; ?></legend>
<?php
        }

        if (isset($fieldset->description) && trim($fieldset->description)) {
?>
<p><?php echo $this->escape(Text::_($fieldset->description)); ?></p>
<?php
        }
?>
<dl class="uk-description-list">
    <?php
    foreach ($fields as $field) {
        if (!$field->hidden && $field->type !== 'Spacer') {
            ?>
    <dt><?php echo $field->title; ?></dt>
    <dd>
        <?php
            if (key_exists($field->fieldname, $customFields)) {
                echo strlen($customFields[$field->fieldname]->value) ? $customFields[$field->fieldname]->value : Text::_('COM_USERS_PROFILE_VALUE_NOT_FOUND');
            } elseif (HTMLHelper::isRegistered('users.' . $field->id)) {
                echo HTMLHelper::_('users.' . $field->id, $field->value);
            } elseif (HTMLHelper::isRegistered('users.' . $field->fieldname)) {
                echo HTMLHelper::_('users.' . $field->fieldname, $field->value);
            } elseif (HTMLHelper::isRegistered('users.' . $field->type)) {
                echo HTMLHelper::_('users.' . $field->type, $field->value);
            } else {
                echo HTMLHelper::_('users.value', $field->value);
            }
        ?>
    </dd>
    <?php

        }
    }
    ?>
</dl>
<hr>
<?php
    }
}
