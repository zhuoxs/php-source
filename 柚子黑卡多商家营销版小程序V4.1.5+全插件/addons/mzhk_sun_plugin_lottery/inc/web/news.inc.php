<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$sql="select * from".tablename('mzhk_sun_plugin_lottery_addnews')." where uniacid={$_W['uniacid']} ";

//$total=pdo_fetchcolumn("select count(*) from".tablename('mzhk_sun_plugin_lottery_adddnews')." where uniacid={$_W['uniacid']} ");
//die;
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($sql);

$pager = pagination($total, $pageindex, $pagesize);
//$list=pdo_getall('mzhk_sun_plugin_lottery_news',array('uniacid'=>$_W['uniacid']),array(),'','num ASC');
if($_GPC['op']=='delete'){
	$res=pdo_delete('mzhk_sun_plugin_lottery_addnews',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('news'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['state']){
	if($_GPC['state']==1){
        $res=pdo_update('mzhk_sun_plugin_lottery_addnews','state=2',array('uniacid'=>$_W['uniacid']));
    }
	$data['state']=$_GPC['state'];
	$res1=pdo_update('mzhk_sun_plugin_lottery_addnews',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	if($res1){
		message('编辑成功！', $this->createWebUrl('news'), 'success');
	}else{
		message('编辑失败！','','error');
	}
}
include $this->template('web/news');