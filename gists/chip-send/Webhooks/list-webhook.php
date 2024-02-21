<?php

$epoch = time();
$api_key = '';
$api_secret = '';

$str = $epoch . $api_key;
$hmac = hash_hmac( 'sha512', $str, $api_secret );

$url = 'https://staging-api.chip-in.asia/api/webhooks';

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
                    [id] => 56
                    [name] => test hooks
                    [public_key] => -----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA31Fuse8KERRoE6dtyD2F
wK5fHNffMdu8u+IZPwiOSo2h4O+GJ06oo2gR364BH0ViZQ6l5muO9d1z7PYx6kva
4MyzJSCE7+pA/gjsnQ8Z6SH4IDvfUWNxYccp8XXpest5n4EjSQxfYvjZla0SgQq4
bdY3AYIAaeB3kbrUzxzWMmuK1kqOYfw/BUHGbnbkYJ0On5pJncAXFxKeeQ+9UjAw
tCKY7Uuq3OZw3bTGRunhJ85K4/noIGkkIWE+Q0KRRs6Q/Cz0Wxy6jaKWOCzNBRZX
UJvoxJazL6Wa8cWRV+c6Y0w1HAh/2cqo3aRDCLeQAU7li55t6vn7NXzabn11PiBL
PwIDAQAB
-----END PUBLIC KEY-----

                    [callback_url] => https://0af58a69f8b3df988e394103f64604c2.m.pipedream.net
                    [email] => 
                    [event_hooks] => Array
                        (
                            [0] => bank_account_status
                            [1] => send_instruction_status
                            [2] => budget_allocation_status
                        )

                    [created_at] => 2024-01-23T08:50:34.239Z
                    [updated_at] => 2024-01-23T08:50:34.239Z
                )

            [1] => Array
                (
                    [id] => 29
                    [name] => test hooks
                    [public_key] => -----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAu1SEbcg+sFVpE4vHby/f
SfQfxNIMfkkmjaBPi5VIrBNO9R+LPjmohFc2RL8gW2tAIMolEZjY0IVDOHCefURs
fUpFlN7x6khShLzsntpeb6pg3ts+oGqZBPx4N/NoQiY1sOP2Z3rpFuGh4PNmQ3Y3
sbgs+C0fDp2vfH6tvTH3WLSQ9qp3mavoVy6UvP6UQm7Mm8i2Y/7Hdv9DYAU9UZMl
LL9lJLn7Y12AKpaw0qjGghA2xLKASpvx62OdqX63xom0ipeN26cytjTBAFX1LiwW
n5xmWnZ+BTlk10JZw7wuIUaJGaeu+FrU5/vfRBe4qXupGulLBXuqKuVs8HCaNhax
LwIDAQAB
-----END PUBLIC KEY-----

                    [callback_url] => https://0af58a69f8b3df988e394103f64604c2.m.pipedream.net
                    [email] => 
                    [event_hooks] => Array
                        (
                            [0] => bank_account_status
                            [1] => send_instruction_status
                        )

                    [created_at] => 2024-01-15T04:57:24.301Z
                    [updated_at] => 2024-01-15T04:57:24.301Z
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
                    [total_count] => 2
                )

        )

)
*/