<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

if (!defined('IN_IA')) {
	exit('Access Denied');
}

global $_GPC, $_W;

$mod_menu = [
	// 系统管理
	'basic'=>[
		'mod'=>'0',
		'title'=>'系统管理',
		'items'=>[
			'basic/set'=>['title'=>'基本设置', 'url'=>webUrl('',['do'=>'basic/set']), 'show'=>TRUE],
			'basic/color'=>['title'=>'颜色配置', 'url'=>webUrl('',['do'=>'basic/color']), 'show'=>TRUE],
			'basic/menus'=>['title'=>'底部导航', 'url'=>webUrl('',['do'=>'basic/menus']), 'show'=>TRUE],
			'basic/menu_quick'=>['title'=>'悬浮按钮', 'url'=>webUrl('',['do'=>'basic/menu_quick']), 'show'=>TRUE],
			'basic/auth_qywx'=>['title'=>'企业微信授权', 'url'=>webUrl('',['do'=>'basic/auth_qywx']), 'show'=>TRUE],
			'basic/cpright'=>['title'=>'版权设置', 'url'=>webUrl('',['do'=>'basic/cpright']), 'show'=>TRUE],
		]
	],
	// 组件管理
	'module'=>[
		'mod'=>'0',
		'title'=>'组件管理',
		'items'=>[
			'module/adact'=>['title'=>'单页面', 'url'=>webUrl('',['do'=>'module/adact']), 'show'=>TRUE],
			'module/mod_wxapp'=>['title'=>'跳转小程序', 'url'=>webUrl('',['do'=>'module/mod_wxapp']), 'show'=>TRUE],
		]
	],
	// 内容管理
	'content'=>[
		'mod'=>'0',
		'title'=>'内容管理',
		'items'=>[
			'content/card'=>['title'=>'名片管理', 'url'=>webUrl('',['do'=>'content/card']), 'show'=>TRUE],
			'content/pro_list'=>['title'=>'产品管理', 'url'=>webUrl('',['do'=>'content/pro_list']), 'show'=>TRUE],
			'content/dy_index'=>['title'=>'动态管理', 'url'=>webUrl('',['do'=>'content/dy_index']), 'show'=>TRUE],
			'content/dy_comment'=>['title'=>'动态评论管理', 'url'=>webUrl('',['do'=>'content/dy_comment']), 'show'=>TRUE],
		]
	],
	// 客户管理
	'client'=>[
		'mod'=>'0',
		'title'=>'客户管理',
		'items'=>[
			'client/user_list'=>['title'=>'客户统计', 'url'=>webUrl('',['do'=>'client/user_list']), 'show'=>TRUE],
		]
	],
	// 官网管理
	'website'=>[
		'mod'=>'0',
		'title'=>'官网管理',
		'items'=>[
			'website/default'=>['title'=>'首页配置', 'url'=>webUrl('',['do'=>'website/default']), 'show'=>TRUE],
			'website/buttons'=>['title'=>'首页按钮组', 'url'=>webUrl('',['do'=>'website/buttons']), 'show'=>TRUE],
			'website/adv'=>['title'=>'轮播图', 'url'=>webUrl('',['do'=>'website/adv']), 'show'=>TRUE],
			'website/adgroup'=>['title'=>'组合广告', 'url'=>webUrl('',['do'=>'website/adgroup']), 'show'=>TRUE],
			'website/act_term'=>['title'=>'普通文章-分类', 'url'=>webUrl('',['do'=>'website/act_term']), 'show'=>TRUE],
			'website/act_news'=>['title'=>'普通文章-文章', 'url'=>webUrl('',['do'=>'website/act_news']), 'show'=>TRUE],
		]
	],
	// 商城管理
	'store'=>[
		'mod'=>'0',
		'title'=>'商城管理',
		'items'=>[
			'store/default'=>['title'=>'首页配置', 'url'=>webUrl('',['do'=>'store/default']), 'show'=>TRUE],
			'store/buttons'=>['title'=>'首页按钮组', 'url'=>webUrl('',['do'=>'store/buttons']), 'show'=>TRUE],
			'store/adsp'=>['title'=>'首页广告', 'url'=>webUrl('',['do'=>'store/adsp']), 'show'=>TRUE],
			'store/adgroup'=>['title'=>'组合广告', 'url'=>webUrl('',['do'=>'store/adgroup']), 'show'=>TRUE],
			'store/adv'=>['title'=>'轮播图', 'url'=>webUrl('',['do'=>'store/adv']), 'show'=>TRUE],
			'store/category'=>['title'=>'商品分类', 'url'=>webUrl('',['do'=>'store/category']), 'show'=>TRUE],
			'store/goods'=>['title'=>'商品管理', 'url'=>webUrl('',['do'=>'store/goods']), 'show'=>TRUE],
			'store/order'=>['title'=>'订单管理', 'url'=>webUrl('',['do'=>'store/order']), 'show'=>TRUE],
			'store/sale'=>['title'=>'优惠券管理', 'url'=>webUrl('',['do'=>'store/sale']), 'show'=>TRUE],
			'store/printer'=>['title'=>'打印机配置', 'url'=>webUrl('',['do'=>'store/printer']), 'show'=>TRUE],
			'store/commission'=>['title'=>'分销管理', 'url'=>webUrl('',['do'=>'store/commission']), 'show'=>TRUE],
		]
	],
	// 旧版商城管理
	'shop'=>[
		'mod'=>'0',
		'title'=>'旧版商城管理',
		'items'=>[
			'shop/category'=>['title'=>'商品分类', 'url'=>webUrl('',['do'=>'shop/category']), 'show'=>TRUE],
			'shop/goods'=>['title'=>'商品管理', 'url'=>webUrl('',['do'=>'shop/goods']), 'show'=>TRUE],
			'shop/order'=>['title'=>'订单管理', 'url'=>webUrl('',['do'=>'shop/order']), 'show'=>TRUE],
			'shop/sale'=>['title'=>'优惠券管理', 'url'=>webUrl('',['do'=>'shop/sale']), 'show'=>TRUE],
		]
	],
	// 其他设置
	'other'=>[
		'mod'=>'0',
		'title'=>'其他设置',
		'items'=>[
			'other/upwxapp'=>['title'=>'上传小程序', 'url'=>webUrl('',['do'=>'other/upwxapp']), 'show'=>TRUE],
			'other/card_set'=>['title'=>'名片设置', 'url'=>webUrl('',['do'=>'other/card_set']), 'show'=>TRUE],
			'other/sdata'=>['title'=>'数据初始化', 'url'=>webUrl('',['do'=>'other/sdata']), 'show'=>TRUE],
			'other/auth'=>['title'=>'系统授权', 'url'=>webUrl('',['do'=>'other/auth']), 'show'=>TRUE],
			'other/upgrade'=>['title'=>'系统同步', 'url'=>webUrl('',['do'=>'other/upgrade']), 'show'=>TRUE],
			'gongdang'=>['title'=>'提交工单', 'url'=>'http://kf.q14.cn/forum.php?mod=forumdisplay&fid=36', 'show'=>TRUE, 'target'=>'_blank'],
			'other/oplog'=>['title'=>'操作日志', 'url'=>webUrl('',['do'=>'other/oplog']), 'show'=>FALSE],
		]
	],
	// 系统功能
	'system'=>[
		'mod'=>'0',
		'title'=>'系统',
		'items'=>[
			'system/dialoglink'=>['title'=>'选择连接', 'url'=>webUrl('',['do'=>'system/dialoglink']), 'show'=>FALSE],
			'system/dialoggood'=>['title'=>'选择商城商品', 'url'=>webUrl('',['do'=>'system/dialoggood']), 'show'=>FALSE],
		]
	],
];

