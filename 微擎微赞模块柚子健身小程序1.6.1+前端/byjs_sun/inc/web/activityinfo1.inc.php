<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
// if(!empty($_GPC['id'])){
	$info=pdo_get('byjs_sun_activitys',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
// }



$type=pdo_getall('byjs_sun_activitytype',array('uniacid'=>$_W['uniacid'],'status'=>1));
// $user=pdo_getall('byjs_sun_user',array('uniacid'=>$_W['uniacid']));


if(checksubmit('submit')){

			$data['typeid']=$_GPC['typeid'];
  			$data['name']=$_GPC['name']; 

  			
            $data['uniacid']=$_W['uniacid'];
            $data['content']=htmlspecialchars_decode($_GPC['content']);

			$data['vir']=$_GPC['vir'];
			$data['virzan']=$_GPC['virzan'];
            $data['virliu']=$_GPC['virliu'];

            $data['imgs']=$_GPC['imgs'];
            $data['type']=2;
            $data['num']=$_GPC['num'];
            
            
            
            $data['addtime']= time();

			if(empty($_GPC['id'])){
				$data['status']=1;
                $data['state']=1;
                
                $res = pdo_insert('byjs_sun_activitys', $data);
                // var_dump($res);
            }else{

                $res = pdo_update('byjs_sun_activitys', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            }
            // p($res);
				if($res){
					message('编辑成功',$this->createWebUrl('activity',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/activityinfo1');