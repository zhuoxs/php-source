<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$id = intval($_GPC['id']);

			if (empty($id)) {
				if (is_array($_GPC['couponid'])) {
					$count = count($_GPC['couponid']);

					if (3 < $count) {
						show_json(0, '最多只能选择三张优惠券！');
					}

					$expcoupon = array();

					foreach ($_GPC['couponid'] as $cpk => $cpv) {
						$where = ' WHERE uniacid = :uniacid AND id = :id';
						$params = array(':uniacid' => $_W['uniacid'], ':id' => intval($cpv));
						$sql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . $where;
						$list = pdo_fetch($sql, $params, 'id');

						if ($list['timelimit'] == 1) {
							if ($list['timeend'] < TIMESTAMP) {
								$expcoupon[$cpk] = $list['couponname'];
							}
						}
					}

					if (!empty($expcoupon) && is_array($expcoupon)) {
						foreach ($expcoupon as $exk => $exv) {
							show_json(0, '优惠券' . $expcoupon[$exk] . ',请选择其他优惠券！');
						}
					}

					$cpids = implode(',', $_GPC['couponid']);
				}
			}
			else {
				if (empty($_GPC['couponid'])) {
					$cpid = explode(',', trim($_GPC['cpids']));
				}
				else {
					if (is_array($_GPC['couponid'])) {
						$count = count($_GPC['couponid']);

						if (3 < $count) {
							show_json(0, '最多只能选择三张优惠券！');
						}

						$cpid = $_GPC['couponid'];
					}
				}

				$expcoupon = array();

				foreach ($cpid as $cpk => $cpv) {
					$where = ' WHERE uniacid = :uniacid AND id = :id';
					$params = array(':uniacid' => $_W['uniacid'], ':id' => intval($cpv));
					$sql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . $where;
					$list = pdo_fetch($sql, $params, 'id');

					if ($list['timelimit'] == 1) {
						if ($list['timeend'] < TIMESTAMP) {
							$expcoupon[$cpk] = $list['couponname'];
						}
					}
				}

				if (!empty($expcoupon) && is_array($expcoupon)) {
					foreach ($expcoupon as $exk => $exv) {
						show_json(0, '优惠券' . $expcoupon[$exk] . ',请选择其他优惠券！');
					}
				}

				$cpids = implode(',', $cpid);
			}

			$data = array('uniacid' => intval($_W['uniacid']), 'cpid' => trim($cpids), 'expiration' => intval($_GPC['expiration']), 'status' => intval($_GPC['status']), 'createtime' => TIMESTAMP);
			if (!empty($_GPC['expiration']) && intval($_GPC['expiration']) == 1) {
				$data['starttime'] = strtotime($_GPC['time']['start']);
				$data['endtime'] = strtotime($_GPC['time']['end']);
			}

			if (empty($id)) {
				pdo_insert('ewei_shop_sendticket', $data);
				plog('sendticket.set', '设置发券内容');
			}
			else {
				$params = array('id' => $id);
				pdo_update('ewei_shop_sendticket', $data, $params);
			}

			show_json(1);
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_sendticket') . ' WHERE uniacid = ' . intval($_W['uniacid']);
		$item = pdo_fetch($sql);

		if (!empty($item)) {
			$cpids = explode(',', $item['cpid']);
			$coupon = array();
			$cpname = array();

			foreach ($cpids as $cpidk => $cpidv) {
				$cpsql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND id = ' . intval($cpidv);
				$list = pdo_fetch($cpsql);
				$cpname[$cpidk] = $list['couponname'];
				$coupon[$cpidk] = $list;
			}

			$coupons = $coupon;
			$item['cpname'] = implode(';', $cpname);
		}

		if (!empty($item['starttime'])) {
			$starttime = $item['starttime'];
		}
		else {
			$starttime = TIMESTAMP;
		}

		if (!empty($item['endtime'])) {
			$endtime = $item['endtime'];
		}
		else {
			$endtime = TIMESTAMP + 60 * 60 * 24 * 30;
		}

		include $this->template();
	}
}

?>
