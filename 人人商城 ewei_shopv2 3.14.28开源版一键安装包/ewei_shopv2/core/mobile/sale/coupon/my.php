<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class My_EweiShopV2Page extends MobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$set = m('common')->getPluginset('coupon');
		com('coupon')->setShare();
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = pdo_fetch('select * from ' . tablename('ewei_shop_coupon_data') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			if (empty($coupon)) {
				header('location: ' . mobileUrl('sale/coupon/my'));
				exit();
			}
		}

		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $data['couponid'], ':uniacid' => $_W['uniacid']));

		if (empty($coupon)) {
			header('location: ' . mobileUrl('sale/coupon/my'));
			exit();
		}

		$coupon['gettime'] = $data['gettime'];
		$coupon['back'] = $data['back'];
		$coupon['backtime'] = $data['backtime'];
		$coupon['used'] = $data['used'];
		$coupon['usetime'] = $data['usetime'];
		$time = time();
		$coupon = com('coupon')->setMyCoupon($coupon, $time);
		$commonset = m('common')->getPluginset('coupon');

		if ($coupon['descnoset'] == '0') {
			if ($coupon['coupontype'] == '0') {
				$coupon['desc'] = $commonset['consumedesc'];
			}
			else if ($coupon['coupontype'] == '1') {
				$coupon['desc'] = $commonset['rechargedesc'];
			}
			else {
				$coupon['desc'] = $commonset['consumedesc'];
			}
		}

		$title2 = '';
		$title3 = '';

		if ($coupon['coupontype'] == '0') {
			if (0 < $coupon['enough']) {
				$title2 = '满' . (double) $coupon['enough'] . '元';
			}
			else {
				$title2 = '购物任意金额';
			}
		}
		else if ($coupon['coupontype'] == '1') {
			if (0 < $coupon['enough']) {
				$title2 = '充值满' . (double) $coupon['enough'] . '元';
			}
			else {
				$title2 = '充值任意金额';
			}
		}
		else {
			if ($coupon['coupontype'] == '2') {
				if (0 < $coupon['enough']) {
					$title2 = '满' . (double) $coupon['enough'] . '元';
				}
				else {
					$title2 = '购物任意金额';
				}
			}
		}

		if ($coupon['backtype'] == 0) {
			if ($coupon['enough'] == '0') {
				$coupon['color'] = 'orange ';
			}
			else {
				$coupon['color'] = 'blue';
			}

			$title3 = '减' . (double) $coupon['deduct'] . '元';
		}

		if ($coupon['backtype'] == 1) {
			$coupon['color'] = 'red ';
			$title3 = '打' . (double) $coupon['discount'] . '折 ';
		}

		if ($coupon['backtype'] == 2) {
			if ($coupon['coupontype'] == '0' || $coupon['coupontype'] == '2') {
				$coupon['color'] = 'red ';
			}
			else {
				$coupon['color'] = 'pink ';
			}

			if (!empty($coupon['backmoney']) && 0 < $coupon['backmoney']) {
				$title3 = $title3 . '送' . $coupon['backmoney'] . '元余额 ';
			}

			if (!empty($coupon['backcredit']) && 0 < $coupon['backcredit']) {
				$title3 = $title3 . '送' . $coupon['backcredit'] . '积分 ';
			}

			if (!empty($coupon['backredpack']) && 0 < $coupon['backredpack']) {
				$title3 = $title3 . '送' . $coupon['backredpack'] . '元红包 ';
			}
		}

		if ($coupon['past'] || !empty($data['used'])) {
			$coupon['color'] = 'disa';
		}

		$coupon['title2'] = $title2;
		$coupon['title3'] = $title3;
		$goods = array();
		$category = array();

		if ($coupon['limitgoodtype'] != 0) {
			if (!empty($coupon['limitgoodids'])) {
				$where = 'and id in(' . $coupon['limitgoodids'] . ')';
			}

			$goods = pdo_fetchall('select `title` from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid ' . $where, array(':uniacid' => $_W['uniacid']), 'id');
		}

		if ($coupon['limitgoodcatetype'] != 0) {
			if (!empty($coupon['limitgoodcateids'])) {
				$where = 'and id in(' . $coupon['limitgoodcateids'] . ')';
			}

			$category = pdo_fetchall('select `name`  from ' . tablename('ewei_shop_category') . ' where uniacid=:uniacid   ' . $where, array(':uniacid' => $_W['uniacid']), 'id');
		}

		$num = pdo_fetchcolumn('select ifnull(count(*),0) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and openid=:openid and uniacid=:uniacid and used=0 ', array(':couponid' => $coupon['id'], ':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
		$canuse = !$coupon['past'] && empty($data['used']);

		if ($coupon['coupontype'] == 0) {
			$useurl = mobileUrl('sale/coupon/my/showcoupongoods', array('id' => $id));
		}
		else if ($coupon['coupontype'] == 1) {
			$useurl = mobileUrl('member/recharge');
		}
		else {
			if ($coupon['coupontype'] == 2) {
				$useurl = mobileUrl('sale/coupon/my');
			}
		}

		$set = $_W['shopset']['coupon'];
		com('coupon')->setShare();
		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$cate = trim($_GPC['cate']);
		$check = 0;

		if (!empty($cate)) {
			if ($cate == 'used') {
				$used = 1;
				$check = 1;
			}
			else {
				$past = 1;
				$check = 2;
			}
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$time = time();
		$sql = 'select d.id,d.friendcouponid,d.couponid,d.gettime,d.friendcouponid,c.timelimit,c.coupontype,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb,c.merchid,c.tagtitle,c.settitlecolor,c.titlecolor from ' . tablename('ewei_shop_coupon_data') . ' d';
		$sql .= ' inner join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
		$sql .= ' where d.openid=:openid and d.uniacid=:uniacid ';

		if (!empty($past)) {
			$sql .= ' and  ( (c.timelimit =0 and c.timedays<>0 and  c.timedays*86400 + d.gettime <unix_timestamp()) or (c.timelimit=1 and c.timeend<unix_timestamp() ))';
		}
		else if (!empty($used)) {
			$sql .= ' and d.used =1 ';
		}
		else {
			if (empty($used)) {
				$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timeend>=' . $time . ')) and  d.used =0 ';
			}
		}

		$total = pdo_fetchcolumn($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid']));
		$sql .= ' order by d.gettime desc  LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$coupons = set_medias(pdo_fetchall($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid'])), 'thumb');
		pdo_update('ewei_shop_coupon_data', array('isnew' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));

		if (empty($coupons)) {
			$coupons = array();
		}

		foreach ($coupons as $i => &$row) {
			$row = com('coupon')->setMyCoupon($row, $time);
			$title2 = '';

			if ($row['coupontype'] == '0') {
				if (0 < $row['enough']) {
					$title2 = '满' . (double) $row['enough'] . '元可用';
					$title5 = '消费满' . (double) $row['enough'];
				}
				else {
					$title2 = '无金额门槛';
					$title5 = '消费任意金额';
				}
			}
			else if ($row['coupontype'] == '1') {
				if (0 < $row['enough']) {
					$title2 = '充值满' . (double) $row['enough'] . '元可用';
					$title5 = '充值满' . (double) $row['enough'];
				}
				else {
					$title2 = '无金额门槛';
					$title5 = '充值任意金额';
				}
			}
			else {
				if ($row['coupontype'] == '2') {
					if (0 < $row['enough']) {
						$title2 = '满' . (double) $row['enough'] . '元可用';
						$title5 = '消费满' . (double) $row['enough'];
					}
					else {
						$title2 = '无金额门槛';
						$title5 = '消费任意金额';
					}
				}
			}

			if ($row['backtype'] == 0) {
				$title3 = '<span class="subtitle">￥</span>' . (double) $row['deduct'];
				$title5 = $title5 . '立减' . (double) $row['deduct'];

				if ($row['enough'] == '0') {
					$row['color'] = 'orange ';
					$tagtitle = '代金券';
				}
				else {
					$row['color'] = 'blue';
					$tagtitle = '满减券';
				}
			}

			if ($row['backtype'] == 1) {
				$row['color'] = 'red ';
				$title3 = (double) $row['discount'] . '折 ';
				$title5 = $title5 . '打' . (double) $row['discount'] . '折 ';
				$tagtitle = '打折券';
			}

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

				if (!empty($row['backmoney']) && 0 < $row['backmoney']) {
					$title3 = '立返';
					$title5 = '立返余额';
				}

				if (!empty($row['backcredit']) && 0 < $row['backcredit']) {
					$title3 = '立返';
					$title5 = '立返积分';
				}

				if (!empty($row['backredpack']) && 0 < $row['backredpack']) {
					$title3 = '立返';
					$title5 = '立返红包';
				}
			}

			if ($row['tagtitle'] == '') {
				$row['tagtitle'] = $tagtitle;
			}

			if ($past == 1) {
				$row['color'] = 'disa';
			}

			$row['check'] = $check;
			$row['title2'] = $title2;
			$row['title3'] = $title3;
			$row['title5'] = $title5;
		}

		unset($row);
		show_json(1, array('list' => $coupons, 'pagesize' => $psize, 'total' => $total));
	}

	public function showcoupons()
	{
		global $_W;
		global $_GPC;
		$key = $_GPC['key'];
		$openid = $_W['openid'];
		$time = time();
		$sql = 'select d.id,d.couponid,d.gettime,c.timelimit,c.coupontype,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb,c.merchid,c.tagtitle,c.settitlecolor,c.titlecolor from ' . tablename('ewei_shop_coupon_sendshow') . ' cs';
		$sql .= ' inner join ' . tablename('ewei_shop_coupon_data') . ' d  on d.id=cs.coupondataid';
		$sql .= ' inner join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id ';
		$sql .= ' where cs.openid=:openid and cs.uniacid=:uniacid and showkey=:key ';
		$sql .= ' order by d.gettime desc  ';
		$coupons = set_medias(pdo_fetchall($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid'], ':key' => $key)), 'thumb');

		if (empty($coupons)) {
			$coupons = array();
		}

		foreach ($coupons as $i => &$row) {
			$imgname = 'ling';
			$row = com('coupon')->setMyCoupon($row, $time);
			$title2 = '';

			if ($row['coupontype'] == '0') {
				if (0 < $row['enough']) {
					$title2 = '消费满' . (double) $row['enough'] . '元';
				}
				else {
					$title2 = '消费';
				}
			}
			else if ($row['coupontype'] == '1') {
				if (0 < $row['enough']) {
					$title2 = '充值满' . (double) $row['enough'] . '元';
				}
				else {
					$title2 = '充值';
				}
			}
			else {
				if ($row['coupontype'] == '2') {
					if (0 < $row['enough']) {
						$title2 = '消费满' . (double) $row['enough'] . '元';
					}
					else {
						$title2 = '消费';
					}
				}
			}

			if ($row['backtype'] == 0) {
				$title2 = $title2 . '立减' . (double) $row['deduct'] . '元';

				if ($row['enough'] == '0') {
					$row['color'] = 'orange ';
					$tagtitle = '代金券';
				}
				else {
					$row['color'] = 'blue';
					$tagtitle = '满减券';
				}
			}

			if ($row['backtype'] == 1) {
				$row['color'] = 'red ';
				$title2 = $title2 . '打' . (double) $row['discount'] . '折';
				$tagtitle = '打折券';
			}

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

				if (!empty($row['backmoney']) && 0 < $row['backmoney']) {
					$title2 = $title2 . '送' . $row['discount'] . '元余额';
				}

				if (!empty($row['backcredit']) && 0 < $row['backcredit']) {
					$title2 = $title2 . '送' . $row['discount'] . '积分';
				}

				if (!empty($row['backredpack']) && 0 < $row['backredpack']) {
					$title2 = $title2 . '送' . $row['discount'] . '元红包';
				}
			}

			if ($row['tagtitle'] == '') {
				$row['tagtitle'] = $tagtitle;
			}

			$check = 0;

			if ($row['used'] == 1) {
				$check = 1;
				$imgname = 'used';
			}
			else {
				if ($row['timelimit'] == 0 && $row['timedays'] != 0 && $row['timedays'] * 86400 + $row['gettime'] < time() || $row['timelimit'] == 1 && $row['timeend'] < time()) {
					$check = 2;
					$row['color'] = 'disa';
					$imgname = 'past';
				}
			}

			$row['imgname'] = $imgname;
			$row['check'] = $check;
			$row['title2'] = $title2;
		}

		unset($row);
		include $this->template();
	}

	public function showcoupons2()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = pdo_fetch('select c.*  from ' . tablename('ewei_shop_coupon_data') . '  cd inner join  ' . tablename('ewei_shop_coupon') . ' c on cd.couponid = c.id  where cd.id=:id and cd.uniacid=:uniacid and coupontype =0  limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			if (empty($coupon)) {
				header('location: ' . mobileUrl('sale/coupon/my'));
				exit();
			}
		}

		if (7 < mb_strlen($data['couponname'], 'utf-8')) {
			$data['couponname'] = mb_substr($data['couponname'], 0, 7, 'utf-8') . '...';
		}

		$title1 = '';
		$title2 = '';

		if ($data['backtype'] == 0) {
			$title1 = '<span>￥</span>' . (double) $data['deduct'];
		}
		else if ($data['backtype'] == 1) {
			$title1 = (double) $data['discount'] . '<span>折</span>';
		}
		else {
			if ($data['backtype'] == 2) {
				if (!empty($data['backmoney']) && 0 < $data['backmoney']) {
					$title1 = '送' . $data['backmoney'] . '元余额';
				}

				if (!empty($data['backcredit']) && 0 < $data['backcredit']) {
					$title1 .= '送' . $data['backcredit'] . '积分';
				}

				if (!empty($data['backredpack']) && 0 < $data['backredpack']) {
					$title1 .= '送' . $data['backredpack'] . '元红包';
				}
			}
		}

		if (0 < $data['enough']) {
			$title2 = '满' . (double) $data['enough'] . '元使用';
		}
		else {
			$title2 = '无金额门槛';
		}

		$goods = array();
		$params = array(':uniacid' => $_W['uniacid']);
		$sql = 'select  distinct  g.*  from ';
		$table = '';
		if ($data['limitgoodcatetype'] == 1 && !empty($data['limitgoodcateids'])) {
			$limitcateids = explode(',', $data['limitgoodcateids']);

			if (0 < count($limitcateids)) {
				$table = '(';
				$i = 0;

				foreach ($limitcateids as $cateid) {
					++$i;

					if (1 < $i) {
						$table .= ' union all ';
					}

					$table .= 'select * from ' . tablename('ewei_shop_goods') . ' where FIND_IN_SET(' . $cateid . ',cates) and deleted =0';
				}

				$table .= ') g';
			}
			else {
				$table = tablename('ewei_shop_goods') . ' g';
			}
		}
		else {
			$table = tablename('ewei_shop_goods') . ' g';
		}

		$where = ' where  g.uniacid=:uniacid and g.bargain =0 and g.status =1 and g.deleted = 0 ';
		if ($data['limitgoodtype'] == 1 && !empty($data['limitgoodids'])) {
			$where .= ' and g.id in (' . $data['limitgoodids'] . ') ';
		}

		if (!empty($data['merchid'])) {
			$where .= ' and g.merchid = ' . $data['merchid'] . ' and g.checked=0';
		}

		$where .= ' ORDER BY RAND() LIMIT 5 ';
		$sql = $sql . $table . $where;
		$goods = pdo_fetchall($sql, $params);

		foreach ($goods as $i => &$row) {
			$couponprice = (double) $row['minprice'];

			if ($data['backtype'] == 0) {
				$couponprice = round($couponprice - (double) $data['deduct'], 2);
			}

			if ($data['backtype'] == 1) {
				$couponprice = (double) $couponprice * (floatval($data['discount']) / 10);
			}

			if ($couponprice < 0) {
				$couponprice = 0;
			}

			$row['couponprice'] = $couponprice;
		}

		unset($row);
		$goods = set_medias($goods, 'thumb');
		include $this->template();
	}

	public function showcoupons3()
	{
		global $_W;
		global $_GPC;
		$key = $_GPC['key'];
		$openid = $_W['openid'];
		$time = time();
		$sql = 'select d.id,d.couponid,d.gettime,c.timelimit,c.limitgoodcatetype,c.limitgoodcateids,c.coupontype,c.limitgoodtype,c.limitgoodids,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb,c.merchid,c.tagtitle,c.settitlecolor,c.titlecolor from ' . tablename('ewei_shop_coupon_sendshow') . ' cs';
		$sql .= ' inner join ' . tablename('ewei_shop_coupon_data') . ' d  on d.id=cs.coupondataid';
		$sql .= ' inner join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id ';
		$sql .= ' where cs.openid=:openid and cs.uniacid=:uniacid and showkey=:key ';
		$sql .= ' order by d.gettime desc  ';
		$coupons = set_medias(pdo_fetchall($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid'], ':key' => $key)), 'thumb');

		if (empty($coupons)) {
			$coupons = array();
		}

		foreach ($coupons as $i => &$row) {
			if (0 < $row['enough']) {
				$row['title2'] = '满' . (double) $row['enough'] . '元使用';
			}
			else {
				$row['title2'] = '无金额门槛';
			}

			if ($row['coupontype'] == 0 || $row['coupontype'] == 2) {
				$row['title3'] = '优惠券';

				if ($row['backtype'] == 0) {
					$row['title1'] = '<span>￥</span>' . (double) $row['deduct'];
				}
				else if ($row['backtype'] == 1) {
					$row['title1'] = (double) $row['discount'] . '<span>折</span>';
				}
				else {
					if ($row['backtype'] == 2) {
						if (!empty($row['backmoney']) && 0 < $row['backmoney']) {
							$row['title1'] = '送' . $row['backmoney'] . '元余额';
						}

						if (!empty($row['backcredit']) && 0 < $row['backcredit']) {
							$row['title1'] .= '送' . $row['backcredit'] . '积分';
						}

						if (!empty($row['backredpack']) && 0 < $row['backredpack']) {
							$row['title1'] .= '送' . $row['backredpack'] . '元红包';
						}
					}
				}

				$goods = array();
				$params = array(':uniacid' => $_W['uniacid']);
				$sql = 'select  distinct  g.*  from ';
				$table = '';
				if ($row['limitgoodcatetype'] == 1 && !empty($row['limitgoodcateids'])) {
					$limitcateids = explode(',', $row['limitgoodcateids']);

					if (0 < count($limitcateids)) {
						$table = '(';
						$i = 0;

						foreach ($limitcateids as $cateid) {
							++$i;

							if (1 < $i) {
								$table .= ' union all ';
							}

							$table .= 'select * from ' . tablename('ewei_shop_goods') . ' where FIND_IN_SET(' . $cateid . ',cates) and deleted = 0';
						}

						$table .= ') g';
					}
					else {
						$table = tablename('ewei_shop_goods') . ' g';
					}
				}
				else {
					$table = tablename('ewei_shop_goods') . ' g';
				}

				$where = ' where  g.uniacid=:uniacid and g.bargain =0 and g.status =1 and g.deleted = 0';
				if ($row['limitgoodtype'] == 1 && !empty($row['limitgoodids'])) {
					$where .= ' and g.id in (' . $row['limitgoodids'] . ') ';
				}

				if (!empty($row['merchid'])) {
					$where .= ' and g.merchid = ' . $row['merchid'] . ' and g.checked=0';
				}

				$where .= ' ORDER BY RAND() LIMIT 5 ';
				$sql = $sql . $table . $where;
				$goods = pdo_fetchall($sql, $params);

				foreach ($goods as $i => &$row2) {
					$couponprice = (double) $row2['minprice'];

					if ($row['backtype'] == 0) {
						$couponprice = round($couponprice - (double) $row['deduct'], 2);
					}

					if ($row['backtype'] == 1) {
						$couponprice = (double) $couponprice * (floatval($row['discount']) / 10);
					}

					if ($couponprice < 0) {
						$couponprice = 0;
					}

					$row2['couponprice'] = $couponprice;
				}

				unset($row2);
				$goods = set_medias($goods, 'thumb');
				$row['goods'] = $goods;
			}
			else {
				$row['title3'] = '充值卷';

				if ($row['backtype'] == 2) {
					if (!empty($row['backmoney']) && 0 < $row['backmoney']) {
						$row['title1'] = '送' . $row['backmoney'] . '元余额';
					}

					if (!empty($row['backcredit']) && 0 < $row['backcredit']) {
						$row['title1'] .= '送' . $row['backcredit'] . '积分';
					}

					if (!empty($row['backredpack']) && 0 < $row['backredpack']) {
						$row['title1'] .= '送' . $row['backredpack'] . '元红包';
					}
				}
			}
		}

		include $this->template();
	}

	public function showcoupongoods()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = pdo_fetch('select c.*  from ' . tablename('ewei_shop_coupon_data') . '  cd inner join  ' . tablename('ewei_shop_coupon') . ' c on cd.couponid = c.id  where cd.id=:id and cd.uniacid=:uniacid and coupontype =0  limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			if (empty($coupon)) {
				header('location: ' . mobileUrl('sale/coupon/my'));
				exit();
			}
		}

		$merchid = 0;

		if (!empty($data['merchid'])) {
			$merchid = $data['merchid'];
		}

		if (8 < mb_strlen($data['couponname'], 'utf-8')) {
			$data['couponname'] = mb_substr($data['couponname'], 0, 8, 'utf-8') . '..';
		}

		$allcategory = m('shop')->getCategory();
		$catlevel = intval($_W['shopset']['category']['level']);
		$opencategory = true;
		$plugin_commission = p('commission');
		if ($plugin_commission && 0 < intval($_W['shopset']['commission']['level'])) {
			$mid = intval($_GPC['mid']);

			if (!empty($mid)) {
				$shop = p('commission')->getShop($mid);

				if (empty($shop['selectcategory'])) {
					$opencategory = false;
				}
			}
		}

		include $this->template();
	}

	public function get_list()
	{
		global $_GPC;
		global $_W;
		$args = array('pagesize' => 10, 'page' => intval($_GPC['page']), 'isnew' => trim($_GPC['isnew']), 'ishot' => trim($_GPC['ishot']), 'isrecommand' => trim($_GPC['isrecommand']), 'isdiscount' => trim($_GPC['isdiscount']), 'istime' => trim($_GPC['istime']), 'issendfree' => trim($_GPC['issendfree']), 'keywords' => trim($_GPC['keywords']), 'cate' => trim($_GPC['cate']), 'order' => trim($_GPC['order']), 'by' => trim($_GPC['by']), 'couponid' => trim($_GPC['couponid']), 'merchid' => intval($_GPC['merchid']));
		$plugin_commission = p('commission');
		if ($plugin_commission && 0 < intval($_W['shopset']['commission']['level']) && empty($_W['shopset']['commission']['closemyshop']) && !empty($_W['shopset']['commission']['select_goods'])) {
			$mid = intval($_GPC['mid']);

			if (!empty($mid)) {
				$shop = p('commission')->getShop($mid);

				if (!empty($shop['selectgoods'])) {
					$args['ids'] = $shop['goodsids'];
				}
			}
		}

		$this->_condition($args);
	}

	private function _condition($args)
	{
		global $_GPC;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$args['merchid'] = intval($_GPC['merchid']);
		}

		if (isset($_GPC['nocommission'])) {
			$args['nocommission'] = intval($_GPC['nocommission']);
		}

		$goods = m('goods')->getListbyCoupon($args);
		show_json(1, array('list' => $goods['list'], 'total' => $goods['total'], 'pagesize' => $args['pagesize']));
	}
}

?>
