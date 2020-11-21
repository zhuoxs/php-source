<?php
//QQ63779278
function getAccount()
{
	global $_W;
	load()->model('account');

	if (!empty($_W['acid'])) {
		return WeAccount::create($_W['acid']);
	}

	$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
	return WeAccount::create($acid);
}

error_reporting(0);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
require '../../../../../addons/ewei_shopv2/core/inc/plugin_model.php';
global $_W;
global $_GPC;
$_W['uniacid'] = $_GPC['uniacid'];
$_W['acid'] = $_GPC['acid'];
ignore_user_abort();
set_time_limit(0);
$logs = pdo_fetchall('select * from ' . tablename('ewei_shop_virtual_send_log') . ' where uniacid=:uniacid and status=0 limit 10', array(':uniacid' => $_W['uniacid']));

if ($logs) {
	foreach ($logs as $log) {
		$data = array('openid' => $log['openid'], 'tag' => $log['tag'], 'default' => unserialize($log['default']), 'cusdefault' => $log['cusdefault'], 'orderid' => $log['orderid'], 'account' => getAccount(), 'url' => $log['url'], 'datas' => unserialize($log['datas']), 'appurl' => $log['appurl']);

		if ($log['sendtime'] < time()) {
			$res = m('notice')->sendNotice($data);

			if ($res) {
				pdo_update('ewei_shop_virtual_send_log', array('status' => 1), array('id' => $log['id'], 'uniacid' => $_W['uniacid']));
			}
		}
	}
}

?>
