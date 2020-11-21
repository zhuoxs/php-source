<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//查出已是商家用户
$info = pdo_get('yzhyk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

//获取微信号
$userlist=pdo_get('yzhyk_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$info['openid']),array("name"));
$info["name"] = $userlist["name"];

$category=pdo_getall('yzhyk_sun_store_category',array('uniacid'=>$_W['uniacid'],'state'=>1));
$district=pdo_getall('yzhyk_sun_store_district',array('uniacid'=>$_W['uniacid'],'state'=>1));
if($_GPC['op']=='search'){
    $name=$_GPC['name'];
    $where=" WHERE uniacid=".$_W['uniacid'];
    $sql="select openid,name as uname from " . tablename("yzhyk_sun_user") ." ".$where." and name like'%".$name."%' ";
    $list=pdo_fetchall($sql);
    echo json_encode($list);
    exit();
}
if(checksubmit('submit')){
			$data['store_name']=$_GPC['store_name'];
			$data['tel']=$_GPC['tel'];
			$data['address']=$_GPC['address'];
			$data['uniacid']=$_W['uniacid'];
			$data['add_time']=time();
            $coordinates = trim($_GPC['coordinates']);
            $coordinatesarr = explode(",",$coordinates);
            $data['coordinates'] = trim($coordinates);
            $data['latitude'] = $coordinatesarr[0];//纬度
            $data['longitude'] = $coordinatesarr[1];//精度
            $data['syrq']=$_GPC['syrq'];
            $data['tag']=$_GPC['tag'];
            $data['starttime']=$_GPC['starttime'];
            $data['endtime']=$_GPC['endtime'];
            $data['category_id']=$_GPC['category_id'];
            $data['district_id']=$_GPC['district_id'];
            $data['content']=htmlspecialchars_decode($_GPC['content']);
            $data['pic']=$_GPC['pic'];
            $data['openid']=$_GPC['openid'];
            $data['ptcc_rate']=$_GPC['ptcc_rate'];
            $data['pay_status']=1;
            if($_GPC['rz_end_time']){
                $data['rz_end_time']=strtotime($_GPC['rz_end_time']);
            }
            $data['rz_status']=$_GPC['rz_status'];
			 if($_GPC['id']==''){
				$res = pdo_insert('yzhyk_sun_store', $data);
				if($res){
					message('新增成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('新增失败','','error');
				}
			}else{
			    unset($data['add_time']);
				$res = pdo_update('yzhyk_sun_store', $data,array('id'=>$_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('store',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/storeinfo2');