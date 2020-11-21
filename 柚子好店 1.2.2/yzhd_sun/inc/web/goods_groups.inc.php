<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
//$where=" WHERE  uniacid=".$_W['uniacid'];
//if($_GPC['keywords']){
//    $op=$_GPC['keywords'];
//      $where.=" and goods_name LIKE  '%$op%'";
//       $data[':name']=$op;
//}
//if($_GPC['status']){
//      $where.=" and state={$_GPC['status']} ";
//}
//$where .= " and branch_id = {$branch_id} ";
//if(!empty($_GPC['time'])){
//   $start=strtotime($_GPC['time']['start']);
//   $end=strtotime($_GPC['time']['end']);
//  $where.=" and time >={$start} and time<={$end}";
//
//}
//$status=$_GPC['status'];

//$data[':uniacid']=$_W['uniacid'];

//$sql="SELECT * FROM".tablename('yzhd_sun_goods_meal').$where;
$where = '1 = 1';
switch ($_GPC['status']) {
  case '1':
    $where .= ' AND state = 1';
    break;
  case '2':
    $where .= ' AND state = 2';
    break;
  case '3':
     $where .= ' AND state = 3';
    break;
}
if ($_GPC['keywords']) {
	$where .= " AND goods_name LIKE '%{$_GPC['keywords']}%'";
}
$branch_id = $_GPC['branch_id'];
$where .= " AND  branch_id = {$branch_id}";
$sql = "SELECT * FROM ims_yzhd_sun_goods_meal WHERE {$where}";
//echo $sql;exit;
$list= pdo_fetchall($sql);

foreach ($list as $k=>$v){
    $list[$k]['store_name'] = pdo_getcolumn('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['branch_id']),'name');
}

if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhd_sun_goods_meal',array('id'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('删除成功！', $this->createWebUrl('goods_groups',array('branch_id'=>$branch_id)), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='mdelete'){
	//die('asdasd');
  	foreach ($_GPC['id'] as $key => $id) {
    	$res=pdo_delete('yzhd_sun_goods_meal',array('id'=>$id, 'uniacid'=>$_W['uniacid']));
    }
    message('删除成功！', $this->createWebUrl('goods_groups',array('branch_id'=>$branch_id)), 'success');
}
if($_GPC['op']=='mok'){
	//die('asdasd');
  	foreach ($_GPC['id'] as $key => $id) {
    	$res=pdo_update('yzhd_sun_goods_meal',array('state' => 2), array('id'=>$id, 'uniacid'=>$_W['uniacid']));
    }
    message('通过成功！', $this->createWebUrl('goods_groups',array('branch_id'=>$branch_id)), 'success');
}
if($_GPC['op']=='mrefuse'){
	//die('asdasd');
  	foreach ($_GPC['id'] as $key => $id) {
    	$res=pdo_update('yzhd_sun_goods_meal',array('state' => 3), array('id'=>$id, 'uniacid'=>$_W['uniacid']));
    }
    message('拒绝成功！', $this->createWebUrl('goods_groups',array('branch_id'=>$branch_id)), 'success');
}

if($_GPC['op']=='tg'){
    $res=pdo_update('yzhd_sun_goods_meal',array('state'=>2),array('id'=>$_GPC['gid']));
    if($res){
         message('通过成功！', $this->createWebUrl('goods_groups',array('branch_id'=>$branch_id)), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhd_sun_goods_meal',array('state'=>3),array('id'=>$_GPC['gid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods_groups',array('branch_id'=>$branch_id)), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}

include $this->template('web/goods_groups');
