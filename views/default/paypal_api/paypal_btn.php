<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

use PaypalApi\PaypalApiOptions;

elgg_require_js('paypal_api/paypal_btn'); 


$paypal_btn_vars = ['id' => 'paypal_btn'];
if ($isAcceptTermsOptionEnabled = PaypalApiOptions::isAcceptTermsOptionEnabled()) {
    $paypal_btn_vars['class'] = 'paypal_btn_disabled';
    echo elgg_view('paypal_api/accept_terms');
}
else {
    // hack for not having exceptions js issues
    echo elgg_format_element("div", ['id' => 'acceptterms', 'class' => 'display:none;'], '');
}
echo elgg_format_element('div', $paypal_btn_vars, '');

echo elgg_format_element('div', [
    'id' => 'ppinfo', 
    'class' => 'ppinfo', 
    'data-env' => PaypalApiOptions::getPaypalModeURL(),
    'data-intent' => 'CAPTURE',
    'data-amount' => $vars['amount'],
    'data-item_reference_id' => $vars['item_reference_id'],
    'data-item_name' => $vars['item_name'],
    'data-custom_id' => $vars['custom_id'],
    'data-custom_success_msg' => $vars['custom_success_msg'],
], '');

$client_id = $vars['client-id']?$vars['client-id']:PaypalApiOptions::getSitePayPalClientID();

$args = [];
$args['client-id'] = $client_id;
$args['currency'] = $vars['currency'];
// $args['locale']  = PaypalApiOptions::getPaypalBtnLocale(); // OBS, see notes in settings.php

$script_url = http_build_query($args);
$script_url = 'https://www.paypal.com/sdk/js?'.$script_url;

echo elgg_format_element('script', [
    'src' => $script_url, 
    'data-partner-attribution-id' => 'TipsandTricks_SP', 
], '');