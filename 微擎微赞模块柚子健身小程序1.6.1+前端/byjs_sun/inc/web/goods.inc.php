<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  a.uniacid=:uniacid ";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
      $where.=" and a.goods_name LIKE  concat('%', :name,'%') ";  
       $data[':name']=$op;
}
if($_GPC['state']){
      $where.=" and a.state={$_GPC['state']} ";  

}
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and a.time >={$start} and a.time<={$end}";

}
$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
 $data[':uniacid']=$_W['uniacid'];
  $sql="select a.*,b.store_name from " . tablename("byjs_sun_goods") . " a"  . " left join " . tablename("byjs_sun_store") . " b on a.store_id=b.id" .$where."  order by a.time desc ";
  $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("byjs_sun_goods") . " a"  . " left join " . tablename("byjs_sun_store") . " b on a.store_id=b.id".$where."  order by a.time desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageindex, $pagesize);
//抢购显示
$sqls = "SELECT a.goods_id FROM ims_byjs_sun_goodsdiscount as a  INNER JOIN ims_byjs_sun_goods as b ON a.goods_id=b.id"; 
$result = pdo_fetchAll($sqls);
foreach($result as $k=> $v){
	foreach($v as $k1=>$v1){
     
    }
}
if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_goods',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('删除成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('byjs_sun_goods',array('state'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('通过成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('byjs_sun_goods',array('state'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}

if($_GPC['op']=='cancle'){
    $res = pdo_delete('byjs_sun_goodsdiscount',array('goods_id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('取消成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('取消失败！','','error');
    }
}
include $this->template('web/goods');