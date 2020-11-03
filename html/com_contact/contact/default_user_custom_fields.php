<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$params = $this->item->params;
$presentation_style = $params->get('presentation_style');

$displayGroups = $params->get('show_user_custom_fields');
$userFieldGroups = [];


if (!$displayGroups || !$this->contactUser) {
    return;
}

foreach ($this->contactUser->jcfields as $field) {
    if (!in_array('-1', $displayGroups) && (!$field->group_id || !in_array($field->group_id, $displayGroups))) {
        continue;
    }
    if (!key_exists($field->group_title, $userFieldGroups)) {
        $userFieldGroups[$field->group_title] = [];
    }
    $userFieldGroups[$field->group_title][] = $field;
}

foreach ($userFieldGroups as $groupTitle => $fields) {
    $id = ApplicationHelper::stringURLSafe($groupTitle);

    if ($presentation_style === 'sliders') {
    ?>
    <li>
        <a class="uk-accordion-title" href="#"><?php echo $groupTitle ? : Text::_('COM_CONTACT_USER_FIELDS'); ?></a>
        <div class="uk-accordion-content">
    <?php
    } elseif ($presentation_style === 'tabs') {
        if (!$tabSetStarted) {
            echo HTMLHelper::_('bootstrap.startTabSet', 'myTab', ['active' => 'display-' . $id]);
            $tabSetStarted = true;
        }
        echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'display-' . $id, $groupTitle ? : Text::_('COM_CONTACT_USER_FIELDS'));
    } elseif ($presentation_style === 'plain') {
    ?>
    <h3><?php echo $groupTitle ? : Text::_('COM_CONTACT_USER_FIELDS'); ?></h3>
    <?php } ?>

    <dl id="user-custom-fields-<?php echo $id; ?>" class="uk-desctiption-list">
        <?php
        foreach ($fields as $field) {
            if (!$field->value) {
                continue;
            }

            if ($field->params->get('showlabel')) {
                echo '<dt>' . Text::_($field->label) . '</dt>';
            }

            echo '<dd>' . $field->value . '</dd>';
        }
        ?>
    </dl>

    <?php
    if ($presentation_style === 'sliders') {
    ?>
        </div>
    </li>
    <?php
    } elseif ($presentation_style === 'tabs') {
        echo HTMLHelper::_('bootstrap.endTab');
    }
}
