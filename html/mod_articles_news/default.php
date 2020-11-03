<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

?>
<div class="uk-list newsflash<?php echo $moduleclass_sfx; ?>">
    <?php
    foreach ($list as $item) {
        require ModuleHelper::getLayoutPath('mod_articles_news', '_item');
    }
    ?>
</div>
