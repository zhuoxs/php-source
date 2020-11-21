<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Detail_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$rank = intval($_GPC['rank']);
		$log_id = intval($_GPC['log_id']);
		$join_id = intval($_GPC['join_id']);
		$task_id = intval($_GPC['task_id']);

		if (!empty($join_id)) {
			$_SESSION[$id . '_rank'] = $rank;
			$_SESSION[$id . '_join_id'] = $join_id;
		}
		else if (!empty($log_id)) {
			$_SESSION[$id . '_log_id'] = $log_id;
		}
		else {
			if (!empty($task_id)) {
				$_SESSION[$id . '_task_id'] = $task_id;
			}
		}

		if (p('task')) {
			if (!empty($task_id)) {
				$rewarded = pdo_fetchcolumn('SELECT `rewarded` FROM ' . tablename('ewei_shop_task_extension_join') . ' WHERE id = :id AND uniacid = :uniacid', array(':id' => $task_id, ':uniacid' => $_W['uniacid']));
				$taskGoodsInfo = unserialize($rewarded);
				$taskGoodsInfo = $taskGoodsInfo['goods'][$id];

				if (!empty($taskGoodsInfo['option'])) {
					$taskGoodsInfo = NULL;
				}
			}

			$taskrewardgoodsid = (int) $_GPC['taskrewardgoodsid'];
			$taskGoodsInfo = pdo_fetch('select * from ' . tablename('ewei_shop_task_reward') . ' where id = :id and openid = :openid and senttime = 0 and gettime > 0', array(':id' => $taskrewardgoodsid, ':openid' => $_W['openid']));
			$_SESSION['taskcut'] = $taskGoodsInfo;

			if (empty($taskGoodsInfo)) {
				$_SESSION['taskcut'] = NULL;
			}
		}

		if (p('threen')) {
			$threenvip = p('threen')->getMember($_W['openid']);

			if (!empty($threenvip)) {
				$threen = true;
			}
		}

		$err = false;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		$commission_data = m('common')->getPluginset('commission');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$isgift = 0;
		$gifts = array();
		$giftgoods = array();
		$gifts = pdo_fetchall('select id,goodsid,giftgoodsid,thumb,title from ' . tablename('ewei_shop_gift') . ' where uniacid = ' . $uniacid . ' and activity = 2 and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . '  ');

		foreach ($gifts as $key => &$value) {
			$gid = explode(',', $value['goodsid']);

			foreach ($gid as $ke => $val) {
				if ($val == $id) {
					$giftgoods = explode(',', $value['giftgoodsid']);

					foreach ($giftgoods as $k => $val) {
						$giftinfo = pdo_fetch('select id,title,thumb,marketprice from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and deleted = 0 and total > 0 and status = 2 and id = ' . $val . ' ');

						if ($giftinfo) {
							$isgift = 1;
							$gifts[$key]['gift'][$k] = $giftinfo;
							$gifttitle = !empty($value['gift'][$k]['title']) ? $value['gift'][$k]['title'] : '赠品';
						}
					}
				}
			}

			if (empty($value['gift'])) {
				unset($gifts[$key]);
			}
		}

		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if ($goods['isverify'] == 2) {
			unset($gifts);
		}

		$goodscode = $this->get_code();

		if ($goods['type'] == 9) {
			header('location: ' . mobileUrl('cycelbuy/goods/detail', array('id' => $goods['id'])));
			exit();
		}

		if (p('offic')) {
			$marketprice = $goods['marketprice'];
			$goods['marketprice'] = $goods['minprice'];
			$commission_price = p('commission')->getCommission($goods);
			$goods['marketprice'] = $marketprice;
		}

		if ($is_openmerch == 1) {
			$set = m('plugin')->loadModel('merch')->getListUserOne($goods['merchid']);

			if ($set['status'] != 1) {
				$is_openmerch = 0;
			}
		}

		$threenprice = json_decode($goods['threen'], 1);
		if (0 < $goods['ispresell'] && (0 < $goods['presellend'] && time() < $goods['preselltimeend'] || $goods['preselltimeend'] == 0)) {
			$goods['minprice'] = $goods['presellprice'];

			if ($goods['hasoption'] == 0) {
				$goods['maxprice'] = $goods['presellprice'];
			}
		}

		if ($goods['type'] == 30) {
			header('location: ' . mobileUrl('newstore/trade/detail', array('id' => $goods['id'])));
			exit();
		}

		if ($goods['type'] == 4) {
			$intervalprice = iunserializer($goods['intervalprice']);

			if (0 < $goods['intervalfloor']) {
				$goods['intervalprice1'] = $intervalprice[0]['intervalprice'];
				$goods['intervalnum1'] = $intervalprice[0]['intervalnum'];
			}

			if (1 < $goods['intervalfloor']) {
				$goods['intervalprice2'] = $intervalprice[1]['intervalprice'];
				$goods['intervalnum2'] = $intervalprice[1]['intervalnum'];
			}

			if (2 < $goods['intervalfloor']) {
				$goods['intervalprice3'] = $intervalprice[2]['intervalprice'];
				$goods['intervalnum3'] = $intervalprice[2]['intervalnum'];
			}
		}

		$timeout = false;
		$access_time = false;

		if ($goods['type'] == 5) {
			if ($goods['verifygoodslimittype'] == 1) {
				$limittime = $goods['verifygoodslimitdate'];
				$now = time();

				if ($limittime < time()) {
					$timeout = true;
					$hint = '您选择的记次时商品的使用时间已经失效，无法购买！';
				}
				else {
					if (1800 < $limittime - $now && $limittime - $now < 7200) {
						$access_time = true;
						$hint = '您选择的记次时商品到期日期是"' . date('Y-m-d H:i:s', $limittime) . '",请确保有足够的时间抵达核销门店进行核销，以免耽误您的使用。';
					}
					else {
						if ($limittime - $now < 1800) {
							$timeout = true;
							$hint = '您选择的记次时商品的使用时间即将失效，无法购买！';
						}
					}
				}
			}
		}

		$isfullback = false;

		if ($goods['isfullback']) {
			$isfullback = true;
			$fullbackgoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE uniacid = ' . $uniacid . ' and goodsid = ' . $id . ' and status=1 limit 1 ');

			if (empty($fullbackgoods)) {
				$isfullback = false;
			}
			else if ($goods['hasoption'] == 1) {
				$fullprice = pdo_fetch('select min(allfullbackprice) as minfullprice,max(allfullbackprice) as maxfullprice,min(allfullbackratio) as minfullratio
                            ,max(allfullbackratio) as maxfullratio,min(fullbackprice) as minfullbackprice,max(fullbackprice) as maxfullbackprice
                            ,min(fullbackratio) as minfullbackratio,max(fullbackratio) as maxfullbackratio,min(`day`) as minday,max(`day`) as maxday
                            from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $id . '');
				$fullbackgoods['minallfullbackallprice'] = $fullprice['minfullprice'];
				$fullbackgoods['maxallfullbackallprice'] = $fullprice['maxfullprice'];
				$fullbackgoods['minallfullbackallratio'] = $fullprice['minfullratio'];
				$fullbackgoods['maxallfullbackallratio'] = $fullprice['maxfullratio'];
				$fullbackgoods['minfullbackprice'] = $fullprice['minfullbackprice'];
				$fullbackgoods['maxfullbackprice'] = $fullprice['maxfullbackprice'];
				$fullbackgoods['minfullbackratio'] = $fullprice['minfullbackratio'];
				$fullbackgoods['maxfullbackratio'] = $fullprice['maxfullbackratio'];
				$fullbackgoods['fullbackratio'] = $fullprice['minfullbackratio'];
				$fullbackgoods['fullbackprice'] = $fullprice['minfullbackprice'];
				$fullbackgoods['minday'] = $fullprice['minday'];
				$fullbackgoods['maxday'] = $fullprice['maxday'];
			}
			else {
				$fullbackgoods['maxallfullbackallprice'] = $fullbackgoods['minallfullbackallprice'];
				$fullbackgoods['maxallfullbackallratio'] = $fullbackgoods['minallfullbackallratio'];
				$fullbackgoods['minday'] = $fullbackgoods['day'];
			}
		}

		$merchid = $goods['merchid'];

		if (json_decode($goods['labelname'], true)) {
			$labelname = json_decode($goods['labelname'], true);
		}
		else {
			$labelname = unserialize($goods['labelname']);
		}

		$style = pdo_fetch('SELECT id,uniacid,style FROM ' . tablename('ewei_shop_goods_labelstyle') . ' WHERE uniacid=' . $uniacid);

		if ($is_openmerch == 0) {
			if (0 < $merchid) {
				$err = true;
				include $this->template('goods/detail');
				exit();
			}
		}
		else {
			if (0 < $merchid && $goods['checked'] == 1) {
				$err = true;
				include $this->template('goods/detail');
				exit();
			}
		}

		$member = m('member')->getMember($openid);

		if (empty($member['updateaddress'])) {
			$address_list = pdo_fetchall('select id,datavalue from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and uniacid=:uniacid', array(':uniacid' => $uniacid, ':openid' => $openid));

			if (!empty($address_list)) {
				$areas = m('common')->getAreas();
				$datacode = array();

				foreach ($areas['province'] as $value) {
					$pname = $value['@attributes']['name'];
					$pcode = $value['@attributes']['code'];
					$datacode[$pcode] = $pname;

					foreach ($value['city'] as $city) {
						$cname = $city['@attributes']['name'];
						$ccode = $city['@attributes']['code'];
						$datacode[$ccode] = $cname;

						foreach ($city['county'] as $county) {
							$aname = $county['@attributes']['name'];
							$acode = $county['@attributes']['code'];
							$datacode[$acode] = $aname;
						}
					}
				}

				$change_data = array();

				foreach ($address_list as $k1 => $v1) {
					if (!empty($v1['datavalue'])) {
						$datavalue = explode(' ', $v1['datavalue']);
						$change_data['province'] = $datacode[$datavalue[0]];
						$change_data['city'] = $datacode[$datavalue[1]];
						$change_data['area'] = $datacode[$datavalue[2]];
						if (!empty($change_data['province']) && !empty($change_data['city']) && !empty($change_data['area'])) {
							pdo_update('ewei_shop_member_address', $change_data, array('id' => $v1['id']));
						}
					}
				}

				pdo_update('ewei_shop_member', array('updateaddress' => 1), array('id' => $member['id']));
			}
		}

		$showgoods = m('goods')->visit($goods, $member);

		if (empty($goods)) {
			$err = true;
			include $this->template();
			exit();
		}

		if (empty($showgoods)) {
			$this->message(array('message' => '您当前会员等级无浏览权限，去商城逛逛吧~', 'buttontext' => '去逛逛'), mobileUrl());
		}

		$seckillinfo = false;
		$seckill = p('seckill');

		if ($seckill) {
			$time = time();
			$seckillinfo = $seckill->getSeckill($goods['id'], 0, false);

			if (!empty($seckillinfo)) {
				if ($seckillinfo['starttime'] <= $time && $time < $seckillinfo['endtime']) {
					$seckillinfo['status'] = 0;
					unset($_SESSION[$id . '_log_id']);
					unset($_SESSION[$id . '_task_id']);
					unset($log_id);
				}
				else if ($time < $seckillinfo['starttime']) {
					$seckillinfo['status'] = 1;
				}
				else {
					$seckillinfo['status'] = -1;
				}
			}
		}

		$task_goods_data = m('goods')->getTaskGoods($openid, $id, $rank, $log_id, $join_id);

		if (empty($task_goods_data['is_task_goods'])) {
			$is_task_goods = 0;

			if (p('bargain')) {
				$bargain = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id = :id AND unix_timestamp(start_time)<' . time() . ' AND unix_timestamp(end_time)>' . time() . ' AND status = 0', array(':id' => $goods['bargain']));

				if ($bargain != false) {
					echo '<script>window.location.href = \'' . mobileUrl('bargain/detail', array('id' => $goods['bargain'])) . '\'</script>';
					return NULL;
				}
			}
		}
		else {
			$is_task_goods = $task_goods_data['is_task_goods'];
			$is_task_goods_option = $task_goods_data['is_task_goods_option'];
			$task_goods = $task_goods_data['task_goods'];
		}

		$goods['sales'] = $goods['sales'] + $goods['salesreal'];
		$goods['content'] = m('ui')->lazy($goods['content']);
		$buyshow = 0;

		if ($goods['buyshow'] == 1) {
			$sql = 'select o.id from ' . tablename('ewei_shop_order') . ' o left join ' . tablename('ewei_shop_order_goods') . ' g on o.id = g.orderid';
			$sql .= ' where o.openid=:openid and g.goodsid=:id and o.status>0 and o.uniacid=:uniacid limit 1';
			$buy_goods = pdo_fetch($sql, array(':openid' => $openid, ':id' => $id, ':uniacid' => $_W['uniacid']));

			if (!empty($buy_goods)) {
				$buyshow = 1;
				$goods['buycontent'] = m('ui')->lazy($goods['buycontent']);
			}
		}

		$goods['unit'] = empty($goods['unit']) ? '件' : $goods['unit'];
		$dispatch_areas = m('dispatch')->getNoDispatchAreas($goods);
		$citys = empty($dispatch_areas) ? '' : $dispatch_areas['citys'];
		if (!empty($citys) && $dispatch_areas['enabled']) {
			$onlysent = $dispatch_areas['onlysent'];
			$has_city = 1;
		}
		else {
			$has_city = 0;
		}

		$package_goods = pdo_fetch('select pg.id,pg.pid,pg.goodsid,p.displayorder from ' . tablename('ewei_shop_package_goods') . ' as pg
                        left join ' . tablename('ewei_shop_package') . ' as p on pg.pid = p.id
                        where pg.uniacid = ' . $uniacid . ' and pg.goodsid = ' . $id . ' and  p.starttime <= ' . time() . ' and p.endtime >= ' . time() . ' and p.deleted = 0 and p.status = 1 ORDER BY p.displayorder desc,pg.id desc limit 1 ');

		if ($package_goods['pid']) {
			$packages = pdo_fetchall('SELECT id,title,thumb,packageprice FROM ' . tablename('ewei_shop_package_goods') . '
                    WHERE uniacid = ' . $uniacid . ' and pid = ' . $package_goods['pid'] . '  ORDER BY id DESC');
			$packages = set_medias($packages, array('thumb'));
		}

		$goods['dispatchprice'] = $this->getGoodsDispatchPrice($goods, $seckillinfo);
		$thumbs = iunserializer($goods['thumb_url']);

		if (empty($thumbs)) {
			$thumbs = array($goods['thumb']);
			if (!empty($goods['thumb_first']) && !empty($goods['thumb'])) {
				$thumbs = array_merge(array($goods['thumb']), $thumbs);
			}

			if (is_array($thumbs) && count($thumbs) == 2 && !empty($goods['thumb_first'])) {
				$thumbs = array_unique($thumbs);
			}

			$thumbs = array_values($thumbs);
		}
		else {
			if (!empty($goods['thumb_first']) && !empty($goods['thumb'])) {
				$thumbs = array_merge(array($goods['thumb']), $thumbs);
			}

			$thumbs = array_values($thumbs);
		}

		$specs = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:goodsid and  uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));
		$spec_titles = array();

		foreach ($specs as $key => $spec) {
			if (2 <= $key) {
				break;
			}

			$spec_titles[] = $spec['title'];
		}

		if (0 < $goods['hasoption']) {
			$spec_titles = implode('、', $spec_titles);
		}
		else {
			$spec_titles = '';
		}

		$params = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_goods_param') . ' WHERE uniacid=:uniacid and goodsid=:goodsid order by displayorder asc', array(':uniacid' => $uniacid, ':goodsid' => $goods['id']));
		$goods = set_medias($goods, 'thumb');
		$goods['canbuy'] = $goods['status'] == 1 && empty($goods['deleted']);

		if (!empty($goods['hasoption'])) {
			$options = pdo_fetchall('select id,stock,marketprice,islive,liveprice from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $goods['id'], ':uniacid' => $_W['uniacid']), 'stock');
			$options_stock = array_keys($options);
		}

		$liveid = intval($_GPC['liveid']);
		if (p('live') && !empty($liveid)) {
			$islive = p('live')->getLivePrice($goods, $liveid);

			if ($islive) {
				$goods['minprice'] = $islive['minprice'];
				$goods['maxprice'] = $islive['maxprice'];

				if (empty($options)) {
					$goods['marketprice'] = $islive['minprice'];
				}
			}
		}

		$liveid = !empty($islive) && !empty($liveid) ? $liveid : 0;

		if ($goods['total'] <= 0) {
			$goods['canbuy'] = false;
		}

		$ispresell = 0;

		if (0 < $goods['ispresell']) {
			$ispresell = 1;
			if (0 < $goods['preselltimestart'] && time() < $goods['preselltimestart']) {
				$goods['canbuy'] = false;
			}

			if (0 < $goods['preselltimeend'] && $goods['preselltimeend'] < time()) {
				$goods['canbuy'] = false;
			}

			$times = $goods['presellovertime'] * 60 * 60 * 24 + $goods['preselltimeend'];
			if (0 < $goods['presellover'] && $times <= time()) {
				$goods['canbuy'] = true;
				$ispresell = 0;
			}
		}

		if ($goods['isverify'] == 2 && 0 < $goods['isendtime'] && 0 < $goods['endtime'] && $goods['endtime'] < time()) {
			$goods['canbuy'] = false;
			$goods['overdue'] = true;
		}

		$goods['timestate'] = '';
		$goods['userbuy'] = '1';

		if (0 < $goods['usermaxbuy']) {
			$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $goods['id'], ':uniacid' => $uniacid, ':openid' => $openid));

			if ($goods['usermaxbuy'] <= $order_goodscount) {
				$goods['userbuy'] = 0;
				$goods['canbuy'] = false;
			}
		}

		$levelid = $member['level'];

		if ($member['groupid'] == '') {
			$groupid = array();
		}
		else {
			$groupid = explode(',', $member['groupid']);
		}

		$goods['levelbuy'] = '1';

		if ($goods['buylevels'] != '') {
			$buylevels = explode(',', $goods['buylevels']);

			if (!in_array($levelid, $buylevels)) {
				$goods['levelbuy'] = 0;
				$goods['canbuy'] = false;
			}
		}

		$goods['groupbuy'] = '1';
		if ($goods['buygroups'] != '' && !empty($groupid)) {
			$buygroups = explode(',', $goods['buygroups']);
			$intersect = array_intersect($groupid, $buygroups);

			if (empty($intersect)) {
				$goods['groupbuy'] = 0;
				$goods['canbuy'] = false;
			}
		}

		$goods['timebuy'] = '0';

		if (empty($seckillinfo)) {
			if ($goods['istime'] == 1) {
				if (time() < $goods['timestart']) {
					$goods['timebuy'] = '-1';
					$goods['canbuy'] = false;
				}
				else {
					if ($goods['timeend'] < time()) {
						$goods['timebuy'] = '1';
						$goods['canbuy'] = false;
					}
				}
			}
		}

		if (com('coupon')) {
			$coupons = $this->getCouponsbygood($goods['id']);
		}

		$canAddCart = true;
		if ($goods['isverify'] == 2 || $goods['type'] == 2 || $goods['type'] == 3 || $goods['type'] == 20 || !empty($goods['cannotrefund']) || !empty($is_task_goods) || !empty($gifts) || !empty($seckillinfo)) {
			$canAddCart = false;
		}

		if ($goods['type'] == 2 && empty($specs)) {
			$gflag = 1;
		}
		else {
			$gflag = 0;
		}

		$enoughs = com_run('sale::getEnoughs');
		$goods_nofree = com_run('sale::getEnoughsGoods');

		if (empty($is_task_goods)) {
			$enoughfree = com_run('sale::getEnoughFree');
		}

		if ($is_openmerch == 1 && 0 < $goods['merchid']) {
			$merch_set = $merch_plugin->getSet('sale', $goods['merchid']);

			if ($merch_set['enoughfree']) {
				$enoughfree = $merch_set['enoughorder'];

				if ($merch_set['enoughorder'] == 0) {
					$enoughfree = -1;
				}
			}
		}

		$one = array(
			array('enough' => $merch_set['enoughmoney'], 'give' => $merch_set['enoughdeduct'])
		);
		$merchenoughs = $merch_set['enoughs'];

		if (empty($merchenoughs)) {
			$merchenoughs = array();
		}

		$merch_set['enoughs'] = array_merge_recursive($one, $merchenoughs);

		if (!empty($goods_nofree)) {
			if (in_array($id, $goods_nofree)) {
				$enoughfree = false;
			}
		}

		if ($enoughfree && $enoughfree < $goods['minprice'] && empty($seckillinfo)) {
			$goods['dispatchprice'] = 0;
		}

		$hasSales = false;
		if (0 < $goods['ednum'] || 0 < $goods['edmoney']) {
			$hasSales = true;
		}

		if ($enoughfree || $enoughs && 0 < count($enoughs)) {
			$hasSales = true;
		}

		$minprice = $goods['minprice'];
		$maxprice = $goods['maxprice'];
		$level = m('member')->getLevel($openid);

		if (empty($is_task_goods)) {
			$memberprice = m('goods')->getMemberPrice($goods, $level);
		}

		if ($goods['isdiscount'] && time() <= $goods['isdiscount_time']) {
			$goods['oldmaxprice'] = $maxprice;
			$prices = array();
			$isdiscount_discounts = json_decode($goods['isdiscount_discounts'], true);
			if (!isset($isdiscount_discounts['type']) || empty($isdiscount_discounts['type'])) {
				$prices_array = m('order')->getGoodsDiscountPrice($goods, $level, 1);
				$prices[] = $prices_array['price'];
			}
			else {
				$goods_discounts = m('order')->getGoodsDiscounts($goods, $isdiscount_discounts, $levelid);
				$prices = $goods_discounts['prices'];
			}

			$minprice = min($prices);
			$maxprice = max($prices);
		}
		else {
			if (isset($options) && 0 < count($options) && $goods['hasoption']) {
				$optionids = array();

				foreach ($options as $val) {
					$optionids[] = $val['id'];
				}

				$sql = 'update ' . tablename('ewei_shop_goods') . ' g set
        g.minprice = (select min(marketprice) from ' . tablename('ewei_shop_goods_option') . (' where goodsid = ' . $id . '),
        g.maxprice = (select max(marketprice) from ') . tablename('ewei_shop_goods_option') . (' where goodsid = ' . $id . ')
        where g.id = ' . $id . ' and g.hasoption=1');
				pdo_query($sql);
			}
			else {
				$sql = 'update ' . tablename('ewei_shop_goods') . (' set minprice = marketprice,maxprice = marketprice where id = ' . $id . ' and hasoption=0;');
				pdo_query($sql);
			}

			$goods_price = pdo_fetch('select minprice,maxprice from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$maxprice = (double) $goods_price['maxprice'];
			$minprice = (double) $goods_price['minprice'];

			if ($islive) {
				$minprice = $islive['minprice'];
				$maxprice = $islive['maxprice'];
			}
		}

		if (!empty($is_task_goods)) {
			if (isset($options) && 0 < count($options) && $goods['hasoption']) {
				$prices = array();

				foreach ($task_goods['spec'] as $k => $v) {
					$prices[] = $v['marketprice'];
				}

				$minprice2 = min($prices);
				$maxprice2 = max($prices);

				if ($minprice2 < $minprice) {
					$minprice = $minprice2;
				}

				if ($maxprice < $maxprice2) {
					$maxprice = $maxprice2;
				}
			}
			else {
				$minprice = $task_goods['marketprice'];
				$maxprice = $task_goods['marketprice'];
			}
		}

		if (0 < $goods['ispresell'] && $goods['hasoption'] && ($goods['preselltimeend'] == 0 || time() < $goods['preselltimeend'])) {
			$presell = pdo_fetch('select min(presellprice) as minprice,max(presellprice) as maxprice from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $id);
			$minprice = $presell['minprice'];
			$maxprice = $presell['maxprice'];
		}

		if (0 < $goods['hasoption']) {
			$productprice = pdo_fetchcolumn('select max(productprice) as productprice from ' . tablename('ewei_shop_goods_option') . ' where goodsid = :goodsid', array(':goodsid' => $id));

			if (!empty($productprice)) {
				$goods['productprice'] = $productprice;
			}
		}

		$goods['minprice'] = $minprice;
		$goods['maxprice'] = $maxprice;
		$getComments = empty($_W['shopset']['trade']['closecommentshow']);
		$hasServices = $goods['cash'] || $goods['seven'] || $goods['repair'] || $goods['invoice'] || $goods['quality'];
		$isFavorite = m('goods')->isFavorite($id);
		$cartCount = m('goods')->getCartCount();
		m('goods')->addHistory($id);
		$shop = set_medias(m('common')->getSysset('shop'), 'logo');
		$shop['url'] = mobileUrl('', NULL, true);
		$mid = intval($_GPC['mid']);
		$opencommission = false;

		if (p('commission')) {
			if (empty($member['agentblack'])) {
				$cset = p('commission')->getSet();
				$opencommission = 0 < intval($cset['level']);

				if ($opencommission) {
					if ($member['isagent'] == 1 && $member['status'] == 1) {
						$mid = $member['id'];
					}

					if (!empty($mid)) {
						if (empty($cset['closemyshop'])) {
							$shop = set_medias(p('commission')->getShop($mid), 'logo');
							$shop['url'] = mobileUrl('commission/myshop', array('mid' => $mid), true);
						}
					}
				}
			}
		}

		$is_offic = false;

		if (p('offic')) {
			if ($member['isagent'] == 1 && $member['status'] == 1) {
				$is_offic = true;
				$shop['url'] = mobileUrl('offic/myshop', array('mid' => $mid), true);
			}
		}

		if (empty($this->merch_user)) {
			$merch_flag = 0;
			if ($is_openmerch == 1 && 0 < $goods['merchid']) {
				$merch_user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:id limit 1', array(':id' => intval($goods['merchid'])));

				if (!empty($merch_user)) {
					$shop = $merch_user;
					$merch_flag = 1;
				}
			}

			$shop['description'] = empty($shop['desc']) ? $shop['description'] : $shop['desc'];

			if ($merch_flag == 1) {
				$shopdetail = array('logo' => !empty($goods['detail_logo']) ? tomedia($goods['detail_logo']) : tomedia($shop['logo']), 'shopname' => !empty($goods['detail_shopname']) ? $goods['detail_shopname'] : $shop['merchname'], 'description' => !empty($goods['detail_totaltitle']) ? $goods['detail_totaltitle'] : $shop['description'], 'btntext1' => trim($goods['detail_btntext1']), 'btnurl1' => !empty($goods['detail_btnurl1']) ? $goods['detail_btnurl1'] : mobileUrl('goods'), 'btntext2' => trim($goods['detail_btntext2']), 'btnurl2' => !empty($goods['detail_btnurl2']) ? $goods['detail_btnurl2'] : mobileUrl('merch', array('merchid' => $goods['merchid'])));
			}
			else {
				$shopdetail = array('logo' => !empty($goods['detail_logo']) ? tomedia($goods['detail_logo']) : $shop['logo'], 'shopname' => !empty($goods['detail_shopname']) ? $goods['detail_shopname'] : $shop['name'], 'description' => !empty($goods['detail_totaltitle']) ? $goods['detail_totaltitle'] : $shop['description'], 'btntext1' => trim($goods['detail_btntext1']), 'btnurl1' => !empty($goods['detail_btnurl1']) ? $goods['detail_btnurl1'] : mobileUrl('goods'), 'btntext2' => trim($goods['detail_btntext2']), 'btnurl2' => !empty($goods['detail_btnurl2']) ? $goods['detail_btnurl2'] : $shop['url']);
			}

			$param = array(':uniacid' => $_W['uniacid']);

			if ($merch_flag == 1) {
				$sqlcon = ' and merchid=:merchid';
				$param[':merchid'] = $goods['merchid'];
			}

			if (empty($shop['selectgoods'])) {
				$statics = array('all' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . (' where uniacid=:uniacid ' . $sqlcon . ' and status=1 and deleted=0'), $param), 'new' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . (' where uniacid=:uniacid ' . $sqlcon . ' and isnew=1 and status=1 and deleted=0'), $param), 'discount' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . (' where uniacid=:uniacid ' . $sqlcon . ' and isdiscount=1 and status=1 and deleted=0'), $param));
			}
			else {
				$goodsids = explode(',', $shop['goodsids']);
				$goodsids = array_filter($goodsids);
				$shop['goodsids'] = implode(',', $goodsids);
				$statics = array('all' => count($goodsids), 'new' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . (' where uniacid=:uniacid ' . $sqlcon . ' and id in(') . $shop['goodsids'] . ') and isnew=1 and status=1 and deleted=0', $param), 'discount' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . (' where uniacid=:uniacid ' . $sqlcon . ' and id in(') . $shop['goodsids'] . ') and isdiscount=1 and status=1 and deleted=0', $param));
			}
		}
		else {
			if ($goods['checked'] == 1) {
				$err = true;
				include $this->template();
				exit();
			}

			$shop = $this->merch_user;
			$shopdetail = array('logo' => !empty($goods['detail_logo']) ? tomedia($goods['detail_logo']) : tomedia($shop['logo']), 'shopname' => !empty($goods['detail_shopname']) ? $goods['detail_shopname'] : $shop['merchname'], 'description' => !empty($goods['detail_totaltitle']) ? $goods['detail_totaltitle'] : $shop['description'], 'btntext1' => trim($goods['detail_btntext1']), 'btnurl1' => !empty($goods['detail_btnurl1']) ? $goods['detail_btnurl1'] : mobileUrl('goods'), 'btntext2' => trim($goods['detail_btntext2']), 'btnurl2' => !empty($goods['detail_btnurl2']) ? $goods['detail_btnurl2'] : mobileUrl('merch', array('merchid' => $goods['merchid'])));

			if (empty($shop['selectgoods'])) {
				$statics = array('all' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and merchid=:merchid and status=1 and deleted=0', array(':uniacid' => $_W['uniacid'], ':merchid' => $goods['merchid'])), 'new' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and merchid=:merchid and isnew=1 and status=1 and deleted=0', array(':uniacid' => $_W['uniacid'], ':merchid' => $goods['merchid'])), 'discount' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and merchid=:merchid and isdiscount=1 and status=1 and deleted=0', array(':uniacid' => $_W['uniacid'], ':merchid' => $goods['merchid'])));
			}
			else {
				$goodsids = explode(',', $shop['goodsids']);
				$statics = array('all' => count($goodsids), 'new' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . (' where uniacid=:uniacid and merchid=:merchid and id in( ' . $shop['goodsids'] . ' ) and isnew=1 and status=1 and deleted=0'), array(':uniacid' => $_W['uniacid'], ':merchid' => $goods['merchid'])), 'discount' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . (' where uniacid=:uniacid and merchid=:merchid and id in( ' . $shop['goodsids'] . ' ) and isdiscount=1 and status=1 and deleted=0'), array(':uniacid' => $_W['uniacid'], ':merchid' => $goods['merchid'])));
			}
		}

		$goodsdesc = !empty($goods['description']) ? $goods['description'] : $goods['subtitle'];
		$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goodsdesc) ? $goodsdesc : $_W['shopset']['shop']['name'], 'link' => mobileUrl('goods/detail', array('id' => $goods['id']), true));
		$com = p('commission');

		if ($com) {
			$cset = $_W['shopset']['commission'];

			if (!empty($cset)) {
				if ($member['isagent'] == 1 && $member['status'] == 1) {
					$_W['shopshare']['link'] = mobileUrl('goods/detail', array('id' => $goods['id'], 'mid' => $member['id']), true);
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = mobileUrl('goods/detail', array('id' => $goods['id'], 'mid' => $_GPC['mid']), true);
					}
				}
			}

			if ($goods['nocommission'] == 0) {
				$glevel = $this->getLevel($openid);
				if (!empty($goods) && $goods['hasoption']) {
					$optioncomm = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));
				}

				$goods['seecommission'] = $this->getCommission($optioncomm, $goods, $glevel, $cset);
			}
			else {
				$goods['seecommission'] = 0;
			}

			$goods['cansee'] = $cset['cansee'];
			$goods['seetitle'] = $cset['seetitle'];
		}
		else {
			$goods['cansee'] = 0;
		}

		if (0 < $goods['seecommission']) {
			$goods['seecommission'] = round($goods['seecommission'], 2);
		}

		$stores = array();

		if ($goods['isverify'] == 2) {
			$storeids = array();

			if (!empty($goods['storeids'])) {
				$storeids = array_merge(explode(',', $goods['storeids']), $storeids);
			}

			if (empty($storeids)) {
				if (0 < $merchid) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
				}
			}
			else if (0 < $merchid) {
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
			}
			else {
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
			}
		}

		$share = m('common')->getSysset('share');
		$share['goods_detail_text'] = nl2br($share['goods_detail_text']);
		if (p('ccard') && $goods['type'] == 20) {
			$diyformhtml = '';
			$diyform_plugin = p('diyform');

			if ($diyform_plugin) {
				$fields = false;

				if ($goods['diyformtype'] == 1) {
					if (!empty($goods['diyformid'])) {
						$diyformid = $goods['diyformid'];
						$formInfo = $diyform_plugin->getDiyformInfo($diyformid);
						$fields = $formInfo['fields'];
					}
				}
				else {
					if ($goods['diyformtype'] == 2) {
						$diyformid = 0;
						$fields = iunserializer($goods['diyfields']);

						if (empty($fields)) {
							$fields = false;
						}
					}
				}

				if (!empty($fields)) {
					ob_start();
					$inPicker = true;
					$openid = $_W['openid'];
					$member = m('member')->getMember($openid, true);
					$f_data = $diyform_plugin->getLastData(3, 0, $diyformid, $id, $fields, $member);
					$flag = 0;

					if (!empty($f_data)) {
						foreach ($f_data as $k => $v) {
							if (!empty($v)) {
								$flag = 1;
								break;
							}
						}
					}

					if (empty($flag)) {
						$f_data = $diyform_plugin->getLastCartData($id);
					}

					$f_data['diychongzhijine'] = $goods['minprice'];
					include $this->template('ccard/formfields');
					$diyformhtml = ob_get_contents();
					ob_clean();
				}
			}

			include $this->template('ccard/ccard_detail');
			exit();
		}

		$new_temp = !is_mobile() ? 1 : intval($_W['shopset']['template']['detail_temp']);
		if ($new_temp && $getComments) {
			$showComments = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level>=0 and deleted=0 and checked=0 and uniacid=:uniacid', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));
		}

		$close_preview = intval($_W['shopset']['shop']['close_preview']);
		$goods['city_express_state'] = 1;
		$city_express = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_city_express') . ' WHERE uniacid=:uniacid and merchid=0 limit 1', array(':uniacid' => $_W['uniacid']));
		if (empty($city_express) || $city_express['enabled'] == 0 || 0 < $goods['merchid'] || $goods['type'] != 1) {
			$goods['city_express_state'] = 0;
		}
		else {
			if (empty($city_express['is_dispatch'])) {
				$goods['dispatchprice'] = array('min' => $city_express['start_fee'], 'max' => $city_express['fixed_fee']);
			}
		}

		$buttonFixedImageSetting = m('common')->getGoodsBottomFixedImageSetting();
		if (empty($goods['merchid']) && $buttonFixedImageSetting['shopStatus']) {
			$goods['bottomFixedImageUrls'] = empty($buttonFixedImageSetting['urls']) ? array() : $buttonFixedImageSetting['urls'];
		}
		else {
			if ($goods['merchid'] != 0 && $buttonFixedImageSetting['merchStatus']) {
				$goods['bottomFixedImageUrls'] = empty($buttonFixedImageSetting['urls']) ? array() : $buttonFixedImageSetting['urls'];
			}
			else {
				$goods['bottomFixedImageUrls'] = array();
			}
		}

		$plugin_diypage = p('diypage');

		if ($plugin_diypage) {
			$diypage = $plugin_diypage->detailPage($goods['diypage']);
			p('diypage')->setShare($diypage, $goods);

			if ($diypage) {
				$startadv = $plugin_diypage->getStartAdv($diypage['diyadv']);
				include $this->template('diypage/detail');
				exit();
			}
		}

		include $this->template();
	}

	public function get_code()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$uniacid = intval($_W['uniacid']);
		$openid = trim($_W['openid']);
		$goods = pdo_fetch('select id,minprice,minprice,maxprice,thumb_url,thumb,title from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$goods['minprice'] = round($goods['minprice'], 2);
		$goods['maxprice'] = round($goods['maxprice'], 2);
		$member = m('member')->getMember($openid);
		$commission_data = m('common')->getPluginset('commission');
		$goodscode = '';
		$parameter = array();

		if (com('goodscode')) {
			if ($goods['minprice'] == $goods['maxprice']) {
				$price = '¥' . $goods['minprice'];
			}
			else {
				$price = '¥' . $goods['minprice'] . ' ~ ' . $goods['maxprice'];
			}

			$goods['thumb_url'] = array_values(unserialize($goods['thumb_url']));
			$goods['thumb'] = $goods['thumb_url'][0];
			$url = mobileUrl('goods/detail', array('id' => $id, 'mid' => $member['id']), true);
			$qrcode = m('qrcode')->createQrcode($url);

			if ($commission_data['codeShare'] == 1) {
				$title[0] = mb_substr($goods['title'], 0, 10, 'utf-8');
				$title[1] = mb_substr($goods['title'], 10, 10, 'utf-8');
				$title = '    ' . $title[0] . '
    ' . $title[1];
				$codedata = array(
					'portrait' => array('thumb' => tomedia($_W['shopset']['shop']['logo']) ? tomedia($_W['shopset']['shop']['logo']) : tomedia($member['avatar']), 'left' => 40, 'top' => 40, 'width' => 100, 'height' => 100),
					'shopname' => array('text' => $_W['shopset']['shop']['name'], 'left' => 160, 'top' => 80, 'size' => 28, 'width' => 360, 'height' => 50, 'color' => '#333'),
					'thumb'    => array('thumb' => tomedia($goods['thumb']), 'left' => 40, 'top' => 160, 'width' => 560, 'height' => 560),
					'qrcode'   => array('thumb' => tomedia($qrcode), 'left' => 23, 'top' => 730, 'width' => 220, 'height' => 220),
					'title'    => array('text' => $title, 'left' => 230, 'top' => 770, 'size' => 24, 'width' => 360, 'height' => 50, 'color' => '#333'),
					'price'    => array('text' => $price, 'left' => 270, 'top' => 880, 'size' => 30, 'color' => '#f20'),
					'desc'     => array('text' => '长按二维码扫码购买', 'left' => 210, 'top' => 980, 'size' => 18, 'color' => '#666')
				);
			}
			else if ($commission_data['codeShare'] == 2) {
				$title[0] = mb_substr($goods['title'], 0, 14, 'utf-8');
				$title[1] = mb_substr($goods['title'], 14, 14, 'utf-8');
				$title = '    ' . $title[0] . '
    ' . $title[1];
				$codedata = array(
					'thumb'    => array('thumb' => tomedia($goods['thumb']), 'left' => 20, 'top' => 20, 'width' => 150, 'height' => 150),
					'title'    => array('text' => $title, 'left' => 170, 'top' => 30, 'size' => 22, 'width' => 430, 'height' => 90, 'color' => '#333'),
					'price'    => array('text' => $price, 'left' => 210, 'top' => 120, 'size' => 30, 'color' => '#f20'),
					'qrcode'   => array('thumb' => tomedia($qrcode), 'left' => 170, 'top' => 200, 'width' => 300, 'height' => 300),
					'desc'     => array('text' => '长按二维码扫码购买', 'left' => 205, 'top' => 510, 'size' => 18, 'color' => '#666'),
					'shopname' => array('text' => $_W['shopset']['shop']['name'], 'left' => 0, 'top' => 585, 'size' => 28, 'width' => 640, 'height' => 50, 'color' => '#fff')
				);
			}
			else {
				if ($commission_data['codeShare'] == 3) {
					$title[0] = mb_substr($goods['title'], 0, 12, 'utf-8');
					$title[1] = mb_substr($goods['title'], 12, 12, 'utf-8');
					$title = '                ' . $title[0] . '
                ' . $title[1];
					$codedata = array(
						'title'  => array('text' => $title, 'left' => 27, 'top' => 40, 'size' => 22, 'width' => 600, 'height' => 90, 'color' => '#333'),
						'thumb'  => array('thumb' => tomedia($goods['thumb']), 'left' => 0, 'top' => 150, 'width' => 640, 'height' => 640),
						'qrcode' => array('thumb' => tomedia($qrcode), 'left' => 20, 'top' => 810, 'width' => 220, 'height' => 220),
						'price'  => array('text' => $price, 'left' => 280, 'top' => 870, 'size' => 30, 'color' => '#000'),
						'desc'   => array('text' => '长按二维码扫码购买', 'left' => 280, 'top' => 950, 'size' => 18, 'color' => '#666')
					);
				}
			}

			$parameter = array('goodsid' => $id, 'qrcode' => $qrcode, 'codedata' => $codedata, 'mid' => $member['id'], 'codeshare' => $commission_data['codeShare']);
			$goodscode = com('goodscode')->createcode($parameter);
		}
		else {
			if ($goods['minprice'] == $goods['maxprice']) {
				$price = '¥' . $goods['minprice'];
			}
			else {
				$price = '¥' . $goods['minprice'] . ' ~ ' . $goods['maxprice'];
			}

			if (substr($goods['thumb'], 0, 2) == '//') {
				$goods['thumb'] = 'http:' . substr($goods['thumb'], stripos($goods['thumb'], '//'));
			}

			$url = mobileUrl('goods/detail', array('id' => $id, 'mid' => $member['id']), true);
			$qrcode = m('qrcode')->createQrcode($url);

			if ($commission_data['codeShare'] == 1) {
				$title[0] = mb_substr($goods['title'], 0, 10, 'utf-8');
				$title[1] = mb_substr($goods['title'], 10, 10, 'utf-8');
				$title = '    ' . $title[0] . '
    ' . $title[1];
				$codedata = array(
					'portrait' => array('thumb' => tomedia($_W['shopset']['shop']['logo']) ? tomedia($_W['shopset']['shop']['logo']) : tomedia($member['avatar']), 'left' => 40, 'top' => 40, 'width' => 100, 'height' => 100),
					'shopname' => array('text' => $_W['shopset']['shop']['name'], 'left' => 160, 'top' => 80, 'size' => 28, 'width' => 360, 'height' => 50, 'color' => '#333'),
					'thumb'    => array('thumb' => tomedia($goods['thumb']), 'left' => 40, 'top' => 160, 'width' => 560, 'height' => 560),
					'qrcode'   => array('thumb' => tomedia($qrcode), 'left' => 23, 'top' => 730, 'width' => 220, 'height' => 220),
					'title'    => array('text' => $title, 'left' => 230, 'top' => 770, 'size' => 24, 'width' => 360, 'height' => 50, 'color' => '#333'),
					'price'    => array('text' => $price, 'left' => 270, 'top' => 880, 'size' => 30, 'color' => '#f20'),
					'desc'     => array('text' => '长按二维码扫码购买', 'left' => 210, 'top' => 980, 'size' => 18, 'color' => '#666')
				);
			}
			else {
				if ($commission_data['codeShare'] == 2) {
					$title[0] = mb_substr($goods['title'], 0, 14, 'utf-8');
					$title[1] = mb_substr($goods['title'], 14, 14, 'utf-8');
					$title = '    ' . $title[0] . '
    ' . $title[1];
					$codedata = array(
						'thumb'    => array('thumb' => tomedia($goods['thumb']), 'left' => 20, 'top' => 20, 'width' => 150, 'height' => 150),
						'title'    => array('text' => $title, 'left' => 170, 'top' => 30, 'size' => 22, 'width' => 430, 'height' => 90, 'color' => '#333'),
						'price'    => array('text' => $price, 'left' => 210, 'top' => 120, 'size' => 30, 'color' => '#f20'),
						'qrcode'   => array('thumb' => tomedia($qrcode), 'left' => 170, 'top' => 200, 'width' => 300, 'height' => 300),
						'desc'     => array('text' => '长按二维码扫码购买', 'left' => 205, 'top' => 510, 'size' => 18, 'color' => '#666'),
						'shopname' => array('text' => $_W['shopset']['shop']['name'], 'left' => 0, 'top' => 585, 'size' => 28, 'width' => 640, 'height' => 50, 'color' => '#fff')
					);
				}
			}

			$parameter = array('goodsid' => $id, 'qrcode' => $qrcode, 'codedata' => $codedata, 'mid' => $member['id'], 'codeshare' => $commission_data['codeShare']);
			$goodscode = m('goods')->createcode($parameter);
		}

		return $goodscode;
	}

	public function querygift()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$giftid = intval($_GPC['id']);
		$gift = pdo_fetch('select * from ' . tablename('ewei_shop_gift') . ' where id=:id and status=1 and  uniacid =:uniacid limit 1', array(':id' => $giftid, ':uniacid' => $_W['uniacid']));
		show_json(1, $gift);
	}

	protected function getGoodsDispatchPrice($goods, $is_seckill = false)
	{
		if (!empty($goods['issendfree']) && empty($is_seckill)) {
			return 0;
		}

		if ($goods['type'] == 2 || $goods['type'] == 3 || $goods['type'] == 20) {
			return 0;
		}

		if ($goods['dispatchtype'] == 1) {
			return $goods['dispatchprice'];
		}

		if (empty($goods['dispatchid'])) {
			$dispatch = m('dispatch')->getDefaultDispatch($goods['merchid']);
		}
		else {
			$dispatch = m('dispatch')->getOneDispatch($goods['dispatchid']);
		}

		if (empty($dispatch)) {
			$dispatch = m('dispatch')->getNewDispatch($goods['merchid']);
		}

		$areas = iunserializer($dispatch['areas']);
		if (!empty($areas) && is_array($areas)) {
			$firstprice = array();

			foreach ($areas as $val) {
				if (empty($dispatch['calculatetype'])) {
					$firstprice[] = $val['firstprice'];
				}
				else {
					$firstprice[] = $val['firstnumprice'];
				}
			}

			array_push($firstprice, m('dispatch')->getDispatchPrice(1, $dispatch));
			$ret = array('min' => round(min($firstprice), 2), 'max' => round(max($firstprice), 2));
		}
		else {
			$ret = m('dispatch')->getDispatchPrice(1, $dispatch);
		}

		return $ret;
	}

	public function get_detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		exit(m('ui')->lazy($goods['content']));
	}

	public function get_comments()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$percent = 100;
		$params = array(':goodsid' => $id, ':uniacid' => $_W['uniacid']);
		$count = array('all' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level>=0 and deleted=0 and checked=0 and uniacid=:uniacid', $params), 'good' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level>=5 and deleted=0 and checked=0 and uniacid=:uniacid', $params), 'normal' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level>=2 and level<=4 and deleted=0 and checked=0 and uniacid=:uniacid', $params), 'bad' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level<=1 and deleted=0 and checked=0 and uniacid=:uniacid', $params), 'pic' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and ifnull(images,\'a:0:{}\')<>\'a:0:{}\' and deleted=0 and checked=0 and uniacid=:uniacid', $params));
		$list = array();

		if (0 < $count['all']) {
			$percent = intval($count['good'] / (empty($count['all']) ? 1 : $count['all']) * 100);
			$list = pdo_fetchall('select nickname,level,content,images,createtime from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and deleted=0 and checked=0 and uniacid=:uniacid order by istop desc, createtime desc, id desc limit 2', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['images'] = set_medias(iunserializer($row['images']));
				$row['nickname'] = cut_str($row['nickname'], 1, 0) . '**' . cut_str($row['nickname'], 1, -1);
			}

			unset($row);
		}

		show_json(1, array('count' => $count, 'percent' => $percent, 'list' => $list));
	}

	/**
     * 计算出此商品的佣金
     * @param type $goodsid
     * @return type
     */
	public function getCommission($option = array(), $goods, $level, $set)
	{
		global $_W;
		$commission = 0;

		if ($level == 'false') {
			return $commission;
		}

		if ($goods['hascommission'] == 1) {
			$price = $goods['maxprice'];
			$levelid = 'default';

			if ($level) {
				$levelid = 'level' . $level['id'];
			}

			$goods_commission = !empty($goods['commission']) ? json_decode($goods['commission'], true) : array();

			if ($goods_commission['type'] == 0) {
				if ($goods['marketprice'] <= $goods['maxprice']) {
					$goods['marketprice'] = $goods['maxprice'];
				}

				$commission = 1 <= $set['level'] ? (0 < $goods['commission1_rate'] ? $goods['commission1_rate'] * $goods['marketprice'] / 100 : $goods['commission1_pay']) : 0;
			}
			else {
				$price_all = array();

				if (!empty($option)) {
					foreach ($goods_commission[$levelid] as $key => $value) {
						foreach ($option as $k => $v) {
							if ('option' . $v['id'] == $key) {
								if (strexists($value[0], '%')) {
									$optioncommission = floatval(str_replace('%', '', $value[0]) / 100) * $v['marketprice'];
									continue;
								}

								$optioncommission = $value[0];
								continue;
							}

							array_push($price_all, $optioncommission);
						}
					}
				}
				else {
					foreach ($goods_commission[$levelid] as $key => $value) {
						foreach ($value as $k => $v) {
							if (strexists($v, '%')) {
								array_push($price_all, floatval(str_replace('%', '', $v) / 100) * $price);
								continue;
							}

							array_push($price_all, $v);
						}
					}
				}

				$commission = max($price_all);
			}
		}
		else {
			if ($goods['marketprice'] <= $goods['maxprice']) {
				$goods['marketprice'] = $goods['maxprice'];
			}

			if ($level != 'false' && !empty($level)) {
				$commission = 1 <= $set['level'] ? round($level['commission1'] * $goods['marketprice'] / 100, 2) : 0;
			}
			else {
				$commission = 1 <= $set['level'] ? round($set['commission1'] * $goods['marketprice'] / 100, 2) : 0;
			}
		}

		return $commission;
	}

	public function getLevel($openid)
	{
		global $_W;
		$level = 'false';

		if (empty($openid)) {
			return $level;
		}

		$member = m('member')->getMember($openid);
		if (empty($member['isagent']) || $member['status'] == 0 || $member['agentblack'] == 1) {
			return $level;
		}

		$level = pdo_fetch('select * from ' . tablename('ewei_shop_commission_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $member['agentlevel']));
		return $level;
	}

	public function get_offic_list()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = intval($_GPC['type']);
		$openid = trim($_W['openid']);
		$params = array(':goodsid' => $id, ':uniacid' => $_W['uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and o.uniacid = :uniacid and o.goodsid = :goodsid and o.enabled = 1 ';

		if (0 < $type) {
			$condition .= ' and o.openid = :openid ';
			$params[':openid'] = $openid;
		}
		else {
			$condition .= ' and o.chosen = 1 ';
		}

		$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_offic') . (' as o where 1 ' . $condition), $params);
		$list = array();

		if (0 < $total) {
			$list = pdo_fetchall('SELECT o.*,m.avatar,m.nickname,g.thumb,g.title,g.minprice FROM ' . tablename('ewei_shop_offic') . ' as o
                    left join ' . tablename('ewei_shop_member') . ' as m on m.openid = o.openid
                    left join ' . tablename('ewei_shop_goods') . (' as g on g.id = o.goodsid
                    where 1 ' . $condition . ' group by o.id order by o.displayorder desc, o.createtime desc, o.id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
			$list = set_medias($list, 'avatar,thumb');

			foreach ($list as &$row) {
				if (empty($row['openid'])) {
					if (empty($row['avatar'])) {
						$row['avatar'] = $_W['shopset']['shop']['logo'];
						$row['nickname'] = $_W['shopset']['shop']['name'];
					}
				}

				$row['images'] = unserialize($row['images']);
				$row['images'] = set_medias($row['images']);
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			}

			unset($row);
		}

		show_json(1, array('officlist' => $list, 'total' => $total, 'pagesize' => $psize));
	}

	public function get_comment_list()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$level = trim($_GPC['level']);
		$params = array(':goodsid' => $id, ':uniacid' => $_W['uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = '';

		if ($level == 'good') {
			$condition = ' and level=5';
		}
		else if ($level == 'normal') {
			$condition = ' and level>=2 and level<=4';
		}
		else if ($level == 'bad') {
			$condition = ' and level<=1';
		}
		else {
			if ($level == 'pic') {
				$condition = ' and ifnull(images,\'a:0:{}\')<>\'a:0:{}\'';
			}
		}

		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_order_comment') . ' ' . ('  where goodsid=:goodsid and uniacid=:uniacid and deleted=0 and checked=0 ' . $condition . ' order by istop desc, createtime desc, id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($list as &$row) {
			$row['headimgurl'] = tomedia($row['headimgurl']);
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			$row['images'] = set_medias(iunserializer($row['images']));
			$row['reply_images'] = set_medias(iunserializer($row['reply_images']));
			$row['append_images'] = set_medias(iunserializer($row['append_images']));
			$row['append_reply_images'] = set_medias(iunserializer($row['append_reply_images']));
			$row['nickname'] = cut_str($row['nickname'], 1, 0) . '**' . cut_str($row['nickname'], 1, -1);
		}

		unset($row);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . (' where goodsid=:goodsid  and uniacid=:uniacid and deleted=0 and checked=0 ' . $condition), $params);
		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}

	public function qrcode()
	{
		global $_W;
		global $_GPC;
		$url = $_W['root'];
		show_json(1, array('url' => m('qrcode')->createQrcode($url)));
	}

	protected function merchData()
	{
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		return array('is_openmerch' => $is_openmerch, 'merch_plugin' => $merch_plugin, 'merch_data' => $merch_data);
	}

	public function getCouponsbygood($goodid)
	{
		global $_W;
		global $_GPC;
		$merchdata = $this->merchData();
		extract($merchdata);
		$time = time();
		$param = array();
		$param[':uniacid'] = $_W['uniacid'];
		$sql = 'select id,timelimit,coupontype,timedays,timestart,timeend,thumb,couponname,enough,backtype,deduct,discount,backmoney,backcredit,backredpack,bgcolor,thumb,credit,money,getmax,merchid,total as t,islimitlevel,limitmemberlevels,limitagentlevels,limitpartnerlevels,limitaagentlevels,limitgoodcatetype,limitgoodcateids,limitgoodtype,limitgoodids,tagtitle,settitlecolor,titlecolor from ' . tablename('ewei_shop_coupon') . ' c ';
		$sql .= ' where uniacid=:uniacid and money=0 and credit = 0 and coupontype=0';

		if ($is_openmerch == 0) {
			$sql .= ' and merchid=0';
		}
		else if (!empty($_GPC['merchid'])) {
			$sql .= ' and merchid=:merchid';
			$param[':merchid'] = intval($_GPC['merchid']);
		}
		else {
			$sql .= ' and merchid=0';
		}

		$hascommission = false;
		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();
			$hascommission = !empty($plugin_com_set['level']);

			if (empty($plugin_com_set['level'])) {
				$sql .= ' and ( limitagentlevels = "" or  limitagentlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitagentlevels = "" or  limitagentlevels is null )';
		}

		$hasglobonus = false;
		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !empty($plugin_globonus_set['open']);

			if (empty($plugin_globonus_set['open'])) {
				$sql .= ' and ( limitpartnerlevels = ""  or  limitpartnerlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitpartnerlevels = ""  or  limitpartnerlevels is null )';
		}

		$hasabonus = false;
		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !empty($plugin_abonus_set['open']);

			if (empty($plugin_abonus_set['open'])) {
				$sql .= ' and ( limitaagentlevels = "" or  limitaagentlevels is null )';
			}
		}
		else {
			$sql .= ' and ( limitaagentlevels = "" or  limitaagentlevels is null )';
		}

		$sql .= ' and gettype=1 and (total=-1 or total>0) and ( timelimit = 0 or  (timelimit=1 and timeend>unix_timestamp()))';
		$sql .= ' order by displayorder desc, id desc  ';
		$list = set_medias(pdo_fetchall($sql, $param), 'thumb');

		if (empty($list)) {
			$list = array();
		}

		if (!empty($goodid)) {
			$goodparam[':uniacid'] = $_W['uniacid'];
			$goodparam[':id'] = $goodid;
			$sql = 'select id,cates,marketprice,merchid   from ' . tablename('ewei_shop_goods');
			$sql .= ' where uniacid=:uniacid and id =:id order by id desc LIMIT 1 ';
			$good = pdo_fetch($sql, $goodparam);
		}

		$cates = explode(',', $good['cates']);

		if (!empty($list)) {
			foreach ($list as $key => &$row) {
				$row = com('coupon')->setCoupon($row, time());
				$row['thumb'] = tomedia($row['thumb']);
				$row['timestr'] = '永久有效';

				if (empty($row['timelimit'])) {
					if (!empty($row['timedays'])) {
						$row['timestr'] = '自领取日后' . $row['timedays'] . '天有效';
					}
				}
				else if ($time <= $row['timestart']) {
					$row['timestr'] = '有效期至:' . date('Y-m-d', $row['timestart']) . '-' . date('Y-m-d', $row['timeend']);
				}
				else {
					$row['timestr'] = '有效期至:' . date('Y-m-d', $row['timeend']);
				}

				if ($row['backtype'] == 0) {
					$row['backstr'] = '立减';
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
							$row['backmoney'] = (double) $row['backredpack'];
							$row['backpre'] = true;
						}
						else if (0 < $row['backmoney']) {
							$row['backstr'] = '返利';
							$row['backmoney'] = (double) $row['backmoney'];
							$row['backpre'] = true;
						}
						else {
							if (!empty($row['backcredit'])) {
								$row['backstr'] = '返积分';
								$row['backmoney'] = (double) $row['backcredit'];
							}
						}
					}
				}

				$limitmemberlevels = explode(',', $row['limitmemberlevels']);
				$limitagentlevels = explode(',', $row['limitagentlevels']);
				$limitpartnerlevels = explode(',', $row['limitpartnerlevels']);
				$limitaagentlevels = explode(',', $row['limitaagentlevels']);
				$p = 0;

				if ($row['islimitlevel'] == 1) {
					$openid = trim($_W['openid']);
					$member = m('member')->getMember($openid);
					if (!empty($row['limitmemberlevels']) || $row['limitmemberlevels'] == '0') {
						$level1 = pdo_fetchall('select * from ' . tablename('ewei_shop_member_level') . ' where uniacid=:uniacid and  id in (' . $row['limitmemberlevels'] . ') ', array(':uniacid' => $_W['uniacid']));

						if (in_array($member['level'], $limitmemberlevels)) {
							$p = 1;
						}
					}

					if ((!empty($row['limitagentlevels']) || $row['limitagentlevels'] == '0') && $hascommission) {
						$level2 = pdo_fetchall('select * from ' . tablename('ewei_shop_commission_level') . ' where uniacid=:uniacid and id  in (' . $row['limitagentlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
						if ($member['isagent'] == '1' && $member['status'] == '1') {
							if (in_array($member['agentlevel'], $limitagentlevels)) {
								$p = 1;
							}
						}
					}

					if ((!empty($row['limitpartnerlevels']) || $row['limitpartnerlevels'] == '0') && $hasglobonus) {
						$level3 = pdo_fetchall('select * from ' . tablename('ewei_shop_globonus_level') . ' where uniacid=:uniacid and  id in(' . $row['limitpartnerlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
						if ($member['ispartner'] == '1' && $member['partnerstatus'] == '1') {
							if (in_array($member['partnerlevel'], $limitpartnerlevels)) {
								$p = 1;
							}
						}
					}

					if ((!empty($row['limitaagentlevels']) || $row['limitaagentlevels'] == '0') && $hasabonus) {
						$level4 = pdo_fetchall('select * from ' . tablename('ewei_shop_abonus_level') . ' where uniacid=:uniacid and  id in (' . $row['limitaagentlevels'] . ') ', array(':uniacid' => $_W['uniacid']));
						if ($member['isaagent'] == '1' && $member['aagentstatus'] == '1') {
							if (in_array($member['aagentlevel'], $limitaagentlevels)) {
								$p = 1;
							}
						}
					}
				}
				else {
					$p = 1;
				}

				if ($p == 1) {
					$p = 0;
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

					if ($p == 0) {
						unset($list[$key]);
					}
				}
				else {
					unset($list[$key]);
				}
			}

			unset($row);
		}

		return array_values($list);
	}

	public function pay($a = array(), $b = array())
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$id = intval($_GPC['id']);
		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$coupon = com('coupon')->setCoupon($coupon, time());

		if (empty($coupon['gettype'])) {
			show_json(-1, '无法' . $coupon['gettypestr']);
		}

		if ($coupon['total'] != -1) {
			if ($coupon['total'] <= 0) {
				show_json(-1, '优惠券数量不足');
			}
		}

		if (!$coupon['canget']) {
			show_json(-1, '您已超出' . $coupon['gettypestr'] . '次数限制');
		}

		if (0 < $coupon['money'] || 0 < $coupon['credit']) {
			show_json(-1, '此优惠券需要前往领卷中心兑换');
		}

		$logno = m('common')->createNO('coupon_log', 'logno', 'CC');
		$log = array('uniacid' => $_W['uniacid'], 'merchid' => $coupon['merchid'], 'openid' => $openid, 'logno' => $logno, 'couponid' => $id, 'status' => 0, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => 1);
		pdo_insert('ewei_shop_coupon_log', $log);
		$result = com('coupon')->payResult($log['logno']);

		if (is_error($result)) {
			show_json($result['errno'], $result['message']);
		}

		show_json(1, array('url' => $result['url'], 'dataid' => $result['dataid'], 'coupontype' => $result['coupontype']));
	}
}

?>
