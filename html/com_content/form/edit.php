<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::_('behavior.tabstate');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

JLoader::register('Master3Config', JPATH_LIBRARIES . '/master3/config.php');
$templateConfig = \Master3Config::getInstance();
$jsIcons = $templateConfig->params->get('jsIcons', 'none');

$this->tab_name = 'com-content-form';
$this->ignore_fieldsets = array('image-intro', 'image-full', 'jmetadata', 'item_associations');

// Create shortcut to parameters.
$params = $this->state->get('params');

// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings.
$editoroptions = isset($params->show_publishing_options);

if (!$editoroptions) {
    $params->show_urls_images_frontend = '0';
}

Factory::getDocument()->addScriptDeclaration("
    Joomla.submitbutton = function( task )
    {
        if ( task == 'article.cancel' || document.formvalidator.isValid( document.getElementById( 'adminForm' ) ) )
        {
            " . $this->form->getField('articletext')->save() . "
            Joomla.submitform( task );
        }
    }
");

?>
<div class="uk-article edit item-page<?php echo $this->pageclass_sfx; ?>">
    <?php if ($params->get('show_page_heading')) { ?>
    <div class="uk-article-title">
        <h1><?php echo $this->escape($params->get('page_heading')); ?></h1>
    </div>
    <?php } ?>

    <form action="<?php echo Route::_('index.php?option=com_content&a_id=' . ( int )$this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">

        <?php
        echo HTMLHelper::_('bootstrap.startTabSet', $this->tab_name, array('uk-active' => 'editor'));

        echo HTMLHelper::_('bootstrap.addTab', $this->tab_name, 'editor', Text::_('COM_CONTENT_ARTICLE_CONTENT'));
        echo $this->form->renderField('title');

        if (is_null($this->item->id)) {
            echo $this->form->renderField('alias');
        }

        echo $this->form->getInput('articletext');

        if ($this->captchaEnabled) {
            echo $this->form->renderField('captcha');
        }
        echo HTMLHelper::_('bootstrap.endTab');

        if ($params->get('show_urls_images_frontend')) {
            echo HTMLHelper::_('bootstrap.addTab', $this->tab_name, 'images', Text::_('COM_CONTENT_IMAGES_AND_URLS'));

            echo $this->form->renderField('image_intro', 'images');
            echo $this->form->renderField('image_intro_alt', 'images');
            echo $this->form->renderField('image_intro_caption', 'images');

            $this->form->setFieldAttribute('float_intro', 'class', 'uk-select', 'images');
            echo $this->form->renderField('float_intro', 'images');

            echo $this->form->renderField('image_fulltext', 'images');
            echo $this->form->renderField('image_fulltext_alt', 'images');
            echo $this->form->renderField('image_fulltext_caption', 'images');

            $this->form->setFieldAttribute('float_fulltext', 'class', 'uk-select', 'images');
            echo $this->form->renderField('float_fulltext', 'images');

            echo $this->form->renderField('urla', 'urls');
            echo $this->form->renderField('urlatext', 'urls');
            echo $this->form->getInput('targeta', 'urls');

            echo $this->form->renderField('urlb', 'urls');
            echo $this->form->renderField('urlbtext', 'urls');
            echo $this->form->getInput('targetb', 'urls');

            echo $this->form->renderField('urlc', 'urls');
            echo $this->form->renderField('urlctext', 'urls');
            echo $this->form->getInput('targetc', 'urls');

            echo HTMLHelper::_('bootstrap.endTab');
        }

        echo LayoutHelper::render('joomla.edit.params', $this);

        echo HTMLHelper::_('bootstrap.addTab', $this->tab_name, 'publishing', Text::_('COM_CONTENT_PUBLISHING'));

        $this->form->setFieldAttribute('catid', 'class', 'uk-select');
        echo $this->form->renderField('catid');

        $this->form->setFieldAttribute('tags', 'size', null);
        $this->form->setFieldAttribute('tags', 'class', 'uk-select', null);
        echo $this->form->renderField('tags');

        if ($params->get('save_history', 0)) {
            echo $this->form->renderField('version_note');
        }

        if ($params->get('show_publishing_options', 1) == 1) {
            echo $this->form->renderField('created_by_alias');
        }

        if ($this->item->params->get('access-change')) {
            $this->form->setFieldAttribute('state', 'size', null);
            $this->form->setFieldAttribute('state', 'class', 'uk-select');
            echo $this->form->renderField('state');

            $this->form->setFieldAttribute('featured', 'class', 'uk-select');
            echo $this->form->renderField('featured');

            if ($params->get('show_publishing_options', 1) == 1) {
                echo $this->form->renderField('publish_up');
                echo $this->form->renderField('publish_down');
            }
        }

        $this->form->setFieldAttribute('access', 'size', null);
        $this->form->setFieldAttribute('access', 'class', 'uk-select');
        echo $this->form->renderField('access');

        echo HTMLHelper::_('bootstrap.endTab');

        echo HTMLHelper::_('bootstrap.addTab', $this->tab_name, 'language', Text::_('JFIELD_LANGUAGE_LABEL'));

        $this->form->setFieldAttribute('language', 'class', 'uk-select');
        echo $this->form->renderField('language');

        echo HTMLHelper::_('bootstrap.endTab');

        if ($params->get('show_publishing_options', 1) == 1) {
            echo HTMLHelper::_('bootstrap.addTab', $this->tab_name, 'metadata', Text::_('COM_CONTENT_METADATA'));

            echo $this->form->renderField('metadesc');
            echo $this->form->renderField('metakey');

            echo HTMLHelper::_('bootstrap.endTab');
        }

        echo HTMLHelper::_('bootstrap.endTabSet');
        ?>

        <input type="hidden" name="task" value="">
        <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
        <?php echo HTMLHelper::_('form.token'); ?>

        <hr class="uk-margin-medium">

        <div class="uk-flex">
            <button type="button" class="uk-button uk-button-primary uk-margin-small-right" onclick="Joomla.submitbutton( 'article.save' )"><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:ok"></span>' : ''), Text::_('JSAVE') ?></button>
            <button type="button" class="uk-button uk-button-default uk-margin-small-right" onclick="Joomla.submitbutton( 'article.cancel' )"><?php echo ($jsIcons ? '<span class="uk-margin-small-right" data-uk-icon="icon:cancel"></span>' : ''), Text::_('JCANCEL') ?></button>

            <?php
            if ($params->get('save_history', 0) && $this->item->id) {
                echo $this->form->getInput('contenthistory');
            }
            ?>
        </div>
    </form>
</div>
