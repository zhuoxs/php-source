<?php
defined('IN_IA') or exit('Access Denied');
wl_load()->model('setting');
if ($op == 'display') {
	$foot = tgsetting_read('foot');
	if(checksubmit()){
		$foot = $_GPC['foot'];
		tgsetting_save($foot, 'foot');
		message('脚部栏编辑成功.', web_url('store/footerbar/display'), 'success');
	}
	
	
	
	include wl_template('store/footerbarset');
}

?>