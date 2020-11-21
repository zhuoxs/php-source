<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'];
$where="uniacid =".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where="uniacid =".$_W['uniacid']." and user_name LIKE  '%$op%'";

}
$type='all';
if($_GPC['type']=='adminlist'){
    $type=$_GPC['type'];
    $where .=' and isadmin = 1';
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzzc_sun_user where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$list = pdo_fetchall($sql);
foreach ($list as $key =>$value){
    $list[$key]['time']=date('Y-m-d H:i:s',$value['time']);
    $list[$key]['coupon']=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_coupon_get')."where uid =".$value['id']." and type = 2 ");
    $list[$key]['rent']=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_coupon_get')."where uid =".$value['id']." and type = 1 ");
}
$total=pdo_fetchcolumn("select count(*) from ims_yzzc_sun_user where ".$where);
$pager = pagination($total, $page, $size);

if($_GPC['op']=='admin'){
    $res=pdo_update('yzzc_sun_user',array('isadmin'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('设置成功',$this->createWebUrl('user',array()),'success');
    }else{
        message('设置失败','','error');
    }
}
if($_GPC['op']=='qxadmin'){
    $res=pdo_update('yzzc_sun_user',array('isadmin'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('user',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
include $this->template('web/user');