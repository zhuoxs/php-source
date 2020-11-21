<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function url($segment, $params = array()) {
	return wurl($segment, $params);
}

function message($msg, $redirect = '', $type = '') {
	global $_W, $_GPC;
	if($redirect == 'refresh') {
		$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
	}
	if($redirect == 'referer') {
		$redirect = referer();
	}
	if($redirect == '') {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
	} else {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
	}
	if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
		if($type != 'ajax' && !empty($_GPC['target'])) {
			exit("
<script type=\"text/javascript\">
parent.require(['jquery', 'util'], function($, util){
	var url = ".(!empty($redirect) ? 'parent.location.href' : "''").";
	var modalobj = util.message('".$msg."', '', '".$type."');
	if (url) {
		modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
	}
});
</script>");
		} else {
			$vars = array();
			$vars['message'] = $msg;
			$vars['redirect'] = $redirect;
			$vars['type'] = $type;
			exit(json_encode($vars));
		}
	}
	if (empty($msg) && !empty($redirect)) {
		header('location: '.$redirect);
	}
	$label = $type;
	if($type == 'error') {
		$label = 'danger';
	}
	if($type == 'ajax' || $type == 'sql') {
		$label = 'warning';
	}
	include wl_template('common/message', TEMPLATE_INCLUDEPATH);
	exit();
}

function checklogin() {
	global $_W;
//	if (empty($_W['weliam']['user_id'])) {
//		message('抱歉，您无权进行该操作，请先登录！', url('user/login', array('shopid' => $_W['__shopid'])), 'warning');
//	}
	return true;
}

function system_modules() {
    return array(
        'basic', 'news', 'music', 'userapi', 'recharge',
        'custom', 'images', 'video', 'voice', 'chats', 'wxcard', 'paycenter'
    );
}

function iajax($code = 0, $message = '', $redirect = '') {
	message(error($code, $message), $redirect, 'ajax');
}