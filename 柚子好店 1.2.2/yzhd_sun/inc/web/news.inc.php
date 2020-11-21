<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select * from".tablename('yzhd_sun_addnews')." where uniacid={$_W['uniacid']} ";

//$total=pdo_fetchcolumn("select count(*) from".tablename('yzhd_sun_adddnews')." where uniacid={$_W['uniacid']} ");
//die;
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($sql);

$pager = pagination($total, $pageindex, $pagesize);
//$list=pdo_getall('yzhd_sun_news',array('uniacid'=>$_W['uniacid']),array(),'','num ASC');
if($_GPC['op']=='delete'){
	$res=pdo_delete('yzhd_sun_addnews',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('news'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['state']){
	$data['state']=$_GPC['state'];
	$res=pdo_update('yzhd_sun_addnews',$data,array('id'=>$_GPC['id']));
	if($res){
		 message('编辑成功！', $this->createWebUrl('news'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/news');