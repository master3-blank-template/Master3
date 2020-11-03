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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Plugin\PluginHelper;

?>
<div class="login<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php
    }

    if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') {
    ?>
    <div class="uk-margin login-description">
    <?php
    if ($this->params->get('logindescription_show') == 1) {
        echo $this->params->get('login_description');
    }

    if ($this->params->get('login_image') != '') {
        ?>
        <img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo Text::_('COM_USERS_LOGIN_IMAGE_ALT'); ?>" loading="lazy">
        <?php } ?>
    </div>
    <?php } ?>

    <form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate form-horizontal well">
        <?php
        foreach ($this->form->getFieldset('credentials') as $field) {
            if (!$field->hidden) {
        ?>
        <div class="uk-margin-top">
            <?php
            $this->form->setFieldAttribute($field->fieldname, 'hint', html_entity_decode(trim(strip_tags($field->label))));
            echo $this->form->getField($field->fieldname)->input;
            ?>
        </div>
        <?php
        }
    }

    if ($this->tfa) {
    ?>
        <div class="uk-margin-top">
            <?php
            $this->form->setFieldAttribute('secretkey', 'hint', html_entity_decode(trim(strip_tags($this->form->getField('secretkey')->label))));
            echo $this->form->getField('secretkey')->input;
            ?>
        </div>
        <?php
        }

        if (PluginHelper::isEnabled('system', 'remember')) {
        ?>
        <div class="uk-margin-top">
            <input id="remember" type="checkbox" name="remember" class="uk-checkbox" value="yes">
            <label for="remember" class="uk-form-label"><?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME'); ?></label>
        </div>
        <?php } ?>

        <div class="uk-margin-top">
            <button type="submit" class="uk-button uk-button-primary"><?php echo Text::_('JLOGIN'); ?></button>
        </div>

        <?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
        <input type="hidden" name="return" value="<?php echo base64_encode($return); ?>">
        <?php echo HTMLHelper::_('form.token'); ?>

    </form>
</div>

<ul class="uk-list uk-margin-top">

    <li>
        <a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>"><?php echo Text::_('COM_USERS_LOGIN_RESET'); ?></a>
    </li>

    <li>
        <a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>"><?php echo Text::_('COM_USERS_LOGIN_REMIND'); ?></a>
    </li>

    <?php
    $usersConfig = ComponentHelper::getParams('com_users');
    if ($usersConfig->get('allowUserRegistration')) {
    ?>
    <li>
        <a href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>"><?php echo Text::_('COM_USERS_LOGIN_REGISTER'); ?></a>
    </li>
    <?php } ?>

</ul>
