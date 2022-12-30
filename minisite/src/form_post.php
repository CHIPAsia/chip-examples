<?php

require( 'api.php' );
require( 'configuration.php' );

$params = array(
  'success_callback' => SITE_URL . '/src/callback.php',
  'success_redirect' => SUCCESS_REDIRECT,
  'failure_redirect' => FAILURE_REDIRECT,
  'cancel_redirect'  => FAILURE_REDIRECT,
  'send_receipt'     => true,
  'creator_agent'    => 'Minisite',
  // 'reference'        => 'Reference',

  'purchase' =>  array(
    'timezone' => 'Asia/Kuala_Lumpur',
    'currency' => 'MYR',
    'products' => array(
      array(
        'name'  => PRODUCT_NAME,
        'price' => round( $_REQUEST['amount'] * 100 ),
      ),
    ),
  ),

  'client' => array(
    'email'     => $_REQUEST['email'],
    'full_name' => substr( $_REQUEST['name'], 0, 128 ),
  ),
);

$chip    = CHIP::get_instance( SECRET_KEY, BRAND_ID );
$payment = $chip->create_payment( $params );

if ( !array_key_exists( 'id', $payment ) ) {
  error_log( 'create payment failed. message: ' . print_r( $payment, true ) );
  exit;
}

session_start();

$_SESSION['payment_id'] = $payment['id'];

header('Location: ' . $payment['checkout_url']);
