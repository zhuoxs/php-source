<?php
define('APP_PATH', __DIR__ . '/../application/');
define('BIND_MODULE','api');
// 加载框架引导文件
require __DIR__.'/../../../framework/bootstrap.inc.php';
require __DIR__ . '/../thinkphp/base.php';
$config = \think\App::initCommon();
\think\App::module('api/Cwx/paycallback',$config);



