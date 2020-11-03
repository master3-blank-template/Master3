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

$lang   = Factory::getLanguage() ;
$user   = Factory::getUser() ;
$groups = $user->getAuthorisedViewLevels() ;

if ( count( $this->children[$this->category->id] ) > 0 )
{
    ?>
    <ul data-uk-nav>
    <?php
    foreach ( $this->children[$this->category->id] as $id => $child )
    {
        // Check whether category access level allows access to subcategories.
        if ( in_array( $child->access, $groups ) )
        {
            if ( $this->params->get( 'show_empty_categories' ) || $child->getNumItems( true ) || count( $child->getChildren() ) )
            {
            ?>

            <li>
                <?php if ( $lang->isRtl() ) { ?>
                <div class="uk-h4">
                    <?php if ( $this->params->get( 'show_cat_num_articles', 1 ) ) { ?>
                    <span class="uk-badge" data-uk-tooltip="<?php echo Text::_( 'COM_CONTENT_NUM_ITEMS_TIP' ) ; ?>"><?php echo $child->getNumItems( true ) ; ?></span>
                    <?php } ?>

                    <a href="<?php echo Route::_( ContentHelperRoute::getCategoryRoute( $child->id ) ); ?>"><?php echo $this->escape( $child->title ) ; ?></a>

                    <?php if ( count( $child->getChildren() ) > 0 && $this->maxLevel > 1 ) { ?>
                    <a href="#category-<?php echo $child->id; ?>" data-toggle="collapse" data-toggle="button" class="uk-button uk-button-small uk-align-right uk-margin-small-left" aria-label="<?php echo Text::_( 'JGLOBAL_EXPAND_CATEGORIES' ) ; ?>"><span class="icon-plus" aria-hidden="true"></span></a>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="uk-h4">
                    <a href="<?php echo Route::_( ContentHelperRoute::getCategoryRoute( $child->id ) ); ?>"><?php echo $this->escape( $child->title ) ; ?></a>

                    <?php if ( $this->params->get( 'show_cat_num_articles', 1 ) ) { ?>
                    <span class="uk-badge" data-uk-tooltip="<?php echo Text::_( 'COM_CONTENT_NUM_ITEMS_TIP' ) ; ?>"><?php echo $child->getNumItems( true ) ; ?></span>
                    <?php } ?>

                    <?php if ( count( $child->getChildren() ) > 0 && $this->maxLevel > 1 ) { ?>
                    <a href="#category-<?php echo $child->id; ?>" data-toggle="collapse" data-toggle="button" class="uk-button uk-button-small uk-align-right uk-margin-small-left" aria-label="<?php echo Text::_( 'JGLOBAL_EXPAND_CATEGORIES' ) ; ?>"><span class="icon-plus" aria-hidden="true"></span></a>
                    <?php } ?>
                </div>
                <?php } ?>

                <?php if ( $this->params->get( 'show_subcat_desc' ) == 1 && $child->description ) { ?>
                <div class="category-desc"><?php echo HTMLHelper::_( 'content.prepare', $child->description, '', 'com_content.category' ) ; ?></div>
                <?php } ?>

                <?php
                if ( count( $child->getChildren() ) > 0 && $this->maxLevel > 1 )
                {
                    $this->children[$child->id] = $child->getChildren();
                    $this->category = $child;
                    $this->maxLevel--;
                    echo $this->loadTemplate( 'children' ) ;
                    $this->category = $child->getParent() ;
                    $this->maxLevel++;
                }
                ?>
            </li>
            <?php
            }
        }
    }
    ?>
    </ul>
<?php
}
