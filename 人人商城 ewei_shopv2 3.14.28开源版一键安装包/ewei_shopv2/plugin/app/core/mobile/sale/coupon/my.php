<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class My_EweiShopV2Page extends AppMobilePage
{
	public function getlist()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$cate = trim($_GPC['cate']);
		$imgname = 'ling';
		$imgname = 'ling';
		$check = 0;

		if (!empty($cate)) {
			if ($cate == 'used') {
				$used = 1;
				$imgname = 'used';
				$check = 1;
			}
			else {
				$past = 1;
				$imgname = 'past';
				$check = 2;
			}
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$time = time();
		$sql = 'select d.id,d.couponid,d.gettime,c.timelimit,c.coupontype,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb,c.merchid,c.tagtitle,c.settitlecolor,c.titlecolor from ' . tablename('ewei_shop_coupon_data') . ' d';
		$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
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
					$title2 = $title2 . '送' . $row['backmoney'] . '元余额';
				}

				if (!empty($row['backcredit']) && 0 < $row['backcredit']) {
					$title2 = $title2 . '送' . $row['backcredit'] . '积分';
				}

				if (!empty($row['backredpack']) && 0 < $row['backredpack']) {
					$title2 = $title2 . '送' . $row['backredpack'] . '元红包';
				}
			}

			if ($row['tagtitle'] == '') {
				$row['tagtitle'] = $tagtitle;
			}

			if ($past == 1) {
				$row['color'] = 'disa';
			}

			$row['imgname'] = $imgname;
			$row['check'] = $check;
			$row['title2'] = $title2;
			$row['iconurl'] = $_W['siteroot'] . 'addons/ewei_shopv2/template/mobile/default/static/images/coupon/' . $row['imgname'] . '.png';
			unset($row['timelimit']);
			unset($row['coupontype']);
			unset($row['timestart']);
			unset($row['timeend']);
			unset($row['enough']);
			unset($row['backtype']);
			unset($row['deduct']);
			unset($row['discount']);
			unset($row['backmoney']);
			unset($row['backcredit']);
			unset($row['backredpack']);
			unset($row['bgcolor']);
			unset($row['merchid']);
			unset($row['settitlecolor']);
			unset($row['titlecolor']);
			unset($row['past']);
			unset($row['merchname']);
			unset($row['css']);
			unset($row['backstr']);
			unset($row['backpre']);
			unset($row['_backmoney']);
		}

		unset($row);
		$set = m('common')->getPluginset('coupon');
		return app_json(array('list' => $coupons, 'pagesize' => $psize, 'total' => $total, 'closecenter' => intval($set['closecenter'])));
	}

	public function getdetail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$data = pdo_fetch('select * from ' . tablename('ewei_shop_coupon_data') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			if (empty($coupon)) {
				return app_error(AppError::$CouponRecordNotFound);
			}
		}

		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $data['couponid'], ':uniacid' => $_W['uniacid']));

		if (empty($coupon)) {
			return app_error(AppError::$CouponNotFound);
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
				$coupon['color'] = 'org ';
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
		$detail = array('name' => $coupon['couponname'], 'merchstr' => $coupon['merchname'] ? '限购' . $coupon['merchname'] . '店铺商品' : '', 'title2' => $coupon['title2'], 'title3' => $coupon['title3'], 'color' => $coupon['color'], 'coupontype' => $coupon['coupontype'], 'limitdiscounttype' => $coupon['limitdiscounttype'], 'limitgoodtype' => $coupon['limitgoodtype'], 'limitgoodcatetype' => $coupon['limitgoodcatetype'], 'limitgoods' => $goods, 'limitcates' => $category, 'num' => $num);

		if ($coupon['timestr'] == '0') {
			$detail['usestr'] = '永久有效';
		}
		else if ($coupon['timestr'] == '1') {
			$detail['usestr'] = '即' . $coupon['gettypestr'] . '日内 ' . $coupon['timedays'] . ' 天有效';
		}
		else {
			$detail['usestr'] = ' ' . $coupon['timestr'];
		}

		if (empty($coupon['coupontype'])) {
			$detail['getstr'] = '立即去选商品使用';
		}
		else if ($coupon['coupontype'] == '1') {
			$detail['getstr'] = '立即去充值';
		}
		else {
			$detail['getstr'] = '返回我的优惠卷';
		}

		if ($coupon['descnoset'] == '0') {
			if ($coupon['coupontype'] == '0') {
				$detail['desc'] = htmlspecialchars_decode($set['consumedesc']);
			}
			else if ($coupon['coupontype'] == '1') {
				$detail['desc'] = htmlspecialchars_decode($set['rechargedesc']);
			}
			else {
				$detail['desc'] = htmlspecialchars_decode($set['consumedesc']);
			}
		}
		else {
			$detail['desc'] = $coupon['desc'];
		}

		return app_json(array('detail' => $detail));
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

		$new = array();

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
			$new[] = array('id' => $row['id'], 'couponname' => $row['couponname'], 'title2' => $row['title2'], 'tagtitle' => $row['tagtitle'], 'check' => $row['check'], 'color' => $row['color'], 'thumb' => $row['thumb'], 'timestr' => $row['timestr'], 'past' => $row['past'], 'merchname' => $row['merchname']);
		}

		unset($row);
		return app_json(array('couponnum' => count($new), 'coupons' => $new));
	}

	public function showcoupon2()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$data = pdo_fetch('select c.*  from ' . tablename('ewei_shop_coupon_data') . '  cd inner join  ' . tablename('ewei_shop_coupon') . ' c on cd.couponid = c.id  where cd.id=:id and cd.uniacid=:uniacid and coupontype =0  limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			if (empty($coupon)) {
				return app_error(AppError::$CouponRecordNotFound);
			}
		}

		if (7 < mb_strlen($data['couponname'], 'utf-8')) {
			$data['couponname'] = mb_substr($data['couponname'], 0, 7, 'utf-8') . '...';
		}

		$data['deduct'] = (double) $data['deduct'];

		if ($data['backtype'] == 0) {
			$data['title1'] = '￥' . (double) $data['deduct'];
		}
		else if ($data['backtype'] == 1) {
			$data['title1'] = (double) $data['discount'] . '折';
		}
		else {
			if ($data['backtype'] == 2) {
				if (!empty($data['backmoney']) && 0 < $data['backmoney']) {
					$data['title1'] = '送' . $data['backmoney'] . '元余额';
				}

				if (!empty($data['backcredit']) && 0 < $data['backcredit']) {
					$data['title1'] .= '送' . $data['backcredit'] . '积分';
				}

				if (!empty($data['backredpack']) && 0 < $data['backredpack']) {
					$data['title1'] .= '送' . $data['backredpack'] . '元红包';
				}
			}
		}

		if (0 < $data['enough']) {
			$data['title2'] = '满' . (double) $data['enough'] . '元使用';
		}
		else {
			$data['title2'] = '无金额门槛';
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

					$table .= 'select * from ' . tablename('ewei_shop_goods') . ' where FIND_IN_SET(' . $cateid . ',cates)';
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

		$where = ' where  g.uniacid=:uniacid and g.bargain =0 and g.status =1 ';
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

			if ($row['backtype'] == 0) {
				$couponprice = $couponprice - (double) $data['deduct'];
			}

			if ($row['backtype'] == 1) {
				$couponprice = $couponprice * $data['discount'] / 10;
			}

			if ($couponprice < 0) {
				$couponprice = 0;
			}

			$row['couponprice'] = $couponprice;
		}

		unset($row);
		$goods = set_medias($goods, 'thumb');
		return app_json(array('detail' => $data, 'goods' => $goods));
	}

	public function showcoupons3()
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

		$new = array();

		foreach ($coupons as $i => &$row) {
			if (0 < $row['enough']) {
				$row['title2'] = '满' . (double) $row['enough'] . '元使用';
			}
			else {
				$row['title2'] = '无金额门槛';
			}

			$newgoods = array();
			if ($row['coupontype'] == 0 || $row['coupontype'] == 2) {
				$row['title3'] = '优惠券';

				if ($row['backtype'] == 0) {
					$row['title1'] = '￥' . (double) $row['deduct'];
				}
				else if ($row['backtype'] == 1) {
					$row['title1'] = (double) $row['discount'] . '折';
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

							$table .= 'select * from ' . tablename('ewei_shop_goods') . ' where FIND_IN_SET(' . $cateid . ',cates)';
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

				$where = ' where  g.uniacid=:uniacid and g.bargain =0 and g.status =1 ';
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
						$couponprice = $couponprice - (double) $row['deduct'];
					}

					if ($row['backtype'] == 1) {
						$couponprice = $couponprice * $row['discount'] / 10;
					}

					if ($couponprice < 0) {
						$couponprice = 0;
					}

					$row2['couponprice'] = $couponprice;
					$newgoods[] = array('id' => $row['id'], 'title' => $row['title'], 'thumb' => $row['thumb'], 'minprice' => $row['minprice'], 'couponprice' => $row['couponprice']);
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

			$new[] = array('id' => $row['id'], 'title1' => $row['title1'], 'title2' => $row['title2'], 'title3' => $row['title3'], 'goods' => $newgoods);
		}

		return app_json(array('couponnum' => count($new), 'coupons' => $new));
	}

	public function showcoupongoods()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$data = pdo_fetch('select c.*  from ' . tablename('ewei_shop_coupon_data') . '  cd inner join  ' . tablename('ewei_shop_coupon') . ' c on cd.couponid = c.id  where cd.id=:id and cd.uniacid=:uniacid and coupontype =0  limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			if (empty($coupon)) {
				return app_error(AppError::$CouponRecordNotFound);
			}
		}

		$merchid = 0;

		if (!empty($data['merchid'])) {
			$merchid = $data['merchid'];
		}

		if (8 < mb_strlen($data['couponname'], 'utf-8')) {
			$data['couponname'] = mb_substr($data['couponname'], 0, 8, 'utf-8') . '..';
		}

		return app_json(array(
			'detail' => array('couponname' => $data['couponname'])
		));
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
		return app_json(array('list' => $goods['list'], 'total' => $goods['total'], 'pagesize' => $args['pagesize']));
	}
}

?>
