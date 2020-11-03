<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$params = $displayData->params;

$images = json_decode($displayData->images);

if (isset($images->image_fulltext) && !empty($images->image_fulltext)) {
    $imgfloat = empty($images->float_fulltext) ? $params->get('float_fulltext') : $images->float_fulltext;
    $alt = $images->image_fulltext_alt ?: $displayData->title;
    ?>
<div class="uk-align-<?php echo htmlspecialchars($imgfloat, ENT_COMPAT, 'UTF-8'); ?> item-image">
    <img <?php if ($images->image_fulltext_caption) {
            echo 'class="caption" title="' . htmlspecialchars($images->image_fulltext_caption, ENT_COMPAT, 'UTF-8') . '"';
        } ?> src="<?php echo htmlspecialchars($images->image_fulltext, ENT_COMPAT, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($alt, ENT_COMPAT, 'UTF-8'); ?>" itemprop="image" loading="lazy">
</div>
<?php
}
