<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Plugin\PluginHelper;

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$denyUserAuthorization = $templateConfig->getDUA();

if (!$denyUserAuthorization) {
?>

<form action="<?php echo Route::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form">

    <?php if ($params->get('pretext')) { ?>
    <div class="uk-margin-bottom">
        <p><?php echo $params->get('pretext'); ?></p>
    </div>
    <?php } ?>

    <div>
        <input id="modlgn-username" type="text" name="username" class="uk-input" placeholder="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?> *" required>
    </div>

    <div class="uk-margin-top">
        <input id="modlgn-passwd" type="password" name="password" class="uk-input" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?> *" required>
    </div>

    <?php if (count($twofactormethods) > 1) { ?>
    <div class="uk-margin-top">
        <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="uk-input" placeholder="<?php echo Text::_('JGLOBAL_SECRETKEY'); ?> *" data-uk-tooltip="<?php echo Text::_('JGLOBAL_SECRETKEY_HELP'); ?>" required>
    </div>
    <?php } ?>

    <?php if (PluginHelper::isEnabled('system', 'remember')) { ?>
    <div class="uk-margin-top">
        <input id="modlgn-remember" type="checkbox" name="remember" class="uk-checkbox" value="yes">
        <label for="modlgn-remember" class="uk-form-label"><?php echo Text::_('MOD_LOGIN_REMEMBER_ME'); ?></label>
    </div>
    <?php } ?>

    <div class="uk-margin-top">
        <button type="submit" name="Submit" class="uk-button uk-button-primary"><?php echo Text::_('JLOGIN'); ?></button>
    </div>

    <?php $usersConfig = ComponentHelper::getParams('com_users'); ?>
    <ul class="uk-list uk-margin-top">

        <?php if ($usersConfig->get('allowUserRegistration')) { ?>
        <li>
            <a href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>">
                <?php echo Text::_('MOD_LOGIN_REGISTER'); ?> <span class="icon-arrow-right"></span>
            </a>
        </li>
        <?php } ?>

        <li>
            <a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
                <?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?>
            </a>
        </li>

        <li>
            <a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
                <?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?>
            </a>
        </li>

    </ul>

    <input type="hidden" name="option" value="com_users">
    <input type="hidden" name="task" value="user.login">
    <input type="hidden" name="return" value="<?php echo $return; ?>">
    <?php echo HTMLHelper::_('form.token'); ?>

    <?php if ($params->get('posttext')) { ?>
    <div class="uk-margin-top">
        <p><?php echo $params->get('posttext'); ?></p>
    </div>
    <?php } ?>

</form>

<?php
}
