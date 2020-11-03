<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

?>
<ul class="uk-nav category-module<?php echo $moduleclass_sfx; ?>">
    <?php if ($grouped) { ?>
        <?php foreach ($list as $group_name => $group) { ?>
        <li>
            <div class="uk-h4 mod-articles-category-group"><?php echo $group_name; ?></div>
            <ul class="uk-nav-sub">
                <?php foreach ($group as $item) { ?>
                    <li>
                        <?php if ($params->get('link_titles') == 1) { ?>
                        <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
                        <?php } else { ?>
                        <?php echo $item->title; ?>
                        <?php } ?>

                        <?php if ($item->displayHits) { ?>
                        <span class="mod-articles-category-hits">( <?php echo $item->displayHits; ?> )</span>
                        <?php } ?>

                        <?php if ($params->get('show_author')) { ?>
                        <span class="mod-articles-category-writtenby"><?php echo $item->displayAuthorName; ?></span>
                        <?php } ?>

                        <?php if ($item->displayCategoryTitle) { ?>
                        <span class="mod-articles-category-category">( <?php echo $item->displayCategoryTitle; ?> )</span>
                        <?php } ?>

                        <?php if ($item->displayDate) { ?>
                        <span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
                        <?php } ?>

                        <?php if ($params->get('show_introtext')) { ?>
                        <p class="mod-articles-category-introtext"><?php echo $item->displayIntrotext; ?></p>
                        <?php } ?>

                        <?php if ($params->get('show_readmore')) { ?>
                            <p class="mod-articles-category-readmore">
                                <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
                                    <?php if ($item->params->get('access-view') == false) { ?>
                                        <?php echo Text::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
                                    <?php } elseif ($readmore = $item->alternative_readmore) { ?>
                                        <?php echo $readmore; ?>
                                        <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                                            <?php if ($params->get('show_readmore_title', 0) != 0) { ?>
                                                <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                                            <?php } ?>
                                    <?php } elseif ($params->get('show_readmore_title', 0) == 0) { ?>
                                        <?php echo Text::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
                                    <?php } else { ?>
                                        <?php echo Text::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
                                        <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                                    <?php } ?>
                                </a>
                            </p>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
    <?php } else { ?>
        <?php foreach ($list as $item) { ?>
            <li>
                <?php if ($params->get('link_titles') == 1) { ?>
                <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
                <?php } else { ?>
                <?php echo $item->title; ?>
                <?php } ?>

                <?php if ($item->displayHits) { ?>
                <span class="mod-articles-category-hits">( <?php echo $item->displayHits; ?> )</span>
                <?php } ?>

                <?php if ($params->get('show_author')) { ?>
                <span class="mod-articles-category-writtenby"><?php echo $item->displayAuthorName; ?></span>
                <?php } ?>

                <?php if ($item->displayCategoryTitle) { ?>
                <span class="mod-articles-category-category">( <?php echo $item->displayCategoryTitle; ?> )</span>
                <?php } ?>

                <?php if ($item->displayDate) { ?>
                <span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
                <?php } ?>

                <?php if ($params->get('show_introtext')) { ?>
                <p class="mod-articles-category-introtext"><?php echo $item->displayIntrotext; ?></p>
                <?php } ?>

                <?php if ($params->get('show_readmore')) { ?>
                    <p class="mod-articles-category-readmore">
                        <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
                            <?php if ($item->params->get('access-view') == false) { ?>
                                <?php echo Text::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
                            <?php } elseif ($readmore = $item->alternative_readmore) { ?>
                                <?php echo $readmore; ?>
                                <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                            <?php } elseif ($params->get('show_readmore_title', 0) == 0) { ?>
                                <?php echo Text::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
                            <?php } else { ?>
                                <?php echo Text::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
                                <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
                            <?php } ?>
                        </a>
                    </p>
                <?php } ?>
            </li>
        <?php } ?>
    <?php } ?>
</ul>
