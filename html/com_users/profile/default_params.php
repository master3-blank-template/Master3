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

$fields = $this->form->getFieldset('params');
if (count($fields)) {
?>
<legend class="uk-h4 uk-text-primary"><?php echo Text::_('COM_USERS_SETTINGS_FIELDSET_LABEL'); ?></legend>

<dl class="uk-description-list">
    <?php
    foreach ($fields as $field) {
        if (!$field->hidden) {
            ?>
        <dt><?php echo $field->title; ?></dt>
        <dd>
            <?php
            if (HTMLHelper::isRegistered('users.' . $field->id)) {
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
<?php
}
