<?php
//QQ63779278
error_reporting(0);
require '../../../../../framework/bootstrap.inc.php';
require '../../../../../addons/ewei_shopv2/defines.php';
require '../../../../../addons/ewei_shopv2/core/inc/functions.php';
global $_W;
global $_GPC;
ignore_user_abort();
set_time_limit(0);
$sets = pdo_fetchall('select uniacid from ' . tablename('ewei_shop_sysset'));

foreach ($sets as $set) {
	$_W['uniacid'] = $set['uniacid'];

	if (empty($_W['uniacid'])) {
		continue;
	}

	$goods = pdo_fetchall('select id,title,ispresell,presellover,presellovertime,presellstart,preselltimestart,presellend,preselltimeend from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $_W['uniacid'] . ' and ispresell > 0 and deleted = 0 ');

	if (!empty($goods)) {
		foreach ($goods as $key => $value) {
			if ($value['ispresell'] == 1 && $value['presellover'] == 0 && $value['presellend'] == 1) {
				if ($value['preselltimeend'] < time()) {
					$value['status'] = 0;
					pdo_update('ewei_shop_goods', array('status' => $value['status']), array('id' => $value['id']));
					plog('goods.edit', '自动修改商品状态 ID: ' . $value['id'] . '<br/>商品名称: ' . $value['title'] . '<br/> 状态:' . '预售自动下架');
				}
			}
			else {
				if ($value['ispresell'] == 1 && $value['presellover'] == 1 && $value['presellend'] == 1) {
					$time = $value['presellover'] * 86400000;

					if ($value['preselltimeend'] + $time < time()) {
						$value['status'] = 0;
						pdo_update('ewei_shop_goods', array('ispresell' => $value['status']), array('id' => $value['id']));
						plog('goods.edit', '自动修改商品状态 ID: ' . $value['id'] . '<br/>商品名称: ' . $value['title'] . '<br/> 状态:' . '预售结束');
					}
				}
			}
		}
	}
}

?>
