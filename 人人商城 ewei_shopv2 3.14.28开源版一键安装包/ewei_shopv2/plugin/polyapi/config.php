<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version'     => '1.0',
	'id'          => 'polyapi',
	'name'        => '进销存-网店管家',
	'v3'          => true,
	'menu'        => array(
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '基础设置')
			)
		),
	'manage_menu' => array(
		'shop'       => array(
			'title'    => '店铺',
			'subtitle' => '店铺首页',
			'icon'     => 'store',
			'items'    => array(
				array(
					'title' => '首页',
					'route' => '',
					'items' => array(
						array('title' => '幻灯片', 'route' => 'adv', 'desc' => '店铺首页幻灯片管理'),
						array('title' => '导航图标', 'route' => 'nav', 'desc' => '店铺首页导航图标管理'),
						array('title' => '广告', 'route' => 'banner', 'desc' => '店铺首页广告管理'),
						array('title' => '魔方推荐', 'route' => 'cube', 'desc' => '店铺首页魔方推荐管理'),
						array('title' => '商品推荐', 'route' => 'recommand', 'desc' => '店铺首页商品推荐管理'),
						array('title' => '排版设置', 'route' => 'sort', 'desc' => '店铺首页排版设置')
						)
					),
				array(
					'title' => '商城',
					'items' => array(
						array('title' => '配送方式', 'route' => 'dispatch', 'desc' => '店铺配送方式管理'),
						array('title' => '公告管理', 'route' => 'notice', 'desc' => '店铺公告管理'),
						array('title' => '评价管理', 'route' => 'comment', 'desc' => '店铺商品评价管理'),
						array('title' => '退货地址', 'route' => 'refundaddress', 'desc' => '店铺退货地址管理')
						)
					),
				array(
					'title' => 'O2O',
					'route' => 'verify',
					'items' => array(
						array('title' => '门店管理', 'route' => 'store', 'desc' => '核销/自提门店管理'),
						array('title' => '店员管理', 'route' => 'saler', 'desc' => '核销/自提门店店员管理')
						)
					)
				)
			),
		'goods'      => array(
			'title'    => '商品',
			'subtitle' => '商品管理',
			'icon'     => 'goods',
			'items'    => array(
				array('title' => '出售中', 'desc' => '出售中商品管理'),
				array('title' => '已售罄', 'route' => 'out', 'desc' => '已售罄/无库存商品管理'),
				array('title' => '仓库中', 'route' => 'stock', 'desc' => '仓库中商品管理'),
				array('title' => '回收站', 'route' => 'cycle', 'desc' => '回收站/已删除商品管理'),
				array('title' => '商品分类', 'route' => 'category'),
				array('title' => '商品组', 'route' => 'group'),
				array(
					'title' => '虚拟卡密',
					'route' => 'virtual',
					'items' => array(
						array('title' => '虚拟卡密', 'route' => 'temp'),
						array('title' => '卡密分类', 'route' => 'category')
						)
					)
				)
			),
		'order'      => array(
			'title'    => '订单',
			'subtitle' => '订单管理',
			'icon'     => 'order',
			'items'    => array(
				array('title' => '待发货', 'route' => 'list.status1', 'desc' => '待发货订单管理'),
				array('title' => '待收货', 'route' => 'list.status2', 'desc' => '待收货订单管理'),
				array('title' => '待付款', 'route' => 'list.status0', 'desc' => '待付款订单管理'),
				array('title' => '已完成', 'route' => 'list.status3', 'desc' => '已完成订单管理'),
				array('title' => '已关闭', 'route' => 'list.status_1', 'desc' => '已关闭订单管理'),
				array('title' => '全部订单', 'route' => 'list', 'desc' => '全部订单列表'),
				array(
					'title' => '维权',
					'route' => 'list',
					'items' => array(
						array('title' => '维权申请', 'route' => 'status4', 'desc' => '维权申请管理'),
						array('title' => '维权完成', 'route' => 'status5', 'desc' => '维权完成管理')
						)
					),
				array(
					'title' => '工具',
					'items' => array(
						array('title' => '自定义导出', 'route' => 'export', 'desc' => '订单自定义导出'),
						array('title' => '批量发货', 'route' => 'batchsend', 'desc' => '订单批量发货')
						)
					)
				)
			),
		'sale'       => array(
			'title'    => '营销',
			'subtitle' => '营销设置',
			'icon'     => 'yingxiao',
			'items'    => array(
				array(
					'title' => '基本功能',
					'items' => array(
						array('title' => '满额立减', 'route' => 'enough', 'desc' => '满额立减设置', 'keywords' => '营销'),
						array('title' => '满额包邮', 'route' => 'enoughfree', 'desc' => '满额包邮设置', 'keywords' => '营销')
						)
					),
				array(
					'title' => '优惠券',
					'route' => 'coupon',
					'items' => array(
						array('title' => '全部优惠券'),
						array('title' => '发放记录', 'route' => 'log', 'desc' => '优惠券发放记录'),
						array('title' => '分类管理', 'route' => 'category', 'desc' => '优惠券分类管理'),
						array('title' => '其他设置', 'route' => 'set', 'desc' => '优惠券设置')
						)
					)
				)
			),
		'statistics' => array(
			'title'    => '数据',
			'subtitle' => '数据统计',
			'icon'     => 'statistics',
			'items'    => array(
				array(
					'title' => '销售统计',
					'items' => array(
						array('title' => '销售统计', 'route' => 'sale'),
						array('title' => '销售指标', 'route' => 'sale_analysis'),
						array('title' => '订单统计', 'route' => 'order')
						)
					),
				array(
					'title' => '商品统计',
					'items' => array(
						array('title' => '销售明细', 'route' => 'goods'),
						array('title' => '销售排行', 'route' => 'goods_rank'),
						array('title' => '销售转化率', 'route' => 'goods_trans')
						)
					),
				array(
					'title' => '会员统计',
					'items' => array(
						array('title' => '消费排行', 'route' => 'member_cost'),
						array('title' => '增长趋势', 'route' => 'member_increase')
						)
					)
				)
			),
		'perm'       => array('title' => '权限', 'subtitle' => '权限系统', 'icon' => 'heimingdan2'),
		'apply'      => array('title' => '结算', 'subtitle' => '权限系统', 'icon' => '31'),
		'plugins'    => array('title' => '应用', 'subtitle' => '权限系统', 'icon' => 'plugins'),
		'sysset'     => array('title' => '设置', 'subtitle' => '权限系统', 'icon' => 'sysset')
		)
	);

?>
