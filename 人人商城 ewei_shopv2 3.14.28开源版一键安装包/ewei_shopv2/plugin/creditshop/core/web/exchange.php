<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

global $_W;
global $_GPC;
check_shop_auth('http://120.26.212.219/api.php');
$id = intval($_GPC['id']);
$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
$store = false;
$address = false;
$carrier = false;

if ($log['isverify']) {
	if (!empty($log['storeid'])) {
		$store = pdo_fetch('select id,storename,address  from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log['storeid'], ':uniacid' => $_W['uniacid']));
		$carrier = array('realname' => $row['realname'], 'mobile' => $row['mobile'], 'storename' => $store['storename'], 'address' => $store['address']);
	}
}
else {
	$address = iunserializer($log['address']);

	if (!is_array($address)) {
		$address = pdo_fetch('select realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $row['addressid'], ':uniacid' => $_W['uniacid']));
	}
}

load()->func('tpl');
include $this->template('exchange');

?>
