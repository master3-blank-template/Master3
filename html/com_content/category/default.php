<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

?>
<div class="category-list<?php echo $this->pageclass_sfx; ?>">
    <?php
    $this->subtemplatename = 'articles';
    echo LayoutHelper::render( 'joomla.content.category_default', $this );
    ?>
</div>
