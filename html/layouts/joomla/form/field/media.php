<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
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
 * @var   string   $preview         The preview image relative path
 * @var   integer  $previewHeight   The image preview height
 * @var   integer  $previewWidth    The image preview width
 * @var   string   $asset           The asset text
 * @var   string   $authorField     The label text
 * @var   string   $folder          The folder text
 * @var   string   $link            The link text
 */
extract($displayData);

// Load the modal behavior script.
HTMLHelper::_('behavior.core');
HTMLHelper::_('behavior.modal');

// Include jQuery
HTMLHelper::_('jquery.framework');
HTMLHelper::_('script', 'media/mediafield-mootools.min.js', array('version' => 'auto', 'relative' => true, 'framework' => true));

// Tooltip for INPUT showing whole image path
$options = array(
    'onShow' => 'jMediaRefreshImgpathTip',
);

$attr = '';

$attr .= ' data-uk-tooltip="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '"';

// Initialize some field attributes.
$attr .= !empty($class) ? ' class="uk-input field-media-input ' . $class . '"' : ' class="uk-input"';
$attr .= !empty($size) ? ' size="' . $size . '"' : '';

// Initialize JavaScript field attributes.
$attr .= !empty($onchange) ? ' onchange="' . $onchange . '"' : '';

// The text field.
echo '<div class="uk-button-group uk-width">';

// The Preview.
$showPreview = true;
$showAsTooltip = false;

switch ($preview) {
    case 'no': // Deprecated parameter value
    case 'false':
    case 'none':
        $showPreview = false;
        break;

    case 'yes': // Deprecated parameter value
    case 'true':
    case 'show':
        break;

    case 'tooltip':
    default:
        $showAsTooltip = true;
        $options = ['onShow' => 'jMediaRefreshPreviewTip'];
        HTMLHelper::_('behavior.tooltip', '.hasTipPreview', $options);
        break;
}

echo '<input type="text" name="' . $name . '" id="' . $id .
    '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') .
    '" readonly="readonly"' . $attr . ' data-basepath="' . Uri::root() . '">';
?>
<a class="modal uk-button uk-button-primary" title="<?php echo Text::_('JLIB_FORM_BUTTON_SELECT'); ?>" href="<?php echo ($readonly ?: ($link ?: 'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=' . $asset . '&amp;author=' . $authorField) . '&amp;fieldid=' . $id . '&amp;folder=' . $folder); ?>" rel="{handler: \'iframe\', size: {x: 800, y: 500}}"><?php echo Text::_('JLIB_FORM_BUTTON_SELECT'); ?></a>
<a class="uk-button uk-button-default" data-uk-tooltip="<?php echo Text::_('JLIB_FORM_BUTTON_CLEAR'); ?>" href="#" onclick="jInsertFieldValue('', '<?php echo $id; ?>'); return false;"><span data-uk-close="icon:close" aria-hidden="true"></span></a>
</div>
