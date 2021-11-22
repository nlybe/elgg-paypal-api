<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

use PaypalApi\PaypalApiOptions;

if ($term_txt = PaypalApiOptions::getAcceptTermsText()) {
    $accept_link_text = elgg_view('output/url', [
        'text' => elgg_echo("paypal_api:accept_terms:label:url:text"),
        'href' => '#lightbox-inline',
        'class' => 'elgg-lightbox-inline',
        'data-colorbox-opts' => json_encode([
            'width' => '70%',
            'height' => '70%',
        ]),
    ]);
    
    echo elgg_format_element('div', ['class' => 'paypal_accept_terms_text'], elgg_format_element('div', ['id' => 'lightbox-inline'], $term_txt));
    echo elgg_format_element('div', ['id' => 'accept_terms_chbx'], elgg_view('input/checkbox', [
		'id' => 'acceptterms',
        'name' => 'acceptterms',
		'label' => elgg_echo("paypal_api:accept_terms:label:url", [$accept_link_text]),
	]));
}
else {
    echo elgg_format_element('div', ['id' => 'paypal_accept_terms'], elgg_echo("paypal_api:accept_terms:label"));
}
