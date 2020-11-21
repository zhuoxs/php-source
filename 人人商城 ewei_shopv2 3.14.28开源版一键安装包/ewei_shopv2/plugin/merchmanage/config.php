<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

return array(
'version' => '1.0', 
'id' => 'merchmanage', 
'name' => '多商户手机端',
'v3' => true,
	'menu'    => array(
		'title'     => '多商户手机端',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '基础设置', 'route' => 'setting'),
			)
			)

);



?>