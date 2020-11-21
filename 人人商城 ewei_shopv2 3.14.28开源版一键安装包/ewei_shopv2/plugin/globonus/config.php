<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'globonus',
	'name'    => '全民股东',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '股东管理', 'route' => 'partner'),
			array('title' => '股东等级', 'route' => 'level'),
			array(
				'title'   => '结算单',
				'items'   => array(
					array('title' => '待确认', 'route' => 'bonus.status0'),
					array('title' => '待结算', 'route' => 'bonus.status1'),
					array('title' => '已结算', 'route' => 'bonus.status2'),
					array('title' => '创建结算单', 'route' => 'bonus.build')
					),
				'extends' => array('globonus.bonus.detail')
				),
			array(
				'title' => '设置',
				'items' => array(
					array('title' => '入口设置', 'route' => 'cover'),
					array('title' => '通知设置', 'route' => 'notice'),
					array('title' => '基础设置', 'route' => 'set')
					)
				)
			)
		)
	);

?>
