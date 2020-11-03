<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

$errorLevelStr = Factory::getConfig()->get('error_reporting', 'default');
$isShowFile = ($errorLevelStr === 'maximum') || ($errorLevelStr === 'development');
$isBacktrace = $errorLevelStr === 'development';

$errorCode = $this->error->getCode();
$errorFile = str_replace(JPATH_ROOT, 'JROOT', $this->error->getFile());
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta charset="utf-8" />
    <base href="<?php echo Uri::base(); ?>" />
    <title><?php echo $this->title; ?> – <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link href="<?php echo Uri::base(true); ?>/media/master3/images/favicon.png" rel="shortcut icon" type="image/png" />
    <link href="<?php echo Uri::base(true); ?>/media/uikit3/dist/css/uikit.min.css" rel="stylesheet" />
</head>
<body>


    <header class="uk-section uk-section-default uk-section-small">
        <div class="uk-container">
            <div class="uk-logo"><?php echo Factory::getConfig()->get('sitename', $this->template); ?></div>
        </div>
    </header>


    <div class="uk-section uk-section-muted uk-padding-remove">
        <div class="uk-container">
            <div class="uk-navbar">
                <ul class="uk-navbar-nav">
                    <li><a href="<?php echo Uri::base(true) ?: '/'; ?>"><?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div>
                <h1><?php echo Text::_(($errorCode == 404 ? 'JERROR_LAYOUT_PAGE_NOT_FOUND' : 'JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND')); ?></h1>

                <div class="uk-margin-large-top"><?php echo Text::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></div>

                <div class="uk-h3"><?php echo $errorCode, ': ', htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></div>

                <?php if ($isShowFile) { ?>
                <div class="uk-h4 uk-margin-remove-top"><?php echo htmlspecialchars($errorFile, ENT_QUOTES, 'UTF-8'), ':', $this->error->getLine(); ?></div>
                <?php } ?>

                <?php if ($isBacktrace) { ?>
                <div class="uk-margin-large-top">
                    <?php
                    echo $this->renderBacktrace();
                    if ($this->error->getPrevious()) {
                        $loop = true;
                        $this->setError($this->_error->getPrevious());
                        while ($loop === true) {
                    ?>
                    <p><strong><?php echo JText::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
                    <p><?php
                        echo
                            htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'), '<br>',
                            htmlspecialchars($this->_error->getFile(), ENT_QUOTES, 'UTF-8'), ':', $this->_error->getLine();
                        ?></p>
                    <?php
                            echo $this->renderBacktrace();
                            $loop = $this->setError($this->_error->getPrevious());
                        }
                        $this->setError($this->error);
                    }
                    ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>


</body>
</html>

