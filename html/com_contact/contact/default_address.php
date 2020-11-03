<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\String\PunycodeHelper;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

?>

<dl class="uk-description-list" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
    <?php
    if (($this->params->get('address_check') > 0) && ($this->contact->address || $this->contact->suburb || $this->contact->state || $this->contact->country || $this->contact->postcode)) {
        $address = [];
        if ($this->contact->address && $this->params->get('show_street_address')) {
            $address[] = '<span itemprop="streetAddress">' . $this->contact->address . '</span>';
        }
        if ($this->contact->suburb && $this->params->get('show_suburb')) {
            $address[] = '<span itemprop="addressLocality">' . $this->contact->suburb . '</span>';
        }
        if ($this->contact->state && $this->params->get('show_state')) {
            $address[] = '<span itemprop="addressRegion">' . $this->contact->state . '</span>';
        }
        if ($this->contact->country && $this->params->get('show_country')) {
            $address[] = '<span itemprop="addressCountry">' . $this->contact->country . '</span>';
        }
        if ($this->contact->postcode && $this->params->get('show_postcode')) {
            $address[] = '<span itemprop="postalCode">' . $this->contact->postcode . '</span>';
        }
        $address = implode(', ', $address);
        ?>
    <dt><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:location"></span>' : ''), Text::_('COM_CONTACT_ADDRESS'); ?>:</dt>
    <dd><?php echo $address; ?></dd>
    <?php
    }

    if ($this->contact->email_to && $this->params->get('show_email')) {
    ?>
    <dt><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:main"></span>' : ''), Text::_('COM_CONTACT_EMAIL_LABEL'); ?>:</dt>
    <dd itemprop="email"><?php echo $this->contact->email_to; ?></dd>
    <?php
    }

    if ($this->contact->telephone && $this->params->get('show_telephone')) {
    ?>
    <dt><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:receiver"></span>' : ''), Text::_('COM_CONTACT_TELEPHONE'); ?>:</dt>
    <dd itemprop="telephone"><?php echo $this->contact->telephone; ?></dd>
    <?php
    }

    if ($this->contact->fax && $this->params->get('show_fax')) {
    ?>
    <dt><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:receiver"></span>' : ''), Text::_('COM_CONTACT_FAX'); ?>:</dt>
    <dd itemprop="faxNumber"><?php echo $this->contact->fax; ?></dd>
    <?php
    }

    if ($this->contact->mobile && $this->params->get('show_mobile')) {
    ?>
    <dt><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:phone"></span>' : ''), Text::_('COM_CONTACT_MOBILE'); ?>:</dt>
    <dd itemprop="telephone"><?php echo $this->contact->mobile; ?></dd>
    <?php
    }

    if ($this->contact->webpage && $this->params->get('show_webpage')) {
    ?>
    <dt><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:world"></span>' : ''), Text::_('URL'); ?>:</dt>
    <dd><a href="<?php echo $this->contact->webpage; ?>" target="_blank" rel="noopener noreferrer" itemprop="url"><?php echo PunycodeHelper::urlToUTF8($this->contact->webpage); ?></a></dd>
    <?php } ?>
</dl>
