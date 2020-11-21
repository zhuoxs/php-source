<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('yzkm_sun_duration',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));

		if(checksubmit('submit')){
			$data['money']=$_GPC['money'];
			$data['duration']=$_GPC['duration'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){
				if ($_GPC['money']!='') {
					$res=pdo_insert('yzkm_sun_duration',$data);
					if($res){
						message('添加成功',$this->createWebUrl('in',array()),'success');
					}else{
						message('添加失败','','error');
					}					
				}else{
					message('输入框不能为空',$this->createWebUrl('addin',array()),'error');
				}


			}else{
				$res = pdo_update('yzkm_sun_duration', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('in',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addin');