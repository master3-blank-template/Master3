<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if ($params->get('item_title')) {
    $item_heading = $params->get('item_heading', 'h4');
    echo '<' . $item_heading . '>';
    if ($item->link !== '' && $params->get('link_titles')) {
        echo '<a href="' . $item->link . '">' . $item->title . '</a>';
    } else {
        echo $item->title;
    }
    echo '</' . $item_heading . '>';
}

if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) {
    echo '<figure class="newsflash-image">';
    echo '<img src="' . $item->imageSrc . '" alt="' . $item->imageAlt . '" loading="lazy">';
    if (!empty($item->imageCaption)) {
        echo '<figcaption>' . $item->imageCaption . '</figcaption>';
    }
    echo '</figure>';
}

if (!$params->get('intro_only')) {
    echo $item->afterDisplayTitle;
}

echo $item->beforeDisplayContent;

if ($params->get('show_introtext', 1)) {
    echo $item->introtext;
}

echo $item->afterDisplayContent;

if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) {
    echo '<a class="readmore" href="' . $item->link . '">' . $item->linkText . '</a>';
}
