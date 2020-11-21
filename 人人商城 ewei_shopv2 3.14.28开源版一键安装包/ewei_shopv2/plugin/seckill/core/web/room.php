<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'seckill/core/seckill_page_web.php';
class Room_EweiShopV2Page extends SeckillWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and r.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		$taskid = intval($_GPC['taskid']);

		if (!empty($taskid)) {
			$task = pdo_fetch('select * from ' . tablename('ewei_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $taskid));

			if (!empty($task)) {
				$condition .= '  and r.taskid=' . $taskid;
			}
		}

		if ($_GPC['enabled'] != '') {
			$condition .= ' and r.enabled=' . intval($_GPC['enabled']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( r.title  like :keyword or t.title like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT r.*, t.title as task_title FROM ' . tablename('ewei_shop_seckill_task_room') . ' r left join ' . tablename('ewei_shop_seckill_task') . (' t  on r.taskid = t.id WHERE 1 ' . $condition . '  ORDER BY r.displayorder DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($list as &$row) {
			$times = pdo_fetchall('select id, time from ' . tablename('ewei_shop_seckill_task_time') . ' where taskid=:taskid and uniacid=:uniacid ', array(':taskid' => $row['taskid'], ':uniacid' => $_W['uniacid']));

			foreach ($times as &$time) {
				$time['goodscount'] = pdo_fetchcolumn('select count(DISTINCT  goodsid)  from ' . tablename('ewei_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and  timeid=:timeid and uniacid=:uniacid ', array(':taskid' => $row['taskid'], ':roomid' => $row['id'], ':uniacid' => $_W['uniacid'], ':timeid' => $time['id']));
			}

			unset($time);
			$row['times'] = $times;
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_seckill_task_room') . ' r left join ' . tablename('ewei_shop_seckill_task') . (' t  on r.taskid = t.id  WHERE 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
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
		$roomid = intval($_GPC['id']);
		$taskid = intval($_GPC['taskid']);

		if (empty($taskid)) {
			$this->message('未选择专题', webUrl('seckill/task'), 'error');
		}

		$task = pdo_fetch('select * from ' . tablename('ewei_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $taskid));

		if (empty($task)) {
			$this->message('未选择专题', webUrl('seckill/task'), 'error');
		}

		$times = pdo_fetchall('select * from ' . tablename('ewei_shop_seckill_task_time') . ' where taskid=:taskid order by `time` asc ', array(':taskid' => $taskid));
		$redis = redis();

		if ($_W['ispost']) {
			$allgoods = array();
			$roomdata = array('title' => trim($_GPC['title']), 'enabled' => intval($_GPC['enabled']), 'page_title' => trim($_GPC['page_title']), 'share_title' => trim($_GPC['share_title']), 'share_desc' => trim($_GPC['share_desc']), 'share_icon' => save_media($_GPC['share_icon']), 'uniacid' => $_W['uniacid'], 'oldshow' => intval($_GPC['oldshow']), 'tag' => trim($_GPC['tag']), 'taskid' => $taskid, 'diypage' => intval($_GPC['diypage']));

			if (!empty($roomid)) {
				pdo_update('ewei_shop_seckill_task_room', $roomdata, array('id' => $roomid));
				plog('seckill.room.edit', '修改会场 ID: ' . $roomid);
			}
			else {
				$roomdata['createtime'] = time();
				pdo_insert('ewei_shop_seckill_task_room', $roomdata);
				$roomid = pdo_insertid();
				plog('seckill.room.add', '添加会场 ID: ' . $roomid);
			}

			foreach ($times as $time) {
				$timeid = $time['id'];
				$goodsids = array();
				$open = trim($_GPC['timeopen'][$time['time']]);

				if (empty($open)) {
					pdo_delete('ewei_shop_seckill_task_goods', array('taskid' => $taskid, 'roomid' => $roomid, 'timeid' => $time['id']));
				}
				else {
					$timegoods = $_GPC['time-' . $time['time'] . 'packagegoods'];

					if (empty($timegoods)) {
						show_json(0, '未添加任何商品');
					}

					if (is_array($timegoods)) {
						$goodsids = array();

						foreach ($timegoods as $k => $v) {
							$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid  and goodsid=:goodsid  limit 1', array(':taskid' => $taskid, ':roomid' => $roomid, ':goodsid' => $k));

							if ($count <= 0) {
								$goodsids[] = $k;
							}

							if (empty($v)) {
								$prices = explode(',', trim($_GPC['time-' . $time['time'] . 'packgoods' . $k]));

								if (empty($prices[4])) {
									$goods = pdo_fetch('select title from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $k, ':uniacid' => $_W['uniacid']));
									show_json(0, '商品' . $goods['title'] . '库存不能为0！');
								}
							}
							else {
								$optionids = explode(',', $v);
								$optionids = array_filter($optionids);

								foreach ($optionids as $option) {
									$prices = explode(',', trim($_GPC['time-' . $time['time'] . 'packagegoodsoption' . $option]));

									if (empty($prices[4])) {
										$goods = pdo_fetch('select title from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $k, ':uniacid' => $_W['uniacid']));
										show_json(0, '商品' . $goods['title'] . '库存不能为0！');
									}
								}
							}
						}

						$check = $this->model->checkTaskGoods($taskid, $roomid, $goodsids);

						if (is_error($check)) {
							show_json(0, $check['message']);
						}

						$displayorder = 0;

						foreach ($timegoods as $k => $v) {
							if (empty($v)) {
								$prices = explode(',', trim($_GPC['time-' . $time['time'] . 'packgoods' . $k]));
								$data = array('displayorder' => $displayorder, 'uniacid' => $_W['uniacid'], 'taskid' => $taskid, 'roomid' => $roomid, 'timeid' => $timeid, 'goodsid' => $k, 'price' => $prices[0], 'commission1' => $prices[1], 'commission2' => $prices[2], 'commission3' => $prices[3], 'total' => $prices[4], 'maxbuy' => $prices[5], 'totalmaxbuy' => $prices[5]);
								$goods = pdo_fetch('select * from ' . tablename('ewei_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and timeid=:timeid and goodsid=:goodsid  limit 1', array(':taskid' => $taskid, ':roomid' => $roomid, ':timeid' => $timeid, ':goodsid' => $k));

								if (empty($goods)) {
									pdo_insert('ewei_shop_seckill_task_goods', $data);
									$goodsids[] = pdo_insertid();
								}
								else {
									pdo_update('ewei_shop_seckill_task_goods', $data, array('id' => $goods['id']));
									$goodsids[] = $goods['id'];
								}

								$data['time'] = $time['time'];
								$allgoods[] = $data;
							}
							else {
								$optionids = explode(',', $v);
								$optionids = array_filter($optionids);

								foreach ($optionids as $option) {
									$prices = explode(',', trim($_GPC['time-' . $time['time'] . 'packagegoodsoption' . $option]));
									$data = array('displayorder' => $displayorder, 'uniacid' => $_W['uniacid'], 'taskid' => $taskid, 'roomid' => $roomid, 'timeid' => $timeid, 'goodsid' => $k, 'optionid' => $option, 'price' => $prices[0], 'commission1' => $prices[1], 'commission2' => $prices[2], 'commission3' => $prices[3], 'total' => $prices[4], 'maxbuy' => $prices[5], 'totalmaxbuy' => $prices[6]);
									$goods = pdo_fetch('select * from ' . tablename('ewei_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and timeid=:timeid and goodsid=:goodsid and optionid=:optionid limit 1', array(':taskid' => $taskid, ':roomid' => $roomid, ':timeid' => $timeid, ':goodsid' => $k, ':optionid' => $option));

									if (empty($goods)) {
										pdo_insert('ewei_shop_seckill_task_goods', $data);
										$goodsids[] = pdo_insertid();
									}
									else {
										pdo_update('ewei_shop_seckill_task_goods', $data, array('id' => $goods['id']));
										$goodsids[] = $goods['id'];
									}

									$data['time'] = $time['time'];
									$allgoods[] = $data;
								}
							}

							++$displayorder;
						}
					}

					if (empty($goodsids)) {
						pdo_query('delete from ' . tablename('ewei_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and timeid=:timeid ', array(':taskid' => $taskid, ':roomid' => $roomid, ':timeid' => $timeid));
					}
					else {
						pdo_query('delete from ' . tablename('ewei_shop_seckill_task_goods') . ' where taskid=:taskid and roomid=:roomid and timeid=:timeid  and id not in (' . implode(',', $goodsids) . ')', array(':taskid' => $taskid, ':roomid' => $roomid, ':timeid' => $timeid));
					}
				}
			}

			$this->model->setTaskCache($taskid);
			show_json(1, array('url' => webUrl('seckill/room', array('taskid' => $taskid))));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_seckill_task_room') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $roomid, ':uniacid' => $_W['uniacid']));
		$roomtimes = array();

		if (!empty($item)) {
			foreach ($times as &$t) {
				$sql = 'select tg.id,tg.goodsid, tg.price as packageprice, tg.maxbuy,tg.totalmaxbuy, g.title,g.thumb,g.hasoption,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('ewei_shop_seckill_task_goods') . ' tg  
                  left join ' . tablename('ewei_shop_goods') . ' g on tg.goodsid = g.id 
                  where tg.taskid=:taskid and tg.roomid=:roomid and  tg.timeid=:timeid and tg.uniacid=:uniacid  group by tg.goodsid order by tg.displayorder asc ';
				$goods = pdo_fetchall($sql, array(':taskid' => $item['taskid'], ':roomid' => $roomid, ':timeid' => $t['id'], ':uniacid' => $_W['uniacid']), 'time');

				foreach ($goods as &$g) {
					$options = array();

					if ($g['hasoption']) {
						$g['optiontitle'] = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price as packageprice,tg.maxbuy,tg.totalmaxbuy, g.title,g.marketprice,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('ewei_shop_seckill_task_goods') . '  tg  left join ' . tablename('ewei_shop_goods') . ' g on tg.goodsid = g.id  where tg.roomid=:roomid and tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $t['id'], ':taskid' => $item['taskid'], ':roomid' => $roomid, ':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));

						foreach ($g['optiontitle'] as $go) {
							$options[] = $go['optionid'];
						}
					}

					$g['option'] = implode(',', $options);
				}

				unset($g);
				$t['goods'] = $goods;

				if (!empty($goods)) {
					$roomtimes[] = $t['time'];
				}
			}

			unset($t);
		}

		$pages = false;

		if (p('diypage')) {
			$pages = p('diypage')->getPageList('allpage', ' and type=7 ');
			$pages = $pages['list'];
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,taskid, title FROM ' . tablename('ewei_shop_seckill_task_room') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_seckill_task_room', array('id' => $item['id']));
			pdo_delete('ewei_shop_seckill_task_goods', array('taskid' => $item['taskid'], 'roomid' => $item['id']));
			$task = pdo_fetch('select id,title from ' . tablename('ewei_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $item['taskid']));
			plog('seckill.room.delete', '删除会场 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' <br/>专题 ID: ' . $task['id'] . ' 标题: ' . $task['title']);
			$this->model->setTaskCache($task['id']);
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetch('SELECT id,taskid,title FROM ' . tablename('ewei_shop_seckill_task_room') . ' WHERE id=:id limit 1', array(':id' => $id));

		if (!empty($item)) {
			$task = pdo_fetch('select id,title from ' . tablename('ewei_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $item['taskid']));
			pdo_update('ewei_shop_seckill_task_room', array('displayorder' => $displayorder), array('id' => $id));
			plog('seckill.adv.edit', '修改会场排序 ID: ' . $item['id'] . ' 标题: ' . $item['advname'] . ' 排序: ' . $displayorder . '  <br/>专题 ID: ' . $task['id'] . ' 标题: ' . $task['title']);
			$this->model->setTaskCache($task['id']);
		}

		show_json(1);
	}

	public function enabled()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,taskid, title FROM ' . tablename('ewei_shop_seckill_task_room') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_seckill_task_room', array('enabled' => intval($_GPC['enabled'])), array('id' => $item['id']));
			$task = pdo_fetch('select id,title from ' . tablename('ewei_shop_seckill_task') . ' where id=:id limit 1', array(':id' => $item['taskid']));
			plog('seckill.room.edit', '修改会场状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['title'] . '<br/>状态: ' . ($_GPC['enabled'] == 1 ? '显示' : '隐藏') . ('<br/>专题 ID: ' . $task['id'] . ' 标题: ' . $task['title']));
			$this->model->setTaskCache($task['id']);
		}

		show_json(1, array('url' => referer()));
	}

	public function querygoods()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$kwd = trim($_GPC['keyword']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$params = array();
		$params[':uniacid'] = $uniacid;
		$condition = ' and status=1 and deleted=0 and type<>4 and type <> 9 and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,thumb,bargain,marketprice,total,goodssn,productsn,`type`,isdiscount,istime,isverify,share_title,share_icon,description,hasoption,nocommission,groupstype
            FROM ' . tablename('ewei_shop_goods') . ('
            WHERE 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_goods') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		$ds = set_medias($ds, array('thumb'));
		include $this->template();
	}

	public function queryoption()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$goodsid = intval($_GPC['goodsid']);
		$pid = intval($_GPC['pid']);
		$selectorid = trim($_GPC['selectorid']);
		$hasoption = 0;
		$params = array(':uniacid' => $uniacid, ':goodsid' => $goodsid);
		$commission_level = 0;

		if (p('commission')) {
			$data = m('common')->getPluginset('commission');
			$commission_level = $data['level'];
		}

		$goods = pdo_fetch('select id,title,marketprice,hasoption,nocommission from ' . tablename('ewei_shop_goods') . ' where uniacid = :uniacid and id = :goodsid ', $params);

		if (!empty($pid)) {
			$packgoods = pdo_fetch('select id,title,packageprice,commission1,commission2,commission3,`option`,goodsid from ' . tablename('ewei_shop_package_goods') . '
                        where pid = ' . $pid . ' and uniacid = :uniacid and goodsid = :goodsid ', $params);
		}
		else {
			$packgoods = array('title' => $goods['title'], 'marketprice' => $goods['marketprice'], 'packageprice' => 0, 'commission1' => 0, 'commission2' => 0, 'commission3' => 0);
		}

		if ($goods['hasoption']) {
			$hasoption = 1;
			$option = array();
			$option = pdo_fetchall('SELECT id,title,marketprice,specs,displayorder FROM ' . tablename('ewei_shop_goods_option') . '
            WHERE uniacid = :uniacid and goodsid = :goodsid  ORDER BY displayorder DESC,id DESC ', $params);
			$package_option = pdo_fetchall('SELECT id,uniacid,goodsid,optionid,pid,title,marketprice,packageprice,commission1,commission2,commission3 FROM ' . tablename('ewei_shop_package_goods_option') . '
            WHERE uniacid = :uniacid and goodsid = :goodsid  and pid = ' . $pid . ' ', $params);

			foreach ($option as $key => $value) {
				foreach ($package_option as $k => $val) {
					if ($value['id'] == $val['optionid']) {
						$option[$key]['packageprice'] = $val['packageprice'];
						$option[$key]['commission1'] = $val['commission1'];
						$option[$key]['commission2'] = $val['commission2'];
						$option[$key]['commission3'] = $val['commission3'];
						continue;
					}
				}

				if (strpos($packgoods['option'], $value['id']) !== false) {
					$option[$key]['isoption'] = 1;
				}
			}
		}
		else {
			$packgoods['marketprice'] = $goods['marketprice'];
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
}

?>
