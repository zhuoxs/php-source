<?php

echo '
';

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'sns',
	'name'    => '人人社区',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '幻灯片管理', 'route' => 'adv'),
			array('title' => '等级管理', 'route' => 'level'),
			array(
				'title' => '社区管理',
				'items' => array(
					array('title' => '分类管理', 'route' => 'category'),
					array('title' => '板块管理', 'route' => 'board'),
					array('title' => '版主管理', 'route' => 'manage'),
					array('title' => '会员管理', 'route' => 'member')
				)
			),
			array(
				'title' => '话题管理',
				'items' => array(
					array('title' => '话题管理', 'route' => 'posts'),
					array('title' => '评论管理', 'route' => 'replys')
				)
			),
			array(
				'title' => '投诉管理',
				'route' => 'complain',
				'items' => array(
					array('title' => '投诉类别', 'route' => 'category'),
					array(
						'title' => '待审核',
						'param' => array('type' => 'untreated')
					),
					array(
						'title' => '未通过',
						'param' => array('type' => 'cancel')
					),
					array(
						'title' => '已审核',
						'param' => array('type' => 'processed')
					),
					array(
						'title' => '已删除',
						'param' => array('type' => 'deleted')
					),
					array(
						'title' => '全部投诉',
						'param' => array('type' => '')
					)
				)
			),
			array(
				'title' => '基础设置',
				'items' => array(
					array('title' => '入口设置', 'route' => 'cover'),
					array('title' => '通知设置', 'route' => 'notice'),
					array('title' => '基础设置', 'route' => 'set')
				)
			)
		)
	)
);

?>
