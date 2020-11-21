<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  1=1";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
      $where.=" and a.name LIKE  '%$op%'";
       $data[':name']=$op;
}
$where .= " and a.uniacid = {$_W['uniacid']} and a.del=0";
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and time >={$start} and time<={$end}";

}
if($_GPC['state']){
    $where.=" and state={$_GPC['state']} ";
}
$type=isset($_GPC['type'])?$_GPC['type']:'all';

$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select a.*,b.name as store_name from " . tablename("yzhd_sun_coupon") . " a"  . " left join " . tablename("yzhd_sun_branch") . " b on a.branch_id=b.id" .$where."  order by a.create_time desc ";
$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("yzhd_sun_coupon") . " a"  . " left join " . tablename("yzhd_sun_branch") . " b on a.branch_id=b.id".$where."  order by a.create_time desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    //软删除
    $res=pdo_update('yzhd_sun_coupon',array('del'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

    if($res){
         message('删除成功！', $this->createWebUrl('coupons'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='mdelete'){
  	foreach ($_GPC['id'] as $key => $id) {
    	$res=pdo_delete('yzhd_sun_coupon',array('id'=>$id, 'uniacid'=>$_W['uniacid']));
    }
    message('删除成功！', $this->createWebUrl('coupons'), 'success');
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhd_sun_coupon',array('state'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('通过成功！', $this->createWebUrl('coupons'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhd_sun_coupon',array('state'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('coupons'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}

include $this->template('web/coupons');
