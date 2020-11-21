<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('yzcj_sun_in',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));


		if(checksubmit('submit')){
			$data['day']=$_GPC['day'];
			$data['money']=$_GPC['money'];
			$data['uniacid']=$_W['uniacid'];

			if($_GPC['id']==''){
				$res=pdo_insert('yzcj_sun_in',$data);
				if($res){
					message('添加成功',$this->createWebUrl('in'),'success');
				}else{
					message('添加失败','','error');
				}
			}else{

				$res = pdo_update('yzcj_sun_in', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
				if($res){
					message('编辑成功',$this->createWebUrl('in'),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addin');