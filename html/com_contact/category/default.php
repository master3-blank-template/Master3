<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

if ($this->params->get('show_page_heading') != 0) {
?>
<h1 class="uk-article-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php
}

$this->subtemplatename = 'items';
echo LayoutHelper::render('joomla.content.category_default', $this);
