<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$data['jihuoma']='MZ'.time() . mt_rand(100, 999);
$res = pdo_update('mzhk_sun_vip', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
if($res){
    message('激活码编辑成功',$this->createWebUrl('Vip',array()),'success');
}
include $this->template('web/changvip');