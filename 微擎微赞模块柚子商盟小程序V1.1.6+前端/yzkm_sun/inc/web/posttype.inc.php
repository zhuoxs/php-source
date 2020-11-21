<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('yzkm_sun_post',array('uniacid' => $_W['uniacid']),array(),'','tname');
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzkm_sun_post',array('id'=>$_GPC['id']));
    $res1=pdo_delete('yzkm_sun_zx',array('post_id'=>$_GPC['id']));//删除分类下的帖子
    if($res){
        message('删除成功',$this->createWebUrl('posttype',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('yzkm_sun_post',array('type'=>$_GPC['type']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('posttype',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
include $this->template('web/posttype');