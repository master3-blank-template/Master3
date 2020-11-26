<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<div class="blog-featured<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php
    }


    $leadingcount = 0;
    if (!empty($this->lead_items)) {
    ?>
    <div class="uk-child-width-1-1" data-uk-grid>
        <?php foreach ($this->lead_items as &$item) { ?>
        <div itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
            <?php
            $this->item = &$item;
            echo $this->loadTemplate('item');
            ?>
        </div>
        <?php
            $leadingcount++;
        }
        ?>
    </div>
    <?php
    }


    if (!empty($this->intro_items)) {
    ?>
    <div class="uk-child-width-1-<?php echo ( int )$this->columns; ?>@m uk-child-width-1-<?php echo ( int )round($this->columns / 2); ?>@s" data-uk-grid>
        <?php foreach ($this->intro_items as $key => &$item) { ?>
        <div itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
            <?php
            $this->item = &$item;
            echo $this->loadTemplate('item');
            ?>
        </div>
        <?php } ?>
    </div>
    <?php
    }


    if (!empty($this->link_items)) {
        echo $this->loadTemplate('links');
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

</div>
