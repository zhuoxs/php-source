<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:49
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzfc_sun_branch',array('id'=>$_GPC['id']));
$map_key=pdo_get('yzfc_sun_system',array('uniacid'=>$_W['uniacid']))['map_key'];
if(strpos($item['banner'],',')){

    $lb_imgs= explode(',',$item['banner']);
}else{
    $lb_imgs=array(
        0=>$item['banner']
    );
}
//var_dump($lb_imgs);exit;
if(checksubmit('submit')){
    if($_GPC['name']==null) {
        message('请您填写分店名称', '', 'error');
    }elseif($_GPC['tel']==null) {
        message('请您填写电话号码', '', 'error');
    }elseif($_GPC['address']==null) {
        message('请您填写分店地址', '', 'error');
    }elseif($_GPC['lng']==null) {
        message('请您先定位分店地址', '', 'error');
    }

    $data['uniacid'] = $_W['uniacid'];
    $data['name']=$_GPC['name'];
    $data['pic']=$_GPC['pic'];

    $data['tel']=$_GPC['tel'];
    $data['address']=$_GPC['address'];
    $data['lng']=$_GPC['lng'];
    $data['lat']=$_GPC['lat'];
    $data['selftime']=date('Y-m-d H:i:s', time());


    if($_GPC['id']==''){

        $res=pdo_insert('yzfc_sun_branch',$data);

        if($res){
            message('添加成功',$this->createWebUrl('branchlist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzfc_sun_branch', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('branchlist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/addbranch');