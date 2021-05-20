<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

if (file_exists(realpath(__DIR__ . '/layouts/template.error.php'))) {
    include(realpath(__DIR__ . '/layouts/template.error.php'));
} else if (file_exists(realpath(__DIR__ . '/layouts/template.error-original.php'))) {
    include(realpath(__DIR__ . '/layouts/template.error-original.php'));
}
