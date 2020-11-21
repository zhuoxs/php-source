<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:49
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzfc_sun_we',array('uniacid'=>$_W['uniacid']));
$map_key=pdo_get('yzfc_sun_system',array('uniacid'=>$_W['uniacid']))['map_key'];
if(checksubmit('submit')){
    if($_GPC['name']==null) {
        message('请您填写公司名称', '', 'error');
    }elseif($_GPC['content']==null) {
        message('请您填写公司简介', '', 'error');
    }elseif($_GPC['tel']==null) {
        message('请您填写电话号码', '', 'error');
    }elseif($_GPC['address']==null) {
        message('请您填写公司地址', '', 'error');
    }elseif($_GPC['lng']==null) {
        message('请您先定位公司地址', '', 'error');
    }

    $data['uniacid'] = $_W['uniacid'];
    $data['name']=$_GPC['name'];
    $data['content']=$_GPC['content'];
    $data['tel']=$_GPC['tel'];
    $data['address']=$_GPC['address'];
    $data['lng']=$_GPC['lng'];
    $data['lat']=$_GPC['lat'];
    $data['pic']=$_GPC['pic'];
    $data['qq']=$_GPC['qq'];
    $data['email']=$_GPC['email'];
    $data['selftime']=date('Y-m-d H:i:s', time());


    if($_GPC['id']==''){

        $res=pdo_insert('yzfc_sun_we',$data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('we',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzfc_sun_we', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('we',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/we');