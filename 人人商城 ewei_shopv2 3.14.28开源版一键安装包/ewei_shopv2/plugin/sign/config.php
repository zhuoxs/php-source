<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'sign',
	'name'    => '积分签到',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array(
				'title' => '签到设置',
				'items' => array(
					array('title' => '签到规则', 'route' => 'rule'),
					array('title' => '签到入口', 'route' => 'set')
					)
				),
			array(
				'title' => '签到记录',
				'items' => array(
					array('title' => '签到记录', 'route' => 'records')
					)
				)
			)
		)
	);

?>
