<?php

// Sample PHP Curl Code for Creating Purchase via API

$secret_key = '';
$brand_id   = '';

$host = 'https://gate.chip-in.asia/api/v1/purchases/';

// more parameters available. refer to: https://gate.chip-in.asia/api/#/Purchases/purchases_create
$params = array(
  'success_redirect' => 'https://domain.com/successful_redirection',
  'failure_redirect' => 'https://domain.com/failed_redirection',
  'cancel_redirect'  => 'https://domain.com/cancel_redirection',
  'success_callback' => 'https://domain.com/successful_callback', // webhook
  'purchase' => [
    "products" => [
      [
        'name'  => 'Order #1',
        'price' => '100', // RM 1
      ],
    ],
  ],
  'brand_id' => $brand_id,
  'client'   => [
    'email'     => 'example@email.com',
    'full_name' => 'Ahmad'
  ],
);

$process = curl_init( $host );
curl_setopt($process, CURLOPT_HEADER , 0);
curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , "Authorization: Bearer $secret_key" ));
curl_setopt($process, CURLOPT_TIMEOUT, 30);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($params) ); 

$return = curl_exec($process);
curl_close($process);

$purchases = json_decode($return, true);

echo $purchases['checkout_url']; // URL

// header('Location: ' . $purchases['checkout_url']);
// var_dump($return);