<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cycelbuy/core/page_mobile.php';
class List_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$trade = m('common')->getSysset('trade');
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		include $this->template('cycelbuy/order/main');
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 50;
		$show_status = $_GPC['status'];
		$r_type = array('退款', '退货退款', '换货');
		$condition = ' and openid=:openid and ismr=0 and deleted=0 and uniacid=:uniacid and istrade=0 ';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$condition .= ' and merchshow=0 ';

		if ($show_status != '') {
			$show_status = intval($show_status);

			switch ($show_status) {
			case 0:
				$condition .= ' and status=0 and paytype<>3';
				break;

			case 1:
				$condition .= ' and (status=1 or (status=0 and paytype=3))';
				break;

			case 2:
				$condition .= ' and (status=2 or (status=1 and sendtype>0))';
				break;

			case 4:
				$condition .= ' and refundstate>0';
				break;

			case 5:
				$condition .= ' and userdeleted=1 ';
				break;

			default:
				$condition .= ' and status=' . intval($show_status);
			}

			if ($show_status != 5) {
				$condition .= ' and userdeleted=0 ';
			}
		}
		else {
			$condition .= ' and userdeleted=0 ';
		}

		$condition .= 'and iscycelbuy = 1';
		$com_verify = com('verify');
		$s_string = '';
		$list = pdo_fetchall('select id,addressid,ordersn,price,dispatchprice,status,iscomment,isverify,verifyendtime,
verified,verifycode,verifytype,iscomment,refundid,expresscom,express,expresssn,finishtime,`virtual`,sendtype,
paytype,expresssn,refundstate,dispatchtype,verifyinfo,merchid,isparent,iscycelbuy,cycelbuy_periodic,userdeleted' . $s_string . '
 from ' . tablename('ewei_shop_order') . (' where 1 ' . $condition . ' order by createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . (' where 1 ' . $condition), $params);
		$refunddays = intval($_W['shopset']['trade']['refunddays']);

		foreach ($list as &$row) {
			$param = array();

			if ($row['isparent'] == 1) {
				$scondition = ' og.parentorderid=:parentorderid';
				$param[':parentorderid'] = $row['id'];
			}
			else {
				$scondition = ' og.orderid=:orderid';
				$param[':orderid'] = $row['id'];
			}

			$sql = 'SELECT og.goodsid,og.total,g.title,g.thumb,g.status,og.price,og.optionname as optiontitle,og.optionid,op.specs,g.merchid,og.seckill,og.seckill_taskid,
                og.sendtype,og.expresscom,og.expresssn,og.express,og.sendtime,og.finishtime,og.remarksend
                FROM ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . (' where ' . $scondition . ' order by og.id asc');
			$goods = pdo_fetchall($sql, $param);
			$ismerch = 0;
			$merch_array = array();

			foreach ($goods as &$r) {
				$r['seckilltask'] = false;

				if ($r['seckill']) {
					$r['seckill_task'] = plugin_run('seckill::getTaskInfo', $r['seckill_taskid']);
				}

				$merchid = $r['merchid'];
				$merch_array[$merchid] = $merchid;

				if (!empty($r['specs'])) {
					$thumb = m('goods')->getSpecThumb($r['specs']);

					if (!empty($thumb)) {
						$r['thumb'] = $thumb;
					}
				}
			}

			unset($r);

			if (!empty($merch_array)) {
				if (1 < count($merch_array)) {
					$ismerch = 1;
				}
			}

			$goods = set_medias($goods, 'thumb');

			if (empty($goods)) {
				$goods = array();
			}

			foreach ($goods as &$r) {
				$r['thumb'] .= '?t=' . random(50);
			}

			unset($r);
			$goods_list = array();
			$goods_list[0]['shopname'] = $_W['shopset']['shop']['name'];
			$goods_list[0]['goods'] = $goods;
			$row['goods'] = $goods_list;
			$row['goods_num'] = count($goods);
			list(, , $row['phaseNum']) = explode(',', $row['cycelbuy_periodic']);
			$statuscss = 'text-cancel';

			switch ($row['status']) {
			case '-1':
				$status = '已取消';
				break;

			case '0':
				if ($row['paytype'] == 3) {
					$status = '待发货';
				}
				else {
					$status = '待付款';
				}

				$statuscss = 'text-cancel';
				break;

			case '1':
				if ($row['isverify'] == 1) {
					$status = '使用中';
					if (0 < $row['verifyendtime'] && $row['verifyendtime'] < time()) {
						$row['status'] = -1;
						$status = '已过期';
					}
				}
				else if (empty($row['addressid'])) {
					if (!empty($row['ccard'])) {
						$status = '充值中';
					}
					else {
						$status = '待取货';
					}
				}
				else {
					$status = '待发货';

					if (0 < $row['sendtype']) {
						$status = '部分发货';
					}
				}

				$statuscss = 'text-warning';
				break;

			case '2':
				$status = '待收货';
				$statuscss = 'text-danger';
				break;

			case '3':
				if (empty($row['iscomment'])) {
					if ($show_status == 5) {
						$status = '已完成';
					}
					else {
						$status = empty($_W['shopset']['trade']['closecomment']) ? '待评价' : '已完成';
					}
				}
				else {
					$status = '交易完成';
				}

				$statuscss = 'text-success';
				break;
			}

			$row['statusstr'] = $status;
			$row['statuscss'] = $statuscss;
			if (0 < $row['refundstate'] && !empty($row['refundid'])) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $row['refundid'], ':uniacid' => $uniacid, ':orderid' => $row['id']));

				if (!empty($refund)) {
					$row['statusstr'] = '待' . $r_type[$refund['rtype']];
				}
			}

			$canrefund = false;
			$row['canrefund'] = $canrefund;
			$row['canverify'] = false;
			$canverify = false;

			if ($com_verify) {
				$showverify = $row['dispatchtype'] || $row['isverify'];

				if ($row['isverify']) {
					if ($row['verifytype'] == 0 || $row['verifytype'] == 1 || $row['verifytype'] == 3) {
						$vs = iunserializer($row['verifyinfo']);
						$verifyinfo = array(
							array('verifycode' => $row['verifycode'], 'verified' => $row['verifytype'] == 0 ? $row['verified'] : $row['goods'][0]['goods']['total'] <= count($vs))
							);
						if ($row['verifytype'] == 0 || $row['verifytype'] == 3) {
							$canverify = empty($row['verified']) && $showverify;
						}
						else {
							if ($row['verifytype'] == 1) {
								$canverify = count($vs) < $row['goods'][0]['goods']['total'] && $showverify;
							}
						}
					}
					else {
						$verifyinfo = iunserializer($row['verifyinfo']);
						$last = 0;

						foreach ($verifyinfo as $v) {
							if (!$v['verified']) {
								++$last;
							}
						}

						$canverify = 0 < $last && $showverify;
					}
				}
				else {
					if (!empty($row['dispatchtype'])) {
						$canverify = $row['status'] == 1 && $showverify;
					}
				}
			}

			$row['canverify'] = $canverify;
		}

		unset($row);
		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function address()
	{
		global $_W;
		global $_GPC;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$show_data = 1;
		$applyforid = intval($_GPC['applyforid']);
		$orderid = intval($_GPC['orderid']);

		if (!empty($orderid)) {
			$address = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where id = :id and orderid=:orderid and status = 0', array(':orderid' => $orderid, ':id' => intval($_GPC['id'])));
			$address = iunserializer($address['address']);
		}

		if (!empty($applyforid)) {
			$new_address = pdo_fetch('select * from ' . tablename('ewei_shop_address_applyfor') . ' where cycleid = :cycleid and isdelete = 0 order by createtime desc limit 1', array(':cycleid' => intval($_GPC['id'])));

			if (!empty($new_address)) {
				$data = iunserializer($new_address['data']);
				$address = array_merge($new_address, $data);
			}
		}

		if (!empty($new_area) && empty($address['datavalue']) || empty($new_area) && !empty($address['datavalue'])) {
			$show_data = 0;
		}

		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$applyid = intval($_GPC['applyid']);
		$orderid = intval($_GPC['orderid']);
		$order = pdo_fetch('SELECT openid,ordersn FROM ' . tablename('ewei_shop_order') . ' WHERE id=:id AND uniacid=:uniacid', array(':id' => $orderid, ':uniacid' => $_W['uniacid']));

		if (empty($order)) {
			show_json(0, '订单未找到');
		}

		$data = array();
		$data = $_GPC['addressdata'];
		$data['mobile'] = trim($data['mobile']);
		$areas = explode(' ', $data['areas']);
		$data['province'] = $areas[0];
		$data['city'] = $areas[1];
		$data['area'] = $areas[2];
		$data['street'] = trim($data['street']);
		$data['datavalue'] = trim($data['datavalue']);
		$data['streetdatavalue'] = trim($data['streetdatavalue']);
		$new_data['data'] = iserializer($data);
		$new_data['orderid'] = $orderid;
		$new_data['uniacid'] = $_W['uniacid'];
		$new_data['openid'] = $_W['openid'];
		$new_data['createtime'] = time();

		if (empty($_GPC['isall'])) {
			$new_data['isall'] = 0;
			$new_data['cycleid'] = intval($_GPC['cycleid']);
		}
		else {
			$new_data['isall'] = $_GPC['isall'];
		}

		$new_data['ordersn'] = $order['ordersn'];

		if (!empty($applyid)) {
			$res = pdo_update('ewei_shop_address_applyfor', $new_data, array('id' => $applyid));
		}
		else {
			$is_submit = pdo_get('ewei_shop_address_applyfor', array('orderid' => $orderid, 'isdelete' => 0, 'isdispose' => 0));

			if ($is_submit) {
				show_json(0, '请勿重复提交');
			}

			$address = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where orderid=:orderid and (status = 0 or status = 1) order by receipttime asc limit 1', array(':orderid' => $orderid));
			$new_data['old_address'] = $address['address'];
			pdo_insert('ewei_shop_address_applyfor', $new_data);
			$res = pdo_insertid();
		}

		if ($res != false) {
			show_json(1, '申请提交成功');
		}
		else {
			show_json(0, '申请提交失败');
		}
	}

	public function applyfor()
	{
		global $_W;
		global $_GPC;
		$apply_id = $_GPC['applyid'];
		$is_edit = $_GPC['is_edit'];
		$data = pdo_get('ewei_shop_address_applyfor', array('id' => $apply_id, 'isdelete' => 0));

		if (empty($data)) {
			$this->message('没有找到申请', '', 'error');
		}

		$data['data'] = iunserializer($data['data']);
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);

		if (empty($is_edit)) {
			include $this->template();
		}
		else {
			include $this->template('cycelbuy/order/list/edit_apply');
		}
	}

	public function cancelApply()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['applyid'];
		$result = pdo_update('ewei_shop_address_applyfor', array('isdelete' => 1), array('id' => $id));

		if ($result) {
			show_json(1);
		}
		else {
			show_json(0);
		}
	}
}

?>
