<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

?>
<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
    <?php if ($this->params->get('filter_field') || $this->params->get('show_pagination_limit')) { ?>
    <div class="uk-margin-medium-bottom data-uk-grid" data-uk-grid>
        <?php if ($this->params->get('filter_field')) { ?>
        <div>
            <input
                type="text"
                name="filter-search"
                id="filter-search"
                value="<?php echo $this->escape($this->state->get('list.filter')); ?>"
                class="uk-input uk-form-width-small"
                onchange="document.adminForm.submit();"
                placeholder="<?php echo Text::_('COM_CONTACT_FILTER_SEARCH_DESC'); ?>"
            >
        </div>
        <?php
        }
        if ($this->params->get('show_pagination_limit')) {
            ?>
            <div>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
            <?php

        }
    }

    if (empty($this->items)) {
    ?>
    <div class="uk-alert"><?php echo Text::_('COM_CONTACT_NO_CONTACTS'); ?></div>
    <?php } else { ?>
    <ul class="uk-list">
        <?php
        foreach ($this->items as $i => $item) {
            if (in_array($item->access, $this->user->getAuthorisedViewLevels())) {
                if ($this->items[$i]->published == 0) {
        ?>
        <li class="uk-disabled uk-text-muted">
        <?php } else { ?>
        <li>
        <?php } ?>
            <div class="uk-grid-small" data-uk-grid>
                <?php if ($this->params->get('show_image_heading')) { ?>
                <div class="uk-width-auto@s">
                    <?php if ($this->items[$i]->image) { ?>
                    <a href="<?php echo Route::_(ContactHelperRoute::getContactRoute($item->slug, $item->catid)); ?>">
                        <?php echo Route::_('image', $this->items[$i]->image, Text::_('COM_CONTACT_IMAGE_DETAILS'), ['class' => 'contact-thumbnail img-thumbnail']); ?>
                    </a>
                    <?php } ?>
                </div>
                <?php } ?>

                <div class="uk-width-expand">
                    <a href="<?php echo Route::_(ContactHelperRoute::getContactRoute($item->slug, $item->catid)); ?>"><?php echo $item->name; ?></a>

                    <?php if ($this->items[$i]->published == 0) { ?>
                    <span class="uk-text--warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
                    <?php
                    }

                    echo $item->event->afterDisplayTitle;
                    echo $item->event->beforeDisplayContent;
                    ?>
                    <ul class="uk-list uk-margin-small-top">

                    <?php if ($this->params->get('show_position_headings')) { ?>
                        <li><?php echo ($jsIcons !== 'none' ? '<span class="uk-margin-small-right" data-uk-icon="icon:cog" data-uk-tooltip="' . Text::_('COM_CONTACT_POSITION') . '"></span>' : Text::_('COM_CONTACT_POSITION') . ': '), $item->con_position; ?></li>
                        <?php } ?>

                        <?php if ($this->params->get('show_email_headings')) { ?>
                        <li><?php echo ($jsIcons !== 'none' ? '<span class="uk-margin-small-right" data-uk-icon="icon:main" data-uk-tooltip="' . Text::_('COM_CONTACT_EMAIL_LABEL') . '"></span>' : Text::_('COM_CONTACT_EMAIL_LABEL') . ': '), $item->email_to; ?></li>
                        <?php } ?>

                        <?php
                        $location = [];
                        if ($this->params->get('show_suburb_headings') && !empty($item->suburb)) {
                            $location[] = $item->suburb;
                        }
                        if ($this->params->get('show_state_headings') && !empty($item->state)) {
                            $location[] = $item->state;
                        }
                        if ($this->params->get('show_country_headings') && !empty($item->country)) {
                            $location[] = $item->country;
                        }
                        ?>
                        <li><?php echo ($jsIcons !== 'none' ? '<span class="uk-margin-small-right" data-uk-icon="icon:location" data-uk-tooltip="' . Text::_('COM_CONTACT_ADDRESS') . '"></span>' : Text::_('COM_CONTACT_ADDRESS') . ': '), implode(', ', $location); ?></li>

                        <?php if ($this->params->get('show_telephone_headings') && !empty($item->telephone)) { ?>
                        <li><?php echo ($jsIcons !== 'none' ? '<span class="uk-margin-small-right" data-uk-icon="icon:receiver" data-uk-tooltip="' . Text::_('COM_CONTACT_TELEPHONE') . '"></span>' : ''), Text::sprintf('COM_CONTACT_TELEPHONE_NUMBER', $item->telephone); ?></li>
                        <?php } ?>

                        <?php if ($this->params->get('show_fax_headings') && !empty($item->fax)) { ?>
                        <li><?php echo ($jsIcons !== 'none' ? '<span class="uk-margin-small-right" data-uk-icon="icon:receiver" data-uk-tooltip="' . Text::_('COM_CONTACT_FAX') . '"></span>' : ''), Text::sprintf('COM_CONTACT_FAX_NUMBER', $item->fax); ?></li>
                        <?php } ?>

                        <?php if ($this->params->get('show_mobile_headings') && !empty($item->mobile)) { ?>
                        <li><?php echo ($jsIcons !== 'none' ? '<span class="uk-margin-small-right" data-uk-icon="icon:phone" data-uk-tooltip="' . Text::_('COM_CONTACT_MOBILE') . '"></span>' : ''), Text::sprintf('COM_CONTACT_MOBILE_NUMBER', $item->mobile); ?></li>
                        <?php } ?>

                    </ul>
                </div>

            <div>
            <?php echo $item->event->afterDisplayContent; ?>

        </li>
        <?php
            }
        }
        ?>
    </ul>
    <?php
    }

    $show_pagination = $this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2);
    $show_pagination_results = $this->params->def('show_pagination_results', 1);

    if ($show_pagination && ($this->pagination->pagesTotal > 1)) {
    ?>
    <div class="uk-margin-top uk-flex uk-flex-center<?php if ($show_pagination_results) { echo ' uk-flex-between@s'; } ?>">

        <div><?php echo $this->pagination->getPagesLinks(); ?></div>

        <?php if ($show_pagination_results) { ?>
        <div class="pages-of"><?php echo $this->pagination->getPagesCounter(); ?></div>
        <?php } ?>

    </div>
    <?php } ?>
    <div>
        <input type="hidden" name="filter_order" value="<?php echo $this->escape($this->state->get('list.ordering')); ?>">
        <input type="hidden" name="filter_order_Dir" value="<?php echo $this->escape($this->state->get('list.direction')); ?>">
    </div>
</form>
