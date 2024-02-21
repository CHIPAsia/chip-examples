<?php

$epoch = time();
$api_key = '';
$api_secret = '';

$str = $epoch . $api_key;
$hmac = hash_hmac( 'sha512', $str, $api_secret );

$url = 'https://staging-api.chip-in.asia/api/send/send_limits/1155';

$header = [
  'Content-Type: application/json' , 
  "Authorization: Bearer $api_key",
  "Checksum: $hmac",
  "Epoch: $epoch",
];


$process = curl_init( $url );
curl_setopt($process, CURLOPT_HEADER , 0);
curl_setopt($process, CURLOPT_HTTPHEADER, $header);
curl_setopt($process, CURLOPT_TIMEOUT, 30);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);

$return = curl_exec($process);
curl_close($process);

$response = json_decode($return, true);

print_r($response);

/*
Array
(
    [id] => 1155
    [currency] => MYR
    [fee_type] => flat
    [transaction_type] => in
    [amount] => 12
    [fee] => 0
    [net_amount] => 12
    [send_instruction_id] => 
    [bank_account_id] => 
    [from_settlement] => 2024-02-21
    [status] => pending
    [approvals_required] => 1
    [approvals_received] => 0
    [approvals_details] => Array
        (
            [0] => Array
                (
                    [destination_type] => email
                    [destination] => testmail@gmail.com
                    [status] => pending
                    [approved_at] => 
                    [expires_at] => 2024-02-21T04:00:00.000Z
                )

        )

    [created_at] => 2024-02-21T01:56:41.800Z
    [updated_at] => 2024-02-21T01:56:41.800Z
)
*/