if ($mod_menu) {
	foreach ($mod_menu as $key => $value) {
		if ($value['items']) {
			foreach ($value['items'] as $k => $v) {
				if (!($v['show'])) {
					unset($mod_menu[$key]['items'][$k]);
				}
			}
		}
	}
}

$first_mod = '0';
if ($_W['role'] == 'founder') {
	foreach ($mod_menu as $k => $v) {
		if (array_key_exists($_GPC['do'], $v['items'])) {
			$mod_menu[$k]['mod'] = '1';
			$first_mod = '1';
			break;
		}
	}
} else {
	unset($mod_menu['other']);

	if ($_W['slwl']['menus_auth']) {
		foreach ($mod_menu as $k => $v) {
			$tmp_menu = array();
			foreach ($v['items'] as $key => $value) {
				$tmp_for = $_W['current_module']['name'].'_menu_'.$key;
				array_push($tmp_menu, $tmp_for);

				if (!(in_array($tmp_for, $_W['slwl']['menus_auth']))) {
					unset($mod_menu[$k]['items'][$key]);
				}
			}

			if (array_key_exists($_GPC['do'], $v['items'])) {
				$mod_menu[$k]['mod'] = '1';
				$first_mod = '1';
			}
		}
	}
}

// 删除没有子项的菜单
foreach ($mod_menu as $key => $value) {
	if (empty($value['items'])) {
		unset($mod_menu[$key]);
	}
}

