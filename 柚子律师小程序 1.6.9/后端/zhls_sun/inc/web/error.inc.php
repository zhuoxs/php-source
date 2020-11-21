<?php
//门店列表
global $_GPC, $_W;
$action = 'field';
$title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'fieldset_display';
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$where=" where uniacid=:uniacid";
if(!empty($_GPC['keywords'])){
	$where.=" and details LIKE  concat('%', :name,'%') ";
	$data[':name']=$_GPC['keywords'];	
}
if($type!="all"){
	$where.=" and state={$_GPC['status']}";
}

  $sql="SELECT * FROM ".tablename('zhls_sun_yellowerror') .$where." ORDER BY time DESC";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhls_sun_yellowerror') .$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);

if($operation=='delete'){
		$id=$_GPC['id'];
		$result = pdo_delete('zhls_sun_yellowerror', array('id'=>$id));
		if($result){
			message('删除成功',$this->createWebUrl('error',array()),'success');
		}else{
			message('删除失败','','error');
		}
}
if($operation=='reply'){
		$id=$_GPC['id'];
		$result = pdo_update('zhls_sun_yellowerror',array('state'=>2), array('id'=>$id));
		if($result){
			message('回复成功',$this->createWebUrl('error',array()),'success');
		}else{
			message('回复失败','','error');
		}
}



include $this->template('web/error');