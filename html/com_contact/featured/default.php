<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<div class="blog-featured<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading') != 0) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php

}

echo $this->loadTemplate('items');

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
    <?php } ?>

</div>
