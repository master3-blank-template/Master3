<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.vote
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

/**
 * Layout variables
 * -----------------
 * @var   string   $context  The context of the content being passed to the plugin
 * @var   object   &$row     The article object
 * @var   object   &$params  The article params
 * @var   integer  $page     The 'page' number
 * @var   array    $parts    The context segments
 * @var   string   $path     Path to this file
 */

$uri = clone Uri::getInstance();
$uri->setVar('hitcount', '0');

// Create option list for voting select box
$options = [];

for ($i = 1; $i < 6; $i++)
{
	$options[] = HTMLHelper::_('select.option', $i, Text::sprintf('PLG_VOTE_VOTE', $i));
}

?>
<form method="post" action="<?php echo htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8'); ?>" class="uk-margin-small-top uk-margin-bottom">
	<span class="uk-flex-inline content_vote">
		<label class="uk-hidden" for="content_vote_<?php echo (int) $row->id; ?>"><?php echo Text::_('PLG_VOTE_LABEL'); ?></label>
		<?php echo HTMLHelper::_('select.genericlist', $options, 'user_rating', ['class' => 'uk-select uk-form-small uk-width-small'], 'value', 'text', '5', 'content_vote_' . (int) $row->id); ?>
		<input class="uk-button uk-button-small uk-margin-small-left" type="submit" name="submit_vote" value="<?php echo Text::_('PLG_VOTE_RATE'); ?>" />
		<input type="hidden" name="task" value="article.vote" />
		<input type="hidden" name="hitcount" value="0" />
		<input type="hidden" name="url" value="<?php echo htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8'); ?>" />
		<?php echo HTMLHelper::_('form.token'); ?>
	</span>
</form>
