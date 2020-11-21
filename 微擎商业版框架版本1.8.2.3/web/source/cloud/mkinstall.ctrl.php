<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC授权
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('cloud');
load()->func('up');
load()->func('db');
$_W['page']['title'] = '公众号应用 - 安装 - 升级';
$dos = array(
    'mkinstall'
);
$do = in_array($do, $dos) ? $do : 'mkinstall';
if ($do == 'mkinstall') {
    global $_W,$_GPC;  
	$hosturl = trim($_SERVER['HTTP_HOST']);
	$updatehost = UPDATEHOST;
	$auth_url = AUTH_URL;
    $updatedir = IA_ROOT.'/data/update';
	$dbname = $_W['config']['db']['master'] ['database'];
	$result = array();

	$return = SendCurl($updatehost.'?a=modules&u='.$hosturl,$result);
	$modules = $return ? $return['module'] : $result;
	$modulelist = $return ? $return['M'] : $result;
	
	$locmlist = array_flip(array_map('current', uni_modules()));

    if(!empty($modulelist)){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 30;
	$params = array();
	if (!empty($modulelist)) {
		foreach($modulelist as  $key => $val){
          if(in_array($val,$locmlist)){
            foreach($modules as  $keys => $value){
              if($value['name'] == $val){
                $modules[$keys]['found'] = 1;
              }
          	}
          }else{
          	foreach($modules as  $keys => $value){
              if($value['name'] == $val){
                $modules[$keys]['found'] = 0;
              }
          	}
          }
    	}
	}

	$result = array_slice($modules, ($pindex-1)*$psize, $psize);
	$total = count($modules);
	$pager = pagination($total, $pindex, $psize);
	}
}

template('cloud/mkinstall');

function module_ver($name) {
  $return = module_fetch($name);
  $ret = $return['version'];
  return $ret;
}
