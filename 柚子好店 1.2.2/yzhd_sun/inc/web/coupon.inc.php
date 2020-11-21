<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$branch_id = intval($_COOKIE['branch_id']);
$where=" WHERE  uniacid=".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
      $where.=" and goods_name LIKE  '%$op%'";
       $data[':name']=$op;
}
if($_GPC['status']){
      $where.=" and state={$_GPC['status']} ";
}
$where .= " and branch_id = {$branch_id} ";
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and ime >={$start} and time<={$end}";

}
$status=$_GPC['status'];

$data[':uniacid']=$_W['uniacid'];

$sql="SELECT * FROM".tablename('yzhd_sun_goods').$where;
$list= pdo_fetchall($sql);
//

//

if($_GPC['op']=='delete'){

    $res=pdo_delete('yzhd_sun_goods',array('id'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));

    if($res){
         message('删除成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhd_sun_goods',array('state'=>2),array('id'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('通过成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhd_sun_goods',array('state'=>3),array('id'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/goods');
