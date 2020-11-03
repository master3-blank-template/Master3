<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;

$blockPosition = $displayData['params']->get('info_block_position', 0);

?>
<div class="uk-margin">

    <?php
    if ($displayData['position'] === 'above' && ($blockPosition == 0 || $blockPosition == 2) || $displayData['position'] === 'below' && ($blockPosition == 1)) {
        if ($displayData['params']->get('info_block_show_title', 1)) {
            echo '<div class="article-info-term uk-h5 uk-margin-small">' . Text::_('COM_CONTENT_ARTICLE_INFO') . '</div>';
        }

        if ($displayData['params']->get('show_author') && !empty($displayData['item']->author)) {
            echo $this->sublayout('author', $displayData);
        }

        if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_slug)) {
            echo $this->sublayout('parent_category', $displayData);
        }

        if ($displayData['params']->get('show_category')) {
            echo $this->sublayout('category', $displayData);
        }

        if ($displayData['params']->get('show_publish_date')) {
            echo $this->sublayout('publish_date', $displayData);
        }
    }

    if ($displayData['position'] === 'above' && ($blockPosition == 0) || $displayData['position'] === 'below' && ($blockPosition == 1 || $blockPosition == 2)) {
        if ($displayData['params']->get('show_create_date')) {
            echo $this->sublayout('create_date', $displayData);
        }

        if ($displayData['params']->get('show_modify_date')) {
            echo $this->sublayout('modify_date', $displayData);
        }

        if ($displayData['params']->get('show_hits')) {
            echo $this->sublayout('hits', $displayData);
        }
    }

    if ($displayData['position'] === 'above' && ($blockPosition == 0 || $blockPosition == 2) || $displayData['position'] === 'below' && ($blockPosition == 1)) {
        if ($displayData['params']->get('show_associations')) {
            echo $this->sublayout('associations', $displayData);
        }
    }
    ?>
</div>
