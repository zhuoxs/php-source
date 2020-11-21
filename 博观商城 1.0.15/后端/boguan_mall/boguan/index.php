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
define('APP_PATH', __DIR__ . '/application/');
//define('LOG_PATH', __DIR__ . '/log/');
//模块标识名称
define('MODEL','boguan_mall');
define('MODEL_PATH','addons/'.MODEL.'/boguan/');

if ($_SERVER['SERVER_NAME'] != $_SERVER['HTTP_HOST']){
    $server= $_SERVER['HTTP_HOST'];
}else{
    $server= $_SERVER['SERVER_NAME'];
}
//网站主域名
define('SITE_URL', '//'.$server.'/');
//小程序域名
define('MINI_URL', 'https://'.$server.'/');

//api url
define('API_URL', SITE_URL.'addons/'.MODEL_PATH.'/boguan/index.php/api/v1/');
//后台路径
define('BG_URL', '//'.$server.'/');


define('WE7_PATH', SITE_URL.'addons/'.MODEL.'/boguan/');
//小程序素材路径
define('MINI_WE7_PATH', MINI_URL.'addons/'.MODEL.'/boguan/');
define('WE_PATH', BG_URL.'addons/'.MODEL.'/boguan/');

// 加载微擎框架文件
require '../../../framework/bootstrap.inc.php';

// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
