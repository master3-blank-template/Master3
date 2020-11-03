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
use Joomla\CMS\Filesystem\Path;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateName = \Master3Config::getTemplateName();

$item = $displayData;

if ($item->language === '*') {
    echo Text::alt('JALL', 'language');
} elseif ($item->language_image) {
    $lang_image = realpath(Path::clean(JPATH_ROOT . '/templates/' . $templateName . '/html/mod_languages/images/' . $language->image . '.svg'));
    if ($lang_image) {
        echo '<span class="uk-border-circle uk-display-inline-block" style="width:1em;">' . file_get_contents($lang_image) . '</span>';;
    } else {
        echo HTMLHelper::_('image', 'mod_languages/' . $item->language_image . '.gif', '', null, true);
    }
    echo '&nbsp;' . htmlspecialchars($item->language_title, ENT_COMPAT, 'UTF-8');
} elseif ($item->language_title) {
    echo htmlspecialchars($item->language_title, ENT_COMPAT, 'UTF-8');
} else {
    echo Text::_('JUNDEFINED');
}
