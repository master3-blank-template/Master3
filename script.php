<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Version;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Installer\InstallerHelper;
use Joomla\Archive\Archive;

class master3InstallerScript
{
    protected $files = [
        '/layouts/joomla/form/field/subform/tabs.php',
        '/layouts/joomla/form/field/subform/tabs/section.php',
        '/media/master3/aes/aes.css',
        '/media/master3/aes/aes.js',
        '/media/master3/images/favicon.png',
        '/media/master3/images/apple-touch-icon.png',
        '/media/master3/images/master3logo.svg',
        '/media/system/css/subform-tabs.css',
        '/libraries/master3/fields/aes.php',
        '/libraries/master3/fields/poslist.php',
        '/libraries/master3/fields/subformfiles.php',
        '/libraries/master3/fields/subformlayouts.php',
        '/libraries/master3/fields/subformmenus.php',
        '/libraries/master3/fields/subformmodules.php',
        '/libraries/master3/fields/subformoffcanvas.php',
        '/libraries/master3/fields/subformsections.php',
        '/libraries/master3/forms/files.xml',
        '/libraries/master3/forms/layouts.xml',
        '/libraries/master3/forms/menus.xml',
        '/libraries/master3/forms/modules.xml',
        '/libraries/master3/forms/offcanvas.xml',
        '/libraries/master3/forms/sections.xml',
        '/libraries/master3/config.php'
    ];

    protected $dirs = [
        '/layouts/joomla/form/field/subform/tabs/',
        '/libraries/master3/fields/',
        '/libraries/master3/forms/',
        '/libraries/master3/images/',
        '/libraries/master3/',
        '/media/master3/images/',
        '/media/master3/aes/',
        '/media/master3/'
    ];

    function preflight($type, $parent)
    {
        $minJoomlaVersion = $parent->get('manifest')->attributes()->version[0];

        if (!class_exists('Joomla\CMS\Version')) {
            JFactory::getApplication()->enqueueMessage(JText::sprintf('J_JOOMLA_COMPATIBLE', JText::_($parent->manifest->name[0]), $minJoomlaVersion), 'error');
            return false;
        }

        if (strtolower($type) === 'install' && Version::MAJOR_VERSION < 4) {
            $msg = '';
            $name = Text::_($parent->manifest->name[0]);
            $minPhpVersion = $parent->manifest->php_minimum[0];

            $ver = new Version();

            if (version_compare($ver->getShortVersion(), $minJoomlaVersion, 'lt')) {
                $msg .= Text::sprintf('J_JOOMLA_COMPATIBLE', $name, $minJoomlaVersion);
            }

            if (version_compare(phpversion(), $minPhpVersion, 'lt')) {
                $msg .= Text::sprintf('J_PHP_COMPATIBLE', $name, $minPhpVersion);
            }

            if ($msg) {
                Factory::getApplication()->enqueueMessage($msg, 'error');
                return false;
            }

            $this->uninstall_old($parent);
        }

        if (strtolower($type) === 'uninstall') {
            $this->uninstall($parent);
        }
    }

    function postflight($type, $parent)
    {
        if (strtolower($type) === 'uninstall') {
            return;
        }

        $msg = '';

        foreach ($this->files as $file) {
            $srcfile = Path::clean(__DIR__ . '/script' . $file);
            $dstfile = Path::clean(JPATH_ROOT . $file);
            if (!is_dir(dirname($dstfile))) {
                mkdir(dirname($dstfile), 0755, true);
            }
            if (!copy($srcfile, $dstfile)) {
                $msg .= Text::sprintf('TPL_MASTER3_UNABLE_TO_COPY', $file);
            }
        }

        $srcfile = Path::clean(JPATH_ROOT . '/templates/master3/layouts/template.default-original.php');
        $dstfile = Path::clean(JPATH_ROOT . '/templates/master3/layouts/template.default.php');
        if (!file_exists($dstfile)) {
            if (!copy($srcfile, $dstfile)) {
                $msg .= Text::sprintf('TPL_MASTER3_UNABLE_TO_COPY', 'template.default-original.php => template.default.php in /templates/master3/layouts/');
            }
        }

        $srcfile = Path::clean(JPATH_ROOT . '/templates/master3/layouts/template.error-original.php');
        $dstfile = Path::clean(JPATH_ROOT . '/templates/master3/layouts/template.error.php');
        if (!file_exists($dstfile)) {
            if (!copy($srcfile, $dstfile)) {
                $msg .= Text::sprintf('TPL_MASTER3_UNABLE_TO_COPY', 'template.error-original.php => template.error.php in /templates/master3/layouts/');
            }
        }

        $srcfile = Path::clean(JPATH_ROOT . '/templates/master3/layouts/template.offline-original.php');
        $dstfile = Path::clean(JPATH_ROOT . '/templates/master3/layouts/template.offline.php');
        if (!file_exists($dstfile)) {
            if (!copy($srcfile, $dstfile)) {
                $msg .= Text::sprintf('TPL_MASTER3_UNABLE_TO_COPY', 'template.offline-original.php => template.offline.php in /templates/master3/layouts/');
            }
        }

        $srcfile = Path::clean(__DIR__ . '/script/update/custom.css');
        $dstfile = Path::clean(JPATH_ROOT . '/templates/master3/css/custom.css');
        if (!file_exists($dstfile)) {
            if (!is_dir(dirname($dstfile))) {
                mkdir(dirname($dstfile), 0755, true);
            }
            if (!copy($srcfile, $dstfile)) {
                $msg .= Text::sprintf('TPL_MASTER3_UNABLE_TO_CREATE', 'custom.css in /templates/master3/css/');
            }
        }

        $srcfile = Path::clean(__DIR__ . '/script/update/custom.js');
        $dstfile = Path::clean(JPATH_ROOT . '/templates/master3/js/custom.js');
        if (!file_exists($dstfile)) {
            if (!is_dir(dirname($dstfile))) {
                mkdir(dirname($dstfile), 0755, true);
            }
            if (!copy($srcfile, $dstfile)) {
                $msg .= Text::sprintf('TPL_MASTER3_UNABLE_TO_CREATE', 'custom.js in /templates/master3/js/');
            }
        }

        $result = $this->installUikit3($parent);
        if ($result !== true) {
            $msg .= Text::sprintf('TPL_MASTER3_UIKIT3_INSTALLATION_ERROR', $result);
        }

        if ($msg) {
            Factory::getApplication()->enqueueMessage($msg, 'error');
            return false;
        }
    }

