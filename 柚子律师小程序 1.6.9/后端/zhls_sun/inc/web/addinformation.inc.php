<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('zhls_sun_information',array('id'=>$_GPC['id']));
$type=pdo_getall('zhls_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
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
			$data['user_id']='100000001';
			$data['user_name']=$_GPC['user_name'];
			$data['views']=$_GPC['views'];
			$data['user_tel']=$_GPC['user_tel'];
			$data['details']=$_GPC['details'];
			$data['type_id']=$_GPC['type_id'];
			$data['type2_id']=$_GPC['type2_id'];
			$data['user_img2']=$_GPC['user_img2'];
			//$data['hot']=$_GPC['hot'];
			$data['top']=$_GPC['top'];
			$data['address']=$_GPC['address'];
			$data['uniacid']=$_W['uniacid'];
			$data['state']=2;
			$data['cityname']=$system['cityname'];
			$data['time']=time();
			$data['sh_time']=time();

				$res = pdo_insert('zhls_sun_information', $data);
				if($res){
					message('新增成功',$this->createWebUrl('information',array()),'success');
				}else{
					message('新增失败','','error');
				}
		}
include $this->template('web/addinformation');