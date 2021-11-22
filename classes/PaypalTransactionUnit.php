<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

class PaypalTransactionUnit extends ElggObject {
    const SUBTYPE = "paypal_transaction_unit";
    
    // transaction fields as received from paypal ipn
    public $paypal_fields = [
        "title" => NULL,
        "description" => NULL,
        "reference_id" => NULL, // the Elgg Object ID
        "custom_id" => NULL,
        "amount_value" => NULL,
        "amount_currency_code" => NULL,
        "payee_email_address" => NULL,
        "payee_merchant_id" => NULL,
        "shipping_name_full_name" => NULL,
        "shipping_address_address_line_1" => NULL,
        "shipping_address_admin_area_1" => NULL,
        "shipping_address_admin_area_2" => NULL,
        "shipping_address_postal_code" => NULL,
        "shipping_address_country_code" => NULL,
    ];
    
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes["subtype"] = self::SUBTYPE;
    }
    
}

