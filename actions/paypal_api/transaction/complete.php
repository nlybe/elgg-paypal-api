<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

use PaypalApi\PaypalApiOptions;

elgg_ajax_gatekeeper();

$result = [
    'error' => false,
];

$q = get_input('q');
$transaction = json_decode($q);

// Buyer validation
$custom = $transaction->purchase_units[0]->custom_id;
if (!$custom) {
    $result['error'] = true;
    register_error(elgg_echo('paypal_api:error:invalid:entity:user'));
}

$custom_arr = explode("-", $custom);
$buyer = get_entity($custom_arr[1]);
if (!$buyer instanceof \ElggUser) {
    $result['error'] = true;
    register_error(elgg_echo('paypal_api:error:invalid:user:missing'));
}

$user = elgg_get_logged_in_user_entity();
if ($buyer->guid !== $user->guid) {
    $result['error'] = true;
    register_error(elgg_echo('paypal_api:error:invalid:user:guid'));
}

// If everything is OK, log transaction
PaypalApiOptions::paypalLogTransaction($transaction);

// will be rendered client-side
system_message(elgg_echo('paypal_api:transaction:success'));

echo json_encode($result);

