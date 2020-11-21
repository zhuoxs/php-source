<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){           
    $data['is_bargainopen']=$_GPC['is_bargainopen'];
    $data['uniacid']=$_W['uniacid'];
    $data['bargain_price']=$_GPC['bargain_price'];
    $data['share_title']=$_GPC['share_title'];

    if($_GPC['id']==''){
        $res=pdo_insert('yzhd_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('kanjiaopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('yzhd_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('kanjiaopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/kanjiaopen');