<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzmdwsc_sun_user',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    $user=pdo_get('yzmdwsc_sun_user',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if(!$user){
        message('充值失败','','error');
    }
    $data['uniacid']=$_W['uniacid'];
    $data['openid']=$user['openid'];
    $data['sign']=1;
    $data['type']=5;
    $data['money']=$_GPC['money'];
    $data['title']=$_GPC['title'];
    $data['add_time']= time();
    $res=pdo_insert('yzmdwsc_sun_user_amount_record',$data);
    $money=$user['amount']+$_GPC['money'];
    if($money<0){
        message('用户余额不能少于0','','error');
    }
    pdo_update('yzmdwsc_sun_user',array('amount +='=>$_GPC['money']),array('id'=>$_GPC['id']));
    if($res){
        message('充值成功',$this->createWebUrl('user2',array()),'success');
    }else{
        message('充值失败','','error');
    }
}
include $this->template('web/user2recharge');