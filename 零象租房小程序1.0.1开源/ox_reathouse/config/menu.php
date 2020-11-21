<?php

return array(
    'service' => array(
        'title' => '服务',
        'subtitle' => '服务设置',
        'route' => 'service.type',
        'icon' => 'fa fa-life-ring fa-4x',
        'isplugin' => 0,
        'items' => array(

            array('title' => '服务列表', 'route' => 'type','desc' => '','icon'=>'fa fa-list-alt'),
            array('title' => '添加服务', 'route' => 'type_add','desc' => '','icon'=>'fa fa-list-alt'),
        ),
    ),

    'repairman' => array(
        'title' => '师傅',
        'subtitle' => '师傅',
        'icon' => 'fa fa-users fa-3x',
        'route' => 'repairman.memberList',
        'isplugin' =>0,
        'items' => array(
            array('title' => '师傅列表', 'route' => 'memberList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        )
    ),
    'order' => array(
        'title' => '订单',
        'subtitle' => '设置',
        'route' => 'order.integral.index',
        'icon' => 'fa fa-clipboard fa-3x',
        'isplugin' => 0,
        'items' => array(
            array('title' => '积分订单', 'route' => 'integral.index', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '商品订单', 'route' => 'order.index', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '应用订单', 'route' => 'apply.index', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        ),
    ),

    'member' => array(
        'title' => '会员',
        'subtitle' => '会员',
        'route' => 'member.memberList',
        'icon' => 'fa fa-user fa-3x',
        'isplugin' => 0,
        'items' => array(

            array('title' => '会员列表', 'route' => 'memberList', 'desc' => '', 'icon' => 'fa fa-list-alt'),

        ),
    ),
    'marketing' => array(
        'title' => '推广',
        'subtitle' => '设置',
        'route' => 'marketing.memberList',
        'icon' => 'fa fa-gift fa-4x',
        'isplugin' => 0,
        'items' => array(
            array('title' => '推广员', 'route' => 'memberList', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        ),
    ),
    'data' => array(
        'title' => '数据',
        'subtitle' => '设置',
        'route' => 'data.home',
        'icon' => 'fa fa-pie-chart fa-3x',
        'isplugin' => 0,
        'items' => array(
             array('title' => '概况', 'route' => 'home', 'desc' => '', 'icon' => 'fa fa-list-alt'),

        ),
    ),
    'baseset' => array(
        'title' => '设置',
        'subtitle' => '设置',
        'route' => 'baseset.index',
        'icon' => 'fa fa-gear fa-3x',
        'isplugin' => 0,
        'items' => array(
            array('title' => '基础设置', 'route' => 'index', 'desc' => '', 'icon' => 'fa fa-list-alt'),
            array('title' => '消息模板', 'route' => 'message', 'desc' => '', 'icon' => 'fa fa-list-alt'),
        ),
    ),



);