<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$id = 1;
//$sql1 = ' SELECT * FROM ' . tablename('zhls_sun_gallery') . ' g ' . ' JOIN ' . tablename('zhls_sun_hairers') .' h ' . ' ON ' . ' g.hair_id=h.id'. ' WHERE ' . ' h.id='.$id;
//$hairData = pdo_fetch($sql1);
//p($hairData);die;


//
$info=pdo_get('zhls_sun_goods',array('id'=>$_GPC['id']));

$spec=pdo_getall('zhls_sun_goods_spec',['uniacid'=>$_W['uniacid']]);
$type=pdo_getall('zhls_sun_type',['uniacid'=>$_W['uniacid']]);
$hair = pdo_getall('zhls_sun_hairers',['uniacid'=>$_W['uniacid']]);
if($info['imgs']){
    $imgs = $info['imgs'];
}
if($info['zs_imgs']){
			if(strpos($info['zs_imgs'],',')){
			$zs_imgs= explode(',',$info['zs_imgs']);
		}else{
			$zs_imgs=array(
				0=>$info['zs_imgs']
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
//    p($_GPC);die;
		if($_GPC['zs_imgs']){
			$data['zs_imgs']=implode(",",$_GPC['zs_imgs']);
		}else{
			$data['zs_imgs']='';
		}
		if($_GPC['lb_imgs']){
			$data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
		}else{
			$data['lb_imgs']='';
		}
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
					message('编辑成功',$this->createWebUrl('goods',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/goodsinfo');