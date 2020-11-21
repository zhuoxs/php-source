<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;

		if (!empty($_W['shopversion'])) {
			header('location: ' . webUrl('member/list'));
			exit();
		}

		include $this->template();
	}

	protected function selectMemberCreate($day = 0)
	{
		global $_W;
		$day = (int) $day;

		if ($day != 0) {
			$createtime1 = strtotime(date('Y-m-d', time() - $day * 3600 * 24));
			$createtime2 = strtotime(date('Y-m-d', time()));
		}
		else {
			$createtime1 = strtotime(date('Y-m-d', time()));
			$createtime2 = strtotime(date('Y-m-d', time() + 3600 * 24));
		}

		$sql = 'select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid = :uniacid and createtime between :createtime1 and :createtime2';
		$param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		return pdo_fetchcolumn($sql, $param);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid';

		if (!empty($_GPC['no_wa'])) {
			$condition .= ' and openid not like \'sns_wa_%\'';
		}

		if (!empty($kwd)) {
			$condition .= ' AND (`realname` LIKE :keyword or `nickname` LIKE :keyword or `mobile` LIKE :keyword or `openid` LIKE :keyword)';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member') . (' WHERE 1 ' . $condition . ' order by id asc'), $params);

		foreach ($ds as &$value) {
			$value['nickname'] = htmlspecialchars($value['nickname'], ENT_QUOTES);
			$value['nickname_wechat'] = htmlspecialchars($value['nickname_wechat'], ENT_QUOTES);
		}

		unset($value);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template('member/query');
	}

	protected function ajaxnewmember($day = 0)
	{
		global $_GPC;
		global $_W;
		$day = (int) $day;

		if (isset($_GPC['day'])) {
			$day = (int) $_GPC['day'];
		}

		$param = array(':uniacid' => $_W['uniacid']);
		$member_count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid', $param);
		$newmember = $this->selectMemberCreate($day);
		return array('count' => (int) $newmember, 'rate' => empty($member_count) ? 0 : (int) number_format(round($newmember / $member_count, 3) * 100));
	}

	protected function ajaxmembergender()
	{
		global $_W;
		$gender_array = array(0, 0, 0);
		$sql_member = 'select gender,count(gender) as gender_num from ' . tablename('ewei_shop_member') . ' where uniacid = :uniacid group by gender';
		$param_member = array(':uniacid' => $_W['uniacid']);
		$member = pdo_fetchall($sql_member, $param_member);

		foreach ($member as $key => $val) {
			if ($val['gender'] == -1) {
				$gender_array[0] += (int) $val['gender_num'];
			}
			else {
				$gender_array[$val['gender']] += (int) $val['gender_num'];
			}
		}

		return $gender_array;
	}

	protected function ajaxmemberlevel()
	{
		global $_W;
		$levels = pdo_fetchall('select * from ' . tablename('ewei_shop_member_level') . ' where uniacid=:uniacid order by level asc', array(':uniacid' => $_W['uniacid']), 'id');
		$levelname = array();

		foreach ($levels as $l) {
			$levelname[$l['id']] = $l['levelname'];
		}

		$levelname[0] = '普通等级';
		ksort($levelname);
		$sql_level = 'select level,count(level) as level_num from ' . tablename('ewei_shop_member') . ' where uniacid = :uniacid group by level';
		$param_level = array(':uniacid' => $_W['uniacid']);
		$member_level = pdo_fetchall($sql_level, $param_level);
		$levels_array = array();

		foreach ($levelname as $lkey => $lvalue) {
			$levels_array[$lkey] = 0;
		}

		foreach ($member_level as $key => $val) {
			if (array_key_exists($val['level'], $levelname)) {
				$levels_array[$val['level']] = $val['level_num'];
			}
			else {
				$levels_array[0] += $val['level_num'];
			}
		}

		if (!array_key_exists(0, $levels_array)) {
			$levels_array[0] = 0;
		}

		$count = array_values($levels_array);
		$name = array_values($levelname);
		$res = array();

		foreach ($count as $key => $value) {
			$res[$key]['value'] = $value;
			$res[$key]['name'] = $name[$key];
		}

		return array('count' => $count, 'name' => $name, 'data' => $res);
	}

	protected function ajaxprovince()
	{
		global $_W;
		$province = pdo_fetchall('select province,count(province) as province_num from ' . tablename('ewei_shop_member') . ' where uniacid = :uniacid group by province', array(':uniacid' => $_W['uniacid']));
		$result = array();

		foreach ($province as $array) {
			$array['province'] = preg_replace('/(市|省)(.*)/', '', $array['province']);
			$res = array('name' => $array['province'], 'value' => (int) $array['province_num']);
			$result[] = $res;
		}

		return $result;
	}

	public function ajaxall()
	{
		echo json_encode(array('ajaxmembergender' => $this->ajaxmembergender(), 'ajaxmemberlevel' => $this->ajaxmemberlevel(), 'ajaxprovince' => $this->ajaxprovince(), 'ajaxnewmember0' => $this->ajaxnewmember(0), 'ajaxnewmember1' => $this->ajaxnewmember(1), 'ajaxnewmember7' => $this->ajaxnewmember(7)));
	}
}

?>
