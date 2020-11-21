<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
$_W['page']['title'] = '全局设置 - 其他设置 - 系统管理';
load()->model('setting');
load()->func('communication');

if(checksubmit('bae_delete_update') || checksubmit('bae_delete_install')) {
	if(!empty($_GPC['bae_delete_update'])) {
		unlink(IA_ROOT . '/data/update.lock');
	} elseif(!empty($_GPC['bae_delete_install'])) {
		unlink(IA_ROOT . '/data/install.lock');
	}
	message('操作成功！', url('system/common'), 'success');
}

if(checksubmit('authmodesubmit')) {
	$authmode = intval($_GPC['authmode']);
	setting_save($authmode, 'authmode');
	message('更新设置成功！', url('system/common'));
}
template('system/common');