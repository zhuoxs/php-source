<?php
//QQ63779278
defined('IN_IA') || exit('Access Denied');
class Extension_EweiShopV2Page extends PluginWebPage
{
	public $action = '';
	public $taskType = '';

	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;
		$action = explode('.', $_W['action']);
		$this->action = $action[1];

		switch ($this->action) {
		case 'single':
			$this->taskType = '单次任务';
			break;

		case 'repeat':
			$this->taskType = '重复任务';
			break;

		case 'first':
			$this->taskType = '新手任务';
			break;

		case 'period':
			$this->taskType = '周期任务';
			break;

		case 'point':
			$this->taskType = '目标任务';
			break;

		default:
			exit('不存在的任务类型');
		}

		$func = trim($_GPC['taskfunc']);
		if (!empty($func) && method_exists($this, $func)) {
			$this->{$func}();
		}
		else {
			$this->main();
		}

		exit();
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$action = $this->action;
		$page = intval($_GPC['page']);
		$page = max(1, $page);
		$list = $this->model->getTaskLixt($action, $page);
		include $this->template('task/extension/index');
	}

	public function add()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			$data = $_GPC['data'];
			$data['uniacid'] = $_W['uniacid'];
			$data['title'] = trim($data['title']);

			if (empty($data['title'])) {
				show_json(0, '请填写标题');
			}

			switch ($this->action) {
			case 'single':
				$data['type'] = 1;
				break;

			case 'repeat':
				$data['type'] = 2;
				break;

			case 'first':
				$data['type'] = 3;
				break;

			case 'period':
				$data['type'] = 4;
				break;

			case 'point':
				$data['type'] = 5;
				break;

			default:
				show_json(0, '不存在的类型');
			}

			$data['starttime'] = intval(strtotime($data['time1']['start']));
			$data['endtime'] = intval(strtotime($data['time1']['end']));
			$data['dotime'] = intval(strtotime($data['time2']['start']));
			$data['donetime'] = intval(strtotime($data['time2']['end']));
			unset($data['time1']);
			unset($data['time2']);
			$data['timelimit'] = floatval($data['timelimit']);
			$data['status'] = intval($data['status']);
			if (count($data['require_data']) < 1 && empty($data['certain'])) {
				show_json(0, '请至少设置一个任务需求');
			}

			if (!empty($data['require_data'])) {
				foreach ($data['require_data'] as $k => $v) {
					if (0 < !$v['num']) {
						show_json(0, '请把任务需求设置完整');
					}
				}
			}

			if (is_array($data['certain'])) {
				foreach ($data['certain'] as $k => $v) {
					$goodsid = intval($v);
					$data['require_data']['cost_goods' . $goodsid]['num'] = 1;
				}
			}

			unset($data['certain']);
			$data['require_data'] = serialize($data['require_data']);
			$data['reward_data']['balance'] = floatval($data['reward_data']['balance']);
			$data['reward_data']['score'] = floatval($data['reward_data']['score']);
			$data['reward_data']['redpacket'] = floatval($data['reward_data']['redpacket']);
			$data['reward_data'] = serialize($data['reward_data']);

			if (empty($id)) {
				pdo_insert('ewei_shop_task', $data);
				$taskid = pdo_insertid();

				if (!empty($taskid)) {
					show_json(1, array('url' => webUrl('task.extension.' . $this->action, array('taskfunc' => 'add', 'id' => $taskid))));
				}
			}
			else if (pdo_update('ewei_shop_task', $data, array('id' => $id, 'uniacid' => $_W['uniacid']))) {
				show_json(1, array('url' => webUrl('task.extension.' . $this->action, array('taskfunc' => 'add', 'id' => $id))));
			}
			else {
				show_json(0, '没有任何更改');
			}
		}
		else {
			$data = pdo_get('ewei_shop_task', array('id' => $id, 'uniacid' => $_W['uniacid']));
			$data['starttime'] = empty($data['starttime']) ? date('Y-m-d H:i') : date('Y-m-d H:i', $data['starttime']);
			$data['endtime'] = empty($data['endtime']) ? date('Y-m-d H:i', time() + 864000) : date('Y-m-d H:i', $data['endtime']);
			$data['dotime'] = empty($data['dotime']) ? date('Y-m-d H:i') : date('Y-m-d H:i', $data['dotime']);
			$data['donetime'] = empty($data['donetime']) ? date('Y-m-d H:i', time() + 864000) : date('Y-m-d H:i', $data['donetime']);
			$data['require_data'] = unserialize($data['require_data']);
			$data['reward_data'] = unserialize($data['reward_data']);
			$data['timelimit'] = floatval($data['timelimit']);
			$taskList = $this->model->getAvailableTask(1, false);
			include $this->template('task/extension/post');
		}
	}

	public function goods()
	{
		global $_W;
		global $_GPC;
		$type = trim($_GPC['type']);
		$title = '';
		$page = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
		$pageprev = $page - 1;
		$pagenext = $page + 1;
		$psize = 10;
		$taskfunc = trim($_GPC['taskfunc']);
		$type = empty($type) ? $taskfunc : $type;

		if (!empty($_GPC['title'])) {
			$title = trim($_GPC['title']);
		}

		if (!empty($type)) {
			if ($type == 'goods') {
				$params = array(':title' => '%' . $title . '%', ':uniacid' => $_W['uniacid'], ':status' => '1');
				$totalsql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_goods') . ' WHERE `uniacid`= :uniacid and `status`=:status and `deleted`=0 AND merchid=0 AND title LIKE :title ';
				$searchsql = 'SELECT id,title,productprice,marketprice,thumb,sales,unit,minprice,hasoption,`total`,`status`,`deleted` FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= :uniacid and `status`=:status and `deleted`=0 AND merchid=0 AND title LIKE :title ORDER BY `status` DESC, `displayorder` DESC,`id` DESC LIMIT ' . ($page - 1) * $psize . ',' . $psize;
				$total = pdo_fetchcolumn($totalsql, $params);
				$pagelast = intval(($total - 1) / $psize) + 1;
				$list = pdo_fetchall($searchsql, $params);
				$spcSql = 'SELECT * FROM ' . tablename('ewei_shop_goods_option') . ' WHERE uniacid= :uniacid AND  goodsid= :goodsid';

				foreach ($list as $key => $value) {
					if ($value['hasoption']) {
						$spcwhere = array(':uniacid' => $_W['uniacid'], ':goodsid' => $value['id']);
						$spclist = pdo_fetchall($spcSql, $spcwhere);

						if (!empty($spclist)) {
							$list[$key]['spc'] = $spclist;
						}
						else {
							$list[$key]['spc'] = '';
						}
					}
				}
			}
			else {
				if ($type == 'coupon') {
					$params = array(':title' => '%' . $title . '%', ':uniacid' => $_W['uniacid']);
					$totalsql = 'select count(*) from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ';
					$searchsql = 'select id,couponname,coupontype,enough,thumb,backtype,deduct,backmoney,backcredit,`total`,backredpack,discount,displayorder from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ORDER BY `displayorder` DESC,`id` DESC LIMIT ' . ($page - 1) * $psize . ',' . $psize;
					$total = pdo_fetchcolumn($totalsql, $params);
					$pagelast = intval(($total - 1) / $psize) + 1;
					$list = pdo_fetchall($searchsql, $params);

					foreach ($list as &$d) {
						$d = com('coupon')->setCoupon($d, time(), false);
						$d['last'] = com('coupon')->get_last_count($d['id']);

						if ($d['last'] == -1) {
							$d['last'] = '不限';
						}
					}

					unset($d);
				}
			}

			include $this->template('task/extension/' . $type);
		}
	}

	public function certain()
	{
		global $_W;
		global $_GPC;
		$type = trim($_GPC['type']);
		$title = '';
		$page = intval($_GPC['page']) ? intval($_GPC['page']) : 1;
		$pageprev = $page - 1;
		$pagenext = $page + 1;
		$psize = 10;
		$taskfunc = trim($_GPC['taskfunc']);
		$type = empty($type) ? $taskfunc : $type;

		if (!empty($_GPC['title'])) {
			$title = trim($_GPC['title']);
		}

		if (!empty($type)) {
			if ($type == 'certain') {
				$params = array(':title' => '%' . $title . '%', ':uniacid' => $_W['uniacid'], ':status' => '1');
				$totalsql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_goods') . ' WHERE `uniacid`= :uniacid and `status`=:status and `deleted`=0 AND merchid=0 AND title LIKE :title ';
				$searchsql = 'SELECT id,title,productprice,marketprice,thumb,sales,unit,minprice,hasoption,`total`,`status`,`deleted` FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid= :uniacid and `status`=:status and `deleted`=0 AND merchid=0 AND title LIKE :title ORDER BY `status` DESC, `displayorder` DESC,`id` DESC LIMIT ' . ($page - 1) * $psize . ',' . $psize;
				$total = pdo_fetchcolumn($totalsql, $params);
				$pagelast = intval(($total - 1) / $psize) + 1;
				$list = pdo_fetchall($searchsql, $params);
				$spcSql = 'SELECT * FROM ' . tablename('ewei_shop_goods_option') . ' WHERE uniacid= :uniacid AND  goodsid= :goodsid';

				foreach ($list as $key => $value) {
					if ($value['hasoption']) {
						$spcwhere = array(':uniacid' => $_W['uniacid'], ':goodsid' => $value['id']);
						$spclist = pdo_fetchall($spcSql, $spcwhere);

						if (!empty($spclist)) {
							$list[$key]['spc'] = $spclist;
						}
						else {
							$list[$key]['spc'] = '';
						}
					}
				}
			}
			else {
				if ($type == 'coupon') {
					$params = array(':title' => '%' . $title . '%', ':uniacid' => $_W['uniacid']);
					$totalsql = 'select count(*) from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ';
					$searchsql = 'select id,couponname,coupontype,enough,thumb,backtype,deduct,backmoney,backcredit,`total`,backredpack,discount,displayorder from ' . tablename('ewei_shop_coupon') . ' where couponname LIKE :title and uniacid=:uniacid ORDER BY `displayorder` DESC,`id` DESC LIMIT ' . ($page - 1) * $psize . ',' . $psize;
					$total = pdo_fetchcolumn($totalsql, $params);
					$pagelast = intval(($total - 1) / $psize) + 1;
					$list = pdo_fetchall($searchsql, $params);

					foreach ($list as &$d) {
						$d = com('coupon')->setCoupon($d, time(), false);
						$d['last'] = com('coupon')->get_last_count($d['id']);

						if ($d['last'] == -1) {
							$d['last'] = '不限';
						}
					}

					unset($d);
				}
			}

			include $this->template('task/extension/' . $type);
		}
	}

	public function record()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$ids = $_GPC['ids'];

		if (!is_array($ids)) {
			$ids = array(intval($ids));
		}

		foreach ($ids as $v) {
			pdo_delete('ewei_shop_task', array('id' => intval($v), 'uniacid' => $_W['uniacid']));
		}

		show_json(1);
	}
}

?>
