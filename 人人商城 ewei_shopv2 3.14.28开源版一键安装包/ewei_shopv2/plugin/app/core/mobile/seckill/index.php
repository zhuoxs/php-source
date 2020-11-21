<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	public function get_list()
	{
		global $_W;
		global $_GPC;
		$redis = redis();
		if (!function_exists('redis') || is_error($redis)) {
			return app_error(1, '请联系管理员开启 redis 支持，才能使用秒杀应用');
		}

		$taskid = intval($_GPC['taskid']);

		if (empty($taskid)) {
			$taskid = $this->getTodaySeckill();

			if (empty($taskid)) {
				return app_error(1, '今日没有秒杀，请明天再来吧~');
			}
		}

		$task = $this->getTaskInfo($taskid);

		if (empty($task)) {
			return app_error(1, '未找到秒杀任务');
		}

		$rooms = $this->getRooms($taskid);

		if (empty($rooms)) {
			return app_error(1, '未找到秒杀会场');
		}

		$room = false;
		$roomindex = 0;
		$roomid = intval($_GPC['roomid']);

		if (empty($roomid)) {
			foreach ($rooms as $row) {
				$room = $row;
				break;
			}
		}
		else {
			foreach ($rooms as $index => $row) {
				if ($row['id'] == $roomid) {
					$room = $row;
					$roomindex = $index;
					break;
				}
			}
		}

		if (empty($room)) {
			return app_error(1, '未找到秒杀会场');
		}

		$roomid = $room['id'];
		$timeid = 0;
		$currenttime = time();
		$timeindex = -1;
		$alltimes = $this->getTaskTimes($taskid);
		$times = array();
		$validtimes = array();

		foreach ($alltimes as $key => $time) {
			$oldshow = true;
			$timegoods = $this->getSeckillGoods($taskid, $time['time'], 'all');
			$hasGoods = false;

			foreach ($timegoods as $tg) {
				if ($tg['roomid'] == $roomid) {
					$hasGoods = true;
					break;
				}
			}

			if (isset($alltimes[$key + 1])) {
				$end = $alltimes[$key + 1]['time'] - 1;
				$endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
			}
			else if (empty($task['overtimes'])) {
				$endtime = strtotime(date('Y-m-d 23:59:59'));
			}
			else {
				$endtime = strtotime(date('Y-m-d ' . $task['overtimes'] . ':00:00'));
			}

			if ($endtime < $currenttime) {
				if (!$room['oldshow']) {
					$oldshow = false;
				}
			}

			if ($hasGoods && $oldshow) {
				$validtimes[] = $time;
			}
		}

		foreach ($validtimes as $key => $time) {
			$timestr = $time['time'];

			if (strlen($timestr) == 1) {
				$timestr = '0' . $timestr;
			}

			$starttime = strtotime(date('Y-m-d ' . $timestr . ':00:00'));

			if (isset($validtimes[$key + 1])) {
				$end = $validtimes[$key + 1]['time'] - 1;
				$endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
			}
			else if (empty($task['overtimes'])) {
				$endtime = strtotime(date('Y-m-d 23:59:59'));
			}
			else {
				$endtime = strtotime(date('Y-m-d ' . $task['overtimes'] . ':00:00'));
			}

			$time['endtime'] = $endtime;
			$time['starttime'] = $starttime;
			if ($starttime <= $currenttime && $currenttime <= $endtime) {
				$time['status'] = 0;
				$timeid = $time['id'];

				if ($timeindex == -1) {
					$timeindex = $key;
				}
			}
			else if ($currenttime < $starttime) {
				$time['status'] = 1;

				if (empty($timeid)) {
					$timeid = $time['id'];
				}
			}
			else {
				if ($endtime < $currenttime) {
					$time['status'] = -1;

					if (empty($timeid)) {
						$timeid = $time['id'];
					}
				}
			}

			$time['time'] = $timestr;
			$times[] = $time;
		}

		$share_title = $room['share_title'];

		if (empty($share_title)) {
			$share_title = $room['page_title'];
		}

		if (empty($share_title)) {
			$share_title = $room['title'];
		}

		if (empty($share_title)) {
			$share_title = $task['share_title'];
		}

		if (empty($share_title)) {
			$share_title = $task['page_title'];
		}

		if (empty($share_title)) {
			$share_title = $task['title'];
		}

		$share_desc = $room['share_desc'];

		if (empty($share_desc)) {
			$share_desc = $task['share_desc'];
		}

		if ($timeindex == -1) {
			$timeindex = 0;
		}

		$count = count($times);

		if ($count - 1 <= $timeindex) {
			$timeindex = $count - 1;
		}

		$page_title = empty($task['page_title']) ? $task['title'] : $task['page_title'];

		if (!empty($room['title'])) {
			$page_title .= ' - ' . $room['title'];
		}

		$mid = m('member')->getMid();
		$_W['shopshare'] = array('title' => $share_title, 'link' => mobileUrl('seckill', array('roomid' => $roomid, 'mid' => $mid), true), 'imgUrl' => tomedia($task['share_icon']), 'desc' => $share_desc);
		$diypages = array();
		$seckill_style = 'style2';
		$seckill_color = 'orange';
		$seckill_adv = array();
		$page = p('app')->getPage('seckill', true);

		if (!empty($page)) {
			$pageitems = $page['data']['items'];
			$seckill_list = array();

			foreach ($pageitems as $itemid => $pageitem) {
				if ($pageitem['id'] == 'seckill_list') {
					$seckill_list = $pageitem;
					break;
				}
			}

			$diypages = array('seckill_list' => $seckill_list, 'diylayer' => $page['data']['page']['diylayer'], 'diyadv' => $page['data']['page']['diyadv'], 'items' => $pageitems, 'background_color' => $page['data']['page']['background'], 'page_title' => $page['data']['page']['title'], 'titlebarcolor' => $page['data']['page']['titlebarcolor']);
			$seckill_style = empty($page['data']['page']['seckill']['style']) ? 'style2' : $page['data']['page']['seckill']['style'];
			$seckill_color = empty($page['data']['page']['seckill']['color']) ? 'orange' : $page['data']['page']['seckill']['color'];
		}

		return app_json(array('diypages' => $diypages, 'timeindex' => $timeindex, 'times' => $times, 'rooms' => $rooms, 'roomid' => $roomid, 'taskid' => $taskid, 'timeid' => $timeid, 'seckill_style' => $seckill_style, 'seckill_color' => $seckill_color));
	}

	public function get_goods()
	{
		global $_W;
		global $_GPC;
		$taskid = intval($_GPC['taskid']);
		$roomid = intval($_GPC['roomid']);
		$timeid = intval($_GPC['timeid']);
		$task = $this->getTaskInfo($taskid);

		if (empty($task)) {
			return app_error(1, '专题未找到');
		}

		$room = $this->getRoomInfo($taskid, $roomid);

		if (empty($room)) {
			return app_error(1, '会场未找到');
		}

		$time = false;
		$nexttime = false;
		$times = $this->getTaskTimes($taskid);

		foreach ($times as $key => $ctime) {
			if ($ctime['id'] == $timeid) {
				$time = $ctime;

				if (isset($times[$key + 1])) {
					$nexttime = $times[$key + 1];
				}

				break;
			}
		}

		if (empty($time)) {
			return app_error(1, '当前时间段未找到');
		}

		$currenttime = time();
		$starttime = strtotime(date('Y-m-d ' . $time['time'] . ':00:00'));

		if (!empty($nexttime)) {
			$end = $nexttime['time'] - 1;
			$endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
		}
		else if (empty($task['overtimes'])) {
			$endtime = strtotime(date('Y-m-d 23:59:59'));
		}
		else {
			$endtime = strtotime(date('Y-m-d ' . $task['overtimes'] . ':00:00'));
		}

		$time['endtime'] = $endtime;
		$time['starttime'] = $starttime;
		$time['status'] = false;
		if ($starttime <= $currenttime && $currenttime <= $endtime) {
			$time['status'] = 0;
		}
		else if ($currenttime < $starttime) {
			$time['status'] = 1;
		}
		else {
			if ($endtime < $currenttime) {
				$time['status'] = -1;
			}
		}

		$sql = 'select tg.id,tg.goodsid, tg.price, g.title,g.thumb,g.thumb_url,g.hasoption,g.marketprice,g.productprice,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('ewei_shop_seckill_task_goods') . ' tg  
                  left join ' . tablename('ewei_shop_goods') . ' g on tg.goodsid = g.id 
                  where tg.taskid=:taskid and tg.roomid=:roomid and tg.timeid=:timeid and tg.uniacid=:uniacid  group by tg.goodsid order by tg.displayorder asc ';
		$goods = pdo_fetchall($sql, array(':taskid' => $taskid, ':roomid' => $roomid, ':uniacid' => $_W['uniacid'], ':timeid' => $time['id']));

		foreach ($goods as &$g) {
			if (p('offic')) {
				$g['thumb_url'] = array_values(unserialize($g['thumb_url']));
				$g['thumb'] = tomedia($g['thumb_url'][0]);
			}

			$seckillinfo = $this->getSeckill($g['goodsid'], 0, false);

			if ($g['hasoption']) {
				$total = 0;
				$count = 0;
				$options = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price,g.title,g.marketprice,g.productprice,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('ewei_shop_seckill_task_goods') . '  tg  left join ' . tablename('ewei_shop_goods') . ' g on tg.goodsid = g.id  where tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $time['id'], ':taskid' => $taskid, ':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));
				$price = $options[0]['price'];
				$productprice = $options[0]['productprice'];

				foreach ($options as $option) {
					$total += $option['total'];

					if ($option['price'] < $price) {
						$price = $option['price'];
					}

					if ($productprice < $option['productprice']) {
						$productprice = $option['productprice'];
					}
				}

				$g['price'] = $price;
				$g['productprice'] = $productprice;
				$g['total'] = $total;
				$g['count'] = $seckillinfo['count'];
				$g['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
			}
			else {
				$g['count'] = $seckillinfo['count'];
				$g['percent'] = 100 < $seckillinfo['percent'] ? 100 : $seckillinfo['percent'];
			}

			$g['thumb'] = tomedia($g['thumb']);
			$g['productprice'] = price_format($g['productprice']);
			$g['price'] = price_format($g['price']);
			$g['timestatus'] = $time['status'];
		}

		unset($g);
		load()->func('logging');
		logging_run($goods);
		$plugin_diypage = p('diypage');

		if ($plugin_diypage) {
			$diypage = $plugin_diypage->seckillPage($room['diypage']);
		}

		return app_json(array('diypage' => $diypage, 'time' => $time, 'goods' => $goods));
	}

	public function get_prefix()
	{
		global $_W;

		if (empty($_W['account']['key'])) {
			$_W['account']['key'] = pdo_fetchcolumn('SELECT `key` FROM ' . tablename('account_wechats') . ' WHERE uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		}

		return 'ewei_shopv2_' . $_W['setting']['site']['key'] . '_' . $_W['uniacid'] . '_' . $_W['account']['key'] . '_seckill_';
	}

	public function getTodaySeckill()
	{
		if (is_error(redis())) {
			return false;
		}

		$redis_prefix = $this->get_prefix();
		global $_W;
		$year = date('Y');
		$month = date('m');
		return redis()->hGet($redis_prefix . 'calendar_' . $year . '_' . $month, date('Y-m-d'));
	}

	public function getTaskInfo($taskid)
	{
		global $_W;
		global $_GPC;

		if (is_error(redis())) {
			return false;
		}

		$redis = redis();
		$redis_prefix = $this->get_prefix();
		$info = $redis->hGetAll($redis_prefix . 'info_' . $taskid);

		if (empty($info)) {
			return false;
		}

		return $info;
	}

	public function getRooms($taskid)
	{
		global $_W;
		global $_GPC;
		$redis = redis();

		if (is_error(redis())) {
			return false;
		}

		$redis_prefix = $this->get_prefix();
		$allrooms = array();
		$rooms = $redis->lGetRange($redis_prefix . 'rooms_' . $taskid, 0, -1);

		foreach ($rooms as $room) {
			$room = json_decode($room, true);

			if (is_array($room)) {
				$allrooms[] = $room;
			}
		}

		return $allrooms;
	}

	public function getTaskTimes($taskid)
	{
		global $_W;
		global $_GPC;
		$redis = redis();

		if (is_error(redis())) {
			return false;
		}

		$redis_prefix = $this->get_prefix();
		$times = $redis->lGetRange($redis_prefix . 'times_' . $taskid, 0, -1);
		$alltimes = array();

		if (empty($times)) {
			return false;
		}

		foreach ($times as $time) {
			$time = json_decode($time, true);

			if (is_array($time)) {
				$alltimes[] = $time;
			}
		}

		return $alltimes;
	}

	public function getSeckillGoods($taskid, $time, $goodsid)
	{
		global $_W;
		global $_GPC;

		if (is_error(redis())) {
			return false;
		}

		$redis_prefix = $this->get_prefix();
		$timegoods = array();
		$goods = redis()->hGetAll($redis_prefix . 'goods_' . $taskid);

		if (empty($goods)) {
			return false;
		}

		$goods = @json_decode($goods['time-' . $time], true);

		if (!is_array($goods)) {
			return false;
		}

		foreach ($goods as $g) {
			if (!is_array($g)) {
				return false;
			}

			if ($g['goodsid'] == $goodsid || $goodsid == 'all') {
				$timegoods[] = $g;
			}
		}

		file_put_contents(__DIR__ . '/a.json', json_encode($timegoods) . PHP_EOL, 8);
		return $timegoods;
	}

	public function getRoomInfo($taskid, $roomid)
	{
		global $_W;

		if (is_error(redis())) {
			return false;
		}

		$rooms = $this->getRooms($taskid);

		foreach ($rooms as $room) {
			if ($room['id'] == $roomid) {
				return $room;
			}
		}

		return false;
	}

	public function getSeckill($goodsid, $optionid = 0, $realprice = true, $openid = '')
	{
		global $_W;
		$redis = redis();

		if (is_error($redis)) {
			return false;
		}

		static $deletedSeckill;

		if (is_null($deletedSeckill)) {
			$this->deleteSeckill();
			$deletedSeckill = true;
		}

		$id = $this->getTodaySeckill();

		if (empty($id)) {
			return false;
		}

		$times = $this->getTaskTimes($id);
		$options = array();
		$currenttime = time();
		$timegoods = array();
		$sktime = 0;
		$timeid = 0;
		$roomid = 0;
		$taskid = 0;
		$goods_starttime = 0;
		$goods_endtime = 0;

		foreach ($times as $key => $time) {
			$starttime = strtotime(date('Y-m-d ' . $time['time'] . ':00:00'));

			if (isset($times[$key + 1])) {
				$end = $times[$key + 1]['time'] - 1;
				$endtime = strtotime(date('Y-m-d ' . $end . ':59:59'));
			}
			else {
				$endtime = strtotime(date('Y-m-d 23:59:59'));
			}

			$time['endtime'] = $endtime;
			$time['starttime'] = $starttime;
			if ($starttime <= $currenttime && $currenttime <= $endtime) {
				$timeid = $time['id'];
				$taskid = $time['taskid'];
				$goods_starttime = $starttime;
				$goods_endtime = $endtime;
				$sktime = $time['time'];
				$z = $this->getSeckillGoods($id, $time['time'], $goodsid);

				if (!empty($z)) {
					$timegoods = $z;
				}
			}
			else if ($currenttime < $starttime) {
				if (empty($timegoods)) {
					$timeid = $time['id'];
					$goods_starttime = $starttime;
					$goods_endtime = $endtime;
					$taskid = $time['taskid'];
					$sktime = $time['time'];
					$z = $this->getSeckillGoods($id, $time['time'], $goodsid);

					if (!empty($z)) {
						$timegoods = $z;
					}
				}
			}
			else {
				if (empty($timegoods)) {
					$timeid = $time['id'];
					$goods_starttime = $starttime;
					$goods_endtime = $endtime;
					$taskid = $time['taskid'];
					$sktime = $time['time'];
					$z = $this->getSeckillGoods($id, $time['time'], $goodsid);

					if (!empty($z)) {
						$timegoods = $z;
					}
				}
			}
		}

		$total = 0;
		$count = 0;
		$selfcount = 0;
		$selftotalcount = 0;
		$maxbuy = 0;
		$notpay = 0;
		$selfnotpay = 0;
		$selftotalnotpay = 0;
		$totalmaxbuy = 0;

		if (!empty($timegoods)) {
			$opswi = false;

			if (!empty($optionid)) {
				foreach ($timegoods as $tk => $tv) {
					if ($tv['optionid'] == $optionid) {
						$opswi = true;
					}
				}

				if (!$opswi) {
					return false;
				}
			}

			$roomid = $timegoods[0]['roomid'];
			$total = $timegoods[0]['total'];
			$price = $timegoods[0]['price'];
			$totalmaxbuy = $timegoods[0]['totalmaxbuy'];
			if (count($timegoods) <= 1 && empty($timegoods['optionid'])) {
				$counts = $this->getSeckillCount($id, $timegoods[0]['timeid'], $timegoods[0]['goodsid'], 0, $openid);
				$count = $counts['count'];
				$selfcount = $counts['selfcount'];
				$selftotalcount = $counts['selftotalcount'];
				$notpay = $counts['notpay'];
				$selfnotpay = $counts['selfnotpay'];
				$selftotalnotpay = $counts['selftotalnotpay'];
				$maxbuy = $timegoods[0]['maxbuy'];
				$percent = ceil($count / (empty($total) ? 1 : $total) * 100);
				$options[] = $timegoods[0];
			}
			else {
				$total = 0;
				$price = $timegoods[0]['price'];
				$option_goods = NULL;

				if (!empty($optionid)) {
					foreach ($timegoods as $g) {
						if ($g['optionid'] == $optionid) {
							$total = $g['total'];
							$price = $g['price'];
							$counts = $this->getSeckillCount($id, $g['timeid'], $g['goodsid'], $optionid, $openid);
							$count = $counts['count'];
							$selfcount = $counts['selfcount'];
							$selftotalcount = $counts['selftotalcount'];
							$selfnotpay = $counts['selfnotpay'];
							$selftotalnotpay = $counts['selftotalnotpay'];
							$notpay = $counts['notpay'];
							$maxbuy = $g['maxbuy'];
							$percent = ceil($count / (empty($g['total']) ? 1 : $g['total']) * 100);
							break;
						}
					}
				}
				else {
					foreach ($timegoods as $g) {
						$total += $g['total'];

						if ($g['price'] <= $price) {
							$price = $g['price'];
						}

						$options[] = $g;
					}

					$counts = $this->getSeckillCount($id, $g['timeid'], $g['goodsid'], 0, $openid);
					$count = $counts['count'];
					$selfcount = $counts['selfcount'];
					$selfnotpay = $counts['selfnotpay'];
					$notpay = $counts['notpay'];
					$selftotalcount = $counts['selftotalcount'];
					$selftotalnotpay = $counts['selftotalnotpay'];
					$percent = ceil($count / (empty($total) ? 1 : $total) * 100);
				}
			}

			if (!$realprice) {
				$price = price_format($price);
			}

			$tag = '';
			$taskinfo = $this->getTaskInfo($taskid);

			if ($taskinfo['enabled'] == 0) {
				return false;
			}

			$roominfo = $this->getRoomInfo($taskid, $roomid);

			if ($roominfo['enabled'] == 0) {
				return false;
			}

			if (!empty($taskinfo['tag'])) {
				$tag = $taskinfo['tag'];
			}

			if (!empty($roominfo['tag'])) {
				$tag = $roominfo['tag'];
			}

			$status = false;
			if ($goods_starttime <= $currenttime && $currenttime <= $goods_endtime) {
				$status = 0;
			}
			else if ($currenttime < $goods_starttime) {
				$status = 1;
			}
			else {
				if ($goods_endtime < $currenttime) {
					$status = -1;
				}
			}

			return array('taskid' => $taskid, 'roomid' => $roomid, 'timeid' => $timeid, 'total' => $total, 'count' => $count, 'selfcount' => $selfcount, 'selftotalcount' => $selftotalcount, 'notpay' => $notpay, 'selfnotpay' => $selfnotpay, 'selftotalnotpay' => $selftotalnotpay, 'maxbuy' => $maxbuy, 'totalmaxbuy' => $totalmaxbuy, 'tag' => $tag, 'time' => $sktime, 'options' => $options, 'starttime' => $goods_starttime, 'endtime' => $goods_endtime, 'price' => $price, 'percent' => $percent, 'status' => $status);
		}

		return false;
	}

	/**
     * 删除未付款过期数据
     */
	public function deleteSeckill()
	{
		global $_W;

		if (is_error(redis())) {
			return false;
		}

		$currenttime = time();
		$redis = redis();
		$redis_prefix = $this->get_prefix();
		$keys = $redis->keys($redis_prefix . 'queue_*');
		$orders = array();

		foreach ($keys as $key) {
			$queue = $redis->lGetRange($key, 0, -1);
			$tags = explode('_', $key);
			$taskid = $tags[8];
			$task = $this->getTaskInfo($taskid);
			$closesec = $task['closesec'];

			if (!empty($queue)) {
				foreach ($queue as $value) {
					$data = @json_decode($value, true);

					if (!is_array($data)) {
						continue;
					}

					if ($data['status'] <= 0 && $closesec <= $currenttime - $data['createtime']) {
						$redis->lRemove($key, $value, 1);

						if (!in_array($data['orderid'], $orders)) {
							$orders[] = $data['orderid'];
						}
					}
				}
			}

			if ($redis->lLen($key) <= 0) {
				$redis->delete($key);
			}

			if (!empty($orders)) {
				$p = com('coupon');

				foreach ($orders as $orderid) {
					$o = pdo_fetch('select  id,openid,deductcredit2,ordersn,isparent,deductcredit,deductprice,status   from ' . tablename('ewei_shop_order') . ' where id=:id  limit 1', array(':id' => $orderid));
					if (!empty($o) && $o['status'] === '0') {
						if ($o['isparent'] == 0) {
							if ($p) {
								if (!empty($o['couponid'])) {
									$p->returnConsumeCoupon($o['id']);
								}
							}

							m('order')->setStocksAndCredits($o['id'], 2);
							m('order')->setDeductCredit2($o);

							if (0 < $o['deductprice']) {
								m('member')->setCredit($o['openid'], 'credit1', $o['deductcredit'], array('0', $_W['shopset']['shop']['name'] . ('秒杀自动关闭订单返还抵扣积分 积分: ' . $o['deductcredit'] . ' 抵扣金额: ' . $o['deductprice'] . ' 订单号: ' . $o['ordersn'])));
							}
						}

						pdo_query('update ' . tablename('ewei_shop_order') . ' set status=-1,canceltime=' . time() . ' where id=' . $o['id']);
					}
				}
			}
		}

		return true;
	}

	public function getSeckillCount($taskid, $timeid, $goodsid, $optionid = 0, $openid = '')
	{
		global $_W;
		global $_GPC;
		$optionid = (int) $optionid;

		if (is_error(redis())) {
			return false;
		}

		$redis = redis();
		$date = date('Y-m-d');
		$redis_prefix = $this->get_prefix();
		$keys = $redis->keys($redis_prefix . 'queue_' . $date . '_' . $taskid . '_' . $timeid . '_' . $goodsid . '_*');

		if (empty($keys)) {
			return array('count' => 0, 'notpay' => 0, 'selfcount' => 0, 'selfnotpay' => 0, 'selftotalcount' => 0, 'selftotalnotpay' => 0);
		}

		$count = 0;
		$notpay = 0;
		$selfcount = 0;
		$selftotalcount = 0;
		$selfnotpay = 0;
		$selftotalnotpay = 0;

		foreach ($keys as $key) {
			$arr = explode('_', $key);
			$key_optionid = (int) $arr[11];
			$queue = $redis->lGetRange($key, 0, -1);

			foreach ($queue as $data) {
				$data = @json_decode($data, true);

				if (!is_array($data)) {
					continue;
				}

				if (0 < $optionid && $key_optionid === $optionid) {
					++$count;
				}
				else {
					if ($optionid == 0) {
						++$count;
					}
				}

				if ($data['status'] <= 0) {
					++$notpay;
				}

				if (!empty($openid) && $data['openid'] == $openid) {
					if ($key_optionid == $optionid) {
						++$selfcount;
					}

					++$selftotalcount;
				}

				if ($data['status'] <= 0 && !empty($openid) && $data['openid'] == $openid) {
					if ($key_optionid === $optionid) {
						++$selfnotpay;
					}

					++$selftotalnotpay;
				}
			}
		}

		return array('count' => $count, 'notpay' => $notpay, 'selfcount' => $selfcount, 'selfnotpay' => $selfnotpay, 'selftotalcount' => $selftotalcount, 'selftotalnotpay' => $selftotalnotpay);
	}
}

?>
