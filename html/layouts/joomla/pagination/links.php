<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\Registry\Registry;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$list = $displayData['list'];
$pages = $list['pages'];

$options = new Registry($displayData['options']);

$showLimitBox = $options->get('showLimitBox', true);
$showPagesLinks = $options->get('showPagesLinks', true);
$showLimitStart = $options->get('showLimitStart', true);

// Calculate to display range of pages
$currentPage = 1;
$range = 1;
$step = 5;

if (!empty($pages['pages'])) {
    foreach ($pages['pages'] as $k => $page) {
        if (!$page['active']) {
            $currentPage = $k;
        }
    }
}

if ($currentPage >= $step) {
    if ($currentPage % $step === 0) {
        $range = ceil($currentPage / $step) + 1;
    } else {
        $range = ceil($currentPage / $step);
    }
}
?>

<div class="uk-flex uk-flex-between">

    <?php if ($showLimitBox) { ?>
    <div class="limit">
        <?php echo Text::_('JGLOBAL_DISPLAY_NUM') . $list['limitfield']; ?>
    </div>
    <?php } ?>

    <?php if ($showPagesLinks && (!empty($pages))) { ?>
    <ul class="uk-pagination">
        <?php
        echo LayoutHelper::render('joomla.pagination.link', $pages['start']);
        echo LayoutHelper::render('joomla.pagination.link', $pages['previous']);

        foreach ($pages['pages'] as $k => $page) {
            $output = LayoutHelper::render('joomla.pagination.link', $page);
            if (in_array($k, range($range * $step - ($step + 1), $range * $step), true)) {
                if (($k % $step === 0 || $k === $range * $step - ($step + 1)) && $k !== $currentPage && $k !== $range * $step - $step) {
                    $output = preg_replace('#( <a.*?> ).*?( </a> )#', '$1...$2', $output);
                }
            }
            echo $output;
        }

        echo LayoutHelper::render('joomla.pagination.link', $pages['next']);
        echo LayoutHelper::render('joomla.pagination.link', $pages['end']);
        ?>
        </ul>
    <?php
    }

    if ($showLimitStart) {
    ?>
    <input type="hidden" name="<?php echo $list['prefix']; ?>limitstart" value="<?php echo $list['limitstart']; ?>">
    <?php } ?>

</div>
