<?php

$epoch = time();
$api_key = '';
$api_secret = '';

$str = $epoch . $api_key;
$hmac = hash_hmac( 'sha512', $str, $api_secret );

$url = 'https://staging-api.chip-in.asia/api/webhooks/57';

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
    [id] => 57
    [name] => test
    [public_key] => -----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzRtJq28SvGWYc3FpEt3M
m2gwABAnTtTPSYSpcwxHKVJMcAQGIhB01uMrhC/7Amd0Tv+F/dv7wQ/lBnj6v6dO
+vkajdHU49q1ODoAlCfsyJsH1/Xw/IRPzfVPn3xlQt1XDpUW8ovuzGHsQELt3RAa
ymigM7zpsT9BxnxrF2mFq5f0XCHfedVsC/88gTDY0B9Y8zRZaLKj70rokgtneVpf
SLPF+L7uwrMKsLeIT2V59fDqWteH22CVKEpRzn4xOrKkeV3lDu1eFozE+CXQZq5q
sbqqUlqMeJyyAzVc6pEcASIYMi8YwRVHclxcaKCaRkMze/BwW8ounRxut1HirPwL
xQIDAQAB
-----END PUBLIC KEY-----

    [callback_url] => https://webhook.site/052368ac-9f12-4fde-8ede-77976cfb85ba
    [email] => jowane5026@ebuthor.com
    [event_hooks] => Array
        (
            [0] => bank_account_status
            [1] => send_instruction_status
            [2] => budget_allocation_status
        )

    [created_at] => 2024-02-21T03:53:02.902Z
    [updated_at] => 2024-02-21T03:53:02.902Z
)
*/