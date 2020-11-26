<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
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

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

$user = Factory::getUser();

$canEdit = $user->authorise('core.edit', 'com_tags');
$canCreate = $user->authorise('core.create', 'com_tags');
$canEditState = $user->authorise('core.edit.state', 'com_tags');

$columns = $this->params->get('tag_columns', 1);
$all_tags_show_tag_description = $this->params->get('all_tags_show_tag_description', 1);
$all_tags_show_tag_hits = $this->params->get('all_tags_show_tag_hits');
$all_tags_show_tag_image = $this->params->get('all_tags_show_tag_image');
$show_float_intro = (bool) $this->params->get('float_intro');

if ($columns < 1) {
    $columns = 1;
}

if ($columns > 6) {
    $columns = 6;
}

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
    <div class="uk-grid uk-grid-small uk-child-width-auto uk-margin-medium-bottom" data-uk-grid>
        <?php if ($this->params->get('filter_field')) { ?>
        <div class="uk-button-group">
            <input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="uk-input uk-form-small uk-form-width-medium" onchange="document.adminForm.submit();" title="<?php echo Text::_('COM_TAGS_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo Text::_('COM_TAGS_TITLE_FILTER_LABEL'); ?>">
            <?php if ($jsIcons !== 'none') { ?>
            <button type="button" name="filter-search-button" title="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>" onclick="document.adminForm.submit();" class="uk-button uk-button-small uk-button-primary"><span data-uk-icon="icon:search"></span></button>
            <button type="reset" name="filter-clear-button" title="<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>" class="uk-button uk-button-small uk-button-default" onclick="resetFilter(); document.adminForm.submit();"><span data-uk-icon="icon:close"></span></button>
            <?php } else { ?>
            <button type="button" name="filter-search-button" onclick="document.adminForm.submit();" class="uk-button uk-button-small uk-button-primary"><?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="reset" name="filter-clear-button" class="uk-button uk-button-small uk-button-default" onclick="resetFilter(); document.adminForm.submit();"><?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?></button>
            <?php } ?>
        </div>
        <?php
        }
        if ($this->params->get('show_pagination_limit')) {
            echo '<div>';

            $limits = [];
            for ($i = 5; $i <= 30; $i += 5) {
                $limits[] = HTMLHelper::_('select.option', "$i");
            }
            $limits[] = HTMLHelper::_('select.option', '50', Text::_('J50'));
            $limits[] = HTMLHelper::_('select.option', '100', Text::_('J100'));
            $limits[] = HTMLHelper::_('select.option', '0', Text::_('JALL'));

            $selected = filter_input(INPUT_POST, 'limit', FILTER_SANITIZE_NUMBER_INT);
            if (!isset($selected)) {
                $selected = 0;
            }
            echo HTMLHelper::_('select.genericlist', $limits, $this->prefix . 'limit', 'class="uk-select uk-form-width-mini uk-form-small" onchange="this.form.submit()"', 'value', 'text', $selected);

            echo '</div>';
        }
        ?>

        <input type="hidden" name="filter_order" value="">
        <input type="hidden" name="filter_order_Dir" value="">
        <input type="hidden" name="limitstart" value="">
        <input type="hidden" name="task" value="">
    </div>
    <?php
    }

    if (!count($this->items)) {
    ?>
    <div class="uk-alert"><?php echo Text::_('COM_TAGS_NO_TAGS'); ?></div>
    <?php
    } else {

        echo $columns > 1 ?
            '<div class="uk-grid uk-child-width-1-' . $columns . '" data-uk-grid="margin:uk-margin-top">' :
            '<ul class="uk-list thumbnails">';
        $itemHtmlTag = $columns > 1 ? 'div' : 'li';

        foreach ($this->items as $i => $item) {
            if ((!empty($item->access)) && in_array($item->access, $this->user->getAuthorisedViewLevels())) {
                echo '<' . $itemHtmlTag . '>';
            ?>
            <a class="uk-text-large uk-display-block" href="<?php echo Route::_(TagsHelperRoute::getTagRoute($item->id . ':' . $item->alias)); ?>"><?php echo $this->escape($item->title); ?></a>
                <?php
                if ($all_tags_show_tag_image && !empty($item->images)) {
                    $images = json_decode($item->images);
                    ?>
                    <div class="tag-body">
                        <?php
                        if (!empty($images->image_intro)) {
                            $imgfloat = empty($images->float_intro) ? $show_float_intro : $images->float_intro;
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
                                    loading="lazy"
                                >
                            </div>
                        <?php } ?>
                    </div>
                <?php
                }
                if (($all_tags_show_tag_description && $item->description) || $all_tags_show_tag_hits) {
                ?>
                <div class="caption">
                    <?php if ($all_tags_show_tag_description && $item->description) { ?>
                    <span class="tag-body"><?php echo HTMLHelper::_('string.truncate', $item->description, $this->params->get('all_tags_tag_maximum_characters')); ?></span>
                    <?php } ?>

                    <?php if ($all_tags_show_tag_hits) { ?>
                    <span class="tag-view"> (<?php echo Text::sprintf('JGLOBAL_HITS_COUNT', $item->hits); ?>)</span>
                    <?php } ?>
                </div>
                <?
                }
                echo '</' . $itemHtmlTag . '>';
            }
        }
        echo $columns > 1 ? '</div>' : '</ul>';
    }

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
</form>
