<?php
global $_GPC, $_W;
$action = 'start';
$GLOBALS['frames'] = $this->getNaveMenu($_COOKIE['cityname'], $action);
$info=pdo_get('zhls_sun_goods',array('id'=>$_GPC['id']));

if($info['imgs']){
			if(strpos($info['imgs'],',')){
			$imgs= explode(',',$info['imgs']);
		}else{
			$imgs=array(
				0=>$info['imgs']
				);
		}
		}
if($info['lb_imgs']){
			if(strpos($info['lb_imgs'],',')){
			$lb_imgs= explode(',',$info['lb_imgs']);
		}else{
			$lb_imgs=array(
				0=>$info['lb_imgs']
				);
		}
		}		
if(checksubmit('submit')){
		if($_GPC['imgs']){
			$data['imgs']=implode(",",$_GPC['imgs']);
		}else{
			$data['imgs']='';
		}
		if($_GPC['lb_imgs']){
			$data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
		}else{
			$data['lb_imgs']='';
		}
			$data['goods_name']=$_GPC['goods_name'];
			$data['goods_cost']=$_GPC['goods_cost'];
			$data['freight']=$_GPC['freight'];
			$data['delivery']=$_GPC['delivery'];
			$data['quality']=$_GPC['quality'];
			$data['free']=$_GPC['free'];
			$data['all_day']=$_GPC['all_day'];
			$data['service']=$_GPC['service'];
			$data['refund']=$_GPC['refund'];
			$data['weeks']=$_GPC['weeks'];
				$res = pdo_update('zhls_sun_goods', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl2('dlingoods',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/dlingoodsinfo');