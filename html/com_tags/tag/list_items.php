<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

Factory::getDocument()->addScriptDeclaration("
var resetFilter = function() {
    document.getElementById( 'filter-search' ).value = '';
}
");

?>
<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">

    <?php if ($this->params->get('show_headings') || $this->params->get('filter_field') || $this->params->get('show_pagination_limit')) { ?>
    <div class="uk-margin-medium uk-flex" data-uk-margin>
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
            echo $this->pagination->getLimitBox();
        }
        ?>
        <input type="hidden" name="filter_order" value="">
        <input type="hidden" name="filter_order_Dir" value="">
        <input type="hidden" name="limitstart" value="">
        <input type="hidden" name="task" value="">
    </div>
    <?php
    }

    if (empty($this->items)) {
    ?>
    <div class="uk-alert"><?php echo Text::_('COM_TAGS_NO_ITEMS'); ?></div>
    <?php } else { ?>
    <table class="category uk-table uk-table-striped uk-table-responsive uk-table-hover">

        <?php if ($this->params->get('show_headings')) { ?>
        <thead>
            <tr>
                <th><?php echo Text::_('JGLOBAL_TITLE'); ?></th>
                <?php if ($date = $this->params->get('tag_list_show_date')) { ?>
                <th><?php echo Text::_('COM_TAGS_' . $date . '_DATE'); ?></th>
                <?php  } ?>
            </tr>
        </thead>
        <?php } ?>

        <tbody>
            <?php
            foreach ($this->items as $i => $item) {
                $class = $item->core_state != 0 ? : ' class="uk-text-muted"';
            ?>
            <tr <?php echo $class; ?>>

                <td>
                    <a href="<?php echo Route::_($item->link); ?>"><?php echo $this->escape($item->core_title); ?></a>
                    <?php if ($item->core_state == 0) { ?>
                    <span class="uk-text-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
                    <?php } ?>
                </td>

                <?php if ($this->params->get('tag_list_show_date')) { ?>
                <td><?php echo HTMLHelper::_('date', $item->displayDate, $this->escape($this->params->get('date_format', Text::_('d.m.Y')))); ?></td>
                <?php } ?>

            </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    // Add pagination links
    if (!empty($this->items) && ($this->pagination->pagesTotal > 1)) {
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
    }
    ?>
</form>
