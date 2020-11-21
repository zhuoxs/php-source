<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}
return array('version' => '1.0', 'id' => 'merchmanage', 'v3' => true, 'name' => '多商户手机端',
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array('title' => '基本设置', 'route' => 'setting')
			)
		)
);

?>