<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version'     => '1.0',
	'id'          => 'merch',
	'name'        => '多商户',
	'v3'          => true,
	'menu'        => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array(
				'title'   => '入驻申请',
				'route'   => 'reg',
				'extends' => array('merch.reg.detail'),
				'items'   => array(
					array(
						'title' => '申请中',
						'param' => array('status' => 0)
					),
					array(
						'title' => '驳回',
						'param' => array('status' => -1)
					)
				)
			),
			array(
				'title' => '商户管理',
				'route' => 'user',
				'items' => array(
					array(
						'title' => '待入驻',
						'param' => array('status' => 0)
					),
					array(
						'title' => '入驻中',
						'param' => array('status' => 1)
					),
					array(
						'title' => '暂停中',
						'param' => array('status' => 2)
					),
					array(
						'title' => '即将到期',
						'param' => array('status' => 3)
					),
					array(
						'title' => '已到期',
						'param' => array('status' => 4)
					),
					array('title' => '商户分组', 'route' => 'group', 'route_ns' => true),
					array('title' => '商户分类', 'route' => 'category', 'route_ns' => true)
				)
			),
			array(
				'title' => '数据统计',
				'route' => 'statistics',
				'items' => array(
					array('title' => '订单统计', 'route' => 'order'),
					array('title' => '商户统计', 'route' => 'merch')
				)
			),
			array(
				'title'   => '提现申请',
				'route'   => 'check',
				'items'   => array(
					array('title' => '待确认申请', 'route' => 'status1'),
					array('title' => '待打款申请', 'route' => 'status2'),
					array('title' => '已打款申请', 'route' => 'status3'),
					array('title' => '无效申请', 'route' => 'status_1')
				),
				'extends' => array('merch.check.detail')
			),
			array(
				'title'   => '积分提现',
				'route'   => 'credit',
				'items'   => array(
					array('title' => '待确认申请', 'route' => 'status1'),
					array('title' => '待打款申请', 'route' => 'status2'),
					array('title' => '已打款申请', 'route' => 'status3'),
					array('title' => '无效申请', 'route' => 'status_1')
				),
				'extends' => array('merch.credit.detail')
			),
			array(
				'title' => '其他设置',
				'items' => array(
					array('title' => '基础设置', 'route' => 'set'),
					array('title' => '通知设置', 'route' => 'notice'),
					array(
						'title'   => '入口设置',
						'route'   => 'cover.register',
						'extends' => array('merch.cover.merchlist', 'merch.cover.merchuser')
					),
					array('title' => '商户分类幻灯', 'route' => 'category.swipe', 'extend' => 'merch.category.edit_swipe')
				)
			)
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
				array('title' => '出售中', 'desc' => '出售中商品管理', 'perm' => 'goods.main'),
				array('title' => '审核中', 'route' => 'check', 'desc' => '审核中商品', 'perm' => 'goods.main'),
				array('title' => '已售罄', 'route' => 'out', 'desc' => '已售罄/无库存商品管理', 'perm' => 'goods.main'),
				array('title' => '仓库中', 'route' => 'stock', 'desc' => '仓库中商品管理', 'perm' => 'goods.main'),
				array('title' => '回收站', 'route' => 'cycle', 'desc' => '回收站/已删除商品管理', 'perm' => 'goods.main'),
				array('title' => '商品分类', 'route' => 'category'),
				array('title' => '商品组', 'route' => 'group'),
				array(
					'title' => '虚拟卡密',
					'route' => 'virtual',
					'items' => array(
						array('title' => '虚拟卡密', 'route' => 'temp', 'extend' => 'goods.virtual.data'),
						array('title' => '卡密分类', 'route' => 'category')
					)
				)
			)
		),
		'order'      => array(
			'title'    => '订单',
			'subtitle' => '订单管理',
			'icon'     => 'order',
			'main'     => true,
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
		'perm'       => array(
			'title'    => '权限',
			'subtitle' => '权限系统',
			'icon'     => 'heimingdan2',
			'items'    => array(
				array('title' => '角色管理', 'route' => 'role'),
				array('title' => '操作员管理', 'route' => 'user'),
				array('title' => '操作员日志', 'route' => 'log')
			)
		),
		'apply'      => array(
			'title'    => '结算',
			'subtitle' => '结算',
			'icon'     => '31',
			'main'     => true,
			'items'    => array(
				array(
					'title' => '余额提现',
					'items' => array(
						array('title' => '待审核申请', 'route' => 'list.status1'),
						array('title' => '待结算申请', 'route' => 'list.status2'),
						array('title' => '已结算申请', 'route' => 'list.status3'),
						array('title' => '已无效申请', 'route' => 'list.status_1'),
						array('title' => '申请提现', 'route' => 'list.add')
					)
				),
				array(
					'title' => '积分商城提现',
					'items' => array(
						array('title' => '待审核申请', 'route' => 'credit.status1'),
						array('title' => '待结算申请', 'route' => 'credit.status2'),
						array('title' => '已结算申请', 'route' => 'credit.status3'),
						array('title' => '已无效申请', 'route' => 'credit.status_1'),
						array('title' => '申请提现', 'route' => 'credit.add')
					)
				)
			)
		),
		'plugins'    => array('title' => '应用', 'icon' => 'plugins'),
		'sysset'     => array(
			'title'    => '设置',
			'subtitle' => '商城设置',
			'icon'     => 'sysset',
			'items'    => array(
				array('title' => '基础设置', 'route' => 'shop'),
				array('title' => '消息提醒', 'route' => 'notice'),
				array(
					'title' => '小票打印机',
					'items' => array(
						array(
							'title'   => '打印机管理',
							'route'   => 'printer.printer_list',
							'extends' => array('sysset.printer.printer_add')
						),
						array('title' => '打印机模板库', 'route' => 'printer'),
						array('title' => '打印设置', 'route' => 'printer.set')
					)
				)
			)
		)
	)
);

?>
