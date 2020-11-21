<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'exchange',
	'name'    => '兑换中心',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array(
				'title' => '兑换分类',
				'items' => array(
					array(
						'title'   => '商品兑换',
						'route'   => 'goods',
						'extends' => array('exchange.goods.nostart', 'exchange.goods.end', 'exchange.goods.edit', 'exchange.goods.dno', 'exchange.goods.dyet', 'exchange.goods.dend')
					),
					array(
						'title'   => '余额兑换',
						'route'   => 'balance',
						'extends' => array('exchange.balance.nostart', 'exchange.balance.end', 'exchange.balance.edit', 'exchange.balance.dno', 'exchange.balance.dyet', 'exchange.balance.dend')
					),
					array(
						'title'   => '红包兑换',
						'route'   => 'redpacket',
						'extends' => array('exchange.redpacket.nostart', 'exchange.redpacket.end', 'exchange.redpacket.edit', 'exchange.redpacket.dno', 'exchange.redpacket.dyet', 'exchange.redpacket.dend')
					),
					array(
						'title'   => '积分兑换',
						'route'   => 'score',
						'extends' => array('exchange.score.nostart', 'exchange.score.end', 'exchange.score.edit', 'exchange.score.dno', 'exchange.score.dyet', 'exchange.score.dend')
					),
					array(
						'title'   => '优惠券兑换',
						'route'   => 'coupon',
						'extends' => array('exchange.coupon.nostart', 'exchange.coupon.end', 'exchange.coupon.edit', 'exchange.coupon.dno', 'exchange.coupon.dyet', 'exchange.coupon.dend')
					),
					array(
						'title'   => '组合兑换',
						'route'   => 'group',
						'extends' => array('exchange.group.nostart', 'exchange.group.end', 'exchange.group.edit', 'exchange.group.dno', 'exchange.group.dyet', 'exchange.group.dend')
					)
				)
			),
			array(
				'title' => '商品订单',
				'items' => array(
					array('title' => '待发货', 'route' => 'record.daifahuo'),
					array('title' => '待收货', 'route' => 'record.daishouhuo'),
					array('title' => '待付款', 'route' => 'record.daifukuan'),
					array('title' => '已关闭', 'route' => 'record.yiguanbi'),
					array('title' => '已完成', 'route' => 'record.yiwancheng'),
					array('title' => '全部订单', 'route' => 'record')
				)
			),
			array(
				'title' => '其他',
				'items' => array(
					array('title' => '文件管理', 'route' => 'setting.download'),
					array('title' => '其他设置', 'route' => 'setting.other')
				)
			),
			array(
				'title' => '兑换记录',
				'items' => array(
					array('title' => '兑换记录', 'route' => 'history')
				)
			)
		)
	)
);

?>
