<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends ComWebPage
{
	public function __construct($_com = 'wxcard')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 5;
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid';
		$data = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND title LIKE :title';
			$data[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if ($_GPC['card_type'] != '') {
			$condition .= ' AND card_type = :card_type';
			$data[':card_type'] = trim($_GPC['card_type']);
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_wxcard') . ' ' . (' where  1 and ' . $condition . ' ORDER BY id DESC,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $data);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_wxcard') . (' where 1 and ' . $condition), $data);
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
		$type = intval($_GPC['type']);

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxcard') . ' WHERE id =:id and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		}

		if ($_W['ispost']) {
			$data = array();
			$data['uniacid'] = $_W['uniacid'];
			$data['catid'] = intval($_GPC['catid']);
			$data['displayorder'] = intval($_GPC['displayorder']);
			$data['color'] = $_GPC['color'];
			$data['notice'] = '请前往商城购买商品时使用!';
			$data['service_phone'] = '';
			$data['description'] = $_GPC['description'];
			$data['use_limit'] = intval($_GPC['use_limit']) <= 1 ? 1 : intval($_GPC['use_limit']);
			$data['get_limit'] = intval($_GPC['get_limit']) <= 1 ? 1 : intval($_GPC['get_limit']);
			$data['can_share'] = $_GPC['can_share'] == 'on' ? 1 : 0;
			$data['can_give_friend'] = $_GPC['can_give_friend'] == 'on' ? 1 : 0;
			$data['center_title'] = $_GPC['center_title'];
			$data['center_sub_title'] = $_GPC['center_sub_title'];
			$data['center_url'] = $_GPC['center_url'];
			$data['setcustom'] = '1';
			$data['custom_url_name'] = $_GPC['custom_url_name'];
			$data['custom_url_sub_title'] = $_GPC['custom_url_sub_title'];
			$data['custom_url'] = $_GPC['custom_url'];
			$data['setpromotion'] = '1';
			$data['promotion_url_name'] = $_GPC['promotion_url_name'];
			$data['promotion_url_sub_title'] = $_GPC['promotion_url_sub_title'];
			$data['promotion_url'] = $_GPC['promotion_url'];
			$data['limitdiscounttype'] = intval($_GPC['limitdiscounttype']);
			$limitgoodcatetype = intval($_GPC['limitgoodcatetype']);
			$limitgoodtype = intval($_GPC['limitgoodtype']);
			$data['limitgoodcatetype'] = $limitgoodcatetype;
			$data['limitgoodtype'] = $limitgoodtype;

			if ($limitgoodcatetype == 1) {
				$data['limitgoodcateids'] = '';
				$cates = array();

				if (is_array($_GPC['cates'])) {
					$cates = $_GPC['cates'];
					$data['limitgoodcateids'] = implode(',', $cates);
				}
			}
			else {
				$data['limitgoodcateids'] = '';
			}

			if ($limitgoodtype == 1) {
				$data['limitgoodids'] = '';
				$goodids = array();

				if (is_array($_GPC['goodsid'])) {
					$goodids = $_GPC['goodsid'];
					$data['limitgoodids'] = implode(',', $goodids);
				}
			}
			else {
				$data['limitgoodids'] = '';
			}

			$data['gettype'] = intval($_GPC['gettype']);
			$data['tagtitle'] = $_GPC['tagtitle'];
			$data['settitlecolor'] = intval($_GPC['settitlecolor']);
			$data['titlecolor'] = $_GPC['titlecolor'];
			$islimitlevel = intval($_GPC['islimitlevel']);
			$data['islimitlevel'] = $islimitlevel;

			if ($islimitlevel == 1) {
				if (is_array($_GPC['limitmemberlevels'])) {
					$data['limitmemberlevels'] = implode(',', $_GPC['limitmemberlevels']);
				}
				else {
					$data['limitmemberlevels'] = '';
				}

				if (is_array($_GPC['limitagentlevels'])) {
					$data['limitagentlevels'] = implode(',', $_GPC['limitagentlevels']);
				}
				else {
					$data['limitagentlevels'] = '';
				}

				if (is_array($_GPC['limitpartnerlevels'])) {
					$data['limitpartnerlevels'] = implode(',', $_GPC['limitpartnerlevels']);
				}
				else {
					$data['limitpartnerlevels'] = '';
				}

				if (is_array($_GPC['limitaagentlevels'])) {
					$data['limitaagentlevels'] = implode(',', $_GPC['limitaagentlevels']);
				}
				else {
					$data['limitaagentlevels'] = '';
				}
			}
			else {
				$data['limitmemberlevels'] = '';
				$data['limitagentlevels'] = '';
				$data['limitpartnerlevels'] = '';
				$data['limitaagentlevels'] = '';
			}

			if (!empty($item)) {
				if ($item['logo_url'] != $_GPC['logourl']) {
					$imgurl = ATTACHMENT_ROOT . $_GPC['logolocalpath'];

					if (!is_file($imgurl)) {
						$img = tomedia($_GPC['logolocalpath']);
						load()->func('communication');
						$resp = ihttp_get($img);
						file_put_contents($imgurl, $resp['content']);
					}

					$result = com('wxcard')->wxCardUpdateImg($imgurl);

					if (is_wxerror($result)) {
						show_json(0, '上传的logo图片限制文件大小限制1MB，像素为300*300，仅支持JPG、PNG格式。');
					}

					$data['logo_url'] = $_GPC['logourl'];
					$data['wxlogourl'] = $result['url'];
				}

				if ($_GPC['datetypevalue'] == 'DATE_TYPE_FIX_TIME_RANGE') {
					$data['datetype'] = $_GPC['datetypevalue'];
					$begin_timestamp = strtotime($_GPC['beginendtime']['start']);
					$end_timestamp = strtotime($_GPC['beginendtime']['end']);
					$nowtime = time();

					if ($end_timestamp < $nowtime) {
						show_json(0, '优惠券有效期不能小于当前日期!');
					}

					if ($item['begin_timestamp'] < $begin_timestamp) {
						show_json(0, '新的有效期开始时间不能大于旧有效期开始时间!');
					}

					if ($end_timestamp < $item['end_timestamp']) {
						show_json(0, '新的有效期结束时间不能小于旧有效期结束时间!');
					}

					$data['begin_timestamp'] = $begin_timestamp;
					$data['end_timestamp'] = $end_timestamp;
				}

				$data['card_type'] = $item['card_type'];
				$data['card_id'] = $item['card_id'];
				$result = com('wxcard')->updateCard($data);

				if (is_wxerror($result)) {
					show_json(0, '卡券更新失败,错误信息:' . $result['errmsg']);
				}

				pdo_update('ewei_shop_wxcard', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('sale.coupon.edit', '编辑卡券 ID: ' . $id . ' <br/>卡券名称: ' . $data['title']);
			}
			else {
				if (empty($type)) {
					$data['card_type'] = 'CASH';
				}
				else {
					if ($type == 1) {
						$data['card_type'] = 'DISCOUNT';
					}
				}

				if (empty($_GPC['logolocalpath'])) {
					show_json(0, 'logo图片未上传');
				}

				$imgurl = ATTACHMENT_ROOT . $_GPC['logolocalpath'];

				if (!is_file($imgurl)) {
					$img = tomedia($_GPC['logolocalpath']);
					load()->func('communication');
					$resp = ihttp_get($img);
					file_put_contents($imgurl, $resp['content']);
				}

				$result = com('wxcard')->wxCardUpdateImg($imgurl);

				if (is_wxerror($result)) {
					show_json(0, '上传的logo图片限制文件大小限制1MB，像素为300*300，仅支持JPG、PNG格式。');
				}

				$data['logo_url'] = $_GPC['logourl'];
				$data['wxlogourl'] = $result['url'];
				$data['brand_name'] = $_GPC['brand_name'];
				$data['title'] = $_GPC['title'];
				$data['datetype'] = $_GPC['datetype'];

				if ($_GPC['datetype'] == 'DATE_TYPE_FIX_TIME_RANGE') {
					$begin_timestamp = strtotime($_GPC['beginendtime']['start']);
					$end_timestamp = strtotime($_GPC['beginendtime']['end']);
					$nowtime = time();

					if ($end_timestamp < $nowtime) {
						show_json(0, '优惠券有效期不能小于当前日期!');
					}

					$data['begin_timestamp'] = $begin_timestamp;
					$data['end_timestamp'] = $end_timestamp;
				}
				else if ($_GPC['datetype'] == 'DATE_TYPE_FIX_TERM') {
					$data['fixed_term'] = intval($_GPC['fixed_term']);
					$data['fixed_begin_term'] = intval($_GPC['fixed_begin_term']);
				}
				else {
					show_json(0, '请选择有效期类型!');
				}

				$data['quantity'] = intval($_GPC['quantity']) <= 1 ? 1 : intval($_GPC['quantity']);
				$data['total_quantity'] = intval($_GPC['quantity']) <= 1 ? 1 : intval($_GPC['quantity']);
				$data['can_use_with_other_discount'] = intval($_GPC['can_use_with_other_discount']);
				$data['setabstract'] = intval($_GPC['setabstract']);

				if (!empty($_GPC['setabstract'])) {
					if (empty($_GPC['abstractimglocalpath'])) {
						show_json(0, '封面图片未上传');
					}

					$data['abstract'] = $_GPC['abstract'];
					$imgurl = ATTACHMENT_ROOT . $_GPC['abstractimglocalpath'];

					if (!is_file($imgurl)) {
						$img = tomedia($_GPC['abstractimglocalpath']);
						load()->func('communication');
						$resp = ihttp_get($img);
						file_put_contents($imgurl, $resp['content']);
					}

					$result = com('wxcard')->wxCardUpdateImg($imgurl);

					if (is_wxerror($result)) {
						show_json(0, '上传的封面图片限制文件大小限制2MB，850*350，仅支持JPG、PNG格式。');
					}

					$data['abstractimg'] = $_GPC['abstractimgurl'];
					$data['icon_url_list'] = $result['url'];
				}

				if (empty($type)) {
					$data['use_condition'] = $_GPC['use_condition'] == 'on' ? 1 : 0;
					$data['accept_category'] = $_GPC['accept_category'];
					$data['reject_category'] = $_GPC['reject_category'];
					$data['least_cost'] = intval(floatval($_GPC['least_cost']) * 100);
					$data['reduce_cost'] = intval(floatval($_GPC['reduce_cost']) * 100);
					if (10000000000 < $data['reduce_cost'] || $data['reduce_cost'] <= 0) {
						show_json(0, '您好,您输入的金额不正确!');
					}
				}
				else {
					$discount = floatval($_GPC['discount']);
					if (10 <= $discount || $discount < 1) {
						show_json(0, '您好,您输入的折扣范围不对! 请输入 1 ~ 9.9 之间数');
					}

					$discount = (10 - $discount) * 10;
					$data['discount'] = $discount;
				}

				$result = com('wxcard')->createCard($data);

				if (is_wxerror($result)) {
					show_json(0, '卡券创建失败,错误信息:' . $result['errmsg']);
				}

				$data['card_id'] = $result['card_id'];
				pdo_insert('ewei_shop_wxcard', $data);
				$id = pdo_insertid();
				plog('sale.coupon.add', '添加卡券 ID: ' . $id . '  <br/>卡券名称: ' . $data['title']);
			}

			show_json(1, array('url' => webUrl('sale/wxcard')));
		}

		if (empty($item)) {
			$starttime = time();
			$endtime = strtotime(date('Y-m-d H:i:s', $starttime) . '+7 days');
		}
		else {
			$isedit = 1;

			if ($item['card_type'] == 'DISCOUNT') {
				$type = 1;
			}
			else {
				$type = 0;
			}

			$starttime = $item['begin_timestamp'];
			$endtime = $item['end_timestamp'];
			if ($item['limitgoodcatetype'] == 1 || $item['limitgoodcatetype'] == 2) {
				$cates = array();
				$cates = explode(',', $item['limitgoodcateids']);
			}

			if ($item['limitgoodtype'] == 1 || $item['limitgoodtype'] == 2) {
				if ($item['limitgoodids']) {
					$limitgoodids = $item['limitgoodids'];
					$str = mb_substr($limitgoodids, mb_strlen($limitgoodids, 'UTF-8') - 1, mb_strlen($limitgoodids, 'UTF-8'), 'UTF-8');

					if ($str == ',') {
						$limitgoodids = mb_substr($limitgoodids, 0, mb_strlen($limitgoodids, 'UTF-8') - 1, 'UTF-8');
					}

					$goods = pdo_fetchall('SELECT id,title,thumb FROM ' . tablename('ewei_shop_goods') . (' WHERE uniacid = :uniacid and id in (' . $limitgoodids . ') '), array(':uniacid' => $_W['uniacid']));
				}
			}

			$discount = (double) (100 - intval($item['discount'])) / 10;
			$limitmemberlevels = explode(',', $item['limitmemberlevels']);
			$limitagentlevels = explode(',', $item['limitagentlevels']);
			$limitpartnerlevels = explode(',', $item['limitpartnerlevels']);
			$limitaagentlevels = explode(',', $item['limitaagentlevels']);
		}

		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_coupon_category') . ' where uniacid=:uniacid and merchid=0 order by id desc', array(':uniacid' => $_W['uniacid']), 'id');
		$goodcategorys = m('shop')->getFullCategory(true, true);
		$shop = $_W['shopset']['shop'];
		$levels = m('member')->getLevels();
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
			$agentlevels = $plugin_com->getLevels();
		}

		if ($hasglobonus) {
			$partnerlevels = $plugin_globonus->getLevels();
		}

		if ($hasabonus) {
			$aagentlevels = $plugin_abonus->getLevels();
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

		$items = pdo_fetchall('SELECT id,card_id,title FROM ' . tablename('ewei_shop_wxcard') . (' WHERE id in( ' . $id . ' ) and merchid=0 AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			$card_id = $item['card_id'];
			$res = com('wxcard')->wxCardDelete($card_id);

			if (is_wxerror($res)) {
			}

			pdo_delete('ewei_shop_wxcard', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('sale.coupon.delete', '删除优惠券 ID: ' . $id . '  <br/>优惠券名称: ' . $item['couponname'] . ' ');
		}

		show_json(1, array('url' => webUrl('sale/coupon')));
	}

	public function stock()
	{
		global $_W;
		global $_GPC;

		if (!cv('sale.wxcard.stock')) {
			$this->message('你没有相应的权限查看');
		}

		$id = intval($_GPC['id']);
		$card_id = $_GPC['card_id'];

		if (!empty($id)) {
			com('wxcard')->wxCardUpdateQuantity($id);
		}

		$sql = 'select id,uniacid,logo_url, card_id,title,total_quantity,quantity from ' . tablename('ewei_shop_wxcard');
		$sql .= '  where uniacid=:uniacid and id=:id   limit 1';
		$item = pdo_fetch($sql, array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$changetype = intval($_GPC['changetype']);
			$num = intval($_GPC['num']);

			if ($num <= 0) {
				show_json(0, array('message' => '请填写大于0的数字!'));
			}

			$quantity = $item['quantity'];
			$total_quantity = $item['total_quantity'];

			if (empty($changetype)) {
				$quantity += $num;
				$total_quantity += $num;
			}
			else {
				$quantity -= $num;
				$total_quantity -= $num;

				if ($quantity < 0) {
					show_json(0, array('message' => '减少数量不能大于当前库存!'));
				}
			}

			com('wxcard')->wxCardModifyStock($card_id, $num, $changetype);
			$data = array('quantity' => $quantity, 'total_quantity' => $total_quantity);
			pdo_update('ewei_shop_wxcard', $data, array('id' => $id));
			plog('sale.wxcard.modifystock', '修改卡券库存信息:卡券ID:' . $id . ',卡券CID:' . $card_id . ',' . empty($changetype) ? '增加' : '减少' . $num . '份');
			show_json(1, array('url' => referer()));
		}

		include $this->template();
	}

	public function qrcode()
	{
		global $_W;
		global $_GPC;

		if (!cv('sale.wxcard.qrcode')) {
			$this->message('你没有相应的权限查看');
		}

		$id = intval($_GPC['id']);
		$card_id = $_GPC['card_id'];
		$result = com('wxcard')->wxCardGetQrcodeUrl($card_id);

		if (!is_wxerror($result)) {
			$codeimg = $result['show_qrcode_url'];
		}
		else {
			$iserror = true;
		}

		include $this->template();
	}
}

?>
