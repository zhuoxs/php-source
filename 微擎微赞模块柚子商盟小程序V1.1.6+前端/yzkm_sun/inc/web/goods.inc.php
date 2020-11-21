<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  a.uniacid=".$_W['uniacid'];
// $where=" WHERE a.uniacid=:uniacid";
if($_GPC['keywords']){//关键字搜索
    $op=$_GPC['keywords'];
      $where.=" and gname LIKE  '%$op%'";
       $data[':name']=$op;
}

if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and ime >={$start} and time<={$end}";

}
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$status=$_GPC['status'];
if($_GPC['status']){
      $where.=" and  a.status=$status ";
}

// p($where);die;
// $data[':uniacid']=$_W['uniacid'];

// $sql="SELECT * FROM".tablename('yzkm_sun_goods').$where;
$sql = "SELECT * FROM".tablename('yzkm_sun_goods')."a left join ".tablename('yzkm_sun_selectedtype')."b on a.cid=b.tid ".$where." ORDER BY gid DESC";
$list= pdo_fetchall($sql);
// p($sql);
// p($list);die;
if($_GPC['op']=='delete'){

    $res=pdo_delete('yzkm_sun_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));

    if($res){
         message('删除成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzkm_sun_goods',array('status'=>2),array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('通过成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzkm_sun_goods',array('status'=>3),array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/goods');