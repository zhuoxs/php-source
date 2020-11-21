<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('mzhk_sun_goods',array('uniacid'=>$_W['uniacid']));
$item2=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_hyopen']=$_GPC['is_hyopen'];
	$data2['code_type']=$_GPC['code_type'];

    $res = pdo_update('mzhk_sun_goods', $data);
	$res2 = pdo_update('mzhk_sun_system',$data2,array('uniacid'=>$_W['uniacid']));
    if($res || $res2){
        message('编辑成功',$this->createWebUrl('hyopen',array()),'success');
    }else{
        message('编辑失败','','error');
    }

}
include $this->template('web/hyopen');