<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'quick',
	'name'    => '快速购买',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '购买页面', 'route' => 'pages'),
			array('title' => '幻灯片设置', 'route' => 'adv')
			)
		)
	);

?>
