<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhls_sun_store',array('id'=>$_GPC['id']));
$area=pdo_getall('zhls_sun_area',array('uniacid'=>$_W['uniacid']));
//查出已是商家用户
$sjuser=pdo_getall('zhls_sun_store',array('uniacid'=>$_W['uniacid']),'user_id');
//二维数组转一维
$yuser=array_column($sjuser, 'user_id');
//用户
$user=pdo_getall('zhls_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));
//行业
$type=pdo_getall('zhls_sun_storetype',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
//入住类型
//$typein=pdo_getall('zhls_sun_in',array('uniacid'=>$_W['uniacid']));

$system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
  $time=24*60*60*7;//一周
   $time2=24*182*60*60;//半年
   $time3=24*365*60*60;//一年

if($info['ad']){
			if(strpos($info['ad'],',')){
			$ad= explode(',',$info['ad']);
		}else{
			$ad=array(
				0=>$info['ad']
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
		if($_GPC['ad']){
			$data['ad']=implode(",",$_GPC['ad']);
		}else{
			$data['ad']='';
		}
		if($_GPC['img']){
			$data['img']=implode(",",$_GPC['img']);
		}else{
			$data['img']='';
		}
//		if(empty($_GPC['user_id'])){
//			message('没有绑定管理员,请绑定后提交','','error');
//		}

		
		//查询钱
		$storetype_id=pdo_get('zhls_sun_storetype',array('id'=>$_GPC['storetype_id']));
		$typemoney=pdo_get('zhls_sun_in',array('id'=>$_GPC['type']));
			$data['store_name']=$_GPC['store_name'];
			$data['tel']=$_GPC['tel'];
			$data['address']=$_GPC['address'];
			$data['logo']=$_GPC['logo'];
			$data['ewm_logo']=$_GPC['ewm_logo'];
			$data['weixin_logo']=$_GPC['weixin_logo'];
			$data['announcement']=$_GPC['announcement'];
			$data['yy_time']=$_GPC['yy_time'];
			$data['keyword']=$_GPC['keyword'];
			$data['skzf']=$_GPC['skzf'];
			$data['wifi']=$_GPC['wifi'];
			$data['mftc']=$_GPC['mftc'];
			$data['jzxy']=$_GPC['jzxy'];
			$data['tgbj']=$_GPC['tgbj'];
			$data['sfxx']=$_GPC['sfxx'];
			//$data['area_id']=$_GPC['area_id'];
			$data['details']=$_GPC['details'];
			$data['num']=$_GPC['num'];
			$data['type']=$_GPC['type'];
			//$data['coordinates']=$_GPC['op']['lat'].','.$_GPC['op']['lng'];
			$data['coordinates']=$_GPC['coordinates'];
			$data['user_id']=$_GPC['user_id'];
			$data['storetype_id']=$_GPC['storetype_id'];
			$data['start_time']=$_GPC['start_time'];
			$data['end_time']=$_GPC['end_time'];
			$data['vr_link']=$_GPC['vr_link'];
			$data['uniacid']=$_W['uniacid'];
			$data['state']=2;
			$data['views']=$_GPC['views'];
			$data['is_top']=$_GPC['is_top'];
			$data['sh_time']=time();
			$data['time_over']=2;	
			if($_GPC['type']==1){
					$data['dq_time']=time()+$time;
				}
				if($_GPC['type']==2){
					$data['dq_time']=time()+$time2;
				}
				if($_GPC['type']==3){
					$data['dq_time']=time()+$time3;
				}

			$data['money']=$storetype_id['money']+$typemoney['money'];
			 if($_GPC['id']==''){		
			$data['cityname']=$system['cityname'];
				$res = pdo_insert('zhls_sun_store', $data);
				if($res){
					message('新增成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('新增失败','','error');
				}
			}else{

				$res = pdo_update('zhls_sun_store', $data,array('id'=>$_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/storeinfo2');