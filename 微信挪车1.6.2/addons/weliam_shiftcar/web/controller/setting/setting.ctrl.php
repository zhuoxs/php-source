<?php 
defined('IN_IA') or exit('Access Denied');
$ops = array('base','templat','share','notice','api','veri','hide');
$op = in_array($op, $ops) ? $op : 'base';
load()->func('tpl');
wl_load()->model('setting');

if ($op == 'base') {
	$settings = wlsetting_read('base');
	if (checksubmit('submit')) {
		$base = array(
			'name'=>$_GPC['name'],
			'logo'=>$_GPC['logo'],
			'copyright'=>$_GPC['copyright'],
			'indexbg'=>$_GPC['indexbg'],
			's_url'=>$_GPC['s_url'],
			'abbre'=>$_GPC['abbre']
		);
		wlsetting_save($base, 'base');
		message('更新设置成功！', web_url('setting/setting/base'));
	}
	include wl_template('setting/base');
}

if ($op == 'templat') {
	$settings = wlsetting_read('templat');
	$styles = array();
	$dir = WL_APP . "view/";
	if ($handle = opendir($dir)) {
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") {
				if (is_dir($dir . "/" . $file)) {
					$styles[] = $file;
				} 
			} 
		} 
		closedir($handle);
	}
	if (checksubmit('submit')) {
		$base = array(
			'appview'=>$_GPC['appview']
		);
		wlsetting_save($base, 'templat');
		message('更新设置成功！', web_url('setting/setting/templat'));
	}
	include wl_template('setting/templat');
}

if ($op == 'share') {
	$settings = wlsetting_read('share');
	if (checksubmit('submit')) {
		$base = array(
			'share_title'=>$_GPC['share_title'],
			'share_image'=>$_GPC['share_image'],
			'share_desc'=>$_GPC['share_desc']
		);
		wlsetting_save($base, 'share');
		message('更新设置成功！', web_url('setting/setting/share'));
	}
	include wl_template('setting/share');
}

if ($op == 'notice') {
	$settings = wlsetting_read('notice');
	if (checksubmit('submit')) {
		$base = array(
			'noticetimes'=>intval($_GPC['noticetimes']),
			'noticetype'=>intval($_GPC['noticetype']),
			'callstatus'=>intval($_GPC['callstatus']),
			'intervaltime'=>intval($_GPC['intervaltime']),
			'locationstatus'=>intval($_GPC['locationstatus']),
			'cnoticestatus'=>intval($_GPC['cnoticestatus']),
			'sendmsg'=>$_GPC['sendmsg'],
			'm_movecar'=>$_GPC['m_movecar'],
			'm_schedule'=>$_GPC['m_schedule'],
			'hidetpl'=>$_GPC['hidetpl'],
			'delivery'=>$_GPC['delivery']
		);
		wlsetting_save($base, 'notice');
		message('更新设置成功！', web_url('setting/setting/notice'));
	}
	include wl_template('setting/notice');
}

if ($op == 'api') {
	$settings = wlsetting_read('api');
	if (checksubmit('submit')) {
		$base = array(
			'jtatus'=>intval($_GPC['jtatus']),
			'ytatus'=>intval($_GPC['ytatus']),
			'btatus'=>intval($_GPC['btatus']),
			'dx_appid' => $_GPC['dx_appid'],
            'dx_secretkey' => $_GPC['dx_secretkey'],
            'dy_sf' => $_GPC['dy_sf'],
            'dy_dx' => $_GPC['dy_dx'],
            'dy_yy' => $_GPC['dy_yy'],
            'dy_yynum' => $_GPC['dy_yynum'],
            'dy_qm' => $_GPC['dy_qm'],
            'yun_accountsid' => $_GPC['yun_accountsid'],
            'yun_authtoken' => $_GPC['yun_authtoken'],
            'yun_appid' => $_GPC['yun_appid'],
            'yun_sf' => $_GPC['yun_sf'],
            'yun_dx' => $_GPC['yun_dx'],
            'yun_hm' => $_GPC['yun_hm'],
            'SubAccountSid' => $_GPC['SubAccountSid'],
            'SubAccountToken' => $_GPC['SubAccountToken'],
            'VoIPAccount' => $_GPC['VoIPAccount'],
            'VoIPPassword' => $_GPC['VoIPPassword'],
            '253yun_accountsid' => $_GPC['253yun_accountsid'],
            '253yun_authtoken' => $_GPC['253yun_authtoken'],
            '253yun_appid' => $_GPC['253yun_appid'],
            '253yun_yywb' => $_GPC['253yun_yywb'],
            '253yun_shownum' => $_GPC['253yun_shownum'],
            '253yun_fromSerNum' => $_GPC['253yun_fromSerNum'],
            '253yun_toSerNum' => $_GPC['253yun_toSerNum'],
            'aliyun_AccessKeyId' => $_GPC['aliyun_AccessKeyId'],
            'aliyun_AccessKeySecret' => $_GPC['aliyun_AccessKeySecret'],
            'aliyun_sf' => $_GPC['aliyun_sf'],
            'aliyun_dx' => $_GPC['aliyun_dx'],
            'aliyun_yy' => $_GPC['aliyun_yy'],
            'aliyun_yynum' => $_GPC['aliyun_yynum'],
            'aliyun_PoolKey' => $_GPC['aliyun_PoolKey'],
            'aliyun_ysnum' => $_GPC['aliyun_ysnum'],
            'aliyun_qm' => $_GPC['aliyun_qm']
		);
		wlsetting_save($base, 'api');
		message('更新设置成功！', web_url('setting/setting/api'));
	}
	include wl_template('setting/api');
}

if ($op == 'veri') {
	$settings = wlsetting_read('veri');
	if (checksubmit('submit')) {
		$base = array(
			'ncstatus'=>intval($_GPC['ncstatus']),
			'bdstatus'=>intval($_GPC['bdstatus']),
			'mobilestatus'=>intval($_GPC['mobilestatus'])
		);
		wlsetting_save($base, 'veri');
		message('更新设置成功！', web_url('setting/setting/veri'));
	}
	include wl_template('setting/veri');
}

if ($op == 'hide') {
	$settings = wlsetting_read('hide');
	if (checksubmit('submit')) {
		$base = array(
			'limit'=>$_GPC['limit']
		);
		wlsetting_save($base, 'hide');
		message('更新设置成功！', web_url('setting/setting/hide'));
	}
	include wl_template('setting/hide');
}