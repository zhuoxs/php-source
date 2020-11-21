<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'qa',
	'name'    => '帮助中心',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array('title' => '幻灯片管理', 'route' => 'adv'),
			array(
				'title' => '问题管理',
				'items' => array(
					array('title' => '问题管理', 'route' => 'question', 'route_must' => true),
					array('title' => '添加问题', 'route' => 'question.add')
					)
				),
			array('title' => '问题分类', 'route' => 'category'),
			array('title' => '基础设置', 'route' => 'set')
			)
		)
	);

?>
