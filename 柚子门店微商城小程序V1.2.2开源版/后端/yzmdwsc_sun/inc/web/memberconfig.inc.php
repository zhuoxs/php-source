<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzmdwsc_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['is_open_member']=$_GPC['is_open_member'];
    $data['member_info']=htmlspecialchars_decode($_GPC['member_info']);
    if($_GPC['id']==''){                
        $res=pdo_insert('yzmdwsc_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('memberconfig',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{

        $res = pdo_update('yzmdwsc_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('memberconfig',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/memberconfig');