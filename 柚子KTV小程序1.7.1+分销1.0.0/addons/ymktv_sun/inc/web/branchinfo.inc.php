<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('fyly_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['name']=$_GPC['name'];
    $data['tel']=$_GPC['tel'];
    $data['img']=$_GPC['img'];
    $data['province_id']=$_GPC['province_id'];
    $data['city_id']=$_GPC['city_id'];
    $data['county_id']=$_GPC['county_id'];
    $data['uniacid']=$_W['uniacid'];
    $data['address']=$_GPC['address'];
    $data['lng']=$_GPC['lng'];
    $data['lat']=$_GPC['lat'];
    if($_GPC['id']==''){
        $res=pdo_insert('fyly_sun_branch',$data);
        if($res){
            message('添加成功',$this->createWebUrl('branch',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('fyly_sun_branch', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('branch',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/branchinfo');