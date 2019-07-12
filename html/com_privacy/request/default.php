<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_privacy
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

/** @var PrivacyViewRequest $this */

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

?>
<div class="request-form<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) { ?>
	<h1 class="uk-article-title">
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php } ?>
	<?php if ($this->sendMailEnabled) { ?>
		<form action="<?php echo Route::_('index.php?option=com_privacy&task=request.submit'); ?>" method="post" class="form-validate form-horizontal well">
			<?php
			foreach ($this->form->getFieldsets() as $fieldset) {
				if (!empty($fieldset->label)) {
				?>
				<legend><?php echo Text::_($fieldset->label); ?></legend>
				<?php
				}
				echo $this->form->renderFieldset($fieldset->name);
			?>
			<?php } ?>
			<div class="uk-margin-top">
				<button type="submit" class="uk-button uk-button-primary validate"><?php echo Text::_('JSUBMIT'); ?></button>
			</div>
			<?php echo HTMLHelper::_('form.token'); ?>
		</form>
	<?php } else { ?>
		<div class="uk-alert uk-alert-warning">
			<p><?php echo Text::_('COM_PRIVACY_WARNING_CANNOT_CREATE_REQUEST_WHEN_SENDMAIL_DISABLED'); ?></p>
		</div>
	<?php } ?>
</div>
