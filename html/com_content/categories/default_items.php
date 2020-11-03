<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

$lang = Factory::getLanguage();

if ($this->maxLevelcat != 0 && count($this->items[$this->parent->id]) > 0) {
    foreach ($this->items[$this->parent->id] as $id => $item) {
        if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) {
?>
<li>
    <a class="uk-display-inline-block" href="<?php echo Route::_(ContentHelperRoute::getCategoryRoute($item->id, $item->language)); ?>"><?php echo $this->escape($item->title); ?></a>

    <?php if ($this->params->get('show_cat_num_articles_cat') == 1) { ?>
    <span class="uk-badge" data-uk-tooltip="<?php echo Text::_('COM_CONTENT_NUM_ITEMS_TIP'); ?>"><?php echo $item->numitems; ?></span>
    <?php } ?>

    <?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) { ?>
    <a id="category-btn-<?php echo $item->id; ?>" href="#category-<?php echo $item->id; ?>" data-toggle="collapse" data-toggle="button" class="uk-button uk-button-small uk-align-right uk-margin-small-left" aria-label="<?php echo Text::_('JGLOBAL_EXPAND_CATEGORIES'); ?>"><span class="icon-plus" aria-hidden="true"></span></a>
    <?php } ?>

    <?php if ($this->params->get('show_description_image') && $item->getParams()->get('image')) { ?>
    <img src="<?php echo $item->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($item->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>" loading="lazy">
    <?php } ?>

    <?php if ($this->params->get('show_subcat_desc_cat') == 1 && $item->description) { ?>
    <div class="uk-margin-small-top category-desc">
        <?php echo HTMLHelper::_('content.prepare', $item->description, '', 'com_content.categories'); ?>
    </div>
    <?php
    }

    if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) {
    ?>
    <ul class="uk-nav-sub uk-h3" id="category-<?php echo $item->id; ?>">
        <?php
        $this->items[$item->id] = $item->getChildren();
        $this->parent = $item;
        $this->maxLevelcat--;
        echo $this->loadTemplate('items');
        $this->parent = $item->getParent();
        $this->maxLevelcat++;
        ?>
    </ul>
    <?php } ?>
</li>
<?php
        }
    }
}
