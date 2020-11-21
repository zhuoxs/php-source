<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')) {

        $data['platform_tel'] = $_GPC['tel'];
        $data['platform_content'] = $_GPC['content'];
        $data['platform_address'] = $_GPC['address'];
        $data['platform_chat'] = $_GPC['chat'];
        $data['platform_logo'] = $_GPC['logo'];
        $data['is_platform'] = $_GPC['is_platform'];

        if($_GPC['id']){
           $res = pdo_update('yzhd_sun_system',$data,array('uniacid'=>$_W['uniacid']));
        }
        if ($res){
            message('操作成功',$this->createWebUrl('platform_info'),'success');
        }else{
            message('操作失败',$this->createWebUrl('platform_info'),'error');
        }
    }
include $this->template('web/platform_info');
