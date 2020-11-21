<?php

echo '
';

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'lottery',
	'name'    => '游戏系统',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '活动管理', 'route' => ''),
			array(
				'title' => '设置',
				'route' => 'setting',
				'items' => array(
					array('title' => '说明&通知设置', 'route' => 'setlottery'),
					array('title' => '入口设置', 'route' => 'setstart')
				)
			)
		)
	)
);

?>
