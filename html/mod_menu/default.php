<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu.nav
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

$class_sfx = $class_sfx ? ' ' . trim($class_sfx) : '';

echo '<ul class="uk-nav' . $class_sfx . '"' . $id . '>';

foreach ($list as $i => &$item) {
    $class = 'item-' . $item->id;

    if ($item->id == $active_id) {
        $class .= ' uk-active';
    } elseif (in_array($item->id, $path)) {
        $class .= ' uk-active';
    } elseif ($item->type === 'alias') {
        $aliasToId = $item->params->get('aliasoptions');

        if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
            $class .= ' uk-active';
        } elseif (in_array($aliasToId, $path)) {
            $class .= ' uk-active';
        }
    }

    if ($item->parent) {
        $class .= ' uk-parent';
    }

    if ($item->type == 'separator') {
        $class .= ' uk-nav-divider';
    }

    echo '<li class="' . trim($class) . '">';

    switch ($item->type) {
        case 'separator':
            break;

        case 'component':
        case 'heading':
        case 'url':
            require ModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
            break;

        default:
            require ModuleHelper::getLayoutPath('mod_menu', 'default_url');
            break;
    }

    if ($item->deeper) {
        echo '<ul class="uk-nav-sub">';
    } elseif ($item->shallower) {
        echo '</li>';

        if ((int)$item->level_diff) {
            echo str_repeat('</ul></li>', (int)$item->level_diff);
        }
    } else {
        echo '</li>';
    }
}

echo '</ul>';
