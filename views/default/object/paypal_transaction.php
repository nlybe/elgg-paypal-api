<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

$title_view = elgg_extract('title_view', $vars, false);
$entity = elgg_extract('entity', $vars, false);

if (!$entity) { 
    return;
}

elgg_format_element('div', [], '&nbsp;');

if ($title_view) {
    $body = elgg_format_element('h3', [], $entity->title);
}

$divTableHeading = elgg_format_element('div', ['class' => 'divTableRow'], 
    elgg_format_element('div', ['class' => 'divTableHead'], elgg_echo('paypal_api:transaction:heading:name')).
    elgg_format_element('div', ['class' => 'divTableHead'], elgg_echo('paypal_api:transaction:heading:paypal_id')).
    elgg_format_element('div', ['class' => 'divTableHead'], elgg_echo('paypal_api:transaction:heading:value'))
);
$divTableHeading = elgg_format_element('div', ['class' => 'divTableHeading'], $divTableHeading);
    
$fields = $entity->paypal_fields;
foreach ($fields as $k => $v) {
    if ($k == 'description') {
        continue;
    }
    if (!empty($entity->$k)) {
        $divTableRow .= elgg_format_element('div', ['class' => 'divTableRow'], 
            elgg_format_element('div', ['class' => 'divTableCell'], elgg_echo('paypal_api:transaction:'.$k)).
            elgg_format_element('div', ['class' => 'divTableCell'], $k).
            elgg_format_element('div', ['class' => 'divTableCell'], $entity->$k)
        );   
    }
}

$divTableBody = elgg_format_element('div', ['class' => 'divTableBody'], $divTableRow);
$divTable = elgg_format_element('div', ['class' => 'divTableBody'], $divTableHeading.$divTableBody);
$body .= $divTable;

$body .= elgg_format_element('h3', ['class' => 'divHeaderPP'], elgg_echo('paypal_api:transaction:purchased_items'));
$body .= elgg_format_element('div', [], $entity->listPurchasedItems());

$body .= elgg_format_element('h3', ['class' => 'divHeaderPP'], elgg_echo('paypal_api:transaction:description'));
$body .= elgg_format_element('div', [], $entity->description);

echo elgg_view('object/elements/full', [
    'entity' => $entity,
    'icon' => '',
    'summary' => '',
    'body' => $body,
    'show_responses' => false,
]);

