<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_xianshigouopen']=$_GPC['is_xianshigouopen'];
    $data['uniacid']=$_W['uniacid'];
    $data['xianshigou_title']=$_GPC['xianshigou_title'];
    if($_GPC['id']==''){                
        $res=pdo_insert('mzhk_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('xianshigouopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('xianshigouopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/xianshigouopen');