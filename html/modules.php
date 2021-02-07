<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');

function modChrome_master3($module, &$params, &$attribs)
{
    $config = \Master3Config::getInstance();
    $masterParams = $config->getModuleParams($module->id);

    $moduleTag = 'div';
    if ($module->module === 'mod_menu') {
        $moduleTag = 'nav';
    }

    $moduleClass = [];
    $moduleClass[] = 'tm-pos-' . $module->position;
    $moduleClass[] = trim($masterParams->display);
    $moduleClass[] = trim($masterParams->class);
    $moduleClass[] = $masterParams->align !== '' ? 'uk-flex ' . $masterParams->align . ' uk-width' : '';
    $moduleClass = trim(implode(' ', $moduleClass));

    $moduleDataAttrs = $masterParams->dataAttrs ? ' ' . $masterParams->dataAttrs : '';

    $titleTag = $masterParams->titleTag !== 'module' ? $masterParams->titleTag : htmlspecialchars($params->get('header_tag', 'h3'));
    $titleClass = trim($masterParams->titleClass . ' ' . htmlspecialchars($params->get('header_class', ''), ENT_COMPAT, 'UTF-8'));
    $titleClass = $titleClass ? ' class="' . $titleClass . '"' : '';

    if ($module->content) {
        echo '<div><' . $moduleTag . ' class="' . trim($moduleClass) . '"' . $moduleDataAttrs . '>';

        if ($module->showtitle && $masterParams->titleTag !== 'none') {
            echo '<' . $titleTag . $titleClass . '>' . $module->title . '</' . $titleTag . '>';
        }

        echo str_replace(["<div >\r\n    ", "<div >\n    ", "</div>\r\n", "</div>\n", "</div>\r"], ['<div>', '<div>', '</div>', '</div>', '</div>'], $module->content);

        echo '</' . $moduleTag . '></div>';
    }
}


function modChrome_navbar($module, &$params, &$attribs)
{
    $config = \Master3Config::getInstance();
    $masterParams = $config->getModuleParams($module->id);

    $moduleTag = 'div';
    $moduleClass = [];
    $moduleClass[] = 'tm-pos-' . $module->position;
    $moduleClass[] = $module->module === 'mod_menu' && in_array($module->position, ['navbar-left', 'navbar-center', 'narbar-right']) ? '' : 'uk-navbar-item';
    $moduleClass[] = $masterParams->align !== '' ? 'uk-flex ' . $masterParams->align . ' uk-width' : '';
    $moduleClass = trim(implode(' ', $moduleClass));

    $moduleDataAttrs = $masterParams->dataAttrs ? ' ' . $masterParams->dataAttrs : '';

    if ($module->content) {

        if ($module->module === 'mod_menu') {
            $sfx = $config->getOffcanvasToggle();

            $moduleTag = 'nav';

            if ($masterParams->offtoggle) {
                $moduleClass .= ' uk-visible' . $sfx;
                echo '<a class="uk-navbar-toggle uk-hidden' . $sfx . '" href="#" data-uk-navbar-toggle-icon data-uk-toggle="target:#' . $masterParams->offtoggle . '" aria-label="Menu"></a>';
            }
        } else {
            $moduleClass .= ' ' . $config->getModuleParams($module->id)->display;
        }

        echo '<div><' . $moduleTag . ' class="' . trim($moduleClass) . '"' . $moduleDataAttrs . '>';

        echo str_replace(["<div >\r\n    ", "<div >\n    ", "</div>\r\n", "</div>\n", "</div>\r"], ['<div>', '<div>', '</div>', '</div>', '</div>'], $module->content);

        echo '</' . $moduleTag . '></div>';
    }
}


function modChrome_empty($module, &$params, &$attribs)
{
    echo str_replace(["<div >\r\n    ", "<div >\n    ", "</div>\r\n", "</div>\n", "</div>\r"], ['<div>', '<div>', '</div>', '</div>', '</div>'], $module->content);
}
