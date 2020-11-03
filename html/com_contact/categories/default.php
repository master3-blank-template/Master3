<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

if ($this->params->get('show_page_heading') && !$params->get('show_title')) {
?>
<h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php } ?>

<ul class="categories-list<?php echo $this->pageclass_sfx; ?>" data-uk-nav="multiple:true">
    <?php
    echo LayoutHelper::render('joomla.content.categories_default', $this);
    echo $this->loadTemplate('items');
    ?>
</ul>
