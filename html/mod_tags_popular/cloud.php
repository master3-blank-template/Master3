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

$minsize = $params->get('minsize', 1);
$maxsize = $params->get('maxsize', 2);

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');

?>
<div class="tagspopular<?php echo $moduleclass_sfx; ?> tagscloud<?php echo $moduleclass_sfx; ?>">
<?php if (!count($list)) { ?>
    <div class="uk-text-muted"><?php echo Text::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></div>
<?php } else { ?>
    <div class="uk-flex uk-flex-wrap" data-uk-margin>
        <?php
        $mincount = null;
        $maxcount = null;
        foreach ($list as $item) {
            if ($mincount === null || $mincount > $item->count) {
                $mincount = $item->count;
            }
            if ($maxcount === null || $maxcount < $item->count) {
                $maxcount = $item->count;
            }
        }
        $countdiff = $maxcount - $mincount;

        foreach ($list as $item) {
            if ($countdiff === 0) {
                $fontsize = $minsize;
            } else {
                $fontsize = $minsize + (($maxsize - $minsize) / $countdiff) * ($item->count - $mincount);
            }
            ?>
        <span class="tag uk-margin-small-right">
            <a class="tag-name" style="font-size: <?php echo $fontsize . 'em'; ?>" href="<?php echo Route::_(TagsHelperRoute::getTagRoute($item->tag_id . ':' . $item->alias)); ?>" rel="tag"><?php echo htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8'); ?></a>
            <?php if ($display_count) { ?>
                <span class="tag-count uk-badge"><?php echo $item->count; ?></span>
            <?php } ?>
        </span>
        <?php } ?>
    </div>
    <?php } ?>
</div>
