<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['type'])?$_GPC['type']:'all';

$store = pdo_getall('wnjz_sun_adminstore',array('uniacid'=>$_W['uniacid']));
foreach ($store as $k=>$v){
    $store[$k]['b_name'] = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'name');
}
if($_GPC['op']=='delete'){
	$res=pdo_delete('wnjz_sun_adminstore',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('adminstore'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['state']){
	$data['state']=$_GPC['state'];
	$res=pdo_update('wnjz_sun_adminstore',$data,array('id'=>$_GPC['id']));
	if($res){
		 message('编辑成功！', $this->createWebUrl('adminstore'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/adminstore');