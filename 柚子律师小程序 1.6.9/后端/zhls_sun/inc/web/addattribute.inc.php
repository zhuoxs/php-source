<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('zhls_sun_goods_spec',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
		
			$data['sort']=$_GPC['sort'];
			$data['spec_name']=$_GPC['spec_name'];
            $data['spec_value']=$_GPC['spec_value'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){				
				$res=pdo_insert('zhls_sun_goods_spec',$data);
				if($res){
					message('添加成功',$this->createWebUrl('attribute',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_goods_spec', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('attribute',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addattribute');