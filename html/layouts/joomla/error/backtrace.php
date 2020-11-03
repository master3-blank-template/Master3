<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

/** @var $displayData array */
$backtraceList = $displayData['backtrace'];

if (!$backtraceList) {
    return;
}

$class = isset($displayData['class']) ? $displayData['class'] : 'uk-table uk-table-divider uk-table-striped  uk-table-responsive';
?>
<table cellpadding="0" cellspacing="0" class="Table <?php echo $class ?>">
    <tr>
        <td colspan="3" class="TD">
            <strong>Call stack</strong>
        </td>
    </tr>

    <tr>
        <td class="TD">
            <strong>#</strong>
        </td>
        <td class="TD">
            <strong>Function</strong>
        </td>
        <td class="TD">
            <strong>Location</strong>
        </td>
    </tr>

    <?php foreach ($backtraceList as $k => $backtrace) { ?>
    <tr>
        <td class="TD">
            <?php echo $k + 1; ?>
        </td>

        <?php if (isset($backtrace['class'])) { ?>
        <td class="TD">
            <?php echo $backtrace['class'] . $backtrace['type'] . $backtrace['function'] . '()'; ?>
        </td>
        <?php } else { ?>
        <td class="TD">
            <?php echo $backtrace['function'] . '()'; ?>
        </td>
        <?php } ?>

        <?php if (isset($backtrace['file'])) { ?>
        <td class="TD">
            <?php echo HTMLHelper::_('debug.xdebuglink', $backtrace['file'], $backtrace['line']); ?>
        </td>
        <?php } else { ?>
        <td class="TD">
            &#160;
        </td>
        <?php } ?>
    </tr>
        <?php } ?>
</table>
