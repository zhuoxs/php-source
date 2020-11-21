<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$we7_system_menu = array();

$we7_system_menu['platform'] = array(
	'title' => '平台',
	'icon' => 'wi wi-platform',
	'url' => url('account/display/platform'),
	'section' => array(),
);

$we7_system_menu['account'] = array(
	'title' => '公众号',
	'icon' => 'wi wi-white-collar',
	'url' => url('home/welcome/platform'),
	'section' => array(
		'platform_plus' => array(
			'title' => '增强功能',
			'menu' => array(
				'platform_reply' => array(
					'title' => '自动回复',
					'url' => url('platform/reply'),
					'icon' => 'wi wi-reply',
					'permission_name' => 'platform_reply',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
					'sub_permission' => array(
																																																																													),
				),
				'platform_menu' => array(
					'title' => '自定义菜单',
					'url' => url('platform/menu/post'),
					'icon' => 'wi wi-custommenu',
					'permission_name' => 'platform_menu',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
				),
				'platform_qr' => array(
					'title' => '二维码/转化链接',
					'url' => url('platform/qr'),
					'icon' => 'wi wi-qrcode',
					'permission_name' => 'platform_qr',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
					),
					'sub_permission' => array(
																																																					),
				),
				'platform_material' => array(
					'title' => '素材/编辑器',
					'url' => url('platform/material'),
					'icon' => 'wi wi-redact',
					'permission_name' => 'platform_material',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
					'sub_permission' => array(
						array(
							'title' => '添加/编辑',
							'url' => url('platform/material-post'),
							'permission_name' => 'material_post',
						),
						array(
							'title' => '删除',
							'permission_name' => 'platform_material_delete',
						),
					),
				),
				'platform_site' => array(
					'title' => '微官网-文章',
					'url' => url('site/multi/display'),
					'icon' => 'wi wi-home',
					'permission_name' => 'platform_site',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
					),
					'sub_permission' => array(
																																																					),
				)
			),
		),
		'platform_module' => array(
			'title' => '应用模块',
			'menu' => array(),
			'is_display' => true,
		),
		'mc' => array(
			'title' => '粉丝',
			'menu' => array(
				'mc_fans' => array(
					'title' => '粉丝管理',
					'url' => url('mc/fans'),
					'icon' => 'wi wi-fansmanage',
					'permission_name' => 'mc_fans',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
				),
				'mc_member' => array(
					'title' => '会员管理',
					'url' => url('mc/member'),
					'icon' => 'wi wi-fans',
					'permission_name' => 'mc_member',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
				)
			),
		),
		'profile' => array(
			'title' => '配置',
			'menu' => array(
				'profile' => array(
					'title' => '参数配置',
					'url' => url('profile/remote'),
					'icon' => 'wi wi-parameter-setting',
					'permission_name' => 'profile_setting',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
				),
				'payment' => array(
					'title' => '支付参数',
					'url' => url('profile/payment'),
					'icon' => 'wi wi-pay-setting',
					'permission_name' => 'profile_pay_setting',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
					),
				),
				'app_module_link' => array(
					'title' => "数据同步",
					'url' => url('profile/module-link-uniacid'),
					'is_display' => 1,
					'icon' => 'wi wi-data-synchro',
					'permission_name' => 'profile_app_module_link_uniacid',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
				),
				
				'bind_domain' => array(
					'title' => '域名绑定',
					'url' => url('profile/bind-domain'),
					'icon' => 'wi wi-bind-domain',
					'permission_name' => 'profile_bind_domain',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
				),
				
			),
		),
		
		'statistics' => array(
			'title' => '统计',
			'menu' => array(
				'statistics_app' => array(
					'title' => '访问统计',
					'url' => url('statistics/app'),
					'icon' => 'wi wi-statistical',
					'permission_name' => 'statistics_app',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
				),
				'statistics_fans' => array(
					'title' => '用户统计',
					'url' => url('statistics/fans'),
					'icon' => 'wi wi-statistical',
					'permission_name' => 'statistics_fans',
					'is_display' => array(
						ACCOUNT_TYPE_OFFCIAL_NORMAL,
						ACCOUNT_TYPE_OFFCIAL_AUTH,
						ACCOUNT_TYPE_XZAPP_NORMAL,
						ACCOUNT_TYPE_XZAPP_AUTH,
					),
				),
			),
		),
		
	),
);

