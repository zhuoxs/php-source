<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('chbl_sun_fabuset',array('uniacid' => $_W['uniacid']));
		if(checksubmit('submit')){
            if(!$_GPC['price']){
                $data['price']=0;
            }else{
                $data['price']=$_GPC['price'];
            }
			$data['type']=$_GPC['type'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){
				$res=pdo_insert('chbl_sun_fabuset',$data);
				if($res){
					message('添加成功',$this->createWebUrl('fabuset',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('chbl_sun_fabuset', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('fabuset',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/fabuset');