<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/18
 * Time: 10:27
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

if($_GPC['check']=='use'){
    $where="uid =".$_GPC['uid']." and type =".$_GPC['type'].' and isuse =1';
}elseif($_GPC['check']=='nouse'){
    $where="uid =".$_GPC['uid']." and type =".$_GPC['type'].' and isuse =0';
}else{
    $where="uid =".$_GPC['uid']." and type =".$_GPC['type'];
}
//var_dump($where);exit;
//var_dump($_GPC['type']);exit;
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzzc_sun_coupon_get where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$list = pdo_fetchall($sql);
foreach ($list as $key =>$value){
    $cou=pdo_get('yzzc_sun_coupon',array('id'=>$value['cid']),array('title'));
    $list[$key]['name']=$cou['title'];
    $list[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
    $list[$key]['usetime']=date('Y-m-d H:i:s',$value['usetime']);
}
$total=pdo_fetchcolumn("select count(*) from ims_yzzc_sun_coupon_get where ".$where);
$pager = pagination($total, $page, $size);
$type=$_GPC['type'];
$uid=$_GPC['uid'];
$check=$_GPC['check'];

include $this->template('web/coupondetails');