<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Associations;

HTMLHelper::addIncludePath( JPATH_COMPONENT . '/helpers/html' );

// Create some shortcuts.
$params    = &$this->item->params;
$n         = count( $this->items );

// Check for at least one editable article
$isEditable = false;

if ( !empty( $this->items ) )
{
    foreach ( $this->items as $article )
    {
        if ( $article->params->get( 'access-edit' ) )
        {
            $isEditable = true;
            break;
        }
    }
}


$tableClass = $this->params->get( 'show_headings' ) != 1 ? ' table-noheader' : '';
?>
<form action="<?php echo htmlspecialchars( Uri::getInstance()->toString() ); ?>" method="post" name="adminForm" id="adminForm" class="uk-margin-medium-top">

    <?php if ( $this->params->get( 'filter_field' ) !== 'hide' || $this->params->get( 'show_pagination_limit' ) ) { ?>
        <legend class="uk-hidden"><?php echo Text::_( 'COM_CONTENT_FORM_FILTER_LEGEND' ); ?></legend>
        <div class="uk-grid-small uk-margin-medium-bottom" data-uk-grid>
            <?php if ( $this->params->get( 'filter_field' ) !== 'hide' ) { ?>
            <div>
                <?php if ( $this->params->get( 'filter_field' ) !== 'tag' ) { ?>
                    <input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape( $this->state->get( 'list.filter' ) ); ?>" class="uk-input uk-form-small uk-form-width-medium" onchange="document.adminForm.submit();" title="<?php echo Text::_( 'COM_CONTENT_FILTER_SEARCH_DESC' ); ?>" placeholder="<?php echo Text::_( 'COM_CONTENT_' . $this->params->get( 'filter_field' ) . '_FILTER_LABEL' ); ?>">
                <?php } else { ?>
                    <select class="uk-select uk-form-small uk-form-width-medium" name="filter_tag" id="filter_tag" onchange="document.adminForm.submit();" >
                        <option value=""><?php echo Text::_( 'JOPTION_SELECT_TAG' ); ?></option>
                        <?php echo HTMLHelper::_( 'select.options', HTMLHelper::_( 'tag.options', true, true ), 'value', 'text', $this->state->get( 'filter.tag' ) ); ?>
                    </select>
                <?php } ?>
            </div>
            <?php
            }
            if ( $this->params->get( 'show_pagination_limit' ) )
            {
            ?>
            <div>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
            <?php } ?>
            <div>
                <button type="submit" name="filter_submit" class="uk-button uk-button-small"><?php echo Text::_( 'COM_CONTENT_FORM_FILTER_SUBMIT' ); ?></button>
            </div>
        </div>
        <input type="hidden" name="filter_order" value="">
        <input type="hidden" name="filter_order_Dir" value="">
        <input type="hidden" name="limitstart" value="">
        <input type="hidden" name="task" value="">

    <?php
    }

    if ( empty( $this->items ) )
    {
        if ( $this->params->get( 'show_no_articles', 1 ) )
        {
        ?>
        <div class="uk-alert"><?php echo Text::_( 'COM_CONTENT_NO_ARTICLES' ); ?></div>
        <?php
        }
    }
    else
    {
    ?>
    <table class="category uk-table uk-table-striped uk-table-responsive uk-table-hover<?php echo $tableClass; ?>">
        <caption class="uk-hidden"><?php echo Text::sprintf( 'COM_CONTENT_CATEGORY_LIST_TABLE_CAPTION', $this->category->title ); ?></caption>
        <thead>
            <tr>

                <th><?php echo Text::_( 'JGLOBAL_TITLE' ); ?></th>

                <?php if ( $date = $this->params->get( 'list_show_date' ) ) { ?>
                <th><?php echo Text::_( 'COM_CONTENT_' . $date . '_DATE' ); ?></th>
                <?php } ?>

                <?php if ( $this->params->get( 'list_show_author' ) ) { ?>
                <th><?php echo Text::_( 'JAUTHOR' ); ?></th>
                <?php } ?>

                <?php if ( $this->params->get( 'list_show_hits' ) ) { ?>
                <th><?php echo Text::_( 'JGLOBAL_HITS' ); ?></th>
                <?php } ?>

                <?php if ( $this->params->get( 'list_show_votes', 0 ) && $this->vote ) { ?>
                <th><?php echo Text::_( 'COM_CONTENT_VOTES' ); ?></th>
                <?php } ?>

                <?php if ( $this->params->get( 'list_show_ratings', 0 ) && $this->vote ) { ?>
                <th><?php echo Text::_( 'COM_CONTENT_RATINGS' ); ?><</th>
                <?php } ?>

                <?php if ( $isEditable ) { ?>
                <th><?php echo Text::_( 'COM_CONTENT_EDIT_ITEM' ); ?></th>
                <?php } ?>

            </tr>
        </thead>

        <tbody>
            <?php foreach ( $this->items as $i => $article ) { ?>

            <tr class="<?php if ( $this->items[$i]->state == 0 ) { echo 'uk-text-muted '; } ?>cat-list-row<?php echo $i % 2; ?>">

                <td headers="categorylist_header_title" class="list-title">
                    <?php
                    if ( in_array( $article->access, $this->user->getAuthorisedViewLevels() ) )
                    {
                    ?>
                    <a href="<?php echo Route::_( ContentHelperRoute::getArticleRoute( $article->slug, $article->catid, $article->language ) ); ?>"><?php echo $this->escape( $article->title ); ?></a>
                    <?php
                        if ( Associations::isEnabled() && $this->params->get( 'show_associations' ) )
                        {
                            $associations = ContentHelperAssociation::displayAssociations( $article->id );
                            foreach ( $associations as $association )
                            {
                                if ( $this->params->get( 'flags', 1 ) && $association['language']->image )
                                {
                                    $flag = HTMLHelper::_( 'image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array( 'title' => $association['language']->title_native ), true );
                                    echo '&nbsp;<a href="' .  Route::_( $association['item'] ) . '">' . $flag . '</a>&nbsp;';
                                }
                                else
                                {
                                    $class = 'label label-association label-' . $association['language']->sef;
                                    echo '&nbsp;<a class="' . $class . '" href="' . Route::_( $association['item'] ) . '">' . strtoupper( $association['language']->sef ) . '</a>&nbsp;';
                                }
                            }
                        }
                    }
                    else
                    {
                        echo $this->escape( $article->title ) . ' : ';
                        $menu   = Factory::getApplication()->getMenu();
                        $active = $menu->getActive();
                        $itemId = $active->id;
                        $link   = new Uri( Route::_( 'index.php?option=com_users&view=login&Itemid=' . $itemId, false ) );
                        $link->setVar( 'return', base64_encode( ContentHelperRoute::getArticleRoute( $article->slug, $article->catid, $article->language ) ) );
                    ?>
                    <a href="<?php echo $link; ?>" class="register"><?php echo Text::_( 'COM_CONTENT_REGISTER_TO_READ_MORE' ); ?></a>
                    <?php
                        if ( Associations::isEnabled() && $this->params->get( 'show_associations' ) )
                        {
                            $associations = ContentHelperAssociation::displayAssociations( $article->id );
                            foreach ( $associations as $association )
                            {
                                if ( $this->params->get( 'flags', 1 ) )
                                {
                                    $flag = HTMLHelper::_( 'image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, array( 'title' => $association['language']->title_native ), true );
                                    echo '&nbsp;<a href="' .  Route::_( $association['item'] ) . '">' . $flag . '</a>&nbsp;';
                                }
                                else
                                {
                                    $class = 'label label-association label-' . $association['language']->sef;
                                    echo '&nbsp;<a class="' . $class . '" href="' . Route::_( $association['item'] ) . '">' . strtoupper( $association['language']->sef ) . '</a>&nbsp;';
                                }
                            }
                        }
                    }

                    if ( $article->state == 0 )
                    {
                    ?>
                    <span class="list-published label label-warning"><?php echo Text::_( 'JUNPUBLISHED' ); ?></span>
                    <?php
                    }
                    if ( strtotime( $article->publish_up ) > strtotime( Factory::getDate() ) )
                    {
                    ?>
                    <span class="list-published label label-warning"><?php echo Text::_( 'JNOTPUBLISHEDYET' ); ?></span>
                    <?php
                    }
                    if ( ( strtotime( $article->publish_down ) < strtotime( Factory::getDate() ) ) && $article->publish_down != Factory::getDbo()->getNullDate() )
                    {
                    ?>
                    <span class="list-published label label-warning"><?php echo Text::_( 'JEXPIRED' ); ?></span>
                    <?php
                    }
                    ?>
                </td>

                <?php if ( $this->params->get( 'list_show_date' ) ) { ?>
                <td><?php echo HTMLHelper::_( 'date', $article->displayDate, $this->escape( $this->params->get( 'date_format', Text::_( 'd.m.Y' ) ) ) ); ?></td>
                <?php } ?>

                <?php if ( $this->params->get( 'list_show_author', 1 ) ) { ?>
                <td>
                    <?php
                    if ( !empty( $article->author ) || !empty( $article->created_by_alias ) )
                    {
                        $author = $article->author;
                        $author = $article->created_by_alias ?: $author;
                        if ( !empty( $article->contact_link ) && $this->params->get( 'link_author' ) == true )
                        {
                            echo HTMLHelper::_( 'link', $article->contact_link, $author );
                        }
                        else
                        {
                            echo $author;
                        }
                    }
                    ?>
                </td>
                <?php } ?>

                <?php if ( $this->params->get( 'list_show_hits', 1 ) ) { ?>
                <td><?php echo $article->hits; ?></td>
                <?php } ?>

                <?php if ( $this->params->get( 'list_show_votes', 0 ) && $this->vote ) { ?>
                <td><?php echo Text::sprintf( 'COM_CONTENT_VOTES_COUNT', $article->rating_count ); ?></td>
                <?php } ?>

                <?php if ( $this->params->get( 'list_show_ratings', 0 ) && $this->vote ) { ?>
                <td><?php echo Text::sprintf( 'COM_CONTENT_RATINGS_COUNT', $article->rating ); ?></td>
                <?php } ?>

                <?php if ( $isEditable ) { ?>
                <td><?php if ( $article->params->get( 'access-edit' ) ) { echo HTMLHelper::_( 'icon.edit', $article, $params, ['class' => 'uk-button uk-button-link', 'data-uk-tooltip' => Text::_( 'JGLOBAL_EDIT_TITLE' ) ] ); } ?></td>
                <?php } ?>

            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
    }

    // Add pagination links
    if ( !empty( $this->items ) )
    {
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
    <?php
        }
    }

    // Code to add a link to submit an article.
    if ( $this->category->getParams()->get( 'access-create' ) )
    {
    ?>
    <div class="uk-margin-top"><?php echo HTMLHelper::_( 'icon.create', $this->category, $this->category->params, ['class' => 'uk-button uk-button-link', 'data-uk-tooltip' => Text::_( 'COM_CONTENT_CREATE_ARTICLE' ) ] ); ?></div>
    <?php
    }
    ?>
</form>
