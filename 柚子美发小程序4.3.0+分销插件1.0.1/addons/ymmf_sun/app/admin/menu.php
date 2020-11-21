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
    13=>array(
        'title' => '门店管理',
        'controller' => '',
        'action' => 'branchslist',
        'icon' => 'fa-building',
        'items' => array(
            array('title' => '门店列表','action' => 'branchslist',),
            array('title' => '店长列表','action' => 'adminstore',),
            array('title' => '门店技师','action' => 'building',),
        )
    ),
    1=>array(
        'title' => '服务管理',
        'controller' => '',
        'action' => 'fenlei',
        'icon' => 'fa-car',
        'items' => array(
            array('title' => '服务分类','action' => 'fenlei',),
            array('title' => '服务列表','action' => 'goods',),
            array('title' => '服务添加','action' => 'goodsinfo',),
        )
    ),
    9=>array(
        'title' => '营销设置',
        'controller' => '',
        'action' => 'ygquan',
        'icon' => 'fa-gift',
        'items' => array(
            array('title' => '营销插件','action' => 'ygquan',),
            array('title' => '优惠券','action' => 'counp'),
            array('title' => '砍价','action' => 'kanjiaopen',)
        )
    ),
    2=>array(
        'title' => '订单管理',
        'controller' => '',
        'action' => 'ddgl',
        'icon' => 'fa-comment-o',
        'items' => array(
            array('title' => '服务订单列表','action' => 'ddgl',),
            array('title' => '砍价订单列表','action' => 'carcheck',),
            array('title' => '充值订单列表','action' => 'recharge',),
        )
    ),
    4=>array(
        'title' => '财务管理',
        'controller' => 'Finance',
        'action' => 'withdrawset',
        'icon' => 'fa-bank',
        'items' => array(
            array('title' => '提现设置','action' => 'withdrawset',),
            array('title' => '提现列表','action' => 'withdraw',),
            array('title' => '商家资金明细','action' => 'mercapdetails',),
//            array('title' => '线下付款设置','action' => 'offlinepay',)
        )
    ),
    10=>array(
        'title' => '充值管理',
        'controller' => '',
        'action' => 'txsz',
        'icon' => 'fa-money',
        'items' => array(
            array('title' => '充值优惠','action' => 'txsz',),
        )
    ),
    3=>array(
        'title' => '会员管理',
        'controller' => '',
        'action' => 'vipmanage',
        'icon' => 'fa-gift',
        'items' => array(
            array('title' => '会员等级','action' => 'vipmanage',),
            array('title' => '会员设置','action' => 'vipopen',)
        )
    ),
    11=>array(
        'title' => '访客管理',
        'controller' => '',
        'action' => 'user2',
        'icon' => 'fa-user',
        'items' => array(
            array('title' => '访客列表','action' => 'user2',)
        )
    ),
    5=>array(
        'title' => '公告管理',
        'controller' => '',
        'action' => 'news',
        'icon' => 'fa-bell',
        'items' => array(
            array('title' => '公告列表','action' => 'news',)
        )
    ),
    7=>array(
        'title' => '广告管理',
        'controller' => '',
        'action' => 'banner',
        'icon' => 'fa-cart-plus',
        'items' => array(
            array('title' => '首页轮播图','action' => 'banner',),
            array('title' => '砍价轮播图','action' => 'kanjia_banner',),
            array('title' => '首页弹窗','action' => 'winindex',),
            array('title' => '海报背景图','action' => 'hbbg',)
        )
    ),
    12=>array(
        'title' => '系统设置',
        'controller' => '',
        'action' => 'settings',
        'icon' => 'fa-cog',
        'items' => array(
            array('title' => '基本信息','action' => 'settings',),
            array('title' => '小程序配置','action' => 'peiz',),
            array('title' => '手机端账号','action' => 'addaccount',),
            array('title' => '首页营销导航','action' => 'nav',),
            array('title' => '底部TAB','action' => 'tabbar',),
            array('title' => '云推送','action' => 'qituisetting',"controller"=>"settings"),
            array('title' => '短信配置','action' => 'sms',),
            array('title' => '模板消息','action' => 'templates',),
            array('title' => '打印配置','action' => 'printing',),
            array('title' => '腾讯地图key','action' => 'copyright',)
        )
    ),
);