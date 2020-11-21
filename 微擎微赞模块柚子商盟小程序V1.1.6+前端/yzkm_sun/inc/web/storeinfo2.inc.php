<?php
global $_GPC, $_W;
// var_dump($_GPC);
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzkm_sun_store',array('id'=>$_GPC['id']),'','id');
$da_time=pdo_getall('yzkm_sun_duration',array('uniacid'=>$_W['uniacid']));//入驻期限
$fenlei_hy=pdo_getall('yzkm_sun_selectedtype',array('uniacid'=>$_W['uniacid']));//行业分类

//获取腾讯地图key
$developkey=pdo_get('yzkm_sun_system',array('uniacid'=>$_W['uniacid']),array('qqkey'));
$key = $developkey['qqkey'];

// $area=pdo_getall('yzkm_sun_area',array('uniacid'=>$_W['uniacid']));
// p($info);
// var_dump($info);
// var_dump($area);
//查出已是商家用户
$sjuser=pdo_getall('yzkm_sun_store',array('uniacid'=>$_W['uniacid']),'user_id');
// p($sjuser);die;
//二维数组转一维
$yuser=array_column($sjuser , 'user_id');//php版本原因会报错

// p($yuser);die;
// var_dump($yuser);
//用户
$user=pdo_getall('yzkm_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));
// var_dump($user);
//行业
$type=pdo_getall('yzkm_sun_selectedtype',array('uniacid'=>$_W['uniacid'],'type'=>1),array(),'','tname');
// p($type);
//入住类型
//$typein=pdo_getall('yzkm_sun_in',array('uniacid'=>$_W['uniacid']));

// $system=pdo_get('yzkm_sun_system',array('uniacid'=>$_W['uniacid']));

// var_dump($info['banner']);
if($info['banner']){
			if(strpos($info['banner'],',')){
			$banner= explode(',',$info['banner']);
		}else{
			$banner=array(
				0=>$info['banner']
				);
		}
		}
if($info['img']){
			if(strpos($info['img'],',')){
			$img= explode(',',$info['img']);
		}else{
			$img=array(
				0=>$info['img']
				);
		}
		}
	/*	 $coordinates=explode(',',$info['coordinates']);
        $list['coordinates']=array(
                'lat'=>$coordinates['0'],
                'lng'=>$coordinates['1'],
            ); */ 

if(checksubmit('submit')){

		// if(empty($fenlei_hy)){
		// 	message('行业分类不能为空，请先添加行业分类','','error');
		// }
		// if(empty($user)){
		// 	message('微信端管理员不能为空，请先添加微信端管理员','','error');
		// }
		// if(empty($da_time)){
		// 	message('入驻期限不能为空，请先添加入驻期限','','error');
		// }	

		if(empty($_GPC['store_name'] )){
			message('商家名称不能为空，请先添加商家名称','','error');
		}
		if(empty($_GPC['phone'] )){
			message('商家电话不能为空，请先添加商家电话','','error');
		}
		if(empty($_GPC['addr'] )){
			message('商家地址不能为空，请先添加商家地址','','error');
		}
		if(empty($_GPC['averagePrice'] )){
			message('人均价格不能为空，请先添加人均价格','','error');
		}
		if(empty($_GPC['lat'] )){
			message('地址坐标不能为空，请先添加地址坐标','','error');
		}

		if($_GPC['banner']){
			$data['banner']=implode(",",$_GPC['banner']);//首页轮播图添加没问题但是图片数据处理还有问题
		}else{
			$data['banner']='';
		}

		if($_GPC['img']){
			$data['img']=implode(",",$_GPC['img']);//商家图片
		}else{
			$data['img']='';
		}

		if(empty($_GPC['storetype_id'])){
			message('行业分类不能为空','','error');
		}

		if(empty($_GPC['user_id'])){
			message('没有绑定管理员,请绑定后提交','','error');
		}

		if(empty($_GPC['type'])){
			message('没有选择入驻时间,请选择后提交','','error');
		}
		

		// $tianshu=pdo_get('yzkm_sun_duration',array('id'=>$_GPC['type']),array(),'','duration');
		// $rz_time=intval($tianshu['duration']);//入驻期限时间
		// $rz_id=intval($tianshu['id']);//入驻期限id
		// $data['type']=$rz_time;	
		// $data['day_rz']=$rz_id;	
		// $time1=60*60*24*$ttyy;//一周
		// 
		

		$tianshu=pdo_get('yzkm_sun_duration',array('id'=>$_GPC['type']));
		$rz_time=intval($tianshu['duration']);//入驻期限时间
		// $rz_id=intval($tianshu['id']);//入驻期限id
		// $data['type']=$rz_time;	
		// $data['day_rz']=$rz_id;	
		$data['day_rz']=$_GPC['type'];//入驻期限id
		$time1=60*60*24*$rz_time;//一周

		$open_time1=date('Y:m:d',time());
		$over_time1=date("Y-m-d H:i:s",time()+$time1);
			$data['uniacid']=$_W['uniacid'];		
			$data['user_id']=$_GPC['user_id'];//ok
			// $data['type']=$_GPC['type'];//ok
			$data['store_name']=$_GPC['store_name'];//ok
			$data['phone']=$_GPC['phone'];//电话
			$data['addr']=$_GPC['addr'];//地址
			$data['logo']=$_GPC['logo'];//商家LOGO
			$data['coordinate']=$_GPC['lat'].",".$_GPC['lng'];//地理坐标	
			$data['start_time']=$_GPC['start_time'];//营业开始时间
			$data['end_time']=$_GPC['end_time'];//营业结束时间
			$data['views']=$_GPC['views'];//人气数								
			$data['skzf']=$_GPC['skzf'];//ok
			$data['wifi']=$_GPC['wifi'];//ok
			$data['mftc']=$_GPC['mftc'];//ok
			$data['jzxy']=$_GPC['jzxy'];//ok
			$data['tgbj']=$_GPC['tgbj'];//ok
			$data['sfxx']=$_GPC['sfxx'];//ok
			$data['details']=$_GPC['details'];//商家简介
			$data['averagePrice']=$_GPC['averagePrice'];//人均价格	
			$data['open_time']=$open_time1;
			$data['over_time']=$over_time1;
			$data['storetype_id']=$_GPC['storetype_id'];//行业分类	
			// $data['duration']=$_GPC['duration'];//入驻期限
			$data['score']=$_GPC['score'];//星级个数		

			 if($_GPC['id']==''){	
				$res = pdo_insert('yzkm_sun_store', $data);
				if($res){
					message('添加成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('yzkm_sun_store', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/storeinfo2');