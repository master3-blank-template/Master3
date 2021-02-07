<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');

/**
 * This is a file to add template specific chrome to pagination rendering.
 * pagination_list_footer
 *     Input variable $list is an array with offsets:
 *         $list[ limit ]        : int
 *         $list[ limitstart ]    : int
 *         $list[ total ]        : int
 *         $list[ limitfield ]    : string
 *         $list[ pagescounter ]    : string
 *         $list[ pageslinks ]    : string
 * pagination_list_render
 *     Input variable $list is an array with offsets:
 *         $list[ all ]
 *             [ data ]        : string
 *             [ active ]    : boolean
 *         $list[ start ]
 *             [ data ]        : string
 *             [ active ]    : boolean
 *         $list[ previous ]
 *             [ data ]        : string
 *             [ active ]    : boolean
 *         $list[ next ]
 *             [ data ]        : string
 *             [ active ]    : boolean
 *         $list[ end ]
 *             [ data ]        : string
 *             [ active ]    : boolean
 *         $list[ pages ]
 *             [ {PAGE} ][ data ]        : string
 *             [ {PAGE} ][ active ]    : boolean
 * pagination_item_active
 *     Input variable $item is an object with fields:
 *         $item->base    : integer
 *         $item->link    : string
 *         $item->text    : string
 * pagination_item_inactive
 *     Input variable $item is an object with fields:
 *         $item->base    : integer
 *         $item->link    : string
 *         $item->text    : string
 * This gives template designers ultimate control over how pagination is rendered.
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */


/**
 * Renders the pagination footer
 * @param   array   $list  Array containing pagination footer
 * @return  string         HTML markup for the full pagination footer
 * @since   3.0
 */
function pagination_list_footer($list)
{
    $html = "<div>\n";
    $html .= $list['pageslinks'];
    $html .= "\n<input type=\"hidden\" name=\"" . $list['prefix'] . "limitstart\" value=\"" . $list['limitstart'] . "\">";
    $html .= "\n</div>";

    return $html;
}

/**
 * Renders the pagination list
 * @param   array   $list  Array containing pagination information
 * @return  string         HTML markup for the full pagination object
 * @since   3.0
 */
function pagination_list_render($list)
{
    $currentId = 0;
    $range = 3;

    foreach ($list['pages'] as $id => $page) {
        if (!$page['active']) {
            $currentId = $id;
        }
    }

    $html = [];
    $html[] = '<ul class="uk-pagination">';

    if ($list['start']['active'] == 1) {
        $html[] = $list['start']['data'];
    }

    if ($list['previous']['active'] == 1) {
        $html[] = $list['previous']['data'];
    }

    foreach ($list['pages'] as $id => $page) {
        if ($id <= $currentId + $range && $id >= $currentId - $range) {
            $html[] = $page['data'];
        }
    }

    if ($list['next']['active'] == 1) {
        $html[] = $list['next']['data'];
    }

    if ($list['end']['active'] == 1) {
        $html[] = $list['end']['data'];
    }

    $html[] = "</ul>";

    return implode("\n", $html);
}

/**
 * Renders an active item in the pagination block
 * @param   PaginationObject  $item  The current pagination object
 * @return  string                    HTML markup for active item
 * @since   3.0
 */
function pagination_item_active(&$item)
{
    $config = \Master3Config::getInstance();
    $jsIcons = $config->params->get('jsIcons', 'none');

    $cls = '';
    $title = '';
    $name = '';

    if ($item->text == Text::_('JNEXT')) {
        $item->text = $jsIcons !== 'none' ? '<span data-uk-pagination-next></span>' : $item->text;
        $cls = "next";
        $title = Text::_('JNEXT');
    } else if ($item->text == Text::_('JPREV')) {
        $item->text = $jsIcons !== 'none' ? '<span data-uk-pagination-previous></span>' : $item->text;
        $cls = "previous";
        $title = Text::_('JPREV');
    } else if ($item->text == Text::_('JLIB_HTML_START')) {
        $item->text = $jsIcons !== 'none' ? '<span data-uk-icon="icon:chevron-double-left"></span>' : $item->text;
        $cls = "first";
        $title = Text::_('JLIB_HTML_START');
    } else if ($item->text == Text::_('JLIB_HTML_END')) {
        $item->text = $jsIcons !== 'none' ? '<span data-uk-icon="icon:chevron-double-right"></span>' : $item->text;
        $cls = "last";
        $title = Text::_('JLIB_HTML_END');
    } else {
        $name = ' aria-label="' . Text::sprintf('JLIB_HTML_GOTO_PAGE', $item->text) . '"';
    }

    if ($cls) {
        $cls = ' class="' . $cls . '"';
        $name = ' aria-label="' . $title . '"';
        $title = ' data-uk-tooltip="' . $title . '"';
    }

    return '<li><a' . ' href="' . $item->link . '"' . $cls . $title . $name . '>' . $item->text . '</a></li>';
}

/**
 * Renders an inactive item in the pagination block
 * @param   PaginationObject  $item  The current pagination object
 * @return  string  HTML markup for inactive item
 * @since   3.0
 */
function pagination_item_inactive(&$item)
{
    return '<li class="uk-active"><span>' . $item->text . '</span></li>';
}
