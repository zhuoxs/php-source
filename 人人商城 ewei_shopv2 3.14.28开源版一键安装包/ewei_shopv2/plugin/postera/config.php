<?php

echo '
';

if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'postera',
	'name'    => '活动海报',
	'v3'      => true,
	'menu'    => array(
		'title'     => '页面',
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array(
				'title'   => '海报管理',
				'route'   => '',
				'extends' => array('postera.scan')
			)
		)
	)
);

?>
