<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Coupon_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (empty($uid)) {
			mc_oauth_userinfo($openid);
		}

		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$groupsset = pdo_fetch('select description,groups_description,discount,headstype,headsmoney,headsdiscount,followbar from ' . tablename('ewei_shop_groups_set') . 'where uniacid = :uniacid ', array(':uniacid' => $uniacid));
		$groupsset['groups_description'] = m('ui')->lazy($groupsset['groups_description']);
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $uniacid, ':status' => 1));
		if (empty($id) || empty($goods)) {
			$this->message('你访问的商品不存在或已删除!', mobileUrl('groups'), 'error');
		}

		if (!empty($goods['thumb_url'])) {
			$goods['thumb_url'] = array_merge(iunserializer($goods['thumb_url']));
		}

		$goods = set_medias($goods, 'thumb');
		$goods['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid));
		$goods['fightnum'] = $goods['teamnum'] + $goods['fightnum'];
		$goods['content'] = m('ui')->lazy($goods['content']);

		if (empty($goods)) {
			$this->message('商品已下架或被删除!', mobileUrl('groups'), 'error');
		}

		if (!empty($groupsset['discount'])) {
			if (empty($goods['discount'])) {
				$goods['headstype'] = $groupsset['headstype'];
				$goods['headsmoney'] = $groupsset['headsmoney'];
				$goods['headsdiscount'] = $groupsset['headsdiscount'];
			}

			if ($goods['groupsprice'] < $goods['headsmoney']) {
				$goods['headsmoney'] = $goods['groupsprice'];
			}
		}

		$specArr = array();

		if ($goods['more_spec'] == 1) {
			$group_goods = pdo_get('ewei_shop_groups_goods', array('id' => $id, 'uniacid' => $_W['uniacid']));

			if (empty($group_goods['gid'])) {
				app_error('缺少商品');
			}

			$specArr = pdo_getall('ewei_shop_goods_spec', array('goodsid' => $group_goods['gid'], 'uniacid' => $_W['uniacid']), array('id', 'title'), '', array('displayorder' => 'desc'));

			foreach ($specArr as $k => $v) {
				$specArr[$k]['item'] = pdo_getall('ewei_shop_goods_spec_item', array('uniacid' => $_W['uniacid'], 'specid' => $v['id']), array('id', 'specid', 'title', 'thumb'), '', array('displayorder' => 'desc'));
			}
		}

		$ladder = array();

		if ($goods['is_ladder'] == 1) {
			$ladder = pdo_getall('ewei_shop_groups_ladder', array('goods_id' => $id, 'uniacid' => $_W['uniacid']));
		}

		$url = array('pay' => mobileUrl('groups/goods/pay'), 'lottery' => mobileUrl('groups/goods/lottery'));
		$set = $_W['shopset'];
		$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goods['share_desc']) ? $goods['share_desc'] : $goods['description'], 'link' => mobileUrl('groups/goods', array('id' => $id), true));
		include $this->template();
	}

	public function pay($a = array(), $b = array())
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$id = intval($_GPC['id']);
		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$coupon = com('coupon')->setCoupon($coupon, time());

		if (0 < $coupon['money']) {
			pdo_delete('ewei_shop_coupon_log', array('couponid' => $id, 'openid' => $openid, 'status' => 0, 'paystatus' => 0));
			$needpay = true;
			$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_coupon_log') . ' where couponid=:couponid and openid=:openid  and status=0 and paystatus=1 and uniacid=:uniacid limit 1', array(':couponid' => $id, ':openid' => $openid, ':uniacid' => $_W['uniacid']));

			if (!empty($lastlog)) {
				show_json(1, array('logid' => $lastlog['id']));
			}
		}
		else {
			pdo_delete('ewei_shop_coupon_log', array('couponid' => $id, 'openid' => $openid, 'status' => 0));
		}

		$logno = m('common')->createNO('coupon_log', 'logno', 'CC');
		$log = array('uniacid' => $_W['uniacid'], 'merchid' => $coupon['merchid'], 'openid' => $openid, 'logno' => $logno, 'couponid' => $id, 'status' => 0, 'paystatus' => 0 < $coupon['money'] ? 0 : -1, 'creditstatus' => 0 < $coupon['credit'] ? 0 : -1, 'createtime' => time(), 'getfrom' => 7);
		pdo_insert('ewei_shop_coupon_log', $log);
		$logid = pdo_insertid();
		show_json(1, array('logid' => $logid));
	}

	public function payresult($a = array())
	{
		global $_W;
		global $_GPC;
		$logid = intval($_GPC['logid']);
		$num = intval($_GPC['num']);
		$card_id = intval($_GPC['card_id']);
		$openid = $_W['openid'];
		$log = pdo_fetch('select id,logno,status,paystatus,couponid from ' . tablename('ewei_shop_coupon_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $_W['uniacid']));

		if (empty($log)) {
			show_json(-1, '订单未找到');
		}

		$coupon = com('coupon')->getCoupon($log['couponid']);
		if (!empty($coupon['usecredit2']) || $coupon['money'] <= 0) {
			$i = 0;

			while ($i < $num) {
				$result = $this->model->payResult($log['logno']);

				if (is_error($result)) {
					show_json($result['errno'], $result['message']);
				}

				++$i;
			}
		}
		else {
			if (empty($log['paystatus'])) {
				show_json(0, '支付未成功!');
			}
		}

		$card_info = $this->model->getMemberCard($card_id);
		$data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'member_card_id' => $card_id, 'name' => $card_info['name'], 'create_time' => time(), 'receive_time' => time(), 'price' => $card_info['price'], 'validate' => $card_info['validate'], 'card_couponcount' => $num, 'card_points' => $card_info['month_points'], 'card_couponid' => $log['couponid']);
		pdo_insert('ewei_shop_member_card_monthsend', $data);
		show_json(1, array('url' => $result['url'], 'dataid' => $result['dataid'], 'coupontype' => $result['coupontype']));
	}

	public function get_month_coupon()
	{
		global $_W;
		global $_GPC;
		$cardid = $_GPC['card_id'];
		$couponid = $_GPC['couponid'];
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$coupon = com('coupon')->getCoupon($couponid);
		if (empty($openid) || empty($cardid) || empty($couponid)) {
			show_json(-1, '参数错误');
		}

		$card = $this->model->getMemberCard($cardid);

		if (empty($card)) {
			show_json(-1, '没有此会员卡');
		}

		if ($card['isdelete']) {
			show_json(-1, '此会员卡已经被删除');
		}

		$has_flag = $this->model->check_Hasget($cardid, $openid);

		if (0 < $has_flag['errno']) {
			show_json(-1, '没购买过此会员卡');
		}
		else {
			if ($has_flag['using'] == '-1') {
				show_json(-1, '购买的会员卡已过期');
			}
		}

		if (!$card['is_month_coupon']) {
			show_json(-1, '此会员卡没有此项福利');
		}

		$month_coupon = iunserializer($card['month_coupon']);
		if (empty($month_coupon) || empty($month_coupon['couponid'])) {
			show_json(-1, '会员卡数据有误');
		}

		if (!in_array($couponid, $month_coupon['couponid'])) {
			show_json(-1, '会员卡数据有误(1)');
		}

		if (!in_array($coupon['id'], $month_coupon['couponid'])) {
			show_json(-1, '此优惠券不存在');
		}

		$couponnum = $month_coupon['couponnum' . $couponid];
		if (empty($couponnum) || $couponnum < 1) {
			show_json(-1, '会员卡数据有误(2)');
		}

		if ($this->model->check_month_coupon($cardid, $openid, $couponid)) {
			show_json(-1, '本月已领取过此优惠券');
		}

		$send_res = $this->model->send_coupon($openid, $couponid, $couponnum, 1);

		if (!$send_res) {
			show_json(-1, '本月已领取过此优惠券');
		}

		$send_log = array('uniacid' => $uniacid, 'openid' => $openid, 'member_card_id' => $cardid, 'name' => $card['name'], 'receive_time' => TIMESTAMP, 'create_time' => TIMESTAMP, 'price' => $card['price'], 'validate' => $card['validate'], 'sendtype' => 2, 'card_couponid' => $couponid, 'card_couponcount' => $couponnum);
		pdo_insert('ewei_shop_member_card_monthsend', $send_log);
		show_json(1, '领取成功');
	}

	public function get_month_point()
	{
		global $_W;
		global $_GPC;
		$cardid = $_GPC['card_id'];
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		if (empty($openid) || empty($cardid)) {
			show_json(-1, '参数错误');
		}

		$plugin_membercard = p('membercard');

		if (!$plugin_membercard) {
			show_json(-1, '插件未找到');
		}

		$card = $this->model->getMemberCard($cardid);

		if (empty($card)) {
			show_json(-1, '会员卡不存在');
		}

		if ($card['isdelete']) {
			show_json(-1, '会员卡已经被删除');
		}

		$has_flag = $this->model->check_Hasget($cardid, $openid);

		if (0 < $has_flag['errno']) {
			show_json(-1, '没购买过此会员卡');
		}
		else {
			if ($has_flag['using'] == '-1') {
				show_json(-1, '购买的会员卡已过期');
			}
		}

		if ($this->model->check_month_point($cardid, $openid)) {
			show_json(-1, '本月已领取过');
		}

		if (!$card['is_month_points']) {
			show_json(-1, '此会员卡没有此项福利');
		}

		$month_points = $card['month_points'];

		if ($month_points <= 0) {
			show_json(-1, '会员卡数据有误');
		}

		$result = m('member')->setCredit($openid, 'credit1', $month_points, array($_W['member']['uid'], '购买会员卡' . $card['name'] . date('m') . '月领取' . $month_points . '积分'));

		if (is_error($result)) {
			show_json(-1, $result['message']);
		}

		$send_log = array('uniacid' => $uniacid, 'openid' => $openid, 'member_card_id' => $cardid, 'name' => $card['name'], 'receive_time' => TIMESTAMP, 'create_time' => TIMESTAMP, 'price' => $card['price'], 'validate' => $card['validate'], 'sendtype' => 1, 'card_points' => $month_points);
		$recid = pdo_insert('ewei_shop_member_card_monthsend', $send_log);

		if (!$recid) {
			show_json(-1, '系统内部错误');
		}

		show_json(1, $send_log);
	}
}

?>
