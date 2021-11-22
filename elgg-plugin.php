<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

use PaypalApi\Elgg\Bootstrap;

require_once(dirname(__FILE__) . '/lib/hooks.php');

return [
    'bootstrap' => Bootstrap::class,
    'entities' => [
        [
            'type' => 'object',
            'subtype' => 'paypal_transaction',
            'class' => 'PaypalTransaction',
            'searchable' => false,
        ],
        [
            'type' => 'object',
            'subtype' => 'paypal_transaction_unit',
            'class' => 'PaypalTransactionUnit',
            'searchable' => false,
        ],
    ],
	'settings' => [
        'paypal_mode' => 'sandbox',
        'acceptterms' => 'sandbox',
        'btn_locale' => 'en_US',
        'btn_size' => 'responsive',
        'btn_color' => 'gold',
        'btn_shape' => 'pill',
        'btn_label' => 'checkout',
        'btn_layout' => 'horizontal',
        'btn_fundingicons' => 'no',
        'btn_tagline' => 'no',
    ],
    'actions' => [
        'paypal_api/transaction/complete' => [],
        'paypal_api/transaction/delete' => ['access' => 'admin'],
    ],
    'routes' => [
        'view:object:paypal_transaction' => [
            'path' => '/paypal_api/transaction_view/{guid}/{title?}',
            'resource' => 'paypal_api/transaction_view',
        ],
    ],
    'widgets' => [],
    'views' => [
        'default' => [],
    ],
    'upgrades' => [],
];
