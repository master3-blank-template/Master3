<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

echo '<ul class="uk-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

if (!$params->get('showLast', 1)) {
    array_pop($list);
}

$count = count($list);
$linkCurrent = Uri::current();
$linkRoot = substr(Uri::root(), 0, -1);

for ($i = 0; $i < $count; $i++) {
    if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link) {
        continue;
    }

    if ($pos = strpos($list[$i]->name, '||')) {
        $name = trim(substr($list[$i]->name, 0, $pos));
    } else {
        $name = $list[$i]->name;
    }

    $meta = '<meta itemprop="position" content="' . ($i + 1) . '">';

    if ($i < $count - 1) {
        if (!empty($list[$i]->link)) {
            $link = explode('?', $list[$i]->link)[0];
            echo '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a itemprop="item" content="' . $linkRoot . $link . '" href="' . $link . '"><span itemprop="name">' . $name . '</span></a>' . $meta . '</li>';
        } else {
            echo '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><span itemprop="item" content="' . $linkRoot . $link . '"><span itemprop="name">' . $name . '</span></span>' . $meta . '</li>';
        }
    } else {
        echo '<li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem"><span itemprop="item" content="' . $linkCurrent . '"><span itemprop="name">' . $name . '</span></span>' . $meta . '</li>';
    }
}

echo '</ul>';
