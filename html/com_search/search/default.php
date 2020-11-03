<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<div class="search<?php echo $this->pageclass_sfx; ?>">

    <?php if ($this->params->get('show_page_heading')) { ?>
    <h1 class="uk-article-title">
        <?php
        if ($this->escape($this->params->get('page_heading'))) {
            echo $this->escape($this->params->get('page_heading'));
        } else {
            echo $this->escape($this->params->get('page_title'));
        }
        ?>
        </h1>
    <?php
    }

    echo $this->loadTemplate('form');

    if ($this->error == null && count($this->results) > 0) {
        echo $this->loadTemplate('results');
    } else {
        echo $this->loadTemplate('error');
    }
    ?>
</div>
