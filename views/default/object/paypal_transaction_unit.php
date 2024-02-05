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
  
$e = get_entity($entity->reference_id);
$fields = $entity->paypal_fields;
foreach ($fields as $k => $v) {
    if ($k == 'description') {
        continue;
    }
    
    if (!empty($entity->$k)) {
        if ($k == 'title' && $e instanceof \ElggObject) {
            $value = elgg_view('output/url', [
                'href' => $e->getURL(),
                'text' => $e->title,
                'title' => $entity->$k,
                'is_trusted' => true,
                'target' => '_blank',
            ]);
        }
        else {
            $value = $entity->$k;
        }

        $divTableRow .= elgg_format_element('div', ['class' => 'divTableRow'], 
            elgg_format_element('div', ['class' => 'divTableCell'], elgg_echo('paypal_api:transaction:item:'.$k)).
            elgg_format_element('div', ['class' => 'divTableCell'], $k).
            elgg_format_element('div', ['class' => 'divTableCell'], $value)
        );   
    }
}

$divTableBody = elgg_format_element('div', ['class' => 'divTableBody'], $divTableRow);
$divTable = elgg_format_element('div', ['class' => 'divTableBody'], $divTableHeading.$divTableBody);
$body .= $divTable;

echo elgg_view('object/elements/full', [
    'entity' => $entity,
    'icon' => '',
    'summary' => '',
    'body' => $body,
    'show_responses' => false,
]);

