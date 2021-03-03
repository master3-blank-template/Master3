<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Language\Text;

?>


<?php
/*
 * toolbar-left
 * toolbar-right
 */
if ($this->countModules('toolbar-left + toolbar-right')) {
    $section = $config->getSectionParams('toolbar');
    $image = $section->image;
    if ($image && $config->isWebP) {
        $image = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp';
        $image = is_file(Path::clean(JPATH_ROOT . '/' . $image)) ? $image : $section->image;
    }
?>
<div role="toolbar" id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ($image ? ' data-src="' . $image . '" data-uk-img' : ''); ?>>
    <div class="<?php echo $section->container; ?>">
        <div class="uk-flex uk-flex-middle uk-flex-between">

            <?php if ($this->countModules('toolbar-left')) { ?>
            <jdoc:include type="modules" name="toolbar-left" style="<?php echo $section->style; ?>" />
            <?php } ?>

            <?php if ($this->countModules('toolbar-right')) { ?>
            <jdoc:include type="modules" name="toolbar-right" style="<?php echo $section->style; ?>" />
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>


<?php
/*
 * logo
 * headbar
 */
$logo = $config->getLogo();
if ($this->countModules('headbar') || $logo !== '') {
    $section = $config->getSectionParams('headbar');
    $image = $section->image;
    if ($image && $config->isWebP) {
        $image = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp';
        $image = is_file(Path::clean(JPATH_ROOT . '/' . $image)) ? $image : $section->image;
    }
?>
<header id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ($image ? ' data-src="' . $image . '" data-uk-img' : ''); ?>>
    <div class="<?php echo $section->container; ?>">
        <div data-uk-grid>

            <?php if ($logo !== '') { ?>
            <div class="uk-width-auto<?php echo $section->responsive; ?> uk-flex uk-flex-middle">
                <?php echo $logo; ?>
            </div>
            <?php } ?>

            <?php if ($this->countModules('headbar')) { ?>
            <div class="uk-width-expand<?php echo $section->responsive; ?> uk-flex uk-flex-middle uk-flex-right<?php echo $section->responsive; ?>">
                <jdoc:include type="modules" name="headbar" style="<?php echo $section->style; ?>" />
            </div>
            <?php } ?>
        </div>
    </div>
</header>
<?php } ?>


<?php
/*
 * navbar-left
 * navbar-center
 * navbar-right
 */
if ($this->countModules('navbar-left + navbar-center + navbar-right')) {
    $section = $config->getSectionParams('navbar', 2);
    $image = $section->image;
    if ($image && $config->isWebP) {
        $image = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp';
        $image = is_file(Path::clean(JPATH_ROOT . '/' . $image)) ? $image : $section->image;
    }
?>
<div role="navigation" id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ($image ? ' data-src="' . $image . '" data-uk-img' : ''), $section->sticky; ?>>
    <div class="<?php echo $section->container; ?>">
        <div data-uk-navbar<?php echo $section->navbarMode; ?>>

            <?php if ($this->countModules('navbar-left')) { ?>
            <div class="uk-navbar-left <?php echo $section->nbLeftDisplay; ?>">
                <jdoc:include type="modules" name="navbar-left" style="<?php echo $section->style; ?>" />
            </div>
            <?php } ?>

            <?php if ($this->countModules('navbar-center')) { ?>
            <div class="uk-navbar-center <?php echo $section->nbCenterDisplay; ?>">
                <jdoc:include type="modules" name="navbar-center" style="<?php echo $section->style; ?>" />
            </div>
            <?php } ?>

            <?php if ($this->countModules('navbar-right')) { ?>
            <div class="uk-navbar-right <?php echo $section->nbRightDisplay; ?>">
                <jdoc:include type="modules" name="navbar-right" style="<?php echo $section->style; ?>" />
            </div>
            <?php } ?>
        </div>
        <?php if ($section->dropbarMode) { ?>
        <div class="uk-navbar-dropbar"></div>
        <?php } ?>
    </div>
</div>
<?php } ?>


<?php
/*
 * breadcrumb
 */
if ($this->countModules('breadcrumb')) {
    $section = $config->getSectionParams('breadcrumb');
    $image = $section->image;
    if ($image && $config->isWebP) {
        $image = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp';
        $image = is_file(Path::clean(JPATH_ROOT . '/' . $image)) ? $image : $section->image;
    }
?>
<div role="navigation" id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ($image ? ' data-src="' . $image . '" data-uk-img' : ''); ?>>
    <div class="<?php echo $section->container; ?>">
        <jdoc:include type="modules" name="breadcrumb" style="<?php echo $section->style; ?>" />
    </div>
</div>
<?php } ?>


<?php
/*
 * system messages
 */
?>
<jdoc:include type="message" />


<?php
/*
 * block-[a-e]
 */
$blockSections = ['block-a', 'block-b', 'block-c', 'block-d', 'block-e'];
foreach ($blockSections as $blockSection) {
    if ($sectionPosCount = $this->countModules($blockSection)) {
        $sectionPosCount = $sectionPosCount > 6 ? 6 : $sectionPosCount;
        $section = $config->getSectionParams($blockSection);
        $sectionResponsive = 'uk-child-width-1-' . ($section->responsive === '' ? '1' : $sectionPosCount . $section->responsive);
        $section->gridClass = trim($sectionResponsive . ' ' . $section->gridClass);
        $image = $section->image;
        if ($image && $config->isWebP) {
            $image = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp';
            $image = is_file(Path::clean(JPATH_ROOT . '/' . $image)) ? $image : $section->image;
        }
    ?>
<section id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ($image ? ' data-src="' . $image . '" data-uk-img' : ''); ?>>
    <div class="<?php echo $section->container; ?>">
        <div class="<?php echo $section->gridClass; ?>" data-uk-grid>
            <jdoc:include type="modules" name="<?php echo $blockSection; ?>" style="<?php echo $section->style; ?>" />
        </div>
    </div>
</section>
<?php } } ?>


<?php
/*
 * system output
 * main-top
 * main-bottom
 * sidebar-a
 * sidebar-b
 */
$systemOutput = $config->getSystemOutput();
$countMainTop = $this->countModules('main-top');
$countMainBottom = $this->countModules('main-bottom');
$countSidebarA = $this->countModules('sidebar-a');
$countSidebarB = $this->countModules('sidebar-b');
if ($systemOutput || $countMainTop || $countMainBottom || $countSidebarA || $countSidebarB) {
    $section = $config->getSectionParams('main', 1);
    $image = $section->image;
    if ($image && $config->isWebP) {
        $image = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp';
        $image = is_file(Path::clean(JPATH_ROOT . '/' . $image)) ? $image : $section->image;
    }
?>
<div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ($image ? ' data-src="' . $image . '" data-uk-img' : ''); ?>>
    <div class="<?php echo $section->container; ?>">
        <div class="<?php echo $section->gridClass; ?>" data-uk-grid>
            <?php if ($systemOutput || $countMainTop || $countMainBottom) { ?>
            <div class="uk-width-<?php echo $section->mainGridSize . $section->responsive; ?>">
                <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>

                    <?php if ($countMainTop) { ?>
                    <div>
                        <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                            <jdoc:include type="modules" name="main-top" style="<?php echo $section->style; ?>" />
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ($systemOutput) { ?>
                    <div>
                        <main id="content">
                            <?php echo $systemOutput; ?>
                        </main>
                    </div>
                    <?php } ?>

                    <?php if ($countMainBottom) { ?>
                    <div>
                        <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                            <jdoc:include type="modules" name="main-bottom" style="<?php echo $section->style; ?>" />
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            } else {
                if (($countSidebarA && !$countSidebarB) || (!$countSidebarA && $countSidebarB)) {
                    $section->sidebarGridSize = '1-1';
                    $section->responsive = '';
                } elseif ($countSidebarA && $countSidebarB) {
                    $section->sidebarGridSize = '1-2';
                }
            }
            ?>

            <?php if ($countSidebarA) { ?>
            <aside class="<?php echo $section->sidebarAClass; ?>uk-width-<?php echo $section->sidebarGridSize . $section->responsive; ?>">
                <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                    <jdoc:include type="modules" name="sidebar-a" style="<?php echo $section->style; ?>" />
                </div>
            </aside>
            <?php } ?>

            <?php if ($countSidebarB) { ?>
            <aside class="<?php echo $section->sidebarBClass; ?>uk-width-<?php echo $section->sidebarGridSize . $section->responsive; ?>">
                <div class="<?php echo 'uk-child-width-1-1 ' . $section->gridClass; ?>" data-uk-grid>
                    <jdoc:include type="modules" name="sidebar-b" style="<?php echo $section->style; ?>" />
                </div>
            </aside>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>


<?php
/*
 * block-[f-k]
 */
$blockSections = ['block-f', 'block-g', 'block-h', 'block-i', 'block-k'];
foreach ($blockSections as $blockSection) {
    if ($sectionPosCount = $this->countModules($blockSection)) {
        $sectionPosCount = $sectionPosCount > 6 ? 6 : $sectionPosCount;
        $section = $config->getSectionParams($blockSection);
        $sectionResponsive = 'uk-child-width-1-' . ($section->responsive === '' ? '1' : $sectionPosCount . $section->responsive);
        $section->gridClass = trim($sectionResponsive . ' ' . $section->gridClass);
        $image = $section->image;
        if ($image && $config->isWebP) {
            $image = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp';
            $image = is_file(Path::clean(JPATH_ROOT . '/' . $image)) ? $image : $section->image;
        }
    ?>
<div id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ($image ? ' data-src="' . $image . '" data-uk-img' : ''); ?>>
    <div class="<?php echo $section->container; ?>">
        <div class="<?php echo $section->gridClass; ?>" data-uk-grid>
            <jdoc:include type="modules" name="<?php echo $blockSection; ?>" style="<?php echo $section->style; ?>" />
        </div>
    </div>
</div>
<?php } } ?>


<?php
/*
 * footer-left
 * footer-center
 * footer-right
 */
if ($this->countModules('footer-left + footer-center + footer-right')) {
    $section = $config->getSectionParams('footer');
    $sectionPosCount = ($this->countModules('footer-left') ? 1 : 0) + ($this->countModules('footer-center') ? 1 : 0) + ($this->countModules('footer-right') ? 1 : 0);
    $sectionResponsive = 'uk-child-width-1-' . ($section->responsive === '' ? '1' : $sectionPosCount . $section->responsive);
    $section->gridClass = trim($sectionResponsive . ' ' . $section->gridClass);
    $image = $section->image;
    if ($image && $config->isWebP) {
        $image = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME) . '.webp';
        $image = is_file(Path::clean(JPATH_ROOT . '/' . $image)) ? $image : $section->image;
    }
?>
<footer id="<?php echo $section->id; ?>" class="<?php echo $section->class; ?>"<?php echo ($image ? ' data-src="' . $image . '" data-uk-img' : ''); ?>>

    <div class="<?php echo $section->container; ?>">

        <div class="<?php echo $section->gridClass; ?>" data-uk-grid>

            <?php if ($this->countModules('footer-left')) { ?>
            <div>
                <jdoc:include type="modules" name="footer-left" style="<?php echo $section->style; ?>" />
            </div>
            <?php } ?>

            <?php if ($this->countModules('footer-center')) { ?>
            <div>
                <jdoc:include type="modules" name="footer-center" style="<?php echo $section->style; ?>" />
            </div>
            <?php } ?>

            <?php if ($this->countModules('footer-right')) { ?>
            <div>
                <jdoc:include type="modules" name="footer-right" style="<?php echo $section->style; ?>" />
            </div>
            <?php } ?>
        </div>
    </div>

</footer>
<?php } ?>


<?php
/*
 * to-top scroller
 */
if ($this->params->get('totop')) { ?>
<a class="uk-padding-small uk-position-bottom-left uk-position-fixed" data-uk-totop data-uk-scroll aria-label="Up"></a>
<?php } ?>


<?php
/*
 * offcanvas
 */
if ($this->countModules('offcanvas')) {
    $offcanvas = $config->getOffcanvasParams('offcanvas');
?>
<aside id="offcanvas" data-uk-offcanvas="<?php echo $offcanvas->attrs; ?>">
    <div class="uk-offcanvas-bar<?php echo $offcanvas->class; ?>">
        <a class="uk-offcanvas-close" data-uk-close aria-label="<?php echo Text::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?>"></a>
        <jdoc:include type="modules" name="offcanvas" style="<?php echo $section->style; ?>" />
    </div>
</aside>
<?php } ?>


<?php
/*
 * offcanvas-menu
 */
if ($this->countModules('offcanvas-menu')) {
    $offcanvas = $config->getOffcanvasParams('offcanvas-menu');
?>
<aside id="offcanvas-menu" data-uk-offcanvas="<?php echo $offcanvas->attrs; ?>">
    <div class="uk-offcanvas-bar<?php echo $offcanvas->class; ?>">
        <a class="uk-offcanvas-close" data-uk-close aria-label="<?php echo Text::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?>"></a>
        <jdoc:include type="modules" name="offcanvas-menu" style="<?php echo $section->style; ?>" />
    </div>
</aside>
<?php } ?>


<?php
/*
 * system debug info
 */
if ($this->countModules('debug')) {
?>
<jdoc:include type="modules" name="debug" style="empty" />
<?php } ?>
