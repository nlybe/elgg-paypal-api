<?php
/**
 * Elgg PayPal API
 * @package paypal_api 
 */

if (!elgg_is_admin_logged_in())	{
    return elgg_error_response(elgg_echo('paypal_api:error:invalid_access'));
}

$guid = get_input('guid');
$entity = get_entity($guid);

if ($entity instanceof PaypalTransaction && $entity->canEdit()) {
    if ($entity->delete()) {
        return elgg_ok_response('', elgg_echo('paypal_api:delete:success'), REFERER);
    }
}

return elgg_error_response(elgg_echo('paypal_api:delete:failed'));
