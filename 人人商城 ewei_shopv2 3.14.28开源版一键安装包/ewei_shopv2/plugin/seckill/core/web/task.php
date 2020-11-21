<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'seckill/core/seckill_page_web.php';
class Task_EweiShopV2Page extends SeckillWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if ($_GPC['enabled'] != '') {
			$condition .= ' and enabled=' . intval($_GPC['enabled']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and title  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_seckill_task') . (' WHERE 1 ' . $condition . '  ORDER BY id DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($list as &$row) {
			$row['roomcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_seckill_task_room') . ' where taskid=:taskid limit 1', array(':taskid' => $row['id']));
			$row['isused'] = $this->model->usedDate($row['id']);
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_seckill_task') . (' WHERE 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$category = pdo_fetchall('select id ,`name` from ' . tablename('ewei_shop_seckill_category') . ' where uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']), 'id');
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
		$id = intval($_GPC['id']);
		$redis = redis();

		if ($_W['ispost']) {
			$allgoods = array();
			$alltimes = $_GPC['times'];
			if (!is_array($alltimes) || empty($alltimes)) {
				show_json(0, '未设置任何秒杀点');
			}

			$taskdata = array('title' => trim($_GPC['title']), 'enabled' => intval($_GPC['enabled']), 'cateid' => intval($_GPC['cateid']), 'tag' => trim($_GPC['tag']), 'page_title' => trim($_GPC['page_title']), 'share_title' => trim($_GPC['share_title']), 'share_desc' => trim($_GPC['share_desc']), 'share_icon' => save_media($_GPC['share_icon']), 'uniacid' => $_W['uniacid'], 'oldshow' => intval($_GPC['oldshow']), 'closesec' => intval($_GPC['closesec']), 'times' => implode(',', $alltimes), 'overtimes' => intval($_GPC['overtimes']));

			if (!empty($id)) {
				pdo_update('ewei_shop_seckill_task', $taskdata, array('id' => $id));
				plog('seckill.task.edit', '修改专题 ID: ' . $id . ' 标题:' . $taskdata['title'] . ' 自动取消时间: ' . $taskdata['closesec']);
			}
			else {
				$taskdata['createtime'] = time();
				pdo_insert('ewei_shop_seckill_task', $taskdata);
				$id = pdo_insertid();
				$taskdata['id'] = $id;
				plog('seckill.task.add', '添加专题 ID: ' . $id . ' 标题:' . $taskdata['title'] . ' 自动取消时间: ' . $taskdata['closesec']);
			}

			$notimes = array();
			$i = 0;

			while ($i <= 23) {
				if (!in_array($i, $alltimes)) {
					$notimes[] = $i;
				}

				++$i;
			}

			foreach ($alltimes as $i) {
				$time = pdo_fetch('select * from ' . tablename('ewei_shop_seckill_task_time') . ' where taskid=:taskid and `time`=:time limit 1', array(':taskid' => $id, ':time' => $i));

				if (empty($time)) {
					$time = array('uniacid' => $_W['uniacid'], 'taskid' => $id, 'time' => $i);
					pdo_insert('ewei_shop_seckill_task_time', $time);
				}
			}

			if (!empty($notimes)) {
				foreach ($notimes as $i) {
					$time = pdo_fetch('select * from ' . tablename('ewei_shop_seckill_task_time') . ' where taskid=:taskid and `time`=:time limit 1', array(':taskid' => $id, ':time' => $i));
					pdo_delete('ewei_shop_seckill_task_time', array('id' => $time['id']));
					pdo_delete('ewei_shop_seckill_task_goods', array('taskid' => $id, 'timeid' => $time['id']));
				}
			}

			$this->model->setTaskCache($id);
			show_json(1, array('url' => webUrl('seckill/task')));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_seckill_task') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_seckill_category') . ' where uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']), 'id');
		$alltimes = array();
		$times = array();

		if (!empty($item)) {
			$alltimes = explode(',', $item['times']);
			$times = pdo_fetchall('select * from ' . tablename('ewei_shop_seckill_task_time') . ' where taskid=:taskid and uniacid=:uniacid', array(':taskid' => $item['id'], ':uniacid' => $_W['uniacid']), 'time');

			foreach ($times as &$t) {
				$sql = 'select tg.id,tg.goodsid, tg.price as packageprice, tg.maxbuy, g.title,g.thumb,g.hasoption,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('ewei_shop_seckill_task_goods') . ' tg  
                  left join ' . tablename('ewei_shop_goods') . ' g on tg.goodsid = g.id 
                  where tg.taskid=:taskid and tg.timeid=:timeid and tg.uniacid=:uniacid  group by tg.goodsid order by tg.displayorder asc ';
				$goods = pdo_fetchall($sql, array(':taskid' => $item['id'], ':uniacid' => $_W['uniacid'], ':timeid' => $t['id']), 'time');

				foreach ($goods as &$g) {
					$options = array();

					if ($g['hasoption']) {
						$g['optiontitle'] = pdo_fetchall('select tg.id,tg.goodsid,tg.optionid,tg.price as packageprice,tg.maxbuy,g.title,g.marketprice,tg.commission1,tg.commission2,tg.commission3,tg.total from ' . tablename('ewei_shop_seckill_task_goods') . '  tg  left join ' . tablename('ewei_shop_goods') . ' g on tg.goodsid = g.id  where tg.timeid=:timeid and tg.taskid=:taskid and tg.timeid=:timeid  and tg.goodsid=:goodsid and  tg.uniacid =:uniacid ', array(':timeid' => $t['id'], ':taskid' => $item['id'], ':goodsid' => $g['goodsid'], ':uniacid' => $_W['uniacid']));

						foreach ($g['optiontitle'] as $go) {
							$options[] = $go['optionid'];
						}
					}

					$g['option'] = implode(',', $options);
				}

				unset($g);
				$t['goods'] = $goods;
			}

			unset($t);
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_seckill_task') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_seckill_task', array('id' => $item['id']));
			pdo_delete('ewei_shop_seckill_task_time', array('taskid' => $item['id']));
			pdo_delete('ewei_shop_seckill_task_goods', array('taskid' => $item['id']));
			$this->model->setTaskCache($item['id']);
			$taskid = $this->model->getTodaySeckill();

			if ($taskid == $id) {
				$this->model->deleteTodaySeckill();
			}

			plog('seckill.task.delete', '删除专题 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function enabled()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_seckill_task') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_seckill_task', array('enabled' => intval($_GPC['enabled'])), array('id' => $item['id']));
			plog('seckill.task.edit', '修改专题状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['title'] . '<br/>状态: ' . $_GPC['enabled'] == 1 ? '显示' : '隐藏');
		}

		$this->model->setTaskCache($id);
		show_json(1, array('url' => referer()));
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid and enabled=1';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,tag FROM ' . tablename('ewei_shop_seckill_task') . (' WHERE 1 ' . $condition . '  ORDER BY id DESC'), $params);

		foreach ($ds as &$row) {
			$row['roomcount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_seckill_task_room') . ' where taskid=:taskid limit 1', array(':taskid' => $row['id']));
			$row['isused'] = $this->model->usedDate($row['id']);
		}

		unset($row);
		include $this->template();
	}
}

?>
