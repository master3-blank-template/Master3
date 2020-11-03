<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;

$pos = $templateConfig->params->get('systemmsgPos', 'top-right');
$timeout = (int)$templateConfig->params->get('systemmsgTimeout', 5) * 1000;

$buffer = [];

if (is_array($msgList) && count($msgList)) {
    $buffer[] = '<script>';

    foreach ($msgList as $type => $msgs) {
        $msgtype = $type;
        $htype = '';

        if ($msgtype == 'message') $msgtype = 'success';
        if ($msgtype == 'notice') $msgtype = 'primary';
        if ($msgtype == 'warning') $msgtype = 'warning';
        if ($msgtype == 'error') $msgtype = 'danger';

        if ($msgtype) {
            $htype = ' uk-text-' . $msgtype;
        }

        $text = '';
        if (count($msgs)) {
            $text = '<p class=\"uk-h3' . $htype . '\">' . Text::_($type) . '</p>';

            foreach ($msgs as $msg) {
                $text .= '<p>' . $msg . '</p>';
            }
        }

        $buffer[] = 'UIkit.notification("' . $text . '", {status:\'' . $msgtype . '\',pos:\'' . $pos . '\',timeout:' . $timeout . ',group:\'system-messages\'});';
    }

    $buffer[] = '</script>';
}

echo implode("\n", $buffer);
