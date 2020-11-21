<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE uniacid=:uniacid ";
$data[':uniacid']=$_W['uniacid'];
$where.=" and lid=1 ";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
      $where.=" and title LIKE  concat('%', :title,'%') ";
      $data[':title']=$op;
}
$type=$_GPC['type'];
if($_GPC['state']==1){
    $where.=" and state=0 ";
}else if($_GPC['state']==2){
    $where.=" and state=1 ";
}else if($_GPC['state']==3){
    $where.=" and state=2 ";
}
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="SELECT * FROM ".tablename('yzhyk_sun_plugin_scoretask_goods').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzhyk_sun_plugin_scoretask_goods').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhyk_sun_plugin_scoretask_goods',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhyk_sun_plugin_scoretask_goods',array('state'=>1),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhyk_sun_plugin_scoretask_goods',array('state'=>2),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/goods');