define(function (require) {
    var elgg = require('elgg');
    var $ = require('jquery');

    // $.ajaxSetup({'cache':true});
    var Ajax = require('elgg/Ajax');
    var ajax = new Ajax();
    
    // get plugin settings
    var dt_settings = require("paypal_api/settings");
    var acceptterms = dt_settings['acceptterms'];
    var btn_size = dt_settings['btn_size'];
    var btn_color = dt_settings['btn_color'];
    var btn_shape = dt_settings['btn_shape'];
    var btn_label = dt_settings['btn_label'];
    var btn_layout = dt_settings['btn_layout'];
    var btn_fundingicons = dt_settings['btn_fundingicons'];
    var btn_tagline = dt_settings['btn_tagline'];
    var custom_msg = "";
    
    // $( document ).ready(function() {
    $(function() {
      amount = $('#ppinfo').data("amount");
      env = $('#ppinfo').data("env");
      intent = $('#ppinfo').data("intent");
      item_name = $('#ppinfo').data("item_name");
      item_reference_id = $('#ppinfo').data("item_reference_id");
      custom_id = $('#ppinfo').data("custom_id");
      custom_msg = $('#ppinfo').data("custom_success_msg");
      
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

          // Disable the buttons
          console.log(acceptterms);
          if (acceptterms) {
            actions.disable();

            // // Listen for changes to the checkbox
            document.querySelector('#acceptterms')
              .addEventListener('change', function(event) { 
                // Enable or disable the button when it is checked or unchecked
                if (event.target.checked) {
                  actions.enable();
                  $("#paypal_btn").removeClass( "paypal_btn_disabled" );
                } else {
                  actions.disable();
                  $("#paypal_btn").addClass( "paypal_btn_disabled" );
                }
              });
          }
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
                  // remove intro text, if exists
                  $(".paypal-intro").text("");

                  // check if not custom success message
                  if (custom_msg === null || custom_msg === undefined) {
                    custom_msg = elgg.echo('paypal_api:transaction:success');
                  }

                  // set max width bot not have limitation on paragraph width
                  $("#paypal_btn").css("max-width", "100%");
                  $("#paypal_btn").text("");
                  $("#accept_terms_chbx").remove();
                  $("#paypal_btn").append("<div class='purchase_success'>"+custom_msg+"</div>");
                  if (jqXHR.AjaxData.status == -1) {
                      return;
                  }
              });

          });
      },
      onCancel: function (data)  {
        elgg.register_error(elgg.echo('paypal_api:transaction:canceled'));
      },
      onError: function (err) {
        elgg.register_error(elgg.echo('paypal_api:transaction:error', [err]));
      }
      }).render("#paypal_btn");
    });    

 
});