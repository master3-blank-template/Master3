<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu.subnav
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

$firstLevel = (int) $list[array_key_first($list)]->level;

echo '<ul class="uk-subnav' . $class_sfx . '"' . $id . '>';

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

    if ($item->type == 'separator' && (int)$item->level === $firstLevel) {
        $class .= ' uk-nav-divider';
    }

    echo '<li class="' . trim($class) . '">';

    switch ($item->type) {
        case 'separator':
            if ((int)$item->level !== $firstLevel) {
                require ModuleHelper::getLayoutPath('mod_menu', 'subnav_heading');
            }
            break;

        case 'component':
        case 'heading':
        case 'url':
            require ModuleHelper::getLayoutPath('mod_menu', 'subnav_' . $item->type);
            break;

        default:
            require ModuleHelper::getLayoutPath('mod_menu', 'subnav_url');
            break;
    }

    if ($item->deeper) {
        if ((int)$item->level === $firstLevel) {
            echo '<div data-uk-dropdown><ul class="uk-nav uk-dropdown-nav">';
        } else {
            echo '<ul class="uk-nav-sub">';
        }
    } elseif ($item->shallower) {
        echo '</li>';

        $level_diff = (int)$item->level_diff - 1;

        if ($level_diff) {
            echo str_repeat('</ul></li>', $level_diff);
        }

        if (((int)$item->level - (int)$item->level_diff) === $firstLevel) {
            echo '</ul></div></li>';
        } else {
            echo '</ul></li>';
        }
    } else {
        echo '</li>';
    }
}

echo '</ul>';
