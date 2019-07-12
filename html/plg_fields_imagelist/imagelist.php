<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Imagelist
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if ($field->value == '') {
	return;
}

$class = $fieldParams->get('image_class');

if ($class) {
	// space before, so if no class sprintf below works
	$class = ' class="' . htmlentities($class, ENT_COMPAT, 'UTF-8', true) . '"';
}

$value = (array)$field->value;
$buffer = '';
$i = 1;

foreach ($value as $path) {
	if (!$path || $path == '-1') {
		continue;
	}

	if ($fieldParams->get('directory', '/') !== '/') {
		$buffer .= sprintf(
			'<img data-src="images/%s/%s"%s%s data-uk-img>',
			$fieldParams->get('directory'),
			htmlentities($path, ENT_COMPAT, 'UTF-8', true),
			$class,
			' alt="' . $field->label . ' – ' . $i . '"'
		);
	} else {
		$buffer .= sprintf(
			'<img data-src="images/%s"%s%s data-uk-img>',
			htmlentities($path, ENT_COMPAT, 'UTF-8', true),
			$class,
			' alt="' . $field->label . ' – ' . $i . '"'
		);
	}

	$i++;
}

echo $buffer;
