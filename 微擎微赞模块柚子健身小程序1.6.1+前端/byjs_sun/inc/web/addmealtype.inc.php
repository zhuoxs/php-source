<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('byjs_sun_mealtype',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
			$data['num']=$_GPC['num'];
			$data['typename']=$_GPC['typename'];
			$data['img']=$_GPC['img'];
			$data['status']=$_GPC['status'];
			$data['content']=$_GPC['content'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){				
				$res=pdo_insert('byjs_sun_mealtype',$data);
				if($res){
					message('添加成功',$this->createWebUrl('mealtype',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('byjs_sun_mealtype', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
				if($res){
					message('编辑成功',$this->createWebUrl('mealtype',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}

include $this->template('web/addmealtype');