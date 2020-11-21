<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'dividend',
	'name'    => '团队分红',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '队长管理', 'route' => 'agent'),
			array('title' => '分红订单', 'route' => 'statistics.order'),
			array(
				'title' => '提现申请',
				'route' => 'apply',
				'items' => array(
					array(
						'title' => '待审核',
						'param' => array('status' => 1)
						),
					array(
						'title' => '待打款',
						'param' => array('status' => 2)
						),
					array(
						'title' => '已打款',
						'param' => array('status' => 3)
						),
					array(
						'title' => '无效',
						'param' => array('status' => -1)
						)
					)
				),
			array(
				'title' => '设置',
				'items' => array(
					array('title' => '通知设置', 'route' => 'notice'),
					array('title' => '入口设置', 'route' => 'cover'),
					array('title' => '基础设置', 'route' => 'set')
					)
				)
			)
		)
	);

?>
