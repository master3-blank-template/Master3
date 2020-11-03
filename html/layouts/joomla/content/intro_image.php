<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Router\Route;

$params = $displayData->params;

$images = json_decode($displayData->images);

if (isset($images->image_intro) && !empty($images->image_intro)) {
    $imgfloat = empty($images->float_intro) ? $params->get('float_intro') : $images->float_intro;
    $alt = $images->image_intro_alt ?: $displayData->title;
?>
<div class="uk-align-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?> item-image">
    <?php if ($params->get('link_titles') && $params->get('access-view')) { ?>
    <a href="<?php echo Route::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>">
        <img <?php if ($images->image_intro_caption) {
                echo 'class="caption" title="' . htmlspecialchars($images->image_intro_caption) . '"';
            } ?> src="<?php echo htmlspecialchars($images->image_intro, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($alt, ENT_COMPAT, 'UTF-8'); ?>" itemprop="thumbnailUrl" loading="lazy"></a>
    <?php } else { ?>
    <img <?php if ($images->image_intro_caption) {
            echo 'class="caption" title="' . htmlspecialchars($images->image_intro_caption, ENT_COMPAT, 'UTF-8') . '"';
        } ?> src="<?php echo htmlspecialchars($images->image_intro, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($alt, ENT_COMPAT, 'UTF-8'); ?>" itemprop="thumbnailUrl" loading="lazy">
    <?php } ?>
</div>
<?php
}
