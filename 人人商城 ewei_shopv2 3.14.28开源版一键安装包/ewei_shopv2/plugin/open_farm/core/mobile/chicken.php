<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once 'seting.php';
require_once 'grade.php';
require_once 'presentation.php';
require_once 'surprised.php';
class Chicken_EweiShopV2Page extends PluginMobilePage
{
	/**
     * 当前数据表名称
     * @var string
     */
	private $table = 'ewei_open_farm_chicken';
	/**
     * 当前类的所有字段
     * @var array
     */
	private $field = array('id', 'uniacid', 'openid', 'name', 'portrait', 'level', 'experience', 'accelerate', 'egg_stock', 'feed_stock', 'bowl_stock', 'integral', 'lay_eggs_sum', 'eat_sum', 'feeding_sum', 'feeding_time', 'create_time');
	/**
     * 默认openid
     * @var string
     */
	private $openid = '';

	/**
     * 初始化接口
     */
	public function __construct()
	{
		parent::__construct();
		global $_W;
		$_W['openid'] = $_W['openid'];
	}

	/**
     * 获取详细信息
     * @param bool $method
     * @return bool
     */
	public function getInfo($method = false)
	{
		global $_W;
		$sql = 'SELECT * FROM ' . tablename($this->table) . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' AND `openid` = \'' . $_W['openid'] . '\' ');
		$info = pdo_fetch($sql);

		if ($method) {
			return $info;
		}

