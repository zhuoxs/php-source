<?php

echo '
';

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'seckill',
	'name'    => '整点秒杀',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '专题管理', 'route' => 'task'),
			array('title' => '会场管理', 'route' => 'room'),
			array('title' => '商品管理', 'route' => 'goods'),
			array('title' => '分类管理', 'route' => 'category'),
			array('title' => '广告管理', 'route' => 'adv'),
			array(
				'title' => '设置',
				'items' => array(
					array('title' => '任务设置', 'route' => 'calendar'),
					array('title' => '入口设置', 'route' => 'cover')
				)
			)
		)
	)
);

?>
