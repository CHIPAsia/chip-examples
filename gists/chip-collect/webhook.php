<?php

$public_key = '-----BEGIN PUBLIC KEY-----
MIIBojANBgkqhkiG9w0BAQEFAAOCAY8AMIIBigKCAYEAxUI+CR2F5DeFtZdZAtek
SWMOgh4ToH/oez8T1oCj2AIuRi7w+8Yq9WCnncfg4ZQ0MCyZi0yIMmrJigAfH6wf
o/npilTKmQMdvNAAZyvHZbj75iyQ4CpU34ujHSFjjEUGoxFLNxjAQ3ycreYErHQC
5DbMGU+u1cKvyT3rFzn/Wq5ILs4/H0ZG/O1ZvI50pojQIYmivWKGr93D45QUUIT9
sRFGY7dyIPgaNy7T0GLPrkLL+zkXtgQ3ipz6/hEU7Y3TJtdBawvE2/YIqHZFPXpx
FejUkU6/8kAoBTIVdCU2EVsphuwzGiEKpvfdEut/ns2xXrGdRhRaVQ1wV8+Jm4O5
yASogAB+BL4RqjkzqN6DpVkaD3KK09XxhSgYelNl3NBf8P69H8kjtZ1zhLyGCc4K
u2H2spW8XrK7XkjITSC61R91OU5hDMem8n3VQASi2B5/Hqi0n3fnx7qRiNAPXDsU
bWrqESwpLPBjXjREYwGY0/XY+mRvGGToJ8+HPBLRVFTtAgMBAAE=
-----END PUBLIC KEY-----';

$postdata = file_get_contents('php://input');
$x_signature = $_SERVER['HTTP_X_SIGNATURE'];

if (openssl_verify( $postdata,  base64_decode($x_signature), $public_key, 'sha256WithRSAEncryption' ) != 1) {
  exit('Openssl Verify Failed!');
}

$data = json_decode($postdata, true);

