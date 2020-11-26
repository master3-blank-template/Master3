<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;

HTMLHelper::addIncludePath( JPATH_COMPONENT . '/helpers' );

$dispatcher = JEventDispatcher::getInstance();

$this->category->text = $this->category->description;
$dispatcher->trigger( 'onContentPrepare', array( $this->category->extension . '.categories', &$this->category, &$this->params, 0 ) );
$this->category->description = $this->category->text;

$results = $dispatcher->trigger( 'onContentAfterTitle', array( $this->category->extension . '.categories', &$this->category, &$this->params, 0 ) );
$afterDisplayTitle = trim( implode( "\n", $results ) );

$results = $dispatcher->trigger( 'onContentBeforeDisplay', array( $this->category->extension . '.categories', &$this->category, &$this->params, 0 ) );
$beforeDisplayContent = trim( implode( "\n", $results ) );

$results = $dispatcher->trigger( 'onContentAfterDisplay', array( $this->category->extension . '.categories', &$this->category, &$this->params, 0 ) );
$afterDisplayContent = trim( implode( "\n", $results ) );

?>
<div class="blog<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">

    <?php if ( $this->params->get( 'show_page_heading' ) ) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape( $this->params->get( 'page_heading' ) ); ?></h1>
    <?php
    }

    if ( $this->params->get( 'show_category_title', 1 ) or $this->params->get( 'page_subheading' ) ) { ?>
    <h2><?php echo $this->escape( $this->params->get( 'page_subheading' ) ); ?>
        <?php if ( $this->params->get( 'show_category_title' ) ) { ?>
        <span class="subheading-category"><?php echo $this->category->title; ?></span>
        <?php } ?>
    </h2>
    <?php
    }
    echo $afterDisplayTitle;

    if ( $this->params->get( 'show_cat_tags', 1 ) && !empty( $this->category->tags->itemTags ) )
    {
        $this->category->tagLayout = new FileLayout( 'joomla.content.tags' );
        echo $this->category->tagLayout->render( $this->category->tags->itemTags );
    }

    if ( $beforeDisplayContent || $afterDisplayContent || ( $this->params->get( 'show_description' ) && $this->category->description ) || ( $this->params->get( 'show_description_image' ) && $this->category->getParams()->get( 'image' ) ) )
    {
    ?>
    <div class="uk-margin-large category-desc">
        <?php if ( $this->params->get( 'show_description_image' ) && $this->category->getParams()->get( 'image' ) ) { ?>
        <img class="uk-width" src="<?php echo $this->category->getParams()->get( 'image' ); ?>" alt="<?php echo htmlspecialchars( $this->category->getParams()->get( 'image_alt' ), ENT_COMPAT, 'UTF-8' ); ?>" loading="lazy">
        <?php
        }
        echo $beforeDisplayContent;

        if ( $this->params->get( 'show_description' ) && $this->category->description )
        {
            echo HTMLHelper::_( 'content.prepare', $this->category->description, '', 'com_content.category' );
        }
        echo $afterDisplayContent;
        ?>
    </div>
    <?php
    }

    if ( empty( $this->lead_items ) && empty( $this->link_items ) && empty( $this->intro_items ) )
    {
        if ( $this->params->get( 'show_no_articles', 1 ) )
        {
            echo '<div class="uk-alert">' . Text::_( 'COM_CONTENT_NO_ARTICLES' ) . '</div>';
        }
    }


    $leadingcount = 0;
    if ( !empty( $this->lead_items ) )
    {
    ?>
    <div class="uk-child-width-1-1" data-uk-grid>
        <?php foreach ( $this->lead_items as &$item ) { ?>
        <div itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
            <?php
            $this->item = &$item;
            echo $this->loadTemplate( 'item' );
            ?>
        </div>
        <?php
            $leadingcount++;
        }
        ?>
    </div>
    <?php
    }


    if ( !empty( $this->intro_items ) )
    {
    ?>
    <div class="uk-child-width-1-<?php echo ( int ) $this->columns; ?>@m uk-child-width-1-<?php echo ( int ) round( $this->columns / 2 ); ?>@s" data-uk-grid>
    <?php
        foreach ( $this->intro_items as $key => &$item )
        {
        ?>
        <div itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
            <?php
            $this->item = &$item;
            echo $this->loadTemplate( 'item' );
            ?>
        </div>
        <?php
        }
    ?>
    </div>
    <?php
    }


    if ( !empty( $this->link_items ) )
    {
        echo $this->loadTemplate( 'links' );
    }

    if ( $this->maxLevel != 0 && !empty( $this->children[$this->category->id] ) )
    {
    ?>
    <hr>
    <div class="cat-children">
        <?php if ( $this->params->get( 'show_category_heading_title_text', 1 ) == 1 ) { ?>
        <h3><?php echo Text::_( 'JGLOBAL_SUBCATEGORIES' ); ?></h3>
        <?php
        }
        echo $this->loadTemplate( 'children' );
        ?>
    </div>
    <?php } ?>

    <?php
    $show_pagination = $this->params->def( 'show_pagination', 2 ) == 1 || ( $this->params->get( 'show_pagination' ) == 2 );
    $show_pagination_results = $this->params->def( 'show_pagination_results', 1 );

    if ( $show_pagination && ( $this->pagination->pagesTotal > 1 ) )
    {
    ?>
    <div class="uk-margin-top uk-flex uk-flex-center<?php if ( $show_pagination_results ) { echo ' uk-flex-between@s'; } ?>">

        <div><?php echo $this->pagination->getPagesLinks(); ?></div>

        <?php if ( $show_pagination_results ) { ?>
        <div class="pages-of"><?php echo $this->pagination->getPagesCounter(); ?></div>
        <?php } ?>

    </div>
    <?php } ?>
</div>
