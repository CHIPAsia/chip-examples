<?php

$epoch = time();
$api_key = '';
$api_secret = '';

$str = $epoch . $api_key;
$hmac = hash_hmac( 'sha512', $str, $api_secret );

$url = 'https://staging-api.chip-in.asia/api/send/send_limits';

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
                                    [destination] => test@gmail.com
                                    [status] => pending
                                    [approved_at] => 
                                    [expires_at] => 2024-02-21T04:00:00.000Z
                                )
                        )

                    [created_at] => 2024-02-21T01:56:41.800Z
                    [updated_at] => 2024-02-21T01:56:41.800Z
                )

            [1] => Array
                (
                    [id] => 1154
                    [currency] => MYR
                    [fee_type] => flat
                    [transaction_type] => in
                    [amount] => 12
                    [fee] => 0
                    [net_amount] => 12
                    [send_instruction_id] => 
                    [bank_account_id] => 
                    [from_settlement] => 2024-02-21
                    [status] => expired
                    [approvals_required] => 1
                    [approvals_received] => 0
                    [approvals_details] => Array
                        (
                            [0] => Array
                                (
                                    [destination_type] => email
                                    [destination] => test@gmail.com
                                    [status] => expired
                                    [approved_at] => 
                                    [expires_at] => 2024-02-21T04:00:00.000Z
                                )
                        )

                    [created_at] => 2024-02-21T01:56:09.104Z
                    [updated_at] => 2024-02-21T01:56:41.819Z
                )

            [2] => Array
                (
                    [id] => 1147
                    [currency] => MYR
                    [fee_type] => flat
                    [transaction_type] => out
                    [amount] => -0.01
                    [fee] => 1
                    [net_amount] => -1.01
                    [send_instruction_id] => 584
                    [bank_account_id] => 
                    [from_settlement] => 
                    [status] => success
                    [approvals_required] => 0
                    [approvals_received] => 0
                    [approvals_details] => Array
                        (
                        )

                    [created_at] => 2024-01-23T08:53:40.854Z
                    [updated_at] => 2024-01-23T08:53:40.854Z
                )

            [3] => Array
                (
                    [id] => 1146
                    [currency] => MYR
                    [fee_type] => flat
                    [transaction_type] => out
                    [amount] => -0.01
                    [fee] => 1
                    [net_amount] => -1.01
                    [send_instruction_id] => 583
                    [bank_account_id] => 
                    [from_settlement] => 
                    [status] => success
                    [approvals_required] => 0
                    [approvals_received] => 0
                    [approvals_details] => Array
                        (
                        )

                    [created_at] => 2024-01-23T08:49:27.588Z
                    [updated_at] => 2024-01-23T08:49:27.588Z
                )

            [4] => Array
                (
                    [id] => 1145
                    [currency] => MYR
                    [fee_type] => flat
                    [transaction_type] => in
                    [amount] => 1000
                    [fee] => 0
                    [net_amount] => 1000
                    [send_instruction_id] => 
                    [bank_account_id] => 
                    [from_settlement] => 2024-01-24
                    [status] => approved
                    [approvals_required] => 1
                    [approvals_received] => 1
                    [approvals_details] => Array
                        (
                            [0] => Array
                                (
                                    [destination_type] => email
                                    [destination] => test@gmail.com
                                    [status] => approved
                                    [approved_at] => 2024-01-23T08:46:04.829Z
                                    [expires_at] => 2024-01-24T04:00:00.000Z
                                )

                        )

                    [created_at] => 2024-01-23T08:44:07.126Z
                    [updated_at] => 2024-01-23T08:46:04.861Z
                )

            [5] => Array
                (
                    [id] => 1089
                    [currency] => MYR
                    [fee_type] => flat
                    [transaction_type] => out
                    [amount] => -2
                    [fee] => 1
                    [net_amount] => -3
                    [send_instruction_id] => 552
                    [bank_account_id] => 
                    [from_settlement] => 
                    [status] => success
                    [approvals_required] => 0
                    [approvals_received] => 0
                    [approvals_details] => Array
                        (
                        )

                    [created_at] => 2024-01-16T07:41:37.859Z
                    [updated_at] => 2024-01-16T07:41:37.859Z
                )

            [6] => Array
                (
                    [id] => 1088
                    [currency] => MYR
                    [fee_type] => flat
                    [transaction_type] => in
                    [amount] => 11
                    [fee] => 0
                    [net_amount] => 11
                    [send_instruction_id] => 
                    [bank_account_id] => 
                    [from_settlement] => 2024-01-17
                    [status] => approved
                    [approvals_required] => 1
                    [approvals_received] => 1
                    [approvals_details] => Array
                        (
                            [0] => Array
                                (
                                    [destination_type] => email
                                    [destination] => test@gmail.com
                                    [status] => approved
                                    [approved_at] => 2024-01-16T07:40:31.882Z
                                    [expires_at] => 2024-01-17T04:00:00.000Z
                                )

                        )

                    [created_at] => 2024-01-16T07:39:07.540Z
                    [updated_at] => 2024-01-16T07:40:31.913Z
                )

        )

    [meta] => Array
        (
            [pagination] => Array
                (
                    [current_page] => 1
                    [prev_page] => 
                    [next_page] => 2
                    [total_pages] => 9
                    [total_count] => 211
                )

        )

)
*/