<?php
//tonychemeng

global $_W;

if (!defined('IN_IA')) {
	exit('Access Denied');
}

$result = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_plugin') . ' where identity=:identity', array(':identity' => 'merchmanage'));

if (empty($result)) {
	$displayorder_max = pdo_fetchcolumn('select max(displayorder) from ' . tablename('ewei_shop_plugin'));
	$displayorder = $displayorder_max + 1;
	$sql = 'INSERT INTO ' . tablename('ewei_shop_plugin') . ' (`displayorder`,`identity`,`name`,`version`,`author`,`status`,`category`) VALUES(' . $displayorder . ',\'merchmanage\',\'多商户手机端\',\'1.0\',\'tonychemeng\',\'1\',\'biz\');';
	pdo_query($sql);
}