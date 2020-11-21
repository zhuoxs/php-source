<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('zhls_sun_yellowtype2',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
	$type = pdo_getall('zhls_sun_yellowtype',array('uniacid' => $_W['uniacid']));
		if(checksubmit('submit')){
			$data['num']=$_GPC['num'];
			$data['type_id']=$_GPC['type_id'];
			$data['name']=$_GPC['name'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){				
				$res=pdo_insert('zhls_sun_yellowtype2',$data);
				if($res){
					message('添加成功',$this->createWebUrl('yellowtype2',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_yellowtype2', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('yellowtype2',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addyellowtype2');