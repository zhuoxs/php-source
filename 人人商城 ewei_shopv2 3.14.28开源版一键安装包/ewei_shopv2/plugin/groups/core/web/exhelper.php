<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Exhelper_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$tab = $_GPC['tab'];
		$sys = pdo_fetch('select * from ' . tablename('ewei_shop_exhelper_sys') . ' where uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			ca('exhelper.printset');
			$port = intval($_GPC['port']);
			$ip = 'localhost';

			if (!empty($port)) {
				if (empty($sys)) {
					pdo_insert('ewei_shop_exhelper_sys', array('port' => $port, 'ip' => $ip, 'uniacid' => $_W['uniacid']));
				}
				else {
					pdo_update('ewei_shop_exhelper_sys', array('port' => $port, 'ip' => $ip), array('uniacid' => $_W['uniacid']));
				}

				plog('exhelper.printset.edit', '修改打印机端口 原端口: ' . $sys['port'] . ' 新端口: ' . $port);
				show_json(1);
			}
		}

		include $this->template();
	}

	public function short()
	{
		global $_W;
		global $_GPC;
		$tab = $_GPC['tab'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid AND deleted = :deleted';
		$params = array(':uniacid' => $_W['uniacid'], ':deleted' => '0');

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND ( title LIKE :title or shorttitle like :title ) ';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if (!empty($_GPC['shorttitle'])) {
			$_GPC['shorttitle'] = intval($_GPC['shorttitle']);

			if ($_GPC['shorttitle'] < 2) {
				$condition .= ' AND shorttitle <> "" ';
			}
			else {
				$condition .= ' AND shorttitle = "" ';
			}
		}

		if ($_GPC['status'] != '') {
			$_GPC['status'] = intval($_GPC['status']);
			$condition .= ' AND status=:status ';
			$params[':status'] = $_GPC['status'];
		}

		$sql = 'SELECT id,title,shorttitle,status FROM ' . tablename('ewei_shop_groups_goods') . (' where  1 and ' . $condition . ' ORDER BY  shorttitle desc, status desc, id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_groups_goods') . (' where 1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function shortedit()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$shorttitle = trim($_GPC['value']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
			$shorttitle = '';
		}

		$goods = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_groups_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($goods as $good) {
			pdo_update('ewei_shop_groups_goods', array('shorttitle' => $shorttitle), array('id' => $good['id'], 'uniacid' => $_W['uniacid']));

			if (empty($shorttitle)) {
				plog('groups.exhelper.short.edit', '清空商品简称 ID: ' . $good['id'] . ' 商品名称: ' . $good['title']);
			}
			else {
				plog('groups.exhelper.short.edit', '修改商品简称 ID: ' . $good['id'] . ' 商品名称: ' . $good['title'] . ' 商品简称: ' . $shorttitle);
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		$tab = $_GPC['tab'];
		$data = $this->model->tempData(1);
		extract($data);
		include $this->template();
	}

	public function expressadd()
	{
		$this->expresspost();
	}

	public function expressedit()
	{
		$this->expresspost();
	}

	protected function expresspost()
	{
		global $_W;
		global $_GPC;
		$tab = $_GPC['tab'];
		$id = intval($_GPC['id']);
		$type = 1;
		$express_list = m('express')->getExpressList();

		if (!empty($id)) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_exhelper_express') . ' where id=:id and type=:type and uniacid=:uniacid limit 1', array(':id' => $id, ':type' => $type, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				$elements = htmlspecialchars_decode($item['datas']);
				$elements = json_decode($elements, true);
			}
		}

		if ($_W['ispost']) {
			$id = intval($_GPC['id']);
			$data = array('isdefault' => intval($_GPC['isdefault']), 'expressname' => trim($_GPC['expressname']), 'expresscom' => trim($_GPC['expresscom']), 'express' => trim($_GPC['express']), 'height' => trim($_GPC['height']), 'datas' => trim($_GPC['datas']), 'bg' => trim($_GPC['bg']), 'type' => 1);

			if (!empty($id)) {
				pdo_update('ewei_shop_exhelper_express', $data, array('id' => $id));
				plog('groups.exhelper.expressedit', '修改快递单信息 ID: ' . $id);
			}
			else {
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_exhelper_express', $data);
				$id = pdo_insertid();
				plog('groups.exhelper.expressadd', '添加快递单模板 ID: ' . $id);
			}

			if (!empty($data['isdefault'])) {
				pdo_update('ewei_shop_exhelper_express', array('isdefault' => 0), array('type' => 1, 'uniacid' => $_W['uniacid']));
				pdo_update('ewei_shop_exhelper_express', array('isdefault' => 1), array('type' => 1, 'id' => $id));
			}

			show_json(1, array('url' => webUrl('groups/exhelper/expressedit', array('id' => $id))));
			exit();
		}

		include $this->template('groups/exhelper/expresspost');
	}

	public function expressdelete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$this->model->tempDelete($id, 1);
		show_json(1);
	}

	public function expresssetdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$this->model->setDefault($id, 1);
		}

		show_json(1);
	}

	public function invoice()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$tab = $_GPC['tab'];
		$data = $this->model->tempData(2);
		extract($data);
		include $this->template();
	}

	public function invoiceadd()
	{
		$this->invoicepost();
	}

	public function invoiceedit()
	{
		$this->invoicepost();
	}

	public function invoicepost()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = 2;
		$express_list = m('express')->getExpressList();

		if (!empty($id)) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_exhelper_express') . '
            where id=:id and type=:type and uniacid=:uniacid limit 1', array(':id' => $id, ':type' => $type, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				$elements = htmlspecialchars_decode($item['datas']);
				$elements = json_decode($elements, true);
			}
		}

		if ($_W['ispost']) {
			$id = intval($_GPC['id']);
			$data = array('isdefault' => intval($_GPC['isdefault']), 'expressname' => trim($_GPC['expressname']), 'expresscom' => trim($_GPC['expresscom']), 'express' => trim($_GPC['express']), 'height' => trim($_GPC['height']), 'datas' => trim($_GPC['datas']), 'bg' => trim($_GPC['bg']), 'type' => 2);

			if (!empty($id)) {
				pdo_update('ewei_shop_exhelper_express', $data, array('id' => $id));
				plog('groups.exhelper.invoniceedit', '修改发货单信息 ID: ' . $id);
			}
			else {
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_exhelper_express', $data);
				$id = pdo_insertid();
				plog('groups.exhelper.invoniceadd', '添加发货单模板 ID: ' . $id);
			}

			if (!empty($data['isdefault'])) {
				pdo_update('ewei_shop_exhelper_express', array('isdefault' => 0), array('type' => 2, 'uniacid' => $_W['uniacid']));
				pdo_update('ewei_shop_exhelper_express', array('isdefault' => 1), array('type' => 2, 'id' => $id));
			}

			show_json(1, array('url' => webUrl('groups/exhelper/invoiceedit', array('id' => $id))));
			exit();
		}

		include $this->template('groups/exhelper/invoicepost');
	}

	public function sender()
	{
		global $_W;
		global $_GPC;
		$tab = $_GPC['tab'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( sendername like :keyword or sendertel like :keyword or sendersign like :keyword or sendercode like :keyword or senderaddress like :keyword or sendercity like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_exhelper_senduser') . (' where  1 and ' . $condition . ' ORDER BY isdefault desc,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_exhelper_senduser') . (' where 1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function senderadd()
	{
		$this->senderpost();
	}

	public function senderedit()
	{
		$this->senderpost();
	}

	protected function senderpost()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_exhelper_senduser') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		}

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'sendername' => trim($_GPC['sendername']), 'sendertel' => trim($_GPC['sendertel']), 'sendersign' => trim($_GPC['sendersign']), 'sendercode' => trim($_GPC['sendercode']), 'senderaddress' => trim($_GPC['senderaddress']), 'sendercity' => trim($_GPC['sendercity']), 'isdefault' => intval($_GPC['isdefault']));

			if (!empty($id)) {
				pdo_update('ewei_shop_exhelper_senduser', $data, array('id' => $id));
				plog('groups.exhelper.senderedit', '修改发件人模板 ID: ' . $id);
			}
			else {
				pdo_insert('ewei_shop_exhelper_senduser', $data);
				$id = pdo_insertid();
				plog('groups.exhelper.senderadd', '添加发件人模板 ID: ' . $id);
			}

			if (!empty($data['isdefault'])) {
				pdo_update('ewei_shop_exhelper_senduser', array('isdefault' => 0), array('uniacid' => $_W['uniacid']));
				pdo_update('ewei_shop_exhelper_senduser', array('isdefault' => 1), array('id' => $id));
			}

			show_json(1, array('url' => webUrl('groups/exhelper/sender', array('id' => $id, 'tab' => 'sender'))));
		}

		include $this->template('groups/exhelper/senderpost');
	}

	public function sendersetdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,sendername FROM ' . tablename('ewei_shop_exhelper_senduser') . (' WHERE id = \'' . $id . '\' AND uniacid=') . $_W['uniacid'] . '');

		if (!empty($item)) {
			pdo_update('ewei_shop_exhelper_senduser', array('isdefault' => 0), array('uniacid' => $_W['uniacid']));
			pdo_update('ewei_shop_exhelper_senduser', array('isdefault' => 1), array('id' => $id));
			plog('groups.exhelper.senderedit', '设置 默认发件人 ID: ' . $id . ' 发件人: ' . $item['sendername'] . ' ');
		}

		show_json(1);
	}

	public function senderdelete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,sendername,sendertel,sendercity,senderaddress FROM ' . tablename('ewei_shop_exhelper_senduser') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_exhelper_senduser', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('groups.exhelper.senderdelete', '删除 发件人模板 ID: ' . $item['id'] . '  <br/>发件人: ' . $item['title'] . '/发件人电话: ' . $item['sendertel'] . '/发件城市: ' . $item['sendercity'] . '/发件地址: ' . $item['senderaddress'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function single()
	{
		global $_W;
		global $_GPC;
		$tab = $_GPC['tab'];
		$paytype = array(
			'none'   => array('css' => 'default', 'name' => '未支付'),
			'credit' => array('css' => 'danger', 'name' => '余额支付'),
			'other'  => array('css' => 'default', 'name' => '后台付款'),
			'wechat' => array('css' => 'success', 'name' => '微信支付')
		);
		$orderstatus = array(
			array('css' => 'danger', 'name' => '待付款'),
			array('css' => 'info', 'name' => '待发货'),
			array('css' => 'warning', 'name' => '待收货'),
			array('css' => 'success', 'name' => '已完成')
		);
		if (empty($starttime) && empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$printset = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exhelper_sys') . ' WHERE uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		$lodopUrl_ip = 'localhost';
		$lodopUrl_port = empty($printset['port']) ? 8000 : $printset['port'];
		$https = $_W['ishttps'] ? 'https://' : 'http://';
		$lodopUrl = $https . $lodopUrl_ip . ':' . $lodopUrl_port . '/CLodopfuncs.js';
		load()->func('tpl');
		include $this->template();
	}

	public function getdata()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$condition = ' o.uniacid = :uniacid and m.uniacid = :uniacid and o.deleted=0 and o.addressid<>0 and o.isverify = 0 ';
			$paras = array(':uniacid' => $_W['uniacid']);

			if ($_GPC['paytype'] != '') {
				if ($_GPC['paytype'] == 'none') {
					$condition .= ' AND o.pay_type = \'\' ';
				}
				else {
					$condition .= ' AND o.pay_type = \'' . trim($_GPC['paytype']) . '\' ';
				}
			}

			$status = intval($_GPC['status']);
			$statuscondition = '';

			if ($status != '') {
				if ($status == 1) {
					$statuscondition = ' and (o.status = 1 and o.is_team = 0) or (o.status = 1 and o.success = 1 ) ';
				}
				else {
					$statuscondition = ' AND o.status = ' . intval($status);
				}
			}
			else {
				$statuscondition = ' and o.status>-1 ';
			}

			if (empty($starttime) || empty($endtime)) {
				$starttime = strtotime('-1 month');
				$endtime = time();
			}

			$searchtime = trim($_GPC['searchtime']);
			if (!empty($searchtime) && !empty($_GPC['starttime']) && !empty($_GPC['endtime']) && in_array($searchtime, array('create', 'pay', 'send', 'finish'))) {
				$starttime = strtotime($_GPC['starttime']);
				$endtime = strtotime($_GPC['endtime']);
				$condition .= ' AND o.' . $searchtime . 'time >= :starttime AND o.' . $searchtime . 'time <= :endtime ';
				$paras[':starttime'] = $starttime;
				$paras[':endtime'] = $endtime;
			}

			$printstate = intval($_GPC['printstate']);

			if ($printstate != '') {
				$condition .= ' AND o.printstate=' . $printstate . ' ';
			}

			$printstate2 = $_GPC['printstate2'];

			if ($printstate2 != '') {
				$condition .= ' AND o.printstate2=' . $printstate2 . ' ';
			}

			if (!empty($_GPC['searchfield']) && !empty($_GPC['keyword'])) {
				$searchfield = trim(strtolower($_GPC['searchfield']));
				$keyword = trim($_GPC['keyword']);

				if ($searchfield == 'orderno') {
					$condition .= ' AND o.orderno LIKE \'%' . $keyword . '%\'';
				}
				else if ($searchfield == 'member') {
					$condition .= ' AND (m.realname LIKE \'%' . $keyword . '%\' or m.mobile LIKE \'%' . $keyword . '%\' or m.nickname LIKE \'%' . $keyword . '%\')';
				}
				else if ($searchfield == 'address') {
					$condition .= ' AND ( a.realname LIKE \'%' . $keyword . '%\' or a.mobile LIKE \'%' . $keyword . '%\' or a.nickname LIKE \'%' . $keyword . '%\')';
				}
				else {
					if ($searchfield == 'expresssn') {
						$condition .= ' AND o.expresssn LIKE \'%' . $keyword . '%\'';
					}
				}
			}

			$sql = 'select o.* ,a.realname ,m.nickname, d.dispatchname,m.nickname,r.refundstatus from ' . tablename('ewei_shop_groups_order') . ' o' . ' left join ' . tablename('ewei_shop_groups_order_refund') . ' r on r.orderid=o.id and ifnull(r.refundstatus,-1)<>-1' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . (' where ' . $condition . ' ' . $statuscondition . ' ORDER BY o.createtime DESC,o.status DESC  ');
			$orders = pdo_fetchall($sql, $paras);
			$list = array();

			foreach ($orders as $key => $order) {
				if (!empty($order['address'])) {
					$order_address = iunserializer($order['address']);
				}
				else {
					$order_address = iunserializer($order['addressid']);
				}

				if (!is_array($order_address)) {
					$member_address = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $order['addressid'], ':uniacid' => $_W['uniacid']));
					$list[$key]['realname'] = $member_address['realname'];
				}
				else {
					$list[$key]['realname'] = $order_address['realname'];
				}

				$list[$key]['orderids'][] = $order['id'];
			}

			include $this->template('groups/exhelper/print_tpl_single');
		}
	}

	public function getorder()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$orderids = trim($_GPC['orderids']);

			if (empty($orderids)) {
				exit('无任何订单，无法查看');
			}

			$arr = explode(',', $orderids);

			if (empty($arr)) {
				exit('无任何订单，无法查看');
			}

			$paytype = array(
				'none'   => array('css' => 'default', 'name' => '未支付'),
				'credit' => array('css' => 'danger', 'name' => '余额支付'),
				'other'  => array('css' => 'default', 'name' => '后台付款'),
				'wechat' => array('css' => 'success', 'name' => '微信支付')
			);
			$orderstatus = array(
				-1 => array('css' => 'default', 'name' => '已关闭'),
				0  => array('css' => 'danger', 'name' => '待付款'),
				1  => array('css' => 'info', 'name' => '待发货'),
				2  => array('css' => 'warning', 'name' => '待收货'),
				3  => array('css' => 'success', 'name' => '已完成')
			);
			$sql = 'select o.* , a.realname,a.mobile,a.province,a.city,a.area, d.dispatchname,m.nickname,r.refundstatus from ' . tablename('ewei_shop_groups_order') . ' o' . ' left join ' . tablename('ewei_shop_groups_order_refund') . ' r on r.orderid=o.id and ifnull(r.refundstatus,-1)<>-1' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . ' where o.id in ( ' . implode(',', $arr) . (') and o.uniacid=' . $_W['uniacid'] . ' and m.uniacid=' . $_W['uniacid'] . ' ORDER BY o.createtime DESC,o.status DESC  ');
			$list = pdo_fetchall($sql, $paras);

			foreach ($list as &$value) {
				$s = $value['status'];
				$value['statusvalue'] = $s;
				$value['statuscss'] = $orderstatus[$s]['css'];
				$value['statusname'] = $orderstatus[$s]['name'];

				if ($s == -1) {
					if ($value['refundstatus'] == 1) {
						$value['status'] = '已退款';
					}
				}

				$p = $value['pay_type'];
				$value['css'] = $paytype[$p]['css'];
				$value['paytypename'] = $paytype[$p]['name'];
				$value['dispatchname'] = empty($value['addressid']) ? '自提' : $value['dispatchname'];

				if (empty($value['dispatchname'])) {
					$value['dispatchname'] = '快递';
				}

				if ($value['isverify'] == 1) {
					$value['dispatchname'] = '线下核销';
				}
				else {
					if (!empty($value['virtual'])) {
						$value['dispatchname'] = '虚拟物品(卡密)<br/>自动发货';
					}
				}

				if (!empty($value['address'])) {
					$addressa = iunserializer($value['address']);
				}
				else {
					$addressa = iunserializer($value['addressid']);
				}

				if (!is_array($addressa)) {
					$member_address = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $value['addressid'], ':uniacid' => $_W['uniacid']));
					$value['address']['realname'] = $member_address['realname'];
					$value['address']['nickname'] = $value['nickname'];
					$value['address']['mobile'] = $member_address['mobile'];
					$value['address']['province'] = $member_address['province'];
					$value['address']['city'] = $member_address['city'];
					$value['address']['area'] = $member_address['area'];
					$value['address']['street'] = $member_address['street'];
					$value['address']['address'] = $member_address['address'];
				}
				else {
					$value['address'] = array('realname' => $addressa['realname'], 'nickname' => $value['nickname'], 'mobile' => $addressa['mobile'], 'province' => $addressa['province'], 'city' => $addressa['city'], 'area' => $addressa['area'], 'street' => $addressa['street'], 'address' => $addressa['address']);
				}

				if ($value['status'] == 1 || $value['status'] == 0 && $value['pay_type'] == 3) {
					$value['send_status'] = 1;
				}
				else {
					$value['send_status'] = 0;
				}

				$order_goods = pdo_fetchall('select g.id,g.title,g.shorttitle,g.thumb,g.units as unit,g.goodssn, g.productsn,
                    g.groupsprice,g.singleprice,g.price,o.is_team,o.price as realprice,o.goodid as ordergoodid,o.printstate,o.printstate2,o.creditmoney,o.discount
                    from ' . tablename('ewei_shop_groups_order') . ' o
                    left join ' . tablename('ewei_shop_groups_goods') . ' g on g.id = o.goodid
                    where o.uniacid=:uniacid and o.id=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $value['id']));

				foreach ($order_goods as $i => $order_good) {
					if (!empty($order_good['optionid'])) {
						$option = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_option') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $order_good['optionid'], ':uniacid' => $_W['uniacid']));
						$order_goods[$i]['weight'] = $option['weight'];
					}
				}

				$goods = '';

				foreach ($order_goods as &$og) {
					$goods .= '' . $og['title'] . '
';

					if (!empty($og['realprice'])) {
						$og['realprice'] = $og['realprice'] - $og['discount'] - $og['creditmoney'];
					}

					if ($og['realprice'] <= 0) {
						$og['realprice'] = 0;
					}

					if ($og['is_team'] == 1) {
						$og['productprice'] = $og['groupsprice'];
					}
					else {
						$og['productprice'] = $og['singleprice'];
					}

					if (!empty($og['goodssn'])) {
						$goods .= ' 商品编号: ' . $og['goodssn'];
					}

					if (!empty($og['productsn'])) {
						$goods .= ' 商品条码: ' . $og['productsn'];
					}

					if (!empty($og['is_team'])) {
						$goods .= ' 团购价格: ' . $og['groupsprice'];
					}
					else {
						$goods .= ' 单购价格: ' . $og['singleprice'];
					}

					$og['total'] = 1;
					$goods .= ' 数量: ' . $og['total'] . ' 总价: ' . $og['realprice'] . '
 ';
				}

				unset($og);
				$value['goods'] = set_medias($order_goods, 'thumb');
				$value['goods_str'] = $goods;
			}

			unset($value);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_groups_order') . ' o ' . ' left join ' . tablename('ewei_shop_groups_order_refund') . ' r on r.orderid=o.id and ifnull(r.refundstatus,-1)<>-1' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid  ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' WHERE o.id in ( ' . implode(',', $arr) . (') and o.uniacid=' . $_W['uniacid']), $paras);
			$totalmoney = pdo_fetchcolumn('SELECT sum(o.price) FROM ' . tablename('ewei_shop_groups_order') . ' o ' . ' left join ' . tablename('ewei_shop_groups_order_refund') . ' r on r.orderid=o.id and ifnull(r.refundstatus,-1)<>-1' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid  ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' WHERE o.id in ( ' . implode(',', $arr) . (') and o.uniacid=' . $_W['uniacid']), $paras);
			$address = false;

			if (!empty($list)) {
				$address = $list[0]['address'];
			}

			$address['sendinfo'] = '';
			$sendinfo = array();

			foreach ($list as $item) {
				foreach ($item['goods'] as $k => $g) {
					if (isset($sendinfo[$g['id']])) {
						$sendinfo[$g['id']]['num'] += $g['total'];
					}
					else {
						$sendinfo[$g['id']] = array('title' => empty($g['shorttitle']) ? $g['title'] : $g['shorttitle'], 'num' => $g['total'], 'optiontitle' => !empty($g['optiontitle']) ? '(' . $g['optiontitle'] . ')' : '');
					}
				}
			}

			$sendinfos = array();

			foreach ($sendinfo as $gid => $info) {
				$info['gid'] = $gid;
				$sendinfos[] = $info;
				$address['sendinfo'] .= $info['title'] . $info['optiontitle'] . ' x ' . $info['num'] . '; ';
			}

			$temps = $this->model->getTemp();
			extract($temps);
			include $this->template('groups/exhelper/print_tpl_single_detail');
		}
	}

	public function saveuser()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$ordersns = $_GPC['ordersns'];

			if (is_array($ordersns)) {
				$data = array('realname' => trim($_GPC['realname']), 'nickname' => trim($_GPC['nickname']), 'mobile' => intval($_GPC['mobile']), 'province' => trim($_GPC['province']), 'city' => trim($_GPC['city']), 'area' => trim($_GPC['area']), 'street' => trim($_GPC['street']), 'address' => trim($_GPC['address']));
				$address_send = iserializer($data);

				foreach ($ordersns as $ordersn) {
					pdo_update('ewei_shop_order', array('address_send' => $address_send), array('ordersn' => $ordersn));
				}

				exit();
			}
		}
	}

	public function getprintTemp()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$type = intval($_GPC['type']);
			$printTempId = intval($_GPC['printTempId']);
			$printUserId = intval($_GPC['printUserId']);

			if (empty($type)) {
				exit(json_encode(array('result' => 'error', 'resp' => '打印错误! 请刷新重试。EP01')));
			}

			if (empty($printTempId)) {
				exit(json_encode(array('result' => 'error', 'resp' => '加载模版错误! 请重新选择打印模板。EP02')));
			}

			if (empty($printUserId)) {
				exit(json_encode(array('result' => 'error', 'resp' => '加载模版错误! 请重新选择发件人信息模板。EP03')));
			}

			$tempSender = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exhelper_senduser') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $printUserId, ':uniacid' => $_W['uniacid']));
			$expTemp = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $printTempId, ':uniacid' => $_W['uniacid']));
			$shop_set = m('common')->getSysset('shop');
			$expDatas = htmlspecialchars_decode($expTemp['datas']);
			$expDatas = json_decode($expDatas, true);
			$expTemp['shopname'] = $shop_set['name'];
			$repItems = array('sendername', 'sendertel', 'senderaddress', 'sendersign', 'sendertime', 'sendercode', 'sendercccc');
			$repDatas = array($tempSender['sendername'], $tempSender['sendertel'], $tempSender['senderaddress'], $tempSender['sendersign'], date('Y-m-d H:i'), $tempSender['sendercode'], $tempSender['sendercity']);

			if (is_array($expDatas)) {
				foreach ($expDatas as $index => $data) {
					$expDatas[$index]['items'] = str_replace($repItems, $repDatas, $data['items']);
				}
			}

			exit(json_encode(array('result' => 'success', 'respDatas' => $expDatas, 'respUser' => $tempSender, 'respTemp' => $expTemp)));
		}
	}

	public function changestate()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$arr = $_GPC['arr'];
			$type = intval($_GPC['type']);
			if (empty($arr) || empty($type)) {
				show_json(0, array('resp' => '数据错误。EP04'));
			}

			foreach ($arr as $i => $data) {
				$orderid = $data['orderid'];
				$ordergoodid = $data['ordergoodid'];
				$ordergood = pdo_fetch('SELECT id,goodid,printstate,printstate2 FROM ' . tablename('ewei_shop_groups_order') . ' WHERE goodid=:goodid and id=:orderid and uniacid=:uniacid limit 1', array(':orderid' => $orderid, ':goodid' => $ordergoodid, ':uniacid' => $_W['uniacid']));

				if ($type == 1) {
					pdo_update('ewei_shop_groups_order', array('printstate' => $ordergood['printstate'] + 1), array('id' => $ordergood['id']));
					$orderprint = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' WHERE id=:orderid and printstate=0 and uniacid= :uniacid ', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));
					$printstatenum = $ordergood['printstate'] + 1;
				}
				else {
					if ($type == 2) {
						pdo_update('ewei_shop_groups_order', array('printstate2' => $ordergood['printstate2'] + 1), array('id' => $ordergood['id']));
						$orderprint = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' WHERE id=:orderid and printstate2=0 and uniacid= :uniacid ', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));
						$printstatenum = $ordergood['printstate2'] + 1;
					}
				}
			}

			show_json(1, array('orderprintstate' => $printstatenum));
		}
	}

	public function getorderinfo()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$orderids = $_GPC['orderids'];
			$temp_express = intval($_GPC['temp_express']);
			$in = implode(',', $orderids);

			if (empty($in)) {
				exit();
			}

			$printTemp = pdo_fetch('SELECT id,type,expressname,express,expresscom FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE id=:id and type=:type and uniacid=:uniacid limit 1', array(':id' => $temp_express, ':type' => 1, ':uniacid' => $_W['uniacid']));
			if (empty($printTemp) || !is_array($printTemp)) {
				exit();
			}

			if (empty($printTemp['expresscom'])) {
				$printTemp['expresscom'] = '其他快递';
			}

			$orders = pdo_fetchall('SELECT o.id,o.orderno,o.addressid,o.address,o.status,o.pay_type,o.expresscom,o.expresssn,a.realname,a.mobile
                    FROM ' . tablename('ewei_shop_groups_order') . ' as o
                    left join ' . tablename('ewei_shop_member_address') . (' a on o.addressid = a.id
                    WHERE o.id in( ' . $in . ' ) and o.status = 1 and (o.is_team = 0 or o.success = 1) and o.uniacid=:uniacid order by o.orderno desc '), array(':uniacid' => $_W['uniacid']));

			if (empty($orders)) {
				exit();
			}

			$paytype = array(
				'none'   => array('css' => 'default', 'name' => '未支付'),
				'credit' => array('css' => 'danger', 'name' => '余额支付'),
				'other'  => array('css' => 'default', 'name' => '后台付款'),
				'wechat' => array('css' => 'success', 'name' => '微信支付')
			);
			$orderstatus = array(
				-1 => array('css' => 'default', 'name' => '已关闭'),
				0  => array('css' => 'danger', 'name' => '待付款'),
				1  => array('css' => 'info', 'name' => '待发货'),
				2  => array('css' => 'warning', 'name' => '待收货'),
				3  => array('css' => 'success', 'name' => '已完成')
			);

			foreach ($orders as $i => $order) {
				if (!empty($order['address'])) {
					$orders[$i]['address_address'] = iunserializer($order['address']);
				}
				else {
					$orders[$i]['address_address'] = iunserializer($order['addressid']);
				}

				if (is_array($orders[$i]['address_address'])) {
				}
				else {
					$orders[$i]['address_address'] = array('realname' => $order['realname'], 'mobile' => $order['mobile']);
				}

				if ($order['status'] == 1) {
					$orders[$i]['send_status'] = 1;
				}
				else {
					$orders[$i]['send_status'] = 0;
				}

				$p = $order['pay_type'];
				$orders[$i]['paycss'] = $paytype[$p]['css'];
				$orders[$i]['paytypename'] = $paytype[$p]['name'];
				$s = $order['status'];
				$orders[$i]['statuscss'] = $orderstatus[$s]['css'];
				$orders[$i]['statusname'] = $orderstatus[$s]['name'];

				if ($s == -1) {
					if ($order['refundstatus'] == 1) {
						$orders[$i]['statusname'] = '已退款';
					}
				}

				if (empty($order['expresscom'])) {
					$orders[$i]['expresscom'] = '其他快递';
				}
			}

			include $this->template('groups/exhelper/print_tpl_dosend');
		}
	}

	public function dosend()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$orderid = intval($_GPC['orderid']);
			$express = trim($_GPC['express']);
			$expresssn = intval($_GPC['expresssn']);
			$expresscom = trim($_GPC['expresscom']);
			$orderinfo = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_order') . ' WHERE id=:orderid and status>-1 and uniacid=:uniacid limit 1', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));

			if (empty($orderinfo)) {
				exit(json_encode(array('result' => 'error', 'resp' => '订单不存在')));
			}

			if ($orderinfo['status'] == 1) {
				pdo_update('ewei_shop_groups_order', array('express' => trim($express), 'expresssn' => trim($expresssn), 'expresscom' => trim($expresscom), 'sendtime' => time(), 'status' => 2), array('id' => $orderid));

				if (!empty($orderinfo['refundid'])) {
					$refund = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_refund') . ' where id=:id limit 1', array(':id' => $orderinfo['refundid']));

					if (!empty($refund)) {
						pdo_update('ewei_shop_groups_order_refund', array('status' => -1), array('id' => $orderinfo['refundid']));
						pdo_update('ewei_shop_groups_order', array('refundid' => 0), array('id' => $orderinfo['id']));
					}
				}

				p('groups')->sendTeamMessage($orderinfo['id']);
				plog('groups.exhelper.dosend', '一键发货 订单号: ' . $orderinfo['orderno'] . ' <br/>快递公司: ' . $_GPC['expresscom'] . ' 快递单号: ' . $_GPC['expresssn']);
				exit(json_encode(array('result' => 'success')));
			}
		}
	}

	public function batch()
	{
		global $_W;
		global $_GPC;
		$tab = $_GPC['tab'];
		$paytype = array(
			'none'   => array('css' => 'default', 'name' => '未支付'),
			'credit' => array('css' => 'danger', 'name' => '余额支付'),
			'other'  => array('css' => 'default', 'name' => '后台付款'),
			'wechat' => array('css' => 'success', 'name' => '微信支付')
		);
		$orderstatus = array(
			array('css' => 'danger', 'name' => '待付款'),
			array('css' => 'info', 'name' => '待发货'),
			array('css' => 'warning', 'name' => '待收货'),
			array('css' => 'success', 'name' => '已完成')
		);
		if (empty($starttime) && empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$printset = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exhelper_sys') . ' WHERE uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		$lodopUrl_ip = 'localhost';
		$lodopUrl_port = empty($printset['port']) ? 8000 : $printset['port'];
		$https = $_W['ishttps'] ? 'https://' : 'http://';
		$lodopUrl = $https . $lodopUrl_ip . ':' . $lodopUrl_port . '/CLodopfuncs.js';
		load()->func('tpl');
		include $this->template();
	}

	public function getdatabatch()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$condition = ' o.uniacid = :uniacid and m.uniacid = :uniacid and o.deleted=0 and o.addressid<>0 and o.isverify = 0  ';
			$paras = array(':uniacid' => $_W['uniacid']);

			if ($_GPC['paytype'] != '') {
				if ($_GPC['paytype'] == 'none') {
					$condition .= ' AND o.pay_type = \'\' ';
				}
				else {
					$condition .= ' AND o.pay_type = \'' . trim($_GPC['paytype']) . '\' ';
				}
			}

			$status = intval($_GPC['status']);
			$statuscondition = '';

			if ($status != '') {
				if ($status == 1) {
					$statuscondition = ' and ((o.status = 1 and o.is_team = 0) or (o.status = 1 and o.success = 1 )) ';
				}
				else {
					$statuscondition = ' AND o.status = ' . intval($status);
				}
			}
			else {
				$statuscondition = ' and o.status >= 0 ';
			}

			if (empty($starttime) || empty($endtime)) {
				$starttime = strtotime('-1 month');
				$endtime = time();
			}

			$searchtime = trim($_GPC['searchtime']);
			if (!empty($searchtime) && !empty($_GPC['starttime']) && !empty($_GPC['endtime']) && in_array($searchtime, array('create', 'pay', 'send', 'finish'))) {
				$starttime = strtotime($_GPC['starttime']);
				$endtime = strtotime($_GPC['endtime']);
				$condition .= ' AND o.' . $searchtime . 'time >= :starttime AND o.' . $searchtime . 'time <= :endtime ';
				$paras[':starttime'] = $starttime;
				$paras[':endtime'] = $endtime;
			}

			if ($_GPC['printstate'] != '') {
				$printstate = intval($_GPC['printstate']);

				if ($printstate == 0) {
					$condition .= ' AND o.printstate = 0 ';
				}
				else {
					$condition .= ' AND o.printstate > 0 ';
				}
			}

			if ($_GPC['printstate2'] != '') {
				$printstate2 = intval($_GPC['printstate2']);

				if ($printstate2 == 0) {
					$condition .= ' AND o.printstate2 = 0 ';
				}
				else {
					$condition .= ' AND o.printstate2 > 0 ';
				}
			}

			if (!empty($_GPC['searchfield']) && !empty($_GPC['keyword'])) {
				$searchfield = trim(strtolower($_GPC['searchfield']));
				$keyword = trim($_GPC['keyword']);

				if ($searchfield == 'ordersn') {
					$condition .= ' AND o.orderno LIKE \'%' . $keyword . '%\'';
				}
				else if ($searchfield == 'member') {
					$condition .= ' AND (m.realname LIKE \'%' . $keyword . '%\' or m.mobile LIKE \'%' . $keyword . '%\' or m.nickname LIKE \'%' . $keyword . '%\')';
				}
				else if ($searchfield == 'address') {
					$condition .= ' AND ( a.realname LIKE \'%' . $keyword . '%\' or a.mobile LIKE \'%' . $keyword . '%\' or o.realname LIKE \'%' . $keyword . '%\' or o.mobile LIKE \'%' . $keyword . '%\' )';
				}
				else if ($searchfield == 'expresssn') {
					$condition .= ' AND o.expresssn LIKE \'%' . $keyword . '%\'';
				}
				else if ($searchfield == 'goodstitle') {
					$condition .= ' AND g.title LIKE \'%' . $keyword . '%\'';
				}
				else {
					if ($searchfield == 'goodssn') {
						$condition .= ' AND g.goodssn LIKE \'%' . $keyword . '%\'';
					}
				}
			}

			$sql = 'select o.* ,a.realname ,m.nickname, d.dispatchname,m.nickname,r.refundstatus from ' . tablename('ewei_shop_groups_order') . ' o' . ' left join ' . tablename('ewei_shop_groups_goods') . ' g on g.id = o.goodid  ' . ' left join ' . tablename('ewei_shop_groups_order_refund') . ' r on r.orderid=o.id and ifnull(r.refundstatus,-1)<>-1' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = o.addressid ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . (' where ' . $condition . ' ' . $statuscondition . ' ORDER BY o.createtime DESC  ');
			$orders = pdo_fetchall($sql, $paras);
			$totalmoney = 0;

			foreach ($orders as $i => $order) {
				$totalmoney = $totalmoney + $order['price'];
				$totalmoney = number_format($totalmoney, 2);
				$paytype = array(
					'none'   => array('css' => 'default', 'name' => '未支付'),
					'credit' => array('css' => 'danger', 'name' => '余额支付'),
					'other'  => array('css' => 'default', 'name' => '后台付款'),
					'wechat' => array('css' => 'success', 'name' => '微信支付')
				);
				$orderstatus = array(
					array('css' => 'danger', 'name' => '待付款'),
					array('css' => 'info', 'name' => '待发货'),
					array('css' => 'warning', 'name' => '待收货'),
					array('css' => 'success', 'name' => '已完成')
				);
				$order_goods = pdo_fetchall('select g.id,g.title,g.shorttitle,g.thumb,g.goodssn,g.units as unit,g.goodssn as option_goodssn, g.productsn as option_productsn,
                    o.price, o.price as realprice,o.goodid as ordergoodid,o.printstate,o.printstate2,g.singleprice,g.groupsprice,o.is_team
                    from ' . tablename('ewei_shop_groups_order') . ' o
                    left join ' . tablename('ewei_shop_groups_goods') . ' g on g.id = o.goodid
                    where o.uniacid=:uniacid and o.id=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']));

				foreach ($order_goods as $ii => $order_good) {
					$order_goods[$ii]['total'] = 1;

					if (!empty($order_good['optionid'])) {
						$option = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_option') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $order_good['optionid'], ':uniacid' => $_W['uniacid']));
						$order_goods[$ii]['weight'] = $option['weight'];
					}
				}

				$value['goods'] = set_medias($order_goods, 'thumb');
				$p = $order['pay_type'];
				$orders[$i]['goods'] = $order_goods;
				$orders[$i]['pay_type'] = $paytype[$p]['name'];
				$orders[$i]['css'] = $paytype[$p]['css'];
				$orders[$i]['dispatchname'] = empty($order['addressid']) ? '自提' : $order['dispatchname'];

				if (empty($orders[$i]['dispatchname'])) {
					$orders[$i]['dispatchname'] = '快递';
				}

				if ($order['isverify'] == 1) {
					$orders[$i]['dispatchname'] = '线下核销';
				}
				else {
					if (!empty($order['virtual'])) {
						$orders[$i]['dispatchname'] = '虚拟物品(卡密)<br/>自动发货';
					}
				}

				$s = $order['status'];
				$orders[$i]['statusvalue'] = $s;
				$orders[$i]['statuscss'] = $orderstatus[$s]['css'];
				$orders[$i]['statusname'] = $orderstatus[$s]['name'];

				if (!empty($order['address'])) {
					$order_address = iunserializer($order['address']);
				}
				else {
					$order_address = iunserializer($order['addressid']);
				}

				if (!is_array($order_address)) {
					$member_address = pdo_fetch('SELECT a.*,m.nickname FROM ' . tablename('ewei_shop_member_address') . ' a
                    left join ' . tablename('ewei_shop_member') . ' m on m.openid=a.openid
                    WHERE a.id=:id and a.uniacid=:uniacid limit 1', array(':id' => $order['addressid'], ':uniacid' => $_W['uniacid']));
					$orders[$i]['address'] = array('realname' => $member_address['realname'], 'nickname' => $member_address['nickname'], 'mobile' => $member_address['mobile'], 'province' => $member_address['province'], 'city' => $member_address['city'], 'area' => $member_address['area'], 'street' => $member_address['street'], 'address' => $member_address['address']);
				}
				else {
					$orders[$i]['address'] = array('realname' => $order_address['realname'], 'nickname' => $order['nickname'], 'mobile' => $order_address['mobile'], 'province' => $order_address['province'], 'city' => $order_address['city'], 'area' => $order_address['area'], 'street' => $order_address['street'], 'address' => $order_address['address']);
				}

				if ($order['status'] == 1) {
					$orders[$i]['send_status'] = 1;
				}
				else {
					$orders[$i]['send_status'] = 0;
				}
			}

			$temps = $this->model->getTemp();
			extract($temps);
			include $this->template('groups/exhelper/print_tpl_batch_detail');
		}
	}

	public function saveuserbatch()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$ordersns = $_GPC['ordersns'];

			if (is_array($ordersns)) {
				$data = array('realname' => trim($_GPC['realname']), 'nickname' => trim($_GPC['nickname']), 'mobile' => intval($_GPC['mobile']), 'province' => trim($_GPC['province']), 'city' => trim($_GPC['city']), 'area' => trim($_GPC['area']), 'street' => trim($_GPC['street']), 'address' => trim($_GPC['address']));
				$address_send = iserializer($data);

				foreach ($ordersns as $ordersn) {
					pdo_update('ewei_shop_order', array('address_send' => $address_send), array('ordersn' => $ordersn));
				}

				exit();
			}
		}
	}

	public function getprintTempbatch()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$type = intval($_GPC['type']);
			$printTempId = intval($_GPC['printTempId']);
			$printUserId = intval($_GPC['printUserId']);

			if (empty($type)) {
				exit(json_encode(array('result' => 'error', 'resp' => '打印错误! 请刷新重试。EP01')));
			}

			if (empty($printTempId)) {
				exit(json_encode(array('result' => 'error', 'resp' => '加载模版错误! 请重新选择打印模板。EP02')));
			}

			if (empty($printUserId)) {
				exit(json_encode(array('result' => 'error', 'resp' => '加载模版错误! 请重新选择发件人信息模板。EP03')));
			}

			$tempSender = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exhelper_senduser') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $printUserId, ':uniacid' => $_W['uniacid']));
			$expTemp = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $printTempId, ':uniacid' => $_W['uniacid']));
			$shop_set = m('common')->getSysset('shop');
			$expDatas = htmlspecialchars_decode($expTemp['datas']);
			$expDatas = json_decode($expDatas, true);
			$expTemp['shopname'] = $shop_set['name'];
			$repItems = array('sendername', 'sendertel', 'senderaddress', 'sendersign', 'sendertime', 'sendercode', 'sendercccc');
			$repDatas = array($tempSender['sendername'], $tempSender['sendertel'], $tempSender['senderaddress'], $tempSender['sendersign'], date('Y-m-d H:i'), $tempSender['sendercode'], $tempSender['sendercity']);

			if (is_array($expDatas)) {
				foreach ($expDatas as $index => $data) {
					$expDatas[$index]['items'] = str_replace($repItems, $repDatas, $data['items']);
				}
			}

			exit(json_encode(array('result' => 'success', 'respDatas' => $expDatas, 'respUser' => $tempSender, 'respTemp' => $expTemp)));
		}
	}

	public function changestatebatch()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$arr = $_GPC['arr'];
			$type = intval($_GPC['type']);
			if (empty($arr) || empty($type)) {
				show_json(0, array('resp' => '数据错误。EP04'));
			}

			foreach ($arr as $i => $data) {
				$orderid = $data['orderid'];
				$ordergoodid = $data['ordergoodid'];
				$ordergood = pdo_fetch('SELECT id,goodid,printstate,printstate2 FROM ' . tablename('ewei_shop_groups_order') . ' WHERE goodid=:goodsid and id=:orderid and uniacid=:uniacid limit 1', array(':orderid' => $orderid, ':goodsid' => $ordergoodid, ':uniacid' => $_W['uniacid']));

				if ($type == 1) {
					pdo_update('ewei_shop_groups_order', array('printstate' => $ordergood['printstate'] + 1), array('id' => $ordergood['id']));
					$printstate[$data['orderid']] = $ordergood['printstate'] + 1;
					$orderprint = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' WHERE id=:orderid and printstate=0 and uniacid= :uniacid ', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));
				}
				else {
					if ($type == 2) {
						pdo_update('ewei_shop_groups_order', array('printstate2' => $ordergood['printstate2'] + 1), array('id' => $ordergood['id']));
						$printstate[$data['orderid']] = $ordergood['printstate2'] + 1;
						$orderprint = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_groups_order') . ' WHERE id=:orderid and printstate2=0 and uniacid= :uniacid ', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));
					}
				}
			}

			show_json(1, array('orderprintstate' => $printstate));
		}
	}

	public function dosendbatch()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$orderid = intval($_GPC['orderid']);
			$express = trim($_GPC['express']);
			$expresssn = intval($_GPC['expresssn']);
			$expresscom = trim($_GPC['expresscom']);
			$orderinfo = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_groups_order') . ' WHERE id=:orderid and status>-1 and uniacid=:uniacid limit 1', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));

			if (empty($orderinfo)) {
				exit(json_encode(array('result' => 'error', 'resp' => '订单不存在')));
			}

			if ($orderinfo['status'] == 1 && ($orderinfo['is_team'] == 0 || $orderinfo['success'] == 1)) {
				pdo_update('ewei_shop_groups_order', array('express' => trim($express), 'expresssn' => trim($expresssn), 'expresscom' => trim($expresscom), 'sendtime' => time(), 'status' => 2), array('id' => $orderid));

				if (!empty($orderinfo['refundid'])) {
					$refund = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order_refund') . ' where id=:id limit 1', array(':id' => $orderinfo['refundid']));

					if (!empty($refund)) {
						pdo_update('ewei_shop_groups_order_refund', array('status' => -1), array('id' => $orderinfo['refundid']));
						pdo_update('ewei_shop_groups_order', array('refundid' => 0), array('id' => $orderinfo['id']));
					}
				}

				plog('groups.exhelper.batchdosend', '一键发货 订单号: ' . $orderinfo['orderno'] . ' <br/>快递公司: ' . $_GPC['expresscom'] . ' 快递单号: ' . $_GPC['expresssn']);
				exit(json_encode(array('result' => 'success')));
			}
		}
	}
}

?>
