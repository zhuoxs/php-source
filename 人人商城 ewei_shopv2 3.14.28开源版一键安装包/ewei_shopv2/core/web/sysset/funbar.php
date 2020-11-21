<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Funbar_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$list = pdo_fetch('select * from ' . tablename('ewei_shop_funbar') . ' where uid=:uid and uniacid=:uniacid limit 1', array(':uid' => $_W['uid'], ':uniacid' => $_W['uniacid']));

		if (!empty($list)) {
			$list = iunserializer($list['datas']);
		}

		if ($_W['ispost']) {
			$datas = $_GPC['datas'];

			if (!empty($datas)) {
				$datas = htmlspecialchars_decode($datas);
				$datas = json_decode($datas, true);
				$datas = iserializer($datas);

				if (empty($list)) {
					pdo_insert('ewei_shop_funbar', array('uid' => $_W['uid'], 'datas' => $datas, 'uniacid' => $_W['uniacid']));
				}
				else {
					pdo_update('ewei_shop_funbar', array('datas' => $datas), array('uid' => $_W['uid'], 'uniacid' => $_W['uniacid']));
				}
			}

			show_json(1);
		}

		include $this->template();
	}

	public function post()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = pdo_fetch('select * from ' . tablename('ewei_shop_funbar') . ' where uid=:uid and uniacid=:uniacid limit 1', array(':uid' => $_W['uid'], ':uniacid' => $_W['uniacid']));

			if (empty($data)) {
				$newdata = array();
			}
			else {
				$newdata = iunserializer($data['datas']);
			}

			if (!is_array($newdata)) {
				$newdata = array();
			}

			$newitem = is_array($_GPC['funbardata']) ? $_GPC['funbardata'] : array();
			$funbardata = array_merge(array($newitem), $newdata);
			$funbardata = iserializer($funbardata);

			if (empty($data)) {
				pdo_insert('ewei_shop_funbar', array('uid' => $_W['uid'], 'datas' => $funbardata, 'uniacid' => $_W['uniacid']));
			}
			else {
				pdo_update('ewei_shop_funbar', array('datas' => $funbardata), array('uid' => $data['uid'], 'uniacid' => $_W['uniacid']));
			}

			show_json(1);
		}
	}
}

?>
