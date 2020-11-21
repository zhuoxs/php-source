<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// [ 应用入口文件 ]
// 定义应用目录

define('APP_PATH', __DIR__ . '/../application/');


// 判断是否安装
if (!is_file(APP_PATH . 'admin/command/Install/install.lock'))
{

    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    $url = $http_type . $_SERVER['HTTP_HOST'].'/addons/make_freight/public/install.php';
    header("location:".$url);
    exit;
}

//加载微擎引导文件
require '../../../../framework/bootstrap.inc.php';

//加载微擎后台登陆管理
require '../../../../web/common/bootstrap.sys.inc.php';



// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';




