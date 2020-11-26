<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

// Note that there are certain parts of this layout used only when there is exactly one tag.
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

?>
<div class="tag-category<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_tag_title', 1)) { ?>
    <h1 class="uk-articke-title"><?php echo HTMLHelper::_('content.prepare', $this->tags_title, '', 'com_tag.tag'); ?></h1>
    <?php } elseif ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-articke-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php
    }

    // We only show a tag description if there is a single tag.
    if (count($this->item) === 1 && ($this->params->get('tag_list_show_tag_image', 1) || $this->params->get('tag_list_show_tag_description', 1))) {
    ?>
    <div class="category-desc uk-margin-medium-bottom">
        <?php
        $images = json_decode($this->item[0]->images);
        if ($this->params->get('tag_list_show_tag_image', 1) == 1 && !empty($images->image_fulltext)) {
        ?>
        <img class="uk-width uk-margin" src="<?php echo htmlspecialchars($images->image_fulltext, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>" loading="lazy">
        <?php
        }

        if ($this->params->get('tag_list_show_tag_description') == 1 && $this->item[0]->description) {
            echo HTMLHelper::_('content.prepare', $this->item[0]->description, '', 'com_tags.tag');
        }
        ?>
    </div>
    <?php
    }

    // If there are multiple tags and a description or image has been supplied use that.
    if ($this->params->get('tag_list_show_tag_description', 1) || $this->params->get('show_description_image', 1)) {
    ?>
    <div class="uk-margin-mefium-bottom">
        <?php if ($this->params->get('show_description_image', 1) == 1 && $this->params->get('tag_list_image')) { ?>
        <img class="uk-width uk-margin" src="<?php echo $this->params->get('tag_list_image'); ?>" loading="lazy">
        <?php
        }
        if ($this->params->get('tag_list_description', '') > '') {
            echo HTMLHelper::_('content.prepare', $this->params->get('tag_list_description'), '', 'com_tags.tag');
        }
        ?>
    </div>
    <?php
    }

    echo $this->loadTemplate('items');

    if (!empty($this->items)) {
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
    <?php
        }
    }
    ?>
</div>
