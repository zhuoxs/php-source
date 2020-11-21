<?php 
defined('IN_IA') or exit('Access Denied');
$ops = array('cate');
$op = in_array($op, $ops) ? $op : 'cate';
wl_load()->model('setting');

if ($op == 'cate') {
	$settings = tgsetting_read('cate');
	if (checksubmit('submit')) {
		$base = array('category_status' => $_GPC['category_status'],'display_status'=>intval($_GPC['display_status']));
		tgsetting_save($base, 'cate');
		message('更新设置成功！', web_url('goods/setting/cate'));
	}
	include wl_template('goods/setting');
}
