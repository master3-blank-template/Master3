<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu.navbar
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$linktype = (int)$item->level === $firstLevel ? '<span class="uk-display-block">' : '<span class="uk-flex uk-flex-middle uk-nav-header">';

if ($item->menu_image) {
    $linktype .= (int)$item->level === $firstLevel ? '<span class="uk-flex uk-flex-middle">' : '';

    if ($item->menu_image_css) {
        $image_attributes['class'] = $item->menu_image_css;
        $linktype .= HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);
    } else {
        $linktype .= HTMLHelper::_('image', $item->menu_image, $item->title);
    }

    if ($item->params->get('menu_text', 1)) {
        $linktype .= '<span class="uk-display-inline-block uk-margin-small-left">' . $item->title . '</span>';
    }

    $linktype .= (int)$item->level === $firstLevel ? '</span>' : '';
} else {
    $linktype .= $item->title;
}

if ((int)$item->level === $firstLevel && $miParams->subtitle) {
    $linktype .= '<span class="uk-display-block uk-navbar-subtitle">' . $miParams->subtitle . '</span>';
}

$linktype .= '</span>';

if ((int)$item->level === $firstLevel) {
    echo '<a class="uk-nav-header">' . $linktype . '</a>';
} else {
    echo $linktype;
}
