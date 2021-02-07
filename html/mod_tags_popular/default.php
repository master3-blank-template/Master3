<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_tags_popular
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');

?>
<div class="tagspopular<?php echo $moduleclass_sfx; ?>">
    <?php if (!count($list)) { ?>
    <div class="uk-text-muted"><?php echo Text::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></div>
    <?php } else { ?>
    <ul class="uk-list">
        <?php foreach ($list as $item) { ?>
        <li>
            <a href="<?php echo Route::_(TagsHelperRoute::getTagRoute($item->tag_id . ':' . $item->alias)); ?>" rel="tag"><?php echo htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8'); ?></a>
            <?php if ($display_count) { ?>
            <span class="tag-count uk-badge"><?php echo $item->count; ?></span>
            <?php } ?>
        </li>
        <?php } ?>
    </ul>
    <?php } ?>
</div>