$we7_system_menu['wxapp'] = array(
	'title' => '微信小程序',
	'icon' => 'wi wi-small-routine',
	'url' => url('wxapp/display/home'),
	'section' => array(
		'wxapp_entrance' => array(
			'title' => '小程序入口',
			'menu' => array(
				'module_entrance_link' => array(
					'title' => "入口页面",
					'url' => url('wxapp/entrance-link'),
					'is_display' => array(
						ACCOUNT_TYPE_APP_NORMAL,
						ACCOUNT_TYPE_APP_AUTH,
						ACCOUNT_TYPE_WXAPP_WORK,
											),
					'icon' => 'wi wi-data-synchro',
					'permission_name' => 'wxapp_entrance_link',
				),
			),
		),
		'platform_module' => array(
			'title' => '应用',
			'menu' => array(),
			'is_display' => true,
		),
		'mc' => array(
			'title' => '粉丝',
			'menu' => array(
				'wxapp_member' => array(
					'title' => '会员',
					'url' => url('mc/member'),
					'is_display' => array(
						ACCOUNT_TYPE_APP_NORMAL,
						ACCOUNT_TYPE_APP_AUTH,
						ACCOUNT_TYPE_WXAPP_WORK,
					),
					'icon' => 'wi wi-fans',
					'permission_name' => 'wxapp_member',
				)
			),
		),
		'wxapp_profile' => array(
			'title' => '配置',
			'menu' => array(
				'wxapp_module_link' => array(
					'title' => "数据同步",
					'url' => url('wxapp/module-link-uniacid'),
					'is_display' => array(
						ACCOUNT_TYPE_APP_NORMAL,
						ACCOUNT_TYPE_APP_AUTH,
						ACCOUNT_TYPE_WXAPP_WORK,
					),
					'icon' => 'wi wi-data-synchro',
					'permission_name' => 'wxapp_module_link_uniacid',
				),
				'wxapp_payment' => array(
					'title' => '支付参数',
					'url' => url('wxapp/payment'),
					'is_display' => array(
						ACCOUNT_TYPE_APP_NORMAL,
						ACCOUNT_TYPE_APP_AUTH,
						ACCOUNT_TYPE_WXAPP_WORK,
					),
					'icon' => 'wi wi-appsetting',
					'permission_name' => 'wxapp_payment',
				),
				'front_download' => array(
					'title' => '上传微信审核',
					'url' => url('wxapp/front-download'),
					'is_display' => 1,
					'icon' => 'wi wi-examine',
					'permission_name' => 'wxapp_front_download',
				),
				'parameter_setting' => array(
					'title' => '参数配置',
					'url' => url('profile/remote'),
					'is_display' => array(
						ACCOUNT_TYPE_APP_NORMAL,
						ACCOUNT_TYPE_APP_AUTH,
						ACCOUNT_TYPE_WXAPP_WORK,
					),
					'icon' => 'wi wi-parameter-setting',
					'permission_name' => 'wxapp_setting',
				),
				'wxapp_platform_material' => array(
					'title' => '素材管理',
					'is_display' => 0,
					'permission_name' => 'wxapp_platform_material',
					'sub_permission' => array(
						array(
							'title' => '删除',
							'permission_name' => 'wxapp_platform_material_delete',
						),
					),
				),
			)
		),
		
		'statistics' => array(
			'title' => '统计',
			'menu' => array(
				'statistics_fans' => array(
					'title' => '访问统计',
					'url' => url('wxapp/statistics'),
					'icon' => 'wi wi-statistical',
					'permission_name' => 'statistics_fans',
					'is_display' => array(
						ACCOUNT_TYPE_APP_NORMAL,
						ACCOUNT_TYPE_APP_AUTH,
						ACCOUNT_TYPE_WXAPP_WORK,
					),
				),
			),
		),
		
	),
);

