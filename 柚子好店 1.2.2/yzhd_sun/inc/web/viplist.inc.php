<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhd_sun_user_vipcard',array('uniacid' => $_W['uniacid']));

$pageindex = max(1, intval($_GPC['page']));

$pagesize=10;
$sql="select *  from " . tablename("yzhd_sun_user_vipcard") . ' WHERE ' . 'uniacid=' . $_W['uniacid'];
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql);
foreach ($list as $k=>$v){
    if($list[$k]['dq_time']<=time()){
        pdo_update('yzhd_sun_user_vipcard',array('status'=>1),array('id'=>$v['id']));
    }
}
$total=pdo_fetchcolumn("select count(*) from " . tablename("yzhd_sun_user_vipcard"));
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res4=pdo_delete("yzhd_sun_user_vipcard",array('id'=>$_GPC['id']));
    if($res4){
        message('删除成功！', $this->createWebUrl('viplist'), 'success');
    }else{
        message('删除失败！','','error');
    }
}


include $this->template('web/viplist');