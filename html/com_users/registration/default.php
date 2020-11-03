<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$denyUserAuthorization = $templateConfig->getDUA();

if (!$denyUserAuthorization) {
    ?>
<div class="registration<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php } ?>

    <form id="member-registration" action="<?php echo Route::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">

        <ul data-uk-tab="connect:#com-users-registration-content">
            <?php
            foreach ($this->form->getFieldsets() as $fieldset) {
                if (count($this->form->getFieldset($fieldset->name))) {
                    ?>
            <li><a href="#"><?php echo Text::_($fieldset->label); ?></a></li>
            <?php
                }
            }
            ?>
        </ul>

        <ul id="com-users-registration-content" class="uk-margin uk-switcher">
            <?php
            // Iterate through the form fieldsets and display each one.
            foreach ($this->form->getFieldsets() as $fieldset) {
                $fields = $this->form->getFieldset($fieldset->name);
                if (count($fields)) {
            ?>
            <li>
                <?php
                    // If the fieldset has a label set, display it as the legend.
                    if (isset($fieldset->label)) {
                    ?>
                    <legend class="uk-h4 uk-text-primary"><?php echo Text::_($fieldset->label); ?></legend>
                    <?php
                    }

                    // Iterate through the fields in the set and display them.
                    foreach ($fields as $field) {
                        // If the field is hidden, just display the input.
                        if ($field->hidden) {
                            echo $field->input;
                        } else {
                        ?>
                    <div class="uk-margin-top">
                        <?php
                        if (in_array(strtolower($field->type), ['list', 'language'])) {
                            $this->form->setFieldAttribute($field->fieldname, 'class', 'uk-select', $field->group ? $field->group : null);
                            echo $this->form->getField($field->fieldname, $field->group ? $field->group : null)->input;
                        } else {
                            $this->form->setFieldAttribute($field->fieldname, 'hint', html_entity_decode(trim(strip_tags($field->label))), $field->group ? $field->group : null);
                            echo $this->form->getField($field->fieldname, $field->group ? $field->group : null)->input;
                        }
                        ?>
                    </div>
                    <?php
                        }
                    }
                ?>
            </li>
            <?php
                }
            }
            ?>
        </ul>

        <hr class="uk-margin-medium">

        <div class="uk-flex">
            <button type="submit" class="uk-button uk-button-primary uk-margin-small-right validate"><?php echo Text::_('JREGISTER'); ?></button>
            <a class="uk-button uk-button-default" href="<?php echo Route::_(''); ?>" title="<?php echo Text::_('JCANCEL'); ?>"><?php echo Text::_('JCANCEL'); ?></a>
        </div>

        <input type="hidden" name="option" value="com_users">
        <input type="hidden" name="task" value="registration.register">
        <?php echo HTMLHelper::_('form.token'); ?>

    </form>
</div>
<?php
}
