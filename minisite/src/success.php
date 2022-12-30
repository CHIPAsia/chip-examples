<?php

require( 'api.php' );
require( 'configuration.php' );

session_start();

if ( isset( $_SESSION['payment_id'] ) ) {
  $payment_id = $_SESSION['payment_id'];
} else {
  header('Location: ' . SITE_URL );
  exit;
}

unset( $_SESSION['payment_id'] );

$chip    = CHIP::get_instance( SECRET_KEY, BRAND_ID );
$payment = $chip->get_payment( $payment_id );

if ( $payment['status'] != 'paid' ) {
  echo 'Payment unsuccessful';
}

// Payment successful
// Message to output below

echo 'Payment successful. Details: ' . print_r( $payment, true );