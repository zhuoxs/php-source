<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$hair_id=$_GPC['hair_id'];
$id = $_GPC['id'];
$service = pdo_get('ymmf_sun_service',['id'=>$id,'uniacid'=>$_W['uniacid']]);
$services = pdo_getall('ymmf_sun_service',['uniacid'=>$_W['uniacid']]);
$info = pdo_getall('ymmf_sun_goods',['uniacid'=>$_W['uniacid']]);
$type = pdo_get('ymmf_sun_hairers',['uniacid'=>$_W['uniacid'],'id'=>$hair_id]);

$name = pdo_getcolumn('ymmf_sun_goods',['id'=>$_GPC['option'],'uniacid'=>$_W['uniacid']],'goods_name');
$hair_name = pdo_getcolumn('ymmf_sun_hairers',array('id'=>$hair_id,'uniacid'=>$_W['uniacid']),'hair_name');
$price = pdo_getcolumn('ymmf_sun_goods',['id'=>$_GPC['option'],'uniacid'=>$_W['uniacid']],'goods_price');
if(checksubmit('submit')){
	$data['option']=$name;
	$data['goods_id']=$_GPC['option'];
	$data['hair_id']=$_GPC['hair_id'];
	$data['hair_name'] = $hair_name;
	$data['price'] = $price;
	$data['state'] = 1 ;
	$data['uniacid']=$_W['uniacid'];
	
	$result=0;
	foreach($services as $k=>$v){
		if($v['hair_id']==$data['hair_id'] && $v['goods_id']==$data['goods_id']){
			$result=1;
		}
	}

	//echo '<pre>';
	//var_dump($result);die;

	if($result==1){
		message('添加失败,服务已存在','','error');
	}else{
		if($id=='' && $data['goods_id']!=0){
			$res=pdo_insert('ymmf_sun_service',$data);
			if($res){
				message('添加成功',$this->createWebUrl('service',array('hair_id'=>$hair_id)),'success');
			}else{
				message('添加失败','','error');
			}
		}elseif($data['goods_id']==0){
			message('添加失败,请选择项目名称','','error');
		}else{
			$res = pdo_update('ymmf_sun_service', $data, array('id' => $_GPC['id']));
			if($res){
				message('编辑成功',$this->createWebUrl('service',array('hair_id'=>$hair_id)),'success');
			}else{
				message('编辑失败','','error');
			}
		}
	}

	
}
include $this->template('web/addservice');