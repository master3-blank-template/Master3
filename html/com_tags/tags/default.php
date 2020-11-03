<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

// Note that there are certain parts of this layout used only when there is exactly one tag.

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');
$description = $this->params->get('all_tags_description');
$descriptionImage = $this->params->get('all_tags_description_image');

?>
<div class="tag-category<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php
    }

    if ($this->params->get('all_tags_show_description_image') && !empty($descriptionImage)) {
    ?>
    <div><img class="uk-width uk-margin-medium" src="<?php echo $descriptionImage; ?>" loading="lazy"></div>
    <?php
    }

    if (!empty($description)) {
    ?>
    <div class="uk-margin-medium"><?php echo $description; ?></div>
    <?php
    }

    echo $this->loadTemplate('items');
    ?>

</div>
