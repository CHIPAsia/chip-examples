<?php

require( 'api.php' );
require( 'configuration.php' );

$content = file_get_contents('php://input');

$payment    = json_decode($content, true);
$payment_id = array_key_exists('id', $payment) ? $payment['id'] : '';

if ( empty( $payment_id ) ) {
  exit;
}

$chip    = CHIP::get_instance( SECRET_KEY, BRAND_ID );
$payment = $chip->get_payment( $payment_id );

if ( $payment['status'] != 'paid' ) {
  exit;
}

// Payment successful
// Action to trigger below