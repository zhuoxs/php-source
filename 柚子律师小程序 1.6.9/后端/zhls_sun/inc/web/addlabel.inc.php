<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_get('zhls_sun_label',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
			$data['label_name']=$_GPC['label_name'];
			$data['type2_id']=$_GPC['type2_id'];
			if($_GPC['id']==''){
				$res=pdo_insert('zhls_sun_label',$data);
				if($res){
					message('添加成功',$this->createWebUrl('fenlei',array('type2_id'=>$_GPC['type2_id'])),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_label', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('fenlei',array('type2_id'=>$_GPC['type2_id'])),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addlabel');