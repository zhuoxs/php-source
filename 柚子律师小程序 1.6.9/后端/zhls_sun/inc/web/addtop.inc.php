<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('zhls_sun_top',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
			$data['type']=$_GPC['type'];
			$data['money']=$_GPC['money'];
			$data['num']=$_GPC['num'];
			$data['uniacid']=$_W['uniacid'];
			$rst=pdo_get('zhls_sun_top',array('type'=>$_GPC['type'],'uniacid'=>$_W['uniacid'],'id !='=>$_GPC['id']));
			if($rst){
				message('该期限已存在请重新添加','','error');
			}
			if($_GPC['id']==''){				
				$res=pdo_insert('zhls_sun_top',$data);
				if($res){
					message('添加成功',$this->createWebUrl('top',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_top', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('top',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addtop');