$we7_system_menu['webapp'] = array(
	'title' => 'PC',
	'icon' => 'wi wi-pc',
	'url' => url('webapp/home/display'),
	'section' => array(
		'platform_module' => array(
			'title' => '应用模块',
			'menu' => array(),
			'is_display' => true,
		),
		'mc' => array(
			'title' => '粉丝',
			'menu' => array(
				'mc_member' => array(
					'title' => '会员管理',
					'url' => url('mc/member'),
					'icon' => 'wi wi-fans',
					'permission_name' => 'mc_member',
				)
			),
		),
		'webapp' => array(
			'title' => '配置',
			'menu' => array(
				'webapp_module_link' => array(
					'title' => "数据同步",
					'url' => url('webapp/module-link-uniacid'),
					'is_display' => 1,
					'icon' => 'wi wi-data-synchro',
					'permission_name' => 'webapp_module_link_uniacid',
				),
				'webapp_rewrite' => array(
					'title' => '伪静态',
					'url' => url('webapp/rewrite'),
					'icon' => 'wi wi-rewrite',
					'permission_name' => 'webapp_rewrite',
				),
				
				'webapp_bind_domain' => array(
					'title' => '域名访问设置',
					'url' => url('webapp/bind-domain'),
					'icon' => 'wi wi-bind-domain',
					'permission_name' => 'webapp_bind_domain',
				),
				
			),
		),
		
		'statistics' => array(
			'title' => '统计',
			'menu' => array(
				'statistics_app' => array(
					'title' => '访问统计',
					'url' => url('statistics/app'),
					'icon' => 'wi wi-statistical',
					'permission_name' => 'statistics_app',
					'is_display' => array(
						ACCOUNT_TYPE_WEBAPP_NORMAL,
					),
				),
			),
		),
		
	),
);

$we7_system_menu['phoneapp'] = array(
	'title' => 'APP',
	'icon' => 'wi wi-white-collar',
	'url' => url('phoneapp/display/home'),
	'section' => array(
		'platform_module' => array(
			'title' => '应用',
			'menu' => array(),
			'is_display' => true,
		),
		'phoneapp_profile' => array(
			'title' => '配置',
			'menu' => array(
				'front_download' => array(
					'title' => '下载APP',
					'url' => url('phoneapp/front-download'),
					'is_display' => 1,
					'icon' => 'wi wi-examine',
					'permission_name' => 'phoneapp_front_download',
				)
			)
		)
	),
);

$we7_system_menu['xzapp'] = array(
	'title' => '熊掌号',
	'icon' => 'wi wi-white-collar',
	'url' => url('xzapp/home/display'),
	'section' => array(
		'platform_module' => array(
			'title' => '应用模块',
			'menu' => array(),
			'is_display' => true,
		),
	),
);
$we7_system_menu['aliapp'] = array(
	'title' => '支付宝小程序',
	'icon' => 'wi wi-white-collar',
	'url' => url('miniapp/display/home'),
	'section' => array(
		'platform_module' => array(
			'title' => '应用',
			'menu' => array(),
			'is_display' => true,
		),
	),
);

$we7_system_menu['module'] = array(
	'title' => '应用',
	'icon' => 'wi wi-apply',
	'url' => url('module/display'),
	'section' => array(),
);

