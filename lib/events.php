<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 *
 * All events are here
 */

/**
 * Register menu in admin area
 * 
 * @param \Elgg\Event $event
 */ 
function paypal_api_admin_menu(\Elgg\Event $event) {
    if (!elgg_in_context('admin')) {
        return null;
    }
    
    /* @var $return MenuItems */
    $result = $event->getValue();
    
    $result[] = \ElggMenuItem::factory([
        'name' => 'paypal_transactions',
        'href' => elgg_normalize_url('admin/paypal_api/transactions'),
        'text' => elgg_echo('admin:paypal_api:menu:transactions'),
        'parent_name' => 'information',
    ]);
    
    return $result;
}