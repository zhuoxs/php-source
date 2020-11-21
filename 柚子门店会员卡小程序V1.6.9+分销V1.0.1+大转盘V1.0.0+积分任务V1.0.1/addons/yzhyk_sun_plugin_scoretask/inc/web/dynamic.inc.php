<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$where=" WHERE  uniacid=:uniacid ";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
      $where.=" and title LIKE  concat('%', :title,'%') ";
       $data[':title']=$op;
}
if($type=='wait'){
    $where.=" and is_status=0";
}else if($type=='ok'){
    $where.=" and is_status=1";
}else if($type=='no'){
    $where.=" and is_status=2";
}
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']." 23:59:59");
  $where.=" and add_time >={$start} and add_time<={$end}";
}

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$data[':uniacid']=$_W['uniacid'];
$sql="select * from ".tablename("yzhyk_sun_dynamic").$where." order by id desc";
$total=pdo_fetchcolumn("select count(*) from ".tablename("yzhyk_sun_dynamic").$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
foreach($list as &$val){
    $goods=pdo_get('yzhyk_sun_goods',array('id'=>$val['gid']));
    if(!empty($goods)){
        $val['goods_name']=$goods['goods_name'];
    }
}
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhyk_sun_dynamic',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('dynamic'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhyk_sun_dynamic',array('state'=>2),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhyk_sun_dynamic',array('state'=>3),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/dynamic');