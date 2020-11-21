<?php

return array(
    'home' => array(
        'title' => '首页',
        'subtitle' => '首页管理',
        'route' => 'home.lunbo',
        'icon' => 'fa fa-home fa-4x',
        'isplugin' => 0,
        'items' => array(
            array('title' => '轮播列表', 'route' => 'lunbo','desc' => '','icon'=>'fa fa-list-alt'),
            array('title' => '回收分类', 'route' => 'type','desc' => '','icon'=>'fa fa-list-alt'),
            array('title' => '价格说明', 'route' => 'priceList','desc' => '','icon'=>'fa fa-list-alt'),
            array('title' => '回收要求', 'route' => 'rule','desc' => '','icon'=>'fa fa-list-alt'),
            array('title' => '跳转列表', 'route' => 'pagesList','desc' => '','icon'=>'fa fa-list-alt'),
        ),
    ),

    'staff' => array(
        'title' => '车夫',
        'subtitle' => '车夫',
        'icon' => 'fa fa-truck fa-4x',
        'route' => 'staff.adminList',
        'isplugin' =>0,
        'items' => array(
            array('title' => '车夫列表', 'route' => 'adminList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '回收记录', 'route' => 'logList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        )
    ),
    'order' => array(
        'title' => '订单',
        'subtitle' => '订单管理',
        'icon' => 'fa fa-recycle fa-4x',
        'route' => 'order.orderList',
        'isplugin' =>0,
        'items' => array(
            array('title' => '单次回收', 'route' => 'orderList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '周期回收', 'route' => 'cycleList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        )
    ),
    'datas' => array(
        'title' => '统计',
        'subtitle' => '数据统计',
        'icon' => 'fa fa-bar-chart fa-4x',
        'route' => 'datas.index',
        'isplugin' =>0,
        'items' => array(
            array('title' => '数据统计', 'route' => 'index', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        )
    ),
    'take' => array(
        'title' => '提现',
        'subtitle' => '提现管理',
        'icon' => 'fa fa-jpy fa-4x',
        'route' => 'take.takeList',
        'isplugin' =>0,
        'items' => array(
            array('title' => '提现列表', 'route' => 'takeList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        )
    ),
    'member' => array(
        'title' => '会员',
        'subtitle' => '会员管理',
        'icon' => 'fa fa-ticket fa-4x',
        'route' => 'member.memberList',
        'isplugin' =>0,
        'items' => array(
            array('title' => '会员列表', 'route' => 'memberList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '黑名单', 'route' => 'blackList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        )
    ),
    'message' => array(
        'title' => '通知',
        'subtitle' => '通知管理',
        'route' => 'message.uniform',
        'icon' => 'fa fa-comments fa-4x',
        'isplugin' => 0,
        'items' => array(
            array('title' => '公众号', 'route' => 'uniform', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '小程序', 'route' => 'wxapp', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        ),
    ),
    'jifenshop' => array(
        'title' => '商城',
        'subtitle' => '积分商城',
        'route' => 'jifenshop.index',
        'icon' => 'fa fa-shopping-cart fa-4x',
        'isplugin' => 0,
        'items' => array(
            array('title' => '基础设置', 'route' => 'index', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '商品管理', 'route' => 'goodslist', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '订单管理', 'route' => 'order', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        ),
    ),
    'baseset' => array(
        'title' => '设置',
        'subtitle' => '设置',
        'route' => 'baseset.index',
        'icon' => 'fa fa-gear fa-4x',
        'isplugin' => 0,
        'items' => array(
            array('title' => '基础设置', 'route' => 'index', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '区域管理', 'route' => 'apply', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '关于我们', 'route' => 'about', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        ),
    ),



);