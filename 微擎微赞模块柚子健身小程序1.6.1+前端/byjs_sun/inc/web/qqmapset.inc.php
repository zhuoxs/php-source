<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('byjs_sun_system',array('uniacid'=>$_W['uniacid']));

// print_r($item);die;
if(checksubmit('submit')){

    $data['uniacid']=$_W['uniacid'];
    $data['developkey']=$_GPC['developkey'];
    // $data['openaddress']=intval($_GPC['openaddress']);
	// $data['opencity']=intval($_GPC['opencity']);

    if($_GPC['id']==''){
        $res=pdo_insert('byjs_sun_system',$data);
        if($res){
            message('添加成功',$this->createWebUrl('qqmapset',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('byjs_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('qqmapset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/qqmapset');