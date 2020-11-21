<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
      $where.=" and gname LIKE  '%$op%'";
       $data[':name']=$op;
}
if($_GPC['status']){
      $where.=" and status={$_GPC['status']} ";

}
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and ime >={$start} and time<={$end}";

}
$status=$_GPC['status'];

$type=isset($_GPC['type'])?$_GPC['type']:'all';
$data[':uniacid']=$_W['uniacid'];

$sql="SELECT * FROM".tablename('wnjz_sun_goods').$where;
$list= pdo_fetchall($sql);
//

//

foreach ($list as $k=>$v){
    $list[$k]['servies'] = pdo_getcolumn('wnjz_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$v['sid']),'servies_name');
}
if($_GPC['op']=='delete'){

    $res=pdo_delete('wnjz_sun_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));

    if($res){
         message('删除成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('wnjz_sun_goods',array('status'=>2),array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('通过成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('wnjz_sun_goods',array('status'=>3),array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/goods');