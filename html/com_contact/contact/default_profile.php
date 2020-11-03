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
use Joomla\CMS\String\PunycodeHelper;
use Joomla\CMS\Plugin\PluginHelper;

if (PluginHelper::isEnabled('user', 'profile')) {
    $fields = $this->item->profile->getFieldset('profile');
?>
<dl class="uk-description-list">
    <?php
    foreach ($fields as $profile) {
        if ($profile->value) {
            echo '<dt>' . $profile->label . '</dt>';
            $profile->text = htmlspecialchars($profile->value, ENT_COMPAT, 'UTF-8');
            switch ($profile->id) {
                case 'profile_website':
                    $v_http = substr($profile->value, 0, 4);
                    if ($v_http === 'http') {
                        echo '<dd><a href="' . $profile->text . '">' . PunycodeHelper::urlToUTF8($profile->text) . '</a></dd>';
                    } else {
                        echo '<dd><a href="http://' . $profile->text . '">' . PunycodeHelper::urlToUTF8($profile->text) . '</a></dd>';
                    }
                    break;
                case 'profile_dob':
                    echo '<dd>' . HTMLHelper::_('date', $profile->text, Text::_('d.m.Y'), false) . '</dd>';
                    break;
                default:
                    echo '<dd>' . $profile->text . '</dd>';
                    break;
            }
        }
    }
    ?>
</dl>
<?php
}
