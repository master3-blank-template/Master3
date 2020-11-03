<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();

if ($templateConfig->isWebP) {
    $module->content = str_replace(['.jpg"', '.jpeg"', '.png"', '.JPG"', '.JPEG"', '.PNG"'], '.webp"', $module->content);
    $module->content = str_replace(['.jpg ', '.jpeg ', '.png ', '.JPG ', '.JPEG ', '.PNG '], '.webp ', $module->content);
}

echo $module->content;
