<?php

$generatedKey='1234567891111156';
$generatedIV='3213213213213216';
$data='abcefg';

$test1=bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $generatedKey, $data, MCRYPT_MODE_CBC, $generatedIV));
$test2=bin2hex(openssl_encrypt($data, 'AES-128-CBC',$generatedKey,0,$generatedIV)); //兼容 >=PHP7.1

var_dump($test1);

echo "<br />";

var_dump($test2);
