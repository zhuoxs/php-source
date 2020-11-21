<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['type'])?$_GPC['type']:'all';

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

//$store = pdo_getall('ymmf_sun_adminstore',array('uniacid'=>$_W['uniacid']));

$sql = "select * from ".tablename('ymmf_sun_adminstore')." where uniacid=".$_W['uniacid']." order by id desc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$store=pdo_fetchall($select_sql);

$total=pdo_fetchcolumn("select count(*) from".tablename('ymmf_sun_adminstore')." where uniacid={$_W['uniacid']} ");
$pager = pagination($total, $pageindex, $pagesize);

foreach ($store as $k=>$v){
    $store[$k]['b_name'] = pdo_getcolumn('ymmf_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'name');
}
if($_GPC['op']=='delete'){
	$res=pdo_delete('ymmf_sun_adminstore',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('adminstore'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['state']){
	$data['state']=$_GPC['state'];
	$res=pdo_update('ymmf_sun_adminstore',$data,array('id'=>$_GPC['id']));
	if($res){
		 message('编辑成功！', $this->createWebUrl('adminstore'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/adminstore');