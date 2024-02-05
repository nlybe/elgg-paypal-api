<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

use PaypalApi\Elgg\Bootstrap;

require_once(dirname(__FILE__) . '/lib/events.php');

return [
    'plugin' => [
        'name' => 'PayPal API',
		'version' => '5.5',
		'dependencies' => [],
	],
    'bootstrap' => Bootstrap::class,
    'entities' => [
        [
            'type' => 'object',
            'subtype' => 'paypal_transaction',
            'class' => 'PaypalTransaction',
            'capabilities' => [
				'commentable' => false,
				'searchable' => false,
				'likable' => false,
			],
        ],
        [
            'type' => 'object',
            'subtype' => 'paypal_transaction_unit',
            'class' => 'PaypalTransactionUnit',
            'capabilities' => [
				'commentable' => false,
				'searchable' => false,
				'likable' => false,
			],
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
    'views' => [
        'default' => [],
    ],
	'events' => [
		'register' => [
			'menu:admin_header' => [
				'paypal_api_admin_menu' => ['priority' => 700],
			],
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'paypal_api/paypal_api.css' => [],
		],
		'css/admin' => [
			'paypal_api/paypal_api_admin.css' => [],
		],
	],
];
