<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 *
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;

final class Master3Config
{

    /*
     * Instance
     */
    private static $instance = null;

    /*
     * Document object
     */
    private $doc = null;

    /*
     * string
     */
    public $name = 'master3';

    /*
     * bool
     */
    public $isMain = false;

    /*
     * int
     */
    protected $menuActiveId = 101;

    /*
     * Registry object
     */
    public $params = null;

    /*
     * string
     */
    protected $layoutName = '';

    /*
     * string
     */
    protected $htmlAttrs = '';

    /*
     * string
     */
    protected $bodyClass = '';

    /*
     * bool
     */
    protected $isNoContent = false;

    /*
     * bool
     */
    public $isWebP = false;


    /*
     * Get static Instance
     * 
     * @return object this
     */
    static public function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Master3Config();
        }

        return self::$instance;
    }


    /*
     * Get WebP support
     */
    protected function checkWebP()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];

        preg_match('/(Android)(?:\'&#x20;| )([0-9.]+)/', $agent, $Android);
        preg_match('/(Version)(?:\/| )([0-9.]+)/', $agent, $Safari);
        preg_match('/(OPR)(?:\/| )([0-9.]+)/', $agent, $Opera);
        preg_match('/(Edge)(?:\/| )([0-9.]+)/', $agent, $Edge);
        preg_match('/(Trident)(?:\/| )([0-9.]+)/', $agent, $IE);
        preg_match('/(rv)(?:\:| )([0-9.]+)/', $agent, $rv);
        preg_match('/(MSIE|Opera|Firefox|Chrome|Chromium|YandexSearch|YaBrowser)(?:\/| )([0-9.]+)/', $agent, $bi);

        $isAndroid = isset($Android[1]);
        $isWin10 = strpos($agent, 'Windows NT 10.0') !== false;

        if ($Safari && !$isAndroid) {
            $browserName = 'Safari';
            $browserVersion = (int) $Safari[2];
        } elseif ($Opera) {
            $browserName = 'Opera';
            $browserVersion = (int) $Opera[2];
        } elseif ($Edge) {
            $browserName = 'Edge';
            $browserVersion = (int) $Edge[2];
        } elseif ($IE) {
            $browserName = 'IE';
            $browserVersion = isset($rv[2]) ? (int) $rv[2] : ($isWin10 ? 11 : (int) $IE[2]);
        } else {
            $browserName = isset($bi[1]) ? $bi[1] : ($isAndroid ? 'Android' : 'Unknown');
            $browserVersion = isset($bi[2]) ? (int) $bi[2] : ($isAndroid ? (float) $Android[2] : 0);
        }

        $browsers = [
            'Chrome' => 32,
            'Firefox' => 65,
            'Opera' => 19,
            'Edge' => 18,
            'YaBrowser' => 1,
            'YandexSearch' => 1,
            'Android' => 4.2
        ];

        $this->isWebP = in_array($browserName, array_keys($browsers)) && ($browserVersion >= $browsers[$browserName]);
    }


    /*
     * Get template name
     * 
     * @retutn string
     */
    static public function getTemplateName()
    {
        $app = Factory::getApplication();
        if ($app->isClient('administrator') === false) {
            return $app->getTemplate('site')->template;
        }

        $input = $app->input;

        $id = ($input->get('option') == 'com_templates' && (int) $input->get('id') !== 0) ? (int) $id = $input->get('id') : 0;

        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('template')
            ->from('#__template_styles');
        if ($id) {
            $query
                ->where('id=' . $id);
        } else {
            $query
                ->where('client_id=0')
                ->where('home=1');
        }
        $templateName = $db->setQuery($query)->loadResult();
        return $templateName;
    }


    /*
     * Constrictor
     */
    protected function __construct()
    {
        $this->name = strtolower(self::getTemplateName());

        $this->doc = Factory::getDocument();

        $this->params = $this->doc->params;

        $app = Factory::getApplication();

        if (!isset($this->params)) {
            $template = $app->getTemplate(true);
            $this->params = $template->params;
        }

        $menuItem = $app->getMenu('site')->getActive();
        $menuDefault = $app->getMenu('site')->getDefault();
        $this->menuActiveId = isset($menuItem) ? $menuItem->id : $menuDefault->id;

        $link = Route::_('index.php?Itemid=' . $menuDefault->id);
        $this->isMain = (Uri::current() == Uri::base()) || (Uri::current() == Uri::base() . substr($link, strlen(Uri::base(true)) + 1));

        $this->checkWebP();


        // param temlateLayouts recompose
        $layouts = [];

        $prmLayouts = $this->params->get('templateLayouts', []);
        foreach ($prmLayouts as $item) {
            $layouts[$item->form->name] = isset($item->form->menuassign) ? $item->form->menuassign : [];
        }

        $this->params->set('templateLayouts', $layouts);


        // param sections recompose
        $sections = [];

        $prmSections = $this->params->get('sections', []);

        $allSectionsMenuIsd = [];
        foreach ($prmSections as $item) {
            if (isset($item->form->menuassignLayout)) {
                $allSectionsMenuIsd = array_merge($allSectionsMenuIsd, $item->form->menuassignLayout);
            }
        }
        $allSectionsMenuIsd = array_values($allSectionsMenuIsd);

        foreach ($prmSections as $item) {
            $layout = new \stdClass();
            $layout->menu = isset($item->form->menuassignLayout) ? $item->form->menuassignLayout : [];
            $layout->active = false;

            $layout->htmlAttrs = isset($item->form->htmlAttrs) ? trim($item->form->htmlAttrs) : '';
            $layout->bodyClass = isset($item->form->bodyClasses) ? trim($item->form->bodyClasses) : '';
            $layout->noComponentMain = isset($item->form->noComponentMain) && $item->form->noComponentMain;

            $layout->list = [];

            foreach ($item->form->sectionList as $itemSection) {
                $section = new \stdClass();
                $section->id = $itemSection->id ? htmlspecialchars($itemSection->id, ENT_QUOTES, 'UTF-8') : $itemSection->name;

                $section->class = [];
                $section->class[] = $itemSection->padding;
                $section->class[] = $itemSection->style;
                $section->class[] = $itemSection->light ? 'uk-light' : '';
                $section->class[] = htmlspecialchars($itemSection->class, ENT_COMPAT, 'UTF-8');

                $section->image = $itemSection->image && Path::clean(JPATH_BASE . '/' . $itemSection->image) ? '/' . $itemSection->image : '';
                if ($section->image) {
                    $section->class[] = $itemSection->imageAlign;
                    $section->class[] = isset($itemSection->imageNoRepeat) && $itemSection->imageNoRepeat ? 'uk-background-norepeat' : '';
                    $section->class[] = isset($itemSection->imageFix) && $itemSection->imageFix ? 'uk-background-fixed' : '';
                }

                $section->class = trim(implode(' ', $section->class));

                $section->style = $itemSection->modulesstyle;

                $section->container = $itemSection->container;

                $section->responsive = $itemSection->responsive === 'stacked' ? '' : '@' . $itemSection->responsive[0];

                $section->gridClass = [];
                $section->gridClass[] = $itemSection->gutter;
                $section->gridClass[] = $itemSection->divider ? 'uk-grid-divider' : '';
                $section->gridClass = trim(implode(' ', $section->gridClass));

                $layout->list[$itemSection->name] = $section;
                unset($section);
            }

            $sections[$item->form->nameLayout] = $layout;
            unset($layout);
        }


        foreach ($sections as $sectionName => $section) {
            if ((!$section->menu && !in_array($this->menuActiveId, $allSectionsMenuIsd)) || in_array($this->menuActiveId, $section->menu)) {
                $this->layoutName = $sectionName;
                $this->htmlAttrs = $section->htmlAttrs;
                $this->bodyClass = $section->bodyClass;
                $this->isNoContent = $section->noComponentMain;
                break;
            }
        }

        if (isset($sections[$this->layoutName])) {
            $sections[$this->layoutName]->active = true;
            $this->bodyClass = $section->bodyClass;
        }

        $this->params->set('sections', $sections);


        // param modules recompose
        $modules = [];

        $prmModules = $this->params->get('modules', []);
        foreach ($prmModules as $item) {
            $module = new \stdClass();

            $module->class = [];
            $module->class[] = $item->form->moduleBox;
            $module->class[] = $item->form->moduleBox !== 'uk-panel' ? $item->form->modulePadding : '';
            $module->class[] = $item->form->light ? 'uk-light' : '';
            $module->class[] = htmlspecialchars($item->form->moduleClass, ENT_COMPAT, 'UTF-8');
            $module->class = trim(implode(' ', $module->class));
            $module->dataAttrs = trim($item->form->moduleDataAttrs);

            $module->display = $item->form->display;
            $module->align = $item->form->moduleAlign;
            $module->offtoggle = isset($item->form->offtoggle) ? $item->form->offtoggle : false;
            $module->titleTag = $item->form->titleTag;
            $module->titleClass = htmlspecialchars($item->form->titleClass, ENT_COMPAT, 'UTF-8');
            $module->titleLink = htmlspecialchars($item->form->titleLink, ENT_QUOTES, 'UTF-8');

            $modules[$item->form->id] = $module;
            unset($module);
        }

        $this->params->set('modules', $modules);


        // param menu recompose
        $menuItems = [];
        $navbarBoundary = $this->params->get('navbarBoundary', '') === 'justify';

        $prmMenus = $this->params->get('menuitems', []);
        foreach ($prmMenus as $item) {
            $menuItem = new \stdClass();

            $menuItem->subtitle = htmlspecialchars($item->form->subtitle, ENT_COMPAT, 'UTF-8');
            $menuItem->cols = $item->form->gridColumns;
            $menuItem->divider = isset($item->form->gridDivider) && $item->form->gridDivider == 1;
            $menuItem->dropdownJustify = $navbarBoundary;
            $menuItem->dropdownClass = htmlspecialchars($item->form->dropdownClass, ENT_COMPAT, 'UTF-8');

            $menuItems[$item->form->menuid] = $menuItem;
            unset($menuItem);
        }

        $this->params->set('menuitems', $menuItems);


        // param offcanvas recompose
        $offcanvas = [];

        $prmOffcanvas = $this->params->get('offcanvas', []);
        foreach ($prmOffcanvas as $item) {
            $oc = new \stdClass();

            $oc->class = htmlspecialchars($item->form->class, ENT_COMPAT, 'UTF-8');

            $oc->attrs = [];
            $oc->attrs[] = 'mode:' . $item->form->mode;
            $oc->attrs[] = $item->form->overlay ? 'overlay:true' : '';
            $oc->attrs[] = $item->form->flip ? 'flip:true' : '';
            $oc->attrs = implode(';', $oc->attrs);

            $offcanvas[$item->form->posname] = $oc;
            unset($oc);
        }

        $this->params->set('offcanvas', $offcanvas);


        // set head data
        $this->setHead();
    }


    /*
     * Get mime-type
     * 
     * @param string $file
     * 
     * @retutn string
     */
    protected function getMime($file)
    {
        if (function_exists('mime_content_type')) {
            return @mime_content_type($file);
        } else {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            switch ($ext) {
                case 'png':
                    $mime = 'image/png';
                    break;

                case 'jpeg':
                case 'jpe':
                case 'jpg':
                    $mime = 'image/jpeg';
                    break;

                case 'gif':
                    $mime = 'image/gif';
                    break;

                case 'svg':
                    $mime = 'image/svg+xml';
                    break;
                case 'svgz':
                    $mime = 'image/svg';
                    break;

                case 'tiff':
                case 'tif':
                    $mime = 'image/tiff';
                    break;

                case 'ico':
                    $mime = 'image/vnd.microsoft.icon';
                    break;

                default:
                    $mime = '';
            }
            return $mime;
        }
    }


    /*
     * Head section data
     */
    protected function setHead()
    {
        $tpath = 'templates/' . $this->name;

        /*
         * load google fonts
         */
        $fonts = $this->getFonts();
        if ($fonts) {
            HTMLHelper::stylesheet($fonts['link'], [], []);
            $this->doc->addStyleDeclaration($fonts['style']);
        }


        /*
         * load template css
         */
        $cssUikit = $this->params->get('cssUikit', 'uikit.min.css');
        if ($cssUikit !== 'none') {
            $isRTL = strpos($cssUikit, 'rtl') !== false;
            $isMin = strpos($cssUikit, 'min') !== false;
            HTMLHelper::_('uikit3.css', $isRTL, $isMin);
        }

        $cssFiles = (array) $this->params->get('cssFiles');
        foreach ($cssFiles as $cssFile) {
            if ($cssFile->form->fInclude) {
                $cssFile = realpath(Path::clean(JPATH_ROOT . '/templates/' . $this->name . '/css/' . htmlspecialchars(trim($cssFile->form->fName))));
                if (is_file($cssFile) && strtolower(pathinfo($cssFile, PATHINFO_EXTENSION)) == 'css') {
                    $cssFile = str_replace('\\', '/', str_replace(JPATH_ROOT . DIRECTORY_SEPARATOR, '', $cssFile));
                    HTMLHelper::stylesheet($cssFile, [], ['options' => ['version' => 'auto']]);
                }
            }
        }

        $cssAddons = $this->params->get('cssAddons');
        $cssAddons = explode("\n", $cssAddons);
        foreach ($cssAddons as $cssAddonFile) {
            $cssAddonFile = realpath(Path::clean(JPATH_ROOT . '/' . htmlspecialchars(trim($cssAddonFile))));
            if (is_file($cssAddonFile) && strtolower(pathinfo($cssAddonFile, PATHINFO_EXTENSION)) == 'css') {
                $cssAddonFile = str_replace('\\', '/', str_replace(JPATH_ROOT . DIRECTORY_SEPARATOR, '', $cssAddonFile));
                HTMLHelper::stylesheet($cssAddonFile, [], ['options' => ['version' => 'auto']]);
            }
        }


        /*
         * load template js
         */
        if ($this->params->get('jsJQ', false)) {
            HTMLHelper::_('jquery.framework', true, null, false);
        }

        $jsUikit = $this->params->get('jsUikit', 'uikit.min.js');
        if ($jsUikit !== 'none') {
            $isMin = strpos($jsUikit, 'min') !== false;
            HTMLHelper::_('uikit3.js', $isMin);
        }

        $jsIcons = $this->params->get('jsIcons', 'uikit-icons.min.js');
        if ($jsIcons !== 'none') {
            $isMin = strpos($jsIcons, 'min') !== false;
            HTMLHelper::_('uikit3.icons', $isMin);
        }

        $jsFiles = (array) $this->params->get('jsFiles');
        foreach ($jsFiles as $jsFile) {
            if ($jsFile->form->fInclude) {
                $jsFile = realpath(Path::clean(JPATH_ROOT . '/templates/' . $this->name . '/js/' . htmlspecialchars(trim($jsFile->form->fName))));
                if (is_file($jsFile) && strtolower(pathinfo($jsFile, PATHINFO_EXTENSION)) == 'js') {
                    $jsFile = str_replace('\\', '/', str_replace(JPATH_ROOT . DIRECTORY_SEPARATOR, '', $jsFile));
                    HTMLHelper::script($jsFile, [], ['options' => ['version' => 'auto']]);
                }
            }
        }

        $jsAddons = $this->params->get('jsAddons');
        $jsAddons = explode("\n", $jsAddons);
        foreach ($jsAddons as $jsAddonFile) {
            $jsAddonFile = realpath(Path::clean(JPATH_ROOT . '/' . htmlspecialchars(trim($jsAddonFile))));
            if (is_file($jsAddonFile) && strtolower(pathinfo($jsAddonFile, PATHINFO_EXTENSION)) == 'js') {
                $jsAddonFile = str_replace('\\', '/', str_replace(JPATH_ROOT . DIRECTORY_SEPARATOR, '', $jsAddonFile));
                HTMLHelper::script($jsAddonFile, [], ['options' => ['version' => 'auto']]);
            }
        }


        /*
         * compose head section
         */
        $this->doc->setHtml5(true);
        $this->doc->setGenerator('');
        $this->doc->setMetaData('viewport', 'width=device-width,initial-scale=1');
        $this->doc->setMetaData('X-UA-Compatible', 'IE=edge', 'http-equiv');

        // favicon
        $favicon = $this->params->get('favicon', '');
        if ($favicon && is_file(Path::clean(JPATH_BASE . '/' . $favicon))) {
            $type = $this->getMime(Path::clean(JPATH_BASE . '/' . $favicon));
            $this->doc->addFavicon(Uri::base(true) . '/' . $favicon, $type, 'shortcut icon');
        }

        // favicon for apple devices
        $faviconApple = $this->params->get('faviconApple', '');
        if ($faviconApple && is_file(Path::clean(JPATH_BASE . '/' . $faviconApple))) {
            $this->doc->addHeadLink(Uri::base(true) . '/' . $faviconApple, 'apple-touch-icon-precomposed');
        }
    }


    /*
     * Google Fonts links
     * 
     * @return array
     */
    protected function getFonts()
    {
        $fontsList = [
            0 => $this->params->get('fontHtml', ''),
            1 => $this->params->get('fontHeading', ''),
            2 => $this->params->get('fontLogo', ''),
            3 => $this->params->get('fontNavbar', ''),
            4 => $this->params->get('fontPre', '')
        ];

        $tmp = $fontsList;
        if (!array_diff($tmp, [''])) {
            return [];
        }
        unset($tmp);

        $variants = implode(',', $this->params->get('fontsVariants', 'regular'));
        $variants = $variants === 'regular' ? '' : ':' . $variants;

        $subsets = implode(',', $this->params->get('fontsSubsets', 'latin'));
        $subsets = $subsets === 'latin' ? '' : '&amp;subset=' . $subsets;

        $tmpLink = [];
        $tmpStyle = [];
        $htmlFont = '';
        $css = [
            0 => 'html',
            1 => 'h1,h2,h3,h4,h5,h6,.uk-h1,.uk-h2,.uk-h3,.uk-h4,.uk-h5,.uk-h6',
            2 => '.uk-logo',
            3 => '.uk-navbar-nav>li>a,.uk-navbar-item,.uk-navbar-toggle',
            4 => 'pre,pre code,:not(pre)>code,:not(pre)>kbd,:not(pre)>samp'
        ];

        foreach ($fontsList as $i => $font) {
            $font = htmlspecialchars(trim($font));

            if ($i == 0) {
                $htmlFont = $font;
            }

            $font_ = str_replace(' ', '+', $font);
            $font_ = $font_ ? $font_ . $variants : '';
            if ($font_ && array_search($font_, $tmpLink, true) === false) {
                $tmpLink[] = $font_;
            }

            if ($font !== '') {
                $tmpStyle[] = $css[$i] . "{font-family:'{$font}'}";
            } elseif ($i > 0 && $htmlFont !== '') {
                $tmpStyle[] = $css[$i] . "{font-family:'{$htmlFont}'}";
            }
        }

        $head['link'] = '//fonts.googleapis.com/css?family=' . implode('|', $tmpLink) . $subsets;

        $head['style'] = implode("\n", $tmpStyle);

        return $head;
    }


    /*
     * Get template layout
     * 
     * @return string
     */
    public function getLayout()
    {
        $layouts = $this->params->get('templateLayouts');

        $layout = 'default';

        foreach ($layouts as $name => $items) {
            if (in_array($this->menuActiveId, $items)) {
                $layout = $name;
                break;
            }
        }

        if (!file_exists(realpath(JPATH_ROOT . "/templates/{$this->name}/layouts/template.{$layout}.php"))) {
            $layout = 'default';
        }
        if (!file_exists(realpath(JPATH_ROOT . "/templates/{$this->name}/layouts/template.{$layout}.php"))) {
            $layout = 'default-original';
        }

        return $layout;
    }


    /*
     * Logo position render
     * 
     * @return text/html
     */
    public function getLogo()
    {
        $logotag = $this->isMain ? 'div' : 'a';
        $logohref = $this->isMain ? '' : ' href="' . Route::_('index.php?Itemid=' . Factory::getApplication()->getMenu('site')->getDefault()->id) . '"';
        $out = '';

        if ($this->doc->countModules('logo')) {
            $out .= "<{$logotag}{$logohref} class=\"uk-logo uk-flex-inline\">";
            $out .= '<jdoc:include type="modules" name="logo" style="empty" />';
            $out .= "</{$logotag}>";
        } else {
            $logoFile = $this->params->get('logoFile', '');
            $siteTitle = $this->params->get('siteTitle', '');

            if ($logoFile || $siteTitle) {
                $out .= "<{$logotag}{$logohref} class=\"uk-logo uk-flex-inline uk-flex-middle\">";

                if ($logoFile) {
                    $mime = $this->getMime(Path::clean(JPATH_BASE . '/' . $logoFile));
                    if ($mime == 'image/svg' || $mime == 'image/svg+xml') {
                        $out .= file_get_contents(Path::clean(JPATH_BASE . '/' . $logoFile));
                    } else {
                        $out .= "<img src=\"{$logoFile}\" alt=\"{$siteTitle}\">";
                    }
                }

                if ($siteTitle) {
                    $out .= '<span' . ($logoFile ? ' class="uk-display-inline-block uk-margin-small-left"' : '') . '>' . $siteTitle . '</span>';
                }

                $out .= "</{$logotag}>";
            } else {
                $out = '';
            }
        }

        return $out;
    }


    /*
     * Get component buffer
     * 
     * @return text/html
     */
    public function getSystemOutput()
    {
        if ($this->isNoContent) {
            return '';
        }

        $out = $this->doc->getBuffer('component');

        $clean = $out;
        $clean = htmlspecialchars(strip_tags($clean));
        $clean = str_replace("\t", '', $clean);
        $clean = str_replace("\n", '', $clean);
        $clean = trim($clean);

        return $clean ? $out : '';
    }


    /*
     * Get attributes for <html> tag
     * 
     * @return string
     */
    public function getHtmlAttrsibutes()
    {
        return trim($this->htmlAttrs);
    }


    /*
     * Get classes for <body> tag
     * 
     * @return string
     */
    public function getBodyClasses()
    {
        $app = Factory::getApplication();
        $out = [];

        $out[] = $this->bodyClass;

        $out[] = 'tmpl-layout--' . $this->getLayout();

        $out[] = 'sc-layout--' . $this->layoutName;

        $option = $app->input->getCmd('option', '');
        $out[] = $option ? 'option--' . $option : '';

        $view = $app->input->getCmd('view', '');
        $out[] = $view ? 'view--' . $view : '';

        $layout = $app->input->getCmd('layout', '');
        $out[] = $layout ? 'layout--' . $layout : '';

        $task = $app->input->getCmd('task', '');
        $out[] = $task ? 'task--' . $task : '';

        $Itemid = $app->input->getCmd('Itemid', '');
        $out[] = $Itemid ? 'Itemid--' . $Itemid : '';

        $menuItem = $app->getMenu('site')->getActive();
        $out[] = isset($menuItem) ? $menuItem->params->get('pageclass_sfx', '') : '';

        return trim(implode(' ', array_diff($out, ['', 0, null])));
    }


    /*
     * Get section params
     * 
     * @param string $sectionName
     * 
     * @return oject
     */
    public function getSectionParams($sectionName, $sectionType = 0)
    {
        $layouts = $this->params->get('sections');

        $layoutName = '';
        foreach ($layouts as $name => $layout) {
            if ($layout->active) {
                $layoutName = $name;
                break;
            }
        }

        if (!$layoutName) {
            foreach ($layouts as $name => $layout) {
                if (!$layout->menu) {
                    $layoutName = $name;
                    break;
                }
            }
        }

        if (isset($layouts[$layoutName]) && isset($layouts[$layoutName]->list[$sectionName])) {
            $section = $layouts[$layoutName]->list[$sectionName];
        } else {
            $section = new \stdClass();
            $section->id = $sectionName;
            $section->class = 'uk-section uk-section-default';
            $section->style = 'master3';
            $section->container = 'uk-container';
            $section->image = '';
            $section->responsive = '@m';
            $section->gridClass = '';

            if ($sectionType === 2) {
                $section->style = 'navbar';
            }

            if ($sectionName === 'breadcrumb') {
                $section->style = 'none';
            }
        }

        if ($sectionType === 1) {
            $section->sidebarGridSize = $this->params->get('sbWidth', '1-5');
            $section->sidebarAClass = $this->params->get('sbPosA', 1) ? 'uk-flex-first' . $section->responsive . ' ' : '';
            $section->sidebarBClass = $this->params->get('sbPosB', 1) ? 'uk-flex-first' . $section->responsive . ' ' : '';

            $countSidebarA = $this->doc->countModules('sidebar-a');
            $countSidebarB = $this->doc->countModules('sidebar-b');

            if (!$countSidebarA && !$countSidebarB) {
                $section->mainGridSize = '1-1';
                $section->responsive = '';
            } else {
                switch ($section->sidebarGridSize) {
                    case '1-6':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '4-6' : '5-6';
                        break;
                    case '1-5':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '3-5' : '4-5';
                        break;
                    case '1-4':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '1-2' : '3-4';
                        break;
                    case '1-3':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '1-3' : '2-3';
                        break;
                    case '2-5':
                        $section->mainGridSize = $countSidebarA && $countSidebarB ? '1-5' : '3-5';
                        break;
                    case '1-2':
                        $section->mainGridSize = '1-1';
                        break;
                }
            }
        }

        if ($sectionType === 2) {
            $section->class .= ' uk-navbar-container' . ($this->params->get('navbarTransparent', 0) ? ' uk-navbar-transparent' : '');

            $section->sticky = $this->params->get('navbarSticky', 0) ? ' data-uk-sticky' : '';
            $section->nbLeftDisplay = $this->params->get('nbLeftDisplay', '');
            $section->nbCenterDisplay = $this->params->get('nbCenterDisplay', '');
            $section->nbRightDisplay = $this->params->get('nbRightDisplay', '');

            $section->dropbarMode = false;
            $navbarMode = [];

            if ($this->params->get('navbarClickMode', 0)) {
                $navbarMode[] = 'mode:click';
            }

            if ($this->params->get('navbarDropbar', 0)) {
                $section->dropbarMode = true;
                $section->container .= ' uk-position-relative';

                $navbarMode[] = 'dropbar:true';

                if ($this->params->get('navbarDropbarPush', 0)) {
                    $navbarMode[] = 'dropbar-mode:push';
                }
            }

            $boundary = $this->params->get('navbarBoundary', '');
            if ($boundary && $boundary !== 'justify') {
                $navbarMode[] = 'boundary-align:true';
                $navbarMode[] = 'align:' . $boundary;
            }

            $section->navbarMode = $navbarMode ? '="' . implode(';', $navbarMode) . '"' : '';
        }

        $section->class = trim($section->class);

        return $section;
    }


    /*
     * Get off-canvas params
     * 
     * @param string $position
     * 
     * @retutn array
     */
    public function getOffcanvasParams($position)
    {
        $offcanvas = (array) $this->params->get('offcanvas');

        if (isset($offcanvas[$position])) {
            $oc = $offcanvas[$position];
        } else {
            $oc = new \stdClass();
            $oc->class = '';
            $oc->attrs = 'mode:slide;overlay:true';
        }

        $oc->id = $position;

        return $oc;
    }


    /*
     * Get modile params
     * 
     * @param string $moduleId
     * 
     * @return array
     */
    public function getModuleParams($moduleId)
    {
        $modules = (array) $this->params->get('modules');

        if (isset($modules[$moduleId])) {
            $module = $modules[$moduleId];
        } else {
            $module = new \stdClass();
            $module->class = 'uk-panel';
            $module->dataAttrs = '';
            $module->display = '';
            $module->align = '';
            $module->offtoggle = 0;
            $module->titleTag = 'module';
            $module->titleClass = '';
            $module->titleLink = '';
        }

        $module->id = $moduleId;

        return $module;
    }


    /*
     * Get off-canvas toggle sfx class
     * 
     * @retutn string
     */
    public function getOffcanvasToggle()
    {
        return $this->params->get('offtoggle', '@m');
    }


    /*
     * Get menuitem params
     * 
     * @param int $itemId
     * 
     * @retutn array
     */
    public function getMenuItemParams($itemId)
    {
        $menuItems = (array) $this->params->get('menuitems');

        if (isset($menuItems[$itemId])) {
            $menuItem = $menuItems[$itemId];
        } else {
            $menuItem = new \stdClass();
            $menuItem->subtitle = '';
            $menuItem->cols = 1;
            $menuItem->divider = false;
            $menuItem->dropdownJustify = false;
            $menuItem->dropdownClass = '';
        }

        $menuItem->id = $itemId;

        return $menuItem;
    }


    /*
     * Get DUA params
     * 
     * @retutn string
     */
    public function getDUA()
    {
        return (int) $this->params->get('denyUserAuthorization', 0);
    }
}
