<?php

$epoch = time();
$api_key = '';
$api_secret = '';

$str = $epoch . $api_key;
$hmac = hash_hmac( 'sha512', $str, $api_secret );

$url = 'https://staging-api.chip-in.asia/api/send/send_instructions';

$header = [
  'Content-Type: application/json' , 
  "Authorization: Bearer $api_key",
  "Checksum: $hmac",
  "Epoch: $epoch",
];

$body = [
  'amount' => 1.44,
  'bank_account_id' => 242,
  'description' => 'test',
  'email' => 'test@gmail.com',
  'reference' => 'test222'
];

$process = curl_init( $url );
curl_setopt($process, CURLOPT_HEADER , 0);
curl_setopt($process, CURLOPT_HTTPHEADER, $header);
curl_setopt($process, CURLOPT_TIMEOUT, 30);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($body) );

$return = curl_exec($process);
curl_close($process);

$response = json_decode($return, true);

print_r($response);

/*
Array
(
    [id] => 588
    [bank_account_id] => 242
    [bank_account_details] => Array
        (
            [name] => AHMAD PINTU
            [bank_code] => MBBEMYKL
            [account_number] => 157380111111
        )

    [amount] => 1.44
    [state] => completed
    [rejection_reason] => 
    [email] => test@gmail.com
    [description] => test
    [reference] => test222
    [slug] => 2ff9c162
    [created_at] => 2024-02-21T03:47:30.484Z
    [updated_at] => 2024-02-21T03:47:30.763Z
    [receipt_url] => https://staging.chip-in.asia/receipts/send/2ff9c162
)
*/