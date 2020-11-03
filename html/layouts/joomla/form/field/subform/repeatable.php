<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

/**
 * Make thing clear
 * @var JForm   $tmpl             The Empty form for template
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

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

if (!$buttons['add'] && !$buttons['remove'] && !$buttons['move']) {
    $buttons = [];
}

// Add script
if ($multiple) {
    HTMLHelper::_('jquery.ui', array('core', 'sortable'));
    HTMLHelper::_('script', 'system/subform-repeatable.js', array('version' => 'auto', 'relative' => true));
}

$sublayout = empty($groupByFieldset) ? 'section' : 'section-byfieldsets';
?>

<div class="subform-repeatable-wrapper subform-layout">
    <div class="subform-repeatable"
        data-bt-add="a.group-add" data-bt-remove="a.group-remove" data-bt-move="a.group-move"
        data-repeatable-element="div.subform-repeatable-group" data-minimum="<?php echo $min; ?>" data-maximum="<?php echo $max; ?>">
        <?php if (!empty($buttons['add'])) { ?>
        <a class="uk-button uk-button-small uk-button-primary group-add btn btn-mini button btn-success" aria-label="<?php echo Text::_('JGLOBAL_FIELD_ADD'); ?>"><?php echo $jsIcons !== 'none' ? '<span data-uk-icon="icon:plus" aria-hidden="true"></span>' : Text::_('JGLOBAL_FIELD_ADD'); ?></a>
        <?php } ?>
    <?php
    foreach ($forms as $k => $form) {
        echo $this->sublayout($sublayout, array('form' => $form, 'basegroup' => $fieldname, 'group' => $fieldname . $k, 'buttons' => $buttons));
    }
    ?>
    <?php if ($multiple) { ?>
    <script type="text/subform-repeatable-template-section" class="subform-repeatable-template-section">
    <?php echo $this->sublayout($sublayout, array('form' => $tmpl, 'basegroup' => $fieldname, 'group' => $fieldname . 'X', 'buttons' => $buttons)); ?>
    </script>
    <?php } ?>
    </div>
</div>
