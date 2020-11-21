<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class MembercardModel extends PluginModel
{
	protected function getUrl($do, $query = NULL)
	{
		$url = mobileUrl($do, $query, true);

		if (strexists($url, '/addons/ewei_shopv2/')) {
			$url = str_replace('/addons/ewei_shopv2/', '/', $url);
		}

		if (strexists($url, '/core/mobile/order/')) {
			$url = str_replace('/core/mobile/order/', '/', $url);
		}

		return $url;
	}

	public function get_Allcard($page = 1, $psize = 20)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($page));
		$limit = ($pindex - 1) * $psize . ',' . $psize;
		$openid = $_W['openid'];
		$condition = ' uniacid = :uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);
		$condition .= ' and status=1 and isdelete=0';
		$sql = 'select * from ' . tablename('ewei_shop_member_card') . (' where  ' . $condition . ' ORDER BY sort_order DESC,create_time DESC LIMIT ' . $limit);
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_card') . ('where 1 and ' . $condition), $params);

		if ($list) {
			foreach ($list as $key => $val) {
				$has_flag = $this->check_Hasget($val['id'], $openid);
				$card_validate = '';
				$startbuy = 1;

				if ($val['validate'] == '-1') {
					$card_validate = '永久有效';
				}
				else {
					$card_validate = '有效期:' . $val['validate'] . '个月';
				}

				if ($has_flag['errno'] == 0) {
					if ($has_flag['using'] == -1) {
						$startbuy = 2;
					}
					else if ($has_flag['using'] == 1) {
						$startbuy = 0;
						$card_validate = $has_flag['validate'];
					}
					else {
						$startbuy = -1;
						$card_validate = $has_flag['validate'];
					}
				}

				$list[$key]['discount_rate'] = round($val['discount_rate'], 1);
				$list[$key]['validate'] = $card_validate;
				$list[$key]['startbuy'] = $startbuy;
				$list[$key]['validate_count'] = $val['validate'];
				$list[$key]['name'] = $this->cut_string($val['name'], 10);
			}
		}

		$result = array('list' => $list, 'psize' => $psize, 'total' => $total);
		return $result;
	}

	public function get_Mycard($openid = '', $page = 1, $psize = 20)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($page));
		$limit = ($pindex - 1) * $psize . ',' . $psize;
		$openid = empty($openid) ? $_W['openid'] : $openid;

		if (empty($openid)) {
			return false;
		}

		$condition = ' and h.uniacid=:uniacid and h.isdelete = :isdelete and c.isdelete = :isdelete and h.openid = :openid  ';
		$params = array(':uniacid' => $_W['uniacid'], ':isdelete' => 0, ':openid' => $openid);
		$now_time = TIMESTAMP;
		$condition .= ' and (h.expire_time=-1 or h.expire_time>' . $now_time . ')';
		$list = pdo_fetchall('SELECT c.*,h.openid,h.expire_time
				FROM ' . tablename('ewei_shop_member_card_history') . ' as h
				left join ' . tablename('ewei_shop_member_card') . (' as c on c.id = h.member_card_id
				WHERE 1 ' . $condition . '  ORDER BY h.receive_time DESC limit ' . $limit . ' '), $params);
		$total = pdo_fetchcolumn('SELECT COUNT(h.id) 
            FROM ' . tablename('ewei_shop_member_card_history') . ' as h 
            left join ' . tablename('ewei_shop_member_card') . (' as c on c.id = h.member_card_id
            where 1  ' . $condition . ' limit 1'), $params);

		if ($list) {
			foreach ($list as $key => $val) {
				$card_validate = '';
				$startbuy = 0;

				if ($val['validate'] == '-1') {
					$card_validate = '永久有效';
					$startbuy = -1;
				}
				else {
					$card_validate = '有效期至:' . date('Y-m-d H:i', $val['expire_time']);
				}

				$list[$key]['discount_rate'] = round($val['discount_rate'], 1);
				$list[$key]['validate'] = $card_validate;
				$list[$key]['startbuy'] = $startbuy;
				$list[$key]['validate_count'] = $val['validate'];
				$list[$key]['name'] = $this->cut_string($val['name'], 10);
			}
		}

		$result = array('list' => $list, 'psize' => $psize, 'total' => $total);
		return $result;
	}

	public function check_Hasget($cardid = 0, $openid = '')
	{
		global $_W;
		global $_GPC;
		$openid = empty($openid) ? $_W['openid'] : $openid;
		if (empty($cardid) || empty($openid)) {
			return array('errno' => 2, 'msg' => '缺少参数');
		}

		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':cardid' => $cardid);
		$record = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_card_history') . ' 
				WHERE openid =:openid and uniacid=:uniacid and member_card_id=:cardid and isdelete=0 ORDER BY receive_time DESC limit 1', $params);

		if (!$record) {
			return array('errno' => 1, 'msg' => '未开通此会员卡');
		}

		$result = array();

		if ($record['expire_time'] == -1) {
			$result['errno'] = 0;
			$result['msg'] = '永久有效';
			$result['using'] = 2;
			$result['validate'] = '永久有效';
		}
		else if ($record['expire_time'] <= time()) {
			$result['using'] = -1;
			$result['validate'] = '已过期';
			$result['errno'] = 0;
			$result['msg'] = '已过期';
		}
		else {
			$result['using'] = 1;
			$result['validate'] = '有效期至:' . date('Y-m-d H:i', $record['expire_time']);
			$result['errno'] = 0;
			$result['msg'] = '使用中';
		}

		return $result;
	}

	public function check_month_point($cardid = 0, $openid = '')
	{
		global $_W;
		global $_GPC;

		if (empty($cardid)) {
			return false;
		}

		$openid = empty($openid) ? $_W['openid'] : $openid;

		if (empty($openid)) {
			return false;
		}

		$condition = ' and uniacid=:uniacid and openid =:openid and member_card_id = :cardid  ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':cardid' => $cardid);
		$card = pdo_fetch('SELECT id,validate FROM ' . tablename('ewei_shop_member_card') . ' 
				WHERE id =:id and uniacid=:uniacid and isdelete=0 limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $cardid));

		if (empty($card)) {
			return false;
		}

		if ($card['validate'] == '-1') {
			$time_between = $this->month_start_end();
			$starttime = $time_between['starttime'];
			$endtime = $time_between['endtime'];
		}
		else {
			$time_between = $this->nonthcard_start_end($cardid, $openid);
			if (is_array($time_between) && 0 < $time_between['month_index']) {
				$starttime = $time_between['starttime'];
				$endtime = $time_between['endtime'];
			}
			else {
				return false;
			}
		}

		$condition .= ' and create_time>' . $starttime . ' and create_time<' . $endtime;
		$month_point = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_card_monthsend') . (' 
				WHERE sendtype=1 ' . $condition), $params);

		if ($month_point) {
			return true;
		}

		return false;
	}

	public function check_month_coupon($cardid = 0, $openid = '', $couponid = 0)
	{
		global $_W;
		global $_GPC;

		if (empty($cardid)) {
			return false;
		}

		$openid = empty($openid) ? $_W['openid'] : $openid;

		if (empty($openid)) {
			return false;
		}

		if (empty($couponid)) {
			return false;
		}

		$condition = ' and uniacid=:uniacid and openid =:openid and member_card_id = :cardid and card_couponid = :card_couponid ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':cardid' => $cardid, ':card_couponid' => $couponid);
		$card = pdo_fetch('SELECT id,validate FROM ' . tablename('ewei_shop_member_card') . ' 
				WHERE id =:id and uniacid=:uniacid and isdelete=0 limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $cardid));

		if (empty($card)) {
			return false;
		}

		if ($card['validate'] == '-1') {
			$time_between = $this->month_start_end();
			$starttime = $time_between['starttime'];
			$endtime = $time_between['endtime'];
		}
		else {
			$time_between = $this->nonthcard_start_end($cardid, $openid);
			if (is_array($time_between) && 0 < $time_between['month_index']) {
				$starttime = $time_between['starttime'];
				$endtime = $time_between['endtime'];
			}
			else {
				return false;
			}
		}

		$condition .= ' and create_time>' . $starttime . ' and create_time<' . $endtime;
		$month_point = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_card_monthsend') . (' 
				WHERE sendtype=2 ' . $condition), $params);

		if ($month_point) {
			return true;
		}

		return false;
	}

	public function nonthcard_start_end($cardid = 0, $openid = '')
	{
		global $_W;
		global $_GPC;

		if (empty($cardid)) {
			return false;
		}

		$openid = empty($openid) ? $_W['openid'] : $openid;

		if (empty($openid)) {
			return false;
		}

		$condition = '  h.uniacid=:uniacid and h.isdelete = :isdelete and h.openid = :openid and h.member_card_id=:cardid ';
		$params = array(':uniacid' => $_W['uniacid'], ':isdelete' => 0, ':openid' => $openid, ':cardid' => $cardid);
		$card = pdo_fetch('SELECT c.*,h.receive_time,h.openid,h.expire_time,c.validate
				FROM ' . tablename('ewei_shop_member_card_history') . ' as h
				left join ' . tablename('ewei_shop_member_card') . (' as c on c.id = h.member_card_id 
				WHERE  ' . $condition . '  ORDER BY h.receive_time DESC limit 1'), $params);

		if (empty($card)) {
			return false;
		}

		if ($card['validate'] == '-1') {
			return false;
		}

		$create_time = $card['receive_time'];
		$card_end = $card['expire_time'];
		$month_index = ceil((time() - $create_time) / (31 * 24 * 3600));
		$starttime = ($month_index - 1) * 31 * 24 * 3600 + $create_time;
		$endtime = $month_index * 31 * 24 * 3600 + $create_time;
		if ($card_end <= time() || $card['validate'] < $month_index) {
			$month_index = -1;
		}

		$result = array('starttime' => $starttime, 'endtime' => $endtime, 'month_index' => $month_index);
		return $result;
	}

	public function month_start_end()
	{
		$time_zone = @date_default_timezone_get();

		if ($time_zone != 'Asia/Shanghai') {
			@date_default_timezone_set('Asia/Shanghai');
		}

		$year = date('Y');
		$month = date('m');
		$day1 = '01';
		$day2 = date('t', time());
		$starttime = strtotime(date($year . '-' . $month . '-' . $day1));
		$endtime = strtotime(date($year . '-' . $month . '-' . $day2 . ' 23:59:59'));
		$result = array('starttime' => $starttime, 'endtime' => $endtime);
		return $result;
	}

	public function querycoupon($couponid = array())
	{
		global $_W;
		global $_GPC;
		$cpinfo = array();
		if (!is_array($couponid) || empty($couponid)) {
			return $cpinfo;
		}

		foreach ($couponid as $ck => $cv) {
			$where = ' WHERE uniacid = :uniacid AND id = :id';
			$params = array(':uniacid' => intval($_W['uniacid']), ':id' => intval($cv));
			$cpsql = 'SELECT id,catid,couponname,bgcolor,enough,coupontype,timestart,timeend,discount,deduct,backtype,backmoney,backcredit,backredpack,createtime,total,limitgoodcatetype,limitgoodtype,limitgoodids,limitgoodcatetype,limitgoodcateids FROM ' . tablename('ewei_shop_coupon') . $where;
			$row = pdo_fetch($cpsql, $params);
			$title2 = '';
			$tagtitle = '';

			if ($row['coupontype'] == '0') {
				if (0 < $row['enough']) {
					$title2 = '满' . (double) $row['enough'] . '元可用';
				}
				else {
					$title2 = '无金额门槛';
				}
			}
			else {
				if ($row['coupontype'] == '1') {
					if (0 < $row['enough']) {
						$title2 = '充值满' . (double) $row['enough'] . '元可用';
					}
					else {
						$title2 = '无金额门槛';
					}
				}
			}

			if ($row['coupontype'] == '2') {
				if (0 < $row['enough']) {
					$title2 = '满' . (double) $row['enough'] . '元可用';
				}
				else {
					$title2 = '无金额门槛';
				}
			}

			if ($row['backtype'] == 0) {
				if ($row['enough'] == '0') {
					$row['color'] = 'org ';
					$tagtitle = '代金券';
				}
				else {
					$row['color'] = 'blue';
					$tagtitle = '满减券';
				}
			}

			if ($row['backtype'] == 1) {
				$row['color'] = 'red ';
				$tagtitle = '打折券';
			}

			$backnum = 0;

			if ($row['backtype'] == 2) {
				if ($row['coupontype'] == '0') {
					$row['color'] = 'red ';
					$tagtitle = '购物返现券';
				}
				else if ($row['coupontype'] == '1') {
					$row['color'] = 'pink ';
					$tagtitle = '充值返现券';
				}
				else {
					if ($row['coupontype'] == '2') {
						$row['color'] = 'red ';
						$tagtitle = '购物返现券';
					}
				}

				if (0 < $row['backredpack']) {
					$backnum = $row['backredpack'];
				}

				if (0 < $row['backcredit']) {
					$backnum = $row['backcredit'];
				}

				if (0 < $row['backmoney']) {
					$backnum = $row['backmoney'];
				}
			}

			$use_limit = '全品类通用';
			if ($row['limitgoodcatetype'] == 1 && $row['limitgoodcateids']) {
				$cateids = explode(',', $row['limitgoodcateids']);
				$cateid = $cateids[0];
				$catename = pdo_fetchcolumn('select `name`  from ' . tablename('ewei_shop_category') . ' where uniacid=:uniacid  and id=:id ', array(':uniacid' => $_W['uniacid'], ':id' => $cateid));

				if ($catename) {
					if (count($cateids) == 1) {
						$use_limit = '限' . $catename . '品类使用';
					}
					else {
						$use_limit = '限' . $catename . '等品类使用';
					}
				}
			}

			if ($row['limitgoodtype'] == 1 && $row['limitgoodids']) {
				$goodids = explode(',', $row['limitgoodids']);
				$goodid = $goodids[0];
				$goodsname = pdo_fetchcolumn('select `title`  from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid  and id=:id ', array(':uniacid' => $_W['uniacid'], ':id' => $goodid));

				if ($goodsname) {
					if (count($goodids) == 1) {
						$use_limit = '限' . $goodsname . '商品使用';
					}
					else {
						$use_limit = '限' . $goodsname . '等商品使用';
					}
				}
			}

			if ($row['tagtitle'] == '') {
				$row['tagtitle'] = $tagtitle;
			}

			$row['title2'] = $title2;
			$row['backnum'] = $backnum;
			$row['use_limit'] = $use_limit;
			unset($row['backredpack']);
			unset($row['backcredit']);
			unset($row['backmoney']);
			unset($row['limitgoodcatetype']);
			unset($row['limitgoodcateids']);
			unset($row['limitgoodtype']);
			unset($row['limitgoodids']);
			$cpinfo[$ck] = $row;
		}

		return $cpinfo;
	}

	public function couponPayResult($logno)
	{
		global $_W;

		if (empty($logno)) {
			return error(-1);
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_coupon_log') . ' WHERE `logno`=:logno and `uniacid`=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':logno' => $logno));

		if (empty($log)) {
			return error(-1, '服务器错误!');
		}

		if (1 <= $log['status']) {
			return true;
		}

		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id limit 1', array(':id' => $log['couponid']));
		$coupon = com('coupon')->setCoupon($coupon, time());

		if (empty($coupon['gettype'])) {
			return error(-1, '无法领取');
		}

		if ($coupon['total'] != -1) {
			if ($coupon['total'] <= 0) {
				return error(-1, '优惠券数量不足');
			}
		}

		if (!$coupon['canget']) {
			return error(-1, '您已超出领取次数限制');
		}

		if (empty($log['status'])) {
			$update = array();
			if (0 < $coupon['credit'] && empty($log['creditstatus'])) {
				m('member')->setCredit($log['openid'], 'credit1', 0 - $coupon['credit'], '购买优惠券扣除积分 ' . $coupon['credit']);
				$update['creditstatus'] = 1;
			}

			if (0 < $coupon['money'] && empty($log['paystatus'])) {
				if ($log['paytype'] == 0) {
					m('member')->setCredit($log['openid'], 'credit2', 0 - $coupon['money'], '购买优惠券扣除余额 ' . $coupon['money']);
				}

				$update['paystatus'] = 1;
			}

			$update['status'] = 1;
			pdo_update('ewei_shop_coupon_log', $update, array('id' => $log['id']));
			$data = array('uniacid' => $_W['uniacid'], 'merchid' => $log['merchid'], 'openid' => $log['openid'], 'couponid' => $log['couponid'], 'gettype' => $log['getfrom'], 'gettime' => time());
			pdo_insert('ewei_shop_coupon_data', $data);
			$dataid = pdo_insertid();
			com('coupon')->sethasnewcoupon($log['openid'], 1);
			$coupon['dataid'] = $dataid;
		}

		$url = mobileUrl('member', NULL, true);

		if ($coupon['coupontype'] == 0) {
			$coupon['url'] = mobileUrl('goods', NULL, true);
		}
		else {
			$coupon['url'] = mobileUrl('member/recharge', NULL, true);
		}

		return $coupon;
	}

	public function getMemberCard($id)
	{
		global $_W;
		global $_GPC;
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_member_card') . ' WHERE uniacid = :uniacid AND id = :id ';
		$params = array(':uniacid' => intval($_W['uniacid']), ':id' => intval($id));
		$result = pdo_fetch($sql, $params);

		if ($result) {
			$result['name'] = $this->cut_string($result['name'], 10);
			$result['discount_rate'] = round($result['discount_rate'], 1);
		}

		return $result;
	}

	protected function buycard_send($cardid = 0, $openid = '')
	{
		global $_W;

		if (empty($cardid)) {
			return false;
		}

		$openid = empty($openid) ? $_W['openid'] : $openid;

		if (empty($openid)) {
			return false;
		}

		$uniacid = $_W['uniacid'];
		$card = $this->getMemberCard($cardid);

		if (empty($card)) {
			return false;
		}

		if ($card['is_card_points'] && $card['card_points']) {
			$credit1 = $card['card_points'];
			$result = m('member')->setCredit($openid, 'credit1', $credit1, array($_W['member']['uid'], '首次开通会员卡' . $card['name'] . '赠送' . $credit1 . '积分'));

			if (is_error($result)) {
				return $result['message'];
			}

			$send_log = array('uniacid' => $uniacid, 'openid' => $openid, 'member_card_id' => $cardid, 'name' => $card['name'], 'receive_time' => TIMESTAMP, 'create_time' => TIMESTAMP, 'price' => $card['price'], 'sendtype' => 1, 'card_points' => $credit1);
			pdo_insert('ewei_shop_member_card_buysend', $send_log);
		}

		if ($card['is_card_coupon'] && $card['card_coupon']) {
			$card_coupon = iunserializer($card['card_coupon']);
			$card_coupons = $this->querycoupon($card_coupon['couponids']);

			foreach ($card_coupons as $key => $val) {
				$send_coupon_num = 1;

				if ($card_coupon['paycpnum' . ($key + 1)]) {
					$send_coupon_num = $card_coupon['paycpnum' . ($key + 1)];
				}

				$this->send_coupon($openid, $val['id'], $send_coupon_num);
				$send_log = array('uniacid' => $uniacid, 'openid' => $openid, 'member_card_id' => $cardid, 'name' => $card['name'], 'receive_time' => TIMESTAMP, 'create_time' => TIMESTAMP, 'price' => $card['price'], 'sendtype' => 2, 'card_couponid' => $val['id'], 'card_couponcount' => $send_coupon_num);
				pdo_insert('ewei_shop_member_card_buysend', $send_log);
			}
		}
	}

	/**
     * 赠送优惠券
     * $gettype获取方式 0 发放 1 领取
     * $couponnum 赠送数量
     */
	public function send_coupon($openid = '', $couponid = 0, $couponnum = 1, $gettype = 0)
	{
		global $_W;
		global $_GPC;
		$openid = empty($openid) ? $_W['openid'] : $openid;

		if (empty($openid)) {
			return false;
		}

		if (empty($couponid)) {
			return false;
		}

		$send_success = array();
		$send_error = array();
		$i = 1;

		while ($i <= $couponnum) {
			$couponlog = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $couponid, 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => 0);
			$log = pdo_insert('ewei_shop_coupon_log', $couponlog);
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'couponid' => $couponid, 'gettype' => $gettype, 'gettime' => time());
			$data = pdo_insert('ewei_shop_coupon_data', $data);
			$did = pdo_insertid();
			if ($log && $data) {
				$send_success[] = $did;
			}
			else {
				$send_error[] = $i;
			}

			++$i;
		}

		return array('success' => $send_success, 'error' => $send_error);
	}

	/**
     * 支付成功
     * @global type $_W
     * @param type $params
     */
	public function payResult($orderno, $type, $app = false)
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `module`=:module AND `tid`=:tid AND `uniacid`=:uniacid limit 1';
		$params = array(':tid' => $orderno, ':module' => 'ewei_shopv2', ':uniacid' => $uniacid);
		$log = pdo_fetch($sql, $params);
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_member_card_order') . ' where  orderno =:orderno and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':orderno' => $orderno));

		if (0 < $order['status']) {
			return true;
		}

		$log_tag = iunserializer($log['tag']);
		$record = array();
		$record['status'] = '1';
		$record['paytype'] = $type;
		$record['paytime'] = time();
		$record['transid'] = $log_tag['transaction_id'];
		$record['apppay'] = $app ? 1 : 0;
		pdo_update('ewei_shop_member_card_order', $record, array('orderno' => $orderno));
		pdo_update('core_paylog', array('status' => 1), array('tid' => $orderno));
		$openid = $order['openid'];
		$cardid = $order['member_card_id'];
		$has_flag = $this->check_Hasget($cardid, $openid);

		if ($has_flag['errno'] == 1) {
			$this->buycard_send($cardid, $openid);
		}

		$this->addMembercard($order['id']);
	}

	public function getMember_card_order($id)
	{
		global $_W;
		$order = pdo_fetch('SELECT * FROM  ' . tablename('ewei_shop_member_card_order') . '  where id=:id and uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		return $order;
	}

	public function getMembercard_order_history($card_id)
	{
		global $_W;
		$time = time();
		$card_history = pdo_fetch($sql = 'SELECT * FROM  ' . tablename('ewei_shop_member_card_history') . ' where member_card_id=:cardid and uniacid=:uniacid and openid=:openid and isdelete=0 and (expire_time=-1 or expire_time >' . $time . ') limit 1', array(':cardid' => $card_id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		return $card_history;
	}

	public function getUserMembercardOrderHistory($card_id, $openid)
	{
		global $_W;
		$time = time();
		$card_history = pdo_fetch($sql = 'SELECT * FROM  ' . tablename('ewei_shop_member_card_history') . ' where member_card_id=:cardid and uniacid=:uniacid and openid=:openid and isdelete=0 and (expire_time=-1 or expire_time >' . $time . ') limit 1', array(':cardid' => $card_id, ':uniacid' => $_W['uniacid'], ':openid' => $openid));
		return $card_history;
	}

	public function getExpireMembercard_order_history($card_id)
	{
		global $_W;
		$card_history = pdo_fetch('SELECT * FROM  ' . tablename('ewei_shop_member_card_history') . ' where member_card_id=:cardid and uniacid=:uniacid and openid=:openid and isdelete=0 and (expire_time=-1 or expire_time <' . time() . ')', array(':uniacid' => $_W['uniacid'], ':cardid' => $card_id, ':openid' => $_W['openid']));
		return $card_history;
	}

	public function addMembercard($order_id)
	{
		global $_W;
		$order = $this->getMember_card_order($order_id);

		if ($order) {
			$check = $this->check_Hasget($order['member_card_id'], $order['openid']);
			$card_info = $this->getMemberCard($order['member_card_id']);
			$paytype = $order['paytype'];

			if ($paytype == 'credit') {
				$pay_type = 0;
			}
			else if ($paytype == 'wechat') {
				$pay_type = 1;
			}
			else {
				if ($paytype == 'alipay') {
					$pay_type = 2;
				}
			}

			if ($card_info) {
				if ($card_info['validate'] == -1) {
					$expire_time = -1;
				}
				else {
					$expire_time = time() + $card_info['validate'] * 3600 * 24 * 31;
				}
			}

			if ($check['errno'] == 1 || $check['using'] == -1) {
				$data = array('uniacid' => $_W['uniacid'], 'openid' => $order['openid'], 'order_id' => $order['id'], 'member_card_id' => $order['member_card_id'], 'name' => $card_info['name'], 'receive_time' => time(), 'pay_type' => $pay_type, 'expire_time' => $expire_time, 'price' => $order['total'], 'user_name' => $order['payment_name'], 'telephone' => $order['telephone']);
				pdo_insert('ewei_shop_member_card_history', $data);
				pdo_query('UPDATE ' . tablename('ewei_shop_member_card') . ' SET `sale_count` = `sale_count` + 1,`stock` = `stock` - 1 WHERE id=' . $order['member_card_id'] . '');
			}
			else {
				if ($check['using'] == 1) {
					$card = $this->getUserMembercardOrderHistory($order['member_card_id'], $order['openid']);

					if ($card) {
						$expire_time = $card['expire_time'] + $card_info['validate'] * 3600 * 24 * 31;
						$updata = array('expire_time' => $expire_time + 1, 'price' => $order['total'], 'pay_type' => $pay_type, 'order_id' => $order['id'], 'user_name' => $order['payment_name'], 'telephone' => $order['telephone']);
						pdo_update('ewei_shop_member_card_history', $updata, array('id' => $card['id']));
						pdo_query('UPDATE ' . tablename('ewei_shop_member_card') . ' SET `sale_count` = `sale_count` + 1,`stock` = `stock` - 1 WHERE id=' . $order['member_card_id'] . '');
					}
				}
			}
		}
	}

	public function get_member_card_buysend($condition, $params)
	{
		global $_W;
		$buysend = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_card_buysend') . (' WHERE  ' . $condition . ' limit 1'), $params);
		return $buysend;
	}

	public function member_card_use_record($orderid, $cardid, $dec_price, $openid = '', $card_free_dispatch = false)
	{
		global $_W;
		if (empty($orderid) || empty($cardid)) {
			return false;
		}

		$openid = empty($openid) ? $_W['openid'] : $openid;
		$card = $this->getMemberCard($cardid);

		if (empty($card)) {
			return false;
		}

		$order = pdo_fetch('SELECT id,price FROM  ' . tablename('ewei_shop_order') . '  where id=:id and uniacid=:uniacid', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));

		if (empty($order)) {
			return false;
		}

		$shipping = 0;

		if ($card_free_dispatch) {
			$shipping = 1;
		}

		$log_data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'order_id' => $orderid, 'member_card_id' => $cardid, 'name' => $card['name'], 'shipping' => $shipping, 'discount_rate' => $card['discount_rate'], 'order_price' => $order['price'], 'dec_price' => $dec_price, 'create_time' => TIMESTAMP);
		pdo_insert('ewei_shop_member_card_uselog', $log_data);
	}

	public function if_order_use_membercard($orderid)
	{
		global $_W;

		if (empty($orderid)) {
			return false;
		}

		$use_log = pdo_fetch('SELECT * FROM  ' . tablename('ewei_shop_member_card_uselog') . '  where order_id=:order_id and uniacid=:uniacid', array(':uniacid' => $_W['uniacid'], ':order_id' => $orderid));

		if (empty($use_log)) {
			return false;
		}

		return $use_log;
	}

	/**
     * 字符串截取
     * @param str $str 字符串
     * @param str $length 截取长度
     * @param str $charset 编码格式
     * @param str $suffix 是否加后缀
     * @return str
     */
	public function cut_string($str, $length = 50, $charset = 'utf-8', $suffix = true)
	{
		$str = trim($str);
		$length = $length * 2;

		if ($length) {
			$wordscut = '';

			if (strtolower($charset) == 'utf-8') {
				$n = 0;
				$tn = 0;
				$noc = 0;

				while ($n < strlen($str)) {
					$t = ord($str[$n]);
					if ($t == 9 || $t == 10 || 32 <= $t && $t <= 126) {
						$tn = 1;
						++$n;
						++$noc;
					}
					else {
						if (194 <= $t && $t <= 223) {
							$tn = 2;
							$n += 2;
							$noc += 2;
						}
						else {
							if (224 <= $t && $t < 239) {
								$tn = 3;
								$n += 3;
								$noc += 2;
							}
							else {
								if (240 <= $t && $t <= 247) {
									$tn = 4;
									$n += 4;
									$noc += 2;
								}
								else {
									if (248 <= $t && $t <= 251) {
										$tn = 5;
										$n += 5;
										$noc += 2;
									}
									else {
										if ($t == 252 || $t == 253) {
											$tn = 6;
											$n += 6;
											$noc += 2;
										}
										else {
											++$n;
										}
									}
								}
							}
						}
					}

					if ($length <= $noc) {
						break;
					}
				}

				if ($length < $noc) {
					$n -= $tn;
				}

				$wordscut = substr($str, 0, $n);
			}
			else {
				$i = 0;

				while ($i < $length - 1) {
					if (127 < ord($str[$i])) {
						$wordscut .= $str[$i] . $str[$i + 1];
						++$i;
					}
					else {
						$wordscut .= $str[$i];
					}

					++$i;
				}
			}

			if ($wordscut == $str) {
				return $str;
			}

			return $suffix ? trim($wordscut) . '...' : trim($wordscut);
		}

		return $str;
	}
}

?>
