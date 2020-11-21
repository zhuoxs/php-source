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
define('BIND_MODULE','admin');
// 加载框架引导文件

//微擎
require __DIR__.'/../../../framework/bootstrap.inc.php';
require IA_ROOT . '/web/common/bootstrap.sys.inc.php';
//require __DIR__.'/../../../web/common/tpl.func.php';

global $_W,$_GPC;
$url = 'http://'. $_SERVER['SERVER_NAME'];
$url .= str_replace('admin.php','', $_SERVER['SCRIPT_NAME']);
$_W['web_root'] = $url;
$_W['weiqing_root'] = explode('addons',$url)[0];
$_W['weiqing_static'] = $_W['weiqing_root']."web/resource/";
$_W['uniacid'] = $_W['uniacid'];// todo 这边修改

//判断是否请求微擎
if ($_GPC['c'] == "utility" and $_GPC['a'] == "file"){
    include IA_ROOT . '/web/index.php';
    exit;
}

require __DIR__ . '/../thinkphp/start.php';
