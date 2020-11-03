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
<ul class="uk-flex uk-flex-wrap newsflash-horiz<?php echo $params->get('moduleclass_sfx'); ?>">
    <?php
    for ($i = 0, $n = count($list); $i < $n; $i++) {
        $item = $list[$i];
    ?>
    <li>
        <?php
        require ModuleHelper::getLayoutPath('mod_articles_news', '_item');
        if ($n > 1 && (($i < $n - 1) || $params->get('showLastSeparator'))) {
            echo '<span class="article-separator">&#160;</span>';
        }
        ?>
    </li>
    <?php } ?>
</ul>
