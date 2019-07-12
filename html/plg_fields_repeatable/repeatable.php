<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Repeatable
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$tmpFields = $field->fieldparams->get('fields');
$aFields = [];
foreach ($tmpFields as $tmpField) {
	$aFields[$tmpField->fieldname] = $tmpField->fieldtype;
}

$fieldValue = $field->value;

if ($fieldValue === '') {
	return;
}

// Get the values
$fieldValues = json_decode($fieldValue, true);

if (empty($fieldValues)) {
	return;
}

$html = '<ul class="uk-list">';

foreach ($fieldValues as $value) {
	foreach ($value as $vKey => $vValue) {
		if ($vValue === '') {
			unset($value[$vKey]);
		}
		if ($aFields[$vKey] === 'media' & $vValue !== '') {
			$value[$vKey] = '<span class="uk-icon uk-icon-image" style="background-image:url(\'/' . $vValue . '\');"></span>';
		}
	}
	$html .= '<li>' . implode(', ', $value) . '</li>';
}

$html .= '</ul>';

echo $html;
