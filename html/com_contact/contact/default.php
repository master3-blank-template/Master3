<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.html.html.bootstrap');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Layout\FileLayout;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

$tparams = $this->item->params;

?>

<div class="contact<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Person">

    <?php if ($this->contact->name && $tparams->get('show_name')) { ?>
    <h1 class="uk-article-title">
        <?php if ($this->item->published == 0) { ?>
        <span class="label label-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
        <?php } ?>
        <span class="contact-name" itemprop="name"><?php echo $this->contact->name; ?></span>
    </h1>
    <?php } elseif ($tparams->get('show_page_heading')) { ?>
    <h1 class="uk-article-title"><?php echo $this->escape($tparams->get('page_heading')); ?></h1>
    <?php
    }

    $show_contact_category = $tparams->get('show_contact_category');

    if ($show_contact_category === 'show_no_link') {
        ?>
        <h3><?php echo $this->contact->category_title; ?></h3>
        <?php

    } elseif ($show_contact_category === 'show_with_link') {
        $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid);
    ?>
    <h3><a href="<?php echo $contactLink; ?>"><?php echo $this->escape($this->contact->category_title); ?></a></h3>
    <?php
    }

    echo $this->item->event->afterDisplayTitle;

    if ($tparams->get('show_contact_list') && count($this->contacts) > 1) {
        ?>
        <form action="#" method="get" name="selectForm" id="selectForm" class="uk-margin">
            <label for="select_contact" class="uk-form-label"><?php echo Text::_('COM_CONTACT_SELECT_CONTACT'); ?></label>
            <?php echo HTMLHelper::_('select.genericlist', $this->contacts, 'select_contact', 'class="uk-select uk-form-width-medium" onchange="document.location.href=this.value"', 'link', 'name', $this->contact->link); ?>
        </form>
        <?php

    }

    if ($tparams->get('show_tags', 1) && !empty($this->item->tags->itemTags)) {
        $this->item->tagLayout = new FileLayout('joomla.content.tags');
        echo $this->item->tagLayout->render($this->item->tags->itemTags);
    }

    echo $this->item->event->beforeDisplayContent;

    $presentation_style = $tparams->get('presentation_style');
    $tabSetStarted = false;

    if ($presentation_style === 'sliders') {
    ?>
    <ul data-uk-accordion>
    <?php
    }


    // info
    if ($this->params->get('show_info', 1)) {

        if ($presentation_style === 'sliders') {
        ?>
        <li>
            <a class="uk-accordion-title" href="#"><?php echo Text::_('COM_CONTACT_DETAILS'); ?></a>
            <div class="uk-accordion-content">
        <?php
        } elseif ($presentation_style === 'tabs') {
            echo HTMLHelper::_('bootstrap.startTabSet', 'myTab', ['active' => 'basic-details']);
            $tabSetStarted = true;
            echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'basic-details', Text::_('COM_CONTACT_DETAILS'));
        } elseif ($presentation_style === 'plain') {
        ?>
        <h3><?php echo Text::_('COM_CONTACT_DETAILS'); ?></h3>
        <?php
        }

        if ($this->contact->image && $tparams->get('show_image')) {
        ?>
        <div class="uk-align-right">
            <?php echo HTMLHelper::_('image', $this->contact->image, $this->contact->name, ['itemprop' => 'image']); ?>
        </div>
        <?php
        }

        if ($this->contact->con_position && $tparams->get('show_position')) {
        ?>
        <dl class="uk-description-list">
            <dt><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:cog"></span>' : ''), Text::_('COM_CONTACT_POSITION'); ?>:</dt>
            <dd itemprop="jobTitle"><?php echo $this->contact->con_position; ?></dd>
        </dl>
        <?php
        }

        echo $this->loadTemplate('address');

        if ($tparams->get('allow_vcard')) {
        ?>
        <div class="uk-margin-top">
            <a class="uk-button uk-button-link" href="<?php echo Route::_('index.php?option=com_contact&amp;view=contact&amp;id=' . $this->contact->id . '&amp;format=vcf'); ?>"><?php echo Text::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS'); ?> <?php echo Text::_('COM_CONTACT_VCARD'); ?></a>
        </div>
        <?php
        }

        if ($presentation_style === 'sliders') {
        ?>
            </div>
        </li>
        <?php
        } elseif ($presentation_style === 'tabs') {
            echo HTMLHelper::_('bootstrap.endTab');
        }
    }


    // form
    if ($tparams->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) {
        if ($presentation_style === 'sliders') {
        ?>
        <li>
            <a class="uk-accordion-title" href="#"><?php echo Text::_('COM_CONTACT_EMAIL_FORM'); ?></a>
            <div class="uk-accordion-content">
        <?php
        } elseif ($presentation_style === 'tabs') {
            if (!$tabSetStarted) {
                echo HTMLHelper::_('bootstrap.startTabSet', 'myTab', ['active' => 'basic-form']);
                $tabSetStarted = true;
            }
            echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'basic-form', Text::_('COM_CONTACT_EMAIL_FORM'));
        } elseif ($presentation_style === 'plain') {
        ?>
        <h3><?php echo Text::_('COM_CONTACT_EMAIL_FORM'); ?></h3>
        <?php
        }

        echo $this->loadTemplate('form');

        if ($presentation_style === 'sliders') {
        ?>
            </div>
        </li>
        <?php
        } elseif ($presentation_style === 'tabs') {
            echo HTMLHelper::_('bootstrap.endTab');
        }
    }


    // links
    if ($tparams->get('show_links')) {
        echo $this->loadTemplate('links');
    }


    // articles
    if ($tparams->get('show_articles') && $this->contact->user_id && $this->contact->articles) {
        if ($presentation_style === 'sliders') {
        ?>
        <li>
            <a class="uk-accordion-title" href="#"><?php echo Text::_('JGLOBAL_ARTICLES'); ?></a>
            <div class="uk-accordion-content">
        <?php
        } elseif ($presentation_style === 'tabs') {
            if (!$tabSetStarted) {
                echo HTMLHelper::_('bootstrap.startTabSet', 'myTab', ['active' => 'basic-articles']);
                $tabSetStarted = true;
            }
            echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'basic-articles', Text::_('JGLOBAL_ARTICLES'));
        } elseif ($presentation_style === 'plain') {
        ?>
        <h3><?php echo Text::_('JGLOBAL_ARTICLES'); ?></h3>
        <?php
        }

        echo $this->loadTemplate('articles');

        if ($presentation_style === 'sliders') {
        ?>
            </div>
        </li>
        <?php
        } elseif ($presentation_style === 'tabs') {
            echo HTMLHelper::_('bootstrap.endTab');
        }
    }


    // user profile
    if ($tparams->get('show_profile') && $this->contact->user_id && PluginHelper::isEnabled('user', 'profile')) {
        if ($presentation_style === 'sliders') {
        ?>
        <li>
            <a class="uk-accordion-title" href="#"><?php echo Text::_('COM_CONTACT_PROFILE'); ?></a>
            <div class="uk-accordion-content">
        <?php
        } elseif ($presentation_style === 'tabs') {
            if (!$tabSetStarted) {
                echo HTMLHelper::_('bootstrap.startTabSet', 'myTab', ['active' => 'basic-profile']);
                $tabSetStarted = true;
            }
            echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'basic-profile', Text::_('COM_CONTACT_PROFILE'));
        } elseif ($presentation_style === 'plain') {
        ?>
        <h3><?php echo Text::_('COM_CONTACT_PROFILE'); ?></h3>
        <?php
        }

        echo $this->loadTemplate('profile');

        if ($presentation_style === 'sliders') {
        ?>
            </div>
        </li>
        <?php
        } elseif ($presentation_style === 'tabs') {
            echo HTMLHelper::_('bootstrap.endTab');
        }
    }


    // custom fields
    if ($tparams->get('show_user_custom_fields') && $this->contactUser) {
        echo $this->loadTemplate('user_custom_fields');
    }


    // other misc
    if ($this->contact->misc && $tparams->get('show_misc')) {
        if ($presentation_style === 'sliders') {
        ?>
        <li>
            <a class="uk-accordion-title" href="#"><?php echo Text::_('COM_CONTACT_OTHER_INFORMATION'); ?></a>
            <div class="uk-accordion-content">
        <?php
        } elseif ($presentation_style === 'tabs') {
            if (!$tabSetStarted) {
                echo HTMLHelper::_('bootstrap.startTabSet', 'myTab', ['active' => 'basic-misc']);
                $tabSetStarted = true;
            }
            echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'basic-misc', Text::_('COM_CONTACT_OTHER_INFORMATION'));
        } elseif ($presentation_style === 'plain') {
        ?>
        <h3><?php echo Text::_('COM_CONTACT_OTHER_INFORMATION'); ?></h3>
        <?php
        }

        echo $this->contact->misc;

        if ($presentation_style === 'sliders') {
        ?>
            </div>
        </li>
        <?php
        } elseif ($presentation_style === 'tabs') {
            echo HTMLHelper::_('bootstrap.endTab');
        }
    }


    if ($presentation_style === 'sliders') {
    ?>
    </ul>
    <?php
    } elseif ($tabSetStarted) {
        echo HTMLHelper::_('bootstrap.endTabSet');
    }

    echo $this->item->event->afterDisplayContent;
    ?>
</div>