    function uninstall($parent)
    {
        foreach ($this->files as $file) {
            \JFile::delete(Path::clean(JPATH_ROOT . $file));
            InstallerHelper::cleanupInstall(Path::clean(JPATH_ROOT . $file));
        }
        foreach ($this->dirs as $dir) {
            \JFolder::delete(Path::clean(JPATH_ROOT . $dir));
            InstallerHelper::cleanupInstall(Path::clean(JPATH_ROOT . $dir));
        }
    }

    function uninstall_old()
    {
        $old_files = [
            '/libraries/master3/fields/aes.css',
            '/libraries/master3/fields/aes.js',
            '/libraries/master3/fields/version.php',
            '/libraries/master3/images/favicon.png',
            '/libraries/master3/images/apple-touch-icon.png',
            '/libraries/master3/images/master3logo.svg'
        ];

        $old_dirs = [
            '/libraries/master3/images/',
            '/templates/master3/uikit/'
        ];

        foreach ($old_files as $file) {
            $_file = Path::clean(JPATH_ROOT . $file);
            if (is_file($_file)) {
                \JFile::delete($_file);
                InstallerHelper::cleanupInstall($_file);
            }
        }
        foreach ($old_dirs as $dir) {
            $_dir = Path::clean(JPATH_ROOT . $dir);
            if (is_file($_dir)) {
                \JFolder::delete($_dir);
                InstallerHelper::cleanupInstall($_dir);
            }
        }
    }

    private function installUikit3($parent)
    {
        $isUikit3 = false;
        $actualVersion = (string) $parent->manifest->uikit_actual[0];

        $manifestFile = Path::clean(JPATH_ADMINISTRATOR . '/manifests/files/file_uikit3.xml');

        if (file_exists(Path::clean($manifestFile))) {
            $xml = @simplexml_load_file($manifestFile);
            if ($xml) {
                $xml = (array) $xml;
                $uikitVersion = $xml['version'];
                if (!version_compare($actualVersion, $uikitVersion, 'gt')) {
                    $isUikit3 = true;
                }
            }
            unset($xml);
        }

        if (!$isUikit3) {

            $tmp = Factory::getConfig()->get('tmp_path');
            $uikitFile = 'https://master3.alekvolsk.info/files/uikit3_v' . $actualVersion . '_j3.zip';
            $tmpFile = Path::clean($tmp . '/uikit3_v' . $actualVersion . '_j3.zip');
            $extDir = Path::clean($tmp . '/' . uniqid('install_'));

            $contents = file_get_contents($uikitFile);
            if ($contents === false) {
                return Text::sprintf('TPL_MASTER3_UIKIT3_IE_FAILED_DOWNLOAD', $uikitFile);
            }

            $resultContents = file_put_contents($tmpFile, $contents);
            if ($resultContents == false) {
                return Text::sprintf('TPL_MASTER3_UIKIT3_IE_FAILED_INSTALLATION', $tmpFile);
            }

            if (!file_exists($tmpFile)) {
                return Text::sprintf('TPL_MASTER3_UIKIT3_IE_NOT_EXISTS', $tmpFile);
            }

            $archive = new Archive(['tmp_path' => $tmp]);
            try {
                $archive->extract($tmpFile, $extDir);
            } catch (\Exception $e) {
                return Text::sprintf('TPL_MASTER3_UIKIT3_IE_FAILER_UNZIP', $tmpFile, $extDir, $e->getMesage());
            }

            $installer = new Installer();
            $installer->setPath('source', $extDir);
            if (!$installer->findManifest()) {
                InstallerHelper::cleanupInstall($tmpFile, $extDir);
                return Text::_('TPL_MASTER3_UIKIT3_IE_INCORRECT_MANIFEST');
            }

            if (!$installer->install($extDir)) {
                InstallerHelper::cleanupInstall($tmpFile, $extDir);
                return Text::_('TPL_MASTER3_UIKIT3_IE_INSTALLER_ERROR');
            }

            InstallerHelper::cleanupInstall($tmpFile, $extDir);
        }

        return true;
    }
}
