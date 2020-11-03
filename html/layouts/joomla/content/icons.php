<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$canEdit = $displayData['params']->get('access-edit');
$articleId = $displayData['item']->id;

?>
<div class="uk-margin-small uk-flex">
    <?php
    if (empty($displayData['print'])) {
        if ($canEdit || $displayData['params']->get('show_print_icon') || $displayData['params']->get('show_email_icon')) {
            if ($displayData['params']->get('show_print_icon')) {
                echo HTMLHelper::_('icon.print_popup', $displayData['item'], $displayData['params'], ['class' => 'uk-button uk-button-link uk-margin-small-right', 'data-uk-tooltip' => str_replace(['<', '>'], ['«', '»'], Text::sprintf('JGLOBAL_PRINT_TITLE', $displayData['item']->title))]);
            }

            if ($displayData['params']->get('show_email_icon')) {
                echo HTMLHelper::_('icon.email', $displayData['item'], $displayData['params'], ['class' => 'uk-button uk-button-link uk-margin-small-right', 'data-uk-tooltip' => Text::_('JGLOBAL_EMAIL_TITLE')]);
            }

            if ($canEdit) {
                echo HTMLHelper::_('icon.edit', $displayData['item'], $displayData['params'], ['class' => 'uk-button uk-button-link', 'data-uk-tooltip' => Text::_('JGLOBAL_EDIT_TITLE')]);
            }
        }
    } else {
        echo HTMLHelper::_('icon.print_screen', $displayData['item'], $displayData['params'], ['class' => 'uk-button uk-button-link', 'data-uk-tooltip' => str_replace(['<', '>'], ['«', '»'], Text::sprintf('JGLOBAL_PRINT_TITLE', $displayData['item']->title))]);
    }
    ?>
</div>
