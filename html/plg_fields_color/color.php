<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Color
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$value = $field->value;

if ($value == '') {
	return;
}

if (is_array($value)) {
	$value = htmlentities(implode(', ', $value));
}

echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="20" height="20"><circle fill="' . $value . '" cx="10" cy="10" r="10"/></svg>&nbsp;' . $value;
