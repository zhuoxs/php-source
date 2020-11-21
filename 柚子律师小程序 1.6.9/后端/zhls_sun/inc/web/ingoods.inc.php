<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$type=isset($_GPC['type'])?$_GPC['type']:'wait';
if($type=='wait'){
  $_GPC['state']=1;
}
$where=" WHERE  a.uniacid=:uniacid  and b.cityname=:cityname";
if(isset($_GPC['keywords'])){
    $op=$_GPC['keywords'];
      $where.=" and a.goods_name LIKE  concat('%', :name,'%') ";  
       $data[':name']=$op;
       $type='all';
}else{
  if($_GPC['state']){
      $where.=" and a.state={$_GPC['state']} ";  
}
}
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and a.time >={$start} and a.time<={$end}";

}
$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;



 $data[':uniacid']=$_W['uniacid'];
 $data[':cityname']= $_COOKIE['cityname'];
  $sql="select a.*,b.store_name from " . tablename("zhls_sun_goods") . " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id" .$where."  order by a.time desc ";
  $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("zhls_sun_goods") . " a"  . " left join " . tablename("zhls_sun_store") . " b on a.store_id=b.id".$where."  order by a.time desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('zhls_sun_goods',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('ingoods'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('zhls_sun_goods',array('state'=>2),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('ingoods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('zhls_sun_goods',array('state'=>3),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('ingoods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/ingoods');