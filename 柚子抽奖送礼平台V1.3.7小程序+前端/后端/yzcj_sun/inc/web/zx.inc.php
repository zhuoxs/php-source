<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list=pdo_getall('yzcj_sun_zx',array('uniacid'=>$_W['uniacid']),array(),'','time ASC');
$where= " where a.uniacid=". $_W['uniacid'];
$data[':uniacid']=$_W['uniacid'];
// ----------------审核状态--------------
if(!empty($_GPC['status'])&&empty($_GPC['keywords'])){
    $status = $_GPC['status'];
    $where.=" and a.status={$status} ";
}
if(empty($_GPC['status'])&&!empty($_GPC['keywords'])){
	$keywords=$_GPC['keywords'];
	$where.=" and b.name LIKE  concat('%','$keywords','%')";
	$data[':name']=$_GPC['keywords'];  
}
// ----------------审核状态--------------
if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $where.=" and a.status={$status}  and b.name LIKE  concat('%','$keywords','%')";
    $data[':name']=$_GPC['keywords'];  
}

$type=isset($_GPC['type'])?$_GPC['type']:'all';
// if(!empty($_GPC['time'])){
//    $start=strtotime($_GPC['time']['start']);
//    $end=strtotime($_GPC['time']['end']);
//   $where.=" and unix_timestamp(a.time) >={$start} and unix_timestamp(a.time)<={$end} ";

// }
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
// $sql="select a.*,b.tname  from " . tablename("yzcj_sun_circle") .$where;
$sql="select a.*,b.name  from " . tablename("yzcj_sun_circle") . " a"  . " left join " . tablename("yzcj_sun_user") . " b on a.uid=b.id " .$where." order by a.status asc ,a.time DESC";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql,$data);

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzcj_sun_circle") . " a"  . " left join " . tablename("yzcj_sun_user") . " b on a.uid=b.id " .$where,$data);
$pager = pagination($total, $pageindex, $pagesize);
//	$total=pdo_fetchcolumn("select count(*) from " . tablename("yzcj_sun_zx") . " a"  . " left join " . tablename("yzcj_sun_zx_type") . " b on a.type_id=b.id" . " left join " . tablename("yzcj_sun_user") . " c on a.user_id=c.id".$where,$data);
//	$pager = pagination($total, $pageindex, $pagesize);
		//$list=pdo_fetchall($sql,$data);
if($_GPC['op']=='delete'){
	$res=pdo_delete('yzcj_sun_circle',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	if($res){
	 	message('删除成功！', $this->createWebUrl('zx'), 'success');
	}else{
		message('删除失败！','','error');
	}
}
if($_GPC['op']=='tg'){
    // p($_GPC['gid']);die;
    $res=pdo_update('yzcj_sun_circle',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
          message('通过成功！', $this->createWebUrl('zx'), 'success');
        }else{
          message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzcj_sun_circle',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('zx'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/zx');