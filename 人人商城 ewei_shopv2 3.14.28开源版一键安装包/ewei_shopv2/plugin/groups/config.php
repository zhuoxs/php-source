<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'groups',
	'name'    => '拼团',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '商品管理', 'route' => 'goods'),
			array('title' => '分类管理', 'route' => 'category'),
			array('title' => '幻灯片管理', 'route' => 'adv'),
			array(
				'title'  => '订单管理',
				'route'  => 'order',
				'extend' => 'groups.order.detail',
				'items'  => array(
					array(
						'title' => '待发货',
						'param' => array('status' => 1)
						),
					array(
						'title' => '待收货',
						'param' => array('status' => 2)
						),
					array(
						'title' => '待付款',
						'param' => array('status' => 3)
						),
					array(
						'title' => '已完成',
						'param' => array('status' => 4)
						),
					array(
						'title' => '已关闭',
						'param' => array('status' => 5)
						),
					array(
						'title' => '全部订单',
						'param' => array('status' => 'all')
						)
					)
				),
			array(
				'title'  => '核销查询',
				'route'  => 'verify',
				'extend' => 'groups.verify.detail',
				'items'  => array(
					array(
						'title' => '未核销',
						'param' => array('verify' => 'normal')
						),
					array(
						'title' => '已核销',
						'param' => array('verify' => 'over')
						),
					array(
						'title' => '已取消',
						'param' => array('verify' => 'cancel')
						)
					)
				),
			array(
				'title'  => '拼团管理',
				'route'  => 'team',
				'extend' => 'groups.team.detail',
				'items'  => array(
					array(
						'title' => '拼团成功',
						'param' => array('type' => 'success')
						),
					array(
						'title' => '拼团中',
						'param' => array('type' => 'ing')
						),
					array(
						'title' => '拼团失败',
						'param' => array('type' => 'error')
						),
					array(
						'title' => '全部拼团',
						'param' => array('type' => 'all')
						)
					)
				),
			array(
				'title'  => '维权设置',
				'route'  => 'refund',
				'extend' => 'groups.refund.detail',
				'items'  => array(
					array(
						'title' => '维权申请',
						'param' => array('status' => 'apply')
						),
					array(
						'title' => '维权完成',
						'param' => array('status' => 'over')
						)
					)
				),
			array(
				'title' => '基础设置',
				'items' => array(
					array('title' => '入口设置', 'route' => 'cover'),
					array('title' => '通知入口', 'route' => 'notice'),
					array('title' => '基础设置', 'route' => 'set'),
					array(
						'title'   => '快递打印',
						'route'   => 'exhelper',
						'extends' => array('groups.exhelper.short', 'groups.exhelper.express', 'groups.exhelper.invoice', 'groups.exhelper.sender', 'groups.exhelper.single', 'groups.exhelper.batch', 'groups.exhelper.senderadd')
						),
					array('title' => '批量发货', 'route' => 'batchsend')
					)
				)
			)
		)
	);

?>
