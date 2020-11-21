<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('wnjz_sun_adminstore',array('id'=>$_GPC['id']));
// 获取门店数据
$branch = pdo_getall('wnjz_sun_branch',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    if($_GPC['build_id']==0){
        message('请选择门店');
    }
    $data['build_id'] = $_GPC['build_id'];
    $data['account'] = $_GPC['account'];
    $data['password'] = $_GPC['password'];
    $data['store_name'] = $_GPC['store_name'];
    $data['mobile'] = $_GPC['mobile'];
    $data['uniacid']=$_W['uniacid'];
     if($_GPC['id']==''){
         $re = pdo_get('wnjz_sun_adminstore',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['account']));
         if($re){
             message('该账户已存在!');
         }else{
             $res=pdo_insert('wnjz_sun_adminstore',$data);
         }
        if($res){
             message('添加成功！', $this->createWebUrl('adminstore'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{
         $be = pdo_getall('wnjz_sun_adminstore',array('uniaicd'=>$_W['uniacid'],'id !='=>$_GPC['id'],'account'=>$_GPC['account']));
         if($be){
             message('该账户已存在!');
         }else{
             $res=pdo_update('wnjz_sun_adminstore',$data,array('id'=>$_GPC['id']));
         }
        if($res){
             message('编辑成功！', $this->createWebUrl('adminstore'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}
include $this->template('web/addadminstore');