<?php
return array(
	'version' => '1.0',
	'id'      => 'pc',
	'name'    => 'pc商城',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array(
				'title' => '商品组列表',
				'route' => 'goods',
				'items' => array(
					array('title' => '商品组编辑')
				)
			),
			array(
				'title' => '菜单管理',
				'route' => 'menu',
				'items' => array(
					array('title' => '顶部导航', 'route' => 'top'),
					array('title' => '底部导航', 'route' => 'bottom')
				)
			),
			array(
				'title' => '广告管理',
				'route' => 'adv',
				'items' => array(
					array('title' => '首页轮播', 'route' => 'banner'),
					array('title' => '推荐广告', 'route' => 'recommend')
				)
			),
			array('title' => '排版设置', 'route' => 'typesetting'),
			array('title' => '设置', 'route' => 'setting')
		)
	)
);

?>
