<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'messages',
	'name'    => '消息群发',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array(
				'title'   => '消息群发',
				'route'   => '',
				'extends' => array('messages.run', 'messages.showsign')
				),
			array('title' => '模版设置', 'route' => 'template')
			)
		)
	);

?>
