<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/**
 * Make thing clear
 * @var JForm   $form       The form instance for render the section
 * @var string  $basegroup  The base group name
 * @var string  $group      Current group name
 * @var array   $buttons    Array of the buttons that will be rendered
 */
extract($displayData);

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

?>

<tr class="subform-repeatable-group" data-base-name="<?php echo $basegroup; ?>" data-group="<?php echo $group; ?>">
    <?php foreach ($form->getFieldsets() as $fieldset) { ?>
    <td class="<?php if (!empty($fieldset->class)) { echo $fieldset->class; } ?>">
        <?php
        foreach ($form->getFieldset($fieldset->name) as $field) {
            if (strtolower($field->type) === 'checkbox') {
        ?>
        <div class="uk-form-stacked uk-margin">
            <label for="<?php echo $field->fieldname; ?>"<?php if (!empty($field->classes)) echo ' class="uk-form-label"'; ?>>
                <input
                    type="<?php echo $field->type; ?>"
                    name="<?php echo $field->name; ?>"
                    id="<?php echo $field->fieldname; ?>"
                    class="uk-<?php echo strtolower($field->type); ?>"
                    <?php echo !$field->checked ? : ' checked="true"'; ?>
                >
                <?php
                echo strip_tags($field->label);
                if ($field->required) {
                    ?>
                <span class="uk-text-danger">&#160;*</span>
                <?php
            } ?>
            </label>
        </div>
        <?php
            } elseif (in_array(strtolower($field->type), ['list'])) {
                $form->setFieldAttribute($field->fieldname, 'class', 'uk-select', $field->group ? $field->group : null);
                echo $form->renderField($field->fieldname, $field->group ? $field->group : null);
            } else {
                echo $field->renderField();
            }
        }
        ?>
    </td>
    <?php } ?>
    <?php if (!empty($buttons)) { ?>
    <td>
        <div class="uk-button-group">
            <?php if ($jsIcons !== 'none') { ?>
                <?php if (!empty($buttons['add'])) { ?><a class="uk-button uk-button-small uk-button-primary group-add btn btn-mini button btn-success" data-uk-tooltip="<?php echo Text::_('JGLOBAL_FIELD_ADD'); ?>"><span data-uk-icon="icon:plus" aria-hidden="true"></span></a><?php } ?>
                <?php if (!empty($buttons['remove'])) { ?><a class="uk-button uk-button-small uk-button-danger group-remove btn btn-mini button btn-danger" data-uk-tooltip="<?php echo Text::_('JGLOBAL_FIELD_REMOVE'); ?>"><span data-uk-icon="icon:minus" aria-hidden="true"></span></a><?php } ?>
                <?php if (!empty($buttons['move'])) { ?><a class="uk-button uk-button-small uk-button-secondary group-move btn btn-mini button btn-primary" data-uk-tooltip="<?php echo Text::_('JGLOBAL_FIELD_MOVE'); ?>"><span data-uk-icon="icon:move" aria-hidden="true"></span></a><?php } ?>
            <?php } else { ?>
                <?php if (!empty($buttons['add'])) { ?><a class="uk-button uk-button-small uk-button-primary group-add btn btn-mini button btn-success"><?php echo Text::_('JGLOBAL_FIELD_ADD'); ?></a><?php } ?>
                <?php if (!empty($buttons['remove'])) { ?><a class="uk-button uk-button-small uk-button-danger group-remove btn btn-mini button btn-danger"><?php echo Text::_('JGLOBAL_FIELD_REMOVE'); ?></a><?php } ?>
                <?php if (!empty($buttons['move'])) { ?><a class="uk-button uk-button-small uk-button-secondary group-move btn btn-mini button btn-primary"><?php echo Text::_('JGLOBAL_FIELD_MOVE'); ?></a><?php } ?>
            <?php } ?>
        </div>
    </td>
    <?php } ?>
</tr>
