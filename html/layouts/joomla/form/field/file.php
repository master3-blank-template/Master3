<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Utility\Utility;

extract($displayData);
/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $hint            Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 * @var   array    $inputType       Options available for this field.
 * @var   array    $spellcheck      Options available for this field.
 * @var   string   $accept          File types that are accepted.
 */

// Including fallback code for HTML5 non supported browsers.
HTMLHelper::_('jquery.framework');
HTMLHelper::_('script', 'system/html5fallback.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

$maxSize = Text::sprintf('JGLOBAL_MAXIMUM_UPLOAD_SIZE_LIMIT', HTMLHelper::_('number.bytes', Utility::getMaxUploadSize()));
$hint = isset($hint) && $hint ? $hint . ', ' . $maxSize : $maxSize;
?>
<div class="uk-button-group uk-width" data-uk-form-custom>
    <input type="file" name="<?php echo $name; ?>" id="<?php echo $id; ?>" <?php
        echo !empty($size) ? ' size="' . $size . '"' : '';
        echo !empty($accept) ? ' accept="' . $accept . '"' : '';
        echo !empty($class) ? ' class="' . $class . '"' : '';
        echo !empty($multiple) ? ' multiple' : '';
        echo $disabled ? ' disabled' : '';
        echo $autofocus ? ' autofocus' : '';
        echo !empty($onchange) ? ' onchange="' . $onchange . '"' : '';
        echo $required ? ' required aria-required="true"' : ''; ?>
    >
    <input class="uk-input uk-form-width-medium" type="text" placeholder="<?php echo htmlspecialchars($hint, ENT_COMPAT, 'UTF-8'); ?>" disabled>
</div>
