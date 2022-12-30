<?php

require( 'configuration.php' );

session_start();

if ( isset( $_SESSION['payment_id'] ) ) {
  $payment_id = $_SESSION['payment_id'];
} else {
  header('Location: ' . SITE_URL );
  exit;
}

// Payment unsuccessful
// Message to output below

echo 'Payment unsuccessful';