<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

use PaypalApi\PaypalApiOptions;

$settings = [
    // 'btn_locale' => PaypalApiOptions::getPaypalBtnLocale(),
    'acceptterms' => PaypalApiOptions::isAcceptTermsOptionEnabled(),
    'btn_size' => PaypalApiOptions::getPaypalBtnSize(),
    'btn_color' => PaypalApiOptions::getPaypalBtnColor(),
    'btn_shape' => PaypalApiOptions::getPaypalBtnShape(),
    'btn_label' => PaypalApiOptions::getPaypalBtnLabel(),
    'btn_layout' => PaypalApiOptions::getPaypalBtnLayout(),
    'btn_fundingicons' => PaypalApiOptions::getPaypalBtnFundingIcons(),
    'btn_tagline' => PaypalApiOptions::getPaypalBtnTagline(),
];

?>

define(<?php echo json_encode($settings); ?>);
