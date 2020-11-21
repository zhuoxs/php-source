<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'exhelper',
	'name'    => '快递助手',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array('title' => '设置', 'route' => 'printset'),
			array('title' => '商品简称管理', 'route' => 'short'),
			array(
				'title' => '模板管理',
				'route' => 'temp',
				'items' => array(
					array('title' => '快递单模板', 'route' => 'express'),
					array('title' => '发货单模板', 'route' => 'invoice'),
					array('title' => '发件人模板', 'route' => 'sender', 'route_ns' => true),
					array('title' => '电子面单模版', 'hidemerch' => true, 'route' => 'esheet')
				)
			),
			array(
				'title' => '快递单/发货单',
				'route' => 'print',
				'items' => array(
					array('title' => '单个打印', 'route' => 'single'),
					array('title' => '批量打印', 'route' => 'batch')
				)
			),
			array(
				'title'     => '电子面单',
				'hidemerch' => true,
				'route'     => 'esheetprint',
				'items'     => array(
					array('title' => '单个打印', 'route' => 'single'),
					array('title' => '批量打印', 'route' => 'batch')
				)
			)
		)
	)
);

?>
