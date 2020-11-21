<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('chbl_sun_goods',array('id'=>$_GPC['id']));

$spec=pdo_getall('chbl_sun_goods_spec');
$type=pdo_getall('chbl_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1));
//查找出所有门店
$store = pdo_getall('chbl_sun_store_active',array('uniacid'=>$_W['uniacid']));
$system = pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']));
if($system['is_goods']==2){
    $data['state']=2;
}else{
    $data['state']=1;
}
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
    if($_GPC['store_id']==0 || !$_GPC['store_id']){
        message('请选择门店名称！');
    }
    if(empty($_GPC['goods_name'])){
        message('请填写商品名称');
    }
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
            $data['is_vip']=$_GPC['is_vip'];
            $data['store_id']=$_GPC['store_id'];
            $data['uniacid']=$_GPC['__uniacid'];
			$data['goods_name']=$_GPC['goods_name'];
			$data['goods_cost']=$_GPC['goods_cost'];
			$data['goods_price']=$_GPC['goods_price'];
            $data['goods_volume']=$_GPC['goods_volume'];
            $data['goods_num']=$_GPC['goods_num'];
            $data['spec_name']=$_GPC['spec_name'];
            $data['spec_value']=$_GPC['spec_value'];
            $data['spec_names']=$_GPC['spec_names'];
            $data['spec_values']=$_GPC['spec_values'];
            $data['type_id']=$_GPC['type_id'];
			$data['freight']=$_GPC['freight'];
			$data['delivery']=$_GPC['delivery'];
			$data['quality']=$_GPC['quality'];
            $data['goods_details']=htmlspecialchars_decode($_GPC['goods_details']);
			$data['free']=$_GPC['free'];
			$data['all_day']=$_GPC['all_day'];
			$data['service']=$_GPC['service'];
			$data['refund']=$_GPC['refund'];
			$data['weeks']=$_GPC['weeks'];
            $data['time']= time();
			if(empty($_GPC['id'])){

                $res = pdo_insert('chbl_sun_goods', $data);
            }else{

                $res = pdo_update('chbl_sun_goods', $data, array('id' => $_GPC['id']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('goods',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/goodsinfo');