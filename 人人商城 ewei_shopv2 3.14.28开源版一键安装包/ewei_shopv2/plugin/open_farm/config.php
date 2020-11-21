<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'open_farm',
	'name'    => '人人农场',
	'v3'      => true,
	'menu'    => array(
		'title'     => '菜单',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '用户统计', 'route' => ''),
			array('title' => '公告管理', 'route' => 'notice'),
			array('title' => '回复管理', 'route' => 'reply'),
			array('title' => '心情管理', 'route' => 'mood'),
			array('title' => '任务管理', 'route' => 'task'),
			array('title' => '等级管理', 'route' => 'grade'),
			array('title' => '彩蛋管理', 'route' => 'surprised'),
			array('title' => '农场设置', 'route' => 'seting'),
			array('title' => '农场配置', 'route' => 'configure')
		)
	)
);

?>
