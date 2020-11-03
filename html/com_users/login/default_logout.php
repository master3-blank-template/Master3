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

?>
<div class="logout<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php

}

if (($this->params->get('logoutdescription_show') == 1 && str_replace(' ', '', $this->params->get('logout_description')) != '') || $this->params->get('logout_image') != '') {
?>
    <div class="uk-margin logout-description">

        <?php
        if ($this->params->get('logoutdescription_show') == 1) {
            echo $this->params->get('logout_description');
        }

        if ($this->params->get('logout_image') != '') {
        ?>
        <img src="<?php echo $this->escape($this->params->get('logout_image')); ?>" class="thumbnail pull-right logout-image" alt="<?php echo Text::_('COM_USER_LOGOUT_IMAGE_ALT'); ?>" loading="lazy">
        <?php } ?>

    </div>
    <?php } ?>

    <form action="<?php echo Route::_('index.php?option=com_users&task=user.logout'); ?>" method="post" class="uk-margin-top">
        <button type="submit" class="uk-button uk-button-primary"><?php echo Text::_('JLOGOUT'); ?></button>

        <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get($this->params->get('logout_redirect_url') ? 'logout_redirect_url' : 'logout_redirect_menuitem', $this->form->getValue('return'))); ?>">

        <?php echo HTMLHelper::_('form.token'); ?>
    </form>
</div>
