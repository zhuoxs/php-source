<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('byjs_sun_business_tel',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    $data['phone']=$_GPC['phone'];
  	$data['team']=$_GPC['team'];
  	$data['logo']=$_GPC['logo'];
    $data['uniacid'] = $_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('byjs_sun_business_tel',$data);
        if($res){
            message('添加成功',$this->createWebUrl('businessTel',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('byjs_sun_business_tel', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('businessTel',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/businesstel');