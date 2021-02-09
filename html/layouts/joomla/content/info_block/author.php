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

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

?>
<div class="createdby" itemprop="author" itemscope itemtype="https://schema.org/Person">
    <?php
    if ($jsIcons !== 'none') {
        echo '<span data-uk-icon="icon:user"></span> ';
    }
    $author = ($displayData['item']->created_by_alias ? : $displayData['item']->author);
    $author = '<span itemprop="name">' . $author . '</span>';
    if (!empty($displayData['item']->contact_link) && $displayData['params']->get('link_author') == true) {
        echo Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url')));
    } else {
        echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author);
    }
    ?>
</div>
