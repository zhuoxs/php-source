<?php
// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');

session_start();
include "thinkphp/base.php";

$config = \think\App::initCommon();

global $_W,$_GPC;
$do = strtolower($_GPC['do']);
$op = strtolower($_GPC['op']);
//微擎进入
if ($_W['user']){
    $_SESSION['admin'] = [
        'name'=>'超级管理员',
        'code'=>'admin',
        'store_id'=>0,
        'uniacid'=>$_W['uniacid'],
    ];
//    独立后台进入
}else{
    $_W['uniacid'] = $_SESSION['admin']['uniacid'];
    $_W['attachurl'] = ($_SERVER['REQUEST_SCHEME']?:'http').'://'.$_SERVER['SERVER_NAME'].'/'.$_W['config']['upload']['attachdir'].'/';
}
// 生成后台地址
function adminurl($op, $do='', $params= []){
    global $_W,$_GPC;
    $url = './index.php?c=site&a=entry&';
    if ($do == ''){
        $do = $_GPC['do'];
    }
    $url .= "do={$do}&";

    $data = [
        'op'=>$op,
        'm'=>'yztc_sun',
    ];
    $data = array_merge($data,$params);
    if (!empty($data)) {
        $queryString = http_build_query($data, '', '&');
        $url .= $queryString;
    }

    return $url;
}

try {
    $data = \think\App::module('admin/' . $do . '/' . $op, $config);
    // 输出数据到客户端
    if ($data instanceof \think\Response) {
        $response = $data;
    } elseif (!is_null($data)) {
        $request = \think\Request::instance();
        // 默认自动识别响应输出类型
        $type = $request->isAjax() ?
            \think\Config::get('default_ajax_return') :
            \think\Config::get('default_return_type');

        $response = \think\Response::create($data, $type);
    } else {
        $response = \think\Response::create();
    }
}catch (\think\exception\HttpResponseException $exception){
    $response = $exception->getResponse();
}
$response->send();
exit;
//defined('IN_IA') or exit('Access Denied');
//
//
//global $_W,$_GPC;
//$url = 'http://'. $_SERVER['SERVER_NAME'];
//$url .= str_replace('web/index.php','', $_SERVER['SCRIPT_NAME']);
//$url .= 'addons/'. $_GPC['m'].'/public/admin.php';
//header('location:'.$url);