<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class History_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_GPC;
		global $_W;
		$page = intval($_GPC['page']);
		$page = max(1, $page);
		$psize = 50;
		$keyword = trim($_GPC['keyword']);
		$kdtype = trim($_GPC['kdtype']);
		$group = trim($_GPC['group']);
		if (empty($start) || empty($end)) {
			$start = strtotime('-1 month');
			$end = time();
		}

		if (!empty($keyword)) {
			switch ($kdtype) {
			case code:
				$keyword_condition = ' AND `serial` LIKE \'%' . $keyword . '%\'';
				break;

			case goodstitle:
				$keyword_condition = ' AND `goods_title` LIKE \'%' . $keyword . '%\'';
				break;

			case openid:
				$keyword_condition = ' AND `openid` LIKE \'%' . $keyword . '%\'';
				break;

			case nickname:
				$keyword_condition = ' AND `nickname` LIKE \'%' . $keyword . '%\'';
				break;

			case group:
				$keyword_condition = ' AND `title` LIKE \'%' . $keyword . '%\'';
				break;

			default:
				$keyword_condition = '';
			}
		}
		else {
			$keyword_condition = '';
		}

		switch ($group) {
		case goods:
			$group_condition = ' AND `mode` = 1';
			break;

		case balance:
			$group_condition = ' AND `mode` = 2';
			break;

		case red:
			$group_condition = ' AND `mode` = 3';
			break;

		case score:
			$group_condition = ' AND `mode` = 4';
			break;

		case coupon:
			$group_condition = ' AND `mode` = 5';
			break;

		case group:
			$group_condition = ' AND `mode` = 6';
			break;

		default:
			$group_condition = '';
		}

		if (is_array($_GPC['time'])) {
			$start = strtotime($_GPC['time']['start']);
			$end = strtotime($_GPC['time']['end']);
			$time_condition = ' AND `time`>=' . $start . ' AND time <=' . $end;
		}

		$ps = $psize * ($page - 1);
		$limit = ' ORDER BY id DESC LIMIT ' . $ps . ',' . $psize;
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_exchange_record') . ' WHERE uniacid = :uniacid ' . $keyword_condition . $group_condition . $time_condition . $limit;
		$record = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
		$countsql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_exchange_record') . ' WHERE uniacid = :uniacid ' . $keyword_condition . $group_condition . $time_condition;
		$count = pdo_fetchcolumn($countsql, array(':uniacid' => $_W['uniacid']));
		$pager = pagination2($count, $page, $psize);
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$key = trim($_GPC['key']);
		$status = intval($_GPC['status']);
		$id = intval($_GPC['id']);

		if ($status == 1) {
			$t1 = tablename('ewei_shop_exchange_group');
			$t2 = tablename('ewei_shop_exchange_code');
			$res = pdo_fetch('SELECT * FROM ' . $t1 . ' INNER JOIN ' . $t2 . ' ON ' . $t1 . '.id = ' . $t2 . '.groupid WHERE ' . $t2 . '.key = :key AND ' . $t2 . '.id = :id', array('key' => $key, ':id' => $id));
			$res_swi = 1;
		}
		else {
			$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exchange_record') . ' WHERE uniacid = :uniacid AND `key` = :key', array(':uniacid' => $_W['uniacid'], ':key' => $key));
		}

		switch ($res['mode']) {
		case 1:
			$type = '商品兑换';
			break;

		case 2:
			$type = '余额兑换';
			break;

		case 3:
			$type = '红包兑换';
			break;

		case 4:
			$type = '积分兑换';
			break;

		case 5:
			$type = '优惠券兑换';
			$couponList = json_decode($res['coupon'], 1);

			if (!is_array($couponList)) {
				$temp = $couponList;
				$couponList = NULL;
				$couponList[0] = $temp;
			}

			foreach ($couponList as $k => $v) {
				$allcoupon[$k] = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE id=:id AND uniacid = :uniacid', array(':id' => $v, ':uniacid' => $_W['uniacid']));
			}

			break;

		case 6:
			$type = '组合兑换';
			$couponList = json_decode($res['coupon'], 1);

			if (!is_array($couponList)) {
				$temp = $couponList;
				$couponList = NULL;
				$couponList[0] = $temp;
			}

			foreach ($couponList as $k => $v) {
				$allcoupon[$k] = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE id=:id AND uniacid = :uniacid', array(':id' => $v, ':uniacid' => $_W['uniacid']));
			}

			break;
		}

		include $this->template();
	}

	public function statistics()
	{
		global $_GPC;
		global $_W;
		$dateRand = $_GPC['date'];

		if (!empty($dateRand)) {
			$range = (strtotime($dateRand['end']) - strtotime($dateRand['start'])) / 86400;
			$i = $range + 1;
			$starttime = strtotime($dateRand['start']);
			$endtime = strtotime($dateRand['end']);
		}
		else {
			$i = 1;
			$starttime = time();
			$endtime = time();
		}

		$price_key = array();
		$price_value = array();
		$count_value = array();
		$balanceCount = 0;
		$goodsCount = 0;
		$redCount = 0;
		$scoreCount = 0;
		$couponCount = 0;
		$groupCount = 0;
		$goodssum = 0;
		$balancesum = 0;
		$redsum = 0;
		$scoresum = 0;
		$couponsum = 0;
		$groupsum = 0;
		$i -= 1;

		while (0 <= $i) {
			if (!empty($dateRand)) {
				$time = strtotime($dateRand['end']);
			}
			else {
				$time = time();
			}

			$time = $time - 86400 * $i;
			$day = date('Y-m-d', $time);
			array_push($price_key, $day);
			$compare_time1 = strtotime($day . ' 00:00:00');
			$compare_time2 = strtotime($day . ' 23:59:59');
			$all = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exchange_record') . (' WHERE uniacid = ' . $_W['uniacid'] . ' AND `time` >= ' . $compare_time1 . ' AND `time` <=' . $compare_time2));
			$all = intval($all);
			array_push($count_value, $all);

			if (!empty($dateRand)) {
				$where = ' AND `time` >= ' . $compare_time1 . ' AND `time` <=' . $compare_time2;
			}
			else {
				$where = '';
			}

			$res = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_exchange_record') . (' WHERE uniacid = ' . $_W['uniacid'] . ' ') . $where);
			$sum = 0;

			if ($res != false) {
				foreach ($res as $ke => $va) {
					if ($va['mode'] == 2) {
						$balanceCount += 1;
						$sum += $va['balance'];
						$balancesum += $va['balance'];
					}
					else if ($va['mode'] == 3) {
						$redCount += 1;
						$sum += $va['red'];
						$redsum += $va['red'];
					}
					else if ($va['mode'] == 1) {
						$goodsCount += 1;
						$goods = json_decode($va['goods'], 1);

						foreach ($goods as $k => $v) {
							$sum += $v[2];
							$goodssum += $v[2];
						}
					}
					else if ($va['mode'] == 4) {
						$scoreCount += 1;
						$scoresum += $va['score'];
					}
					else if ($va['mode'] == 5) {
						$couponCount += 1;
						$couponsum += count(json_decode($va['coupon'], 1));
					}
					else {
						if ($va['mode'] == 6) {
							$groupCount += 1;
							$groupsum = 0;
						}
					}

					$sum = round($sum, 2);
				}
			}

			array_push($price_value, $sum);
			--$i;
		}

		$return = json_encode(array('price_key' => $price_key, 'price_value' => $price_value, 'count_value' => $count_value));
		$arr = array('goodsc' => $goodsCount, 'balancec' => $balanceCount, 'redc' => $redCount, 'scorec' => $scoreCount, 'couponc' => $couponCount, 'groupc' => $groupCount, 'goodss' => $goodssum, 'balances' => $balancesum, 'reds' => $redsum, 'scores' => $scoresum, 'coupons' => $couponsum, 'groups' => $groupsum);
		$json = json_encode($arr);
		include $this->template();
	}
}

?>
