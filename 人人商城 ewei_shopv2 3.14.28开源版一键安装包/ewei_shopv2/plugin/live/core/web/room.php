<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Room_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' l.uniacid = :uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);

			if ($_GPC['seach'] == 'title') {
				$condition .= ' AND l.title LIKE :title';
				$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
			}
			else {
				if ($_GPC['seach'] == 'cate') {
					$condition .= ' AND lc.name LIKE :cate';
					$params[':cate'] = '%' . trim($_GPC['keyword']) . '%';
				}
			}
		}

		if ($_GPC['state'] != '') {
			$condition .= ' AND l.status = :status';
			$params[':status'] = intval($_GPC['state']);
		}

		if ($_GPC['isrecommand'] != '') {
			$condition .= ' AND l.recommend = :isrecommand';
			$params[':isrecommand'] = intval($_GPC['isrecommand']);
		}

		$sql = 'SELECT l.*,lc.name FROM ' . tablename('ewei_shop_live') . ' as l
		        left join ' . tablename('ewei_shop_live_category') . (' as lc on lc.id = l.category
		        where  1 and ' . $condition . ' ORDER BY l.displayorder DESC,l.id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_live') . ' as l
		        left join ' . tablename('ewei_shop_live_category') . (' as lc on lc.id = l.category
		        where  1 and ' . $condition), $params);

		foreach ($list as $key => &$value) {
			if ($value['covertype'] == 1) {
				$value['thumb'] = $value['cover'];
			}

			$url = mobileUrl('live/room', array('id' => $value['id']), true);
			$value['qrcode'] = m('qrcode')->createQrcode($url);
		}

		unset($value);

		if ($merch_plugin) {
			$merch_user = $merch_plugin->getListUser($list, 'merch_user');
			if (!empty($list) && !empty($merch_user)) {
				foreach ($list as &$row) {
					$row['merchname'] = $merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name'];
				}

				unset($row);
			}
		}

		$pager = pagination2($total, $pindex, $psize);
		$category = pdo_fetchall('select id,`name`,thumb from ' . tablename('ewei_shop_live_category') . ' where uniacid=:uniacid order by displayorder desc', array(':uniacid' => $_W['uniacid']), 'id');
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$id = intval($_GPC['id']);

		if (0 < $id) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_live') . ' where uniacid = ' . $uniacid . ' and id = ' . $id . ' ');
			$coupon = array();

			if (!empty($item['couponid'])) {
				$coupon = pdo_fetchall('select c.couponname,c.thumb,c.id,lc.coupontotal,lc.couponlimit from ' . tablename('ewei_shop_live_coupon') . ' as lc
                        left join ' . tablename('ewei_shop_coupon') . ' as c on c.id = lc.couponid
                        where lc.uniacid = ' . $uniacid . ' and lc.roomid = ' . $id . ' and lc.couponid in(' . $item['couponid'] . ')  ');
			}

			$couponid = $item['couponid'];
		}

		$goodsarr = json_decode(htmlspecialchars_decode($_GPC['goodsarr']), true);
		$goodsid = array();

		if (!empty($goodsarr)) {
			foreach ($goodsarr as $goods) {
				$goodsid[] = $goods['id'];
			}
		}

		$goodsids = implode(',', $goodsid);

		if ($_W['ispost']) {
			$data = array('displayorder' => intval($_GPC['displayorder']), 'uniacid' => $uniacid, 'title' => trim($_GPC['title']), 'liveidentity' => trim($_GPC['liveidentity']), 'url' => trim($_GPC['url']), 'video' => trim($_GPC['video']), 'thumb' => save_media($_GPC['thumb']), 'cover' => save_media($_GPC['cover']), 'covertype' => intval($_GPC['covertype']), 'goodsid' => $goodsids, 'iscoupon' => intval($_GPC['iscoupon']), 'couponid' => $_GPC['couponid'], 'livetype' => intval($_GPC['livetype']), 'screen' => intval($_GPC['screen']), 'category' => intval($_GPC['category']), 'livetime' => strtotime($_GPC['livetime']), 'recommend' => intval($_GPC['recommend']), 'hot' => intval($_GPC['hot']), 'status' => intval($_GPC['status']), 'introduce' => m('common')->html_images($_GPC['introduce']), 'packetmoney' => floatval($_GPC['packetmoney']), 'packettotal' => intval($_GPC['packettotal']), 'packetprice' => floatval($_GPC['packetprice']), 'packetdes' => trim($_GPC['packetdes']), 'invitation_id' => intval($_GPC['invitation_id']), 'showlevels' => is_array($_GPC['showlevels']) ? implode(',', $_GPC['showlevels']) : '', 'showgroups' => is_array($_GPC['showgroups']) ? implode(',', $_GPC['showgroups']) : '', 'showcommission' => is_array($_GPC['showcommission']) ? implode(',', $_GPC['showcommission']) : '', 'jurisdiction_url' => trim($_GPC['jurisdiction_url']), 'jurisdictionurl_show' => intval($_GPC['jurisdictionurl_show']), 'notice' => trim($_GPC['notice']), 'notice_url' => trim($_GPC['notice_url']), 'followqrcode' => trim($_GPC['followqrcode']), 'share_title' => trim($_GPC['share_title']), 'share_icon' => trim($_GPC['share_icon']), 'share_desc' => trim($_GPC['share_desc']), 'share_url' => trim($_GPC['share_url']));
			$nestable = $_GPC['nestable'];
			$tabs = array(
				'interaction' => array('name' => trim($_GPC['dtab']['tabtitle']), 'isshow' => 1),
				'goods'       => array('name' => trim($_GPC['dtab']['goodstitle']), 'isshow' => $_GPC['dtab']['goodstitleshow'] === '0' ? 0 : 1),
				'introduce'   => array('name' => trim($_GPC['dtab']['introducetitle']), 'isshow' => $_GPC['dtab']['introducetitleshow'] === '0' ? 0 : 1),
				'customname1' => array('name' => trim($_GPC['dtab']['customname1']), 'type' => trim($_GPC['dtab']['customtype1']), 'url' => $_GPC['dtab']['customurl1'], 'introduce' => m('common')->html_images($_GPC['dtab']['customintroduce1']), 'isshow' => in_array('customname1', $nestable) ? 1 : 0),
				'customname2' => array('name' => trim($_GPC['dtab']['customname2']), 'type' => trim($_GPC['dtab']['customtype2']), 'url' => $_GPC['dtab']['customurl2'], 'introduce' => m('common')->html_images($_GPC['dtab']['customintroduce2']), 'isshow' => in_array('customname2', $nestable) ? 1 : 0),
				'customname3' => array('name' => trim($_GPC['dtab']['customname3']), 'type' => trim($_GPC['dtab']['customtype3']), 'url' => $_GPC['dtab']['customurl3'], 'introduce' => m('common')->html_images($_GPC['dtab']['customintroduce3']), 'isshow' => in_array('customname3', $nestable) ? 1 : 0),
				'customname4' => array('name' => trim($_GPC['dtab']['customname4']), 'type' => trim($_GPC['dtab']['customtype4']), 'url' => $_GPC['dtab']['customurl4'], 'introduce' => m('common')->html_images($_GPC['dtab']['customintroduce4']), 'isshow' => in_array('customname4', $nestable) ? 1 : 0)
				);
			$tab_total = !intval($tabs['goods']['isshow']) + !intval($tabs['introduce']['isshow']) + intval($tabs['customname1']['isshow']) + intval($tabs['customname2']['isshow']) + intval($tabs['customname3']['isshow']) + intval($tabs['customname4']['isshow']);

			if (4 < $tab_total) {
				$length = $tab_total + 1;
				show_json(0, '您现在有' . $length . '个菜单，最多使用5个菜单，请删除多余菜单！');
			}

			$tab = array();

			foreach ($nestable as $value) {
				$tab[$value] = $tabs[$value];
			}

			$data['tabs'] = serialize($tab);
			$data['nestable'] = serialize(array_unique($nestable));

			if ($data['packetmoney'] < 0) {
				show_json(0, '请填写正确的红包总额！');
			}

			if ($data['packettotal'] < 0) {
				show_json(0, '请填写正确的红包个数！');
			}

			if ($data['packetprice'] < 0) {
				show_json(0, '请填写正确的红包金额！');
			}

			if ($data['livetype'] == 2) {
				if (!empty($data['video'])) {
					if (!$this->check_url($data['video'])) {
						show_json(0, '请输入合法的地址！');
					}
				}
				else {
					show_json(0, '视频流地址不能为空！');
				}
			}
			else if (!empty($data['url'])) {
				if (!$this->check_url($data['url'])) {
					show_json(0, '请输入合法的地址！');
				}
			}
			else {
				show_json(0, '直播地址不能为空！');
			}

			if (!empty($goodsid)) {
				$data['goodsid'] = is_array($goodsid) ? implode(',', $goodsid) : 0;
			}

			if (!empty($data['couponid'])) {
				foreach ($_GPC['couponid'] as $key => $value) {
					if (strpos($couponid, $value) !== false) {
						pdo_update('ewei_shop_live_coupon', array('coupontotal' => $_GPC['coupontotal' . $value . ''], 'couponlimit' => $_GPC['couponlimit' . $value . '']), array('uniacid' => $uniacid, 'roomid' => $id, 'couponid' => $value));
						$couponid = str_replace($value, '', $couponid);
					}
					else {
						$data_coupon = array('uniacid' => $uniacid, 'roomid' => $id, 'couponid' => intval($value), 'coupontotal' => intval($_GPC['coupontotal' . $value . '']), 'couponlimit' => intval($_GPC['couponlimit' . $value . '']));
						pdo_insert('ewei_shop_live_coupon', $data_coupon);
					}
				}
			}

			$couponid = array_filter(explode(',', $couponid));

			if (!empty($couponid)) {
				foreach ($couponid as $value) {
					pdo_delete('ewei_shop_live_coupon', array('couponid' => $value, 'uniacid' => $uniacid, 'roomid' => $id));
				}
			}

			$data['couponid'] = is_array($_GPC['couponid']) ? implode(',', $_GPC['couponid']) : 0;

			if (!empty($id)) {
				if ($item['livetime'] < $data['livetime']) {
					$data['subscribenotice'] = 0;
				}

				pdo_update('ewei_shop_live', $data, array('id' => $id));
				plog('live.room.edit', '编辑直播间 ID: ' . $id . ' <br/>全返名称: ' . $data['title']);
			}
			else {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_live', $data);
				$id = pdo_insertid();
				plog('live.room.add', '添加直播间 ID: ' . $id . '  <br/>全返名称: ' . $data['title']);
			}

			$goodsliveid = $item['goodsid'];

			if (!empty($goodsarr)) {
				foreach ($goodsarr as $key => $value) {
					$good_data = pdo_fetch('select title,thumb,marketprice,goodssn,productsn,hasoption
                            from ' . tablename('ewei_shop_goods') . ' where id = ' . $value['id'] . ' and uniacid = ' . $uniacid . ' ');

					if (empty($data['thumb'])) {
						$data['thumb'] = save_media($good_data['thumb']);
					}

					if (!empty($value['options'])) {
						pdo_delete('ewei_shop_live_goods_option', array('goodsid' => $value['id'], 'uniacid' => $uniacid, 'liveid' => intval($id)));

						foreach ($value['options'] as $options) {
							$live_price = $options['column']['liveprice'] == NULL ? $options['marketprice'] : $options['column']['liveprice'];
							$optionData = array('uniacid' => $uniacid, 'goodsid' => $value['id'], 'optionid' => intval($options['id']), 'liveid' => $id, 'liveprice' => floatval($live_price));
							pdo_insert('ewei_shop_live_goods_option', $optionData);
						}

						$livegoods_option = pdo_fetch('select min(liveprice) as minliveprice,max(liveprice) as maxliveprice from ' . tablename('ewei_shop_live_goods_option') . ' where goodsid = ' . $value['id'] . ' and liveid = ' . $id . ' ');
						$minliveprice = $livegoods_option['minliveprice'];
						$maxliveprice = $livegoods_option['maxliveprice'];
						$liveprice = $livegoods_option['minliveprice'];
					}
					else {
						$live_price = $value['column']['liveprice'] == NULL ? $value['marketprice'] : $value['column']['liveprice'];
						$liveprice = floatval($live_price);
						$minliveprice = $maxliveprice = $liveprice;
					}

					if (strpos($goodsliveid, $value['id']) !== false) {
						$goodsliveid = str_replace($value['id'], '', $goodsliveid);
					}

					$live_goods = pdo_fetch('select * from ' . tablename('ewei_shop_live_goods') . ' where goodsid = ' . $value['id'] . ' and uniacid = ' . $uniacid . ' and liveid = ' . $id . ' ');

					if (empty($live_goods)) {
						$live_goods_data = array('uniacid' => $uniacid, 'goodsid' => $value['id'], 'liveid' => $id, 'minliveprice' => floatval($minliveprice), 'liveprice' => floatval($liveprice), 'maxliveprice' => floatval($maxliveprice), 'liveid' => $id);
						pdo_insert('ewei_shop_live_goods', $live_goods_data);
					}
					else {
						pdo_update('ewei_shop_live_goods', array('minliveprice' => floatval($minliveprice), 'liveprice' => floatval($minliveprice), 'maxliveprice' => floatval($maxliveprice)), array('uniacid' => $uniacid, 'goodsid' => intval($value['id']), 'liveid' => $id));
					}

					unset($liveprice);
					unset($minliveprice);
					unset($maxliveprice);
				}

				$goodsliveid = array_filter(explode(',', $goodsliveid));

				if (!empty($goodsliveid)) {
					foreach ($goodsliveid as $value) {
						pdo_delete('ewei_shop_live_goods', array('uniacid' => $uniacid, 'goodsid' => intval($value), 'liveid' => $id));
					}
				}

				unset($good_data);
				unset($goodsid);
			}

			show_json(1, array('url' => webUrl('live/room/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$menu = unserialize($item['tabs']);
		$nestables = unserialize($item['nestable']);

		if (empty($nestables)) {
			$nestables = array('interaction', 'goods', 'introduce');
		}

		$isInvitation = p('invitation') ? true : false;
		$invitation = array();

		if ($isInvitation) {
			$invitation = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_invitation') . ' WHERE status = 1 and uniacid = ' . $uniacid . ' ORDER BY createtime desc');
		}

		$levels = m('member')->getLevels();

		foreach ($levels as &$l) {
			$l['key'] = 'level' . $l['id'];
		}

		unset($l);
		$levels = array_merge(array(
	array('id' => 0, 'key' => 'default', 'levelname' => empty($_W['shopset']['shop']['levelname']) ? '默认会员' : $_W['shopset']['shop']['levelname'])
	), $levels);
		$groups = m('member')->getGroups();

		if ($item['showlevels'] != '') {
			$item['showlevels'] = explode(',', $item['showlevels']);
		}

		if ($item['showgroups'] != '') {
			$item['showgroups'] = explode(',', $item['showgroups']);
		}

		if ($item['showcommission'] != '') {
			$item['showcommission'] = explode(',', $item['showcommission']);
		}

		$iscommission = false;
		$commission = array();

		if (p('commission')) {
			$iscommission = true;
			$commission = p('commission')->getLevels(true, true);
		}

		$liveidentity = array(
			array('type' => 0, 'identity' => 'qlive', 'name' => '青果直播'),
			array('type' => 0, 'identity' => 'ys7', 'name' => '萤石直播'),
			array('type' => 1, 'identity' => 'panda', 'name' => '熊猫直播'),
			array('type' => 1, 'identity' => 'douyu', 'name' => '斗鱼直播'),
			array('type' => 1, 'identity' => 'huajiao', 'name' => '花椒直播'),
			array('type' => 1, 'identity' => 'yizhibo', 'name' => '一直播'),
			array('type' => 1, 'identity' => 'inke', 'name' => '映客直播'),
			array('type' => 2, 'identity' => 'tencentcloud', 'name' => '腾讯云直播'),
			array('type' => 2, 'identity' => 'alicloud', 'name' => '阿里云直播'),
			array('type' => 2, 'identity' => 'other', 'name' => '其他直播')
			);
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_live_category') . ' where uniacid = ' . $uniacid . ' and enabled = 1 ');
		if (0 < $id && !empty($item['goodsid'])) {
			$goods = pdo_fetchall('select g.id,g.title,g.marketprice,lg.liveprice,lg.minliveprice,lg.maxliveprice,g.thumb,g.hasoption,lg.liveid,g.total  from ' . tablename('ewei_shop_live_goods') . ' as lg 
            left join ' . tablename('ewei_shop_goods') . ' as g on lg.goodsid = g.id and lg.uniacid = g.uniacid
            where lg.liveid = ' . $id . ' and lg.uniacid = ' . $uniacid . ' ');

			foreach ($goods as $key => $value) {
				$goods[$key]['thumb'] = tomedia($goods[$key]['thumb']);

				if (0 < $value['hasoption']) {
					$goods[$key]['options'] = pdo_fetchall('SELECT go.id,lgo.liveprice FROM ' . tablename('ewei_shop_live_goods_option') . ' as lgo
                    left join ' . tablename('ewei_shop_goods_option') . ' as go on lgo.optionid=go.id and lgo.goodsid=go.goodsid and lgo.uniacid=go.uniacid and lgo.liveid = ' . $id . '
                    WHERE go.uniacid = :uniacid and go.goodsid = :goodsid  ORDER BY go.displayorder DESC,go.id DESC ', array(':uniacid' => $uniacid, 'goodsid' => $value['id']));

					foreach ($goods[$key]['options'] as $k => $val) {
						$goods[$key]['options'][$k]['column']['liveprice'] = $goods[$key]['options'][$k]['liveprice'];
					}
				}
				else {
					$goods[$key]['column']['liveprice'] = $goods[$key]['liveprice'];
				}
			}
		}

		include $this->template();
	}

	public function menu_add()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$id = intval($_GPC['id']);
		$nestable = trim($_GPC['nestable']);
		$nestable = explode(',', $nestable);
		$nestable = array_filter($nestable);

		if (empty($nestable)) {
			$nestable = array('interaction', 'goods', 'introduce');
		}

		$menu = array('interaction', 'goods', 'introduce', 'customname1', 'customname2', 'customname3', 'customname4');
		$res = array_diff($menu, $nestable);
		$res = array_values($res);
		show_json(1, array('menu' => $res[0]));
	}

	public function check_url($url)
	{
		if (!preg_match('/\\b(?:(?:https?|http):\\/\\/|www\\.)[-a-z0-9+&@#\\/%?=~_|!:,.;]*[-a-z0-9+&@#\\/%=~_|]/i', $url)) {
			return false;
		}

		return true;
	}

	public function statistics()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$roomid = intval($_GPC['roomid']);
		$start = intval($_GPC['start']);
		$end = intval($_GPC['end']);
		$room = pdo_fetch('select * from ' . tablename('ewei_shop_live') . ' where uniacid = ' . $uniacid . ' and id = ' . $roomid . ' ');
		$table_pushrecords_order = $this->model->getRedisTable('push_records_order', $roomid);
		$pushrecords_order = redis()->lRange($table_pushrecords_order, 0, -1);
		$table_pushrecords = $this->model->getRedisTable('push_records', $roomid);
		$pushrecord = array();
		$pushrecord = redis()->hGetAll($table_pushrecords);
		$coupontotal = 0;
		$redpacktotal = 0;
		$redpacktprice = 0;

		foreach ($pushrecord as $key => $value) {
			$value = json_decode($value, true);

			if ($value['type'] == 2) {
				$coupontotal += $value['total'] - $value['total_remain'];
			}
			else {
				$redpacktotal += $value['total'] - $value['total_remain'];
				$redpacktprice += $value['money'] - $value['money_remain'];
			}
		}

		$statistics_time = pdo_fetchall('select * from ' . tablename('ewei_shop_live_status') . ' where roomid = ' . $roomid . ' and uniacid = ' . $uniacid . ' and endtime != \'\' order by id desc ');
		if (empty($start) || empty($end)) {
			$start = intval($statistics_time[0]['starttime']);
			$end = intval($statistics_time[0]['endtime']);
		}

		$list = array();
		$order = array();
		$order = pdo_fetchall('select og.goodsid,og.price,og.total,g.title from ' . tablename('ewei_shop_order') . ' as o 
                left join ' . tablename('ewei_shop_order_goods') . ' as og on og.orderid = o.id 
                left join ' . tablename('ewei_shop_goods') . ' as g on og.goodsid = g.id
                where o.uniacid = ' . $uniacid . ' and o.liveid = ' . $roomid . ' and o.createtime >= ' . $start . ' and o.createtime <= ' . $end . ' and o.status >= 1 and o.refundid = 0  ');
		$len = count($order);
		$total = 0;
		$allprice = 0;

		foreach ($order as $key => $value) {
			$i = 0;

			foreach ($list as $k => $val) {
				if ($val['goodsid'] == $value['goodsid']) {
					$list[$k]['price'] += $value['price'];
					$list[$k]['total'] += $value['total'];
					$i = 1;
				}
			}

			$total += $order[$key]['total'];
			$allprice += $order[$key]['price'];

			if (0 < $i) {
				unset($order[$key]);
			}
			else {
				$list[$key] = $value;
			}
		}

		foreach ($list as $key => $value) {
			$list[$key]['price'] = price_format($value['price'], 2);
			$list[$key]['totalpro'] = number_format($value['total'] / $total * 100, 0);
			$list[$key]['pricepro'] = number_format($value['price'] / $allprice * 100, 0);
		}

		include $this->template();
	}

	public function hasoption()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$goodsid = intval($_GPC['goodsid']);
		$id = intval($_GPC['id']);
		$hasoption = 0;
		$params = array(':uniacid' => $uniacid, ':goodsid' => $goodsid);

		if (empty($id)) {
			$goods = pdo_fetch('select id,title,marketprice,hasoption from ' . tablename('ewei_shop_goods') . '
                        where id = ' . $goodsid . ' and uniacid = ' . $uniacid . ' ');
		}
		else {
			$goods = pdo_fetch('select g.id,g.title,g.marketprice,lg.liveprice,g.hasoption from ' . tablename('ewei_shop_live_goods') . ' as lg
                    left join ' . tablename('ewei_shop_goods') . ' as g on g.id = lg.goodsid and g.uniacid = lg.uniacid
                    where lg.goodsid = ' . $goodsid . ' and lg.uniacid = ' . $uniacid . ' ');
		}

		$option = array();

		if ($goods['hasoption']) {
			$hasoption = 1;

			if (empty($id)) {
				$option = pdo_fetchall('SELECT go.id,go.title,go.marketprice,go.specs
                FROM ' . tablename('ewei_shop_goods_option') . ' as go 
                WHERE go.uniacid = :uniacid and go.goodsid = :goodsid group by go.id  ORDER BY go.displayorder DESC,go.id DESC ', $params);
			}
			else {
				$option = pdo_fetchall('SELECT go.id,go.title,go.marketprice,go.specs,lgo.liveprice
                FROM ' . tablename('ewei_shop_goods_option') . ' as go 
                left join ' . tablename('ewei_shop_live_goods_option') . ' as lgo on lgo.optionid = go.id and lgo.goodsid = go.goodsid and lgo.uniacid = go.uniacid and lgo.liveid = ' . $id . '
                WHERE go.uniacid = :uniacid and go.goodsid = :goodsid group by go.id  ORDER BY go.displayorder DESC,go.id DESC ', $params);
			}
		}
		else {
			$goods['marketprice'] = $goods['marketprice'];
		}

		include $this->template();
	}

	public function option()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$options = is_array($_GPC['option']) ? implode(',', array_filter($_GPC['option'])) : 0;
		$options = intval($options);
		$option = pdo_fetch('SELECT id,title FROM ' . tablename('ewei_shop_goods_option') . '
            WHERE uniacid = ' . $uniacid . ' and id = ' . $options . '  ORDER BY displayorder DESC,id DESC LIMIT 1');
		show_json(1, $option);
	}

	public function deleted()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_live') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_live', array('id' => $item['id']));
			plog('live.room.deleted', '删除直播间<br/>ID: ' . $item['id'] . '<br/>直播间名称: ' . $item['title']);
			$favoritetotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_live_favorite') . ' where roomid = ' . $id . ' ');

			if (0 < $favoritetotal) {
				pdo_delete('ewei_shop_live_favorite', array('roomid' => $item['id']));
			}

			$viewtotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_live_view') . ' where roomid = ' . $id . ' ');

			if (0 < $viewtotal) {
				pdo_delete('ewei_shop_live_view', array('roomid' => $item['id']));
			}

			if (function_exists('redis') && !is_error(redis())) {
				$this->model->deleteRedisTable($item['id']);
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$kwd = trim($_GPC['keyword']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$params = array();
		$params[':uniacid'] = $uniacid;
		$condition = ' and deleted=0 and uniacid=:uniacid and status = 1 and merchid = 0 and status = 1 and type != 4 and ispresell = 0 and bargain = 0 ';

		if (!empty($kwd)) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $kwd . '%';
		}

		$goods = pdo_fetchall('SELECT id,title,thumb,marketprice,total,hasoption
            FROM ' . tablename('ewei_shop_goods') . ('
            WHERE 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_goods') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		$goods = set_medias($goods, array('thumb'));
		include $this->template();
	}

	public function console()
	{
		global $_W;
		global $_GPC;
		if (!function_exists('redis') || is_error(redis())) {
			$this->message('请联系管理员开启 redis 支持，才能使用直播应用', '', 'error');
			exit();
		}

		$id = intval($_GPC['id']);

		if (empty($id)) {
			$this->message('直播间参数错误');
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_live') . ' WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($item)) {
			$this->message('直播间不存在');
		}

		if (empty($item['status'])) {
			$this->message('请先启用直播间');
		}

		if ($item['livetype'] == 2) {
			$item['url'] = $item['video'];
		}

		if ($item['livetype'] < 2) {
			$getVideo = $this->model->getLiveInfo($item['url'], $item['liveidentity']);
			if (!is_error($getVideo) && !empty($getVideo['hls_url'])) {
				$url = urlencode($getVideo['hls_url']);
			}
		}
		else {
			$url = urlencode($item['url']);
		}

		$this_url = $_W['siteroot'];
		$url = urldecode($url);
		$emojiList = $this->model->getEmoji();
		$uid = 'console' . '_' . $_W['uid'] . '_' . $_W['role'] . '_' . $_W['uniacid'];
		$nickname = '管理员' . $_W['username'];
		$wsConfig = json_encode(array('address' => $this->model->getWsAddress(), 'scene' => 'live', 'roomid' => $id, 'uniacid' => $_W['uniacid'], 'uid' => $uid, 'nickname' => $nickname, 'attachurl' => $_W['attachurl']));
		$records = $this->model->handleRecords($id, true);
		$push_records = array();
		$table_pushrecords_order = $this->model->getRedisTable('push_records_order', $id);
		$pushrecords_order = redis()->lRange($table_pushrecords_order, 0, -1);
		$table_pushrecords = $this->model->getRedisTable('push_records', $id);
		$pushrecords = redis()->hGetAll($table_pushrecords);

		if ($pushrecords === false) {
			redis()->del($table_pushrecords);
		}

		if (!empty($pushrecords_order)) {
			foreach ($pushrecords_order as $index => $redpackid) {
				$pushrecord = redis()->hGet($table_pushrecords, $redpackid);

				if (!empty($pushrecord)) {
					$push_records[] = json_decode($pushrecord, true);
				}
			}
		}

		$push_count = count($push_records);

		if (!empty($push_records)) {
			$push_records = array_reverse($push_records);
		}

		include $this->template();
	}

	public function console_record()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$pushid = intval($_GPC['pushid']);
		$type = intval($_GPC['type']);
		if (!empty($id) && !empty($pushid)) {
			$type = $type == 2 ? 'coupon' : 'redpack';
			$table_redpack = $this->model->getRedisTable($type . '_list_' . $pushid, $id);
			$list = redis()->hGetAll($table_redpack);
		}

		if (!empty($list)) {
			foreach ($list as &$item) {
				$item = json_decode($item, true);

				if ($type == 'coupon') {
					if ($item['couponid'] <= 0) {
						unset($item);
					}
				}
				else {
					if ($item['money'] <= 0) {
						unset($item);
					}
				}
			}

			unset($item);
		}

		include $this->template();
	}

	public function property()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = trim($_GPC['type']);
		$value = intval($_GPC['value']);

		if (in_array($type, array('status', 'displayorder', 'hot', 'recommend'))) {
			$statusstr = '';

			if ($type == 'status') {
				$typestr = '状态';
				$statusstr = $value == 1 ? '显示' : '关闭';
			}
			else if ($type == 'displayorder') {
				$typestr = '排序';
				$statusstr = '序号 ' . $value;
			}
			else if ($type == 'hot') {
				$typestr = '是否热门';
				$statusstr = $value == 1 ? '是' : '否';
			}
			else {
				if ($type == 'recommend') {
					$typestr = '是否推荐';
					$statusstr = $value == 1 ? '是' : '否';
				}
			}

			if (empty($id) && is_array($_GPC['ids'])) {
				$ids = $_GPC['ids'];

				foreach ($_GPC['ids'] as $item) {
					$property_update = pdo_update('ewei_shop_live', array($type => $value), array('id' => $item, 'uniacid' => $_W['uniacid']));
					plog('live.room.edit', '修改直播' . $typestr . '状态   ID: ' . $item . ' ' . $statusstr . ' ');
				}
			}
			else {
				$property_update = pdo_update('ewei_shop_live', array($type => $value), array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('live.room.edit', '修改直播' . $typestr . '状态   ID: ' . $id . ' ' . $statusstr . ' ');
			}
		}

		show_json(1);
	}

	public function console_video()
	{
		global $_GPC;
		$url = trim($_GPC['url']);

		if (!empty($url)) {
			$url = urldecode($url);
		}

		include $this->template();
	}
}

?>
