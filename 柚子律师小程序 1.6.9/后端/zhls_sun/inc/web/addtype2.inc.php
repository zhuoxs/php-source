<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
    $hair_id=$_GPC['hair_id'];
    $id = $_GPC['id'];
	$info = pdo_get('zhls_sun_gallery',array('id'=>$id));
//	p($info);die;
if($info['imgs']){
    $imgs = explode(',',$info['imgs']);
}else{
    $imgs = '';
}
	$type = pdo_getall('zhls_sun_hairers',array('id' => $hair_id));
//	p($type);die;
		if(checksubmit('submit')){
//		    p($_GPC);die;
			$data['galname']=$_GPC['galname'];
			$data['state']=$_GPC['state'];
			$data['hair_id']=$_GPC['hair_id'];
			$data['imgs']=implode(',',$_GPC['imgs']);
			$data['addtime']=time();
			$data['uniacid']=$_W['uniacid'];
			if($_GPC['id']==''){
				$res=pdo_insert('zhls_sun_gallery',$data);

				if($res){
					message('添加成功',$this->createWebUrl('type2',array('hair_id'=>$hair_id)),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_gallery', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('type2',array('hair_id'=>$hair_id)),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addtype2');