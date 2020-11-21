<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


$config = array(
	'version' => '1.0',
	'id'      => 'app',
	'name'    => '小程序',
	'v3'      => true,
	'menu'    => array(
		'title'     => '小程序',
		'plugincom' => 1,
		'icon'      => 'xiaochengxu',
		'iconcolor' => '#54a532',
		'items'     => array(
			array('title' => '页面设计', 'route' => 'page'),
			array('title' => '商品二维码', 'route' => 'goods'),
			array('title' => '底部导航', 'route' => 'tabbar'),
			array('title' => '小程序设置', 'route' => 'setting'),
			array('title' => '发布与审核', 'route' => 'mlrelease'),
			array('title' => '分销海报', 'route' => 'poster'),
			array('title' => '启动广告', 'route' => 'startadv'),
			array(
				'title' => '其他设置',
				'items' => array(
					array('title' => '模板消息', 'route' => 'tmessage')
					
					)
				)
			)
		)
	);
$hasSysWxapp = @is_file(IA_ROOT . '/addons/ewei_shopwxapp/wxapp.php');

if ($hasSysWxapp) {
	$config['menu']['items'][5]['items'][] = array('title' => '系统小程序', 'route' => 'syswxapp', 'perm' => 'app.setting');
}


return $config;

?>