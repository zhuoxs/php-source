<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'mmanage',
	'name'    => '手机端管理',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array('title' => '基本设置', 'route' => 'setting')
		)
	)
);

?>
