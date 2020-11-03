<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

// Create a shortcut for params.
$params = &$this->item->params;

if (empty($this->items)) {
?>
<div class="uk-alert"><?php echo Text::_('COM_CONTACT_NO_CONTACTS'); ?></div>
<?php } else { ?>
<table class="uk-table uk-table-striped uk-table-responsive uk-table-hover">

    <?php if ($this->params->get('show_headings')) { ?>
    <thead>
        <tr>
            <th><?php echo Text::_('JGLOBAL_NUM'); ?></th>

            <th><?php echo Text::_('COM_CONTACT_CONTACT_EMAIL_NAME_LABEL'); ?></th>

            <?php if ($this->params->get('show_position_headings')) { ?>
            <th><?php echo Text::_('COM_CONTACT_POSITION'); ?></th>
            <?php } ?>

            <?php if ($this->params->get('show_email_headings')) { ?>
            <th><?php echo Text::_('JGLOBAL_EMAIL'); ?></th>
            <?php } ?>

            <?php if ($this->params->get('show_telephone_headings')) { ?>
            <th><?php echo Text::_('COM_CONTACT_TELEPHONE'); ?></th>
            <?php } ?>

            <?php if ($this->params->get('show_mobile_headings')) { ?>
            <th><?php echo Text::_('COM_CONTACT_MOBILE'); ?></th>
            <?php } ?>

            <?php if ($this->params->get('show_fax_headings')) { ?>
            <th><?php echo Text::_('COM_CONTACT_FAX'); ?></th>
            <?php } ?>

            <?php if ($this->params->get('show_suburb_headings')) { ?>
            <th><?php echo Text::_('COM_CONTACT_SUBURB'); ?></th>
            <?php } ?>

            <?php if ($this->params->get('show_state_headings')) { ?>
            <th><?php echo Text::_('COM_CONTACT_STATE'); ?></th>
            <?php } ?>

            <?php if ($this->params->get('show_country_headings')) { ?>
            <th><?php echo Text::_('COM_CONTACT_COUNTRY'); ?></th>
            <?php } ?>

        </tr>
    </thead>
    <?php } ?>

    <tbody>
        <?php foreach ($this->items as $i => $item) { ?>
        <tr itemscope itemtype="https://schema.org/Person">

            <td><?php echo $i; ?></td>

            <td>
                <?php if ($this->items[$i]->published == 0) { ?>
                <span class="label label-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
                <?php } ?>
                <a href="<?php echo Route::_(ContactHelperRoute::getContactRoute($item->slug, $item->catid)); ?>" itemprop="url"><span itemprop="name"><?php echo $item->name; ?></span></a>
            </td>

            <?php if ($this->params->get('show_position_headings')) { ?>
            <td itemprop="jobTitle"><?php echo $item->con_position; ?></td>
            <?php } ?>

            <?php if ($this->params->get('show_email_headings')) { ?>
            <td itemprop="email"><?php echo $item->email_to; ?></td>
            <?php } ?>

            <?php if ($this->params->get('show_telephone_headings')) { ?>
            <td itemprop="telephone"><?php echo $item->telephone; ?></td>
            <?php } ?>

            <?php if ($this->params->get('show_mobile_headings')) { ?>
            <td itemprop="telephone"><?php echo $item->mobile; ?></td>
            <?php } ?>

            <?php if ($this->params->get('show_fax_headings')) { ?>
            <td itemprop="faxNumber"><?php echo $item->fax; ?></td>
            <?php } ?>

            <?php if ($this->params->get('show_suburb_headings')) { ?>
            <td itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"><span itemprop="addressLocality"><?php echo $item->suburb; ?></span></td>
            <?php } ?>

            <?php if ($this->params->get('show_state_headings')) { ?>
            <td itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"><span itemprop="addressRegion"><?php echo $item->state; ?></span></td>
            <?php } ?>

            <?php if ($this->params->get('show_country_headings')) { ?>
            <td itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"><span itemprop="addressCountry"><?php echo $item->country; ?></span></td>
            <?php } ?>

        </tr>
        <?php } ?>

    </tbody>
</table>
<?php
}
