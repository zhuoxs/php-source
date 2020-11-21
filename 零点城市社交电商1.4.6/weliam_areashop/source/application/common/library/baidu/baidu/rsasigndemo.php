<?php

require("Autoloader.php");

/**
 * 第一部分：从公私钥文件路径中读取出公私钥文件内容
 */

$rsaPrivateKeyFilePath = 'rsa/rsa_private_key.pem';
$rsaPublicKeyFilePath = 'rsa/rsa_public_key.pem';

if( !file_exists($rsaPrivateKeyFilePath) || !is_readable($rsaPrivateKeyFilePath) ||
    !file_exists($rsaPublicKeyFilePath) || !is_readable($rsaPublicKeyFilePath) ){
    return false;
}

$rsaPrivateKeyStr = file_get_contents($rsaPrivateKeyFilePath);
$rsaPublicKeyStr = file_get_contents($rsaPublicKeyFilePath);

/**
 * 第二部分：生成签名 DEMO
 */

$requestParamsArr = array(
    'orderId' => 55558888,
    'refundBatchId' => '88000001'
);
$rsaSign = NuomiRsaSign::genSignWithRsa($requestParamsArr, $rsaPrivateKeyStr);
$requestParamsArr['sign'] = $rsaSign;
print_r($requestParamsArr);

/**
 * 第三部分：校验签名 DEMO
 */

$checkSignRes = NuomiRsaSign::checkSignWithRsa($requestParamsArr, $rsaPublicKeyStr);
print_r($checkSignRes); # true :签名校验成功，false：签名校验失败

