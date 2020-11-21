<?php

return array(
    14=>array(
        'title' => '平台数据',
        'controller' => '',
        'action' => 'index',
        'icon' => 'fa-newspaper-o',
        'items' => array(
            array('title' => '数据展示','action' => 'index',)
        )
    ),
    1=>array(
        'title' => '商家管理',
        'controller' => '',
        'action' => 'brand',
        'icon' => 'fa-car',
        'items' => array(
            array('title' => '商家列表','action' => 'brand',),
            array('title' => '商家添加','action' => 'brandadd',),
            array('title' => '商家分类','action' => 'storecate',),
			array('title' => '商圈设置','action' => 'tradingarea',),
            array('title' => '缴费记录','action' => 'storefeelog',),
            array('title' => '店内设施','action' => 'storefacility',),
            array('title' => '入驻设置','action' => 'storeset',),
            array('title' => '入驻价格','action' => 'storeprice',)
        )
    ),
    7=>array(
        'title' => '商品管理',
        'controller' => '',
        'action' => 'goods',
        'icon' => 'fa-cart-plus',
        'items' => array(
            array('title' => '商品列表','action' => 'goods',),
            array('title' => '商品添加','action' => 'goodsinfo',),
			array('title' => '商品分类','action' => 'goodscate',),
            array('title' => '分类轮播图','action' => 'catebanner',),
			array('title' => '商品规格','action' => 'goodsattr',)
        )
    ),
    2=>array(
        'title' => '订单管理',
        'controller' => '',
        'action' => 'orderinfo',
        'icon' => 'fa-comment-o',
        'items' => array(
            array('title' => '拼团订单列表','action' => 'orderinfo',),
            array('title' => '砍价订单列表','action' => 'kjinfo',),
            array('title' => '集卡订单列表','action' => 'jkinfo',),
            array('title' => '抢购订单列表','action' => 'qginfo',),
            array('title' => '普通订单列表','action' => 'otherinfo',),
            array('title' => '免单订单列表','action' => 'hyinfo',),
            array('title' => '配送订单列表','action' => 'psinfo',),
            array('title' => '优惠券记录','action' => 'counporder',),
            array('title' => '会员卡订单','action' => 'viporder',),
			array('title' => '核销记录','action' => 'writewoffrecords',)
        )
    ),
    3=>array(
        'title' => '财务管理',
        'controller' => '',
        'action' => 'withdrawset',
        'icon' => 'fa-bank',
        'items' => array(
            array('title' => '提现设置','action' => 'withdrawset',),
            array('title' => '提现列表','action' => 'withdraw',),
            array('title' => '商家资金明细','action' => 'mercapdetails',),
            array('title' => '线下付款设置','action' => 'offlinepay',)
        )
    ),
    4=>array(
        'title' => '专题管理',
        'controller' => '',
        'action' => 'specialtopic',
        'icon' => 'fa-book',
        'items' => array(
            array('title' => '专题管理','action' => 'specialtopic',),
            array('title' => '添加专题','action' => 'addspecialtopic','op'=>'add')
        )
    ),
    5=>array(
        'title' => '好评管理',
        'controller' => '',
        'action' => 'circle',
        'icon' => 'fa-bullseye',
        'items' => array(
            array('title' => '好评管理','action' => 'circle',)
        )
    ),
    6=>array(
        'title' => '广告管理',
        'controller' => '',
        'action' => 'banner',
        'icon' => 'fa-life-ring',
        'items' => array(
            array('title' => '广告管理','action' => 'banner',),
            array('title' => 'Banner设置','action' => 'acbranner',),
            array('title' => '首页弹窗设置','action' => 'popbanner',),
            array('title' => '小程序跳转','action' => 'wxappjump',)
        )
    ),
    9=>array(
        'title' => '营销设置',
        'controller' => '',
        'action' => 'ygquan',
        'icon' => 'fa-gift',
        'items' => array(
            array('title' => '营销插件','action' => 'ygquan',),
            array('title' => '线下优惠券','action' => 'couponlist','controller' => 'coupon'),
            array('title' => '拼团活动','action' => 'collage',),
            array('title' => '集卡活动','action' => 'card',),
            array('title' => '抢购活动','action' => 'qglist',),
            array('title' => '砍价活动','action' => 'kjlist',),
            array('title' => '免单活动','action' => 'hylist',)
        )
    ),
    11=>array(
        'title' => '会员管理',
        'controller' => '',
        'action' => 'user2',
        'icon' => 'fa-user',
        'items' => array(
            array('title' => '会员列表','action' => 'user2',),
            array('title' => 'vip等级','action' => 'vip',),
            array('title' => 'vip激活码','action' => 'vipcode',),
            array('title' => '会员激活记录','action' => 'vippaylog',),
            array('title' => '会员充值卡','action' => 'rechargecard',),
            array('title' => '会员明细','action' => 'rechargelogo',),
			array('title' => '购买会员赠送','action' => 'returnorder',),
			array('title' => '会员特权图标','action' => 'vipicons',),
        )
    ),
    12=>array(
        'title' => '系统设置',
        'controller' => 'settings',
        'action' => 'settings',
        'icon' => 'fa-cog',
        'items' => array(
            array('title' => '基本信息','action' => 'settings',),
            array('title' => '小程序配置','action' => 'peiz',),
            array('title' => '黑卡设置','action' => 'rankcardset',),
            array('title' => '顶部导航管理','action' => 'tbbanner',),
            array('title' => '底部导航管理','action' => 'settab',),
            array('title' => '短信配置','action' => 'sms',),
            array('title' => '模板消息','action' => 'templates',),
            array('title' => '云推送','action' => 'qituisetting',),
            array('title' => '小程序页面','action' => 'wxapppages',),
            array('title' => '福利群设置','action' => 'welfaregroup',),
            array('title' => '前端主题','action' => 'tplset',),
            array('title' => '展示订单设置','action' => 'orderset',),
			array('title' => '区域设置','action' => 'qqmapset',),
			array('title' => '手机号授权','action' => 'opentel',),
			array('title' => '工商信息','action' => 'business',),
			array('title' => '我的页面图标','action' => 'myicon',),
        )
    ),
	13=>array(
        'title' => '插件应用',
        'controller' => 'plugins',
        'action' => 'plugin',
        'icon' => 'fa-cog',
        'items' => array(
            array('title' => '插件应用','action' => 'plugin',),
        )
    ),
	16=>array(
        'title' => '云供销',
        'controller' => 'cloud',
        'action' => 'cloud',
        'icon' => 'fa-cog',
        'items' => array(
            array('title' => '参数配置','action' => 'cloud',),
			array('title' => '挚能云商品','action' => 'cloudgoods',),
        )
    ),
);