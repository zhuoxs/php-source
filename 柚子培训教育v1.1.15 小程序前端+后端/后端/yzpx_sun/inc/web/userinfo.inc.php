<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/25
 * Time: 14:06
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzpx_sun_integralset',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['sign']=$_GPC['sign'];
    $data['full']=$_GPC['full'];
    $data['cost_score']=$_GPC['cost_score'];
    $data['use_score']=$_GPC['use_score'];
    $data['use_money']=$_GPC['use_money'];
    $data['rule']=$_GPC['rule'];
    $data['selftime']=date('Y-m-d H:i:s', time());
    if($info==''){
        $res = pdo_insert('yzpx_sun_integralset', $data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('设置成功',$this->createWebUrl('userinfo',array()),'success');
        }else{
            message('设置失败','','error');
        }
    }else{
        $res = pdo_update('yzpx_sun_integralset', $data, array('uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('userinfo',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/userinfo');