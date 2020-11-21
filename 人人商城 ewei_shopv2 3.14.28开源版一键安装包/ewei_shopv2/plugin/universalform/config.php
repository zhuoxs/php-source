<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}


return array(
'version' => '1.0', 
'id' => 'universalform', 
'name' => '调研报名',
'v3' => true,
	'menu'    => array(
		'title'     => '调研报名',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '模板管理', 'route' => 'temp'),
			array('title' => '分类管理', 'route' => 'category'),
			)
			)

);

?>