<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

JLoader::register('ContentHelperRoute', JPATH_SITE . '/components/com_content/helpers/route.php');

if ($this->params->get('show_articles')) {
?>
<ul class="uk-list">
    <?php foreach ($this->item->articles as $article) { ?>
    <li>
        <?php echo HTMLHelper::_('link', Route::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)), htmlspecialchars($article->title, ENT_COMPAT, 'UTF-8')); ?>
    </li>
    <?php } ?>
</ul>
<?php
}
