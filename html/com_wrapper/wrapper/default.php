<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_wrapper
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('script', 'com_wrapper/iframe-height.min.js', ['version' => 'auto', 'relative' => true]);

$title = $this->escape($this->params->get('page_heading')) ? $this->escape($this->params->get('page_heading')) : $this->escape($this->params->get('page_title'));

?>
<div class="uk-article <?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $title; ?></h1>
    <?php } ?>

    <iframe <?php echo $this->wrapper->load; ?>
        id="blockrandom"
        name="iframe"
        src="<?php echo $this->escape($this->wrapper->url); ?>"
        width="<?php echo $this->escape($this->params->get('width')); ?>"
        height="<?php echo $this->escape($this->params->get('height')); ?>"
        scrolling="<?php echo $this->escape($this->params->get('scrolling')); ?>"
        frameborder="<?php echo $this->escape($this->params->get('frameborder', 1)); ?>"
        title="<?php echo $title; ?>"
        class="wrapper<?php echo $this->pageclass_sfx; ?>"
    >
        <?php echo Text::_('COM_WRAPPER_NO_IFRAMES'); ?>
    </iframe>

</div>
