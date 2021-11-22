<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

namespace PaypalApi;

use PaypalTransaction;
use PaypalTransactionUnit;

class PaypalApiOptions {

    const PLUGIN_ID = 'paypal_api';                   // current plugin ID
    const PAPI_YES = 'yes';                         // general purpose value for yes
    const PAPI_NO = 'no';                           // general purpose value for no
    const PAPI_MODE_LIVE = 'live';                                                  // paypal mode "live"
    const PAPI_MODE_SANDBOX = 'sandbox';                                            // paypal mode "sandbox"
    const PAPI_URL_LIVE = 'https://www.paypal.com/cgi-bin/webscr';                  // paypal live URL
    const PAPI_URL_SANDBOX = 'https://www.sandbox.paypal.com/cgi-bin/webscr';       // paypal sandbox URL

    const DEFAULT_BTN_LOCALE = 'en_US';         // Default PayPal Checkout Button locale
    const DEFAULT_BTN_SIZE = 'responsive';          // Default PayPal Checkout Button size
    const DEFAULT_BTN_COLOR = 'gold';           // Default PayPal Checkout Button color
    const DEFAULT_BTN_SHAPE = 'pill';           // Default PayPal Checkout Button shape
    const DEFAULT_BTN_LABEL = 'checkout';       // Default PayPal Checkout Button label
    const DEFAULT_BTN_LAYOUT = 'horizontal';    // Default PayPal Checkout Button layout
    
    /**
     * Set some HTML Variables for PayPal Payments Standard
     * See https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#individual-items-variables
     */
    // const DEFAULT_CMD = '_xclick';                      // set default value of cmd
    // const DEFAULT_ITEM_NAME = 'PayPal Single Purchase'; // set default item name
    // const DEFAULT_CURRENCY_CODE = 'USD';                // set default currency code
    // const DEFAULT_QUANTITY = 1;                         // set default quantity
    // const DEFAULT_NO_SHIPPING = 0;                      // 0 — prompt for an address, but do not require one, 1 — do not prompt for an address, 2 — prompt for an address, and require one
    // const DEFAULT_NOTIFY_URL = 'paypal_api/ipn';        // set default ipn

    /**
     * Get param value from settings
     * 
     * @return type
     */

    Public Static function getParams($setting_param = '', $default_value = null) {
        if (!$setting_param) {
            return false;
        }

        return trim(elgg_get_plugin_setting($setting_param, self::PLUGIN_ID, $default_value));
    }

    /**
     * Get the current PayPal mode, according plugin settings
     * Default if not set is sandbox
     *  
     * @return type
     */
    Public Static function getPaypalMode() {
        return self::getParams('paypal_mode', self::PAPI_MODE_SANDBOX);
    }

    /**
     * Retrieve the Client ID as it has been set in plugin settings
     * 
     * @return Client ID or false if empty
     */
    Public Static function getSitePayPalClientID() {
        $cliend_id = self::getParams('cliend_id');
        return $cliend_id?$cliend_id:false;
    }   

    /**
     * Get the PayPal Checkout Button locale, according plugin settings
     *  
     * @return string
     */
    Public Static function getPaypalBtnLocale() {
        return self::getParams('btn_locale', self::DEFAULT_BTN_LOCALE);
    }   

    /**
     * Get the PayPal Checkout Button size, according plugin settings
     *  
     * @return string
     */
    Public Static function getPaypalBtnSize() {
        return self::getParams('btn_size', self::DEFAULT_BTN_SIZE);
    }   

    /**
     * Get the PayPal Checkout Button color, according plugin settings
     *  
     * @return string
     */
    Public Static function getPaypalBtnColor() {
        return self::getParams('btn_color', self::DEFAULT_BTN_COLOR);
    }   

    /**
     * Get the PayPal Checkout Button shape, according plugin settings
     *  
     * @return string
     */
    Public Static function getPaypalBtnShape() {
        return self::getParams('btn_shape', self::DEFAULT_BTN_SHAPE);
    }   

    /**
     * Get the PayPal Checkout Button label, according plugin settings
     *  
     * @return string
     */
    Public Static function getPaypalBtnLabel() {
        return self::getParams('btn_label', self::DEFAULT_BTN_LABEL);
    }   

    /**
     * Get the PayPal Checkout Button layout, according plugin settings
     *  
     * @return string
     */
    Public Static function getPaypalBtnLayout() {
        return self::getParams('btn_layout', self::DEFAULT_BTN_LAYOUT);
    }

    /**
     * Get the PayPal Checkout Button fundingicons, according plugin settings
     * 
     * @return boolean
     */
    Public Static function getPaypalBtnFundingIcons() {
        $get_param = self::getParams('btn_fundingicons');
        return $get_param === self::PAPI_YES?true:false;
    }

