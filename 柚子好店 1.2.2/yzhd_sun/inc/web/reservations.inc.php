<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$branch_id = $_GPC['id'];

$list= pdo_getall('yzhd_sun_reservations', array('branch_id' => $branch_id,'uniacid'=>$_W['uniacid']));
//

//

if($_GPC['op']=='delete'){

    $res=pdo_delete('yzhd_sun_reservations',array('id'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));

    if($res){
         message('删除成功！', $this->createWebUrl('reservations'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='mdelete'){

  	foreach ($_GPC['id'] as $key => $id) {
    	$res=pdo_delete('yzhd_sun_reservations',array('id'=>$id,'uniacid'=>$_W['uniacid']));
    }

    message('删除成功！', $this->createWebUrl('reservations'), 'success');
}

if($_GPC['op']=='mok'){

  	foreach ($_GPC['id'] as $key => $id) {
    	$res = pdo_update('yzhd_sun_reservations',array('status'=>1),array('id'=>$id,'uniacid'=>$_W['uniacid']));
    }

    message('通过成功！', $this->createWebUrl('reservations'), 'success');
}

if($_GPC['op']=='tg'){
    $res=pdo_update('yzhd_sun_reservations',array('status'=>1),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('branchslist'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhd_sun_reservations',array('state'=>3),array('id'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('yzhd_sun_reservations'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/reservations');
