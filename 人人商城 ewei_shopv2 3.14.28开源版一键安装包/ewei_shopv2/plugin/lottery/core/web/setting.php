<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Setting_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and uniacid=:uniacid and `is_delete`=0 ';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND `title` LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_lottery_task') . (' WHERE 1 ' . $condition . ' ORDER BY addtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_task') . (' where 1 ' . $condition . ' '), $params);
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
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_lottery_task') . ' WHERE uniacid =:uniacid AND `id`=:id LIMIT 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($item)) {
			$item = array(
				'uniacid'    => $_W['uniacid'],
				'start_time' => '',
				'end_time'   => '',
				'task_data'  => array(),
				'updatetime' => '',
				'addtime'    => ''
				);
			$starttime = time();
			$endtime = strtotime(date('Y-m-d H:i', $starttime) . '+30 days');
		}
		else {
			$starttime = $item['start_time'];
			$endtime = $item['end_time'];
			$item['task_data'] = unserialize($item['task_data']);
		}

		$condition = ' AND `status`=1 AND uniacid= ' . $_W['uniacid'];
		$tasklist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_task_poster') . (' WHERE 1 ' . $condition . ' ORDER BY createtime desc LIMIT 15'));
		$condition = ' AND `is_delete`=0 AND uniacid= ' . $_W['uniacid'];
		$lotterylist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_lottery') . (' WHERE 1 ' . $condition . ' ORDER BY addtime desc LIMIT 15'));

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'title' => trim($_GPC['title']), 'start_time' => strtotime($_GPC['time']['start']), 'end_time' => strtotime($_GPC['time']['end']), 'updatetime' => time());
			$active = array();
			$active_data = htmlspecialchars_decode($_GPC['active_data']);
			$active_data = json_decode($active_data, 1);

			foreach ($active_data as $key => $value) {
				$active[$value['rank']] = array('id' => $value['id'], 'active' => $value['active']);
			}

			$task = array();
			$active_task = htmlspecialchars_decode($_GPC['active_task']);
			$active_task = json_decode($active_task, 1);

			foreach ($active_task as $key => $value) {
				if ($value['type'] == 1) {
					$task_data = array('type' => $value['type'], 'lottery' => $value['lottery'], 'paytype' => $value['paytype'], 'money' => $value['money'], 'active' => $active[$value['rank']]);
				}

				if ($value['type'] == 2) {
					$task_data = array('type' => $value['type'], 'lottery' => $value['lottery'], 'day' => $value['day'], 'active' => $active[$value['rank']]);
				}

				if ($value['type'] == 3) {
					$task_data = array('type' => $value['type'], 'lottery' => $value['lottery'], 'taskid' => $value['taskid'], 'taskname' => $value['taskname'], 'active' => $active[$value['rank']]);
				}

				if ($value['type'] == 4) {
					$task_data = array('type' => $value['type'], 'lottery' => $value['lottery'], 'content' => $value['content'], 'active' => $active[$value['rank']]);
				}

				array_push($task, $task_data);
			}

			$data['task_data'] = serialize($task);

			if (!empty($id)) {
				$param = array('id' => $id);
				$res = pdo_update('ewei_shop_lottery_task', $data, $param);

				if ($res) {
					show_json(1, array('url' => webUrl('lottery/setting')));
				}
				else {
					show_json(0, '更新失败!');
				}
			}
			else {
				$data['addtime'] = time();
				pdo_insert('ewei_shop_lottery_task', $data);
				$id = pdo_insertid();

				if ($id) {
					show_json(1, array('url' => webUrl('lottery/setting')));
				}
				else {
					show_json(0, '添加失败!');
				}
			}
		}

		include $this->template();
	}

	public function delete()
	{
		global $_GPC;
		global $_W;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$posters = pdo_fetchall('SELECT `id`,`title` FROM ' . tablename('ewei_shop_lottery_task') . (' WHERE `id` in ( ' . $id . ' ) and `uniacid`=') . $_W['uniacid']);

		foreach ($posters as $poster) {
			pdo_update('ewei_shop_lottery_task', array('is_delete' => 1), array('id' => $poster['id'], 'uniacid' => $_W['uniacid']));
			plog('lottery.setting.delete', '删除场景 ID: ' . $id . ' 海报名称: ' . $poster['title']);
		}

		show_json(1, array('url' => webUrl('lottery/setting')));
	}

	public function setstart()
	{
		global $_W;
		global $_GPC;
		$defaultcount = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_lottery_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		$default = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_lottery_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			cv('lottery.edit');

			if (0 < $defaultcount) {
				$default = unserialize($default);
				$default['keyword'] = trim($_GPC['keyword']);
				$default['title'] = trim($_GPC['title']);
				$default['thumb'] = trim($_GPC['thumb']);
				$default['desc'] = trim($_GPC['desc']);

				if (empty($default['keyword'])) {
					show_json(0, '请填写关键词!');
				}

				$keyword = m('common')->keyExist($default['keyword']);

				if (!empty($keyword)) {
					if ($keyword['name'] != 'ewei_shopv2:lottery') {
						show_json(0, '关键字已存在!');
					}
				}

				$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2:lottery'));

				if (!empty($rule)) {
					$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
					$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
				}

				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:lottery', 'module' => 'cover', 'displayorder' => 0, 'status' => 1);

				if (empty($rule)) {
					pdo_insert('rule', $rule_data);
					$rid = pdo_insertid();
				}
				else {
					pdo_update('rule', $rule_data, array('id' => $rule['id']));
					$rid = $rule['id'];
				}

				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($default['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => 1);

				if (empty($keyword)) {
					pdo_insert('rule_keyword', $keyword_data);
				}
				else {
					pdo_update('rule_keyword', $keyword_data, array('id' => $keyword['id']));
				}

				$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'title' => $default['title'], 'description' => $default['desc'], 'thumb' => $default['thumb'], 'url' => mobileUrl('lottery', NULL, 1));

				if (empty($cover)) {
					pdo_insert('cover_reply', $cover_data);
				}
				else {
					pdo_update('cover_reply', $cover_data, array('id' => $cover['id']));
				}

				$default = serialize($default);
				$update_data = array('data' => $default);
				pdo_update('ewei_shop_lottery_default', $update_data, array('uniacid' => $_W['uniacid']));
				plog('lottery.set.edit', '修改入口设置');
				show_json(1);
			}
			else {
				$default = array();
				$default['keyword'] = trim($_GPC['keyword']);
				$default['title'] = trim($_GPC['title']);
				$default['thumb'] = trim($_GPC['thumb']);
				$default['desc'] = trim($_GPC['desc']);

				if (empty($default['keyword'])) {
					show_json(0, '请填写关键词!');
				}

				$keyword = m('common')->keyExist($default['keyword']);

				if (!empty($keyword)) {
					if ($keyword['name'] != 'ewei_shopv2:lottery') {
						show_json(0, '关键字已存在!');
					}
				}

				$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2:lottery'));

				if (!empty($rule)) {
					$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
					$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
				}

				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:lottery', 'module' => 'cover', 'displayorder' => 0, 'status' => 1);

				if (empty($rule)) {
					pdo_insert('rule', $rule_data);
					$rid = pdo_insertid();
				}
				else {
					pdo_update('rule', $rule_data, array('id' => $rule['id']));
					$rid = $rule['id'];
				}

				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($default['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => 1);

				if (empty($keyword)) {
					pdo_insert('rule_keyword', $keyword_data);
				}
				else {
					pdo_update('rule_keyword', $keyword_data, array('id' => $keyword['id']));
				}

				$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'title' => $default['title'], 'description' => $default['desc'], 'thumb' => $default['thumb'], 'url' => mobileUrl('lottery', NULL, 1));

				if (empty($cover)) {
					pdo_insert('cover_reply', $cover_data);
				}
				else {
					pdo_update('cover_reply', $cover_data, array('id' => $cover['id']));
				}

				$default = serialize($default);
				$insert_data = array('uniacid' => $_W['uniacid'], 'data' => $default, 'addtime' => time());
				pdo_insert('ewei_shop_lottery_default', $insert_data);
			}
		}

		$set = unserialize($default);
		$url = mobileUrl('lottery', NULL, true);
		$qrcode = m('qrcode')->createQrcode($url);
		include $this->template();
	}

	public function setlottery()
	{
		global $_W;
		global $_GPC;
		$set = pdo_fetchcolumn('SELECT `data` FROM ' . tablename('ewei_shop_lottery_default') . ' WHERE uniacid =:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));

		if (!empty($set)) {
			$set = unserialize($set);
		}

		$data = m('common')->getSysset('notice', false);

		if ($_W['ispost']) {
			ca('sysset.notice.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			m('common')->updateSysset(array('notice' => $data));
			plog('sysset.notice.edit', '修改系统设置-模板消息通知设置');
			$set['lotteryinfo'] = serialize($_GPC['lotteryinfo']);
			$data = array('data' => serialize($set), 'addtime' => time());
			$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_default') . ' WHERE uniacid =:uniacid', array(':uniacid' => $_W['uniacid']));

			if ($count) {
				pdo_update('ewei_shop_lottery_default', $data, array('uniacid' => $_W['uniacid']));
			}
			else {
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_lottery_default', $data);
			}

			show_json(1, array('url' => webUrl('lottery/setting/setlottery')));
		}

		include $this->template();
	}
}

?>
