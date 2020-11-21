<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('mzhk_sun_coupon',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){
	$data['is_counp']=$_GPC['is_counp'];
    $res = pdo_update('mzhk_sun_coupon', $data,array('uniacid'=>$_W['uniacid']));
    if($res){
        message('编辑成功',$this->createWebUrl('couponsing',array()),'success');
    }else{
        message('编辑失败','','error');
    }

}
include $this->template('web/couponsing');