<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('byjs_sun_storein',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
			$data['name']=$_GPC['name'];
			$data['day']=$_GPC['day'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){
				$res=pdo_insert('byjs_sun_storein',$data);
				if($res){
					message('添加成功',$this->createWebUrl('in',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('byjs_sun_storein', $data, array('id' => $_GPC['id'],'uniacid' => $_W['uniacid']));
				if($res){
					message('编辑成功',$this->createWebUrl('in',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addin');