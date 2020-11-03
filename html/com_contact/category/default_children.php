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

if ($this->maxLevel != 0 && count($this->children[$this->category->id]) > 0) {
    ?>
<ul data-uk-nav>
    <?php
    foreach ($this->children[$this->category->id] as $id => $child) {
        if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) {
    ?>
    <li>
        <div class="uk-h4">
            <a href="<?php echo Route::_(ContactHelperRoute::getCategoryRoute($child->id)); ?>"><?php echo $this->escape($child->title); ?></a>

            <?php if ($this->params->get('show_cat_items') == 1) { ?>
            <span class="uk-badge" data-uk-tooltip="<?php echo Text::_('COM_CONTACT_CAT_NUM'); ?>"><?php echo $child->numitems; ?></span>
            <?php } ?>
        </div>

        <?php if ($this->params->get('show_subcat_desc') == 1 && $child->description) { ?>
        <div class="uk-margin-small-top category-desc">
            <?php echo HTMLHelper::_('content.prepare', $child->description, '', 'com_contact.category'); ?>
        </div>
        <?php
        }

        if (count($child->getChildren()) > 0) {
            $this->children[$child->id] = $child->getChildren();
            $this->category = $child;
            $this->maxLevel--;
            echo $this->loadTemplate('children');
            $this->category = $child->getParent();
            $this->maxLevel++;
        }
        ?>
    </li>
    <?php
        }
    }
    ?>
</ul>
<?php
}
