<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$selector = empty($displayData['selector']) ? '' : $displayData['selector'];

?>

<ul class="uk-tab" id="<?php echo $selector; ?>Tabs" data-uk-tab="connect:#<?php echo $selector; ?>Content"></ul>
<ul class="uk-switcher uk-margin-top" id="<?php echo $selector; ?>Content">
