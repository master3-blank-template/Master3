<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_languages
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

?>
<div class="mod-languages<?php echo $moduleclass_sfx; ?>">

    <?php if ($headerText) { ?>
    <div class="uk-margin-bottom pretext"><p><?php echo $headerText; ?></p></div>
    <?php
    }

    if ($params->get('dropdown', 0) && !$params->get('dropdownimage', 1)) {
    ?>

    <form name="lang" method="post" action="<?php echo htmlspecialchars(Uri::current(), ENT_COMPAT, 'UTF-8'); ?>">
        <select class="uk-select uk-width-auto" onchange="document.location.replace( this.value );" >
            <?php foreach ($list as $language) { ?>
            <option dir=<?php echo $language->rtl ? '"rtl"' : '"ltr"'; ?> value="<?php echo htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $language->active ? 'selected="selected"' : ''; ?>><?php echo $language->title_native; ?></option>
            <?php
        } ?>
        </select>
    </form>

    <?php } elseif ($params->get('dropdown', 0) && $params->get('dropdownimage', 1)) { ?>

    <div class="uk-inline">
        <?php
        foreach ($list as $language) {
            if ($language->active) {
        ?>
        <a href="#" class="uk-button uk-button-link uk-flex uk-flex-middle">
            <?php if ($language->image) { ?>
            <span class="uk-border-circle uk-display-inline-block uk-margin-small-right" style="width:20px;">
                <?php
                $lang_image = realpath(__DIR__ . '/images/' . $language->image . '.svg');
                if ($lang_image) {
                    echo file_get_contents($lang_image);
                }
                ?>
            </span>
            <?php } ?>
            <span class="uk-display-inline-block"><?php echo $language->title_native; ?></span>
        </a>
        <?php
                break;
            }
        }
        ?>
        <div data-uk-dropdown="pos:bottom-<?php echo Factory::getLanguage()->isRtl() ? 'left' : 'right'; ?>">
            <ul class="uk-nav uk-dropdown-nav">
                <?php
                foreach ($list as $language) {
                    if (!$language->active || $params->get('show_active', 1)) {
                ?>
                <li <?php echo $language->active ? ' class="uk-active"' : ''; ?>>
                    <a href="<?php echo htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'); ?>" class="uk-flex uk-flex-middle"<?php echo $params->get('lineheight', 1) ? '' : ' style="font-size:1rem"'; ?>>
                        <?php if ($language->image) { ?>
                        <span class="uk-border-circle uk-display-inline-block uk-margin-small-right" style="width:20px;">
                            <?php
                            $lang_image = realpath(__DIR__ . '/images/' . $language->image . '.svg');
                            if ($lang_image) {
                                echo file_get_contents($lang_image);
                            }
                            ?>
                        </span>
                        <?php } ?>
                        <span class="uk-display-inline-block"><?php echo $language->title_native; ?></span>
                    </a>
                </li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <?php } else { ?>

    <ul class="<?php echo $params->get('inline', 1) ? 'uk-subnav uk-margin-remove' : 'uk-list uk-margin-remove'; ?>">
        <?php
        $first = true;
        foreach ($list as $language) {
            if (!$language->active || $params->get('show_active', 1)) {
                $firstClass = $first ? ' uk-padding-remove' : '';
                $first = false;
        ?>
        <li class="<?php echo trim(($language->active ? 'uk-active' : '') . $firstClass); ?>" dir="<?php echo $language->rtl ? 'rtl' : 'ltr'; ?>">
            <a href="<?php echo htmlspecialchars($language->link, ENT_QUOTES, 'UTF-8'); ?>">
                <?php
                if ($params->get('image', 1)) {
                    if ($language->image) {
                        ?>
                <span class="uk-border-circle uk-display-inline-block" style="width:20px;" data-uk-tooltip="<?php echo $language->title_native ?>">
                    <?php
                    $lang_image = realpath(__DIR__ . '/images/' . $language->image . '.svg');
                    if ($lang_image) {
                        echo file_get_contents($lang_image);
                    }
                    ?>
                </span>
                <?php
                    } else {
                        echo strtoupper($language->sef);
                    }
                } else {
                    echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef);
                }
                ?>
            </a>
        </li>
        <?php
            }
        }
        ?>
    </ul>

    <?php
    }

    if ($footerText) {
        ?>
        <div class="uk-margin-top posttext"><p><?php echo $footerText; ?></p></div>
        <?php
    }
    ?>

</div>
