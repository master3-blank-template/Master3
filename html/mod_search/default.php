<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;

?>
<div class="search<?php echo $moduleclass_sfx; ?>">
    <form id="mod-search-<?php echo $module->id ?>" action="<?php echo Route::_('index.php'); ?>" method="post" class="uk-search uk-search-default">
        <?php
        $output = '<input name="searchword" id="mod-search-searchword-' . $module->id . '" maxlength="' . $maxlength . '"  class="uk-search-input uk-form-width-medium search-query input-medium" type="search" placeholder="' . $text . '">';

        $btn_output = '';
        if ($button) {
            $btn_output = '<a href="#"' . ($button_pos == 'right' ? ' class="uk-search-icon-flip"' : '') . ' onclick="document.getElementById(\'mod-search-' . $module->id . '\').submit();" data-uk-search-icon></a>';
        }

        echo $btn_output . $output;
        ?>
        <input type="hidden" name="task" value="search">
        <input type="hidden" name="option" value="com_search">
        <input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>">
    </form>
</div>
