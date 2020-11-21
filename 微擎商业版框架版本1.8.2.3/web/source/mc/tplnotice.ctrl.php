<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('mc_tplnotice');
$_W['page']['title'] = '会员微信通知-会员中心';
$dos = array('set');
$do = in_array($do, $dos) ? $do : 'set';

if($do == 'set') {
	if(checksubmit()) {
		$data = array(
			'recharge' => $_GPC['recharge'],
			'credit1' => $_GPC['credit1'],
			'credit2' => $_GPC['credit2'],
			'group' => $_GPC['group'],
			'nums_plus' => $_GPC['nums_plus'],
			'nums_times' => $_GPC['nums_times'],
			'times_plus' => $_GPC['times_plus'],
			'times_times' => $_GPC['times_times'],
		);
		uni_setting_save('tplnotice', $data);
		message('设置通知模板成功', referer(), 'success');
	}
	$setting = uni_setting_load('tplnotice');
	$set = $setting['tplnotice'];
	if(!is_array($set)) {
		$set = array();
	}
	$tpls = array(
		'recharge' => array(
			'name' => '会员余额充值',
			'help' => '请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”会员充值通知“，编号为：“TM00009”的模板。',
		),
		'credit2' => array(
			'name' => '会员余额消费',
			'help' => '请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”余额变更通知“，编号为：“OPENTM207266084”的模板。',
		),
		'credit1' => array(
			'name' => '会员积分变更',
			'help' => '请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”积分提醒“，编号为：“TM00335”的模板。',
		),
		'group' => array(
			'name' => '会员等级变更',
			'help' => '请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”会员级别变更提醒“，编号为：“TM00891”的模板',
		),
		'nums_plus' => array(
			'name' => '会员卡计次充值',
			'help' => '请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”计次充值通知“，编号为：“OPENTM207207134”的模板 ',
		),
		'nums_times' => array(
			'name' => '会员卡计次消费',
			'help' => '请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”计次消费通知“，编号为：“OPENTM202322532”的模板',
		),
		'times_plus' => array(
			'name' => '会员卡计时充值',
			'help' => '请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”自动续费成功通知“，编号为：“TM00956”的模板',
		),
		'times_times' => array(
			'name' => '会员卡计时即将到期',
			'help' => '请在“微信公众平台”选择行业为：“IT科技 - 互联网|电子商务”，添加标题为：”到期提醒通知“，编号为：“TM00008”的模板',
		),
	);
	template('mc/tplnotice');
}
