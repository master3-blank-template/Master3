<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
<div class="uk-child-width-1-1 uk-grid-divider search-results<?php echo $this->pageclass_sfx; ?>" data-uk-grid>
    <?php foreach ($this->results as $result) { ?>
    <div>

        <div>
            <span class="uk-text-bold"><?php echo $this->pagination->limitstart + $result->count . '. '; ?></span>
            <span class="uk-h4">
                <?php if ($result->href) { ?>
                <a href="<?php echo Route::_($result->href); ?>"<?php if ($result->browsernav == 1) { ?> target="_blank"<?php } ?>><?php echo $result->title; ?></a>
                <?php
                } else {
                    echo $result->title;
                }
                ?>
            </span>
        </div>

        <?php if ($result->section) { ?>
        <div class="uk-margin-small-top uk-article-meta">
            <?php echo Text::_('JCATEGORY'); ?>: <?php echo $this->escape($result->section); ?>
        </div>
        <?php } ?>

        <div class="uk-margin-small-top result-text"><?php echo $result->text; ?></div>

        <?php if ($this->params->get('show_date')) { ?>
        <div class="uk-margin-small-top uk-article-meta result-created<?php echo $this->pageclass_sfx; ?>"><?php echo Text::sprintf('JGLOBAL_CREATED_DATE_ON', $result->created); ?></div>
        <?php } ?>

    </div>
    <?php } ?>
</div>

<div class="pagination"><?php echo $this->pagination->getPagesLinks(); ?></div>
