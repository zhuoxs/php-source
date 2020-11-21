<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//

//
$info=pdo_get('zhls_sun_goods',array('id'=>$_GPC['id']));

//$spec=pdo_getall('zhls_sun_goods_spec',['uniacid'=>$_W['uniacid']]);
//$type=pdo_getall('zhls_sun_type',['uniacid'=>$_W['uniacid']]);
//$hair = pdo_getall('zhls_sun_hairers',['uniacid'=>$_W['uniacid']]);
if($info['imgs']){
    $imgs = $info['imgs'];
}

if(checksubmit('submit')){
//    p($_GPC);die;
            $data['uniacid']=$_GPC['__uniacid'];
			$data['goods_name']=$_GPC['goods_name'];
			$data['goods_cost']=$_GPC['goods_cost'];
			$data['goods_price']=$_GPC['goods_price'];
            $data['goods_volume']=$_GPC['goods_volume'];
            $data['spec_name']=$_GPC['spec_name'];
            $data['spec_value']=$_GPC['spec_value'];
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
            $data['survey']=$_GPC['survey'];
            $data['imgs'] = $_GPC['imgs'];
//            p($data);die;
			if(empty($_GPC['id'])){

                $res = pdo_insert('zhls_sun_goods', $data);
            }else{

                $res = pdo_update('zhls_sun_goods', $data, array('id' => $_GPC['id']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('business',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/businessinfo');