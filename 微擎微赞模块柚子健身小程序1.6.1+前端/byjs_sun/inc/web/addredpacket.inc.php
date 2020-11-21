<?php
global $_W,$_GPC;
$GLOBALS['frames'] = $this->getMainMenu();


if(checksubmit('submit')){
    $data['uniacid'] = $_W['uniacid'];
    $data['total'] = $_GPC['total'];
    $data['status'] = $_GPC['type_status'];
    $data['create_time'] = date('Y-m-d H:i:s');
    $res = pdo_insert('byjs_sun_redpacket',$data);
    if($res){
        message('插入成功',$this->createWebUrl('redpacket',array()),'success');
    }else{
        message('插入失败','','error');
    }

}

if($_GPC['id']){
  if($_GPC['op'] == 'delete'){
	$id = $_GPC['id'];
  	$res = pdo_delete('byjs_sun_redpacket',array('id'=>$id,'uniacid'=>$_W['uniacid']));
  if($res){
        message('删除成功',$this->createWebUrl('redpacket',array()),'success');
    }else{
        message('删除失败','',error);
    }
}else{
    if($_GPC['status'] == 2){
        $res = pdo_update('byjs_sun_redpacket',array('status'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    }else{
        $res = pdo_update('byjs_sun_redpacket',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('操作成功',$this->createWebUrl('redpacket',array()),'success');
    }else{
        message('操作失败','',error);
    }
    }
}


include $this->template('web/addredpacket');

