<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'goodscircle',
	'name'    => '好物圈',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '设置', 'route' => 'index')
		)
	)
);

?>
