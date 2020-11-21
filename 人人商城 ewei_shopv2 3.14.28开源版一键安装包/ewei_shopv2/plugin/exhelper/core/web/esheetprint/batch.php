<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Batch_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$paytype = array(
			0  => array('css' => 'default', 'name' => '未支付'),
			1  => array('css' => 'danger', 'name' => '余额支付'),
			11 => array('css' => 'default', 'name' => '后台付款'),
			2  => array('css' => 'danger', 'name' => '在线支付'),
			21 => array('css' => 'success', 'name' => '微信支付'),
			22 => array('css' => 'warning', 'name' => '支付宝支付'),
			23 => array('css' => 'warning', 'name' => '银联支付'),
			3  => array('css' => 'primary', 'name' => '货到付款')
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

		$printset = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_exhelper_sys') . ' WHERE uniacid=:uniacid and merchid=0 limit 1', array(':uniacid' => $_W['uniacid']));
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
		$uniacid = $_W['uniacid'];

		if ($_W['ispost']) {
			$condition = ' o.uniacid = :uniacid and o.deleted=0 and o.isparent=0 and o.city_express_state=0 ';
			$condition .= ' and (o.addressid<>0 and o.isverify=0 and o.virtual=0 and o.merchid=0 and o.deleted=0)';
			$paras = array(':uniacid' => $_W['uniacid']);

			if ($_GPC['paytype'] != '') {
				if ($_GPC['paytype'] == '2') {
					$condition .= ' AND ( o.paytype =21 or o.paytype=22 or o.paytype=23 )';
				}
				else {
					$condition .= ' AND o.paytype =' . intval($_GPC['paytype']);
				}
			}

			$status = intval($_GPC['status']);
			$statuscondition = '';

			if ($status != '') {
				if ($status == '4') {
					$statuscondition = ' AND o.refundstate>0 and o.refundid<>0';
				}
				else if ($status == '5') {
					$statuscondition = ' AND o.refundtime<>0';
				}
				else if ($status == '1') {
					$statuscondition = ' AND ( o.status = 1 or (o.status=0 and o.paytype=3) )';
				}
				else if ($status == '0') {
					$statuscondition = ' AND o.status = 0 and o.paytype<>3';
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

			if ($_GPC['printstate'] != '') {
				$printstate = intval($_GPC['printstate']);
				$condition .= ' AND o.printstate=' . $printstate . ' ';
			}

			if ($_GPC['printstate2'] != '') {
				$printstate2 = intval($_GPC['printstate2']);
				$condition .= ' AND o.printstate2=' . $printstate2 . ' ';
			}

			$sqlcondition = '';
			if (!empty($_GPC['searchfield']) && !empty($_GPC['keyword'])) {
				$searchfield = trim(strtolower($_GPC['searchfield']));
				$keyword = trim($_GPC['keyword']);

				if ($searchfield == 'ordersn') {
					$condition .= ' AND o.ordersn LIKE \'%' . $keyword . '%\'';
				}
				else if ($searchfield == 'member') {
					$condition .= ' AND (m.realname LIKE \'%' . $keyword . '%\' or m.mobile LIKE \'%' . $keyword . '%\' or m.nickname LIKE \'%' . $keyword . '%\')';
				}
				else if ($searchfield == 'address') {
					$condition .= ' AND ( a.realname LIKE \'%' . $keyword . '%\' or a.mobile LIKE \'%' . $keyword . '%\' or o.carrier LIKE \'%' . $keyword . '%\' )';
				}
				else if ($searchfield == 'expresssn') {
					$condition .= ' AND o.expresssn LIKE \'%' . $keyword . '%\'';
				}
				else if ($searchfield == 'goodstitle') {
					$sqlcondition = ' inner join ( select distinct og.orderid from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . (' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and og.merchid=0 and (locate(:keyword,g.title)>0)) gs on gs.orderid=o.id');
					$paras[':keyword'] = trim($_GPC['keyword']);
				}
				else {
					if ($searchfield == 'goodssn') {
						$sqlcondition = ' inner join ( select distinct og.orderid from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . (' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and og.merchid=0 and (locate(:keyword,g.goodssn)>0)) gs on gs.orderid=o.id');
						$paras[':keyword'] = trim($_GPC['keyword']);
					}
				}
			}

			$sql = 'select o.* ,a.realname ,m.nickname, d.dispatchname,m.nickname,r.status as refundstatus from ' . tablename('ewei_shop_order') . ' o' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.orderid=o.id and ifnull(r.status,-1)<>-1 and ifnull(r.status,-1)<> -2' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid = o.uniacid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . $sqlcondition . (' where ' . $condition . ' ' . $statuscondition . '  ORDER BY o.createtime DESC,o.status DESC  ');
			$orders = pdo_fetchall($sql, $paras);
			$totalmoney = 0;

			foreach ($orders as $i => $order) {
				$totalmoney = $totalmoney + $order['price'];
				$totalmoney = number_format($totalmoney, 2);
				$paytype = array(
					0  => array('css' => 'default', 'name' => '未支付'),
					1  => array('css' => 'danger', 'name' => '余额支付'),
					11 => array('css' => 'default', 'name' => '后台付款'),
					2  => array('css' => 'danger', 'name' => '在线支付'),
					21 => array('css' => 'success', 'name' => '微信支付'),
					22 => array('css' => 'warning', 'name' => '支付宝支付'),
					23 => array('css' => 'warning', 'name' => '银联支付'),
					3  => array('css' => 'primary', 'name' => '货到付款')
				);
				$orderstatus = array(
					-1 => array('css' => 'default', 'name' => '已关闭'),
					0  => array('css' => 'danger', 'name' => '待付款'),
					1  => array('css' => 'info', 'name' => '待发货'),
					2  => array('css' => 'warning', 'name' => '待收货'),
					3  => array('css' => 'success', 'name' => '已完成')
				);
				$order_goods = pdo_fetchall('select g.id,g.title,g.shorttitle,g.thumb,g.unit,g.goodssn,og.optionid,og.goodssn as option_goodssn, g.productsn, g.weight, og.productsn as option_productsn, og.total,og.price,og.optionname as optiontitle, og.realprice,og.printstate,og.printstate2,og.id as ordergoodid,og.esheetprintnum,og.ordercode from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.merchid=0 and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']));

				foreach ($order_goods as $ii => $order_good) {
					if (!empty($order_good['optionid'])) {
						$option = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_option') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $order_good['optionid'], ':uniacid' => $_W['uniacid']));
						$order_goods[$ii]['weight'] = $option['weight'];
						$order_goods[$ii]['goodssn'] = $option['goodssn'];
						$order_goods[$ii]['productsn'] = $option['productsn'];
						$order_goods[$ii]['unit'] = $option['unit'];
					}
				}

				$order_goods = set_medias($order_goods, 'thumb');
				$p = $order['paytype'];
				$orders[$i]['goods'] = $order_goods;
				$orders[$i]['paytype'] = $paytype[$p]['name'];
				$orders[$i]['css'] = $paytype[$p]['css'];
				$orders[$i]['dispatchname'] = empty($order['addressid']) ? '自提' : $order['dispatchname'];

				if (empty($orders[$i]['dispatchname'])) {
					$orders[$i]['dispatchname'] = '快递';
				}

				if ($order['isverify'] == 1) {
					$orders[i]['dispatchname'] = '线下核销';
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

				if (!empty($order['address_send'])) {
					$orders[$i]['address'] = iunserializer($order['address_send']);
				}
				else {
					$orders[$i]['address'] = iunserializer($order['address']);
				}

				$orders[$i]['address']['address'] = $orders[$i]['address']['street'] . $orders[$i]['address']['address'];
				$orders[$i]['address']['nickname'] = $order['nickname'];

				if ($order['dispatchtype'] == 1) {
					$order['carrier'] = iunserializer($order['carrier']);
					$store = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_store') . ' WHERE id=:id and uniacid=:uniacid limit 1', array(':id' => $order['storeid'], ':uniacid' => $_W['uniacid']));
					$orders[$i]['address']['realname'] = $order['carrier']['carrier_realname'];
					$orders[$i]['address']['mobile'] = $order['carrier']['carrier_mobile'];
					$orders[$i]['address']['address'] = '[' . $store['storename'] . ']' . $store['address'];
					$orders[$i]['address']['province'] = '用户自提';
					$orders[$i]['address']['city'] = '用户自提';
					$orders[$i]['address']['area'] = '用户自提';
				}

				if ($order['status'] == 1 || $order['status'] == 0 && $order['paytype'] == 3) {
					$orders[$i]['send_status'] = 1;
				}
				else {
					$orders[$i]['send_status'] = 0;
				}
			}

			$temps = $this->model->getTemp();
			extract($temps);
			include $this->template('exhelper/esheetprint/batch/print_tpl_detail');
		}
	}

	public function saveuser()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$ordersns = $_GPC['ordersns'];

			if (is_array($ordersns)) {
				$data = array('realname' => trim($_GPC['realname']), 'nickname' => trim($_GPC['nickname']), 'mobile' => intval($_GPC['mobile']), 'province' => trim($_GPC['province']), 'city' => trim($_GPC['city']), 'area' => trim($_GPC['area']), 'address' => trim($_GPC['address']));
				$address_send = iserializer($data);

				foreach ($ordersns as $ordersn) {
					pdo_update('ewei_shop_order', array('address_send' => $address_send), array('ordersn' => $ordersn, 'merchid' => 0));
				}

				exit();
			}
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
				exit(json_encode(array('result' => 'error', 'resp' => '数据错误。EP04')));
			}

			foreach ($arr as $i => $data) {
				$orderid = $data['orderid'];
				$ordergoodid = $data['ordergoodid'];
				$ordergood = pdo_fetch('SELECT id,goodsid,printstate,printstate2 FROM ' . tablename('ewei_shop_order_goods') . ' WHERE goodsid=:goodsid and orderid=:orderid and uniacid=:uniacid and merchid=0 limit 1', array(':orderid' => $orderid, ':goodsid' => $ordergoodid, ':uniacid' => $_W['uniacid']));

				if ($type == 1) {
					pdo_update('ewei_shop_order_goods', array('printstate' => $ordergood['printstate'] + 1), array('id' => $ordergood['id']));
					$orderprint = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_order_goods') . ' WHERE orderid=:orderid and printstate=0 and uniacid= :uniacid and merchid=0', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));
				}
				else {
					if ($type == 2) {
						pdo_update('ewei_shop_order_goods', array('printstate2' => $ordergood['printstate2'] + 1), array('id' => $ordergood['id']));
						$orderprint = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_order_goods') . ' WHERE orderid=:orderid and printstate2=0 and uniacid= :uniacid and merchid=0', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));
					}
				}

				if ($orderprint == 0) {
					$printstatenum = 2;
				}
				else {
					$printstatenum = 1;
				}

				if ($type == 1) {
					pdo_update('ewei_shop_order', array('printstate' => $printstatenum), array('id' => $orderid));
				}
				else {
					if ($type == 2) {
						pdo_update('ewei_shop_order', array('printstate2' => $printstatenum), array('id' => $orderid));
					}
				}
			}

			exit(json_encode(array('result' => 'success', 'orderprintstate' => $printstatenum)));
		}
	}

	public function getorderinfo()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$orderids = $_GPC['orderids'];
			$temp_esheetid = intval($_GPC['temp_esheetid']);
			$in = implode(',', $orderids);

			if (empty($in)) {
				exit();
			}

			$params = array(':uniacid' => $_W['uniacid'], ':id' => $temp_esheetid);
			$sql = 'SELECT temp.id,temp.esheetname,esheet.express,esheet.name as expresscom  FROM ' . tablename('ewei_shop_exhelper_esheet_temp') . ' temp ' . ' left join ' . tablename('ewei_shop_exhelper_esheet') . ' esheet on temp.esheetid = esheet.id ' . ' where temp.id=:id and temp.uniacid=:uniacid and temp.merchid=0 limit 1';
			$printTemp = pdo_fetch($sql, $params);
			if (empty($printTemp) || !is_array($printTemp)) {
				exit();
			}

			$orders = pdo_fetchall('SELECT id,ordersn,address,address_send,status,paytype,expresscom,expresssn,express,dispatchtype FROM ' . tablename('ewei_shop_order') . (' WHERE id in( ' . $in . ' ) and (status=1 or (paytype=3 and status=0)) and uniacid=:uniacid and merchid=0 and isparent=0 order by ordersn desc '), array(':uniacid' => $_W['uniacid']));

			if (empty($orders)) {
				exit();
			}

			$paytype = array(
				0  => array('css' => 'default', 'name' => '未支付'),
				1  => array('css' => 'danger', 'name' => '余额支付'),
				11 => array('css' => 'default', 'name' => '后台付款'),
				2  => array('css' => 'danger', 'name' => '在线支付'),
				21 => array('css' => 'success', 'name' => '微信支付'),
				22 => array('css' => 'warning', 'name' => '支付宝支付'),
				23 => array('css' => 'warning', 'name' => '银联支付'),
				3  => array('css' => 'primary', 'name' => '货到付款')
			);
			$orderstatus = array(
				-1 => array('css' => 'default', 'name' => '已关闭'),
				0  => array('css' => 'danger', 'name' => '待付款'),
				1  => array('css' => 'info', 'name' => '待发货'),
				2  => array('css' => 'warning', 'name' => '待收货'),
				3  => array('css' => 'success', 'name' => '已完成')
			);

			foreach ($orders as $i => $order) {
				if (!empty($order['address_send'])) {
					$orders[$i]['address_address'] = iunserializer($order['address_send']);
				}
				else {
					$orders[$i]['address_address'] = iunserializer($order['address']);
				}

				if ($order['status'] == 1 || $order['status'] == 0 && $order['paytype'] == 3) {
					$orders[$i]['send_status'] = 1;
				}
				else {
					$orders[$i]['send_status'] = 0;
				}

				$p = $order['paytype'];
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
			}

			include $this->template('exhelper/esheetprint/print_tpl_dosend');
		}
	}

	public function dosend()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$orderid = intval($_GPC['orderid']);
			$express = trim($_GPC['express']);
			$expresssn = trim($_GPC['expresssn']);
			$expresscom = trim($_GPC['expresscom']);
			$orderinfo = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id=:orderid and status>-1 and uniacid=:uniacid and merchid=0 limit 1', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));

			if (empty($orderinfo)) {
				exit(json_encode(array('result' => 'error', 'resp' => '订单不存在')));
			}

			if ($orderinfo['status'] == 1 || $orderinfo['status'] == 0 && $orderinfo['paytype'] == 3) {
				pdo_update('ewei_shop_order', array('express' => trim($express), 'expresssn' => trim($expresssn), 'expresscom' => trim($expresscom), 'sendtime' => time(), 'status' => 2, 'refundstate' => 0), array('id' => $orderid));

				if (!empty($orderinfo['refundid'])) {
					$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $orderinfo['refundid']));

					if (!empty($refund)) {
						pdo_update('ewei_shop_order_refund', array('status' => -1, 'endtime' => time()), array('id' => $orderinfo['refundid']));
						pdo_update('ewei_shop_order', array('refundid' => 0), array('id' => $orderinfo['id']));
					}
				}

				m('notice')->sendOrderMessage($orderinfo['id']);
				plog('exhelper.print.batch.dosend', '一键发货 订单号: ' . $orderinfo['ordersn'] . ' <br/>快递公司: ' . $_GPC['expresscom'] . ' 快递单号: ' . $_GPC['expresssn']);
				exit(json_encode(array('result' => 'success')));
			}
		}
	}

	public function getesheetTemp()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$temp_senderid = intval($_GPC['temp_senderid']);
			$temp_esheetid = intval($_GPC['temp_esheetid']);

			if (empty($temp_esheetid)) {
				exit(json_encode(array('result' => 'error', 'resp' => '加载模版错误! 请重新选择打印模板。')));
			}

			if (empty($temp_senderid)) {
				exit(json_encode(array('result' => 'error', 'resp' => '加载模版错误! 请重新选择发件人信息模板。')));
			}

			if (empty($_GPC['printarr']['orderid'])) {
				exit(json_encode(array('result' => 'error', 'resp' => '未找到相关订单')));
			}

			$params = array(':uniacid' => $_W['uniacid'], ':id' => $temp_esheetid);
			$sql = 'SELECT *  FROM ' . tablename('ewei_shop_exhelper_esheet_temp') . ' temp ' . ' left join ' . tablename('ewei_shop_exhelper_esheet') . ' esheet on temp.esheetid = esheet.id ' . ' where temp.id=:id and temp.uniacid=:uniacid and temp.merchid=0 limit 1';
			$esheet_item = pdo_fetch($sql, $params);
			$sender_item = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_exhelper_senduser') . ' WHERE id=:id and uniacid=:uniacid and merchid=0 limit 1', array(':id' => $temp_senderid, ':uniacid' => $_W['uniacid']));
			$orderids = explode(',', $_GPC['printarr']['orderid']);
			$template = pdo_fetch('SELECT id, ordersn, print_template  FROM ' . tablename('ewei_shop_order') . ' WHERE id=:id limit 1', array('id' => $orderids[0]));
			$replace_str = array('\'', '"', '#', '&', '+', '<', '>', ',');
			$ordercode = $template['ordersn'];
			$eorder = array();
			$eorder['ShipperCode'] = $esheet_item['code'];
			$eorder['OrderCode'] = trim($_GPC['printarr']['ordercode']);
			$eorder['OrderCode'] = $ordercode;
			$eorder['PayType'] = $esheet_item['paytype'];
			$eorder['ExpType'] = 1;
			$eorder['CustomerName'] = $esheet_item['customername'];
			$eorder['CustomerPwd'] = $esheet_item['customerpwd'];
			$eorder['MonthCode'] = $esheet_item['monthcode'];
			$eorder['SendSite'] = $esheet_item['sendsite'];
			$eorder['IsNotice'] = $esheet_item['isnotice'];
			$sender = array();
			$sender['Name'] = $sender_item['sendername'];
			$sender['Mobile'] = $sender_item['sendertel'];
			$sender['ProvinceName'] = $sender_item['province'];
			$sender['CityName'] = $sender_item['city'];
			$sender['ExpAreaName'] = $sender_item['area'];
			$sender['Address'] = $sender_item['senderaddress'];
			$sender['PostCode'] = $sender_item['sendercode'];
			$sender['ExpAreaName'] = str_replace($replace_str, '', trim($sender['ExpAreaName']));
			$sender['Address'] = str_replace($replace_str, '', trim($sender['Address']));
			$receiver = array();
			$receiver['Name'] = trim($_GPC['printarr']['Name']);
			$receiver['Mobile'] = trim($_GPC['printarr']['Mobile']);
			$receiver['ProvinceName'] = trim($_GPC['printarr']['ProvinceName']);
			$receiver['CityName'] = trim($_GPC['printarr']['CityName']);
			$receiver['ExpAreaName'] = trim($_GPC['printarr']['ExpAreaName']);
			$receiver['ExpAreaName'] = str_replace($replace_str, '', trim($receiver['ExpAreaName']));
			$receiver['Address'] = trim($_GPC['printarr']['Address']);
			$receiver['Address'] = str_replace($replace_str, '', trim($receiver['Address']));
			if ($esheet_item['code'] == 'EMS' || $esheet_item['code'] == 'YZPY' || $esheet_item['code'] == 'YZBK') {
				$receiver['PostCode'] = '000000';
			}

			$commodityOne = array();
			$goodsname = str_replace($replace_str, '', trim($_GPC['printarr']['sendinfo']));
			$goods_name = '商品：' . $goodsname;
			$commodityOne['GoodsName'] = $goods_name;
			$commodityOne['Goodsquantity'] = intval($_GPC['printarr']['all_total']);
			$commodity = array();
			$commodity[] = $commodityOne;
			$eorder['Sender'] = $sender;
			$eorder['Receiver'] = $receiver;
			$eorder['Commodity'] = $commodity;
			$eorder['IsReturnPrintTemplate'] = '1';

			if ($esheet_item['code'] == 'YTO') {
				$esheet_item['templatesize'] = 180;
			}

			if (!empty($esheet_item['templatesize'])) {
				$eorder['TemplateSize'] = $esheet_item['templatesize'];
			}

			$jsonResult = $this->model->submitEOrder($eorder);
			$result = json_decode($jsonResult['content'], true);
			if ($result['ResultCode'] == '100' || $result['Success'] === true) {
				$printTemplate = str_replace('[二维码]', 'VIP客户', $result['PrintTemplate']);
				$printTemplate = preg_replace_callback('/商品：(.*)<\\/div>/', function($match) use($goodsname) {
					return $goodsname;
				}, $printTemplate);
				pdo_query('UPDATE ' . tablename('ewei_shop_order_goods') . ' SET `esheetprintnum` = `esheetprintnum` + 1 WHERE id in (' . $_GPC['printarr']['ordergoodid'] . ')');
				pdo_update('ewei_shop_order_goods', array('ordercode' => $eorder['OrderCode']), array('id' => explode(',', $_GPC['printarr']['ordergoodid'])));

				foreach ($orderids as $orderid) {
					$orderinfo = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_order') . ' WHERE id=:orderid and status>-1 and uniacid=:uniacid and merchid=0 limit 1', array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));

					if (empty($orderinfo)) {
						continue;
					}

					if ($orderinfo['status'] == 1 || $orderinfo['status'] == 0 && $orderinfo['paytype'] == 3) {
						$data = array('express' => trim($esheet_item['express']), 'expresssn' => trim($result['Order']['LogisticCode']), 'expresscom' => trim($esheet_item['name']), 'sendtime' => time(), 'refundstate' => 0, 'print_template' => $printTemplate);

						if ($esheet_item['issend'] == 1) {
							$data['status'] = 2;

							if (!empty($orderinfo['refundid'])) {
								$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $orderinfo['refundid']));

								if (!empty($refund)) {
									pdo_update('ewei_shop_order_refund', array('status' => -1, 'endtime' => time()), array('id' => $orderinfo['refundid']));
									pdo_update('ewei_shop_order', array('refundid' => 0), array('id' => $orderinfo['id']));
								}
							}
						}

						$update_res = pdo_update('ewei_shop_order', $data, array('id' => $orderinfo['id']));
						if ($update_res && $data['status'] == 2) {
							m('notice')->sendOrderMessage($orderinfo['id']);
							plog('exhelper.print.batch.dosend', '自动发货 订单号: ' . $orderinfo['ordersn'] . ' <br/>快递公司: ' . $_GPC['expresscom'] . ' 快递单号: ' . $_GPC['expresssn']);
						}
					}
				}

				exit(json_encode(array('result' => 'success', 'PrintTemplate' => $printTemplate, 'ordercode' => $eorder['OrderCode'], 'issend' => $esheet_item['issend'])));
			}
			else {
				exit(json_encode(array('result' => 'error', 'resp' => $result['Reason'])));
			}
		}
	}
}

?>
