<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

use PaypalApi\PaypalApiOptions;

// elgg_require_js('paypal_api/paypal_btn'); 
// $paypal_btn_id = 'paypal_btn';
$paypal_btn_id = 'paypal_btn_'.rand();
echo elgg_format_element('div', [''], '----');
echo elgg_format_element('div', ['id' => $paypal_btn_id], '');
echo elgg_format_element('div', [''], '----');

echo elgg_format_element('div', [
    'id' => 'ppinfo', 
    'class' => 'ppinfo', 
    'data-env' => PaypalApiOptions::getPaypalModeURL(),
    'data-intent' => 'CAPTURE',
    'data-amount' => $vars['amount'],
    'data-item_reference_id' => $vars['item_reference_id'],
    'data-item_name' => $vars['item_name'],
    'data-custom_id' => $vars['custom_id'],
], '');

$client_id = $vars['client-id']?$vars['client-id']:PaypalApiOptions::getSitePayPalClientID();

$args = [];
$args['client-id'] = $client_id;
$args['currency'] = $vars['currency'];
// $args['locale']  = PaypalApiOptions::getPaypalBtnLocale(); // OBS, see notes in settings.php

$script_url = http_build_query($args);
$script_url = 'https://www.paypal.com/sdk/js?'.$script_url;

printf( '<script defer src="%s" data-partner-attribution-id="TipsandTricks_SP" data-sdk-integration-source="button-factory"></script>', $script_url );

// echo elgg_format_element('script', [
//     'src' => $script_url, 
//     'data-partner-attribution-id' => 'TipsandTricks_SP', 
// ], '');


?>

<script>
// define(function (require) {
require(['jquery', 'paypal_api/settings'], function($) {
    var elgg = require('elgg');
    var $ = require('jquery');
    

    console.log('inside ----> 0');
    // $.ajaxSetup({'cache':true});
    var Ajax = require('elgg/Ajax');
    var ajax = new Ajax();
    console.log('inside ----> 1');
    // get plugin settings
    var dt_settings = require("paypal_api/settings");
    var btn_size = dt_settings['btn_size'];
    var btn_color = dt_settings['btn_color'];
    var btn_shape = dt_settings['btn_shape'];
    var btn_label = dt_settings['btn_label'];
    var btn_layout = dt_settings['btn_layout'];
    var btn_fundingicons = dt_settings['btn_fundingicons'];
    var btn_tagline = dt_settings['btn_tagline'];
    console.log('inside ----> 2');
    // $( document ).ready(function() {
    $(function() {
      console.log('inside ----> 3');
      amount = $('#ppinfo').data("amount");
      env = $('#ppinfo').data("env");
      intent = $('#ppinfo').data("intent");
      item_name = $('#ppinfo').data("item_name");
      item_reference_id = $('#ppinfo').data("item_reference_id");
      custom_id = $('#ppinfo').data("custom_id");
      console.log('inside ----> 4');
      // check definitions at https://developer.paypal.com/docs/api/orders/v2, https://developer.paypal.com/demo/checkout/#/pattern/confirm
      // https://developer.paypal.com/docs/archive/checkout/integrate/, https://developer.paypal.com/docs/archive/checkout/how-to/customize-flow/
      // https://github.com/paypal/paypal-checkout-components/blob/master/docs/implement-checkout.md
      paypal.Buttons({
        env: env,
        style: {
          size: btn_size,
          color: btn_color,
          shape: btn_shape,
          label: btn_label,
          layout: btn_layout,
          fundingicons: btn_fundingicons,
          tagline: btn_tagline
        },
        // onInit is called when the button first renders
        onInit: function(data, actions) {
            console.log('inside ----> 222222222');
          // Disable the buttons
          actions.disable();
          
          // Listen for changes to the checkbox
          // document.querySelector('#check')
          //   .addEventListener('change', function(event) {

          //     // Enable or disable the button when it is checked or unchecked
          //     if (event.target.checked) {
          //       actions.enable();
          //     } else {
          //       actions.disable();
          //     }
          //   });
          actions.enable();
        },
        createOrder: function(data, actions) {
          return actions.order.create({
            intent: intent,
            purchase_units: [{
              description: item_name,
              amount: {
                value: amount
              },
              reference_id: item_reference_id,
              custom_id: custom_id
              // invoice_id: invoice_id
              // soft_descriptor: soft_descriptor
            }],
      
          });
        },
        // Finalize the transaction
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
              var paypal_response = JSON.stringify(details);
              
              ajax.action('paypal_api/transaction/complete', {
                data: {
                  q: paypal_response
                },
              }).done(function (output, statusText, jqXHR) {
                  $("#<?php echo $paypal_btn_id; ?>").text("");
                  $("#<?php echo $paypal_btn_id; ?>").append("<div class='purchase_success'>"+elgg.echo('paypal_api:transaction:success')+"</div>");
                  if (jqXHR.AjaxData.status == -1) {
                      return;
                  }
              });

          });
      },
      onCancel: function (data)  {
        console.log('inside ----> 5');
        elgg.register_error(elgg.echo('paypal_api:transaction:canceled'));
      },
      onError: function (err) {
        console.log('inside ----> 6');
        elgg.register_error(elgg.echo('paypal_api:transaction:error', [err]));
      }
      }).render("#<?php echo $paypal_btn_id; ?>")
      .catch((err) => {
        console.warn("Warning - Caught an error when attempting to render component", err);
        });
    //   ;
      console.log('inside ----> 7');
    }); 
})
</script>

