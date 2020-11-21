<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}
class Api_Login extends WeModuleWxapp
{
    /**
     * 发送验证码
     */
    public function send(){
        global $_GPC, $_W;
        $params = [
            'phone' => $_GPC['phone'],
            'uniacid'=>$_W['uniacid'],
            'create_time' => $_SERVER['REQUEST_TIME']
        ];
       $detail =  pdo_fetch("SELECT * FROM  ".tablename('ox_master_code_log')."  WHERE phone = :phone AND uniacid ={$_W['uniacid']} AND create_time > ".($_SERVER['REQUEST_TIME'] -60),[':phone' => $_GPC['phone']]);
       if($detail){
           return $this->result(1, '发送过于频繁',    $params['code']);
       }
        $params['code'] = rand(100000,999999);
        Qcloud::instance()->tempSend(['phone'=>$_GPC['phone'],'code'=>$params['code'] ,'num'=>10]);
        $result = pdo_insert('ox_master_code_log',$params);
        return $this->result(0, '发送成功',    $params['code']);
    }
    /**
     * 登录
     */
    public function login(){
        global $_GPC, $_W;
        $detail =  pdo_fetch("SELECT * FROM  ".tablename('ox_master_code_log')."  WHERE phone = :phone AND uniacid ={$_W['uniacid']} AND create_time > ".($_SERVER['REQUEST_TIME'] -600),[':phone' => $_GPC['phone']]);
        if($detail && $detail['code'] = $_GPC['code']  ){
            $result = pdo_get('ox_master_store',['uniacid' =>$_W['uniacid'],'phone' =>  $_GPC['phone'] ]);
            return $this->result(0, '登录成功',$result);
        }else{
            return $this->result(1, '验证码不正确','');
        }
    }

}