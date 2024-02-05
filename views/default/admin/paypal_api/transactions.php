<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

// restrict pages only to admins
elgg_admin_gatekeeper();

$options = [
    'type' => 'object',
    'subtype' => PaypalTransaction::SUBTYPE,
    'limit' => 0,
    'full_view' => false,
    'view_toggle_type' => false,
];

if (elgg_is_active_plugin('datatables_api')) {
    $entities = elgg_get_entities($options);
    
    if ($entities) {
        $dt_options = [];
        $dt_options['dt_titles'] = array(
            elgg_echo('paypal_api:admin:transactions:table:header:id'),
            elgg_echo('paypal_api:admin:transactions:table:header:title'),
            elgg_echo('paypal_api:admin:transactions:table:header:transaction_id'),
            elgg_echo('paypal_api:admin:transactions:table:header:create_time'),
            elgg_echo('paypal_api:admin:transactions:table:header:actions'),
        );
        
        $dt_data = [];
        foreach ($entities as $e) {
            $dt_data_tmp = [];
            // datatable 
            $dt_data_tmp['guid'] = $e->getGUID();
            
            $entity = get_entity(intval($e->object_guid));
            if (!$entity instanceof \ElggObject) {    // backward compatibility
                $entity = get_entity(intval($e->item_number));
            }
            if ($entity instanceof \ElggObject) {
                $dt_data_tmp['title'] = elgg_view('output/url', array(
                    'href' => $entity->getURL(),
                    'text' => $e->title,
                    'title' => elgg_echo('admin:paypal_api:transactions:details'),
                    'is_trusted' => true,
                    'target' => '_blank',
                ));                
            }
            else {
                $dt_data_tmp['title'] = $e->title;
            }
            
            $dt_data_tmp['txn_id'] = elgg_view('output/url', array(
                'href' => elgg_normalize_url('paypal_api/transaction_view/'.$e->getGUID()),
                'text' => $e->id,
                'title' => elgg_echo('admin:paypal_api:transactions:details'),
                'is_trusted' => true,
                'class' => 'elgg-lightbox',
            ));            
            $dt_data_tmp['create_time'] = $e->create_time;
            $dt_data_tmp['delete'] = elgg_view('output/url', array(
                'href' => "action/paypal_api/transaction/delete?guid={$e->getGUID()}",
                'text' => elgg_view_icon('remove'),
                'title' => elgg_echo('delete:this'),
                'is_action' => true,
                'data-confirm' => elgg_echo('deleteconfirm'),
            ));

            array_push($dt_data, $dt_data_tmp);        
        }

        $dt_options['dt_data'] = $dt_data;
        
        $content = elgg_view('datatables_api/datatables_api', $dt_options);
    }  
}
else {
    $content = elgg_list_entities($options);
}

echo elgg_format_element('div', [], $content);

// unset variables
unset($entities);
unset($dt_data);
