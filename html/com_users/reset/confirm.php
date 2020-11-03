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
<div class="reset-confirm<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php } ?>

    <form action="<?php echo Route::_('index.php?option=com_users&task=reset.confirm'); ?>" method="post" class="form-validate form-horizontal well">
        <?php
        foreach ($this->form->getFieldsets() as $fieldset) {
            $fields = $this->form->getFieldset($fieldset->name);
            if (count($fields)) {
                if (isset($fieldset->label)) {
                ?>
                <p><?php echo Text::_($fieldset->label); ?></p>
                <?php
                }

                foreach ($fields as $field) {
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
            }
        }
        ?>

        <hr class="uk-margin-medium">

        <div>
            <button type="submit" class="uk-button uk-button-primary validate"><?php echo Text::_('JSUBMIT'); ?></button>
        </div>

        <?php echo HTMLHelper::_('form.token'); ?>

    </form>
</div>
<?php
}
