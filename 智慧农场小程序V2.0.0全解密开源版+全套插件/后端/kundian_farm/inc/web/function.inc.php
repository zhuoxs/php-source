<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/12 0012
 * Time: 15:05
 */
defined("IN_IA")or exit("Access denied");
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
function cacheCode($uniacid){
    $return =array();
    if(cache_load('kundian_farm_auth_code_time'.$uniacid) > time()){
        $return['code']=1;
    }else{
        $servername = trim($_SERVER['SERVER_NAME']);
        $url = 'http://baidu.com/public/index.php/index/index/allow_domain?domain='.$servername.'&module_name=kundian_farm';
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
        $result = curl_exec($ch);
        $res=json_decode($result);
        if($res->is_open_auth==1) {
            if ($res->code == 1000) {
                cache_write('kundian_farm_auth_code_time' . $uniacid, time() + 604800);
                cache_write('kundian_farm_auth_code' . $uniacid, $res->kundian_code);
                $return['code'] = 1;
            } else {
                $return['code'] = 2;
                $return['msg'] = $res->msg;
            }
        }else{
            $return['code']=1;
        }
    }
    return $return;
}

function checkKundianAuth(){
    global $_GPC,$_W;
    $res=cacheCode($_W['uniacid']);
    if($res['code']==2){
        message($res['msg'],'./index.php?c=miniapp&a=version&do=home&version_id='.$_GPC['version_id']);
    }
}
