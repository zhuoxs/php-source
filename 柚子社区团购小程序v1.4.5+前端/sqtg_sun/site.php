<?php
// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');

session_start();
include "thinkphp/base.php";

$_W['web_root'] = '/';
$arrs = explode('web/',$_SERVER['SCRIPT_NAME']);
if (count($arrs) == 2){
    $_W['web_root'] = $arrs[0];
}
$arrs = explode('addons/',$_SERVER['SCRIPT_NAME']);
if (count($arrs) == 2){
    $_W['web_root'] = $arrs[0];
}


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

    $remote = $_W['setting']['remote'];
    if ($remote[$_W['uniacid']]){
        $remote = $remote[$_W['uniacid']];
    }

    $_W['attachurl_local'] = ($_SERVER['REQUEST_SCHEME']?:'http').'://'.$_SERVER['SERVER_NAME'].'/'.$_W['config']['upload']['attachdir'].'/';

    switch ($remote['type']){
        case 0:
            $_W['attachurl'] = $_W['attachurl_local'];
            break;
        case 1:
//            $_W['attachurl'] = $remote['alioss']['url'];
            break;
        case 2:
            $_W['attachurl'] = $remote['alioss']['url'];
            $_W['attachurl_remote'] = $remote['alioss']['url'];
            break;
        case 3:
            $_W['attachurl'] = $remote['qiniu']['url'];
            $_W['attachurl_remote'] = $remote['qiniu']['url'];
            break;
        case 4:
            $_W['attachurl'] = $remote['cos']['url'];
            $_W['attachurl_remote'] = $remote['cos']['url'];
            break;
    }
    $_W['attachurl'] .= '/';
    $_W['attachurl_remote'] .= '/';
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
        'm'=>'sqtg_sun',
    ];
    $data = array_merge($data,$params);
    if (!empty($data)) {
        $queryString = http_build_query($data, '', '&');
        $url .= $queryString;
    }

    return $url."&version_id=".urlencode('1#');
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