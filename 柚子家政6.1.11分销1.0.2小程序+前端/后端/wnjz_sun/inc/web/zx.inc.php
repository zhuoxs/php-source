<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list=pdo_getall('wnjz_sun_zx',array('uniacid'=>$_W['uniacid']),array(),'','time ASC');
$uniacid=$_W['uniacid'];
$where="  WHERE a.uniacid=$uniacid and a.detele=1 ";

if(!empty($_GPC['keywords'])){
    $where.=" and a.title LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['keywords'];   
}
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and unix_timestamp(a.time) >={$start} and unix_timestamp(a.time)<={$end} ";

}
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select a.*,b.tname  from " . tablename("wnjz_sun_selected") . " a"  . " left join " . tablename("wnjz_sun_selectedtype") . " b on a.ac_id=b.tid" .$where;
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,$data);

//	$total=pdo_fetchcolumn("select count(*) from " . tablename("wnjz_sun_zx") . " a"  . " left join " . tablename("wnjz_sun_zx_type") . " b on a.type_id=b.id" . " left join " . tablename("wnjz_sun_user") . " c on a.user_id=c.id".$where,$data);
//	$pager = pagination($total, $pageindex, $pagesize);
		//$list=pdo_fetchall($sql,$data);
if($_GPC['op']=='delete'){
	$res=pdo_delete('wnjz_sun_selected',array('seid'=>$_GPC['seid']));
	if($res){
		 message('删除成功！', $this->createWebUrl('zx'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['state']){
	$data['state']=$_GPC['state'];
	$res=pdo_update('wnjz_sun_zx',$data,array('seid'=>$_GPC['seid']));
	if($res){
		 message('编辑成功！', $this->createWebUrl('zx'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/zx');