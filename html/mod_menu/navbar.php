<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu.navbar
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');

if (!function_exists('getL2Items')) {
    function getL2Items($items, $id, $firstLevel)
    {
        $result = 0;
        foreach ($items as $item) {
            if ((int) $item->level === ($firstLevel + 1) && (int) $item->parent_id === $id) {
                $result++;
            }
        }
        return $result;
    }
}

$templateConfig = \Master3Config::getInstance();
$navbarClickMode = $templateConfig->params->get('navbarClickMode', 0);

$id = '';
$l2_i = 0;

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

$class_sfx = $class_sfx ? ' ' . trim($class_sfx) : '';

$firstLevel = (int) $list[array_key_first($list)]->level;

echo '<ul class="uk-navbar-nav' . $class_sfx . '"' . $id . '>';

foreach ($list as $i => &$item) {
    if ((int) $item->level === $firstLevel) {
        $miParams = $templateConfig->getMenuItemParams($item->id);
    }

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

    if ($item->type === 'separator') {
        $class .= ' uk-nav-divider';
    }

    if ($item->parent) {
        $class .= ' uk-parent';
    }

    echo '<li class="' . trim($class) . '">';

    switch ($item->type) {
        case 'separator':
            if ((int) $item->level === $firstLevel) {
                require ModuleHelper::getLayoutPath('mod_menu', 'navbar_heading');
            }
            break;

        case 'component':
        case 'heading':
        case 'url':
            require ModuleHelper::getLayoutPath('mod_menu', 'navbar_' . $item->type);
            break;

        default:
            require ModuleHelper::getLayoutPath('mod_menu', 'navbar_url');
            break;
    }

    if ($item->deeper) {
        if ((int) $item->level === $firstLevel) {
            $boundary = $miParams->dropdownJustify ? ' data-uk-drop="boundary:.uk-navbar;boundary-align:true;pos:bottom-justify;' . ($navbarClickMode ? 'mode:click;' : '') . '"' : '';
            $dropdownClass = $miParams->dropdownClass ? ' ' . $miParams->dropdownClass : '';

            if ($miParams->cols === 1) {
                echo '<div class="uk-navbar-dropdown' . $dropdownClass . '"' . $boundary . '><ul class="uk-nav uk-navbar-dropdown-nav">';
            } else {
                $l2_ic = getL2Items($list, (int) $item->id, (int)$firstLevel);
                $l2_cnt = (int) floor($l2_ic / $miParams->cols);
                $l2_rod = (int) ($l2_ic % $miParams->cols);
                $l2_i = 0;
                $l2_aItem = 0;
                $l2_arr = [];
                for ($l2_tmp = 0; $l2_tmp < $miParams->cols; $l2_tmp++) {
                    $l2_arr[$l2_tmp] = $l2_cnt + ($l2_rod ? 1 : 0);
                    $l2_rod = ($l2_rod ? $l2_rod - 1 : 0);
                }
                unset($l2_ic, $l2_cnt, $l2_rod);

                $divider = $miParams->divider ? 'uk-navbar-dropdown-grid ' : '';

                echo '<div class="uk-navbar-dropdown uk-navbar-dropdown-width-' . $miParams->cols . $dropdownClass . '"' . $boundary . '>'
                    . '<div class="' . $divider . 'uk-child-width-1-' . $miParams->cols . '" data-uk-grid>'
                    . '<div>'
                    . '<ul class="uk-nav uk-navbar-dropdown-nav">';
            }
        } else {
            echo '<ul class="uk-nav-sub">';
        }
    } elseif ($item->shallower) {
        echo '</li>';

        $level_diff = (int) $item->level_diff - 1;

        if ($level_diff) {
            echo str_repeat('</ul></li>', $level_diff);
        }

        if (((int) $item->level - (int) $item->level_diff) === $firstLevel) {

            if ($miParams->cols === 1) {
                echo '</ul></div></li>';
            } else {
                echo '</ul></div></div></div></li>';
                unset($l2_arr);
            }
        } else {
            echo '</ul></li>';
        }

        if (isset($l2_arr) && isset($l2_aItem)) {
            $l2_i++;
            if ($l2_arr[$l2_aItem] === $l2_i) {
                echo '</ul></div><div><ul class="uk-nav uk-navbar-dropdown-nav">';
                $l2_i = 0;
                $l2_aItem++;
            }
        }
    } else {
        echo '</li>';

        if ((int) $item->level === ($firstLevel + 1) && isset($l2_arr) && isset($l2_aItem)) {
            $l2_i++;
            if ($l2_arr[$l2_aItem] === $l2_i) {
                echo '</ul></div><div><ul class="uk-nav uk-navbar-dropdown-nav">';
                $l2_i = 0;
                $l2_aItem++;
            }
        }
    }
}

echo '</ul>';
