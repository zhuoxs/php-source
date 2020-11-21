<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'creditshop',
	'name'    => '积分商城',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '商品管理', 'route' => 'goods'),
			array('title' => '分类管理', 'route' => 'category'),
			array('title' => '幻灯片管理', 'route' => 'adv'),
			array(
				'title' => '参与记录',
				'route' => 'log',
				'items' => array(
					array('title' => '兑换记录', 'route' => 'exchange', 'extend' => 'creditshop.log.detail'),
					array('title' => '抽奖记录', 'route' => 'draw')
					)
				),
			array(
				'title' => '评价管理',
				'items' => array(
					array('title' => '全部评价', 'route' => 'comment'),
					array('title' => '待审核', 'route' => 'comment.check')
					)
				),
			array(
				'title' => '发货管理',
				'items' => array(
					array('title' => '待发货', 'route' => 'log.order'),
					array('title' => '待收货', 'route' => 'log.convey'),
					array('title' => '已完成', 'route' => 'log.finish')
					)
				),
			array(
				'title' => '核销管理',
				'items' => array(
					array('title' => '全部核销', 'route' => 'log.verify'),
					array('title' => '待核销', 'route' => 'log.verifying'),
					array('title' => '已核销', 'route' => 'log.verifyover')
					)
				),
			array(
				'title' => '设置',
				'items' => array(
					array('title' => '入口设置', 'route' => 'cover'),
					array('title' => '通知设置', 'route' => 'notice', 'hidemerch' => 'true'),
					array('title' => '基础设置', 'route' => 'set', 'hidemerch' => 'true')
					)
				)
			)
		)
	);

?>