$we7_system_menu['system'] = array(
	'title' => '系统',
	'icon' => 'wi wi-setting',
	'url' => url('home/welcome/system'),
	'section' => array(
	

	
		'wxplatform' => array(
			'title' => '公众号',
			'menu' => array(
				'system_account' => array(
					'title' => ' 微信公众号',
					'url' => url('account/manage', array('account_type' => '1')),
					'icon' => 'wi wi-wechat',
					'permission_name' => 'system_account',
					'sub_permission' => array(
						array(
							'title' => '公众号管理设置',
							'permission_name' => 'system_account_manage',
						),
						array(
							'title' => '添加公众号',
							'permission_name' => 'system_account_post',
						),
						array(
							'title' => '公众号停用',
							'permission_name' => 'system_account_stop',
						),
						array(
							'title' => '公众号回收站',
							'permission_name' => 'system_account_recycle',
						),
						array(
							'title' => '公众号删除',
							'permission_name' => 'system_account_delete',
						),
						array(
							'title' => '公众号恢复',
							'permission_name' => 'system_account_recover',
						),
					),
				),
				'system_module' => array(
					'title' => '公众号应用',
					'url' => url('module/manage-system', array('support' => MODULE_SUPPORT_ACCOUNT_NAME)),
					'icon' => 'wi wi-wx-apply',
					'permission_name' => 'system_module',
				),
				'system_template' => array(
					'title' => '微官网模板',
					'url' => url('system/template'),
					'icon' => 'wi wi-wx-template',
					'permission_name' => 'system_template',
				),
				'system_platform' => array(
					'title' => ' 微信开放平台',
					'url' => url('system/platform'),
					'icon' => 'wi wi-exploitsetting',
					'permission_name' => 'system_platform',
				),
			)
		),
		'module' => array(
			'title' => '小程序',
			'menu' => array(
				'system_wxapp' => array(
					'title' => '微信小程序',
					'url' => url('account/manage', array('account_type' => '4')),
					'icon' => 'wi wi-wxapp',
					'permission_name' => 'system_wxapp',
					'sub_permission' => array(
						array(
							'title' => '小程序管理设置',
							'permission_name' => 'system_wxapp_manage',
						),
						array(
							'title' => '添加小程序',
							'permission_name' => 'system_wxapp_post',
						),
						array(
							'title' => '小程序停用',
							'permission_name' => 'system_wxapp_stop',
						),
						array(
							'title' => '小程序回收站',
							'permission_name' => 'system_wxapp_recycle',
						),
						array(
							'title' => '小程序删除',
							'permission_name' => 'system_wxapp_delete',
						),
						array(
							'title' => '小程序恢复',
							'permission_name' => 'system_wxapp_recover',
						),
					),
				),
				'system_module_wxapp' => array(
					'title' => '小程序应用',
					'url' => url('module/manage-system', array('support' => MODULE_SUPPORT_WXAPP_NAME)),
					'icon' => 'wi wi-wxapp-apply',
					'permission_name' => 'system_module_wxapp',
				),
			)
		),
		
		'welcome' => array(
			'title' => '系统首页',
			'menu' => array(
				'system_welcome' => array(
					'title' => '系统首页应用',
					'url' => url('module/manage-system', array('support' => MODULE_SUPPORT_SYSTEMWELCOME_NAME)),
					'icon' => 'wi wi-wxapp',
					'permission_name' => 'system_welcome',
				)
			),
			'founder' => true
		),
		
		'webapp' => array(
			'title' => 'PC',
			'menu' => array(
				'system_webapp' => array(
					'title' => 'PC',
					'url' => url('account/manage', array('account_type' => ACCOUNT_TYPE_WEBAPP_NORMAL)),
					'icon' => 'wi wi-pc',
					'permission_name' => 'system_webapp',
					'sub_permission' => array(
					),
				),
				'system_module_webapp' => array(
					'title' => 'PC应用',
					'url' => url('module/manage-system', array('support' => MODULE_SUPPORT_WEBAPP_NAME)),
					'icon' => 'wi wi-pc-apply',
					'permission_name' => 'system_module_webapp',
				),
			)
		),
		'phoneapp' => array(
			'title' => 'APP',
			'menu' => array(
				'system_phoneapp' => array(
					'title' => 'APP',
					'url' => url('account/manage', array('account_type' => ACCOUNT_TYPE_PHONEAPP_NORMAL)),
					'icon' => 'wi wi-app',
					'permission_name' => 'system_phoneapp',
					'sub_permission' => array(
					),
				),
				'system_module_phoneapp' => array(
					'title' => 'APP应用',
					'url' => url('module/manage-system', array('support' => MODULE_SUPPORT_PHONEAPP_NAME)),
					'icon' => 'wi wi-app-apply',
					'permission_name' => 'system_module_phoneapp',
				),
			)
		),
		'xzapp' => array(
			'title' => '熊掌号',
			'menu' => array(
				'system_xzapp' => array(
					'title' => '熊掌号',
					'url' => url('account/manage', array('account_type' => ACCOUNT_TYPE_XZAPP_NORMAL)),
					'icon' => 'wi wi-xzapp',
					'permission_name' => 'system_xzapp',
					'sub_permission' => array(
					),
				),
				'system_module_xzapp' => array(
					'title' => '熊掌号应用',
					'url' => url('module/manage-system', array('support' => MODULE_SUPPORT_XZAPP_NAME)),
					'icon' => 'wi wi-xzapp-apply',
					'permission_name' => 'system_module_xzapp',
				),
			)
		),
		'aliapp' => array(
			'title' => '支付宝小程序',
			'menu' => array(
				'system_aliapp' => array(
					'title' => '支付宝小程序',
					'url' => url('account/manage', array('account_type' => ACCOUNT_TYPE_ALIAPP_NORMAL)),
					'icon' => 'wi wi-aliapp',
					'permission_name' => 'system_aliapp',
					'sub_permission' => array(
					),
				),
				'system_module_aliapp' => array(
					'title' => '支付宝小程序应用',
					'url' => url('module/manage-system', array('support' => MODULE_SUPPORT_ALIAPP_NAME)),
					'icon' => 'wi wi-aliapp-apply',
					'permission_name' => 'system_module_aliapp',
				),
			)
		),
		'user' => array(
			'title' => '帐户/用户',
			'menu' => array(
				'system_my' => array(
					'title' => '我的帐户',
					'url' => url('user/profile'),
					'icon' => 'wi wi-user',
					'permission_name' => 'system_my',
				),
				'system_user' => array(
					'title' => '用户管理',
					'url' => url('user/display'),
					'icon' => 'wi wi-user-group',
					'permission_name' => 'system_user',
					'sub_permission' => array(
						array(
							'title' => '编辑用户',
							'permission_name' => 'system_user_post',
						),
						array(
							'title' => '审核用户',
							'permission_name' => 'system_user_check',
						),
						array(
							'title' => '店员管理',
							'permission_name' => 'system_user_clerk',
						),
						array(
							'title' => '用户回收站',
							'permission_name' => 'system_user_recycle',
						),
						array(
							'title' => '用户属性设置',
							'permission_name' => 'system_user_fields',
						),
						array(
							'title' => '用户属性设置-编辑字段',
							'permission_name' => 'system_user_fields_post',
						),
						array(
							'title' => '用户注册设置',
							'permission_name' => 'system_user_registerset',
						),
					),
				),
				
				'system_user_founder_group' => array(
					'title' => '副创始人组',
					'url' => url('founder/display'),
					'icon' =>'wi wi-co-founder',
					'permission_name' =>'system_founder_manage',
					'sub_permission' => array(
						array(
							'title' => '添加创始人组',
							'permission_name' => 'system_founder_group_add',
						),
						array(
							'title' => '编辑创始人组',
							'permission_name' => 'system_founder_group_post',
						),
						array(
							'title' => '删除创始人组',
							'permission_name' => 'system_founder_group_del',
						),
						array(
							'title' => '添加创始人',
							'permission_name' => 'system_founder_user_add',
						),
						array(
							'title' => '编辑创始人',
							'permission_name' => 'system_founder_user_post',
						),
						array(
							'title' => '删除创始人',
							'permission_name' => 'system_founder_user_del',
						),
					),
				),
				
			)
		),
		'permission' => array(
			'title' => '权限管理',
			'menu' => array(
				'system_module_group' => array(
					'title' => '应用权限组',
					'url' => url('module/group'),
					'icon' => 'wi wi-appjurisdiction',
					'permission_name' => 'system_module_group',
					'sub_permission' => array(
						array(
							'title' => '添加应用权限组',
							'permission_name' => 'system_module_group_add',
						),
						array(
							'title' => '编辑应用权限组',
							'permission_name' => 'system_module_group_post',
						),
						array(
							'title' => '删除应用权限组',
							'permission_name' => 'system_module_group_del',
						),
					),
				),
				'system_user_group' => array(
					'title' => '用户权限组',
					'url' => url('user/group'),
					'icon' => 'wi wi-userjurisdiction',
					'permission_name' => 'system_user_group',
					'sub_permission' => array(
						array(
							'title' => '添加用户组',
							'permission_name' => 'system_user_group_add',
						),
						array(
							'title' => '编辑用户组',
							'permission_name' => 'system_user_group_post',
						),
						array(
							'title' => '删除用户组',
							'permission_name' => 'system_user_group_del',
						),
					),
				),
			)
		),
		'article' => array(
			'title' => '文章/公告',
			'menu' => array(
				'system_article' => array(
					'title' => '文章管理',
					'url' => url('article/news'),
					'icon' => 'wi wi-article',
					'permission_name' => 'system_article_news',
				),
				'system_article_notice' => array(
					'title' => '公告管理',
					'url' => url('article/notice'),
					'icon' => 'wi wi-notice',
					'permission_name' => 'system_article_notice',
				)
			)
		),
		'message' => array(
			'title' => '消息提醒',
			'menu' => array(
				'system_message_notice' => array(
					'title' => '消息提醒',
					'url' => url('message/notice'),
					'icon' => 'wi wi-bell',
					'permission_name' => 'system_message_notice',
				)
			)
		),
		
		'system_statistics' => array(
			'title' => '统计',
			'menu' => array(
				'system_account_analysis' => array(
					'title' => 	'访问统计',
					'url' => url('statistics/account'),
					'icon' => 'wi wi-statistical',
					'permission_name' => 'system_account_analysis',
				),
			)
		),
		
		'cache' => array(
			'title' => '缓存',
			'menu' => array(
				'system_setting_updatecache' => array(
					'title' => '更新缓存',
					'url' => url('system/updatecache'),
					'icon' => 'wi wi-update',
					'permission_name' => 'system_setting_updatecache',
				),
			),
		),
	),
);

