<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('ymmf_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info = pdo_getall('ymmf_sun_branch',array('uniacid'=>$_W['uniacid']));
//p($info);die;
global $_W, $_GPC;

if($_GPC['op']=='delete'){
        $res=pdo_delete('ymmf_sun_branch',array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('操作失败','','error');
        }

}
if($_GPC['op']=='change'){
    $res=pdo_update('ymmf_sun_branch',array('stutes'=>$_GPC['stutes']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('branchslist',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/branchslist');