// web页时展开第一个菜单列表项
if ($first_mod == '0') {
	if ($mod_menu) {
		foreach ($mod_menu as $k => $v) {
			$mod_menu[$k]['mod'] = '1';
			break;
		}
	}
}

$_W['menus_array']['left'] = $mod_menu;

// -----------------------------------------------------------------------------

// top菜单
$mod_menu_top = [
	'top'=>[
		'mod'=>'0',
		'title'=>'项部菜单',
		'items'=>[
			'web'=>['title'=>'首页', 'url'=>webUrl('web'), 'show'=>TRUE],
			'basic/set'=>['title'=>'基本设置', 'url'=>webUrl('',['do'=>'basic/set']), 'show'=>TRUE],
			'basic/color'=>['title'=>'颜色配置', 'url'=>webUrl('',['do'=>'basic/color']), 'show'=>TRUE],
			'basic/menus'=>['title'=>'底部菜单', 'url'=>webUrl('',['do'=>'basic/menus']), 'show'=>TRUE],
			'content/card'=>['title'=>'名片管理', 'url'=>webUrl('',['do'=>'content/card']), 'show'=>TRUE],
			'content/pro_list'=>['title'=>'产品管理', 'url'=>webUrl('',['do'=>'content/pro_list']), 'show'=>TRUE],
			'store/store_goods'=>['title'=>'商品管理', 'url'=>webUrl('',['do'=>'store/goods']), 'show'=>TRUE],
			'content/dy_index'=>['title'=>'动态管理', 'url'=>webUrl('',['do'=>'content/dy_index']), 'show'=>TRUE],
			'client/user_list'=>['title'=>'客户统计', 'url'=>webUrl('',['do'=>'client/user_list']), 'show'=>TRUE],
			'other/upwxapp'=>['title'=>'上传小程序', 'url'=>webUrl('',['do'=>'other/upwxapp']), 'show'=>TRUE],
		]
	],
];

if ($_W['role'] != 'founder') {
	foreach ($mod_menu_top as $k => $v) {
		foreach ($v['items'] as $key => $value) {
			if ($key != 'web' && $key != 'upwxapp') {
				$tmp_for = $_W['current_module']['name'].'_menu_'.$key;
				if ($_W['slwl']['menus_auth']) {
					if (!(in_array($tmp_for, $_W['slwl']['menus_auth']))) {
						unset($mod_menu_top[$k]['items'][$key]);
					}
				}
			}
		}
	}
}

$_W['menus_array']['top'] = $mod_menu_top['top'];

