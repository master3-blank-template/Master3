<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

?>
<div class="contact-form">
    <form id="contact-form" action="<?php echo Route::_('index.php'); ?>" method="post" class="form-validate form-horizontal well">
        <?php
        foreach ($this->form->getFieldsets() as $fieldset) {
            if ($fieldset->name === 'captcha' && !$this->captchaEnabled) {
                continue;
            }
            $fields = $this->form->getFieldset($fieldset->name);
            if (count($fields)) {
                if (isset($fieldset->label) && ($legend = trim(Text::_($fieldset->label))) !== '') {
            ?>
            <legend class="uk-h5 uk-text-bold"><?php echo $legend; ?></legend>
            <?php
                }
                foreach ($fields as $field) {
                ?>
                    <div class="uk-margin">
                    <?php
                    $this->form->setFieldAttribute($field->fieldname, 'hint', html_entity_decode(trim(strip_tags($field->label))), $field->group);
                    echo $this->form->getField($field->fieldname, $field->group)->input;
                    ?>
                    </div>
                    <?php
                }
            }
        } ?>
        <div class="uk-margin-top">
            <button class="uk-button uk-button-primary validate" type="submit"><?php echo Text::_('COM_CONTACT_CONTACT_SEND'); ?></button>
            <input type="hidden" name="option" value="com_contact">
            <input type="hidden" name="task" value="contact.submit">
            <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
            <input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>">
            <?php echo HTMLHelper::_('form.token'); ?>
        </div>
    </form>
</div>
