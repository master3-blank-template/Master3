<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$links = [];

// Letters 'a' to 'e'
foreach (range('a', 'e') as $char) {
    $link = $this->contact->params->get('link' . $char);
    $label = $this->contact->params->get('link' . $char . '_name');

    if (!$link) {
        continue;
    }

    $link = (0 === strpos($link, 'http')) ? $link : '//' . $link;

    $label = $label ? : $link;
    $links[] = '<li><a href="' . $link . '" itemprop="url">' . $label . '</a></li>';
}

if ($links) {
    if ($this->params->get('presentation_style') === 'sliders') {
?>
<li>
    <a class="uk-accordion-title" href="#"><?php echo Text::_('COM_CONTACT_LINKS'); ?></a>
    <div class="uk-accordion-content">
    <?php
    } elseif ($this->params->get('presentation_style') === 'tabs') {
        if (!$tabSetStarted) {
            echo HTMLHelper::_('bootstrap.startTabSet', 'myTab', ['active' => 'basic-links']);
            $tabSetStarted = true;
        }
        echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'display-links', Text::_('COM_CONTACT_LINKS'));
    } elseif ($this->params->get('presentation_style') === 'plain') {
    ?>
    <h3><?php echo Text::_('COM_CONTACT_LINKS'); ?></h3>
    <?php } ?>

    <ul class="uk-list"><?php echo implode('', $links); ?></ul>

    <?php if ($this->params->get('presentation_style') === 'sliders') { ?>
    </div>
</li>
<?php
    } elseif ($this->params->get('presentation_style') === 'tabs') {
        echo HTMLHelper::_('bootstrap.endTab');
    }
}
