<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/25
 * Time: 14:06
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzfc_sun_admin',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$branch=pdo_getall('yzfc_sun_branch',array('uniacid'=>$_W['uniacid'],'status'=>1));
//var_dump($branch);exit;
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['account']=$_GPC['account'];
    if (preg_match("/^[a-z0-9\#]*$/",  $data['account'])){
        $data['auth']=$_GPC['auth'];
        if($data['auth']==2){
            $data['bid']=$_GPC['bid'];
        }else{
            $data['bid']=0;
        }
        $data['createtime']=time();
        $data['token']=md5(time());
    }else{
        message('账号只能含有英文或数字','','error');
    }


    if($_GPC['id']==''){
        if($_GPC['psw']){
            $data['psw']=md5($_GPC['psw']);
        }else{
            message('密码不能为空','','error');
        }
        $res = pdo_insert('yzfc_sun_admin',$data);
        if($res){
            message('添加成功',$this->createWebUrl('useradmin',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        if($_GPC['psw']){
            $data['psw']=md5($_GPC['psw']);
        }
        $res = pdo_update('yzfc_sun_admin', $data, array('id'=>$_GPC['id']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('useradmin',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/userinfo');