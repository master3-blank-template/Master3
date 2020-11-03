<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$type = $templateConfig->params->get('systemmsg', 'alert');

$msgList = $displayData['msgList'];

echo '<div id="system-message-container">';
include realpath(__DIR__ . ($type == 'alert' ? '/message_alert.php' : '/message_notification.php'));
echo '</div>';
