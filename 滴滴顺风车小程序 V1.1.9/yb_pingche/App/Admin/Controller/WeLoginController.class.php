<?php

namespace Admin\Controller;

use Think\Controller;

class WeLoginController extends Controller
{
    public function index()
    {
        if(session_status() != PHP_SESSION_ACTIVE){
            @session_start();
        }

        $account = session('we8');
        $current_url = get_url();
        //$key = 'addons/' . WE7_MODULE_NAME;

        //$we7_url = mb_substr($current_url, 0, stripos($current_url, $key));
        $we7_url = 'https://'.$_SERVER['HTTP_HOST'];
        if(empty($account)){
            header('Location:'.$we7_url);
            exit();
        }

        $wxapp = M('wxapp')->where(['uniacid'=>$account['acid']])->find();
        if(!$wxapp){
            $add['uniacid'] = $account['acid'];
            $add['name']    =  $account['name'];
            $add['create_time'] = time();
            M('wxapp')->add($add);
        }

        $config = M('config')->where(['uniacid'=>$account['acid']])->find();
        if(!$config)
        {
            $add2['pingche_xcx_appid'] = $account['key'];
            $add2['wx_pay_appid']= $account['key'];
            $add2['pingche_xcx_secret'] = $account['secret'];
            $add2['uniacid'] = $account['acid'];
            $add2['appname'] = $account['name'];
            $add2['addtime'] = time();
            M('config')->add($add2);
        }
         header('Location:'.$we7_url.'/addons/yb_pingche/admin.php');
    }

}
?>