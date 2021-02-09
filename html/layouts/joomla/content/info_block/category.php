<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

?>
<div class="category-name">
    <?php
    if ($jsIcons !== 'none') {
        echo '<span data-uk-icon="icon:folder"></span> ';
    }
    $title = $this->escape($displayData['item']->category_title);
    if ($displayData['params']->get('link_category') && $displayData['item']->catslug) {
        $url = '<a href="' . Route::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)) . '" itemprop="genre">' . $title . '</a>';
        echo Text::sprintf('COM_CONTENT_CATEGORY', $url);
    } else {
        echo Text::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>');
    }
    ?>
</div>
