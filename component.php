<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.master3
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$config = \Master3Config::getInstance();
$systemOutput = $config->getSystemOutput();

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="head"/>
</head>
<body class="<?php echo $config->getBodyClasses(); ?>">
    <jdoc:include type="message" />
    <?php if ($systemOutput) { ?>
    <main id="content">
        <?php echo $systemOutput; ?>
    </main>
    <?php } ?>
</body>
</html>
