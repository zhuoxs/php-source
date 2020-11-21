<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'membercard',
	'name'    => '会员卡',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '会员卡管理', 'route' => 'cardmanage'),
			array('title' => '领取记录', 'route' => 'getrecord'),
			array('title' => '删除记录', 'route' => 'delrecord')
		)
	)
);

?>
