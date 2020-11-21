<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Refund_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_GPC;
		global $_W;
		$page = intval($_GPC['page']);
		$page = max(1, $page);
		$psize = 50;
		$ps = $psize * ($page - 1);
		$likeCondition = '';
		$keyword = $_GPC['keyword'];

		if ($keyword) {
			$likeCondition = 'and ordersn like \'%' . $_GPC['keyword'] . '%\'';
		}

		$limit = ' ORDER BY id DESC LIMIT ' . $ps . ',' . $psize;
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_address_applyfor') . ' WHERE uniacid = :uniacid ' . $likeCondition . $limit;
		$record = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));

		foreach ($record as $key => $value) {
			$record[$key]['data'] = iunserializer($value['data']);
		}

		$countsql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_address_applyfor') . ' WHERE uniacid = :uniacid ' . $likeCondition;
		$count = pdo_fetchcolumn($countsql, array(':uniacid' => $_W['uniacid']));
		$pager = pagination2($count, $page, $psize);
		include $this->template('cycelbuy/refund/main');
	}

	public function detail()
	{
		global $_GPC;
		global $_W;
		$id = $_GPC['id'];
		$data = pdo_get('ewei_shop_address_applyfor', array('id' => $id));
		$data['data'] = iunserializer($data['data']);

		if (empty($data['data']['areas'])) {
			$data['data']['areas'] = $data['data']['province'] . ' ' . $data['data']['city'] . ' ' . $data['data']['area'];
		}

		$data['old_address'] = iunserializer($data['old_address']);
		$sql = 'select g.title,o.price,o.goodsprice,o.discountprice,o.dispatchprice,o.cycelbuy_periodic from ' . tablename('ewei_shop_order') . ' o ' . 'left join ' . tablename('ewei_shop_order_goods') . ' og on og.orderid=o.id ' . 'left join' . tablename('ewei_shop_goods') . 'g on g.id = og.goodsid ' . 'where o.id = :orderid';
		$order = pdo_fetch($sql, array(':orderid' => $data['orderid']));
		$cycelbuy_periodic = explode(',', $order['cycelbuy_periodic']);
		$order['num'] = $cycelbuy_periodic[2];
		$periods = pdo_getall('ewei_shop_cycelbuy_periods', array('orderid' => $data['orderid']));

		foreach ($periods as $k => $v) {
			$temp = iunserializer($v['address']);
			$periods[$k]['address'] = $temp['province'] . ',' . $temp['city'] . ',' . $temp['area'] . ',' . $temp['address'] . $temp['realname'] . ',' . $temp['mobile'];

			if ($v['status'] == 0) {
				$periods[$k]['status'] = '未开始';
			}
			else if ($v['status'] == 1) {
				$periods[$k]['status'] = '进行中';
			}
			else {
				$periods[$k]['status'] = '已结束';
			}

			if (empty($data['isall'])) {
				if ($v['id'] == $data['cycleid']) {
					$cycelsn = explode('_', $v['cycelsn']);
					$updateNum = $cycelsn[1];
				}
			}
		}

		include $this->template();
	}

	public function disagree()
	{
		global $_GPC;
		global $_W;
		$id = $_GPC['id'];
		$orderid = $_GPC['orderid'];
		$data = pdo_get('ewei_shop_address_applyfor', array('id' => $id));
		$data['data'] = iunserializer($data['data']);
		include $this->template();
	}

	public function save()
	{
		global $_GPC;
		global $_W;
		$id = $_GPC['id'];
		$orderid = $_GPC['orderid'];

		if (empty($orderid)) {
			show_json(0, '缺少orderid');
		}

		$order = pdo_fetch('SELECT openid FROM ' . tablename('ewei_shop_order') . ' WHERE id=:id AND uniacid=:uniacid', array(':id' => $orderid, ':uniacid' => $_W['uniacid']));
		$content = $_GPC['refundcontent'];
		$type = $_GPC['refundstatus'];

		if ($content) {
			$data['message'] = $content;
		}

		$data['isdispose'] = 1;
		$data['ispass'] = $type;
		$result = pdo_update('ewei_shop_address_applyfor', $data, array('id' => $id));
		$data = pdo_get('ewei_shop_address_applyfor', array('id' => $id));

		if ($result !== false) {
			if ($type == 1) {
				if ($data['isall'] == 0) {
					pdo_update('ewei_shop_cycelbuy_periods', array('address' => $data['data']), array('id' => $data['cycleid']));
				}
				else {
					$address = pdo_fetchall('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where orderid=:orderid and status = 0', array(':orderid' => $orderid));

					foreach ($address as $k => $v) {
						pdo_update('ewei_shop_cycelbuy_periods', array('address' => $data['data']), array('id' => $v['id']));
					}
				}

				show_json(1);
			}
			else {
				show_json(1);
			}

			$this->model->sendMessage(NULL, $data, 'TM_CYCELBUY_SELLER_ADDRESS');
			$this->model->sendMessage($order['openid'], $data, 'TM_CYCELBUY_BUYER_ADDRESS');
		}
		else {
			show_json(0, '修改失败');
		}
	}
}

?>
