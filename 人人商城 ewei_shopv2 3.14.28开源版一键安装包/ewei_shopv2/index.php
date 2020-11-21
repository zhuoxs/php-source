<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


require EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	/**
     * 商品列表
     */
	public function get_list()
	{
		global $_GPC;
		global $_W;
		$pagesize = intval($_GPC['pagesize']);
		$condition = ' bg.account_id = :uniacid AND bg.status = 0 AND g.deleted = 0 AND g.status = 1';
		$params = array(':uniacid' => intval($_W['uniacid']));

		if (!(empty($_GPC['keywords']))) {
			$keywords = trim($_GPC['keywords']);
			$condition .= ' AND g.title LIKE \'%' . $keywords . '%\' ';
		}


		$sql = 'SELECT bg.* ,g.id as gid,g.title,g.subtitle,g.thumb,g.marketprice,g.productprice,g.minprice,g.maxprice,g.isdiscount,g.isdiscount_time,g.isdiscount_discounts,g.sales,g.salesreal,g.total,g.description,g.bargain,g.`type` as gtype,g.ispresell,g.`virtual`,g.hasoption,g.video FROM ' . tablename('ewei_shop_bargain_goods') . ' bg ' . ' LEFT JOIN ' . tablename('ewei_shop_goods') . ' g ON g.id = bg.goods_id ' . ' WHERE ' . $condition . ' ORDER BY bg.id DESC ';
		$list = pdo_fetchall($sql, $params);
		$list = set_medias($list, 'thumb');
		app_json(array('list' => $list, 'total' => $list['total'], 'pagesize' => $pagesize));
	}

	/**
     * 砍价商品详情
     */
	public function get_detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			app_error(AppError::$ParamsError);
		}


		$mid = (int) m('member')->getMid();
		$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id = :id AND status=\'0\'', array(':id' => $id));

		if (!(empty($res))) {
			$goods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id AND status = \'1\' AND deleted = \'0\'', array(':id' => $res['goods_id']));

			if (!(empty($goods))) {
				$thumbs = iunserializer($goods['thumb_url']);

				if (empty($thumbs)) {
					$thumbs = array($goods['thumb']);
				}


				if (!(empty($goods['thumb_first'])) && !(empty($goods['thumb']))) {
					$thumbs = array_merge(array($goods['thumb']), $thumbs);
				}


				$data['id'] = $res['id'];
				$data['goodsid'] = $goods['id'];
				$data['thumbs'] = set_medias($thumbs);
				$data['title'] = $goods['title'];
				$data['title2'] = $goods['subtitle'];
				$data['start_price'] = $goods['marketprice'];
				$data['sold'] = $goods['sales'];
				$data['stock'] = $goods['total'];
				$data['content'] = $goods['content'];
				$data['type'] = $res['type'];
				$data['custom'] = urldecode($res['custom']);
				$data['custom'] = json_decode($data['custom'], true);
				$data['mid'] = $mid;

				if ((strtotime($res['start_time']) < time()) && (time() < strtotime($res['end_time']))) {
					$data['isStart'] = 1;
				}
				 else {
					$data['isStart'] = 0;
				}

				$start_time = strtotime($res['start_time']) - time();
				$end_time = strtotime($res['end_time']);
				$data['start_time'] = strtotime($res['start_time']);
				$data['end_time'] = strtotime($res['end_time']);
				$time3 = $end_time - time();
				$data['status'] = '0';
				$data['swi'] = 0;

				if (0 < $start_time) {
					$data['status'] = '0';
					$data['swi'] = 1;
				}
				 else if ($time3 < 0) {
					$data['status'] = '1';
					$data['swi'] = 2;
				}
				 else if (($goods['total'] <= 0) && ($data['swi'] == 0)) {
					$data['swi'] = 3;
				}


				if (!(empty($res['initiate']))) {
					$act_id = pdo_get('ewei_shop_bargain_actor', array('goods_id' => $id, 'openid' => $_W['openid'], 'status' => 0), 'id');

					if (!(empty($act_id))) {
						$data['act_swi'] = $act_id['id'];
					}

				}


				if (substr($goods['marketprice'], -3, 3) == '.00') {
					$goods['marketprice'] = intval($goods['marketprice']);
				}


				if (substr($res['end_price'], -3, 3) == '.00') {
					$data['end_price'] = intval($res['end_price']);
				}


				$data['start_price'] = $goods['marketprice'];
				$data['act_times'] = $res['act_times'];

				if (($res['type'] == 1) && ($res['mode'] == 1)) {
					$data['m_swi '] = 1;
				}
				 else {
					$data['m_swi '] = 0;
				}

				$result = array('list' => $data);
			}

		}


		app_json($result);
	}

	/**
     *  获取砍价规则
     *
     */
	public function rule()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$myMid = (int) m('member')->getMid();
		$mid = (int) $_GPC['mid'];
		$rule = pdo_get('ewei_shop_bargain_goods', array('id' => $id, 'account_id' => $_W['uniacid']), array('rule'));

		if (empty($rule['rule'])) {
			$rule = pdo_get('ewei_shop_bargain_account', array('id' => $_W['uniacid']), array('rule'));
		}


		$result = array('rule' => $rule);
		app_json($result);
	}

	/**
     *  砍价详情
     */
	public function bargain()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$ajax = $_GPC['ajax'];
		$myMid = (int) m('member')->getMid();
		$mid = (int) $_GPC['mid'];
		$unequalMid = 0;
		$result = array();
		$result['unequalMid'] = $unequalMid;

		if ($id == NULL) {
			$id = 1;
		}


		$account_set = pdo_get('ewei_shop_bargain_account', array('id' => $_W['uniacid']), array('partin', 'rule', 'sharestyle'));
		$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE id = :id', array(':id' => $id));
		$res['bargain_price'] = str_replace('-', '', $res['bargain_price']);
		$res2 = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id = :id AND status=\'0\'', array(':id' => $res['goods_id']));
		$ewei_detail = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id AND status = \'1\' AND bargain > 0 AND deleted=0', array(':id' => $res2['goods_id']));
		if (!($ewei_detail['id']) || !($res['id']) || !($res2['id'])) {
			return;
		}


		$res2['title'] = $ewei_detail['title'];
		$res2['title2'] = $ewei_detail['subtitle'];
		$res2['start_price'] = $ewei_detail['marketprice'];

		if (substr($res2['start_price'], -3, 3) == '.00') {
			$res2['start_price'] = intval($res2['start_price']);
		}


		if (substr($res2['end_price'], -3, 3) == '.00') {
			$res2['end_price'] = intval($res2['end_price']);
		}


		$res2['sold'] = $ewei_detail['sales'];
		$res2['stock'] = $ewei_detail['total'];
		$res2['images'] = json_encode(array($ewei_detail['thumb']));
		$thumbs = array($ewei_detail['thumb']);
		$res2['thumb'] = tomedia($thumbs[0]);
		$res2['content'] = $ewei_detail['content'];
		if (!($res) || !($res2)) {
			include $this->template('bargain/lost');
			return;
		}


		if (substr($res['bargain_price'], -3, 3) == '.00') {
			$res['bargain_price'] = intval($res['bargain_price']);
		}


		if (substr($res['now_price'], -3, 3) == '.00') {
			$res['now_price'] = intval($res['now_price']);
		}


		if ($_W['openid'] === $res['openid']) {
			$swi = 111;
		}
		 else {
			$swi = 222;
		}

		$time2 = strtotime($res2['end_time']);
		$time3 = $time2 - time();
		$start_time = strtotime($res2['start_time']) - time();
		$res2['start_time'] = strtotime($res2['start_time']);
		$type = $res['type'];

		if (0 < $res2['time_limit']) {
			$res2['end_time'] = strtotime($res2['end_time']);
			$showtime = strtotime($res['created_time']) + ($res2['time_limit'] * 3600);
			$showtime = date('Y-m-d H:i:s', $showtime);
		}
		 else {
			$res2['end_time'] = strtotime($res2['end_time']);
		}

		$status = 3;
		$trade_swi = 0;

		if ($res2['mode'] == 0) {
			$trade_swi = 5;
		}


		if (($res2['type'] == 1) && ($res2['mode'] == 1) && ($res2['end_price'] < $res['now_price'])) {
			$trade_swi = 4;
		}


		if (0 < $start_time) {
			$status = '0';
		}
		 else if ($time3 < 0) {
			$status = '1';
			$trade_swi = 2;
		}


		$arrived = 0;

		if (!($res2['end_price'] < $res['now_price'])) {
			$arrived = 1;
		}


		$timeout = 0;

		if (((strtotime($res['created_time']) + ($res2['time_limit'] * 3600)) < time()) && ($res2['time_limit'] != '0')) {
			$timeout = 1;
		}


		$account_set['partin'] *= -1;
		$res3 = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_bargain_record') . ' WHERE actor_id = :actor_id ORDER BY id DESC LIMIT 0,10', array(':actor_id' => $id));

		if (!(empty($res3))) {
			foreach ($res3 as $res3k => $res3v ) {
				$res3[$res3k]['bargain_time'] = date('m/d  H:i', strtotime($res3v['bargain_time']));
			}
		}


		$res4 = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE goods_id = ' . $res2['id'] . ' AND account_id=:uniacid and bargain_price <= \'' . $account_set['partin'] . '\' ORDER BY bargain_price ASC LIMIT 10', array(':uniacid' => $_W['uniacid']));

		if (!(empty($res4))) {
			foreach ($res4 as $res4k => $res4v ) {
				$res4[$res4k]['update_time'] = date('m/d  H:i', strtotime($res4v['update_time']));
			}
		}


		$min_price = $res2['end_price'];
		$max_price = $res2['start_price'];

		if (pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE id = :id AND status = \'1\'', array(':id' => $id))) {
			if ($trade_swi != 2) {
				$trade_swi = 1;
			}

		}
		 else if ($res2['stock'] <= 0) {
			if (($trade_swi != 2) && ($trade_swi != 1)) {
				$trade_swi = 3;
			}

		}


		if (!(empty($res2['time_limit']))) {
			$time_limit = (($res2['time_limit'] * 3600) + strtotime($res['created_time'])) - time();
		}
		 else {
			$time_limit = $time3;
		}

		if ($ajax == 151) {
			$backInfo = $this->cut($id, $time_limit, $min_price, $res2['each_time'], $res2['total_time'], $max_price, $res2['probability']);

			if ($backInfo['error'] == 1) {
				app_error(1, $backInfo['message']);
			}


			if ($backInfo['error'] == 0) {
				app_json(array('cutPrice' => $backInfo['cutPrice']));
			}

		}
		 else {
			$res2['user_set'] = urldecode($res2['user_set']);
			$share_res = json_decode($res2['user_set'], true);

			if ($type == 1) {
				if (!(empty($share_res['bargain_title']))) {
				}
				 else {
					$share['title'] = $res2['title'];
				}

				if (!(empty($share_res['bargain_content_f']))) {
					$share['content'] = $share_res['goods_content'];
				}
				 else {
					$share['content'] = $res2['title2'];
				}

				if (!(empty($share_res['bargain_logo']))) {
					$share['logo'] = tomedia($share_res['bargain_logo']);
				}
				 else {
					$tt = json_decode($res2['images']);
					$share['logo'] = tomedia($tt[0]);
				}
			}
			 else if ($type == 0) {
				if (!(empty($share_res['bargain_title']))) {
					$weikan = $res2['start_price'] + $res['bargain_price'];
					$share_res['bargain_title'] = str_replace('[已砍]', $res['bargain_price'], $share_res['bargain_title']);
					$share_res['bargain_title'] = str_replace('[未砍]', $weikan, $share_res['bargain_title']);
					$share_res['bargain_title'] = str_replace('[现价]', $res['now_price'], $share_res['bargain_title']);
					$share_res['bargain_title'] = str_replace('[原价]', $res2['start_price'], $share_res['bargain_title']);
					$share['title'] = str_replace('[底价]', $res2['end_price'], $share_res['bargain_title']);
				}
				 else {
					$share['title'] = $res2['title'];
				}

				if (!(empty($share_res['bargain_content']))) {
					$share['content'] = $share_res['bargain_content'];
				}
				 else {
					$share['content'] = $res2['title2'];
				}

				if (!(empty($share_res['bargain_logo']))) {
					$share['logo'] = tomedia($share_res['bargain_logo']);
				}
				 else {
					$tt = json_decode($res2['images']);
					$share['logo'] = tomedia($tt[0]);
				}
			}


			$account_set['partin'] *= -1;
			$myself_swi = 0;
			$myself_count = pdo_get('ewei_shop_bargain_record', array('openid' => $_W['openid'], 'actor_id' => $res['id']), 'id');

			if (empty($myself_count['id']) && (0 < $res2['myself'])) {
				$myself_swi = 1;
			}

		}

		$result['list'] = $res;
		$result['bargain'] = $res2;
		$result['bargain_set'] = $account_set;
		$result['bargain_record'] = $res3;
		$result['bargain_actor'] = $res4;
		$result['swi'] = $swi;
		$result['trade_swi'] = $trade_swi;
		$result['myself_swi'] = $myself_swi;
		$result['mid'] = $myMid;
		$result['arrived'] = $arrived;
		$result['timeout'] = $timeout;
		app_json($result);
	}

	/**
     *  参加砍价
     */
	public function join()
	{
		global $_W;
		global $_GPC;
		$mid = (int) m('member')->getMid();
		file_put_contents(__DIR__ . '/c.json', json_encode($mid));
		$user_info = m('member')->getMember($_W['openid']);

		if (empty($user_info)) {
			app_error(AppError::$AuthEnticationFail);
		}


		$bargain_id = (int) $_GPC['id'];
		$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id = :id', array(':id' => $bargain_id));

		if ($res['maximum'] <= $res['act_times']) {
			app_error(1, '活动次数已到达上限,不能发起砍价');
		}


		$goods_detail = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id AND status=\'1\'', array(':id' => $res['goods_id']));

		if ($goods_detail['total'] <= 0) {
			app_error(1, '库存不足,不能发起砍价');
		}
		 else if (strtotime($res['end_time']) < time()) {
			app_error(1, '活动时间已经结束');
		}
		 else if (time() < strtotime($res['start_time'])) {
			app_error(1, '活动时间尚未开始');
		}
		 else if ($goods_detail['status'] != 1) {
			app_error(1, '商品已下架');
		}


		$time = date('Y-m-d H:i:s', time());
		$data = array('goods_id' => $bargain_id, 'now_price' => $goods_detail['marketprice'], 'created_time' => $time, 'update_time' => $time, 'bargain_times' => 0, 'openid' => $user_info['openid'], 'nickname' => $user_info['nickname'], 'head_image' => $user_info['avatar'], 'bargain_price' => 0, 'status' => 0, 'account_id' => $_W['uniacid']);

		if (!(empty($user_info['openid']))) {
			$if = pdo_insert('ewei_shop_bargain_actor', $data);
			$result_id = pdo_insertid();
			pdo_query('UPDATE ' . tablename('ewei_shop_bargain_goods') . ' SET act_times=act_times+1 WHERE id= :id', array(':id' => $bargain_id));
		}
		 else {
			app_error(1, '拒绝访问');
		}

		if ($result_id) {
			app_json(array('id' => $result_id, 'mid' => $mid));
		}
		 else {
			app_error(1, '操作错误');
		}
	}

	/**
     *  砍价算法
     */
	public function cut($actor_id, $time3, $min_price, $each_time, $total_time, $max_price, $probability_json)
	{
		global $_GPC;
		global $_W;
		$sum = 0;
		$probability = json_decode($probability_json, true);
		$rand_num = rand(1, 100);
		$i = 0;

		while ($i < count($probability['rand'])) {
			$sum += $probability['rand'][$i];

			if ($rand_num <= $sum) {
				$loop = $i;
				break;
			}


			++$i;
		}

		$min = $probability['min'][$loop];
		$max = $probability['max'][$loop];
		$info = m('member')->getMember($_W['openid']);
		$min *= 100;
		$max *= 100;
		$record_res = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_bargain_record') . ' WHERE actor_id=:actor_id AND openid= :openid', array(':actor_id' => $actor_id, ':openid' => $_W['openid']));
		$all_record = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_bargain_record') . ' WHERE actor_id= :actor_id', array(':actor_id' => $actor_id));

		if (empty($actor_id)) {
			return array('error' => 1, 'message' => '砍价失败！');
		}


		if ($time3 <= 0) {
			return array('error' => 1, 'message' => '砍价已结束！');
		}


		if (($each_time <= count($record_res)) || ($total_time <= count($all_record))) {
			return array('error' => 1, 'message' => '砍价机会已用完！');
		}


		$cut_price = rand($min, $max) / 100;
		$cut_price = round($cut_price, 2);
		$now_price = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE id = :id', array(':id' => $actor_id));

		if ($now_price['status'] == 1) {
			return array('error' => 1, 'message' => '已经成交过了！');
		}


		$now_price['now_price'] = round($now_price['now_price'], 2);
		$min_price = round($min_price, 2);

		if ($now_price['now_price'] <= $min_price) {
			return array('error' => 1, 'message' => '砍到底价了,快去告诉TA可以按底价购买啦！');
		}


		$temp_price = 2000000;
		$lastbargain = 0;
		$temp_price = $now_price['now_price'] + $cut_price;

		if ($temp_price < $min_price) {
			$cut_price = $min_price - $now_price['now_price'];
			$cut_price = round($cut_price, 2);

			if (0 < $cut_price) {
				$cut_price = -1 * $cut_price;
			}


			$lastbargain = 1;
		}


		$cut_price = round($cut_price, 2);
		$time = date('Y-m-d H:i:s', time());
		$insert_data = array('actor_id' => $actor_id, 'bargain_price' => $cut_price, 'openid' => $_W['openid'], 'nickname' => $info['nickname'], 'head_image' => $info['avatar'], 'bargain_time' => $time);
		$res_ins = pdo_insert('ewei_shop_bargain_record', $insert_data);
		$res_act = pdo_query('UPDATE ' . tablename('ewei_shop_bargain_actor') . ' SET now_price = now_price + :now_price ,update_time = :update_time , bargain_price = bargain_price + :bargain_price WHERE id= :id', array(':now_price' => $cut_price, ':update_time' => $time, ':bargain_price' => $cut_price, ':id' => $actor_id));

		if ($cut_price <= 0) {
			$now_price['now_price'] += $cut_price;
			$cut_price = -1 * $cut_price;
			$this->sendBargainResult($now_price['openid'], $cut_price, $now_price['now_price'], $info['nickname'], '砍掉', '成功', $lastbargain);
			pdo_query('UPDATE ' . tablename('ewei_shop_bargain_actor') . ' SET bargain_times = bargain_times + 1 WHERE id = :id', array(':id' => $actor_id));
			return array('error' => 0, 'cutPrice' => $cut_price);
		}


		if (0 < $cut_price) {
			$now_price['now_price'] += $cut_price;
			$this->sendBargainResult($now_price['openid'], $cut_price, $now_price['now_price'], $info['nickname'], '增加', '失败');
			pdo_query('UPDATE ' . tablename('ewei_shop_bargain_actor') . ' SET bargain_times = bargain_times + 1 WHERE id = :id', array(':id' => $actor_id));
			return array('error' => 0, 'cutPrice' => $cut_price);
		}

	}

	/**
     *  砍价中
     */
	public function act()
	{
		global $_W;
		global $_GPC;
		$myMid = (int) m('member')->getMid();
		$mid = (int) $_GPC['mid'];
		$mid = m('member')->getMid();
		$act = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE openid= :openid AND account_id = :account_id AND status = \'0\' ORDER BY id DESC', array(':openid' => $_W['openid'], ':account_id' => $_W['uniacid']));
		$i = 0;

		while ($i < count($act)) {
			$goods[$i] = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id=:id AND status = \'0\'', array(':id' => $act[$i]['goods_id']));
			$ewei_detail = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id AND status = \'1\' AND deleted=\'0\'', array(':id' => $goods[$i][0]['goods_id']));

			if (empty($ewei_detail)) {
				unset($goods[$i]);
				continue;
			}


			$goods[$i]['title'] = $ewei_detail['title'];
			$goods[$i][0]['title'] = $ewei_detail['title'];
			$goods[$i][0]['title2'] = $ewei_detail['subtitle'];
			$goods[$i][0]['start_price'] = $ewei_detail['marketprice'];
			$goods[$i][0]['sold'] = $ewei_detail['sales'];
			$goods[$i][0]['stock'] = $ewei_detail['total'];
			$goods[$i][0]['images'] = json_encode(array($ewei_detail['thumb']));
			$thumbs = array($ewei_detail['thumb']);
			$goods[$i][0]['thumb'] = tomedia($thumbs[0]);
			$goods[$i][0]['content'] = $ewei_detail['content'];
			$goods[$i][0]['actor_id'] = $act[$i]['id'];
			$goods[$i][0]['now_price'] = $act[$i]['now_price'];

			if (substr($goods[$i][0]['end_price'], -3, 3) == '.00') {
				$goods[$i][0]['end_price'] = intval($goods[$i][0]['end_price']);
			}


			if (substr($goods[$i][0]['start_price'], -3, 3) == '.00') {
				$goods[$i][0]['start_price'] = intval($goods[$i][0]['start_price']);
			}


			if (substr($goods[$i][0]['now_price'], -3, 3) == '.00') {
				$goods[$i][0]['now_price'] = intval($goods[$i][0]['now_price']);
			}


			$goods[$i][0]['label_swi'] = 0;

			if (((strtotime($act[$i]['created_time']) + ($goods[$i][0]['time_limit'] * 3600)) < time()) && ($goods[$i][0]['time_limit'] != '0')) {
				$goods[$i][0]['label_swi'] = 1;
			}


			if ($goods[$i][0]['now_price'] == $goods[$i][0]['end_price']) {
				$goods[$i][0]['label_swi'] = 3;
			}


			if (strtotime($goods[$i][0]['end_time']) < time()) {
				$goods[$i][0]['label_swi'] = 2;
			}


			++$i;
		}

		$result = array('goods' => $goods, 'mid' => $mid);
		app_json($result);
	}

	/**
     *  已购买
     */
	public function purchase()
	{
		global $_W;
		global $_GPC;
		$myMid = (int) m('member')->getMid();
		$mid = (int) $_GPC['mid'];
		$mid = m('member')->getMid();
		$act = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE openid= :openid AND account_id = :account_id AND status = \'1\' ORDER BY id DESC', array(':openid' => $_W['openid'], ':account_id' => $_W['uniacid']));
		$i = 0;

		while ($i < count($act)) {
			$goods[$i] = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id=:id', array(':id' => $act[$i]['goods_id']));
			$ewei_detail = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id AND status = \'1\'', array(':id' => $goods[$i][0]['goods_id']));

			if (empty($ewei_detail)) {
				unset($goods[$i]);
				continue;
			}


			$goods[$i][0]['title'] = $ewei_detail['title'];
			$goods[$i][0]['title2'] = $ewei_detail['subtitle'];
			$goods[$i][0]['start_price'] = $ewei_detail['marketprice'];
			$goods[$i][0]['sold'] = $ewei_detail['sales'];
			$goods[$i][0]['stock'] = $ewei_detail['total'];
			$goods[$i][0]['images'] = json_encode(array($ewei_detail['thumb']));
			$thumbs = array($ewei_detail['thumb']);
			$goods[$i][0]['thumb'] = tomedia($thumbs[0]);
			$goods[$i][0]['content'] = $ewei_detail['content'];
			$goods[$i][0]['actor_id'] = $act[$i]['id'];
			$goods[$i][0]['now_price'] = $act[$i]['now_price'];
			$goods[$i][0]['order'] = $act[$i]['order'];
			++$i;
		}

		$result = array('goods' => $goods, 'mid' => $mid);
		app_json($result);
	}
}


?>