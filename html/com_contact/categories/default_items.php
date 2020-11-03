<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

if ($this->maxLevelcat != 0 && count($this->items[$this->parent->id]) > 0) {
    foreach ($this->items[$this->parent->id] as $id => $item) {
        if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) {
?>
<li>
    <div class="uk-h3">
        <a class="uk-display-inline-block" href="<?php echo Route::_(ContactHelperRoute::getCategoryRoute($item->id, $item->language)); ?>"><?php echo $this->escape($item->title); ?></a>

        <?php if ($this->params->get('show_cat_items_cat') == 1) { ?>
        <span class="uk-badge" data-uk-tooltip="<?php echo Text::_('COM_CONTACT_NUM_ITEMS'); ?>"><?php echo $item->numitems; ?></span>
        <?php
    } ?>
    </div>

    <?php if ($this->params->get('show_subcat_desc_cat') == 1 && $item->description) { ?>
    <div class="uk-margin-small-top category-desc">
        <?php echo HTMLHelper::_('content.prepare', $item->description, '', 'com_contact.categories'); ?>
    </div>
    <?php
    }

    if ($this->maxLevelcat > 1 && count($item->getChildren()) > 0) {
    ?>
    <ul class="uk-nav-sub" id="category-<?php echo $item->id; ?>">
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
