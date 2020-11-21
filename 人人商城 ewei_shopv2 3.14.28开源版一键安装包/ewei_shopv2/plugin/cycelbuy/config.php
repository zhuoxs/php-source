<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'cycelbuy',
	'name'    => '周期购',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array(
				'title' => '商品管理',
				'route' => 'goods',
				'items' => array(
					array('title' => '出售中', 'route' => 'sale', 'perm' => 'cycelbuy.goods.main'),
					array('title' => '已售罄', 'route' => 'out', 'perm' => 'cycelbuy.goods.main'),
					array('title' => '仓库中', 'route' => 'stock', 'perm' => 'cycelbuy.goods.main'),
					array('title' => '回收站', 'route' => 'cycle', 'perm' => 'cycelbuy.goods.main')
					)
				),
			array(
				'title' => '订单管理',
				'route' => 'order',
				'items' => array(
					array('title' => '待付款', 'route' => 'list.status0', 'perm' => 'cycelbuy.order.status0'),
					array('title' => '未开始', 'route' => 'list.status1', 'perm' => 'cycelbuy.order.status1'),
					array('title' => '进行中', 'route' => 'list.status2', 'perm' => 'cycelbuy.order.status2'),
					array('title' => '已完成', 'route' => 'list.status3', 'perm' => 'cycelbuy.order.status3'),
					array('title' => '已关闭', 'route' => 'list.status_1', 'perm' => 'cycelbuy.order.status_1'),
					array('title' => '全部订单', 'route' => 'list', 'perm' => 'cycelbuy.order'),
					array('title' => '维权申请', 'route' => 'list.status4', 'perm' => 'cycelbuy.order.status4'),
					array('title' => '维权完成', 'route' => 'list.status5', 'perm' => 'cycelbuy.order.status5')
					)
				),
			array(
				'title' => '审核修改地址',
				'items' => array(
					array('title' => '审核修改地址', 'route' => 'refund', 'hidemerch' => 'true')
					)
				),
			array(
				'title' => '评价管理',
				'items' => array(
					array('title' => '全部评价', 'route' => 'comment')
					)
				),
			array(
				'title' => '设置',
				'items' => array(
					array('title' => '基础设置', 'route' => 'set', 'hidemerch' => 'true', 'perm' => 'cycelbuy.set'),
					array('title' => '消息通知', 'route' => 'notice', 'perm' => 'cycelbuy.notice')
					)
				)
			)
		)
	);

?>
