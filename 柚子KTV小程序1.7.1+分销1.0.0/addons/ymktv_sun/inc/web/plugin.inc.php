<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

global $_W, $_GPC;

//判断分销插件是否安装
if(pdo_tableexists("ymktv_sun_distribution_set")){
	$distribution = 1;
}
	
/*分销跳转*/
if($_GPC['op']=='todistribution'){
	//判断分销插件是否安装
	if(pdo_tableexists("ymktv_sun_distribution_set")){
		$url = url('site/entry/distribution_set', array('m' => 'ymktv_sun_plugin_distribution'));
		$url = substr($url,2);
		$newurl = $_W['siteroot']."web/".$url;
		@header("location:".$newurl."");
	}else{
		message('请先安装ktv分销插件','','error');
	}
}

include $this->template('web/plugin');