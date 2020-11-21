<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/5
 * Time: 9:54
 */
global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzzc_sun_msg_set',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['open']=$_GPC['open'];
    $data['type']=$_GPC['type'];
    $data['api_account']=$_GPC['api_account'];
    $data['api_psw']=$_GPC['api_psw'];
    $data['buy_template']=$_GPC['buy_template'];
    $data['dayu_signname']=$_GPC['dayu_signname'];
    $data['dayu_templatecode']=$_GPC['dayu_templatecode'];
    $data['dayu_accesskey']=$_GPC['dayu_accesskey'];
    $data['dayu_accesskeysecret']=$_GPC['dayu_accesskeysecret'];
    $data['uniacid']=$_W['uniacid'];
    if($_GPC['id']==''){
        $res=pdo_insert('yzzc_sun_msg_set',$data);
    }else{
        $res=pdo_update('yzzc_sun_msg_set',$data,array('id'=>$_GPC['id']));
    }
    if($res){
        message('设置成功！', $this->createWebUrl('msgset'), 'success');
    }else{
        message('设置失败！','','error');
    }
}
include $this->template('web/msgset');