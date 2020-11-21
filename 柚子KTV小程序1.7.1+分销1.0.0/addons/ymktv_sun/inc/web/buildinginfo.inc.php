<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//获取腾讯地图key
$developkey=pdo_get('ymktv_sun_system',array('uniacid'=>$_W['uniacid']),array('qqkey'));
$key = $developkey['qqkey'];

	$info = pdo_get('ymktv_sun_building',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
	$info['lng'] = explode(',',$info['longitude'])[0];
    $info['lat'] = explode(',',$info['longitude'])[1];
		if(checksubmit('submit')){
			$data['b_name']=$_GPC['b_name'];
			$data['uniacid']=$_W['uniacid'];
			$data['addtime'] = time();
			$data['address'] = $_GPC['address'];
            $data['b_img'] = $_GPC['b_img'];
            $data['tel'] = $_GPC['tel'];
            $data['build_details'] = htmlspecialchars_decode($_GPC['build_details']);
			$data['longitude'] = $_GPC['lng']. ',' .$_GPC['lat'];
            $data['user']=trim($_GPC['user']);
            $data['key']=trim($_GPC['key']);
            $data['sn'] = $_GPC['sn'];

			if($_GPC['id']==''){
				$res=pdo_insert('ymktv_sun_building',$data);
				if($res){
					message('添加成功',$this->createWebUrl('building',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('ymktv_sun_building', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('building',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/buildinginfo');