<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
/**
 * Make thing clear
 * @var JForm   $form       The form instance for render the section
 * @var string  $basegroup  The base group name
 * @var string  $group      Current group name
 * @var array   $buttons    Array of the buttons that will be rendered
 */
extract($displayData);

?>

<div class="subform-repeatable-group uk-margin-sma;;" data-base-name="<?php echo $basegroup; ?>" data-group="<?php echo $group; ?>">
    <?php if (!empty($buttons)) { ?>
    <div class="uk-text-right">
        <div class="uk-button-group">
            <?php if (!empty($buttons['add'])) { ?><a class="uk-button uk-button-small uk-button-primary group-add btn btn-mini button btn-success" data-uk-tooltip="<?php echo Text::_('JGLOBAL_FIELD_ADD'); ?>"><span data-uk-icon="icon:plus" aria-hidden="true"></span> </a><?php } ?>
            <?php if (!empty($buttons['remove'])) { ?><a class="uk-button uk-button-small uk-button-danger group-remove btn btn-mini button btn-danger" data-uk-tooltip="<?php echo Text::_('JGLOBAL_FIELD_REMOVE'); ?>"><span data-uk-icon="icon:minus" aria-hidden="true"></span> </a><?php } ?>
            <?php if (!empty($buttons['move'])) { ?><a class="uk-button uk-button-small uk-button-primary group-move btn btn-mini button btn-primary" data-uk-tooltip="<?php echo Text::_('JGLOBAL_FIELD_MOVE'); ?>"><span data-uk-icon="icon:move" aria-hidden="true"></span> </a><?php } ?>
        </div>
    </div>
    <?php
    }
    
    foreach ($form->getGroup('') as $field) {
        echo $field->renderField();
    }
    ?>
</div>
