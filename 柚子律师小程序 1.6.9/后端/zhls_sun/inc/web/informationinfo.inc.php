<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhls_sun_information',array('id'=>$_GPC['id']));
//$type=pdo_get('zhls_sun_type',array('id'=>$info['type_id']));
$type=pdo_getall('zhls_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
$type2=pdo_get('zhls_sun_type2',array('id'=>$info['type2_id']));
$system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
if($info['img']){
			if(strpos($info['img'],',')){
			$img= explode(',',$info['img']);
		}else{
			$img=array(
				0=>$info['img']
				);
		}
		}
if(checksubmit('submit')){
		if($_GPC['img']){
			$data['img']=implode(",",$_GPC['img']);
		}else{
			$data['img']='';
		}
			$data['user_name']=$_GPC['user_name'];
			$data['views']=$_GPC['views'];
			$data['user_tel']=$_GPC['user_tel'];
			$data['details']=$_GPC['details'];
			$data['hot']=$_GPC['hot'];
			$data['top']=$_GPC['top'];
			$data['address']=$_GPC['address'];
			$data['cityname']=$system['cityname'];
			$data['type_id']=$_GPC['type_id'];
			$data['type2_id']=$_GPC['type2_id'];
			if($_GPC['cityname']){
				$data['cityname']=$_GPC['cityname'];
			}
				$res = pdo_update('zhls_sun_information', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('information',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/informationinfo');