<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$info = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_open_plugin') . ' WHERE plugin = :plugin', array(':plugin' => 'open_messikefu'));
		$redis_key = 'open_messikefu';
		$redis = redis();
		$data = m('common')->getPluginset(array('open_messikefu'), $_W['uniacid']);

		if (!empty($data)) {
			$info['url'] = $data['open_messikefu']['url'];
		}

		$_GPC['merch'] = empty($_GPC['merch']) ? 0 : $_GPC['merch'];
		$_GPC['orderid'] = empty($_GPC['orderid']) ? 0 : $_GPC['orderid'];
		$url = $info['url'];

		if (!is_error($redis)) {
			if ($redis->get($redis_key)) {
				$url .= '&qudao=renren&goodsid=' . $_GPC['goodsid'] . '&merch=' . $_GPC['merch'] . '&orderid=' . $_GPC['orderid'];
			}
			else {
				$res = p('open_messikefu')->checkOpen($info['key'], $info['plugin'], $info['domain']);
				if ($res && $res['errno'] == -1) {
					show_json(0, $res['errmsg']);
				}

				if (!is_error($redis)) {
					if ($redis->setnx($redis_key, time())) {
						$redis->expireAt($redis_key, time() + 172800);
					}
				}

				pdo_update('ewei_shop_open_plugin', array('expirtime' => time() + 172800), array('id' => $info['id']));
			}
		}

		header('location: ' . $url);
		exit();
	}
}

?>