		$this->model->returnJson($info);
	}

	/**
     * 添加用户饲料
     * @param $number
     * @return bool
     */
	public function incFeed($number)
	{
		global $_W;
		$tableName = tablename($this->table);
		$sql = ' UPDATE ' . $tableName . ' SET ' . ('`feed_stock` = `feed_stock` + ' . $number . ' ') . ' WHERE ' . (' `uniacid` = \'' . $_W['uniacid'] . '\' AND ') . (' `openid` = \'' . $_W['openid'] . '\' ');
		$query = pdo_query($sql);
		return $query;
	}

	/**
     * 添加用户饲料
     * @param $number
     * @return bool
     */
	public function redFeed($number)
	{
		global $_W;
		$tableName = tablename($this->table);
		$sql = ' UPDATE ' . $tableName . ' SET ' . ('`feed_stock` = `feed_stock` - ' . $number . ' ') . ' WHERE ' . (' `uniacid` = \'' . $_W['uniacid'] . '\' AND ') . (' `openid` = \'' . $_W['openid'] . '\' ');
		$query = pdo_query($sql);
		return $query;
	}

	/**
     * 添加用户鸡吃过的饲料总数
     * @param $chicken
     * @return array
     */
	public function updateFeed($chicken)
	{
		global $_W;
		$data = $this->layEggs($chicken);
		$tableName = tablename($this->table);
		$sql = ' UPDATE ' . $tableName . ' SET ' . ('`eat_sum` = `eat_sum` + ' . $chicken['feeding_sum'] . ' ,') . ('`lay_eggs_sum` = ' . $data['number'] . ' ') . ' WHERE ' . (' `uniacid` = \'' . $_W['uniacid'] . '\' AND ') . (' `openid` = \'' . $_W['openid'] . '\' ; ');
		pdo_query($sql);
		return $data;
	}

	/**
     * 添加鸡蛋库存
     * @param $number
     * @return bool
     */
	public function incEggs($number)
	{
		global $_W;
		$tableName = tablename($this->table);
		$sql = ' UPDATE ' . $tableName . ' SET ' . ('`egg_stock` = `egg_stock` + ' . $number . ' ') . ' WHERE ' . (' `uniacid` = \'' . $_W['uniacid'] . '\' AND ') . (' `openid` = \'' . $_W['openid'] . '\' ; ');
		$query = pdo_query($sql);
		return $query;
	}

	/**
     * 添加鸡蛋库存
     * @param $number
     * @return bool
     */
	public function redEggs($number)
	{
		global $_W;
		$tableName = tablename($this->table);
		$sql = ' UPDATE ' . $tableName . ' SET ' . ('`egg_stock` = `egg_stock` - ' . $number . ' ,') . ('`last_egg_stock` = `last_egg_stock` - ' . $number . ' ') . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ; ');
		$query = pdo_query($sql);
		return $query;
	}

	/**
     * 鸡下蛋
     * @param $chicken
     * @return array
     */
	public function layEggs($chicken)
	{
		global $_W;
		$laySum = $chicken['feeding_sum'] + $chicken['lay_eggs_sum'];
		$seting = new Seting_EweiShopV2Page();
		$seting = $seting->getInfo(true);
		$number = $laySum;
		$layEggsEatNumber = $chicken['lay_eggs_eat'] ? $chicken['lay_eggs_eat'] : $seting['lay_eggs_eat'];
		$eggSum = 0;
		$eggs = array();

		if ($layEggsEatNumber <= $laySum) {
			$layEggSum = floor($laySum / $layEggsEatNumber);
			$layEggsFeed = $layEggSum * $layEggsEatNumber;
			$layEggsFeedSum = $laySum - $layEggsFeed;

			if (0 < $layEggSum) {
				$i = 0;

				while ($i < $layEggSum) {
					$one = rand($seting['lay_eggs_number_min'], $seting['lay_eggs_number_max']);
					$eggSum += $one;
					$eggs[] = $one;
					++$i;
				}

				$i = 0;

				while ($i < $layEggSum) {
					$this->surprised();
					++$i;
				}

				$data['lay_eggs_eat'] = $seting['lay_eggs_eat'];
				pdo_update($this->table, $data);
			}

			$number = $layEggsFeedSum;
		}

		$data = array('number' => $number, 'egg_sum' => $eggSum, 'eggs' => $eggs);
		return $data;
	}

	/**
     * 鸡下彩蛋
     */
	public function surprised()
	{
		global $_W;
		$surprised = new Surprised_EweiShopV2Page();
		$surprised->clearCouponSurprised();
		$seting = new Seting_EweiShopV2Page();
		$setingInfo = $seting->getInfo(true);
		$surprisedData = array('yes' => $setingInfo['surprised_probability'], 'no' => 100 - $setingInfo['surprised_probability']);
		$surprised = $this->model->getRand($surprisedData);

		if ($surprised === 'yes') {
			$surprisedTable = 'ewei_open_farm_surprised';
			$where = array('uniacid' => $_W['uniacid']);
			$surprisedArr = pdo_getall($surprisedTable, $where);

			if (!$surprisedArr) {
				return $surprisedArr;
			}

			$probabilityArr = array();

			foreach ($surprisedArr as $key => $value) {
				$probabilityArr[$value['id']] = $value['probability'];
			}

			$prize = $this->model->getRand($probabilityArr);
			$userSurprised = 'ewei_open_farm_user_surprised';
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'surprised_id' => $prize, 'status' => '否', 'create_time' => date('Y-m-d H:i:s'));
			$query = pdo_insert($userSurprised, $data);
			return $query;
		}
	}

	/**
     * 添加用户经验值
     * @param $chicken
     * @return void
     */
	public function incExperience($chicken)
	{
		global $_W;
		$seting = new Seting_EweiShopV2Page();
		$setingInfo = $seting->getInfo(true);
		$number = $chicken['feeding_sum'] * $setingInfo['eat_experience'];
		$grade = new Grade_EweiShopV2Page();
		$gradeData = array('level' => $chicken['level'], 'experience' => $number + $chicken['experience']);
		$gradeData = $grade->checkLevel($gradeData);
		$where = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']);
		pdo_update($this->table, $gradeData, $where);
	}

	/**
     * 添加用户积分
     * @param $number
     * @return bool
     */
	public function incIntegral($number)
	{
		global $_W;
		$chicken = $this->getInfo(true);
		$gradeData = array('integral' => $chicken['integral'] + $number);
		$where = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']);
		$query = pdo_update($this->table, $gradeData, $where);
		return $query;
	}

	/**
     * 进食时间
     * @param $feed
     * @return float|int
     */
	public function calFeeding($feed)
	{
		global $_W;
		$seting = new Seting_EweiShopV2Page();
		$setingInfo = $seting->getInfo(true);
		$eatTime = (double) $setingInfo['eat_time'] * (double) $feed;
		$chicket = $this->getInfo(true);
		if (isset($chicket['accelerate']) && !empty($chicket['accelerate'])) {
			$eatTime -= (double) ($chicket['accelerate'] / 100 * $eatTime);
		}

		$eatTime = sprintf('%.2f', $eatTime);
		return $eatTime;
	}

	/**
     * 计算饲料数
     * @param $second
     * @return float|int
     */
	public function calFeed($second)
	{
		global $_W;
		$seting = new Seting_EweiShopV2Page();
		$setingInfo = $seting->getInfo(true);
		$feed = $second / $setingInfo['eat_time'];
		return $feed;
	}

	/**
     * 更新上次鸡蛋库存
     * @param $number
     * @return bool
     */
	public function updateLastEgg($number)
	{
		global $_W;
		$tableName = tablename($this->table);
		$sql = ' UPDATE ' . $tableName . ' SET ' . ('`last_egg_stock` = ' . $number . ' ') . (' WHERE `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ; ');
		$query = pdo_query($sql);
		return $query;
	}

	/**
     * 添加使用鸡蛋记录
     * @param $number
     */
	public function eggLog($number)
	{
		global $_W;
		$table = 'ewei_open_farm_egg';
		$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'sum' => $number, 'use_sum' => 0, 'status' => '否', 'receive' => '否', 'create_time' => date('Y-m-d H:i:s'));
		pdo_insert($table, $data);
	}

	/**
     * 给鸡喂食
     */
	public function feeding()
	{
		$chicken = $this->getInfo(true);
		$egg = 0;
		$bowl = 0;
		$surprised = array();
		$eggs = array();

		if ($chicken['feeding_sum']) {
			$now = time();
			$lately = strtotime($chicken['feeding_time']);
			$finish = $this->calFeeding($chicken['feeding_sum']);
			$reach = $lately + $finish;

			if ($reach <= $now) {
				$this->incExperience($chicken);
				$data = $this->updateFeed($chicken);
				$egg = $data['egg_sum'];
				$eggs = $data['eggs'];
				$surprised = $this->getSurprisedList();
				$this->feedingEnd();
				$data = $this->runFeeding($chicken);
				$time = $data['time'];
				$bowl = $data['bowl'];
			}
			else {
				$time = $reach - $now;
				$bowl = $this->calFeed($time);
				$chicken = array('bowl_stock' => $bowl);
				$where = array('openid' => $chicken['openid'], 'uniacid' => $chicken['uniacid']);
				pdo_update($this->table, $chicken, $where);
			}
		}
		else {
			$this->feedingEnd();
			$data = $this->runFeeding($chicken);
			$time = $data['time'];
			$bowl = $data['bowl'];
		}

		if (0 < $egg && 0 < count($eggs)) {
			foreach ($eggs as $value) {
				$this->eggLog($value);
				$presentation = new Presentation_EweiShopV2Page();
				$content = '主人主人,我吃完饲料下了 ' . $value . ' 颗蛋,一定要记得领取哦~';
				$presentation->addInfo($content);
			}
		}

		$surprisedSum = count($surprised);

		if (0 < $surprisedSum) {
			foreach ($surprised as $value) {
				$presentation = new Presentation_EweiShopV2Page();
				$content = '主人主人,恭喜你成功获得了 1 颗彩蛋,快打开看看吧~';
				$presentation->addInfo($content);
			}
		}

		$response = array('time' => $time < 0 ? 0 : $time, 'bowl' => $bowl < 0 ? 0 : $bowl, 'egg' => $egg < 0 ? 0 : $egg, 'eggs' => $eggs, 'surprised' => $surprised);
		$this->model->returnJson($response);
	}

	/**
     * 验证吃完饲料
     */
	public function checkFeedingEnd()
	{
		$chicken = $this->getInfo(true);
		$egg = 0;
		$surprised = array();
		$eggs = array();

		if ($chicken['feeding_sum']) {
			$now = time();
			$lately = strtotime($chicken['feeding_time']);
			$finish = $this->calFeeding($chicken['feeding_sum']);
			$reach = $lately + $finish;

			if ($reach <= $now) {
				$this->incExperience($chicken);
				$data = $this->updateFeed($chicken);
				$egg = $data['egg_sum'];
				$eggs = $data['eggs'];
				$surprised = $this->getSurprisedList();
				$this->feedingEnd();
				$time = 0;
				$bowl = 0;
			}
			else {
				$time = $reach - $now;
				$bowl = $this->calFeed($time);
				$chicken = array('bowl_stock' => $bowl);
				$where = array('openid' => $chicken['openid'], 'uniacid' => $chicken['uniacid']);
				pdo_update($this->table, $chicken, $where);
			}
		}
		else {
			$time = 0;
			$bowl = 0;
		}

		if (0 < $egg && 0 < count($eggs)) {
			foreach ($eggs as $value) {
				$this->eggLog($value);
				$presentation = new Presentation_EweiShopV2Page();
				$content = '主人主人,我吃完饲料下了 ' . $value . ' 颗蛋,一定要记得领取哦~';
				$presentation->addInfo($content);
			}
		}

		$surprisedSum = count($surprised);

		if (0 < $surprisedSum) {
			foreach ($surprised as $value) {
				$presentation = new Presentation_EweiShopV2Page();
				$content = '主人主人,恭喜你成功获得了 1 颗彩蛋,快打开看看吧~';
				$presentation->addInfo($content);
			}
		}

		$response = array('time' => $time < 0 ? 0 : $time, 'bowl' => $bowl < 0 ? 0 : $bowl, 'egg' => $egg < 0 ? 0 : $egg, 'eggs' => $eggs, 'surprised' => $surprised);
		$this->model->returnJson($response);
	}

	/**
     * 吃完饲料
     */
	public function feedingEnd()
	{
		global $_W;
		$data = array('feeding_time' => '0000-00-00 00:00:00', 'bowl_stock' => 0, 'feeding_sum' => 0);
		$where = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']);
		pdo_update($this->table, $data, $where);
	}

	/**
     * 查询所有没有提示过的彩蛋
     */
	public function getSurprisedList($mode = false)
	{
		global $_W;
		$seting = new Seting_EweiShopV2Page();
		$seting = $seting->getInfo(true);
		$chicken = $this->getInfo(true);
		$invalid = $seting['surprised_invalid_time'] + $chicken['surprised_guard'];
		$limit = date('Y-m-d H:i:s', strtotime(' - ' . $invalid . ' hours '));
		$table = 'ewei_open_farm_user_surprised';
		$tableName = tablename($table);
		$sql = ' DELETE FROM ' . $tableName . ' ' . (' WHERE `create_time` < \'' . $limit . '\' ') . (' AND `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . ' AND `receive` = \'否\' ';
		pdo_query($sql);
		$table = 'ewei_open_farm_user_surprised';
		$where = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'status' => '否');
		$infoList = pdo_getall($table, $where);
		$infoList = $this->getSurprisedDetails($infoList);
		$data = array('status' => '是');
		pdo_update($table, $data, $where);

		foreach ($infoList as $key => $val) {
			if (empty($val)) {
				unset($infoList[$key]);
			}
		}

		$infoList = array_values($infoList);

		if (!count($infoList)) {
			$infoList = array();
		}

		return $infoList;
	}

	/**
     * 获取彩蛋的详情
     * @param $data
     * @return array
     */
	public function getSurprisedDetails($data)
	{
		global $_W;
		if ($data && 0 < count($data)) {
			foreach ($data as $key => $value) {
				$surprised = $this->surprisedInfo($value['surprised_id']);

				switch ($surprised['category']) {
				case '优惠券':
					$table = 'ewei_shop_coupon';
					$where = array('id' => $surprised['value']);
					$fields = array('couponname', 'enough', 'backtype', 'deduct', 'discount', 'backmoney', 'backcredit', 'backredpack', 'total');
					$info = pdo_get($table, $where, $fields);
					$gettotal = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and uniacid=:uniacid limit 1', array(':couponid' => $surprised['value'], ':uniacid' => $_W['uniacid']));
					$left_count = $info['total'] - $gettotal;
					$left_count = intval($left_count);
					if ($info['total'] != -1 && $left_count <= 0) {
						unset($data[$key]);
					}
					else {
						$data[$key] = array_merge($data[$key], $surprised, $info);
					}

					break;

				case '积分':
					$data[$key] = array_merge($data[$key], $surprised);
					break;

				default:
					break;
				}
			}
		}

		return array_values($data);
	}

	/**
     * 查询彩蛋详情
     * @param $id
     * @return bool
     */
	public function surprisedInfo($id)
	{
		$table = 'ewei_open_farm_surprised';
		$where = array('id' => $id);
		$field = array('category', 'value');
		$query = pdo_get($table, $where, $field);
		return $query;
	}

	/**
     * 喂食
     * @param $chicken
     * @return array
     */
	public function runFeeding($chicken)
	{
		global $_W;
		$seting = new Seting_EweiShopV2Page();
		$seting = $seting->getInfo(true);
		$bowl = $seting['bowl'] < $chicken['feed_stock'] ? $seting['bowl'] : $chicken['feed_stock'];
		$data = array();
		$time = $this->calFeeding($bowl);
		$data['feeding_time'] = date('Y-m-d H:i:s');
		$data['feeding_sum'] = $bowl;
		$data['lay_eggs_eat'] = $seting['lay_eggs_eat'];
		$data['bowl_stock'] = $bowl;
		$where = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']);
		pdo_update($this->table, $data, $where);
		$data = array('bowl' => $bowl, 'time' => $time);
		$this->redFeed($bowl);
		return $data;
	}

	/**
     * 获取彩蛋
     * @param bool $method
     * @return array|bool
     */
	public function getSurprised($method = false)
	{
		global $_W;
		$seting = new Seting_EweiShopV2Page();
		$seting = $seting->getInfo(true);
		$chicken = $this->getInfo(true);
		$invalid = $seting['surprised_invalid_time'] + $chicken['surprised_guard'];
		$limit = date('Y-m-d H:i:s', strtotime(' - ' . $invalid . ' hours '));
		$table = 'ewei_open_farm_user_surprised';
		$tableName = tablename($table);
		$sql = ' DELETE FROM ' . $tableName . ' ' . (' WHERE `create_time` < \'' . $limit . '\' ') . (' AND `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . ' AND `receive` = \'否\' ';
		pdo_query($sql);
		$sql = ' SELECT * FROM ' . $tableName . ' ' . (' WHERE `uniacid` = ' . $_W['uniacid'] . ' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . ' AND `receive` = \'否\' ' . ' ORDER BY `id` ASC ';
		$query = pdo_fetch($sql);
		$surprisedInfo = $this->surprisedInfo($query['surprised_id']);
		$query = array_merge($query, $surprisedInfo);

		if ($query['category'] === '优惠券') {
			$table = 'ewei_shop_coupon';
			$where = array('id' => $surprisedInfo['value']);
			$fields = array('couponname', 'enough', 'backtype', 'deduct', 'discount', 'backmoney', 'backcredit', 'backredpack', 'total');
			$info = pdo_get($table, $where, $fields);
			$gettotal = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and uniacid=:uniacid limit 1', array(':couponid' => $surprisedInfo['value'], ':uniacid' => $_W['uniacid']));
			$left_count = $info['total'] - $gettotal;
			$left_count = intval($left_count);
			if ($info['total'] != -1 && $left_count <= 0) {
				$query = array();
			}
			else {
				$query = array_merge($query, $info);
			}
		}

		if ($method) {
			return $query;
		}

		$this->model->returnJson($query);
	}

	/**
     * 领取优惠券
     */
	public function coupon()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['__input']['id'];
		$dataid = $_GPC['__input']['dataid'];
		$category = $_GPC['__input']['category'];
		$surprisedId = $_GPC['__input']['surprised_id'];
		$table = 'ewei_open_farm_user_surprised';
		$url = false;
		$where = array('id' => $id);
		$data = array('receive' => '是', 'status' => '是');
		$query = pdo_update($table, $data, $where);
		$table = 'ewei_open_farm_surprised';
		$where = array('id' => $surprisedId);
		$surprised = pdo_get($table, $where);

		if ($category === '积分') {
			m('member')->setCredit($_W['openid'], 'credit1', $surprised['value'], array(0, '农场积分彩蛋'));
		}
		else {
			$data = array('id' => $dataid);
			$url = mobileUrl('sale/coupon/my/detail', $data, true);
		}

		if ($query !== false) {
			$this->model->returnJson(true, false, false, $url);
		}

		$this->model->returnJson($query, false, false, $url);
	}

	/**
     * 查询所有没有提示过的彩蛋
     * @param bool $method
     * @return int
     */
	public function getEggs($method = false)
	{
		global $_W;
		$seting = new Seting_EweiShopV2Page();
		$seting = $seting->getInfo(true);
		$limit = date('Y-m-d H:i:s', strtotime(' - ' . $seting['egg_invalid_time'] . ' hours '));
		$table = 'ewei_open_farm_egg';
		$tableName = tablename($table);
		$sql = ' SELECT * FROM ' . $tableName . (' WHERE `create_time` >= \'' . $limit . '\' ') . (' AND `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . ' AND `receive` = \'否\' ' . ' AND `status` = \'否\' ';
		$eggArr = pdo_fetchall($sql);
		$eggSum = 0;

		foreach ($eggArr as $key => $value) {
			$eggSum += $value['sum'];
		}

		if ($method) {
			return $eggSum;
		}

		$this->model->returnJson($eggSum);
	}

	/**
     * 领取鸡蛋
     */
	public function receiveEgg()
	{
		global $_W;
		$seting = new Seting_EweiShopV2Page();
		$seting = $seting->getInfo(true);
		$limit = date('Y-m-d H:i:s', strtotime(' - ' . $seting['egg_invalid_time'] . ' hours '));
		$table = 'ewei_open_farm_egg';
		$tableName = tablename($table);
		$sql = ' SELECT * FROM ' . $tableName . (' WHERE `create_time` >= \'' . $limit . '\' ') . (' AND `uniacid` = \'' . $_W['uniacid'] . '\' ') . (' AND `openid` = \'' . $_W['openid'] . '\' ') . ' AND `receive` = \'否\' ' . ' AND `status` = \'否\' ';
		$eggArr = pdo_fetchall($sql);
		$eggSum = 0;
		$eggIdArr = array();

		foreach ($eggArr as $key => $value) {
			$eggSum += $value['sum'];
			$eggIdArr[] = $value['id'];
		}

		$idStr = implode(',', $eggIdArr);
		$this->receiveEggLog($idStr);
		$this->incEggs($eggSum);
		$chicken = $this->getInfo(true);
		$this->updateLastEgg($chicken['egg_stock']);
		pdo_query($sql);
		$this->model->returnJson($eggSum);
	}

	/**
     * 更新蛋日志
     * @param $idStr
     */
	public function receiveEggLog($idStr)
	{
		$sql = ' UPDATE `ims_ewei_open_farm_egg` ' . ' SET `receive` = \'是\' ' . (' WHERE `id` IN (' . $idStr . '); ');
		pdo_query($sql);
	}

	/**
     * 异步下载头像
     */
	public function downloadPortrait()
	{
		$chicken = $this->getInfo(true);
		$saveFolder = __DIR__ . '/../../static/mobile/portrait/';

		if (!file_exists($saveFolder)) {
			mkdir($saveFolder);
		}

		$filePath = $saveFolder . $chicken['uniacid'] . '-' . $chicken['openid'] . '.jpg';

		if (!is_file($filePath)) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $chicken['portrait']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			$file = curl_exec($ch);
			curl_close($ch);
			$resource = fopen($filePath, 'a');
			fwrite($resource, $file);
			fclose($resource);
		}
	}
}

?>
