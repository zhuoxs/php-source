<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type= isset($_GPC['type'])?$_GPC['type']:0;
$branch_id = isset($_GPC['branch_id']) ? $_GPC['branch_id'] : 0;
setcookie('branch_id', $branch_id, time()+60*60*24*30);
$list = pdo_getall('yzhd_sun_category',array('uniacid'=>$_W['uniacid']),'','','c_time DESC');
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhd_sun_category',array('cid'=>$_GPC['cid']));
    if($res){
         message('删除成功！', $this->createWebUrl('category'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
include $this->template('web/branchmanage');
