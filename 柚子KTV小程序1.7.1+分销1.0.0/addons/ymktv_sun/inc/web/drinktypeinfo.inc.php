<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('ymktv_sun_drinktype',array('uniacid' => $_W['uniacid'],'dtid'=>$_GPC['dtid']));
		if(checksubmit('submit')){
			$data['dt_name']=$_GPC['dt_name'];
            $data['sort']=$_GPC['sort'];
			$data['uniacid']=$_W['uniacid'];
			$data['dt_time'] = date('Y-m-d H:i:s',time());
			if($_GPC['dtid']==''){
				$res=pdo_insert('ymktv_sun_drinktype',$data);
				if($res){
					message('添加成功',$this->createWebUrl('drinktype',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('ymktv_sun_drinktype', $data, array('dtid' => $_GPC['dtid']));
				if($res){
					message('编辑成功',$this->createWebUrl('drinktype',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/drinktypeinfo');