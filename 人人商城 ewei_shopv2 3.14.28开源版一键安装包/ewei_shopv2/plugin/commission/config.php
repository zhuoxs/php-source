<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'commission',
	'name'    => '人人分销',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '分销商管理', 'route' => 'agent'),
			array('title' => '增长趋势统计', 'route' => 'increase'),
			array('title' => '分销商等级', 'route' => 'level'),
			array('title' => '分销订单', 'route' => 'statistics.order'),
			array('title' => '分销商统计', 'route' => 'statistics.agent'),
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
					array('title' => '排行榜设置', 'route' => 'rank'),
					array('title' => '通知设置', 'route' => 'notice'),
					array('title' => '入口设置', 'route' => 'cover'),
					array('title' => '基础设置', 'route' => 'set')
				)
			)
		)
	)
);

?>