    /**
     * Get the PayPal Checkout Button tagline, according plugin settings
     * 
     * @return boolean
     */
    Public Static function getPaypalBtnTagline() {
        $get_param = self::getParams('btn_tagline');
        return $get_param === self::PAPI_YES?true:false;
    }  

    /**
     * Retrieve the right mode URL, according selected mode in plugin settings
     * 
     * @return type
     */
    Public Static function getPaypalModeURL() {
        $paypal_mode = self::getPaypalMode();

        if ($paypal_mode === self::PAPI_MODE_LIVE) {
            return self::PAPI_URL_LIVE;
        }

        return self::PAPI_URL_SANDBOX;
    }

    /**
     * Check if the acceptterms option is enables, according plugin settings
     * 
     * @return boolean
     */
    Public Static function isAcceptTermsOptionEnabled() {
        $get_param = self::getParams('acceptterms');
        return $get_param === self::PAPI_YES?true:false;
    } 

    /**
     * Get the current PayPal mode, according plugin settings
     *  
     * @return type
     */
    Public Static function getAcceptTermsText() {
        return self::getParams('acceptterms_txt');
    }

    // /** OBS ???
    //  * Check if sandbox mode is enabled
    //  * 
    //  * @return boolean
    //  */
    // Public Static function isSandboxMode() {
    //     $paypal_mode = self::getPaypalMode();

    //     if ($paypal_mode === self::PAPI_MODE_SANDBOX) {
    //         return true;
    //     }

    //     return false;
    // }
    
    /**
     * Default Paypal transactions logging
     * 
     * @param type $options
     * @return type
     */
    Public Static function paypalLogTransaction($transaction) {

        elgg_call(ELGG_IGNORE_ACCESS, function () use ($transaction) {
            $log = new PaypalTransaction();
            $log->subtype = PaypalTransaction::SUBTYPE;
            $log->access_id = ACCESS_PRIVATE;
            $log->owner_guid = elgg_get_site_entity()->guid;
            $log->container_guid = elgg_get_site_entity()->guid;

            $log->title = elgg_echo("paypal_api:transaction:title:id", [$transaction->id]);
            $log->description = json_encode($transaction);
            $log->create_time = $transaction->create_time;
            $log->update_time = $transaction->update_time;
            $log->id = $transaction->id;
            $log->intent = $transaction->intent;
            $log->status = $transaction->status;
            $log->payer_email_address = $transaction->payer->email_address;
            $log->payer_payer_id = $transaction->payer->payer_id;
            $log->payer_address_country_code = $transaction->payer->address->country_code;
            $log->payer_name_given_name = $transaction->payer->name->given_name;
            $log->payer_name_surname = $transaction->payer->name->surname;
            // foreach ($transaction as $key => $val) {
            //     $log->$key = $val;
            // }
            $log->save();

            $purchase_units = $transaction->purchase_units;
            if (is_array($purchase_units) && count($purchase_units) > 0) {
                foreach ($purchase_units as $unit) {
                    $pu = new PaypalTransactionUnit();
                    $pu->subtype = PaypalTransactionUnit::SUBTYPE;
                    $pu->access_id = ACCESS_PRIVATE;
                    $pu->owner_guid = elgg_get_site_entity()->guid;
                    $pu->container_guid = $log->getGUID();

                    $pu->title = $unit->description;
                    $pu->reference_id = $unit->reference_id;
                    $pu->custom_id = $unit->custom_id;
                    $pu->amount_value = $unit->amount->value;
                    $pu->amount_currency_code = $unit->amount->currency_code;
                    $pu->payee_email_address = $unit->payee->email_address;
                    $pu->payee_merchant_id = $unit->payee->merchant_id;
                    $pu->shipping_name_full_name = $unit->shipping->name->full_name;
                    $pu->shipping_address_address_line_1 = $unit->shipping->address->address_line_1;
                    $pu->shipping_address_admin_area_1 = $unit->shipping->address->admin_area_1;
                    $pu->shipping_address_admin_area_2 = $unit->shipping->address->admin_area_2;
                    $pu->shipping_address_postal_code = $unit->shipping->address->postal_code;
                    $pu->shipping_address_country_code = $unit->shipping->address->country_code;
                    $pu->save();
                }
            }  

            // trigger plugin hook for individual plugins to have an option to save their own ipn log
            $result = elgg_trigger_plugin_hook('paypal_api', 'ipn_log', ['transaction' => $transaction], false);

            return $log;
        });

        return false;
    }    
}
