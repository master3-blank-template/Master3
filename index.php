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

$htmlAttrs = $config->getHtmlAttrsibutes();
$htmlAttrs = $htmlAttrs ? ' ' . $htmlAttrs : '';

$bodyClass = $config->getBodyClasses();
$bodyClass = $bodyClass ? ' class="' . $bodyClass . '"' : '';

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"<?php echo $htmlAttrs; ?>>
<head>
    <jdoc:include type="head"/>
</head>
<body<?php echo $bodyClass; ?>>


    <?php
    /*
     * include layout
     * layout name === active menu item alias
     * if no layer is found for the active menu item, the default layer is used
     */
    include(realpath(__DIR__ . '/layouts/template.' . $config->getLayout() . '.php'));
    ?>


</body>
</html>
