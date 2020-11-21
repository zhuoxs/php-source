<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$type=isset($_GPC['type'])?$_GPC['type']:'wait';
$where="WHERE  uniacid=:uniacid  and cityname=:cityname";
if(isset($_GPC['keywords'])){
    $op=$_GPC['keywords'];
      $where.=" and (start_place LIKE  concat('%', :name,'%') or end_place LIKE  concat('%', :name,'%'))";  
       $data[':name']=$op;
       $type='all';
}
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and time >={$start} and time<={$end}";

}
$state=isset($_GPC['state'])?$_GPC['state']:1;
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

 $data[':uniacid']=$_W['uniacid'];
 $data[':cityname']=$_COOKIE["cityname"];
if($type=='all'){   
  $sql="select * from" . tablename("zhls_sun_car") .$where."  order by top,time desc ";
  $total=pdo_fetchcolumn("select count(*)  from " . tablename("zhls_sun_car") .$where,$data);
}else{
    $where.= " and state=$state";
   $sql="select * from" . tablename("zhls_sun_car") .$where."  order by top,time desc ";
     $total=pdo_fetchcolumn("select count(*)  from " . tablename("zhls_sun_car") .$where,$data);
}
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('zhls_sun_car',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('incarinfo'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('zhls_sun_car',array('state'=>2,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('incarinfo'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('zhls_sun_car',array('state'=>3,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('incarinfo'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/incarinfo');