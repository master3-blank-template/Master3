<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;

$buffer = [];

if (is_array($msgList) && count($msgList)) {

    foreach ($msgList as $type => $msgs) {
        $msgtype = $type;
        $htype = '';

        if ($msgtype == 'message') $msgtype = 'success';
        if ($msgtype == 'notice') $msgtype = 'primary';
        if ($msgtype == 'warning') $msgtype = 'warning';
        if ($msgtype == 'error') $msgtype = 'danger';

        if ($msgtype) {
            $msgtype = ' uk-alert-' . $msgtype;
            $htype = ' uk-text-' . $msgtype;
        }

        $buffer[] = '<div class="uk-margin-remove uk-alert-large' . $msgtype . '" data-uk-alert>';
        $buffer[] = '<div class="uk-container">';
        $buffer[] = '<div class="uk-panel">';

        $buffer[] = '<a class="uk-alert-close" data-uk-close></a>';

        if (count($msgs)) {
            $buffer[] = '<p class="uk-h3' . $htype . '">' . Text::_($type) . '</p>';

            foreach ($msgs as $msg) {
                $buffer[] = '<p>' . $msg . '</p>';
            }
        }

        $buffer[] = '</div></div></div>';
    }

}

echo implode('', $buffer);
