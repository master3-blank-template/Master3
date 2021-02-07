<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.pagenavigation
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

$lang = Factory::getLanguage(); ?>

<div class="uk-flex uk-flex-between uk-margin">

    <?php if ($row->prev) { ?>
    <div>
        <a class="uk-button uk-button-link uk-flex uk-flex-middle" data-uk-tooltip="<?php echo htmlspecialchars($rows[$location - 1]->title); ?>" aria-label="<?php echo JText::sprintf('JPREVIOUS_TITLE', htmlspecialchars($rows[$location - 1]->title)); ?>" href="<?php echo $row->prev; ?>" rel="prev">
            <?php if ($jsIcons !== 'none') { ?>
            <span data-uk-icon="icon:chevron-left" aria-hidden="true"></span>
            <?php } ?>
            <span aria-hidden="true"><?php echo $row->prev_label; ?></span>
        </a>
    </div>
    <?php } ?>

    <?php if ($row->next) { ?>
    <div class="uk-flex uk-flex-1 uk-flex-right">
        <a class="uk-button uk-button-link uk-flex uk-flex-middle" data-uk-tooltip="<?php echo htmlspecialchars($rows[$location + 1]->title); ?>" aria-label="<?php echo JText::sprintf('JNEXT_TITLE', htmlspecialchars($rows[$location + 1]->title)); ?>" href="<?php echo $row->next; ?>" rel="next">
            <span aria-hidden="true"><?php echo $row->next_label; ?></span>
            <?php if ($jsIcons !== 'none') { ?>
            <span data-uk-icon="icon:chevron-right" aria-hidden="true"></span>
            <?php } ?>
        </a>
    </div>
    <?php } ?>
</div>
