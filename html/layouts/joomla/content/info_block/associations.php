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
use Joomla\CMS\Router\Route;
use Joomla\CMS\Filesystem\Path;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateName = \Master3Config::getTemplateName();

if (!empty($displayData['item']->associations)) {
    $associations = $displayData['item']->associations;
    ?>

<div class="association">
    <?php
    echo Text::_('JASSOCIATIONS');
    foreach ($associations as $association) {
        if ($displayData['item']->params->get('flags', 1) && $association['language']->image) {
            $lang_image = realpath(Path::clean(JPATH_ROOT . '/templates/' . $templateName . '/html/mod_languages/images/' .  $association['language']->image . '.svg'));
            if ($lang_image) {
                $flag = '<span class="uk-border-circle uk-flex-inline" style="width:1em;">' . file_get_contents($lang_image) . '</span>';
            } else {
                $flag = HTMLHelper::_('image', 'mod_languages/' .  $association['language']->image . '.gif', '', null, true);
            }
            echo '&nbsp;<a href="' . Route::_($association['item']) . '" data-uk-tooltip="' . $association['language']->title_native . '">' . $flag . '</a>&nbsp;';
        } else {
            $class = 'label label-association label-' . $association['language']->sef;
            echo '&nbsp;<a class="' . $class . '" href="' . Route::_($association['item']) . '">' . strtoupper($association['language']->sef) . '</a>&nbsp;';
        }
    }
    ?>
</div>
<?php
}
