<?php

$epoch = time();
$api_key = '';
$api_secret = '';

$str = $epoch . $api_key;
$hmac = hash_hmac( 'sha512', $str, $api_secret );

$url = 'https://staging-api.chip-in.asia/api/send/bank_accounts';

$header = [
  'Content-Type: application/json' , 
  "Authorization: Bearer $api_key",
  "Checksum: $hmac",
  "Epoch: $epoch",
];

$body = [
  'account_number' => '157380111111',
  'bank_code' => 'MBBEMYKL',
  'name' => 'Ahmad Pintu',
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
    [id] => 242
    [status] => verified
    [account_number] => 157380111111
    [bank_code] => MBBEMYKL
    [group_id] => 
    [name] => AHMAD PINTU
    [reference] => 
    [created_at] => 2023-11-01T15:23:34.487Z
    [is_debiting_account] => 
    [is_crediting_account] => 
    [updated_at] => 2024-02-21T03:44:58.600Z
    [deleted_at] => 
    [rejection_reason] => 
)
*/