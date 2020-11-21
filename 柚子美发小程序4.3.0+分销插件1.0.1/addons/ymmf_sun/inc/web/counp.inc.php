<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('ymmf_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
//$info = pdo_getall('ymmf_sun_coupon',array('weid'=>$_W['uniacid']));
//$sql = "select * from ".tablename('ymmf_sun_coupon')." where weid=".$_W['uniacid']." order by id desc";
//$info=pdo_fetchall($sql);

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql = "select * from ".tablename('ymmf_sun_coupon')." where weid=".$_W['uniacid']." order by id desc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$info=pdo_fetchall($select_sql);

$total=pdo_fetchcolumn("select count(*) from".tablename('ymmf_sun_coupon')." where weid={$_W['uniacid']} ");
$pager = pagination($total, $pageindex, $pagesize);


foreach ($info as $k=>$v){
    $info[$k]['b_name'] = pdo_getcolumn('ymmf_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'name');
}
//p($info);die;
global $_W, $_GPC;

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('ymmf_sun_coupon',array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('counp',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('ymmf_sun_coupon',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('counp',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/counp');