<?php

$epoch = time();
$api_key = '';
$api_secret = '';

$str = $epoch . $api_key;
$hmac = hash_hmac( 'sha512', $str, $api_secret );

$url = 'https://staging-api.chip-in.asia/api/send/accounts';

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
    [results] => Array
        (
            [0] => Array
                (
                    [id] => 1
                    [status] => active
                    [currency] => MYR
                    [send_fee_type] => flat
                    [settlement_convert_approvals_count] => 1
                    [send_fee] => 1
                    [convertible_balance_from_statement] => 1000
                    [current_balance] => 2710.83
                    [created_at] => 2023-07-05T18:26:11.576Z
                    [updated_at] => 2023-07-05T18:26:11.576Z
                )

        )

    [meta] => Array
        (
            [pagination] => Array
                (
                    [current_page] => 1
                    [prev_page] => 
                    [next_page] => 
                    [total_pages] => 1
                    [total_count] => 1
                )

        )

)
*/