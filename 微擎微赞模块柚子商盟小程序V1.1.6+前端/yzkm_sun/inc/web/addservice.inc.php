<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
    $hair_id=$_GPC['hair_id'];
    $id = $_GPC['id'];
    $service = pdo_get('yzkm_sun_service',['id'=>$id]);
	$info = pdo_getall('yzkm_sun_goods');
	$type = pdo_getall('yzkm_sun_hairers');
//	p($type);die;
		if(checksubmit('submit')){
//		    p($_GPC);die;
		    $name = pdo_getcolumn('yzkm_sun_goods',['id'=>$_GPC['option']],'goods_name');
            $hair_name = pdo_getcolumn('yzkm_sun_hairers',['id'=>$hair_id],'hair_name');
            $price = pdo_getcolumn('yzkm_sun_goods',['id'=>$_GPC['option']],'goods_price');
			$data['option']=$name;
			$data['goods_id']=$_GPC['option'];
			$data['hair_id']=$_GPC['hair_id'];
			$data['hair_name'] = $hair_name;
			$data['price'] = $price;
			$data['state'] = 1 ;
			$data['uniacid']=$_W['uniacid'];
			if($id==''){
				$res=pdo_insert('yzkm_sun_service',$data);
				if($res){
					message('添加成功',$this->createWebUrl('service',array('hair_id'=>$hair_id)),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('yzkm_sun_service', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('service',array('hair_id'=>$hair_id)),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addservice');