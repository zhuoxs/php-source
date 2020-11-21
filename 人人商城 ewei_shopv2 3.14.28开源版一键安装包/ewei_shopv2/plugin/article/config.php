<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

return array(
	'version' => '1.0',
	'id'      => 'article',
	'name'    => '文章营销',
	'v3'      => true,
	'menu'    => array(
		'plugincom' => 1,
		'items'     => array(
			array(
				'title'   => '文章管理',
				'route'   => '',
				'extends' => array('article.record')
				),
			array('title' => '分类管理', 'route' => 'category'),
			array('title' => '举报记录', 'route' => 'report'),
			array('title' => '其他设置', 'route' => 'set')
			)
		)
	);

?>
