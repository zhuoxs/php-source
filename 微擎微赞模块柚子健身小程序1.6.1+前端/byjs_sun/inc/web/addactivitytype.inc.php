<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('byjs_sun_activitytype',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
			$data['num']=$_GPC['num'];
			$data['name']=$_GPC['name'];
			$data['status']=$_GPC['status'];

			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){				
				$res=pdo_insert('byjs_sun_activitytype',$data);
				if($res){
					message('添加成功',$this->createWebUrl('activitytype',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('byjs_sun_activitytype', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
				if($res){
					message('编辑成功',$this->createWebUrl('activitytype',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}

include $this->template('web/addactivitytype');