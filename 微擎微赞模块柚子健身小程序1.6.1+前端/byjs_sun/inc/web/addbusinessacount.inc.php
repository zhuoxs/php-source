<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('byjs_sun_business_account',array('uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    $data['account']=$_GPC['username'];
    $data['password']=$_GPC['pwd'];
    $data['img'] = $_GPC['img'];
    $data['uniacid'] = $_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('byjs_sun_business_account',$data);
        if($res){
            message('添加成功',$this->createWebUrl('addbusinessacount',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('byjs_sun_business_account', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('addbusinessacount',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/addbusinessacount');