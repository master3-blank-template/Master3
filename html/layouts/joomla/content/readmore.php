<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$params = $displayData['params'];
$item = $displayData['item'];
$direction = Factory::getLanguage()->isRtl() ? 'left' : 'right';
?>

<p class="uk-margin-small uk-flex uk-flex-right">
    <?php if (!$params->get('access-view')) { ?>
        <a class="uk-button uk-button-link uk-button-small" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
            <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
        </a>
    <?php } elseif ($readmore = $item->alternative_readmore) { ?>
        <a class="uk-button uk-button-link uk-button-small" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo $readmore; ?>
            <?php if ($params->get('show_readmore_title', 0) != 0) { ?>
                <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
            <?php
        } ?>
        </a>
        <?php } elseif ($params->get('show_readmore_title', 0) == 0) { ?>
        <a class="uk-button uk-button-link uk-button-small" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo Text::_('COM_CONTENT_READ_MORE'); ?> <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo Text::sprintf('COM_CONTENT_READ_MORE_TITLE'); ?>
        </a>
    <?php } else { ?>
        <a class="uk-button uk-button-link uk-button-small" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo Text::_('COM_CONTENT_READ_MORE'); ?> <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo Text::_('COM_CONTENT_READ_MORE'); ?>
            <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
        </a>
    <?php } ?>
</p>
