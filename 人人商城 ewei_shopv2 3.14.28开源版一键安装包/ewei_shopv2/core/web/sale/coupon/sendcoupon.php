<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Sendcoupon_EweiShopV2Page extends ComWebPage
{
	public function __construct($_com = 'coupon')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$couponid = intval($_GPC['couponid']);
		$coupon = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE id=:id and uniacid=:uniacid and merchid=0', array(':id' => $couponid, ':uniacid' => $_W['uniacid']));
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_level') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY level asc'));
		$list2 = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_group') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY id asc'));
		$coupons = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_coupon') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and merchid=0 and isfriendcoupon = 0  ORDER BY id asc'));
		$hascommission = false;
		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();
			$hascommission = !empty($plugin_com_set['level']);
		}

		$hasglobonus = false;
		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !empty($plugin_globonus_set['open']);
		}

		$hasabonus = false;
		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !empty($plugin_abonus_set['open']);
		}

		if ($hascommission) {
			$list3 = $plugin_com->getLevels();
		}

		if ($hasglobonus) {
			$list4 = $plugin_globonus->getLevels();
		}

		if ($hasabonus) {
			$list5 = $plugin_abonus->getLevels();
		}

		$data = m('common')->getPluginset('coupon');
		m('common')->updatePluginset(array('coupon' => $data));
		load()->func('tpl');
		include $this->template();
	}

	public function fetch()
	{
		global $_W;
		global $_GPC;
		$couponid = intval($_GPC['couponid']);
		$class1 = $_GPC['send1'];
		$coupon = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE id=:id and uniacid=:uniacid and merchid=0', array(':id' => $couponid, ':uniacid' => $_W['uniacid']));

		if (empty($coupon)) {
			show_json(0, '未找到优惠券!');
		}

		$send_total = intval($_GPC['send_total']);

		if (empty($send_total)) {
			show_json(0, '发送数量最小为1!');
		}

		if ($class1 == 1) {
			$send_openid = $_GPC['send_openid'];
			$openids = explode(',', $send_openid);
			$plog = '发放优惠券 ID: ' . $couponid . ' 方式: 指定 OPENID 人数: ' . count($openids);
		}
		else if ($class1 == 2) {
			$where = '';

			if (!empty($_GPC['send_level'])) {
				$where .= ' and level =' . intval($_GPC['send_level']);
			}

			$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\'') . $where, array(), 'openid');

			if (!empty($_GPC['send_level'])) {
				$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_member_level') . ' where id=:id limit 1', array(':id' => $_GPC['send_level']));
			}
			else {
				$levelname = '全部';
			}

			$openids = array_keys($members);
			$plog = '发放优惠券 ID: ' . $couponid . ' 方式: 等级-' . $levelname . ' 人数: ' . count($members);
		}
		else if ($class1 == 3) {
			$where = '';

			if (!empty($_GPC['send_group'])) {
				$where .= ' and groupid =' . intval($_GPC['send_group']);
			}

			$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\'') . $where, array(), 'openid');

			if (!empty($_GPC['send_group'])) {
				$groupname = pdo_fetchcolumn('select groupname from ' . tablename('ewei_shop_member_group') . ' where id=:id limit 1', array(':id' => $_GPC['send_group']));
			}
			else {
				$groupname = '全部分组';
			}

			$openids = array_keys($members);
			$plog = '发放优惠券 ID: ' . $couponid . '  方式: 分组-' . $groupname . ' 人数: ' . count($members);
		}
		else if ($class1 == 4) {
			$where = '';
			$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\'') . $where, array(), 'openid');
			$openids = array_keys($members);
			$plog = '发放优惠券 ID: ' . $couponid . '  方式: 全部会员 人数: ' . count($members);
		}
		else if ($class1 == 5) {
			$where = '';
			if (!empty($_GPC['send_agentlevel']) || $_GPC['send_partnerlevels'] === '0') {
				$where .= ' and agentlevel =' . intval($_GPC['send_agentlevel']);
			}

			$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and isagent=1 and status=1 ') . $where, array(), 'openid');

			if ($_GPC['send_agentlevel'] != '') {
				$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_commission_level') . ' where id=:id limit 1', array(':id' => $_GPC['send_agentlevel']));
			}
			else {
				$levelname = '全部';
			}

			$openids = array_keys($members);
			$plog = '发放优惠券 ID: ' . $couponid . '  方式: 分销商-' . $levelname . ' 人数: ' . count($members);
		}
		else if ($class1 == 6) {
			$where = '';
			if (!empty($_GPC['send_partnerlevels']) || $_GPC['send_partnerlevels'] === '0') {
				$where .= ' and partnerlevel =' . intval($_GPC['send_partnerlevels']);
			}

			$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and ispartner=1 and partnerstatus=1 ') . $where, array(), 'openid');

			if ($_GPC['send_partnerlevels'] != '') {
				$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_globonus_level') . ' where id=:id limit 1', array(':id' => $_GPC['send_partnerlevels']));
			}
			else {
				$levelname = '全部';
			}

			$openids = array_keys($members);
			$plog = '发放优惠券 ID: ' . $couponid . '  方式: 股东-' . $levelname . ' 人数: ' . count($members);
		}
		else {
			if ($class1 == 7) {
				$where = '';
				if (!empty($_GPC['send_aagentlevels']) || $_GPC['send_aagentlevels'] === '0') {
					$where .= ' and aagentlevel =' . intval($_GPC['send_aagentlevels']);
				}

				$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and isaagent=1 and aagentstatus=1 ') . $where, array(), 'openid');

				if ($_GPC['send_aagentlevels'] != '') {
					$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_abonus_level') . ' where id=:id limit 1', array(':id' => $_GPC['send_aagentlevels']));
				}
				else {
					$levelname = '全部';
				}

				$openids = array_keys($members);
				$plog = '发放优惠券 ID: ' . $couponid . '  方式: 区域代理-' . $levelname . ' 人数: ' . count($members);
			}
		}

		$mopenids = array();

		foreach ($openids as $openid) {
			$mopenids[] = '\'' . str_replace('\'', '\'\'', $openid) . '\'';
		}

		if (empty($mopenids)) {
			show_json(0, '未找到发送的会员!');
		}

		$members = pdo_fetchall('select id,openid,nickname from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $mopenids) . (') and uniacid=' . $_W['uniacid']));

		if (empty($members)) {
			show_json(0, '未找到发送的会员!');
		}

		if ($coupon['total'] != -1) {
			$last = com('coupon')->get_last_count($couponid);

			if ($last <= 0) {
				show_json(0, '优惠券数量不足,无法发放!');
			}

			$need = count($members) - $last;

			if (0 < $need) {
				show_json(0, '优惠券数量不足,请补充 ' . $need . ' 张优惠券才能发放!');
			}
		}

		$data = array('sendtemplateid' => $_GPC['sendtemplateid'], 'frist' => $_GPC['frist'], 'fristcolor' => $_GPC['fristcolor'], 'keyword1' => $_GPC['keyword1'], 'keyword1color' => $_GPC['keyword1color'], 'keyword2' => $_GPC['keyword2'], 'keyword2color' => $_GPC['keyword2color'], 'remark' => $_GPC['remark'], 'remarkcolor' => $_GPC['remarkcolor'], 'templateurl' => $_GPC['templateurl'], 'custitle' => $_GPC['custitle'], 'custhumb' => $_GPC['custhumb'], 'cusdesc' => $_GPC['cusdesc'], 'cusurl' => $_GPC['cusurl']);
		m('common')->updatePluginset(array('coupon' => $data));
		$time = time();

		foreach ($members as $m) {
			$i = 1;

			while ($i <= $send_total) {
				$log = array('uniacid' => $_W['uniacid'], 'merchid' => $coupon['merchid'], 'openid' => $m['openid'], 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $couponid, 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => $time, 'getfrom' => 0);
				pdo_insert('ewei_shop_coupon_log', $log);
				$logid = pdo_insertid();
				$data = array('uniacid' => $_W['uniacid'], 'merchid' => $coupon['merchid'], 'openid' => $m['openid'], 'couponid' => $couponid, 'gettype' => 0, 'gettime' => $time, 'senduid' => $_W['uid']);
				pdo_insert('ewei_shop_coupon_data', $data);
				++$i;
			}
		}

		show_json(1, array('openids' => $openids));
	}

	public function sendmessage()
	{
		global $_GPC;
		global $_W;
		$openid = $_GPC['openid'];
		$messagetype = intval($_GPC['messagetype']);
		$couponid = intval($_GPC['couponid']);
		$data = m('common')->getPluginset('coupon');

		if (empty($messagetype)) {
			exit(json_encode(array('result' => 0)));
		}
		else if ($messagetype == 1) {
			if (empty($data['sendtemplateid'])) {
				exit(json_encode(array('result' => 0, 'mesage' => '未指设定发送模板!', 'openid' => $openid)));
			}

			if (empty($openid)) {
				exit(json_encode(array('result' => 0, 'mesage' => '未指定openid!', 'openid' => $openid)));
			}

			$msg = array(
				'first'  => array('value' => $data['frist'], 'color' => $data['fristcolor']),
				'remark' => array('value' => $data['remark'], 'color' => $data['remarkcolor'])
				);
			$msg['keyword1'] = array('value' => '会员通知', 'color' => $data['keyword1color']);
			$msg['keyword2'] = array('value' => $data['keyword1'], 'color' => $data['keyword1color']);
			$msg['keyword3'] = array('value' => $data['keyword2'], 'color' => $data['keyword2color']);

			if (empty($data['templateurl'])) {
				$data['templateurl'] = mobileUrl('sale/coupon/my', NULL, true);
			}

			$result = m('message')->sendTplNotice($openid, $data['sendtemplateid'], $msg, $data['templateurl']);

			if (is_error($result)) {
				exit(json_encode(array('result' => 0, 'message' => $result['message'], 'openid' => $openid)));
			}

			exit(json_encode(array('result' => 1)));
		}
		else if ($messagetype == 2) {
			if (empty($openid)) {
				exit(json_encode(array('result' => 0, 'mesage' => '未指定openid!', 'openid' => $openid)));
			}

			if (empty($data['cusurl'])) {
				$data['cusurl'] = mobileUrl('sale/coupon/my', NULL, true);
			}

			$resp = $this->sendNews($openid, $data['custitle'], $data['cusdesc'], $data['cusurl'], $data['custhumb']);

			if (is_error($resp)) {
				exit(json_encode(array('result' => 0, 'message' => $resp['message'], 'openid' => $openid)));
			}

			exit(json_encode(array('result' => 1)));
		}
		else {
			exit(json_encode(array('result' => 0)));
		}
	}

	public function sendNews($openid, $title, $desc, $url, $picurl, $account = NULL)
	{
		global $_W;
		$result = false;
		$articles[] = array('title' => urlencode($title), 'description' => urlencode($desc), 'url' => $url, 'picurl' => tomedia($picurl));
		$result = m('message')->sendNews($openid, $articles, $account);
		return $result;
	}
}

?>
