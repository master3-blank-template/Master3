<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu.nav
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$linktype = $item->title;
$linkClass = '';

if ($item->menu_image) {
    $linkClass = 'uk-flex uk-flex-middle ';

    if ($item->menu_image_css) {
        $image_attributes['class'] = $item->menu_image_css;
        $linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);
    } else {
        $linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
    }

    if ($item->params->get('menu_text', 1)) {
        $linktype .= '<span class="uk-display-inline-block uk-margin-small-left">' . $item->title . '</span>';
    }
}

echo '<span class="'. $linkClass . 'uk-nav-header">' . $linktype . '</span>';
