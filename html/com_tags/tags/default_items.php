<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

HTMLHelper::_('behavior.caption');
HTMLHelper::_('behavior.core');

$user = Factory::getUser();

$canEdit = $user->authorise('core.edit', 'com_tags');
$canCreate = $user->authorise('core.create', 'com_tags');
$canEditState = $user->authorise('core.edit.state', 'com_tags');

$columns = $this->params->get('tag_columns', 1);

if ($columns < 1) {
    $columns = 1;
}

$bsspans = floor(12 / $columns);

if ($bsspans < 1) {
    $bsspans = 1;
}

$bscolumns = min($columns, floor(12 / $bsspans));
$n = count($this->items);

Factory::getDocument()->addScriptDeclaration("
var resetFilter = function() {
    document.getElementById( 'filter-search' ).value = '';
}
");

?>
<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
    <?php
    if ($this->params->get('filter_field') || $this->params->get('show_pagination_limit')) {
    ?>
    <div class="uk-flex uk-margin-medium-bottom" data-uk-margin>
        <?php if ($this->params->get('filter_field')) { ?>
        <div class="uk-button-group">
            <input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="uk-input uk-form-small uk-form-width-medium" onchange="document.adminForm.submit();" title="<?php echo Text::_('COM_TAGS_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo Text::_('COM_TAGS_TITLE_FILTER_LABEL'); ?>" />
            <button type="button" name="filter-search-button" title="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>" onclick="document.adminForm.submit();" class="uk-button uk-button-primary uk-button-small"><span data-uk-icon="icon:search"></span></button>
            <button type="reset" name="filter-clear-button" title="<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>" class="uk-button uk-button-default uk-button-small" onclick="resetFilter(); document.adminForm.submit();"><span class="icon:close"></span></button>
        </div>
        <?php
        }
        if ($this->params->get('show_pagination_limit')) {
            echo $this->pagination->getLimitBox();
        }
        ?>

        <input type="hidden" name="filter_order" value="" />
        <input type="hidden" name="filter_order_Dir" value="" />
        <input type="hidden" name="limitstart" value="" />
        <input type="hidden" name="task" value="" />
    </div>
    <?php
    }

    if ($this->items == false || $n === 0) {
    ?>
    <div class="uk-alert"><?php echo Text::_('COM_TAGS_NO_TAGS'); ?></div>
    <?php
    } else {
        foreach ($this->items as $i => $item) {
            if ($n === 1 || $i === 0 || $bscolumns === 1 || $i % $bscolumns === 0) {
        ?>
        <ul class="uk-list thumbnails">
        <?php
        }
        if ((!empty($item->access)) && in_array($item->access, $this->user->getAuthorisedViewLevels())) {
            ?>
            <li>
                <h3><a href="<?php echo Route::_(TagsHelperRoute::getTagRoute($item->id . ':' . $item->alias)); ?>"><?php echo $this->escape($item->title); ?></a></h3>
            <?php
        }
        if ($this->params->get('all_tags_show_tag_image') && !empty($item->images)) {
            $images = json_decode($item->images);
            ?>
                <div class="tag-body">
                    <?php
                    if (!empty($images->image_intro)) {
                        $imgfloat = empty($images->float_intro) ? $this->params->get('float_intro') : $images->float_intro;
                        ?>
                        <div class="uk-align-<?php echo htmlspecialchars($imgfloat); ?> item-image">
                            <img
                                <?php
                                if ($images->image_intro_caption) {
                                    echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
                                }
                                ?>
                                src="<?php echo $images->image_intro; ?>"
                                alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"
                            />
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
                <div class="caption">
                    <?php if ($this->params->get('all_tags_show_tag_description', 1)) { ?>
                    <span class="tag-body"><?php echo HTMLHelper::_('string.truncate', $item->description, $this->params->get('all_tags_tag_maximum_characters')); ?></span>
                    <?php } ?>
                    
                    <?php if ($this->params->get('all_tags_show_tag_hits')) { ?>
                    <span class="uk-badge"><?php echo Text::sprintf('JGLOBAL_HITS_COUNT', $item->hits); ?></span>
                    <?php } ?>
                </div>
            </li>
            
            <?php if (($i === 0 && $n === 1) || $i === $n - 1 || $bscolumns === 1 || (($i + 1) % $bscolumns === 0)) { ?>
            </ul>
            <?php
            }
        }
    }

    if (!empty($this->items)) {
        $show_pagination = $this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2);
        $show_pagination_results = $this->params->def('show_pagination_results', 1);
    
        if ($show_pagination && ($this->pagination->pagesTotal > 1)) {
        ?>
    <div class="uk-margin-top uk-flex uk-flex-center<?php if ($show_pagination_results) { echo ' uk-flex-between@s'; } ?>">

        <div><?php echo $this->pagination->getPagesLinks(); ?></div>

        <?php if ($show_pagination_results) { ?>
        <div><?php echo $this->pagination->getPagesCounter(); ?></div>
        <?php } ?>

    </div>
    <?php
        }
    }
    ?>
</form>
