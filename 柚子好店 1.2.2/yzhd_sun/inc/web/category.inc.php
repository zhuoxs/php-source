<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type= isset($_GPC['type'])?$_GPC['type']:0;
//$branch_id = intval($_COOKIE['branch_id']);

$where['uniacid'] = $_W['uniacid'];

$list = pdo_getall('yzhd_sun_category',$where, '','','c_time DESC');

if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhd_sun_category',array('cid'=>$_GPC['cid']));
    if($res){
         message('删除成功！', $this->createWebUrl('category',array('id'=>$_GPC['id'])), 'success');
    }else{
         message('删除失败！','','error');
    }
}
include $this->template('web/category');
