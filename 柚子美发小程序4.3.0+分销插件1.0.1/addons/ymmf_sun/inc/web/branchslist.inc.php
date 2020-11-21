<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('ymmf_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$sql = "select * from ".tablename('ymmf_sun_branch')." where uniacid=".$_W['uniacid']." order by id desc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$info=pdo_fetchall($select_sql);

$total = pdo_fetchcolumn("select count(*) from".tablename('ymmf_sun_branch')." where uniacid={$_W['uniacid']} ");
$pager = pagination($total, $pageindex, $pagesize);

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