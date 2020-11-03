<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
<div class="profile<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php
    }

    if (Factory::getUser()->id == $this->data->id) {
    ?>
    <div class="uk-margin">
        <a class="uk-button uk-button-link" href="<?php echo Route::_('index.php?option=com_users&task=profile.edit&user_id=' . (int)$this->data->id); ?>"><?php echo Text::_('COM_USERS_EDIT_PROFILE'); ?></a>
    </div>
    <?php
    }


    $fieldsets = $this->form->getFieldsets();

    if (isset($fieldsets['core'])) {
        unset($fieldsets['core']);
    }

    if (isset($fieldsets['params'])) {
        unset($fieldsets['params']);
    }
    ?>

    <ul data-uk-tab="connect:#com-users-profile-content">
        <li><a href="#"><?php echo Text::_('COM_USERS_PROFILE_CORE_LEGEND'); ?></a></li>
        <li><a href="#"><?php echo Text::_('COM_USERS_SETTINGS_FIELDSET_LABEL'); ?></a></li>
        <?php if ($fieldsets) { ?>
        <li><a href="#"><?php echo Text::_('JOPTIONS'); ?></a></li>
        <?php } ?>
    </ul>

    <ul id="com-users-profile-content" class="uk-margin uk-switcher">
        <li><?php echo $this->loadTemplate('core'); ?></li>
        <li><?php echo $this->loadTemplate('params'); ?></li>
        <?php if ($fieldsets) { ?>
        <li><?php echo $this->loadTemplate('custom'); ?></li>
        <?php } ?>
    </ul>
</div>
