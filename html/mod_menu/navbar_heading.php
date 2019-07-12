<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu.navbar
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$linktype = '<span class="uk-display-block">' . $item->title;

if ($item->menu_image) {
    if ($item->menu_image_css) {
        $image_attributes['class'] = $item->menu_image_css;
        $linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);
    } else {
        $linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
    }

    if ($item->params->get('menu_text', 1)) {
        $linktype .= '<span class="uk-display-inline-block">' . $item->title;
    }
}

if ($miParams->subtitle) {
    $linktype .= '<span class="uk-display-block uk-navbar-subtitle">' . $miParams->subtitle . '</span>';
}

$linktype .= '</span>';

echo '<a>' . $linktype . '</a>';
