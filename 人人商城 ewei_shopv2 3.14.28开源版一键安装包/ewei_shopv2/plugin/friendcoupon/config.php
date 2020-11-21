<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'friendcoupon',
	'name'    => '好友瓜分券',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '活动列表', 'route' => 'activity_list'),
			array('title' => '数据统计', 'route' => 'statistics'),
			array('title' => '消息通知', 'route' => 'notify')
			)
		)
	);

?>
