<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_fields
 * @copyright   Copyright (C) Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!key_exists('item', $displayData) || !key_exists('context', $displayData)) {
    return;
}

$item = $displayData['item'];

if (!$item) {
    return;
}

$context = $displayData['context'];

if (!$context) {
    return;
}

\JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');

$parts = explode('.', $context);
$component = $parts[0];
$fields = null;

if (key_exists('fields', $displayData)) {
    $fields = $displayData['fields'];
} else {
    $fields = $item->jcfields ? : \FieldsHelper::getFields($context, $item, true);
}

if (!$fields) {
    return;
}

?>
<dl class="uk-description-list fields-container">
    <?php
    foreach ($fields as $field) {
        if (!isset($field->value) || $field->value == '') {
            continue;
        }
        $class = $field->params->get('render_class');
        ?>
        <?php echo \FieldsHelper::render($context, 'field.render', array('field' => $field, 'class' => $class)); ?>
    <?php } ?>
</dl>
