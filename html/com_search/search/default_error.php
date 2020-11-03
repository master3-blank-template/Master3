<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if ($this->error) {
?>
<div class="uk-alert uk-alert-danger">
    <?php echo $this->escape($this->error); ?>
</div>
<?php
}
