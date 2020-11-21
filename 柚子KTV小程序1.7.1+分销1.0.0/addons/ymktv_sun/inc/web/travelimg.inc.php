<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('fyly_sun_banner',array('location' =>7,'uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
    $data['bname']=$_GPC['bname'];
    $data['lb_imgs']=$_GPC['lb_imgs'];
    $data['uniacid'] = $_W['uniacid'];
    $data['location'] = 7; //此处添加的是行程的顶部图
    if ($info == null || $info == ''){
        $res = pdo_insert('fyly_sun_banner',$data);
    }else{
        $res = pdo_update('fyly_sun_banner',$data,array('uniacid' => $_W['uniacid'],'location' => 7));
    }

    if ($res){
        message('添加成功',$this->createWebUrl('travelimg'),'success');
    }else{
        message('添加失败',$this->createWebUrl('travelimg'),'error');
    }
}
include $this->template('web/travelimg');