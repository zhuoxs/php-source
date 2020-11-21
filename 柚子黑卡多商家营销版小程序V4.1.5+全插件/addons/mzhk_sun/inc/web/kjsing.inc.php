<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('mzhk_sun_goods',array('uniacid'=>$_W['uniacid']));
$item2=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_kjopen']=$_GPC['is_kjopen'];
	$data2['open_num']=$_GPC['open_num'];
	$data2['day_num']=$_GPC['day_num'];
	$data2['open_friend']=$_GPC['open_friend'];
	$data2['friend_num']=$_GPC['friend_num'];
    $res = pdo_update('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));
	$res2 = pdo_update('mzhk_sun_system', $data2,array('uniacid'=>$_W['uniacid']));
    if($res || $res2){
        message('编辑成功',$this->createWebUrl('kjsing',array()),'success');
    }else{
        message('编辑失败','','error');
    }

}
include $this->template('web/kjsing');