$we7_system_menu['site'] = array(
	'title' => '站点',
	'icon' => 'wi wi-system-site',
	'url' => url('system/site'),
	'section' => array(
		
		'setting' => array(
			'title' => '设置',
			'menu' => array(
				'system_setting_site' => array(
					'title' => '站点设置',
					'url' => url('system/site'),
					'icon' => 'wi wi-site-setting',
					'permission_name' => 'system_setting_site',
				),
				'system_setting_menu' => array(
					'title' => '菜单设置',
					'url' => url('system/menu'),
					'icon' => 'wi wi-menu-setting',
					'permission_name' => 'system_setting_menu',
				),
				'system_setting_attachment' => array(
					'title' => '附件设置',
					'url' => url('system/attachment'),
					'icon' => 'wi wi-attachment',
					'permission_name' => 'system_setting_attachment',
				),
				'system_setting_systeminfo' => array(
					'title' => '系统信息',
					'url' => url('system/systeminfo'),
					'icon' => 'wi wi-system-info',
					'permission_name' => 'system_setting_systeminfo',
				),
				'system_setting_logs' => array(
					'title' => '查看日志',
					'url' => url('system/logs'),
					'icon' => 'wi wi-log',
					'permission_name' => 'system_setting_logs',
				),
				'system_setting_ipwhitelist' => array(
					'title' => 'IP白名单',
					'url' => url('system/ipwhitelist'),
					'icon' => 'wi wi-ip',
					'permission_name' => 'system_setting_ipwhitelist',
				),
				'system_setting_sensitiveword' => array(
					'title' => '过滤敏感词',
					'url' => url('system/sensitiveword'),
					'icon' => 'wi wi-sensitive',
					'permission_name' => 'system_setting_sensitiveword',
				),
				'system_setting_thirdlogin' => array(
					'title' => '用户登录/注册设置',
					'url' => url('user/registerset'),
					'icon' => 'wi wi-user',
					'permission_name' => 'system_setting_thirdlogin',
				),
				'system_setting_oauth' => array(
					'title' => 'oauth全局设置',
					'url' => url('system/oauth'),
					'icon' => 'wi wi-oauth',
					'permission_name' => 'system_setting_oauth',
				),
			)
		),
		'utility' => array(
			'title' => '常用工具',
			'menu' => array(
				'system_utility_filecheck' => array(
					'title' => '系统文件校验',
					'url' => url('system/filecheck'),
					'icon' => 'wi wi-file',
					'permission_name' => 'system_utility_filecheck',
				),
				'system_utility_optimize' => array(
					'title' => '性能优化',
					'url' => url('system/optimize'),
					'icon' => 'wi wi-optimize',
					'permission_name' => 'system_utility_optimize',
				),
				'system_utility_database' => array(
					'title' => '数据库',
					'url' => url('system/database'),
					'icon' => 'wi wi-sql',
					'permission_name' => 'system_utility_database',
				),
				'system_utility_scan' => array(
					'title' => '木马查杀',
					'url' => url('system/scan'),
					'icon' => 'wi wi-safety',
					'permission_name' => 'system_utility_scan',
				),
				'system_utility_bom' => array(
					'title' => '检测文件BOM',
					'url' => url('system/bom'),
					'icon' => 'wi wi-bom',
					'permission_name' => 'system_utility_bom',
				),
			)
		),

		'backjob'=> array(
			'title' => '后台任务',
			'menu'=> array(
				'system_job'=> array(
					'title' => '后台任务',
					'url' => url('system/job/display'),
					'icon' => 'wi wi-job',
					'permission_name' => 'system_job',
				)
			)
		)
	),
	'founder' => true,
);



$we7_system_menu['help'] = array(
	'title' => '系统帮助',
	'icon' => 'wi wi-market',
	'url' => url('help/display'),
	'section' => array(),
	'blank' => false,
);



	$we7_system_menu['store'] = array(
		'title' => '商城',
		'icon' => 'wi wi-store',
		'url' => url('home/welcome/ext', array('m' => 'store')),
		'section' => array(),
	);


return $we7_system_menu;