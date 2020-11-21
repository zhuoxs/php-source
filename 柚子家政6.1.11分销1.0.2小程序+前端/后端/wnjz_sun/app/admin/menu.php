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
    7=>array(
        'title' => '服务管理',
        'controller' => '',
        'action' => 'goods',
        'icon' => 'fa-cart-plus',
        'items' => array(
            array('title' => '技师列表','action' => 'servies',),
            array('title' => '服务分类','action' => 'category',),
            array('title' => '服务列表','action' => 'goods',),
			array('title' => '服务添加','action' => 'goodsinfo',)
        )
    ),
    1=>array(
        'title' => '门店管理',
        'controller' => '',
        'action' => 'branchslist',
        'icon' => 'fa-comment-o',
        'items' => array(
            array('title' => '店铺管理','action' => 'branchslist',),
            array('title' => '店长管理','action' => 'adminstore',)
        )
    ),
    10=>array(
        'title' => '充值管理',
        'controller' => '',
        'action' => 'txsz',
        'icon' => 'fa-money',
        'items' => array(
            array('title' => '充值优惠','action' => 'txsz',)
        )
    ),
    2=>array(
        'title' => '订单管理',
        'controller' => '',
        'action' => 'orderinfo',
        'icon' => 'fa-book',
        'items' => array(
            array('title' => '服务订单列表','action' => 'orderinfo',),
            array('title' => '砍价订单列表','action' => 'carcheck'),
            array('title' => '充值订单列表','action' => 'recharge',),
            array('title' => '订单评价列表','action' => 'pingjia')
        )
    ),
    3=>array(
        'title' => '文章管理',
        'controller' => '',
        'action' => 'zx',
        'icon' => 'fa-book',
        'items' => array(
            array('title' => '文章管理','action' => 'zx',),
            array('title' => '分类管理','action' => 'zxtype',)
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
    9=>array(
        'title' => '营销设置',
        'controller' => '',
        'action' => 'ygquan',
        'icon' => 'fa-gift',
        'items' => array(
            array('title' => '营销插件','action' => 'ygquan',)
        )
    ),
    11=>array(
        'title' => '会员管理',
        'controller' => '',
        'action' => 'user2',
        'icon' => 'fa-user',
        'items' => array(
            array('title' => '会员列表','action' => 'user2',)
        )
    ),
    12=>array(
        'title' => '系统设置',
        'controller' => 'settings',
        'action' => 'settings',
        'icon' => 'fa-cog',
        'items' => array(
            array('title' => '基本信息','action' => 'settings',),
            array('title' => '首页轮播图','action' => 'banner',),
            array('title' => '首页弹窗','action' => 'winindex',),
            array('title' => '海报设置','action' => 'poster',),
            array('title' => '小程序配置','action' => 'peiz',),
            array('title' => '手机端账号','action' => 'addaccount',),
            array('title' => '砍价轮播图','action' => 'kanjia_banner',),
            array('title' => '云推送','action' => 'qituisetting',),
            array('title' => '模板消息','action' => 'templates',),
            array('title' => '首页导航','action' => 'nav',),
            array('title' => '底部TAB','action' => 'tabbar',),
			array('title' => '短信配置','action' => 'sms',),
			array('title' => '打印配置','action' => 'printing',),
            array('title' => '腾讯地图key','action' => 'copyright',)
        )
    ),
);
