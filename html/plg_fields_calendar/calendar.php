<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Calendar
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$value = $field->value;

if ($value == '') {
	return;
}

if (is_array($value)) {
	$value = implode(', ', $value);
}

$formatString = $field->fieldparams->get('showtime', 0) ? 'd.m.Y H:i' : 'd.m.Y';

echo htmlentities(HTMLHelper::_('date', $value, Text::_($formatString)));
