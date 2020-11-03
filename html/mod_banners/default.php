<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_banners
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

JLoader::register('BannerHelper', JPATH_ROOT . '/components/com_banners/helpers/banner.php');

?>

<?php if ($headerText) { ?>
<div class="uk-margin-bottom"><?php echo $headerText; ?></div>
<?php
} ?>

<div class="uk-child-width-1-1 <?php echo $moduleclass_sfx; ?>" data-uk-grid>

    <?php foreach ($list as $item) { ?>
    <div>
        <?php
        $link = Route::_('index.php?option=com_banners&task=click&id=' . $item->id);
        if ($item->type == 1) {
            // Text based banners
            echo str_replace(array('{CLICKURL}', '{NAME}'), array($link, $item->name), $item->custombannercode);
        } else {
            $imageurl = $item->params->get('imageurl');
            $width = $item->params->get('width');
            $height = $item->params->get('height');

            if (BannerHelper::isImage($imageurl)) {
                $name = htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');

                // Image based banner
                $baseurl = strpos($imageurl, 'http') === 0 ? '' : Uri::base();
                $alt = $item->params->get('alt');
                $alt = $alt ? : $item->name;
                $alt = $alt ? : Text::_('MOD_BANNERS_BANNER');
                $img = '<img data-src="' . $baseurl . $imageurl . '" alt="' . $alt . '"' . (!empty($width) ? ' width="' . $width . '"' : '') . (!empty($height) ? ' height="' . $height . '"' : '') . ' data-uk-img loading="lazy">';

                if ($item->clickurl) {
                    // Wrap the banner in a link
                    $target = $params->get('target', 1);
                    if ($target == 1) {
                        // Open in a new window
                        ?>
        <a href="<?php echo $link; ?>" title="<?php echo $name; ?>" target="_blank" rel="noopener noreferrer"><?php echo $img; ?></a>
        <?php } elseif ($target == 2) { // Open in a popup window ?>
        <a href="<?php echo $link; ?>" title="<?php echo $name; ?>" onclick="window.open( this.href, '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550' );return false"><?php echo $img; ?></a>
        <?php } else { // Open in parent window ?>
        <a href="<?php echo $link; ?>" title="<?php echo $name; ?>"><?php echo $img; ?></a>
        <?php
                    }
                } else { // Just display the image if no link specified
                echo $img;
            }
        } elseif (BannerHelper::isFlash($imageurl)) {
        ?>
        <object
            classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
            <?php if (!empty($width)) echo ' width="' . $width . '"'; ?>
            <?php if (!empty($height)) echo ' height="' . $height . '"'; ?>
        >
            <param name="movie" value="<?php echo $imageurl; ?>" />
            <embed
                src="<?php echo $imageurl; ?>"
                loop="false"
                pluginspage="http://www.macromedia.com/go/get/flashplayer"
                type="application/x-shockwave-flash"
                <?php if (!empty($width)) echo ' width="' . $width . '"'; ?>
                <?php if (!empty($height)) echo ' height="' . $height . '"'; ?>
            />
        </object>
        <?php
        }
    }
    ?>
    </div>
    <?php } ?>
</div>

<?php if ($footerText) { ?>
<div class="uk-margin-top"><?php echo $footerText; ?></div>
<?php }
