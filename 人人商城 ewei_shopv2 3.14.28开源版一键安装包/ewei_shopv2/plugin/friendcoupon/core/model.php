<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class FriendcouponModel extends PluginModel
{
	const WXAPP_PREFIX = 'wxapp_';
	const SWITCH_SUFFIX = '_switch';

	public $errmsg;
	public $errno = 0;

	/**
     * 获取用户的瓜分券
     * @param $friendcouponid
     * @param $openid
     * @return bool
     */
	public function getFriendCoupon($openid, $friendcouponid)
	{
		global $_W;
		return pdo_fetch('select * from ' . tablename('ewei_shop_coupon_data') . ' where uniacid = :uniacid and openid = :openid and friendcouponid = :friendcoupoinid', array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':friendcouponid' => $friendcouponid));
	}

	/**
     * 获取活动列表
     */
	public function getActivityList()
	{
		global $_W;
		return pdo_fetchall('select * from ' . tablename('ewei_shop_friendcoupon') . ' where uniacid = :uniacid and deleted = :deleted order by create_time desc', array(':uniacid' => $_W['uniacid'], ':deleted' => 0));
	}

	public function avgCouponAlgorithm($coupon_money, $people_count)
	{
		$avg_amount = floor($coupon_money / $people_count * 100) / 100;
		$previous = array_fill(0, $people_count - 1, $avg_amount);
		$last_one = $coupon_money - $avg_amount * ($people_count - 1);
		$ret = array_merge(array($last_one), $previous);
		shuffle($ret);
		return $ret;
	}

	/**
     * @param $total
     * @param $num
     * @param float $min
     * @return array
     */
	public function randomCouponAlgorithm($total, $num, $min = 0.01)
	{
		$overPlus = $total - $num * $min;
		$base = 0;
		$container = array();
		$i = 0;

		while ($i < $num) {
			$weight = round(lcg_value() * 1000);
			$container[$i]['weight'] = $weight;
			$container[$i]['money'] = $min;
			$base += $weight;
			++$i;
		}

		$len = $num - 1;
		$i = 0;

		while ($i < $len) {
			$money = floor($container[$i]['weight'] / $base * $overPlus * 100) / 100;
			$container[$i]['money'] += $money;
			++$i;
		}

		array_pop($container);
		$result = array_column($container, 'money');
		$last_one = round($total - array_sum($result), 2);
		array_push($result, $last_one);
		return $result;
	}

	/**
     * 检查用户是否参加过这个活动
     * @param $openid string 用户Openid
     * @param $activity_id int 活动id
     * @return bool|false 返回参加过的活动|false
     */
	public function isJoinActivity($openid, $activity_id)
	{
		global $_W;
		return pdo_fetch('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and openid = :openid and activity_id = :activity_id', array(':openid' => $openid, ':uniacid' => $_W['uniacid'], ':activity_id' => $activity_id));
	}

	/**
     * 获取当前用户参加的活动的信息
     * @param $openid
     * @param $activity_id
     * @return bool
     */
	public function getCurrentActivityInfo($openid, $activity_id)
	{
		global $_W;
		return pdo_fetch('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and openid = :openid and activity_id = :activity_id', array(':openid' => $openid, ':uniacid' => $_W['uniacid'], ':activity_id' => $activity_id));
	}

	/**
     * 获取当前正在进行的活动
     * @param $activity_id
     * @param $headerid
     * @return array|false 返回正在进行的活动,如果没有返回false
     */
	public function getOngoingActivities($activity_id, $headerid)
	{
		global $_W;
		return pdo_fetchall('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and activity_id = :activity_id and headerid = :headerid', array(':headerid' => $headerid, ':activity_id' => $activity_id, ':uniacid' => $_W['uniacid']));
	}

	/**
     * 获取活动,不传入id返回所有活动
     * @param int $id
     * @return array|bool
     */
	public function getActivity($id = NULL)
	{
		global $_W;
		$table = tablename('ewei_shop_friendcoupon');

		if (is_null($id)) {
			return pdo_fetchall('select * from ' . $table . ' where uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		}

		return pdo_fetch('select * from ' . $table . ' where id  = :id', array(':id' => $id));
	}

	/**
     * 验证活动有效性,验证成功返回活动,验证失败返回false
     * @param $verifyItem array|int
     * @return bool|array
     */
	public function validateActivity($id)
	{
		$activity = $this->getActivity($id);
		$time = time();

		if (!$activity) {
			$this->errmsg = '活动不存在';
			return false;
		}

		if ($time < $activity['activity_start_time']) {
			$this->errmsg = '活动未开始！';
			return false;
		}

		if ($activity['activity_end_time'] < $time || !empty($activity['stop_time']) && $activity['stop_time'] < $time) {
			$this->errno = -10001;
			$this->errmsg = '活动已经结束！<br>下次早点来啊~!';
			return false;
		}

		if ((int) $activity['launches_limit'] === (int) $activity['launches_count']) {
			$this->errno = -10002;
			$this->errmsg = '活动已经没有可发起次数!';
			return false;
		}

		if ((int) $activity['status'] === -1) {
			$this->errmsg = '当前活动已经失效！';
			return false;
		}

		return $activity;
	}

	/**
     * 下发好友瓜分券
     * @param $coupons array,已经成功的瓜分券接口
     * @return bool
     */
	public function sendFriendCoupon($coupons)
	{
		global $_W;

		try {
			foreach ($coupons as $coupon) {
				$data = array('uniacid' => $_W['uniacid'], 'couponname' => '瓜分券', 'enough' => $coupon['enough'], 'deduct' => $coupon['deduct'], 'timelimit' => $coupon['use_time_limit'], 'timestart' => $coupon['use_start_time'], 'timeend' => $coupon['use_end_time'], 'timedays' => $coupon['use_valid_days'], 'createtime' => time(), 'total' => 1, 'coupontype' => 0, 'limitdiscounttype' => $coupon['limitdiscounttype'], 'limitgoodcatetype' => $coupon['limitgoodcatetype'], 'limitgoodcateids' => $coupon['limitgoodcateids'], 'limitgoodtype' => $coupon['limitgoodtype'], 'limitgoodids' => $coupon['limitgoodids'], 'isfriendcoupon' => 1);
				pdo_insert('ewei_shop_coupon', $data);
				$insert_id = pdo_insertid();
				$data['openid'] = $coupon['openid'];
				$data['friendcouponid'] = $coupon['friendcouponid'];
				$couponData[$insert_id] = $data;
			}

			foreach ($couponData as $id => $coupon) {
				$data = array('couponid' => $id, 'uniacid' => $_W['uniacid'], 'gettype' => 0, 'openid' => $coupon['openid'], 'gettime' => time(), 'friendcouponid' => $coupon['friendcouponid']);
				pdo_insert('ewei_shop_coupon_data', $data);
			}
		}
		catch (Exception $e) {
			$this->errmsg = '优惠券下发失败';
			return false;
		}

		return true;
	}

	/**
     * 验证数组是否为多维数组
     * @param $array
     * @return bool
     */
	protected function isMultiArray($array)
	{
		if (!is_array($array)) {
			return false;
		}

		return count($array) === count($array, 1);
	}

	public function dateFormat($timestamp, $format = 'Y-m-d H:i:s')
	{
		return date($format, $timestamp);
	}

	public function getTakePartUserData($activity_id, $headerid)
	{
		global $_W;
		return pdo_fetchall('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and headerid = :headerid and activity_id = :activity_id and openid <> \'\'', array(':uniacid' => $_W['uniacid'], ':headerid' => $headerid, ':activity_id' => $activity_id));
	}

	public function isSuccess($activity_id, $headerid)
	{
		return count($this->getTakePartUserData($activity_id, $headerid)) == $this->getActivity($activity_id)['people_count'];
	}

	/**
     * 根据openid获取用户
     * @param $openid
     * @return bool|array
     */
	public function getMember($openid)
	{
		global $_W;
		return pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where uniacid = :uniacid and openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
	}

	public function getTakePartInPeopleData($activity_id, $headerid)
	{
		global $_W;
		$r = pdo_fetchall('select * from ' . tablename('ewei_shop_friendcoupon_data') . ' where uniacid = :uniacid and headerid = :headerid and activity_id = :activity_id', array(':uniacid' => $_W['uniacid'], ':headerid' => $headerid, ':activity_id' => $activity_id));
	}

	/**
     * 引入随机优惠券算法
     */
	public function import_redPackBuilder()
	{
		$path = IA_ROOT . '/addons/ewei_shopv2/plugin/friendcoupon/core/redPackBuilder.php';
		require_once $path;
	}

	/**
     * 获取微信的模板消息,公众号的可以通过m('notice')->sendNotice()方法解决
     * @param $type
     * @return array|bool
     */
	public function getTemplateMessage($type)
	{
		global $_W;
		$allowTypes = array('complete');

		if (!in_array($type, $allowTypes)) {
			return false;
		}

		$typecode = 'friendcoupon_' . $type;
		$commonModel = m('common');
		$set = $commonModel->getSysset('notice');
		$key = static::WXAPP_PREFIX . $type;
		$switch_key = $key . static::SWITCH_SUFFIX;
		$data = array('messageId' => $set[$key] ?: 'default', 'isOpen' => !$set[$switch_key]);

		if (!$data['isOpen']) {
			return false;
		}

		if ($data['messageId'] == 'default') {
			return pdo_fetch('select * from ' . tablename('ewei_shop_member_wxapp_message_template_default') . ' where uniacid = :uniacid and typecode = :typecode', array(':uniacid' => $_W['uniacid'], ':typecode' => $typecode));
		}

		return pdo_fetch('select * from ' . tablename('ewei_shop_wxapp_tmessage') . ' where id = :id', array('id' => $data['messageId']));
	}

	/**
     * 获取公众号或者小程序token
     * @param bool $wxapp
     * @return mixed
     */
	public function getToken($wxapp = false)
	{
		if ($wxapp) {
			return p('app')->getAccessToken();
		}

		return m('common')->getAccount()->fetch_token();
	}
}

?>
