<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Coupon_EweiShopV2ComModel extends ComModel
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

	public function get_last_count($couponid = 0)
	{
		global $_W;
		$coupon = pdo_fetch('SELECT id,total FROM ' . tablename('ewei_shop_coupon') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $couponid, ':uniacid' => $_W['uniacid']));

		if (empty($coupon)) {
			return 0;
		}

		if ($coupon['total'] == -1) {
			return -1;
		}

		$gettotal = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and uniacid=:uniacid ', array(':couponid' => $couponid, ':uniacid' => $_W['uniacid']));
		return $coupon['total'] - $gettotal;
	}

	public function creditshop($logid = 0)
	{
		global $_W;
		global $_GPC;
		$pcreditshop = p('creditshop');

		if (!$pcreditshop) {
			return NULL;
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_creditshop_log') . ' WHERE `id`=:id and `uniacid`=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $logid));

		if (!empty($log)) {
			$member = m('member')->getMember($log['openid']);
			$goods = $pcreditshop->getGoods($log['couponid'], $member);
			$couponlog = array('uniacid' => $_W['uniacid'], 'openid' => $log['openid'], 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $log['couponid'], 'status' => 1, 'paystatus' => $log['paystatus'] != 0 ? 0 : -1, 'creditstatus' => 0 < $log['creditpay'] ? 0 : -1, 'createtime' => time(), 'getfrom' => 2);
			pdo_insert('ewei_shop_coupon_log', $couponlog);
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $log['openid'], 'merchid' => $_GPC['merchid'], 'couponid' => $log['couponid'], 'gettype' => 2, 'gettime' => time());
			pdo_insert('ewei_shop_coupon_data', $data);
			$this->sethasnewcoupon($log['openid'], 1);
			$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id limit 1', array(':id' => $log['couponid']));
			$coupon = $this->setCoupon($coupon, time());
			$this->sendMessage($coupon, 1, $member);
			pdo_update('ewei_shop_creditshop_log', array('status' => 3), array('id' => $logid));
		}
	}

	public function taskposter($member, $couponid, $couponnum)
	{
		global $_W;
		global $_GPC;
		$pposter = p('poster');

		if (!$pposter) {
			return NULL;
		}

		$coupon = $this->getCoupon($couponid);

		if (empty($coupon)) {
			return NULL;
		}

		$i = 1;

		while ($i <= $couponnum) {
			$couponlog = array('uniacid' => $_W['uniacid'], 'openid' => $member['openid'], 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $couponid, 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => 3);
			pdo_insert('ewei_shop_coupon_log', $couponlog);
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $member['openid'], 'couponid' => $couponid, 'gettype' => 3, 'gettime' => time(), 'nocount' => 1);
			pdo_insert('ewei_shop_coupon_data', $data);
			$this->sethasnewcoupon($member['openid'], 1);
			++$i;
		}
	}

	public function getAvailableCoupons($type, $money = 0, $merch_array, $goods_array = array())
	{
		global $_W;
		global $_GPC;
		$time = time();
		$param = array();
		$param[':openid'] = $_W['openid'];
		$param[':uniacid'] = $_W['uniacid'];
		$sql = 'select d.id,d.couponid,d.gettime,c.timelimit,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb,c.merchid,c.limitgoodcatetype,c.limitgoodtype,c.limitgoodcateids,c.limitgoodids  from ' . tablename('ewei_shop_coupon_data') . ' d';
		$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
		$sql .= ' where d.openid=:openid and d.uniacid=:uniacid and c.merchid=0 and d.merchid=0 and c.coupontype=' . $type . ' and d.used=0 ';

		if ($type == 1) {
			$sql .= 'and ' . $money . '>=c.enough ';
		}

		$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . ')) order by d.gettime desc';
		$list = pdo_fetchall($sql, $param);

		if (!empty($merch_array)) {
			foreach ($merch_array as $key => $value) {
				$merchid = $key;

				if (0 < $merchid) {
					$param[':merchid'] = $merchid;
					$sql = 'select d.id,d.couponid,d.gettime,c.timelimit,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb,c.merchid,c.limitgoodcatetype,c.limitgoodtype,c.limitgoodcateids,c.limitgoodids  from ' . tablename('ewei_shop_coupon_data') . ' d';
					$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
					$sql .= ' where d.openid=:openid and d.uniacid=:uniacid and c.merchid=:merchid and d.merchid=:merchid and c.coupontype=' . $type . '  and d.used=0 ';
					$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . ')) order by d.gettime desc';
					$merch_list = pdo_fetchall($sql, $param);

					if (!empty($merch_list)) {
						$list = array_merge($list, $merch_list);
					}
				}
			}
		}

		$goodlist = array();

		if (!empty($goods_array)) {
			foreach ($goods_array as $key => $value) {
				$goodparam[':uniacid'] = $_W['uniacid'];
				$goodparam[':id'] = $value['goodsid'];
				$sql = 'select id,`type`,cates,marketprice,merchid   from ' . tablename('ewei_shop_goods');
				$sql .= ' where uniacid=:uniacid and id =:id order by id desc LIMIT 1 ';
				$good = pdo_fetch($sql, $goodparam);
				$good['saletotal'] = $value['total'];
				$good['optionid'] = $value['optionid'];

				if ($good['type'] == 4) {
					$good['marketprice'] = $value['wholesaleprice'];
				}

				if (!empty($good)) {
					$goodlist[] = $good;
				}
			}
		}

		if ($type == 0) {
			$list = $this->checkcouponlimit($list, $goodlist);
		}

		$list = set_medias($list, 'thumb');

		if (!empty($list)) {
			foreach ($list as &$row) {
				$row['thumb'] = tomedia($row['thumb']);
				$row['timestr'] = '永久有效';

				if (empty($row['timelimit'])) {
					if (!empty($row['timedays'])) {
						$row['timestr'] = date('Y-m-d H:i', $row['gettime'] + $row['timedays'] * 86400);
					}
				}
				else if ($time <= $row['timestart']) {
					$row['timestr'] = date('Y-m-d H:i', $row['timestart']) . '-' . date('Y-m-d H:i', $row['timeend']);
				}
				else {
					$row['timestr'] = date('Y-m-d H:i', $row['timeend']);
				}

				if ($row['backtype'] == 0) {
					$row['backstr'] = '立减';
					$row['css'] = 'deduct';
					$row['backmoney'] = (double) $row['deduct'];
					$row['backpre'] = true;

					if ($row['enough'] == '0') {
						$row['color'] = 'org ';
					}
					else {
						$row['color'] = 'blue';
					}
				}
				else if ($row['backtype'] == 1) {
					$row['backstr'] = '折';
					$row['css'] = 'discount';
					$row['backmoney'] = (double) $row['discount'];
					$row['color'] = 'red ';
				}
				else {
					if ($row['backtype'] == 2) {
						if ($row['coupontype'] == '0') {
							$row['color'] = 'red ';
						}
						else {
							$row['color'] = 'pink ';
						}

						if (0 < $row['backredpack']) {
							$row['backstr'] = '返现';
							$row['css'] = 'redpack';
							$row['backmoney'] = (double) $row['backredpack'];
							$row['backpre'] = true;
						}
						else if (0 < $row['backmoney']) {
							$row['backstr'] = '返利';
							$row['css'] = 'money';
							$row['backmoney'] = (double) $row['backmoney'];
							$row['backpre'] = true;
						}
						else {
							if (!empty($row['backcredit'])) {
								$row['backstr'] = '返积分';
								$row['css'] = 'credit';
								$row['backmoney'] = (double) $row['backcredit'];
							}
						}
					}
				}
			}

			unset($row);
		}

		return $list;
	}

	public function checkcouponlimit($list, $goodlist)
	{
		global $_W;

		foreach ($list as $key => $row) {
			$pass = 0;
			$enough = 0;
			if ($row['limitgoodcatetype'] == 0 && $row['limitgoodtype'] == 0 && $row['enough'] == 0) {
				$pass = 1;
			}
			else {
				foreach ($goodlist as $good) {
					if (0 < $row['merchid'] && 0 < $good['merchid'] && $row['merchid'] != $good['merchid']) {
						continue;
					}

					$p = 0;
					$cates = explode(',', $good['cates']);
					$limitcateids = explode(',', $row['limitgoodcateids']);
					$limitgoodids = explode(',', $row['limitgoodids']);
					if ($row['limitgoodcatetype'] == 0 && $row['limitgoodtype'] == 0) {
						$p = 1;
					}

					if ($row['limitgoodcatetype'] == 1) {
						$result = array_intersect($cates, $limitcateids);

						if (0 < count($result)) {
							$p = 1;
						}
					}

					if ($row['limitgoodtype'] == 1) {
						$isin = in_array($good['id'], $limitgoodids);

						if ($isin) {
							$p = 1;
						}
					}

					if ($p == 1) {
						$pass = 1;
					}

					if (0 < $row['enough'] && $p == 1) {
						if (0 < $good['optionid'] && $good['type'] != 4) {
							$optionparam[':uniacid'] = $_W['uniacid'];
							$optionparam[':id'] = $good['optionid'];
							$sql = 'select  marketprice  from ' . tablename('ewei_shop_goods_option');
							$sql .= ' where uniacid=:uniacid and id =:id order by id desc LIMIT 1 ';
							$option = pdo_fetch($sql, $optionparam);

							if (!empty($option)) {
								$enough += (double) $option['marketprice'] * $good['saletotal'];
							}
						}
						else {
							$enough += (double) $good['marketprice'] * $good['saletotal'];
						}
					}
				}

				if (0 < $row['enough'] && $enough < $row['enough']) {
					$pass = 0;
				}
			}

			if ($pass == 0) {
				unset($list[$key]);
			}
		}

		return array_values($list);
	}

	public function payResult($logno)
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
		$coupon = $this->setCoupon($coupon, time());

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
			$this->sethasnewcoupon($log['openid'], 1);
			$coupon['dataid'] = $dataid;
			$member = m('member')->getMember($log['openid']);
			$set = m('common')->getPluginset('coupon');
			$this->sendMessage($coupon, 1, $member);
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

	public function sendMessage($coupon, $send_total, $member, $account = NULL)
	{
		global $_W;
		$articles = array();
		$title = str_replace('[nickname]', $member['nickname'], $coupon['resptitle']);
		$desc = str_replace('[nickname]', $member['nickname'], $coupon['respdesc']);
		$title = str_replace('[total]', $send_total, $title);
		$desc = str_replace('[total]', $send_total, $desc);
		$siteroot = $_W['siteroot'];

		if (strexists($siteroot, '/addons/ewei_shopv2/')) {
			$replace_str = array('/addons/ewei_shopv2/');
			$siteroot = str_replace($replace_str, '/', trim($siteroot));
			$_W['siteroot'] = $siteroot;
		}

		$url = empty($coupon['respurl']) ? mobileUrl('sale/coupon/my', NULL, true) : $coupon['respurl'];
		$picurl = tomedia($coupon['respthumb']);

		if (!strexists($picurl, 'http')) {
			$picurl = $this->spec_tomedia($coupon['respthumb']);
		}

		if (!empty($coupon['resptitle'])) {
			$articles[] = array('title' => urlencode($title), 'description' => urlencode($desc), 'url' => $url, 'picurl' => $picurl);
		}

		if (!empty($articles)) {
			$resp = m('message')->sendNews($member['openid'], $articles, $account);

			if (is_error($resp)) {
				$templateid = $coupon['templateid'];
				$msg = array(
					'first'    => array('value' => '亲爱的' . $member['nickname'] . '恭喜您获得优惠券', 'color' => '#ff0000'),
					'keyword1' => array('title' => '业务类型', 'value' => '优惠券通知', 'color' => '#000000'),
					'keyword2' => array('title' => '处理进度', 'value' => '获得' . $coupon['couponname'], 'color' => '#000000'),
					'keyword3' => array('title' => '处理内容', 'value' => $desc, 'color' => '#4b9528'),
					'remark'   => array('value' => '点击查看详情', 'color' => '#000000')
				);

				if (!empty($templateid)) {
					m('message')->sendTplNotice($member['openid'], $templateid, $msg, $url);
				}
			}
		}
	}

	public function sendBackMessage($openid, $coupon, $gives)
	{
		global $_W;

		if (empty($gives)) {
			return NULL;
		}

		$set = m('common')->getPluginset('coupon');
		$templateid = $set['templateid'];
		$content = '您的优惠券【' . $coupon['couponname'] . '】已返利 ';
		$givestr = '';

		if (isset($gives['credit'])) {
			$givestr .= ' ' . $gives['credit'] . '个积分';
		}

		if (isset($gives['money'])) {
			if (!empty($givestr)) {
				$givestr .= '，';
			}

			$givestr .= $gives['money'] . '元余额';
		}

		if (isset($gives['redpack'])) {
			if (!empty($givestr)) {
				$givestr .= '，';
			}

			$givestr .= $gives['redpack'] . '元现金';
		}

		$content .= $givestr;
		$content .= '，请查看您的账户，谢谢!';
		$msg = array(
			'keyword1' => array('value' => '优惠券返利', 'color' => '#73a68d'),
			'keyword2' => array('value' => $content, 'color' => '#73a68d'),
			'keyword3' => array('value' => date('Y-m-d H:i:s'), 'color' => '#000000')
		);
		$url = mobileUrl('member', NULL, true);

		if (!empty($templateid)) {
			m('message')->sendTplNotice($openid, $templateid, $msg, $url);
		}
		else {
			m('message')->sendCustomNotice($openid, $msg, $url);
		}
	}

	public function sendReturnMessage($openid, $coupon)
	{
		global $_W;
		$set = m('common')->getPluginset('coupon');
		$templateid = $set['templateid'];
		$msg = array(
			'keyword1' => array('value' => '优惠券退回', 'color' => '#73a68d'),
			'keyword2' => array('value' => '您的优惠券【' . $coupon['couponname'] . '】已退回您的账户，您可以再次使用, 谢谢!', 'color' => '#73a68d'),
			'keyword3' => array('value' => date('Y-m-d H:i:s'), 'color' => '#000000')
		);
		$url = mobileUrl('sale/coupon/my', NULL, true);

		if (!empty($templateid)) {
			m('message')->sendTplNotice($openid, $templateid, $msg, $url);
		}
		else {
			m('message')->sendCustomNotice($openid, $msg, $url);
		}
	}

	public function useRechargeCoupon($log)
	{
		global $_W;

		if (empty($log['couponid'])) {
			return NULL;
		}

		$data = pdo_fetch('select id,openid,couponid,used from ' . tablename('ewei_shop_coupon_data') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log['couponid'], ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			return NULL;
		}

		if (!empty($data['used'])) {
			return NULL;
		}

		$coupon = pdo_fetch('select enough,backcredit,backmoney,backredpack,couponname from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $data['couponid'], ':uniacid' => $_W['uniacid']));

		if (empty($coupon)) {
			return NULL;
		}

		if (0 < $coupon['enough'] && $log['money'] < $coupon['enough']) {
			return NULL;
		}

		$gives = array();
		$backcredit = $coupon['backcredit'];

		if (!empty($backcredit)) {
			if (strexists($backcredit, '%')) {
				$backcredit = intval(floatval(str_replace('%', '', $backcredit)) / 100 * $log['money']);
			}
			else {
				$backcredit = intval($backcredit);
			}

			if (0 < $backcredit) {
				$gives['credit'] = $backcredit;
				m('member')->setCredit($data['openid'], 'credit1', $backcredit, array(0, '充值优惠券返积分'));
			}
		}

		$backmoney = $coupon['backmoney'];

		if (!empty($backmoney)) {
			if (strexists($backmoney, '%')) {
				$backmoney = round(floatval(floatval(str_replace('%', '', $backmoney)) / 100 * $log['money']), 2);
			}
			else {
				$backmoney = round(floatval($backmoney), 2);
			}

			if (0 < $backmoney) {
				$gives['money'] = $backmoney;
				m('member')->setCredit($data['openid'], 'credit2', $backmoney, array(0, '充值优惠券返利'));
			}
		}

		$backredpack = $coupon['backredpack'];

		if (!empty($backredpack)) {
			if (strexists($backredpack, '%')) {
				$backredpack = round(floatval(floatval(str_replace('%', '', $backredpack)) / 100 * $log['money']), 2);
			}
			else {
				$backredpack = round(floatval($backredpack), 2);
			}

			if (0 < $backredpack) {
				$gives['redpack'] = $backredpack;
				$backredpack = intval($backredpack * 100);
				m('finance')->pay($data['openid'], 1, $backredpack, '', '充值优惠券-返现金', false);
			}
		}

		pdo_update('ewei_shop_coupon_data', array('used' => 1, 'usetime' => time(), 'ordersn' => $log['logno']), array('id' => $data['id']));
		$this->posterbyusesendtask($data['couponid'], $_W['openid']);
		$this->sendBackMessage($log['openid'], $coupon, $gives);
		if (!empty($backcredit) || !empty($backmoney)) {
			$account = m('common')->getAccount();
			$member = m('member')->getMember($log['openid']);
			$text = '亲爱的' . $member['nickname'] . '，您使用了' . $coupon['couponname'] . '  贈送您';

			if (!empty($backcredit)) {
				$text .= $backcredit . '积分  ';
			}

			if (!empty($backmoney)) {
				$text .= $backmoney . '余额  ';
			}

			m('message')->sendTexts($log['openid'], $text, '', $account);
		}
	}

	public function consumeCouponCount($openid, $money = 0, $merch_array, $goods_array)
	{
		global $_W;
		global $_GPC;
		$time = time();
		$param = array();
		$param[':openid'] = $openid;
		$param[':uniacid'] = $_W['uniacid'];
		$sql = 'select d.id,d.couponid,c.enough,c.merchid,c.limitgoodtype,c.limitgoodcatetype,c.limitgoodcateids,c.limitgoodids  from ' . tablename('ewei_shop_coupon_data') . ' d';
		$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
		$sql .= ' where d.openid=:openid and d.uniacid=:uniacid and c.merchid=0 and d.merchid=0 and c.coupontype=0 and d.used=0 ';
		$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . ')) order by d.gettime desc';
		$list = pdo_fetchall($sql, $param);

		if (!empty($merch_array)) {
			foreach ($merch_array as $key => $value) {
				$merchid = $key;

				if (0 < $merchid) {
					$ggprice = $value['ggprice'];
					$param[':merchid'] = $merchid;
					$sql = 'select d.id,d.couponid,c.enough,c.merchid,c.limitgoodtype,c.limitgoodcatetype,c.limitgoodcateids,c.limitgoodids  from ' . tablename('ewei_shop_coupon_data') . ' d';
					$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
					$sql .= ' where d.openid=:openid and d.uniacid=:uniacid and c.merchid=:merchid and d.merchid=:merchid and c.coupontype=0  and d.used=0 ';
					$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . '))';
					$merch_list = pdo_fetchall($sql, $param);

					if (!empty($merch_list)) {
						$list = array_merge($list, $merch_list);
					}
				}
			}
		}

		$goodlist = array();

		if (!empty($goods_array)) {
			foreach ($goods_array as $key => $value) {
				$goodparam[':uniacid'] = $_W['uniacid'];
				$goodparam[':id'] = $value['goodsid'];
				$sql = 'select id,cates,marketprice,merchid,`type`  from ' . tablename('ewei_shop_goods');
				$sql .= ' where uniacid=:uniacid and id =:id order by id desc LIMIT 1 ';
				$good = pdo_fetch($sql, $goodparam);
				$good['saletotal'] = $value['total'];
				$good['optionid'] = $value['optionid'];

				if ($good['type'] == 4) {
					$good['marketprice'] = $value['wholesaleprice'];
				}

				if (!empty($good)) {
					$goodlist[] = $good;
				}
			}
		}

		$list = $this->checkcouponlimit($list, $goodlist);
		return count($list);
	}

	public function rechargeCouponCount($openid, $money = 0)
	{
		global $_W;
		global $_GPC;
		$time = time();
		$sql = 'select count(*) from ' . tablename('ewei_shop_coupon_data') . ' d ' . '  left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id ' . ('  where d.openid=:openid and d.uniacid=:uniacid and  c.coupontype=1 and ' . $money . '>=c.enough and d.used=0 ') . (' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . '))');
		return pdo_fetchcolumn($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid']));
	}

	public function useConsumeCoupon($orderid = 0)
	{
		global $_W;
		global $_GPC;

		if (empty($orderid)) {
			return NULL;
		}

		$order = pdo_fetch('select ordersn,createtime,couponid from ' . tablename('ewei_shop_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid']));

		if (empty($order)) {
			return NULL;
		}

		$coupon = false;

		if (!empty($order['couponid'])) {
			$coupon = $this->getCouponByDataID($order['couponid']);
		}

		if (empty($coupon)) {
			return NULL;
		}

		pdo_update('ewei_shop_coupon_data', array('used' => 1, 'usetime' => $order['createtime'], 'ordersn' => $order['ordersn']), array('id' => $order['couponid']));
		$this->posterbyusesendtask($coupon['id'], $_W['openid']);
	}

	public function returnConsumeCoupon($order)
	{
		global $_W;

		if (!is_array($order)) {
			$order = pdo_fetch('select id,openid,ordersn,createtime,couponid,status,finishtime from ' . tablename('ewei_shop_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1', array(':id' => intval($order), ':uniacid' => $_W['uniacid']));
		}

		if (empty($order)) {
			return NULL;
		}

		$coupon = $this->getCouponByDataID($order['couponid']);

		if (empty($coupon)) {
			return NULL;
		}

		if (!empty($coupon['used']) && $coupon['ordersn'] == $order['ordersn']) {
			pdo_update('ewei_shop_coupon_data', array('used' => 0, 'usetime' => 0, 'ordersn' => ''), array('id' => $order['couponid']));
			$this->sendReturnMessage($order['openid'], $coupon);
		}
	}

	public function backConsumeCoupon($orderid)
	{
		global $_W;

		if (!is_array($orderid)) {
			$order = pdo_fetch('select id,openid,ordersn,createtime,couponid,couponmerchid,status,finishtime,`virtual`,isparent,parentid,coupongoodprice  from ' . tablename('ewei_shop_order') . ' where id=:id and status>=0 and couponid >0 and uniacid=:uniacid limit 1', array(':id' => intval($orderid), ':uniacid' => $_W['uniacid']));
		}

		if (empty($order)) {
			return NULL;
		}

		$couponid = $order['couponid'];
		$couponmerchid = $order['couponmerchid'];
		$isparent = $order['isparent'];
		$parentid = $order['parentid'];
		$finishtime = $order['finishtime'];

		if (empty($couponid)) {
			return NULL;
		}

		$coupon = $this->getCouponByDataID($order['couponid']);

		if ($coupon['backtype'] != 2) {
			return NULL;
		}

		if (empty($coupon)) {
			return NULL;
		}

		if (!empty($coupon['back'])) {
			return NULL;
		}

		$coupongoodprice = 0;

		if ($parentid == 0) {
			$coupongoodprice = $order['coupongoodprice'];
		}

		if ($isparent == 1 || $parentid != 0) {
			$all_done = 1;

			if ($isparent == 1) {
				if (0 < $couponmerchid) {
					$sql = 'select id,openid,ordersn,createtime,couponid,couponmerchid,status,finishtime,`virtual`,isparent,parentid from ' . tablename('ewei_shop_order') . ' where parentid=:parentid and couponmerchid=:couponmerchid and status>=0 and uniacid=:uniacid limit 1';
					$order = pdo_fetch($sql, array(':parentid' => $orderid, ':couponmerchid' => $couponmerchid, ':uniacid' => $_W['uniacid']));

					if (empty($order)) {
						return NULL;
					}

					if ($order['status'] != 3) {
						$all_done = 0;
					}
					else {
						$finishtime = $order['finishtime'];
					}
				}
				else {
					$list = m('order')->getChildOrder($orderid);
				}
			}
			else if (0 < $couponmerchid) {
				if ($order['status'] != 3) {
					$all_done = 0;
				}
				else {
					$finishtime = $order['finishtime'];
				}
			}
			else {
				$list = m('order')->getChildOrder($parentid);
			}

			if (!empty($list)) {
				foreach ($list as $k => $v) {
					if ($v['status'] != 3 && 0 < $v['couponid']) {
						$all_done = 0;
					}
					else {
						if ($finishtime < $v['finishtime']) {
							$finishtime = $v['finishtime'];
						}
					}
				}
			}
		}

		if ($parentid != 0 && $couponmerchid == 0) {
			if ($all_done == 1) {
				$sql = 'select id,openid,ordersn,createtime,couponid,couponmerchid,status,finishtime,`virtual`,isparent,parentid from ' . tablename('ewei_shop_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1';
				$order = pdo_fetch($sql, array(':id' => $parentid, ':uniacid' => $_W['uniacid']));

				if (empty($order)) {
					return NULL;
				}
			}
		}

		$backcredit = $coupon['backcredit'];
		$backmoney = $coupon['backmoney'];
		$backredpack = $coupon['backredpack'];
		$gives = array();
		$canback = false;
		if ($order['status'] == 1 && $coupon['backwhen'] == 2) {
			$canback = true;
		}
		else {
			$is_done = 0;
			if ($isparent == 1 || $parentid != 0) {
				if ($all_done == 1) {
					$is_done = 1;
				}
			}
			else {
				if ($order['status'] == 3) {
					$is_done = 1;
				}
			}

			if ($is_done == 1) {
				if (!empty($order['virtual'])) {
					$canback = true;
				}
				else if ($coupon['backwhen'] == 1) {
					$canback = true;
				}
				else {
					if ($coupon['backwhen'] == 0) {
						$canback = true;
						$tradeset = m('common')->getSysset('trade');
						$refunddays = intval($tradeset['refunddays']);

						if (0 < $refunddays) {
							$days = intval((time() - $finishtime) / 3600 / 24);

							if ($days <= $refunddays) {
								$canback = false;
							}
						}
					}
				}
			}
		}

		if ($canback) {
			if (0 < $parentid) {
				$ordermoney = pdo_fetchcolumn('select coupongoodprice from ' . tablename('ewei_shop_order') . ' where id=:id and status>=0 and couponid >0 and uniacid=:uniacid limit 1', array(':id' => intval($parentid), ':uniacid' => $_W['uniacid']));
			}
			else {
				$ordermoney = $coupongoodprice;
			}

			if ($ordermoney == 0) {
				$sql = 'select ifnull( sum(og.realprice),0) from ' . tablename('ewei_shop_order_goods') . ' og ';
				$sql .= ' left join ' . tablename('ewei_shop_order') . ' o on';
				if ($couponmerchid == 0 && $isparent == 1) {
					$sql .= ' o.id=og.parentorderid ';
				}
				else {
					$sql .= ' o.id=og.orderid ';
				}

				$sql .= ' where o.id=:orderid and o.openid=:openid and o.uniacid=:uniacid ';
				$ordermoney = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $order['openid'], ':orderid' => $order['id']));
			}

			if (!empty($backcredit)) {
				if (strexists($backcredit, '%')) {
					$backcredit = intval(floatval(str_replace('%', '', $backcredit)) / 100 * $ordermoney);
				}
				else {
					$backcredit = intval($backcredit);
				}

				if (0 < $backcredit) {
					$gives['credit'] = $backcredit;
					m('member')->setCredit($order['openid'], 'credit1', $backcredit, array(0, '充值优惠券返积分'));
				}
			}

			if (!empty($backmoney)) {
				if (strexists($backmoney, '%')) {
					$backmoney = round(floatval(floatval(str_replace('%', '', $backmoney)) / 100 * $ordermoney), 2);
				}
				else {
					$backmoney = round(floatval($backmoney), 2);
				}

				if (0 < $backmoney) {
					$gives['money'] = $backmoney;
					m('member')->setCredit($order['openid'], 'credit2', $backmoney, array(0, '购物优惠券返利'));
				}
			}

			if (!empty($backredpack)) {
				if (strexists($backredpack, '%')) {
					$backredpack = round(floatval(floatval(str_replace('%', '', $backredpack)) / 100 * $ordermoney), 2);
				}
				else {
					$backredpack = round(floatval($backredpack), 2);
				}

				if (0 < $backredpack) {
					$gives['redpack'] = $backredpack;
					$backredpack = intval($backredpack * 100);
					m('finance')->pay($order['openid'], 1, $backredpack, '', '购物优惠券-返现金', false);
				}
			}

			pdo_update('ewei_shop_coupon_data', array('back' => 1, 'backtime' => time()), array('id' => $order['couponid']));
			$this->sendBackMessage($order['openid'], $coupon, $gives);
		}
	}

	public function getCoupon($couponid = 0)
	{
		global $_W;
		return pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $couponid, ':uniacid' => $_W['uniacid']));
	}

	public function getCouponByDataID($dataid = 0)
	{
		global $_W;
		$data = pdo_fetch('select id,openid,couponid,used,back,backtime,ordersn from ' . tablename('ewei_shop_coupon_data') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $dataid, ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			return false;
		}

		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $data['couponid'], ':uniacid' => $_W['uniacid']));

		if (empty($coupon)) {
			return false;
		}

		$coupon['back'] = $data['back'];
		$coupon['backtime'] = $data['backtime'];
		$coupon['used'] = $data['used'];
		$coupon['usetime'] = $data['usetime'];
		$coupon['ordersn'] = $data['ordersn'];
		return $coupon;
	}

	public function setCoupon($row, $time, $withOpenid = true)
	{
		global $_W;

		if ($withOpenid) {
			$openid = $_W['openid'];
		}

		$row['free'] = false;
		$row['past'] = false;
		$row['thumb'] = tomedia($row['thumb']);
		$row['merchname'] = '';
		$row['total'] = $this->get_last_count($row['id']);

		if (0 < $row['merchid']) {
			$merch_plugin = p('merch');

			if ($merch_plugin) {
				$merch_user = $merch_plugin->getListUserOne($row['merchid']);

				if (!empty($merch_user)) {
					$row['merchname'] = $merch_user['merchname'];
				}
			}
		}

		if (0 < $row['money'] && 0 < $row['credit']) {
			$row['getstatus'] = 0;
			$row['gettypestr'] = '购买';
		}
		else if (0 < $row['money']) {
			$row['getstatus'] = 1;
			$row['gettypestr'] = '购买';
		}
		else if (0 < $row['credit']) {
			$row['getstatus'] = 2;
			$row['gettypestr'] = '兑换';
		}
		else {
			$row['getstatus'] = 3;
			$row['gettypestr'] = '领取';
		}

		$row['timestr'] = '0';

		if (empty($row['timelimit'])) {
			if (!empty($row['timedays'])) {
				$row['timestr'] = 1;
			}
		}
		else if ($time <= $row['timestart']) {
			$row['timestr'] = date('Y-m-d', $row['timestart']) . '-' . date('Y-m-d', $row['timeend']);
		}
		else {
			$row['timestr'] = date('Y-m-d', $row['timeend']);
		}

		$row['css'] = 'deduct';

		if ($row['backtype'] == 0) {
			$row['backstr'] = '立减';
			$row['css'] = 'deduct';
			$row['backpre'] = true;
			$row['_backmoney'] = $row['deduct'];
		}
		else if ($row['backtype'] == 1) {
			$row['backstr'] = '折';
			$row['css'] = 'discount';
			$row['_backmoney'] = $row['discount'];
		}
		else {
			if ($row['backtype'] == 2) {
				if (!empty($row['backredpack'])) {
					$row['backstr'] = '返现';
					$row['css'] = 'redpack';
					$row['backpre'] = true;
					$row['_backmoney'] = $row['backredpack'];
				}
				else if (!empty($row['backmoney'])) {
					$row['backstr'] = '返利';
					$row['css'] = 'money';
					$row['backpre'] = true;
					$row['_backmoney'] = $row['backmoney'];
				}
				else {
					if (!empty($row['backcredit'])) {
						$row['backstr'] = '返积分';
						$row['css'] = 'credit';
						$row['_backmoney'] = $row['backcredit'];
					}
				}
			}
		}

		if ($withOpenid) {
			$row['cangetmax'] = -1;
			$row['canget'] = true;
			if ($row['total'] != -1 && $row['total'] <= 0) {
				$row['canget'] = false;
				$row['cangetmax'] = -2;
				return $row;
			}

			if (0 < $row['getmax']) {
				$gets = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and openid=:openid and uniacid=:uniacid and gettype=1 limit 1', array(':couponid' => $row['id'], ':openid' => $openid, ':uniacid' => $_W['uniacid']));
				$row['cangetmax'] = $row['getmax'] - $gets;

				if ($row['cangetmax'] <= 0) {
					$row['cangetmax'] = 0;
					$row['canget'] = false;
				}
			}
		}

		return $row;
	}

	public function setMyCoupon($row, $time)
	{
		global $_W;
		$row['past'] = false;
		$row['thumb'] = tomedia($row['thumb']);
		$row['merchname'] = '';

		if (0 < $row['merchid']) {
			$merch_plugin = p('merch');

			if ($merch_plugin) {
				$merch_user = $merch_plugin->getListUserOne($row['merchid']);

				if (!empty($merch_user)) {
					$row['merchname'] = $merch_user['merchname'];
				}
			}
		}

		$row['timestr'] = '';

		if (empty($row['timelimit'])) {
			if (!empty($row['timedays'])) {
				$row['timestr'] = date('Y-m-d', $row['gettime'] + $row['timedays'] * 86400);

				if ($row['gettime'] + $row['timedays'] * 86400 < $time) {
					$row['past'] = true;
				}
			}
		}
		else {
			if ($time <= $row['timestart']) {
				$row['timestr'] = date('Y-m-d H:i', $row['timestart']) . '-' . date('Y-m-d', $row['timeend']);
			}
			else {
				$row['timestr'] = date('Y-m-d H:i', $row['timeend']);
			}

			if ($row['timeend'] < $time) {
				$row['past'] = true;
			}
		}

		$row['css'] = 'deduct';

		if ($row['backtype'] == 0) {
			$row['backstr'] = '立减';
			$row['css'] = 'deduct';
			$row['backpre'] = true;
			$row['_backmoney'] = $row['deduct'];
		}
		else if ($row['backtype'] == 1) {
			$row['backstr'] = '折';
			$row['css'] = 'discount';
			$row['_backmoney'] = $row['discount'];
		}
		else {
			if ($row['backtype'] == 2) {
				if (!empty($row['backredpack'])) {
					$row['backstr'] = '返现';
					$row['css'] = 'redpack';
					$row['backpre'] = true;
					$row['_backmoney'] = $row['backredpack'];
				}
				else if (!empty($row['backmoney'])) {
					$row['backstr'] = '返利';
					$row['css'] = 'money';
					$row['backpre'] = true;
					$row['_backmoney'] = $row['backmoney'];
				}
				else {
					if (!empty($row['backcredit'])) {
						$row['backstr'] = '返积分';
						$row['css'] = 'credit';
						$row['_backmoney'] = $row['backcredit'];
					}
				}
			}
		}

		if ($row['past']) {
			$row['css'] = 'past';
		}

		return $row;
	}

	public function setShare()
	{
		global $_W;
		global $_GPC;
		$set = m('common')->getPluginset('coupon');
		$openid = $_W['openid'];
		$url = mobileUrl('sale/coupon', NULL, true);
		$_W['shopshare'] = array('title' => $set['title'], 'imgUrl' => tomedia($set['icon']), 'desc' => $set['desc'], 'link' => $url);

		if (p('commission')) {
			$pset = p('commission')->getSet();

			if (!empty($pset['level'])) {
				$member = m('member')->getMember($openid);
				if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
					$_W['shopshare']['link'] = $url . '&mid=' . $member['id'];
					if (empty($pset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
						$trigger = true;
					}
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = $url . '&mid=' . $_GPC['id'];
					}
				}
			}
		}
	}

	public function perms()
	{
		return array(
			'coupon' => array(
				'text'     => $this->getName(),
				'isplugin' => true,
				'child'    => array(
					'coupon'   => array('text' => '优惠券', 'view' => '查看', 'add' => '添加优惠券-log', 'edit' => '编辑优惠券-log', 'delete' => '删除优惠券-log', 'send' => '发放优惠券-log'),
					'category' => array('text' => '分类', 'view' => '查看', 'add' => '添加分类-log', 'edit' => '编辑分类-log', 'delete' => '删除分类-log'),
					'log'      => array('text' => '优惠券记录', 'view' => '查看', 'export' => '导出-log'),
					'center'   => array('text' => '领券中心设置', 'view' => '查看设置', 'save' => '保存设置-log'),
					'set'      => array('text' => '基础设置', 'view' => '查看设置', 'save' => '保存设置-log')
				)
			)
		);
	}

	public function addtaskdata($orderid)
	{
		global $_W;
		$pdata = m('common')->getPluginset('coupon');
		$order = pdo_fetch('select id,openid,price  from ' . tablename('ewei_shop_order') . ' where id=:id   and uniacid=:uniacid limit 1', array(':id' => intval($orderid), ':uniacid' => $_W['uniacid']));

		if (empty($order)) {
			return NULL;
		}

		if ($pdata['isopensendtask'] == 1) {
			$price = $order['price'];
			$sendtasks = pdo_fetch('select id,couponid,sendnum,num,sendpoint  from ' . tablename('ewei_shop_coupon_sendtasks') . '
             where  status =1  and uniacid=:uniacid and starttime< :now and endtime>:now and enough<=:enough   and num>=sendnum
             order by  enough desc,id  limit 1', array(':now' => time(), ':enough' => $price, ':uniacid' => $_W['uniacid']));

			if (!empty($sendtasks)) {
				$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'taskid' => intval($sendtasks['id']), 'couponid' => intval($sendtasks['couponid']), 'parentorderid' => 0, 'sendnum' => intval($sendtasks['sendnum']), 'tasktype' => 1, 'orderid' => $orderid, 'createtime' => time(), 'status' => 0, 'sendpoint' => intval($sendtasks['sendpoint']));
				pdo_insert('ewei_shop_coupon_taskdata', $data);
				$num = intval($sendtasks['num']) - intval($sendtasks['sendnum']);
				pdo_update('ewei_shop_coupon_sendtasks', array('num' => $num), array('id' => $sendtasks['id']));
			}
		}

		if ($pdata['isopengoodssendtask'] == 1) {
			$goodssendtasks = pdo_fetchall('select  og.id,og.goodsid,og.orderid,og.parentorderid,og.total,gst.id as taskid,gst.couponid,gst.sendnum,gst.sendpoint,gst.num
            from ' . tablename('ewei_shop_coupon_goodsendtask') . ' gst
            inner join ' . tablename('ewei_shop_order_goods') . ' og on og.goodsid =gst.goodsid  and (orderid=:orderid or parentorderid=:orderid)
            where  og.uniacid=:uniacid and og.openid=:openid and gst.num>=gst.sendnum and gst.status = 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':orderid' => $orderid));

			foreach ($goodssendtasks as $task) {
				$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'taskid' => intval($task['taskid']), 'couponid' => intval($task['couponid']), 'sendnum' => intval($task['total']) * intval($task['sendnum']), 'tasktype' => 2, 'orderid' => intval($task['orderid']), 'parentorderid' => intval($task['parentorderid']), 'createtime' => time(), 'status' => 0, 'sendpoint' => intval($task['sendpoint']));
				pdo_insert('ewei_shop_coupon_taskdata', $data);
				$num = intval($task['num']) - intval($task['total']) * intval($task['sendnum']);
				pdo_update('ewei_shop_coupon_goodsendtask', array('num' => $num), array('id' => $task['taskid']));
			}
		}
	}

	public function sendcouponsbytask($orderid)
	{
		global $_W;

		if (!is_array($orderid)) {
			$order = pdo_fetch('select id,openid,ordersn,createtime,status,finishtime,`virtual`,isvirtualsend,isparent,parentid  from ' . tablename('ewei_shop_order') . ' where id=:id and status>=0  and uniacid=:uniacid limit 1', array(':id' => intval($orderid), ':uniacid' => $_W['uniacid']));
		}

		if (empty($order)) {
			return NULL;
		}

		$isonlyverifygoods = false;

		if ($order['status'] == 2) {
			$sql = 'SELECT goodsid FROM ' . tablename('ewei_shop_order_goods') . ' WHERE uniacid=:uniacid AND orderid=:orderid ';
			$goodsids = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']));

			foreach ($goodsids as $gidk => $gidv) {
				$gtype = pdo_fetch('SELECT type FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $gidv['goodsid']));

				if ($gtype['type'] == 5) {
					$isonlyverifygoods = true;
				}
			}
		}

		$parentid = $order['parentid'];
		$gosendtask = false;
		if ($isonlyverifygoods || $order['status'] == 1) {
			$gosendtask = true;
			$sendpoint = 2;
		}
		else {
			if ($order['status'] == 3) {
				if (0 < $parentid) {
					$num = pdo_fetchcolumn('select 1 from ' . tablename('ewei_shop_order') . '
                where parentid =:parentid and uniacid=:uniacid  and openid=:openid  and status<>3', array(':parentid' => intval($parentid), ':uniacid' => $_W['uniacid'], ':openid' => $order['openid']));

					if (empty($num)) {
						$gosendtask = true;
						$sendpoint = 1;
					}
				}
				else {
					$gosendtask = true;
					$sendpoint = 1;
				}
			}
		}

		if ($gosendtask) {
			if ($order['status'] == 3 && (!empty($order['isvirtualsend']) || !empty($order['virtual']))) {
				$lista = $this->getOrderSendCoupons($orderid, 1, 1, $order['openid']);
				$listb = $this->getOrderSendCoupons($orderid, 2, 1, $order['openid']);
				$list = array_merge($lista, $listb);
			}
			else {
				$list = $this->getOrderSendCoupons($orderid, $sendpoint, 1, $order['openid']);
			}

			if (!empty($list) && 0 < count($list)) {
				$this->posterbylist($list, $order['openid'], 6);
			}
		}

		if ($order['status'] == 3 && (!empty($order['isvirtualsend']) || !empty($order['virtual']))) {
			$list2a = $this->getOrderSendCoupons($orderid, 1, 2, $order['openid']);
			$list2b = $this->getOrderSendCoupons($orderid, 2, 2, $order['openid']);
			$list2 = array_merge($list2a, $list2b);
		}
		else {
			$list2 = $this->getOrderSendCoupons($orderid, $sendpoint, 2, $order['openid']);
		}

		if (!empty($list2) && 0 < count($list2)) {
			$this->posterbylist($list2, $order['openid'], 6);
		}
	}

	public function getOrderSendCoupons($orderid, $sendpoint, $tasktype, $openid)
	{
		global $_W;

		if ($sendpoint == 2) {
			$taskdata = pdo_fetchall('select id, couponid, sendnum  from ' . tablename('ewei_shop_coupon_taskdata') . '
            where  status=0  and openid=:openid and uniacid=:uniacid and sendpoint=:sendpoint and tasktype=:tasktype
            and (orderid=:orderid or parentorderid=:orderid)', array(':openid' => $openid, ':uniacid' => $_W['uniacid'], ':sendpoint' => $sendpoint, ':tasktype' => $tasktype, ':orderid' => $orderid));
		}
		else {
			$taskdata = pdo_fetchall('select  id, couponid, sendnum  from ' . tablename('ewei_shop_coupon_taskdata') . '
            where  status=0  and openid=:openid and uniacid=:uniacid and sendpoint=:sendpoint and tasktype=:tasktype
            and orderid=:orderid', array(':openid' => $openid, ':uniacid' => $_W['uniacid'], ':sendpoint' => $sendpoint, ':tasktype' => $tasktype, ':orderid' => $orderid));
		}

		return $taskdata;
	}

	public function poster($member, $couponid, $couponnum, $gettype = 0)
	{
		global $_W;
		global $_GPC;
		$pposter = p('poster');

		if (!$pposter) {
			return NULL;
		}

		$coupon = $this->getCoupon($couponid);

		if (empty($coupon)) {
			return NULL;
		}

		$i = 1;

		while ($i <= $couponnum) {
			$couponlog = array('uniacid' => $_W['uniacid'], 'openid' => $member['openid'], 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $couponid, 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => $gettype);
			pdo_insert('ewei_shop_coupon_log', $couponlog);
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $member['openid'], 'couponid' => $couponid, 'gettype' => $gettype, 'gettime' => time());
			pdo_insert('ewei_shop_coupon_data', $data);
			$this->sethasnewcoupon($member['openid'], 1);
			++$i;
		}

		$set = m('common')->getPluginset('coupon');
		$this->sendMessage($coupon, $couponnum, $member);
	}

	public function posterbylist($list, $openid, $gettype)
	{
		global $_W;
		global $_GPC;
		$num = 0;
		$showkey = random(20);
		$data = m('common')->getPluginset('coupon');
		if (empty($data['showtemplate']) || $data['showtemplate'] == 2) {
			$url = $this->getUrl('sale/coupon/my/showcoupons3', array('key' => $showkey), true);
		}
		else {
			$url = $this->getUrl('sale/coupon/my/showcoupons', array('key' => $showkey), true);
		}

		if (strexists($url, '/core/task/order/')) {
			$url = str_replace('/core/task/order/', '/', $url);
		}

		foreach ($list as $taskdata) {
			$couponnum = 0;
			$couponnum = intval($taskdata['sendnum']);
			$num += $couponnum;
			$merchid = pdo_fetchcolumn("select merchid from " . tablename("ewei_shop_coupon") . " where id=:couponid limit 1", array(":couponid" => $taskdata["couponid"]));
			$i = 1;

			while ($i <= $couponnum) {
				$couponlog = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $taskdata['couponid'], 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => intval($gettype), "merchid" => $merchid);
				pdo_insert('ewei_shop_coupon_log', $couponlog);
				$data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'couponid' => $taskdata['couponid'], 'gettype' => intval($gettype), 'merchid' => $merchid, 'gettime' => time());
				pdo_insert('ewei_shop_coupon_data', $data);
				$coupondataid = pdo_insertid();
				$this->sethasnewcoupon($openid, 1);
				$data = array('showkey' => $showkey, 'uniacid' => $_W['uniacid'], 'openid' => $openid, 'coupondataid' => $coupondataid);
				pdo_insert('ewei_shop_coupon_sendshow', $data);
				++$i;
			}

			pdo_update('ewei_shop_coupon_taskdata', array('status' => 1), array('id' => $taskdata['id']));
		}

		$msg = '恭喜您获得' . $num . '张优惠券!';
		$ret = m('message')->sendCustomNotice($openid, $msg, $url);
	}

	public function posterbyusesendtask($couponid, $openid)
	{
		global $_W;
		global $_GPC;
		$pdata = m('common')->getPluginset('coupon');

		if ($pdata['isopenusesendtask'] == 0) {
			return NULL;
		}

		$list = pdo_fetchall('select  *  from ' . tablename('ewei_shop_coupon_usesendtasks') . '
            where  status=1  and  usecouponid= :usecouponid and uniacid=:uniacid and starttime< :now and endtime>:now   and num>=sendnum
             order by  id', array(':usecouponid' => $couponid, ':now' => time(), ':uniacid' => $_W['uniacid']));

		if (empty($list)) {
			return NULL;
		}

		$gettype = 6;
		$num = 0;
		$showkey = random(20);
		$data = m('common')->getPluginset('coupon');
		if (empty($data['showtemplate']) || $data['showtemplate'] == 2) {
			$url = $this->getUrl('sale/coupon/my/showcoupons3', array('key' => $showkey), true);
		}
		else {
			$url = $this->getUrl('sale/coupon/my/showcoupons', array('key' => $showkey), true);
		}

		foreach ($list as $taskdata) {
			$couponnum = 0;
			$couponnum = intval($taskdata['sendnum']);
			$num += $couponnum;
			$i = 1;

			while ($i <= $couponnum) {
				$couponlog = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $taskdata['couponid'], 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => intval($gettype));
				pdo_insert('ewei_shop_coupon_log', $couponlog);
				$data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'couponid' => $taskdata['couponid'], 'gettype' => intval($gettype), 'gettime' => time());
				pdo_insert('ewei_shop_coupon_data', $data);
				$coupondataid = pdo_insertid();
				$this->sethasnewcoupon($openid, 1);
				$data = array('showkey' => $showkey, 'uniacid' => $_W['uniacid'], 'openid' => $openid, 'coupondataid' => $coupondataid);
				pdo_insert('ewei_shop_coupon_sendshow', $data);
				++$i;
			}

			$num2 = intval($taskdata['num']) - intval($taskdata['sendnum']);
			pdo_update('ewei_shop_coupon_usesendtasks', array('num' => $num2), array('id' => $taskdata['id']));
		}

		$msg = '恭喜您获得' . $num . '张优惠券!';
		$ret = m('message')->sendCustomNotice($openid, $msg, $url);
	}

	public function getCashierCoupons($openid, $money = 0, $merchid = 0)
	{
		global $_W;
		global $_GPC;
		$time = time();
		$param = array();
		$param[':openid'] = $openid;
		$param[':uniacid'] = $_W['uniacid'];
		$param[':merchid'] = $merchid;
		$sql = 'select d.id,d.couponid,d.gettime,c.timelimit,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb,c.merchid,c.limitgoodcatetype,c.limitgoodtype,c.limitgoodcateids,c.limitgoodids  from ' . tablename('ewei_shop_coupon_data') . ' d';
		$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
		$sql .= ' where d.openid=:openid and d.uniacid=:uniacid and c.merchid=:merchid and d.merchid=:merchid  and c.coupontype=2 and d.used=0 ';

		if (0 < $money) {
			$sql .= 'and ' . $money . '>=c.enough ';
		}

		$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . ')) order by d.gettime desc';
		$list = pdo_fetchall($sql, $param);
		$list = set_medias($list, 'thumb');

		if (!empty($list)) {
			foreach ($list as &$row) {
				$row['thumb'] = tomedia($row['thumb']);
				$row['timestr'] = '永久有效';

				if (empty($row['timelimit'])) {
					if (!empty($row['timedays'])) {
						$row['timestr'] = date('Y-m-d H:i', $row['gettime'] + $row['timedays'] * 86400);
					}
				}
				else if ($time <= $row['timestart']) {
					$row['timestr'] = date('Y-m-d H:i', $row['timestart']) . '-' . date('Y-m-d H:i', $row['timeend']);
				}
				else {
					$row['timestr'] = date('Y-m-d H:i', $row['timeend']);
				}

				if ($row['backtype'] == 0) {
					$row['backstr'] = '立减';
					$row['css'] = 'deduct';
					$row['backmoney'] = $row['deduct'];
					$row['backpre'] = true;

					if ($row['enough'] == '0') {
						$row['color'] = 'org ';
					}
					else {
						$row['color'] = 'blue';
					}
				}
				else if ($row['backtype'] == 1) {
					$row['backstr'] = '折';
					$row['css'] = 'discount';
					$row['backmoney'] = $row['discount'];
					$row['color'] = 'red ';
				}
				else {
					if ($row['backtype'] == 2) {
						if ($row['coupontype'] == '0') {
							$row['color'] = 'red ';
						}
						else {
							$row['color'] = 'pink ';
						}

						if (0 < $row['backredpack']) {
							$row['backstr'] = '返现';
							$row['css'] = 'redpack';
							$row['backmoney'] = $row['backredpack'];
							$row['backpre'] = true;
						}
						else if (0 < $row['backmoney']) {
							$row['backstr'] = '返利';
							$row['css'] = 'money';
							$row['backmoney'] = $row['backmoney'];
							$row['backpre'] = true;
						}
						else {
							if (!empty($row['backcredit'])) {
								$row['backstr'] = '返积分';
								$row['css'] = 'credit';
								$row['backmoney'] = $row['backcredit'];
							}
						}
					}
				}
			}

			unset($row);
		}

		return $list;
	}

	public function getCoupons()
	{
		global $_W;
		$time = time();
		return pdo_fetchall('select * from ' . tablename('ewei_shop_coupon') . ' where  (timelimit = 0  or  (timelimit =1 and timestart<={$time} && timeend>={$time})) and uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
	}

	public function getInfo()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];

		if (empty($openid)) {
			return false;
		}

		$member = m('member')->getMember($_W['openid']);
		$condition = ' WHERE uniacid = :uniacid AND openid = :openid limit 1';
		$paramso = array(':uniacid' => intval($_W['uniacid']), ':openid' => trim($openid));
		$osql = 'SELECT `id` FROM ' . tablename('ewei_shop_order') . $condition;
		$order = pdo_fetchall($osql, $paramso);

		if (empty($order)) {
			$sql2 = 'SELECT * FROM ' . tablename('ewei_shop_sendticket') . ' WHERE uniacid = ' . intval($_W['uniacid']);
			$ticket = pdo_fetch($sql2);

			if ($ticket['status'] == 1) {
				if ($ticket['expiration'] == 1) {
					if ($ticket['endtime'] < TIMESTAMP) {
						$status = array('status' => 0);
						pdo_update('ewei_shop_sendticket', $status, array('id' => $ticket['id']));
						return false;
					}

					$cpinfo = $this->getCoupon_new($ticket['cpid']);

					if (empty($cpinfo)) {
						return false;
					}

					$insert = $this->insertDraw($openid, $cpinfo);

					if ($insert) {
						if (count($cpinfo) == count($cpinfo, 1)) {
							$status = $this->sendTicket($openid, $cpinfo['id'], 14);

							if (!$status) {
								return false;
							}

							$cpinfo['did'] = $status;
						}
						else {
							foreach ($cpinfo as $cpk => $cpv) {
								$status = $this->sendTicket($openid, $cpv['id'], 14);

								if (!$status) {
									return false;
								}

								$cpinfo[$cpk]['did'] = $status;
							}
						}

						if (count($cpinfo) == count($cpinfo, 1)) {
							$cpinfos[] = $cpinfo;
						}
						else {
							$cpinfos = $cpinfo;
						}

						return $cpinfos;
					}

					return false;
				}

				$cpinfo = $this->getCoupon_new($ticket['cpid']);

				if (empty($cpinfo)) {
					return false;
				}

				$insert = $this->insertDraw($openid, $cpinfo);

				if ($insert) {
					if (count($cpinfo) == count($cpinfo, 1)) {
						$status = $this->sendTicket($openid, $cpinfo['id'], 14);

						if (!$status) {
							return false;
						}

						$cpinfo['did'] = $status;
					}
					else {
						foreach ($cpinfo as $cpk => $cpv) {
							$status = $this->sendTicket($openid, $cpv['id'], 14);

							if (!$status) {
								return false;
							}

							$cpinfo[$cpk]['did'] = $status;
						}
					}

					if (count($cpinfo) == count($cpinfo, 1)) {
						$cpinfos[] = $cpinfo;
					}
					else {
						$cpinfos = $cpinfo;
					}

					return $cpinfos;
				}

				return false;
			}

			if ($ticket['status'] == 0) {
				return false;
			}
		}
		else {
			return false;
		}
	}

	public function getCoupon_new($cpid)
	{
		global $_W;
		global $_GPC;

		if (strpos($cpid, ',')) {
			$cpids = explode(',', $cpid);
		}
		else {
			$cpids = $cpid;
		}

		if (is_array($cpids)) {
			$cpinfo = array();

			foreach ($cpids as $cpk => $cpv) {
				$cpsql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND id = ' . intval($cpv);
				$list = pdo_fetch($cpsql);

				if ($list['timelimit'] == 1) {
					if (TIMESTAMP < $list['timeend']) {
						$cpinfo[$cpk] = $list;
					}
				}
				else {
					if ($list['timelimit'] == 0) {
						$cpinfo[$cpk] = $list;
					}
				}
			}

			return $cpinfo;
		}

		$cpsql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND id = ' . intval($cpid);
		$cpinfo = pdo_fetch($cpsql);
		return $cpinfo;
	}

	public function insertDraw($openid, $cpinfo)
	{
		global $_W;
		global $_GPC;

		if (empty($openid)) {
			return false;
		}

		$drawsql = 'SELECT * FROM ' . tablename('ewei_shop_sendticket_draw') . ' WHERE  openid = :openid AND uniacid = :uniacid ';
		$drawparpams = array(':uniacid' => intval($_W['uniacid']), ':openid' => trim($openid));
		$drawdata = pdo_fetch($drawsql, $drawparpams);

		if (empty($drawdata)) {
			$drawcpid = array();

			if (count($cpinfo) == count($cpinfo, 1)) {
				foreach ($cpinfo as $cpk => $cpv) {
					$drawcpid[$cpk] = $cpv;
				}

				$drawcpids = $cpinfo['id'];
			}
			else {
				foreach ($cpinfo as $cpk => $cpv) {
					$drawcpid[$cpk] = $cpv['id'];
				}

				$drawcpids = trim(implode(',', $drawcpid));
			}

			$data = array('uniacid' => intval($_W['uniacid']), 'cpid' => $drawcpids, 'openid' => trim($openid), 'createtime' => TIMESTAMP);
			$insert = pdo_insert('ewei_shop_sendticket_draw', $data);
			return $insert;
		}

		return false;
	}

	public function sendTicket($openid, $couponid, $gettype = 0)
	{
		global $_W;
		global $_GPC;
		$couponlog = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $couponid, 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => 3);
		$log = pdo_insert('ewei_shop_coupon_log', $couponlog);
		$data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'couponid' => $couponid, 'gettype' => $gettype, 'gettime' => time());
		$data = pdo_insert('ewei_shop_coupon_data', $data);
		$did = pdo_insertid();
		$this->sethasnewcoupon($openid, 1);
		if ($log && $data) {
			return $did;
		}

		return false;
	}

	public function share($money)
	{
		$activity = $this->activity($money);

		if (!empty($activity)) {
			return true;
		}

		return false;
	}

	public function activity($money)
	{
		global $_W;
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_sendticket_share') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND status = 1 AND (enough = ' . $money . ' OR enough <= ' . $money . ') AND (expiration = 0 OR (expiration = 1 AND endtime >= ' . TIMESTAMP . ')) ORDER BY enough DESC,createtime DESC LIMIT 1';
		$activity = pdo_fetch($sql);
		return $activity;
	}

	public function getCanGetCouponNum($merchid = 0)
	{
		global $_W;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$time = time();
		$param = array();
		$param[':uniacid'] = $_W['uniacid'];
		$sql = 'select id,timelimit,coupontype,timedays,timestart,timeend,couponname,enough,backtype,deduct,discount,backmoney,backcredit,backredpack,bgcolor,thumb,credit,money,getmax,merchid,total as t,tagtitle,settitlecolor,titlecolor  from ' . tablename('ewei_shop_coupon');
		$sql .= ' where uniacid=:uniacid';

		if ($is_openmerch == 0) {
			$sql .= ' and merchid=0';
		}
		else {
			if (!empty($merchid)) {
				$sql .= ' and merchid=:merchid';
				$param[':merchid'] = intval($merchid);
			}
		}

		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();

			if (empty($plugin_com_set['level'])) {
				$sql .= ' and ( limitagentlevels = "" or  limitagentlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitagentlevels = "" or  limitagentlevels is null )';
		}

		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();

			if (empty($plugin_globonus_set['open'])) {
				$sql .= ' and ( limitpartnerlevels = ""  or  limitpartnerlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitpartnerlevels = ""  or  limitpartnerlevels is null )';
		}

		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();

			if (empty($plugin_abonus_set['open'])) {
				$sql .= ' and ( limitaagentlevels = "" or  limitaagentlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitaagentlevels = "" or  limitaagentlevels is null )';
		}

		$sql .= ' and gettype=1 and (total=-1 or total>0) and ( timelimit = 0 or  (timelimit=1 and timeend>unix_timestamp()))';
		$sql .= ' order by displayorder desc, id desc ';
		$coupons = set_medias(pdo_fetchall($sql, $param), 'thumb');

		if (empty($coupons)) {
			return 0;
		}

		return count($coupons);
	}

	public function sethasnewcoupon($openid, $hasnewcoupon = 0)
	{
		global $_W;
		pdo_update('ewei_shop_member', array('hasnewcoupon' => $hasnewcoupon), array('openid' => $openid, 'uniacid' => $_W['uniacid']));
	}

	public function spec_tomedia($src, $local_path = false)
	{
		global $_W;
		setting_load('remote');

		if (!empty($_W['setting']['remote']['type'])) {
			if ($_W['setting']['remote']['type'] == ATTACH_FTP) {
				$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['ftp']['url'] . '/';
			}
			else if ($_W['setting']['remote']['type'] == ATTACH_OSS) {
				$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['alioss']['url'] . '/';
			}
			else if ($_W['setting']['remote']['type'] == ATTACH_QINIU) {
				$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['qiniu']['url'] . '/';
			}
			else {
				if ($_W['setting']['remote']['type'] == ATTACH_COS) {
					$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['cos']['url'] . '/';
				}
			}
		}

		if (empty($src)) {
			return '';
		}

		if (strexists($src, 'c=utility&a=wxcode&do=image&attach=')) {
			return $src;
		}

		if (strexists($src, 'addons/')) {
			return $_W['siteroot'] . substr($src, strpos($src, 'addons/'));
		}

		if (strexists($src, $_W['siteroot']) && !strexists($src, '/addons/')) {
			$urls = parse_url($src);
			$src = $t = substr($urls['path'], strpos($urls['path'], 'images'));
		}

		$t = strtolower($src);
		if (strexists($t, 'https://mmbiz.qlogo.cn') || strexists($t, 'http://mmbiz.qpic.cn')) {
			$url = url('utility/wxcode/image', array('attach' => $src));
			return $_W['siteroot'] . 'web' . ltrim($url, '.');
		}

		if (substr($t, 0, 7) == 'http://' || substr($t, 0, 8) == 'https://' || substr($t, 0, 2) == '//') {
			return $src;
		}

		if ($local_path || empty($_W['setting']['remote']['type']) || file_exists(IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/' . $src)) {
			$src = $_W['siteroot'] . $_W['config']['upload']['attachdir'] . '/' . $src;
		}
		else {
			$src = $_W['attachurl_remote'] . $src;
		}

		return $src;
	}
}

?>
