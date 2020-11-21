<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once 'presentation.php';
require_once 'chicken.php';
class Task_EweiShopV2Page extends PluginMobilePage
{
	/**     * 当前数据表名称     * @var string     */
	private $table = 'ewei_open_farm_task';
	/**     * 当前类的所有字段     * @var array     */
	private $field = array('id', 'uniacid', 'logo', 'title', 'feed', 'get_max', 'start_time', 'end_time', 'category', 'core', 'order_feed', 'money_feed', 'goods_id', 'goods_feed', 'core_feed', 'member_level', 'member_level_feed', 'create_time');
	/**     * 默认openid     * @var string     */
	private $openid = '';

	/**     * 初始化接口     */
	public function __construct()
	{
		parent::__construct();
		global $_W;
		$_W['openid'] = $_W['openid'];
	}

	/**     * 任务列表     * @param     */
	public function getList()
	{
		global $_W;
		global $_GPC;
		$currentPage = intval($_GPC['__input']['page']) ? intval($_GPC['__input']['page']) : 1;
		$pageSize = 10;
		$now = date('Y-m-d H:i:s');
		$sql = ' SELECT ' . ' `id`, ' . ' `uniacid`, ' . ' `logo`, ' . ' `title`, ' . ' `get_max`, ' . ' `core`, ' . ' `category`, ' . ' `goods_id`, ' . ' `goods_feed`, ' . ' `order_feed`, ' . ' `money_feed` ' . ' FROM ' . tablename($this->table) . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `start_time` <= \'' . $now . '\' ') . (' AND `end_time` >= \'' . $now . '\' ') . ' LIMIT ' . ($currentPage - 1) * $pageSize . ',' . $pageSize;
		$list = pdo_fetchall($sql);
		$list = $this->model->forTomedia($list, 'logo', 'show_logo');
		$list = $this->updateTask($list);
		$list = $this->getStatus($list);
		$this->model->returnJson($list);
	}

	/**     * 更新任务数据     * @param $data     * @return array     */
	public function updateTask($data)
	{
		global $_W;
		global $_GPC;
		if (!$data || count($data) <= 0) {
			return $data;
		}

		$today = date('Y-m-d');
		$start = $today . ' 00:00:00';
		$end = $today . ' 23:59:59';

		foreach ($data as $key => $value) {
			$table = 'ewei_open_farm_user_task';
			$userTask = tablename($table);
			$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $value['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
			$query = pdo_fetchall($sql);
			$taskSum = count($query);

			if ($taskSum <= 0) {
				continue;
			}

			if ($query[0]['status'] === '进行中') {
				switch ($value['category']) {
				case '任务中心':
					$this->updateCore($value);
					break;

				case '商城下单':
					$this->updateShop($value);
					break;

				case '购买商品':
					$this->updateGoods($value);
					break;

				default:
					break;
				}
			}
			else {
				if ($query[0]['status'] === '已完成') {
					continue;
				}
			}
		}

		return $data;
	}

	/**     * 更新任务中心任务状态     * @param $data     * @return void     */
	public function updateCore($data)
	{
		global $_W;
		global $_GPC;
		$today = date('Y-m-d');
		$start = $today . ' 00:00:00';
		$end = $today . ' 23:59:59';
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $data['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);
		if ($query && 1 <= count($query)) {
			$taskRecord = 'ewei_shop_task_record';
			$tableName = tablename($taskRecord);
			$sql = ' SELECT `id`,`finishtime` FROM ' . $tableName . ' ' . (' WHERE `id` = \'' . $query[0]['rid'] . '\' ');
			$record = pdo_fetchall($sql);
			if ($record && $record[0]['finishtime'] !== '0000-00-00 00:00:00') {
				$sql = ' UPDATE ' . $userTask . ' SET ' . ' `status` = \'已完成\' ' . (' WHERE `id` = ' . $query[0]['id']);
				pdo_query($sql);
			}
		}
	}

	/**     * 更新商城下单任务状态     * @param $data     */
	public function updateShop($data)
	{
		global $_W;
		global $_GPC;
		$today = date('Y-m-d');
		$start = $today . ' 00:00:00';
		$end = $today . ' 23:59:59';
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $data['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);
		if ($query && 1 <= count($query)) {
			$startTime = strtotime($query[0]['create_time']);
			$endTime = strtotime($end);
			$table = 'ewei_shop_order';
			$order = tablename($table);
			$sql = ' SELECT `price` FROM ' . $order . ' ' . (' WHERE `createtime` >= \'' . $startTime . '\' ') . (' AND `createtime` <= \'' . $endTime . '\' ') . (' AND `paytime` >= \'' . $startTime . '\' ') . (' AND `paytime` <= \'' . $endTime . '\' ');
			$orderArr = pdo_fetchall($sql);
			$orderMoney = 0;
			$orderSum = count($orderArr);

			foreach ($orderArr as $key => $value) {
				$orderMoney += $value['price'];
			}

			if (0 < $orderSum) {
				$sql = ' UPDATE ' . $userTask . ' SET ' . (' `order_money` = ' . $orderMoney . ' , ') . (' `order_sum` = ' . $orderSum . ' ,') . ' `status` = \'已完成\' ' . (' WHERE `id` = ' . $query[0]['id'] . ' ');
				pdo_query($sql);
			}
		}
	}

	/**     * 更新购买商品任务信息     * @param $data     */
	public function updateGoods($data)
	{
		global $_W;
		global $_GPC;
		$today = date('Y-m-d');
		$start = $today . ' 00:00:00';
		$end = $today . ' 23:59:59';
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $data['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);
		if ($query && 1 <= count($query)) {
			$startTime = strtotime($query[0]['create_time']);
			$endTime = strtotime($end);
			$table = 'ewei_shop_order_goods';
			$orderGoods = tablename($table);
			$sql = ' SELECT `id`,`goodsid`,`orderid` FROM ' . $orderGoods . ' ' . (' WHERE `goodsid` = \'' . $data['goods_id'] . '\' ') . (' AND `createtime` >= \'' . $startTime . '\' ') . (' AND `createtime` <= \'' . $endTime . '\' ');
			$goodsArr = pdo_fetchall($sql);
			$goodsArr = $this->checkOrderPay($goodsArr);
			$goodsSum = count($goodsArr);

			if (0 < $goodsSum) {
				$sql = ' UPDATE ' . $userTask . ' SET ' . (' `goods_sum` = ' . $goodsSum . ' ,') . ' `status` = \'已完成\' ' . (' WHERE `id` = ' . $query[0]['id'] . ' ');
				pdo_query($sql);
			}
		}
	}

	/**     * 判断订单是否支付     * @param $data     * @return mixed     */
	public function checkOrderPay($data)
	{
		$today = date('Y-m-d');
		$start = $today . ' 00:00:00';
		$end = $today . ' 23:59:59';
		$startTime = strtotime($start);
		$endTime = strtotime($end);
		$orderIdArr = array();

		foreach ($data as $key => $value) {
			$orderIdArr[$value['id']] = $value['orderid'];
		}

		$orderIdStr = implode(',', $orderIdArr);
		$table = 'ewei_shop_order';
		$tableName = tablename($table);
		$sql = ' SELECT * FROM ' . $tableName . ' ' . (' WHERE `id` IN (' . $orderIdStr . ') ');
		$orderArr = pdo_fetchall($sql);

		foreach ($orderArr as $key => $value) {
			if ($value['paytime'] < $startTime && $endTime < $value['paytime'] || $value['status'] <= 0) {
				foreach ($data as $k => $v) {
					if ($v['orderid'] === $value['id']) {
						unset($data[$k]);
					}
				}
			}
		}

		return $data;
	}

	/**     * 根据id获取信息     * @param $id     * @return bool     */
	public function getInfoById($id)
	{
		$where = array('id' => $id);
		$info = pdo_get($this->table, $where);
		return $info;
	}

	/**     * 查询任务状态     * @param $data     * @return mixed     */
	public function getStatus($data)
	{
		global $_W;
		global $_GPC;
		if (!$data || count($data) <= 0) {
			return $data;
		}

		$today = date('Y-m-d');
		$start = $today . ' 00:00:00';
		$end = $today . ' 23:59:59';

		foreach ($data as $key => $value) {
			$table = 'ewei_open_farm_user_task';
			$userTask = tablename($table);
			$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $value['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
			$query = pdo_fetchall($sql);
			$taskSum = count($query);

			if ($taskSum === 0) {
				$data[$key]['status'] = -1;
			}
			else {
				$taskLog = $query[0];

				switch ($taskLog['status']) {
				case '进行中':
					$data[$key]['status'] = -1;
					break;

				case '已完成':
					$data[$key]['status'] = 1;
					break;

				case '已领取':
					$data[$key]['status'] = 2;
					break;

				default:
					break;
				}

				$feed = 0;

				switch ($data[$key]['category']) {
				case '购买商品':
					if ($query && 0 < count($query)) {
						$feed = $query[0]['goods_sum'] * $data[$key]['goods_feed'];
						$feed = $feed <= $data[$key]['get_max'] ? $feed : $data[$key]['get_max'];
					}

					break;

				case '商城下单':
					if ($query && 0 < count($query)) {
						$sumFeed = $query[0]['order_sum'] * $data[$key]['order_feed'];
						$moneyFeed = $query[0]['order_money'] / $data[$key]['money_feed'];
						$feed = floor($sumFeed + $moneyFeed);
						$feed = $feed <= $data[$key]['get_max'] ? $feed : $data[$key]['get_max'];
					}

					break;
				}

				$data[$key]['feed'] = $feed;
			}
		}

		return $data;
	}

	/**     * 领取任务     * @return mixed     */
	public function receiveTask()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];

		switch ($data['category']) {
		case '签到':
			$this->signIn($data);
			break;

		case '任务中心':
			$this->core($data);
			break;

		case '商城下单':
			$this->shop($data);
			break;

		case '购买商品':
			$this->goods($data);
			break;

		case '会员领取':
			$this->member($data);
			break;

		default:
			break;
		}
	}

	/**     * 签到任务     * @param $data     * @return void     */
	public function signIn($data)
	{
		global $_W;
		global $_GPC;
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$task = $this->getInfoById($data['id']);
		$today = date('Y-m-d');
		$start = $today . ' 00:00:00';
		$end = $today . ' 23:59:59';
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . ' AND `status` = \'进行中\' ' . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);
		$log = false;
		$inc = false;
		$journal = false;
		if (!$query || count($query) < 1) {
			$taskLog = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'task_id' => $data['id'], 'status' => '已领取', 'create_time' => date('Y-m-d H:i:s'));
			$log = pdo_insert($table, $taskLog);
			$feed = $task['get_max'] < $task['feed'] ? $task['get_max'] : $task['feed'];

			if ($log) {
				$chicken = new Chicken_EweiShopV2Page();
				$inc = $chicken->incFeed($feed);
			}

			if ($inc) {
				$presentation = new Presentation_EweiShopV2Page();
				$content = '主人主人,你签到成功获得了' . $feed . '克饲料哦~';
				$journal = $presentation->addInfo($content);
			}
		}

		$this->model->returnJson($log && $inc && $journal);
	}

	/**     * 任务中心     * @param $data     * @return void     */
	public function core($data)
	{
		global $_W;
		global $_GPC;
		$now = date('Y-m-d');
		$start = $now . ' 00:00:00';
		$end = $now . ' 23:59:59';
		$task = $this->getInfoById($data['id']);
		if (isset($data['rid']) && !empty($data['rid'])) {
			$rid = $data['rid'];
		}
		else {
			$taskRecord = 'ewei_shop_task_record';
			$tableName = tablename($taskRecord);
			$sql = ' SELECT `id` FROM ' . $tableName . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `taskid` = \'' . $task['core'] . '\' ') . ' AND `finishtime` = \'0000-00-00 00:00:00\' ' . ' ORDER BY `id` DESC ' . ' LIMIT 1 ';
			$recordArr = pdo_fetch($sql);
			$rid = isset($recordArr['id']) ? $recordArr['id'] : 0;
		}

		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `rid` = \'' . $rid . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);

		if (count($query) <= 0) {
			$userTask = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'task_id' => $task['id'], 'rid' => $rid, 'status' => '进行中', 'create_time' => date('Y-m-d H:i:s'));
			pdo_insert('ewei_open_farm_user_task', $userTask);
		}

		$parameter = array('id' => $task['core'], 'rid' => $rid);
		$coreUrl = mobileUrl('task/detail', $parameter, true);
		$this->model->returnJson(true, false, '', $coreUrl);
	}

	/**     * 商城下单     * @param $data     */
	public function shop($data)
	{
		global $_W;
		global $_GPC;
		$task = $this->getInfoById($data['id']);
		$now = date('Y-m-d');
		$start = $now . ' 00:00:00';
		$end = $now . ' 23:59:59';
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);

		if (count($query) <= 0) {
			$userTask = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'task_id' => $task['id'], 'status' => '进行中', 'create_time' => date('Y-m-d H:i:s'));
			pdo_insert('ewei_open_farm_user_task', $userTask);
		}

		$coreUrl = mobileUrl('', array(), true);
		$this->model->returnJson(true, false, '', $coreUrl);
	}

	/**     * 购买商品     * @param $data     */
	public function goods($data)
	{
		global $_W;
		global $_GPC;
		$task = $this->getInfoById($data['id']);
		$now = date('Y-m-d');
		$start = $now . ' 00:00:00';
		$end = $now . ' 23:59:59';
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);

		if (count($query) <= 0) {
			$userTask = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'task_id' => $task['id'], 'status' => '进行中', 'create_time' => date('Y-m-d H:i:s'));
			pdo_insert('ewei_open_farm_user_task', $userTask);
		}

		$parameter = array('id' => $task['goods_id']);
		$coreUrl = mobileUrl('goods/detail', $parameter, true);
		$this->model->returnJson(true, false, '', $coreUrl);
	}

	/**     * 会员奖励     * @param $data     * @return void     */
	public function member($data)
	{
		global $_W;
		global $_GPC;
		$info = $this->getInfo($data['id']);
		$member = m('member')->getMember($_W['openid']);

		if ($member['level'] !== $info['member_level']) {
			$this->model->returnJson(false, false, '您的会员等级不满足领取要求');
		}

		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$task = $this->getInfoById($data['id']);
		$today = date('Y-m-d');
		$start = $today . ' 00:00:00';
		$end = $today . ' 23:59:59';
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . ' AND `status` = \'进行中\' ' . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);
		$log = false;
		$inc = false;
		$journal = false;
		if (!$query || count($query) < 1) {
			$taskLog = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'task_id' => $data['id'], 'status' => '已领取', 'create_time' => date('Y-m-d H:i:s'));
			$log = pdo_insert($table, $taskLog);
			$feed = $task['get_max'] < $task['member_level_feed'] ? $task['get_max'] : $task['member_level_feed'];

			if ($log) {
				$chicken = new Chicken_EweiShopV2Page();
				$inc = $chicken->incFeed($feed);
			}

			if ($inc) {
				$presentation = new Presentation_EweiShopV2Page();
				$content = '主人主人,你领取会员奖励饲料获得了' . $feed . '克饲料哦~';
				$journal = $presentation->addInfo($content);
			}
		}

		$this->model->returnJson($log && $inc && $journal);
	}

	/**     * 领取奖励     */
	public function receive()
	{
		global $_W;
		global $_GPC;
		$data = $_GPC['__input'];

		switch ($data['category']) {
		case '任务中心':
			$this->receiveCore($data);
			break;

		case '商城下单':
			$this->receiveShop($data);
			break;

		case '购买商品':
			$this->receiveGoods($data);
			break;

		default:
			break;
		}
	}

	/**     * 领取任务中心完成奖励     * @param $data     */
	public function receiveCore($data)
	{
		global $_W;
		global $_GPC;
		$task = $this->getInfoById($data['id']);
		$inc = false;
		$journal = false;
		$now = date('Y-m-d');
		$start = $now . ' 00:00:00';
		$end = $now . ' 23:59:59';
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' UPDATE ' . $userTask . ' SET `status` = \'已领取\' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$status = pdo_query($sql);
		$feed = $task['get_max'] < $task['core_feed'] ? $task['get_max'] : $task['core_feed'];

		if ($status) {
			$chicken = new Chicken_EweiShopV2Page();
			$inc = $chicken->incFeed($feed);
		}

		if ($inc && $status) {
			$presentation = new Presentation_EweiShopV2Page();
			$content = '主人主人,你完成 任务中心 类任务成功获得了' . $feed . '克饲料哦~';
			$journal = $presentation->addInfo($content);
		}

		$this->model->returnJson($journal);
	}

	/**     * 领取商城下单任务奖励     * @param $data     */
	public function receiveShop($data)
	{
		global $_W;
		global $_GPC;
		$task = $this->getInfoById($data['id']);
		$feed = 0;
		$inc = false;
		$now = date('Y-m-d');
		$start = $now . ' 00:00:00';
		$end = $now . ' 23:59:59';
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);
		if ($query && 0 < count($query)) {
			$sumFeed = $query[0]['order_sum'] * $task['order_feed'];
			$moneyFeed = $query[0]['order_money'] / $task['money_feed'];
			$feed = floor($sumFeed + $moneyFeed);
			$feed = $feed <= $task['get_max'] ? $feed : $task['get_max'];
		}

		if ($task) {
			$chicken = new Chicken_EweiShopV2Page();
			$inc = $chicken->incFeed($feed);
		}

		$sql = ' UPDATE ' . $userTask . ' SET `status` = \'已领取\' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$status = pdo_query($sql);
		$journal = false;
		if ($inc && $status) {
			$presentation = new Presentation_EweiShopV2Page();
			$content = '主人主人,你完成 商城下单 类任务成功获得了' . $feed . '克饲料哦~';
			$journal = $presentation->addInfo($content);
		}

		$this->model->returnJson($journal);
	}

	/**     * 领取购买商品任务奖励     * @param $data     */
	public function receiveGoods($data)
	{
		global $_W;
		global $_GPC;
		$task = $this->getInfoById($data['id']);
		$inc = false;
		$status = false;
		$journal = false;
		$feed = 0;
		$now = date('Y-m-d');
		$start = $now . ' 00:00:00';
		$end = $now . ' 23:59:59';
		$table = 'ewei_open_farm_user_task';
		$userTask = tablename($table);
		$sql = ' SELECT * FROM ' . $userTask . ' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
		$query = pdo_fetchall($sql);
		if ($query && 0 < count($query)) {
			$feed = $query[0]['goods_sum'] * $task['goods_feed'];
			$feed = $feed <= $task['get_max'] ? $feed : $task['get_max'];
		}

		if ($task) {
			$chicken = new Chicken_EweiShopV2Page();
			$inc = $chicken->incFeed($feed);
		}

		if ($inc) {
			$sql = ' UPDATE ' . $userTask . ' SET `status` = \'已领取\' ' . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . (' AND `task_id` = \'' . $task['id'] . '\' ') . (' AND `create_time` >= \'' . $start . '\' ') . (' AND `create_time` <= \'' . $end . '\' ');
			$status = pdo_query($sql);
		}

		if ($inc && $status) {
			$presentation = new Presentation_EweiShopV2Page();
			$content = '主人主人,你完成 购买商品 类任务成功获得了' . $feed . '克饲料哦~';
			$journal = $presentation->addInfo($content);
		}

		$this->model->returnJson($journal);
	}

	/**     * 获取任务详情     * @param $id     * @return bool     */
	public function getInfo($id)
	{
		global $_W;
		$where = array('id' => $id, 'uniacid' => $_W['uniacid']);
		$query = pdo_get($this->table, $where);
		return $query;
	}
}

?>
