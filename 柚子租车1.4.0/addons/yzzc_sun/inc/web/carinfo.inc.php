<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzzc_sun_car',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
$nowshop=pdo_get('yzzc_sun_carbrand',array('id'=>$info['carbrand']),array('id','name'));
$cartype=pdo_getall('yzzc_sun_carcity',array('uniacid'=>$_W['uniacid']));
$shop=pdo_getall('yzzc_sun_carbrand',array('uniacid'=>$_W['uniacid']),array('id','name'));
$nowcartype=pdo_get('yzzc_sun_cartype',array('id'=>$info['carcity']),array('id','name'));
if($info['imgs']){
    if(strpos($info['imgs'],',')){
        $lb_imgs= explode(',',$info['imgs']);

    }else{
        $lb_imgs=array(
            0=>$info['imgs']
        );
    }
}
if(checksubmit('submit')){
//	 p($_GPC);die;
	if($_GPC['name']==null){
		message('请您车辆名称', '', 'error');
	}elseif($_GPC['carnum']==null){
        message('请您填写车牌号码','','error');
    }elseif($_GPC['pic']==null){
		message('请您写上传图片','','error');die;
	}
	// elseif($_GPC['sid']==null){
 //        message('请您先添加门店','','error');die;
 //    }

    if($_GPC['imgs']){

        $data['imgs']=implode(",",$_GPC['imgs']);

    }else{
        $data['imgs']='';
    }
    $data['registrationtime'] =strtotime($_GPC['registrationtime']) ;

	$data['uniacid']=$_W['uniacid'];
	// $data['sid']=$_GPC['sid'];
	$data['name']=$_GPC['name'];
	$data['carnum']=$_GPC['carnum'];
	$data['color']=$_GPC['color'];
	$data['mileage']=$_GPC['mileage'];
	$data['cartype'] = $_GPC['cartype'];
	$data['carbrand'] = $_GPC['carbrand'];
	$data['carcity'] = $_GPC['carcity'];
	$data['phone']=$_GPC['phone'];
	$data['grarbox']=$_GPC['grarbox'];
	$data['displacement']=$_GPC['displacement'];
	$data['num'] = $_GPC['num'];
	$data['money'] = $_GPC['money'];
	$data['monthmoney'] = $_GPC['monthmoney'];
	$data['guidemoney'] = $_GPC['guidemoney'];
	
	$data['content'] = html_entity_decode($_GPC['content']);
	$data['rec'] = $_GPC['rec'];
	$data['pic'] = $_GPC['pic'];
	$data['sort'] = $_GPC['sort'];
	$data['createtime'] = date('Y-m-d H:i:s', time());

	if(empty($_GPC['id'])){
	$data['status'] = 2;
		
		$res = pdo_insert('yzzc_sun_car', $data,array('uniacid'=>$_W['uniacid']));

		if($res){
			message('添加成功',$this->createWebUrl('car',array()),'success');
		}else{
			message('添加失败','','error');
		}
	}else{

		$res = pdo_update('yzzc_sun_car', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
	}
	if($res){
		message('修改成功',$this->createWebUrl('car',array()),'success');
	}else{
		message('修改失败','','error');
	}
}
include $this->template('web/carinfo');