<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/**
 * Make thing clear
 *
 * @var JForm   $form       The form instance for render the section
 * @var string  $basegroup  The base group name
 * @var string  $group      Current group name
 * @var array   $buttons    Array of the buttons that will be rendered
 */
extract($displayData);

?>

<div class="subform-tabs-group" data-base-name="<?php echo $basegroup; ?>" data-group="<?php echo $group; ?>">

	<?php foreach ($form->getFieldsets() as $fieldset) { ?>
	<fieldset <?php if (!empty($fieldset->class)) { echo 'class="' . $fieldset->class . '"'; } ?>>
		
		<?php if (!empty($fieldset->label)) { ?>
		<legend><?php echo Text::_($fieldset->label); ?></legend>
		<?php } ?>

		<?php
		foreach ($form->getFieldset($fieldset->name) as $field) {
			echo $field->renderField();
		}
		?>
		
	</fieldset>
	<?php } ?>

</div>
