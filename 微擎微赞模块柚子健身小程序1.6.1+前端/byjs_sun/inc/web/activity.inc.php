<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  a.uniacid=:uniacid ";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
      $where.=" and a.name LIKE  concat('%', :name,'%') ";  
       $data[':name']=$op;
}
if(!empty($_GPC['status'])&&empty($_GPC['state'])&&empty($_GPC['type1'])&&empty($_GPC['typeid'])){

      $where.=" and a.status={$_GPC['status']} ";  
}
if(empty($_GPC['status'])&&!empty($_GPC['state'])&&empty($_GPC['type1'])&&empty($_GPC['typeid'])){

      $where.=" and a.state={$_GPC['state']} ";  
}
if(empty($_GPC['status'])&&empty($_GPC['state'])&&!empty($_GPC['type1'])&&empty($_GPC['typeid'])){

      $where.=" and a.type={$_GPC['type1']} ";  
}
if(empty($_GPC['status'])&&empty($_GPC['state'])&&empty($_GPC['type1'])&&!empty($_GPC['typeid'])){

      $where.=" and a.typeid={$_GPC['typeid']} ";  
}
if(empty($_GPC['status'])&&empty($_GPC['state'])&&!empty($_GPC['type1'])&&!empty($_GPC['typeid'])){

      $where.=" and a.typeid={$_GPC['typeid']} and a.type={$_GPC['type1']}";  
}
if(empty($_GPC['status'])&&!empty($_GPC['state'])&&empty($_GPC['type1'])&&!empty($_GPC['typeid'])){

      $where.=" and a.typeid={$_GPC['typeid']} and a.state={$_GPC['state']}";  
}
if(!empty($_GPC['status'])&&empty($_GPC['state'])&&empty($_GPC['type1'])&&!empty($_GPC['typeid'])){

      $where.=" and a.typeid={$_GPC['typeid']} and a.status={$_GPC['status']}";  
}
if(!empty($_GPC['status'])&&!empty($_GPC['state'])&&empty($_GPC['type1'])&&empty($_GPC['typeid'])){

      $where.=" and a.state={$_GPC['state']} and a.status={$_GPC['status']} ";  
}
if(empty($_GPC['status'])&&!empty($_GPC['state'])&&!empty($_GPC['type1'])&&empty($_GPC['typeid'])){

      $where.=" and a.state={$_GPC['state']}  and a.type={$_GPC['type1']}";  
}
if(!empty($_GPC['status'])&&empty($_GPC['state'])&&!empty($_GPC['type1'])&&empty($_GPC['typeid'])){

      $where.=" and a.status={$_GPC['status']}  and a.type={$_GPC['type1']}";  
}
if(!empty($_GPC['status'])&&!empty($_GPC['state'])&&!empty($_GPC['type1'])&&empty($_GPC['typeid'])){

      $where.=" and a.state={$_GPC['state']} and a.status={$_GPC['status']}  and a.type={$_GPC['type1']} ";  
}
if(!empty($_GPC['status'])&&!empty($_GPC['state'])&&empty($_GPC['type1'])&&!empty($_GPC['typeid'])){

      $where.=" and a.typeid={$_GPC['typeid']} and a.status={$_GPC['status']} and a.state={$_GPC['state']}";  
}
if(!empty($_GPC['status'])&&empty($_GPC['state'])&&!empty($_GPC['type1'])&&!empty($_GPC['typeid'])){

      $where.=" and a.typeid={$_GPC['typeid']} and a.status={$_GPC['status']} and a.type={$_GPC['type1']}";  
}
if(empty($_GPC['status'])&&!empty($_GPC['state'])&&!empty($_GPC['type1'])&&!empty($_GPC['typeid'])){

      $where.=" and a.typeid={$_GPC['typeid']} and a.state={$_GPC['state']} and a.type={$_GPC['type1']}";  
}
if(!empty($_GPC['status'])&&!empty($_GPC['state'])&&!empty($_GPC['type1'])&&!empty($_GPC['typeid'])){

      $where.=" and a.typeid={$_GPC['typeid']} and a.state={$_GPC['state']} and a.type={$_GPC['type1']} and a.status={$_GPC['status']}";  
}

$activitytype=pdo_getall('byjs_sun_activitytype',array('uniacid'=>$_W['uniacid'],'status'=>1));


$status=$_GPC['status'];
$state=$_GPC['state'];
$type1=$_GPC['type1'];
$typeid=$_GPC['typeid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$tuijian=$_GPC['tuijian'];
$xuanchuan=$_GPC['xuanchuan'];
$activitytype1=$_GPC['activitytype1'];
$data[':uniacid']=$_W['uniacid'];
$sql="select a.*,b.name as typename from " . tablename("byjs_sun_activitys") . " a"  . " left join " . tablename("byjs_sun_activitytype") . " b on a.typeid=b.id" .$where."  order by a.num asc,a.status desc ";
$total=pdo_fetchcolumn("select count(*) from " . tablename("byjs_sun_activitys") . " a"  . " left join " . tablename("byjs_sun_activitytype") . " b on a.typeid=b.id".$where."  order by a.num asc,a.status desc",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_activitys',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('删除成功！', $this->createWebUrl('activity'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('byjs_sun_activitys',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('通过成功！', $this->createWebUrl('activity'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('byjs_sun_activitys',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('activity'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
if($_GPC['op']=='tj'){
    $res=pdo_update('byjs_sun_activitys',array('state'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('操作成功！', $this->createWebUrl('activity'), 'success');
        }else{
              message('操作失败！','','error');
        }
}
if($_GPC['op']=='qx'){
    $res=pdo_update('byjs_sun_activitys',array('state'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('操作成功！', $this->createWebUrl('activity'), 'success');
        }else{
         message('操作失败！','','error');
        }
}

if($_GPC['op']=='cancle'){
    $res = pdo_delete('byjs_sun_activitydiscount',array('activity_id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('取消成功！', $this->createWebUrl('activity'), 'success');
    }else{
        message('取消失败！','','error');
    }
}
include $this->template('web/activity');