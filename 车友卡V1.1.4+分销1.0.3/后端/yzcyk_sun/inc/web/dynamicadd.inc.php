<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzcyk_sun_dynamic',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$goods=pdo_getall('yzcyk_sun_activity',array('uniacid'=>$_W['uniacid'],'state'=>2));
foreach ($goods as &$val){
    $store=pdo_get('yzcyk_sun_store',array('id'=>$val['store_id']));
    $val['title']=$store['store_name'].'-'.$val['title'];
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
if(checksubmit('submit')){

            if($_GPC['imgs']){
                $data['imgs']=implode(",",$_GPC['imgs']);
            }else{
                $data['imgs']='';
            }
            $system=pdo_get('yzcyk_sun_system',array('uniacid'=>$_W['uniacid']));
            $tab=pdo_get('yzcyk_sun_tab',array('uniacid'=>$_W['uniacid']));
            $data['uniacid']=$_W['uniacid'];
			$data['title']=$system['pt_name']; 
            $data['content']=$_GPC['content'];
            $data['add_time']=time();
            $data['gid']=$_GPC['gid'];
            $data['head_img']=$tab['dynamic_headimg'];
			if(empty($_GPC['id'])){
                $res = pdo_insert('yzcyk_sun_dynamic', $data);
            }else{
                $res = pdo_update('yzcyk_sun_dynamic', $data, array('id' => $_GPC['id']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('dynamic',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/dynamicadd');