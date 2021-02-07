<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
/** @var PaginationObject $item */
$item = $displayData['data'];

$display = $item->text;

switch (( string )$item->text) {
    // Check for "Prev" item
    case $item->text === Text::_('JPREV'):
        $liClass = '';
        $item->text = Text::_('JPREVIOUS');
        $icon = '<span data-uk-pagination-previous></span>';
        break;

    // Check for "Next" item
    case Text::_('JNEXT'):
        $liClass = ' uk-flex uk-flex-1 uk-flex-right';
        $icon = '<span data-uk-pagination-next></span>';
        break;

    default:
        $icon = null;
        break;
}

if ($icon !== null) {
    $display = $icon;
}

$cssClasses = [];
if ($displayData['active']) {
    if ($item->base > 0) {
        $limit = 'limitstart.value=' . $item->base;
    } else {
        $limit = 'limitstart.value=0';
    }

    $title = '';

    if (!is_numeric($item->text)) {
        $title = ' data-uk-tooltip="' . $item->text . '" aria-label="' . $item->text . '"';
    }

    $onClick = 'document.adminForm.' . $item->prefix . 'limitstart.value=' . ($item->base > 0 ? $item->base : '0') . '; Joomla.submitform();return false;';
    $class = $liClass;
} else {
    $class = (property_exists($item, 'active') && $item->active) ? 'uk-active' : 'uk-disabled';
    $class .= $liClass;
}
if ($displayData['active']) {
?>
    <li class="<?php echo trim($class); ?>">
        <a<?php echo $cssClasses ? ' class="' . implode(' ', $cssClasses) . '"' : ''; ?> <?php echo $title; ?> href="#" onclick="<?php echo $onClick; ?>"><?php echo $display; ?></a>
    </li>
<?php } else { ?>
    <li class="<?php echo trim($class); ?>">
        <span><?php echo $display; ?></span>
    </li>
<?php }
