<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('ymktv_sun_vip_open',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){           
    $data['vip_open']=$_GPC['vip_open'];
    $data['room_dis']=$_GPC['room_dis'];
    $data['drink_dis']=$_GPC['drink_dis'];
    //$data['vip_details'] = $_GPC['vip_details'];
	$data['vip_details'] = htmlspecialchars_decode($_GPC['vip_details']);
    $data['vip_pic'] = $_GPC['vip_pic'];
    $data['uniacid']=$_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('ymktv_sun_vip_open',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('vipsetup',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('ymktv_sun_vip_open', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('vipsetup',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/vip/vipsetup');