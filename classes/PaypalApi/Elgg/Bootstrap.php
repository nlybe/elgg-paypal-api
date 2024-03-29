<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

namespace PaypalApi\Elgg;

use Elgg\DefaultPluginBootstrap;
// use PaypalApi\PaypalApiOptions;

class Bootstrap extends DefaultPluginBootstrap {
	
	const HANDLERS = [];
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		$this->initViews();
	}

	/**
	 * Init views
	 *
	 * @return void
	 */
	protected function initViews() {
		// register settings js
		elgg_register_simplecache_view('paypal_api/settings.js');

		// // register menu item in admin area
		// if (elgg_get_context() == 'admin') {
		// 	elgg_register_menu_item('page', [
		// 		'name' => 'paypal_transactions',
		// 		'href' => elgg_normalize_url('admin/paypal_api/transactions'),
		// 		'text' => elgg_echo('admin:paypal_api:menu:transactions'),
		// 		// 'context' => 'admin',
		// 		'parent_name' => 'information',
		// 	]);
		// }
	}
}
