<?php

require("Autoloader.php");

/**
 * 第一部分：从申请的私钥文件路径中读取出私钥的内容
 */

$rsaPriviateKeyFilePath = 'rsa/rsa_private_key.pem';

if( !file_exists($rsaPriviateKeyFilePath) || !is_readable($rsaPriviateKeyFilePath)){
    //throw 自己系统的异常
}

$rsaPrivateKey = file_get_contents($rsaPriviateKeyFilePath);

/**
 * 第二部分：新建请求对象
 * 每个接口的请求对象都不一样
 */

$request = new NuomiIntegrationCashierOrderConsumeRequest();

/**
 * 1.每个接口都必须传的系统参数
 */
$request->setAppKey('MMM4hG');

/**
 * 2.每个接口单独的业务参数
 */
$request->setOrderId('800200451');
$request->setUserId('2250333905');

/**
 * 3.生成签名,设置RsgSign签名
 */

#获取当前request请求参数的数组，用来生成签名
$requestApiParamsArr = $request->getApiParams();

$rsaSign = NuomiRsaSign::genSignWithRsa( $requestApiParamsArr ,$rsaPrivateKey);

$request->setRsaSign($rsaSign);




/**
 * 第三部分：执行请求
 */
$nuomiRequestClient = new NuomiRequestClient();
$res = $nuomiRequestClient->exec($request);

//第四部分：根据接口返回处理自己的相关逻辑
print_r( $res );