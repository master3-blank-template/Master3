<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$denyUserAuthorization = $templateConfig->getDUA();

if (!$denyUserAuthorization) {

    $cookieLogin = $this->user->get('cookieLogin');

    if (!empty($cookieLogin) || $this->user->get('guest')) {
        // The user is not logged in or needs to provide a password.
        echo $this->loadTemplate('login');
    } else {
        // The user is already logged in.
        echo $this->loadTemplate('logout');
    }

}
