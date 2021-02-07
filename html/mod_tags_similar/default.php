<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_tags_similar
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
<div class="tagssimilar<?php echo $moduleclass_sfx; ?>">
<?php if ($list) { ?>
    <ul class="uk-list">
    <?php foreach ($list as $i => $item) { ?>
        <li>
            <?php
            if (($item->type_alias === 'com_users.category') || ($item->type_alias === 'com_banners.category')) {
                if (!empty($item->core_title)) {
                    echo htmlspecialchars($item->core_title, ENT_COMPAT, 'UTF-8');
                }
            } else {
                if (!empty($item->core_title)) {
                    ?>
            <a href="<?php echo Route::_($item->link); ?>" rel="tag"><?php echo htmlspecialchars($item->core_title, ENT_COMPAT, 'UTF-8'); ?></a>
            <?php

        }
    }
    ?>
        </li>
    <?php } ?>
    </ul>
    <?php } else { ?>
    <div class="uk-text-muted"><?php echo Text::_('MOD_TAGS_SIMILAR_NO_MATCHING_TAGS'); ?></div>
    <?php } ?>
</div>
