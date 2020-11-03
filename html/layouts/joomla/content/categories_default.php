<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;

if ($displayData->params->get('show_page_heading')) {
    ?>
<h2><?php echo $displayData->escape($displayData->params->get('page_heading')); ?></h2>
<?php

}

if ($displayData->params->get('show_base_description')) {
    // If there is a description in the menu parameters use that;
    if ($displayData->params->get('categories_description')) {
    ?>
    <div class="category-desc base-desc">
        <?php echo HTMLHelper::_('content.prepare', $displayData->params->get('categories_description'), '', $displayData->get('extension') . '.categories'); ?>
    </div>
    <?php
    } else {
        // Otherwise get one from the database if it exists.
        if ($displayData->parent->description) {
        ?>
        <div class="category-desc base-desc">
            <?php echo HTMLHelper::_('content.prepare', $displayData->parent->description, '', $displayData->parent->extension . '.categories'); ?>
        </div>
        <?php
        }
    }
}
