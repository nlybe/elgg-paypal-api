<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

class PaypalTransaction extends ElggObject {
    const SUBTYPE = "paypal_transaction";
    
    // transaction fields as received from paypal ipn
    public $paypal_fields = [
        "title" => NULL,
        "description" => NULL,
        "create_time" => NULL,
        "update_time" => NULL,
        "id" => NULL,
        "intent" => NULL,
        "status" => NULL,
        "payer_email_address" => NULL,
        "payer_payer_id" => NULL,
        "payer_address_country_code" => NULL,
        "payer_name_given_name" => NULL,
        "payer_name_surname" => NULL,
    ];    
    
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes["subtype"] = self::SUBTYPE;
    }        
    
    /**
     * Get the purchased items of transaction
     * 
     * @return Array of purchased items
     */
    public function getPurchasedItems() {
        return elgg_get_entities([
            'type' => 'object',
            'subtype' => PaypalTransactionUnit::SUBTYPE,
            'container_guid' => $this->getGUID(),
        ]);
    }
    
    /**
     * List the purchased items of transaction
     * 
     * @return List of purchased items
     */
    public function listPurchasedItems() {
        return elgg_list_entities([
            'type' => 'object',
            'subtype' => PaypalTransactionUnit::SUBTYPE,
            'container_guid' => $this->getGUID(),
        ]);
    }
}

