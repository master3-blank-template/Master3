<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');

?>
<div class="archive<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php } ?>

    <form id="adminForm" action="<?php echo Route::_('index.php'); ?>" method="post" class="form-inline">

        <div class="uk-flex" data-uk-margin>
            <?php if ($this->params->get('filter_field') !== 'hide') { ?>
            <input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->filter); ?>" class="uk-inpit uk-form-width-medium" onchange="document.getElementById('adminForm').submit();" placeholder="<?php echo Text::_('COM_CONTENT_TITLE_FILTER_LABEL'); ?>">
            <?php
            }

            echo $this->form->monthField;
            echo $this->form->yearField;
            echo $this->form->limitField;
            ?>

            <button type="submit" class="uk-button uk-butto-primary"><?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?></button>

            <input type="hidden" name="view" value="archive">
            <input type="hidden" name="option" value="com_content">
            <input type="hidden" name="limitstart" value="0">
        </div>

        <?php echo $this->loadTemplate('items'); ?>

    </form>
</div>
