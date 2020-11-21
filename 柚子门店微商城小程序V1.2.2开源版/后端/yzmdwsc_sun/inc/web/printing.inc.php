<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzmdwsc_sun_printing',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['user']=trim($_GPC['user']);
    $data['key']=trim($_GPC['key']);
    $data['is_open']=$_GPC['is_open'];
    $data['sn'] = $_GPC['sn'];
    $data['uniacid']=trim($_W['uniacid']);
    $data['add_time']=time();
    if($_GPC['id']==''){
        $res=pdo_insert('yzmdwsc_sun_printing',$data);
        if($res){
            message('添加成功',$this->createWebUrl('printing',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['add_time']);
        $res = pdo_update('yzmdwsc_sun_printing', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('printing',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/printing');