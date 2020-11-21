<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
// if(!empty($_GPC['id'])){
	$info=pdo_get('byjs_sun_activitys',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
// }



$type=pdo_getall('byjs_sun_activitytype',array('uniacid'=>$_W['uniacid'],'status'=>1));
$user=pdo_getall('byjs_sun_user',array('uniacid'=>$_W['uniacid']));


if(checksubmit('submit')){

			$data['typeid']=$_GPC['typeid'];
  			$data['name']=$_GPC['name']; 
  			$data['starttime']=$_GPC['starttime'];
  			$data['endtime']=$_GPC['endtime'];
  			$data['address']=$_GPC['address'];
  			$data['lng']=$_GPC['lng'];
  			$data['lat']=$_GPC['lat'];
  			
            $data['uniacid']=$_W['uniacid'];
            $data['content']=htmlspecialchars_decode($_GPC['content']);

			$data['top']=$_GPC['top'];
			$data['vir']=$_GPC['vir'];
			$data['virzan']=$_GPC['virzan'];
            $data['virliu']=$_GPC['virliu'];
            $data['application']=$_GPC['application'];
            $data['uid']=$_GPC['uid'];

            // $user2=pdo_get('byjs_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['uid']));
            $data['ininame']=$_GPC['ininame'];
			$data['iniphone']=$_GPC['iniphone'];
            $data['inigender']=$_GPC['inigender'];
            $data['imgs']=$_GPC['imgs'];
            $data['num']=$_GPC['num'];
            $data['is_open']=$_GPC['is_open'];
            $data['type']=1;
            
            
            $data['addtime']= time();
			if(empty($_GPC['id'])){
				$data['status']=1;
        $data['state']=1;
                $res = pdo_insert('byjs_sun_activitys', $data);
            }else{

                $res = pdo_update('byjs_sun_activitys', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('activity',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/activityinfo');