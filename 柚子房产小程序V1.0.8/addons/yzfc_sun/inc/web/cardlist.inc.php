<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/1
 * Time: 15:10
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'] ." and status =1";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and title LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_card") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzfc_sun_card')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
foreach ($info as $key =>$value){
    $info[$key]['start_time']=date('Y-m-d H:i:s',$value['start_time']);
    $info[$key]['end_time']=date('Y-m-d H:i:s',$value['end_time']);
}
//var_dump($info);exit;
if($_GPC['op']=='delete'){
    $res=pdo_update('yzfc_sun_card',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('cardlist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='deletearr'){
    $res=pdo_update('yzfc_sun_card',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('cardlist',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

include $this->template('web/cardlist');