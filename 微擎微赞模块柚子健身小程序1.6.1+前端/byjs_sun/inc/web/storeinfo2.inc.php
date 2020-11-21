<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$info=pdo_get('byjs_sun_store',array('id'=>$_GPC['id']));
//$area=pdo_getall('byjs_sun_area',array('uniacid'=>$_W['uniacid']));
//查出已是商家用户
$sjuser=pdo_getall('byjs_sun_user',array('uniacid'=>$_W['uniacid']));
$info = pdo_get('byjs_sun_store_active',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
//二维数组转一维
//$yuser=array_column($sjuser, 'user_id');
//用户
//$user=pdo_getall('byjs_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));
//行业
//$type=pdo_getall('byjs_sun_storetype',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
//入住类型
//$typein=pdo_getall('byjs_sun_istoren',array('uniacid'=>$_W['uniacid']));

$system=pdo_get('byjs_sun_system',array('uniacid'=>$_W['uniacid']));
$time=24*60*60*7;//一周
$time1=24*30*60*60;//一个月
$time2=24*91*60*60;//三个月
$time3=24*182*60*60;//半年
$time4=24*365*60*60;//一年

if(checksubmit('submit')){
			$data['store_name']=$_GPC['store_name'];
			$data['tel']=$_GPC['tel'];
            $data['user_id']=$_GPC['user_id'];
			$data['address']=$_GPC['address'];
			$data['time_type']=$_GPC['time_type'];
			$data['rz_time'] = time();
			$data['active_type']=$_GPC['active_type'];
			$data['uniacid']=$_W['uniacid'];
			$data['state']=2;
			$data['time_over']=2;
            if($_GPC['time_type']==1){
                $data['dq_time']=time()+$time;
            }
            if($_GPC['time_type']==2){
                $data['dq_time']=time()+$time1;
            }
            if($_GPC['time_type']==3){
                $data['dq_time']=time()+$time2;
            }
            if($_GPC['time_type']==4){
                $data['dq_time']=time()+$time3;
            }
            if($_GPC['time_type']==5){
                $data['dq_time']=time()+$time4;
            }
            if($data['user_id']==111){
                message('请选择所属用户');
            }
            if(!$data['store_name']){
                message('请填写商家名称');
            }
            if(!$data['tel']){
                message('请填写商家电话');
            }
            if(!$data['address']){
                message('请填写商家地址');
            }
			 if($_GPC['id']==''){
				$res = pdo_insert('byjs_sun_store_active', $data);
				if($res){
					message('新增成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('新增失败','','error');
				}
			}else{
				$res = pdo_update('byjs_sun_store_active', $data,array('id'=>$_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/storeinfo2');