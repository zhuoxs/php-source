<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('ymktv_sun_type',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
		    if(empty($_GPC['type_name'])){
		        message('请输入分类！');
            }
            $data['sort']=$_GPC['sort'];
			$data['type_name']=$_GPC['type_name'];
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){				
				$res=pdo_insert('ymktv_sun_type',$data);
				if($res){
					message('添加成功',$this->createWebUrl('type',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('ymktv_sun_type', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('type',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addtype');