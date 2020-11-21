<?php

use GatewayWorker\Gateway;

$context = array(
    // 参考手册 http://php.net/manual/zh/context.ssl.php
    'ssl' => array(
        'local_cert'                 => __DIR__.'/ssl/server.pem', // 也可以是crt文件
        'local_pk'                   => __DIR__.'/ssl/server.key',
        'verify_peer'                => false,
//        'allow_self_signed'          => true, //如果是自签名证书需要开启此选项
    )
);



$gate = new Gateway("websocket://0.0.0.0:3671",$context);
$gate->transport = 'ssl';
$gate->startPort = 2001;
$gate->name = 'Gateway';
$gate->pingInterval = 55;
$gate->pingNotResponseLimit = 1;
$gate->registerAddress = '127.0.0.1:1234';








