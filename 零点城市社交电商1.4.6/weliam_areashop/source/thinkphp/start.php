<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;
ob_start();//清空缓冲区
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Max-Age:1728000');

if($_SERVER['HTTP_ACCEPT'] == "OPTIONS"){
    header('Access-Control-Allow-Headers:Content-Type, Accept, Authorization, X-Requested-With, X_Requested_With, Origin');
    header('Access-Control-Request-Method:*');
}
// ThinkPHP 引导文件
// 1. 加载基础文件
require __DIR__ . '/base.php';

// 2. 执行应用
App::run()->send();

