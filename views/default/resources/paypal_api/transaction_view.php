<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

// restrict pages only to admins
elgg_admin_gatekeeper();

// get entity
$guid = elgg_extract('guid', $vars, '');
$entity = get_entity($guid);

$error_msg = '';

if (!$entity instanceof \PaypalTransaction) {
    $error_msg = elgg_echo('paypal_api:error:invalid_entity');
}

if (!empty($error_msg)) {
    echo elgg_format_element('h3', ['class'=>''], $error_msg); 
}
else {
    $title = elgg_format_element('div', 
        ['class' => 'elgg-head'], 
        elgg_format_element('h3', [], $entity->title)
    );
    
    $vars['entity'] = $entity;
    $vars['title_view'] = false;
    $vars['show_responses'] = false;
        
    $content = elgg_format_element('div', 
        ['style' => 'width:850px;height:600px;overflow-y: auto'], 
        elgg_view_entity($entity, $vars)
    );
    
    echo elgg_format_element('div', ['class'=>'elgg-module elgg-module-info'], $title.$content); 
}



