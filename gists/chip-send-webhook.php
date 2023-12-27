<?php

$public_key = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuhWXgq84Zi7d2rUZnbvf
L09fqoLKaqv3AAHDfo4Kkn2kMrYDiMFh1U/m63mW/PFZYyrK8bFAj83qj0ocHZyg
CBPFH7N8EAdXOkL1WZCxkaau7839agPA39vhehZhpKdQCF/h3t8LAVDecbjsLu/3
lqkWq809SAut+J37pwQphtSMqoG2Y1s/V42wevTllwMqKXjrI/13SrG9t9uN/pWS
4ULoOngqGB8Q2bbO8IxcMNBbwxP7/O1+4oLSsBZl2QVDeaODj495OpWgqUjZmjkx
IdIaQFneHmjBWwIWVVmCo2Nh5fasMYfJ6b765s6y0X6fSYcWi3CZ2YYFZ4Y+mD0L
swIDAQAB
-----END PUBLIC KEY-----';

$postdata = file_get_contents('php://input');
$x_signature = $_SERVER['HTTP_X_SIGNATURE'];

if (openssl_verify( $postdata,  base64_decode($x_signature), $public_key, 'sha512WithRSAEncryption' ) != 1) {
  exit('Openssl Verify Failed!');
}

$data = json_decode($postdata, true);

switch($_SERVER['HTTP_EVENT_TYPE']) {
  case 'send_instruction_status':
    break;
  case 'bank_account_status':
    break;
  case 'budget_allocation_status';
    break;
}