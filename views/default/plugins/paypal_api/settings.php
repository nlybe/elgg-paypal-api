<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */
    
use PaypalApi\PaypalApiOptions;

$plugin = elgg_get_plugin_from_id('paypal_api');

// PayPal Mode
$options_paypal_mode = [
    PaypalApiOptions::PAPI_MODE_LIVE => elgg_echo('paypal_api:settings:mode:'.PaypalApiOptions::PAPI_MODE_LIVE),
    PaypalApiOptions::PAPI_MODE_SANDBOX => elgg_echo('paypal_api:settings:mode:'.PaypalApiOptions::PAPI_MODE_SANDBOX),
];

$basic_settings .= elgg_view_field([
    '#type' => 'dropdown',
    'name' => 'params[paypal_mode]',
    'value' => ($plugin->paypal_mode?$plugin->paypal_mode:PaypalApiOptions::PAPI_MODE_SANDBOX),
    'options_values' => $options_paypal_mode,
    '#label' => elgg_echo('paypal_api:settings:paypal_mode'),
    '#help' => elgg_echo('paypal_api:settings:paypal_mode:help'),
]); 

// PayPal Client ID
$basic_settings .= elgg_view_field([
    '#type' => 'text',
    'name' => 'params[cliend_id]',
    'value' => $plugin->cliend_id,
    '#label' => elgg_echo('paypal_api:settings:cliend_id'),
    '#help' => elgg_echo('paypal_api:settings:cliend_id:help'),
    'required' => false,
]);

$basic_settings .= elgg_view_field([
    '#type' => 'checkbox',
    'name' => 'params[acceptterms]',
    'default' => 'no',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->acceptterms === 'yes'),  
    '#label' => elgg_echo('paypal_api:settings:acceptterms'),
    '#help' => elgg_echo('paypal_api:settings:acceptterms:help'),
]);

$basic_settings .= elgg_view_field([
    '#type' => 'longtext',
    'name' => 'params[acceptterms_txt]',
    'value' => $plugin->acceptterms_txt,
    '#label' => elgg_echo('paypal_api:settings:acceptterms_txt'),
    '#help' => elgg_echo('paypal_api:settings:acceptterms_txt:help'),
    'required' => false,
]);

$basic_title = elgg_format_element('h3', [], elgg_echo('paypal_api:settings:basic_title'));
echo elgg_view_module('inline', '', $basic_settings, ['header' => $basic_title]);

// Customize the PayPal Checkout Button

// The locale renders components. By default PayPal smartly detects the correct locale for the buyer based on their geolocation and browser preferences. 
// It is recommended to pass this parameter only if you need the PayPal buttons to render in the same language as the rest of your site
// $btn_settings .= elgg_view_field([
//     '#type' => 'text',
//     'name' => 'params[btn_locale]',
//     'value' => $plugin->btn_locale,
//     '#label' => elgg_echo('paypal_api:settings:btn_locale'),
//     '#help' => elgg_echo('paypal_api:settings:btn_locale:help'),
//     'required' => false,
// ]);

$btn_settings .= elgg_view_field([
    '#type' => 'dropdown',
    'name' => 'params[btn_size]',
    'value' => ($plugin->btn_size?$plugin->btn_size:'medium'),
    'options_values' => [
        'small' => elgg_echo('paypal_api:settings:btn_size:small'),
        'medium' => elgg_echo('paypal_api:settings:btn_size:medium'),
        'large' => elgg_echo('paypal_api:settings:btn_size:large'),
        'responsive' => elgg_echo('paypal_api:settings:btn_size:responsive'),
    ],
    '#label' => elgg_echo('paypal_api:settings:btn_size'),
    '#help' => elgg_echo('paypal_api:settings:btn_size:help'),
]);

$btn_settings .= elgg_view_field([
    '#type' => 'dropdown',
    'name' => 'params[btn_color]',
    'value' => ($plugin->btn_color?$plugin->btn_color:'gold'),
    'options_values' => [
        'gold' => elgg_echo('paypal_api:settings:btn_color:gold'),
        'blue' => elgg_echo('paypal_api:settings:btn_color:blue'),
        'silver' => elgg_echo('paypal_api:settings:btn_color:silver'),
        'white' => elgg_echo('paypal_api:settings:btn_color:white'),
        'black' => elgg_echo('paypal_api:settings:btn_color:black'),
    ],
    '#label' => elgg_echo('paypal_api:settings:btn_color'),
    '#help' => elgg_echo('paypal_api:settings:btn_color:help'),
]);

$btn_settings .= elgg_view_field([
    '#type' => 'dropdown',
    'name' => 'params[btn_shape]',
    'value' => ($plugin->btn_shape?$plugin->btn_shape:'pill'),
    'options_values' => [
        'pill' => elgg_echo('paypal_api:settings:btn_shape:pill'),
        'rect' => elgg_echo('paypal_api:settings:btn_shape:rect'),
    ],
    '#label' => elgg_echo('paypal_api:settings:btn_shape'),
    '#help' => elgg_echo('paypal_api:settings:btn_shape:help'),
]);

$btn_settings .= elgg_view_field([
    '#type' => 'dropdown',
    'name' => 'params[btn_label]',
    'value' => ($plugin->btn_label?$plugin->btn_label:'checkout'),
    'options_values' => [
        'checkout' => elgg_echo('paypal_api:settings:btn_label:checkout'),
        'pay' => elgg_echo('paypal_api:settings:btn_label:pay'),
        'buynow' => elgg_echo('paypal_api:settings:btn_label:buynow'),
        'paypal' => elgg_echo('paypal_api:settings:btn_label:paypal'),
    ],
    '#label' => elgg_echo('paypal_api:settings:btn_label'),
    '#help' => elgg_echo('paypal_api:settings:btn_label:help'),
]);

$btn_settings .= elgg_view_field([
    '#type' => 'dropdown',
    'name' => 'params[btn_layout]',
    'value' => ($plugin->btn_layout?$plugin->btn_layout:'horizontal'),
    'options_values' => [
        'horizontal' => elgg_echo('paypal_api:settings:btn_layout:horizontal'),
        'vertical' => elgg_echo('paypal_api:settings:btn_layout:vertical'),
    ],
    '#label' => elgg_echo('paypal_api:settings:btn_layout'),
    '#help' => elgg_echo('paypal_api:settings:btn_layout:help'),
]);

$btn_settings .= elgg_view_field([
    '#type' => 'checkbox',
    'name' => 'params[btn_fundingicons]',
    'default' => 'no',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->btn_fundingicons === 'yes'),  
    '#label' => elgg_echo('paypal_api:settings:btn_fundingicons'),
    '#help' => elgg_echo('paypal_api:settings:btn_fundingicons:help'),
]);

$btn_settings .= elgg_view_field([
    '#type' => 'checkbox',
    'name' => 'params[btn_tagline]',
    'default' => 'no',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->btn_tagline === 'yes'),  
    '#label' => elgg_echo('paypal_api:settings:btn_tagline'),
    '#help' => elgg_echo('paypal_api:settings:btn_tagline:help'),
]);

$btn_title = elgg_format_element('h3', [], elgg_echo('paypal_api:settings:btn_title'));
echo elgg_view_module('inline', '', $btn_settings, ['header' => $btn_title]);
 
