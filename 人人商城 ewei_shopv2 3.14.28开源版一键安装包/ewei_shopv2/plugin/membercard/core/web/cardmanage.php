<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Cardmanage_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$membercard_data = m('common')->getPluginset('membercard');

		if (empty($membercard_data['view'])) {
			$view = 'gird';
		}
		else {
			$view = $membercard_data['view'];
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid ';
		$condition .= ' and isdelete =0';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND name LIKE :name';
			$params[':name'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if ($_GPC['status'] != '') {
			$condition .= ' AND status = :status';
			$params[':status'] = intval($_GPC['status']);
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_member_card') . ('
				where   ' . $condition . ' ORDER BY sort_order DESC,create_time DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		if ($list) {
			foreach ($list as $key => $val) {
				$list[$key]['name'] = p('membercard')->cut_string($val['name'], 11);
				$equity = '';

				if ($val['shipping']) {
					$equity .= '免费包邮·';
				}

				if ($val['member_discount']) {
					$equity .= $val['discount_rate'] . '折优惠·';
				}

				if ($val['is_card_coupon']) {
					$equity .= '开卡送券·';
				}

				if ($val['is_month_coupon']) {
					$equity .= '每月领券·';
				}

				$equity = trim($equity);

				if (!empty($equity)) {
					$equity = rtrim($equity, '·');
				}

				$list[$key]['equity'] = $equity;
			}
		}

		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_card') . ('where 1 and ' . $condition), $params);
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
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_card') . ' 
				WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if ($item) {
			if ($item['card_coupon']) {
				$card_coupon = iunserializer($item['card_coupon']);
				$coupons_pay = $this->querycoupon($card_coupon['couponids']);

				foreach ($coupons_pay as $cpk => $cpv) {
					$coupons_pay[$cpk]['couponsnum' . $cpv['id']] = $card_coupon['couponsnum' . $cpv['id']];
				}
			}

			if ($item['month_coupon']) {
				$month_coupon = iunserializer($item['month_coupon']);
				$coupons_share = $this->querycoupon($month_coupon['couponid']);

				foreach ($coupons_share as $cpk => $cpv) {
					$coupons_share[$cpk]['couponnum' . $cpv['id']] = $month_coupon['couponnum' . $cpv['id']];
				}
			}
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'name' => trim($_GPC['name']), 'sort_order' => intval($_GPC['sort_order']), 'card_style' => trim($_GPC['card_style']), 'shipping' => intval($_GPC['shipping']), 'member_discount' => intval($_GPC['member_discount']), 'discount_rate' => floatval($_GPC['discount_rate']), 'discount' => intval($_GPC['discount']), 'is_card_points' => intval($_GPC['is_card_points']), 'card_points' => intval($_GPC['card_points']), 'is_card_coupon' => intval($_GPC['is_card_coupon']), 'is_month_points' => intval($_GPC['is_month_points']), 'month_points' => intval($_GPC['month_points']), 'is_month_coupon' => intval($_GPC['is_month_coupon']), 'validate' => intval($_GPC['validate']), 'price' => floatval($_GPC['price']), 'stock' => intval($_GPC['stock']), 'status' => intval($_GPC['status']), 'description' => $_GPC['description']);
			$data['discount_rate'] = round($data['discount_rate'], 1);
			$card_coupon = array();
			$month_coupon = array();

			if (empty($data['name'])) {
				show_json(0, '请填写会员卡名称');
			}

			if (empty($data['shipping']) && empty($data['member_discount']) && empty($id)) {
				show_json(0, '至少选择一种会员权益');
			}

			if ($data['member_discount'] && empty($data['discount_rate'])) {
				show_json(0, '请填写会员折扣');
			}

			if ($data['discount_rate'] && ($data['discount_rate'] <= 0 || 10 <= $data['discount_rate'])) {
				show_json(0, '会员折扣须是0-10之间的数值');
			}

			if ($data['is_card_points'] && empty($data['card_points'])) {
				show_json(0, '请填写开卡赠送积分值');
			}

			if (empty($data['description'])) {
				show_json(0, '请填写会员使用须知');
			}

			if ($data['is_card_coupon']) {
				if (empty($_GPC['couponids'])) {
					show_json(0, '请选择开卡赠送的优惠券');
				}

				$card_coupon['couponid1_text'] = $_GPC['couponid1_text'];
				$card_coupon['couponids'] = $_GPC['couponids'];
				$count = count($_GPC['couponids']);

				if ($count == 2) {
					if ($_GPC['couponids'][0] == $_GPC['couponids'][1]) {
						show_json(0, '开卡赠送同一张优惠券不能重复选择！');
					}
				}

				if ($count == 3) {
					if ($_GPC['couponids'][0] == $_GPC['couponids'][1] || $_GPC['couponids'][0] == $_GPC['couponids'][2] || $_GPC['couponids'][1] == $_GPC['couponids'][2]) {
						show_json(0, '开卡赠送同一张优惠券不能重复选择！');
					}
				}

				foreach ($_GPC['couponids'] as $ck => $cv) {
					if (intval($_GPC['couponsnum' . $cv]) < 1) {
						show_json(0, '每张优惠券的每人领取数量不能小于1');
					}
					else {
						$card_coupon['paycpnum' . ($ck + 1)] = $_GPC['couponsnum' . $cv];
						$card_coupon['couponsnum' . $cv] = $_GPC['couponsnum' . $cv];
					}
				}
			}

			if ($data['is_month_points'] && empty($data['month_points'])) {
				show_json(0, '请填写每月赠送积分值');
			}

			if ($data['is_month_coupon']) {
				if (empty($_GPC['couponid'])) {
					show_json(0, '请选择每月赠送的优惠券');
				}

				$month_coupon['couponid2_text'] = $_GPC['couponid2_text'];
				$month_coupon['couponid'] = $_GPC['couponid'];
				$count = count($_GPC['couponid']);

				if ($count == 2) {
					if ($_GPC['couponid'][0] == $_GPC['couponid'][1]) {
						show_json(0, '每月赠送同一张优惠券不能重复选择！');
					}
				}

				if ($count == 3) {
					if ($_GPC['couponid'][0] == $_GPC['couponid'][1] || $_GPC['couponid'][0] == $_GPC['couponid'][2] || $_GPC['couponid'][1] == $_GPC['couponid'][2]) {
						show_json(0, '每月赠送同一张优惠券不能重复选择！');
					}
				}

				foreach ($_GPC['couponid'] as $ck => $cv) {
					if (intval($_GPC['couponnum' . $cv]) < 1) {
						show_json(0, '每张优惠券的每人领取数量不能小于1');
					}
					else {
						$month_coupon['paycpnum' . ($ck + 1)] = $_GPC['couponnum' . $cv];
						$month_coupon['couponnum' . $cv] = $_GPC['couponnum' . $cv];
					}
				}
			}

			if (empty($_GPC['validity']) && empty($id)) {
				show_json(0, '请选择会员卡有效期');
			}

			if ($_GPC['validity'] == 1) {
				if (empty($data['validate'])) {
					show_json(0, '请填写会员卡有效期');
				}

				if ($data['validate'] <= 0) {
					show_json(0, '请填写正确的有效期');
				}
			}
			else {
				$data['validate'] = -1;
			}

			if ($data['price'] < 0) {
				$data['price'] = 0;
			}

			if ($data['stock'] < 0) {
				$data['stock'] = 0;
			}

			if (empty($data['card_style'])) {
				$data['card_style'] = 'card-style-golden';
			}

			$data['card_coupon'] = iserializer($card_coupon);
			$data['month_coupon'] = iserializer($month_coupon);

			if (!empty($id)) {
				$update_data = array('sort_order' => intval($_GPC['sort_order']), 'stock' => $data['stock'], 'update_time' => TIMESTAMP, 'status' => intval($_GPC['status']), 'description' => $_GPC['description']);
				$goods_update = pdo_update('ewei_shop_member_card', $update_data, array('id' => $id, 'uniacid' => $_W['uniacid']));

				if (!$goods_update) {
					show_json(0, '会员卡编辑失败！' . $data['stock']);
				}

				plog('membercard.cardmanage.edit', '编辑会员卡 ID: ' . $id . ' <br/>会员卡名称: ' . $data['name']);
			}
			else {
				$data['create_time'] = time();
				$goods_insert = pdo_insert('ewei_shop_member_card', $data);

				if (!$goods_insert) {
					show_json(0, '会员卡添加失败！');
				}

				$id = pdo_insertid();
				plog('membercard.cardmanage.add', '添加会员卡 ID: ' . $id . '  <br/>会员卡名称: ' . $data['name']);
			}

			show_json(1, array('url' => webUrl('membercard/cardmanage/edit', array('op' => 'post', 'id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		include $this->template();
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$status = intval($_GPC['status']);
		$item = pdo_fetch('SELECT id,name,status FROM ' . tablename('ewei_shop_member_card') . (' WHERE id = \'' . $id . '\' AND uniacid=') . $_W['uniacid'] . '');

		if (empty($item)) {
			show_json(0, '会员卡不存在或者已经被删除');
		}

		$status = abs(1 - $item['status']);
		$result = pdo_update('ewei_shop_member_card', array('status' => $status), array('id' => $id, 'uniacid' => $_W['uniacid']));

		if (!$result) {
			show_json(0, '操作失败');
		}

		$operator = empty($status) ? '停发' : '启用';
		plog('membercard.cardmanage.status', $operator . '会员卡 ID: ' . $id . '  <br/>会员卡名称: ' . $item['name']);
		show_json(1, array('url' => referer()));
	}

	public function enabled()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data['view'] = $_GPC['view'];
			m('common')->updatePluginset(array('membercard' => $data));
			show_json(1);
		}
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_member_card') . (' WHERE id = \'' . $id . '\' AND uniacid=') . $_W['uniacid'] . '');

		if (empty($item)) {
			show_json(0, '抱歉,会员卡不存在或者已经被删除');
		}

		pdo_update('ewei_shop_member_card', array('isdelete' => 1, 'del_time' => time()), array('id' => $id, 'uniacid' => $_W['uniacid']));
		pdo_update('ewei_shop_member_card_history', array('isdelete' => 1, 'del_time' => time()), array('member_card_id' => $id, 'uniacid' => $_W['uniacid']));
		plog('membercard.cardmanage.delete', '删除会员卡: ' . $id . ' 标题: ' . $item['name'] . ' ');
		show_json(1);
	}

	public function querycoupon($couponid = array())
	{
		global $_W;
		global $_GPC;
		$cpinfo = array();
		if (!is_array($couponid) || empty($couponid)) {
			return $cpinfo;
		}

		foreach ($couponid as $ck => $cv) {
			$where = ' WHERE uniacid = :uniacid AND id = :id';
			$params = array(':uniacid' => intval($_W['uniacid']), ':id' => intval($cv));
			$cpsql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . $where;
			$cpinfo[$ck] = pdo_fetch($cpsql, $params);
		}

		return $cpinfo;
	}
}

?>
