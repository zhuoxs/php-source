<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------
// [ 应用入口文件 ]
header('Content-Type:text/html;charset=utf-8');
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.5.0','<'))  die('PHP版本过低，最少需要PHP5.5，请升级PHP版本！');
// 定义应用目录
define('APP_PATH', __DIR__ . '/app/');
// 检查是否安装
if(!is_file(APP_PATH.'install/install.lock')) {
    if (!is_writable(__DIR__ . '/runtime')) {
        echo '请开启[runtime]文件夹的读写权限';
        exit;
    }
    define('BIND_MODULE', 'install');
}
// 定义入口为admin
define('ENTRANCE', 'admin');
// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';
