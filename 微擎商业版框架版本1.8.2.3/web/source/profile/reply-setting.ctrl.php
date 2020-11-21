<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$dos = array('display', 'post');
$do = in_array($do, $dos) ? $do : 'display';

$_W['page']['title'] = '回复设置';

if ($do == 'display') {
	$times = empty($_W['account']['setting']) ? 0 : intval($_W['account']['setting']['reply_setting']);
	template('profile/reply-setting');
}

if ($do == 'post') {
	if (checksubmit()) {
		$new_times = intval($_GPC['times']);
		if ($new_times > 50 || $new_times < 0) {
			itoast('次数超过限制，请重新设置！');
		}
		uni_setting_save('reply_setting', $new_times);
		itoast('保存成功！', referer(), 'success');
	}
}