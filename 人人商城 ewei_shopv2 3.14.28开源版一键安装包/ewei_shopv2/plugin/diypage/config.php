<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '2.0',
	'id'      => 'diypage',
	'name'    => '店铺装修',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array(
				'title' => '页面管理',
				'route' => 'page',
				'items' => array(
					array('title' => '系统页面', 'route' => 'sys'),
					array('title' => '应用页面', 'route' => 'plu', 'hidemerch' => true),
					array('title' => '自定义页面', 'route' => 'diy'),
					array('title' => '新建页面', 'route' => 'create')
					)
				),
			array(
				'title' => '公用模块',
				'route' => 'page',
				'items' => array(
					array('title' => '模块管理', 'route' => 'mod', 'route_must' => true),
					array('title' => '新建模块', 'route' => 'mod.add')
					)
				),
			array(
				'title' => '自定义菜单',
				'route' => 'menu',
				'items' => array(
					array('title' => '菜单管理', 'route_must' => true),
					array('title' => '新建菜单', 'route' => 'add')
					)
				),
			array(
				'title' => '其他功能',
				'route' => 'shop',
				'items' => array(
					array('title' => '悬浮按钮', 'route' => 'layer'),
					array('title' => '返回顶部', 'route' => 'gotop'),
					array('title' => '关注条', 'route' => 'followbar'),
					array('title' => '启动广告', 'route' => 'adv'),
					array('title' => '下单提醒', 'route' => 'danmu')
					)
				),
			array(
				'title' => '商城设置',
				'route' => 'shop',
				'items' => array(
					array('title' => '页面设置', 'route' => 'page'),
					array('title' => '菜单设置', 'route' => 'menu')
					)
				),
			array(
				'title' => '模板管理',
				'route' => 'temp',
				'items' => array(
					array('title' => '全部模板'),
					array('title' => '模板分类', 'route' => 'category')
					)
				)
			)
		)
	);

?>
