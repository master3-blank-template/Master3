<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('behavior.tabstate');

/**
 * Make thing clear
 *
 * @var Form    $tmpl             The Empty form for template
 * @var array   $forms            Array of JForm instances for render the rows
 * @var bool    $multiple         The multiple state for the form field
 * @var int     $min              Count of minimum repeating in multiple mode
 * @var int     $max              Count of maximum repeating in multiple mode
 * @var string  $fieldname        The field name
 * @var string  $control          The forms control
 * @var string  $label            The field label
 * @var string  $description      The field description
 * @var array   $buttons          Array of the buttons that will be rendered
 * @var bool    $groupByFieldset  Whether group the subform fields by it`s fieldset
 */

extract($displayData);

HTMLHelper::_('stylesheet', 'system/subform-tabs.css', ['version' => 'auto', 'relative' => true]);

if (!$forms) {
	echo '<div class="alert alert-warning uk-alert uk-alert-warning">Subform elements not found.</div>';
} else {
	$fieldset = $forms[0]->getFieldset('');
	$keyField = array_shift($fieldset);

	$uid = uniqid() . '-' . $fieldname;

	$tab_name = 'subform-tabset-' . $uid;

	$out = [];

	$out[] = '<div class="subform-tabs tabs-left">';

	$out[] = '<ul class="nav nav-tabs" id="' . $tab_name . 'Tabs">';

	$class = ' class="active"';
	foreach ($forms as $k => $form) {
		$out[] = '<li' . $class . '><a href="#subform-tab-' . $uid . '-' . $keyField->fieldname . '-' . $k . '" data-toggle="tab">' . $form->getValue($keyField->fieldname, $keyField->group ? $keyField->group : null) . '</a></li>';
		$class = '';
	}
	$out[] = '</ul>';

	$out[] = '<div class="tab-content" id="' . $tab_name . 'Content">';
	$class = ' active';
	foreach ($forms as $k => $form) {
		$out[] = '<div id="subform-tab-' . $uid . '-' . $keyField->fieldname . '-' . $k . '" class="tab-pane' . $class . '">';
		$class = '';
		$out[] = $this->sublayout('section', array('form' => $form, 'basegroup' => $fieldname, 'group' => $fieldname . $k, 'buttons' => $buttons));
		$out[] = '</div>';
	}
	$out[] = '</div>';

	$out[] = '</div>';

	echo implode('', $out);
	unset($out);
}