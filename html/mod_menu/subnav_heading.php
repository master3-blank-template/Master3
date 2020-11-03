<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu.nav
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

if ($item->menu_image) {
    $linktype = '<span class="uk-flex uk-flex-middle">';

    if ($item->menu_image_css) {
        $image_attributes['class'] = $item->menu_image_css;
        $linktype .= HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);
    } else {
        $linktype .= HTMLHelper::_('image', $item->menu_image, $item->title);
    }

    if ($item->params->get('menu_text', 1)) {
        $linktype .= '<span class="uk-display-inline-block' . ((int)$item->level !== $firstLevel ? ' uk-nav-header' : '') . ' uk-margin-small-left">' . $item->title . '</span>';
    }

    $linktype .= '</span>';
} else {
    $linktype = '<span' . ((int)$item->level !== $firstLevel ? ' class="uk-nav-header"' : '') . '>' . $item->title . '</span>';
}

echo $linktype;
