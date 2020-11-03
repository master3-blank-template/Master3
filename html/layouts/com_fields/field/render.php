<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_fields
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

if (!key_exists('field', $displayData)) {
    return;
}

$field = $displayData['field'];
$label = Text::_($field->label);
$value = $field->value;
$showLabel = $field->params->get('showlabel');
$class = $displayData['class'];

if ($value == '') {
    return;
}

?>
<dt class="field-entry <?php echo $class; ?>">
    <?php if ($showLabel == 1) { ?>
    <span class="field-label"><?php echo htmlentities($label, ENT_QUOTES | ENT_IGNORE, 'UTF-8'); ?>: </span>
    <?php } ?>
</dt>
<dd class="field-entry <?php echo $class; ?>">
    <span class="field-value"><?php echo $value; ?></span>
</dd>
