<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('ymktv_sun_vipka',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['vip_title'] = $_GPC['vip_title'];
    $data['vip_term'] = $_GPC['vip_term'];
    $data['vip_price'] = $_GPC['vip_price'];
    $data['vip_type'] = $_GPC['vip_type'];
    if($_GPC['id']==''){
        $data['uniacid'] = $_W['uniacid'];
        $res=pdo_insert('ymktv_sun_vipka',$data);
        if($res){
            message('添加成功',$this->createWebUrl('adminvip',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('ymktv_sun_vipka', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('adminvip',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/vip/adminvipinfo');