<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$redis = redis();
		if (!function_exists('redis') || is_error($redis)) {
			$this->message('请联系管理员开启 redis 支持，才能使用秒杀应用', '', 'error');
			exit();
		}

		$advs = pdo_fetchall('select * from ' . tablename('ewei_shop_seckill_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder asc', array(':uniacid' => $_W['uniacid']));
		$advs = set_medias($advs, 'thumb');
		$taskid = intval($_GPC['taskid']);

		if (empty($taskid)) {
			$taskid = $this->model->getTodaySeckill();

			if (empty($taskid)) {
				$this->message('今日没有秒杀，请明天再来吧~');
				exit();
			}
		}

		$task = $this->model->getTaskInfo($taskid);

		if (empty($task)) {
			$this->message('未找到秒杀任务');
			exit();
		}

		$rooms = $this->model->getRooms($taskid);

		if (empty($rooms)) {
			$this->message('未找到秒杀会场');
			exit();
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
			$this->message('未找到秒杀会场');
			exit();
		}

		$roomid = $room['id'];
		$timeid = 0;
		$currenttime = time();
		$timeindex = -1;
		$alltimes = $this->model->getTaskTimes($taskid);
		$times = array();
		$validtimes = array();

		foreach ($alltimes as $key => $time) {
			$oldshow = true;
			$timegoods = $this->model->getSeckillGoods($taskid, $time['time'], 'all');
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
		$share_icon = empty($room['share_icon']) ? $task['share_icon'] : $room['share_icon'];

		if (empty($share_icon)) {
			$share_icon = $_W['shopset']['share']['icon'];
		}

		$_W['shopshare'] = array('title' => $share_title, 'link' => mobileUrl('seckill', array('roomid' => $roomid, 'mid' => $mid), true), 'imgUrl' => tomedia($share_icon), 'desc' => $share_desc);
		$plugin_diypage = p('diypage');

		if ($plugin_diypage) {
			$diypage = $plugin_diypage->seckillPage($room['diypage']);

			if ($diypage) {
				$startadv = $plugin_diypage->getStartAdv($diypage['diyadv']);
				include $this->template('diypage/seckill');
				exit();
			}
		}

		include $this->template();
	}

	public function get_goods()
	{
		global $_W;
		global $_GPC;
		$taskid = intval($_GPC['taskid']);
		$roomid = intval($_GPC['roomid']);
		$timeid = intval($_GPC['timeid']);
		$task = $this->model->getTaskInfo($taskid);

		if (empty($task)) {
			show_json(0, '专题未找到');
		}

		$room = $this->model->getRoomInfo($taskid, $roomid);

		if (empty($room)) {
			show_json(0, '会场未找到');
		}

		$time = false;
		$nexttime = false;
		$times = $this->model->getTaskTimes($taskid);

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
			show_json(0, '当前时间段未找到');
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

			$seckillinfo = $this->model->getSeckill($g['goodsid'], 0, false);

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
		}

		unset($g);
		load()->func('logging');
		logging_run($goods);
		$plugin_diypage = p('diypage');

		if ($plugin_diypage) {
			$diypage = $plugin_diypage->seckillPage($room['diypage']);
		}

		show_json(1, array('diypage' => $diypage, 'time' => $time, 'goods' => $goods));
	}
}

?>
