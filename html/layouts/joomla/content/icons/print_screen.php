<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');

$templateConfig = \Master3Config::getInstance();

$jsIcons = $templateConfig->params->get('jsIcons', 'none');

echo ($jsIcons !== 'none' ? '<span data-uk-icon="icon:print" data-uk-tooltip="' . trim(Text::_('JGLOBAL_PRINT')) . '"></span>' : trim(Text::_('JGLOBAL_PRINT')));
