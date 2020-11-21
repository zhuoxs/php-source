<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'open_messikefu',
	'name'    => '万能客服',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'icon'      => 'page',
		'items'     => array(
			array('title' => '基础设置', 'route' => 'open_messikefu.set')
		)
	)
);

?>
