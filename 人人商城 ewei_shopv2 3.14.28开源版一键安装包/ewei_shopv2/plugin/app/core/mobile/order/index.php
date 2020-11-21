<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	protected function merchData()
	{
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		return array('is_openmerch' => $is_openmerch, 'merch_plugin' => $merch_plugin, 'merch_data' => $merch_data);
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];

		if (empty($openid)) {
			return app_error(AppError::$ParamsError);
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$show_status = $_GPC['status'];
		$r_type = array('退款', '退货退款', '换货');
		$condition = ' and openid=:openid and ismr=0 and deleted=0 and uniacid=:uniacid ';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$merchdata = $this->merchData();
		extract($merchdata);
		$condition .= ' and merchshow=0 ';

		if ($show_status != '') {
			$show_status = intval($show_status);

			switch ($show_status) {
			case 0:
				$condition .= ' and status=0 and paytype!=3';
				break;

			case 1:
				$condition .= ' AND ( status = 1 or (status=0 and paytype=3) )';
				break;

			case 2:
				$condition .= ' and (status=2 or status=0 and paytype=3)';
				break;

			case 4:
				$condition .= ' and refundstate>0';
				break;

			case 5:
				$condition .= ' and userdeleted=1 ';
				break;

			case 6:
				$condition .= ' and userdeleted=0 ';
				break;

			default:
				$condition .= ' and status=' . intval($show_status);
			}

			if ($show_status != 5) {
				$condition .= ' and userdeleted=0 ';
			}
		}
		else {
			$condition .= ' and userdeleted=0 ';
		}

		$com_verify = com('verify');
		$list = pdo_fetchall('select id,ordersn,price,userdeleted,isparent,refundstate,paytype,status,addressid,refundid,isverify,dispatchtype,verifytype,verifyinfo,verifycode,iscomment,iscycelbuy,verified,createtime from ' . tablename('ewei_shop_order') . (' where 1 ' . $condition . ' order by createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . (' where 1 ' . $condition), $params);
		$refunddays = intval($_W['shopset']['trade']['refunddays']);

		if ($is_openmerch == 1) {
			$merch_user = $merch_plugin->getListUser($list, 'merch_user');
		}

		$isonlyverifygoods = false;

		foreach ($list as &$row) {
			$param = array();

			if ($row['isparent'] == 1) {
				$scondition = ' og.parentorderid=:parentorderid';
				$param[':parentorderid'] = $row['id'];
			}
			else {
				$scondition = ' og.orderid=:orderid';
				$param[':orderid'] = $row['id'];
			}

			$sql = 'SELECT og.id,og.goodsid,og.total,g.title,g.thumb,g.type, og.price,og.optionname as optiontitle,op.marketprice,g.marketprice as gprice,og.optionid,op.specs,g.merchid,g.status,og.single_refundid,og.single_refundstate FROM ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . (' where ' . $scondition . ' order by og.id asc');
			$goods = pdo_fetchall($sql, $param);
			$goods = set_medias($goods, array('thumb'));
			$ismerch = 0;
			$merch_array = array();
			$g = 0;
			$nog = 0;

			foreach ($goods as &$r) {
				$merchid = $r['merchid'];
				$merch_array[$merchid] = $merchid;

				if (!empty($r['specs'])) {
					$thumb = m('goods')->getSpecThumb($r['specs']);

					if (!empty($thumb)) {
						$r['thumb'] = tomedia($thumb);
					}
				}

				if ($r['status'] == 2) {
					$giftinfo = pdo_fetch('select id,title,thumb,marketprice,total from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 2  and id = ' . $r['goodsid'] . ' ');
					if (empty($giftinfo) || $giftinfo['total'] == 0) {
						continue;
					}

					$row['gift'][$g] = $r;
					++$g;
				}
				else {
					$row['nogift'][$nog] = $r;
					++$nog;
				}

				if ($r['type'] == 5) {
					$isonlyverifygoods = true;
				}

				if (empty($r['marketprice'])) {
					$r['marketprice'] = $r['gprice'];
				}
			}

			unset($r);

			if (!empty($merch_array)) {
				if (1 < count($merch_array)) {
					$ismerch = 1;
				}
			}

			if (empty($goods)) {
				$goods = array();
			}

			foreach ($goods as &$r) {
				$r['thumb'] .= '?t=' . random(50);
			}

			unset($r);
			$goods_list = array();
			$i = 0;

			if ($ismerch) {
				$getListUser = $merch_plugin->getListUser($goods);
				$merch_user = $getListUser['merch_user'];

				foreach ($getListUser['merch'] as $k => $v) {
					if (empty($merch_user[$k]['merchname'])) {
						$goods_list[$i]['shopname'] = $_W['shopset']['shop']['name'];
					}
					else {
						$goods_list[$i]['shopname'] = $merch_user[$k]['merchname'];
					}

					$goods_list[$i]['goods'] = $v;
					++$i;
				}
			}
			else {
				if ($merchid == 0) {
					$goods_list[$i]['shopname'] = $_W['shopset']['shop']['name'];
				}
				else {
					$merch_data = $merch_plugin->getListUserOne($merchid);
					$goods_list[$i]['shopname'] = $merch_data['merchname'];
				}

				$goods_list[$i]['goods'] = $goods;
			}

			$row['goods'] = $goods_list;
			$statuscss = 'text-cancel';
			$nextstatus = '';

			switch ($row['status']) {
			case '-1':
				$status = '已取消';
				break;

			case '0':
				if ($row['paytype'] == 3) {
					$status = '待发货';
					$nextstatus = '确认收货';
				}
				else {
					$status = '待付款';
					$nextstatus = '立即付款';
				}

				$statuscss = 'text-cancel';
				break;

			case '1':
				if ($row['isverify'] == 1) {
					$status = '使用中';
				}
				else if (empty($row['addressid'])) {
					$status = '待取货';
					$nextstatus = '确认收货';
				}
				else {
					$status = '待发货';
				}

				$statuscss = 'text-warning';
				break;

			case '2':
				$status = '待收货';
				$statuscss = 'text-danger';
				$nextstatus = '确认收货';
				break;

			case '3':
				if (empty($row['iscomment'])) {
					if ($show_status == 5) {
						$status = '已完成';
					}
					else {
						$status = empty($_W['shopset']['trade']['closecomment']) ? '待评价' : '已完成';
						$nextstatus = '去评价';
					}
				}
				else {
					$status = '交易完成';
				}

				$statuscss = 'text-success';
				break;
			}

			$row['statusstr'] = $status;
			$row['nextstatus'] = $nextstatus;
			$row['statuscss'] = $statuscss;
			if (0 < $row['refundstate'] && !empty($row['refundid'])) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $row['refundid'], ':uniacid' => $uniacid, ':orderid' => $row['id']));

				if (!empty($refund)) {
					$row['statusstr'] = '待' . $r_type[$refund['rtype']];
				}
			}

			$row['canverify'] = false;
			$canverify = false;

			if ($com_verify) {
				$showverify = ($row['dispatchtype'] || $row['isverify']) && !$isonlyverifygoods;

				if ($row['isverify']) {
					if (!$isonlyverifygoods) {
						if ($row['verifytype'] == 0 || $row['verifytype'] == 1) {
							$vs = iunserializer($row['verifyinfo']);
							$verifyinfo = array(
								array('verifycode' => $row['verifycode'], 'verified' => $row['verifytype'] == 0 ? $row['verified'] : $row['goods'][0]['total'] <= count($vs))
							);

							if ($row['verifytype'] == 0) {
								$canverify = empty($row['verified']) && $showverify;
							}
							else {
								if ($row['verifytype'] == 1) {
									$canverify = count($vs) < $row['goods'][0]['total'] && $showverify;
								}
							}
						}
						else {
							$verifyinfo = iunserializer($row['verifyinfo']);
							$last = 0;

							foreach ($verifyinfo as $v) {
								if (!$v['verified']) {
									++$last;
								}
							}

							$canverify = 0 < $last && $showverify;
						}
					}
				}
				else {
					if (!empty($row['dispatchtype'])) {
						$canverify = $row['status'] == 1 && $showverify;
					}
				}
			}

			$row['canverify'] = $canverify;

			if ($is_openmerch == 1) {
				$row['merchname'] = $merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name'];
			}

			$row['isonlyverifygoods'] = $isonlyverifygoods;

			if ($row['isonlyverifygoods']) {
				$row['canverify'] = false;
				$verifygood = pdo_fetch('select * from ' . tablename('ewei_shop_verifygoods') . ' where orderid=:orderid limit 1', array(':orderid' => $row['id']));

				if (!empty($verifygood)) {
					$row['verifygoods_id'] = $verifygood['id'];
					$verifynum = pdo_fetchcolumn('select sum(verifynum) from ' . tablename('ewei_shop_verifygoods_log') . '    where verifygoodsid =:id  ', array(':id' => $verifygood['id']));

					if (empty($verifygood['limittype'])) {
						$limitdate = intval($verifygood['starttime']) + intval($verifygood['limitdays']) * 86400;
					}
					else {
						$limitdate = intval($verifygood['limitdate']);
					}

					$row['canverify'] = time() <= $limitdate;

					if (0 < $verifygood['limitnum']) {
						$row['canverify'] = $verifynum < $verifygood['limitnum'];
					}
				}
			}

			$row['cancancel'] = !$row['userdeleted'] && !$row['status'];
			$row['canpay'] = $row['paytype'] != 3 && !$row['userdeleted'] && $row['status'] == 0;
			$row['canverify'] = $row['canverify'] && $row['status'] != -1 && $row['status'] != 0;
			$row['candelete'] = $row['status'] == 3 || $row['status'] == -1;
			$row['cancomment'] = $row['status'] == 3 && $row['iscomment'] == 0 && empty($_W['shopset']['trade']['closecomment']);
			$row['cancomment2'] = $row['status'] == 3 && $row['iscomment'] == 1 && empty($_W['shopset']['trade']['closecomment']);
			$row['cancomplete'] = $row['status'] == 2;
			$row['cancancelrefund'] = 0 < $row['refundstate'] && isset($refund) && $refund['status'] != 5;
			$row['candelete2'] = $row['userdeleted'] == 1;
			$row['canrestore'] = $row['userdeleted'] == 1;
			$row['hasexpress'] = 1 < $row['status'] && 0 < $row['addressid'];
		}

		unset($row);
		$can_sync_goodscircle = false;
		$goodscircle_set = m('common')->getPluginset('goodscircle');
		if (p('goodscircle') && $goodscircle_set['order']) {
			$can_sync_goodscircle = true;
		}

		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total, 'page' => $pindex, 'can_sync_goodscircle' => $can_sync_goodscircle));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['id']);
		$ispeerpay = m('order')->checkpeerpay($orderid);
		if (empty($orderid) || empty($openid)) {
			return app_error(AppError::$ParamsError);
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		$seckill_color = '';

		if (0 < $order['seckilldiscountprice']) {
			$where = ' WHERE uniacid=:uniacid AND type = 5';
			$params = array(':uniacid' => $_W['uniacid']);
			$page = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_page') . $where . ' LIMIT 1 ', $params);

			if (!empty($page)) {
				$data = base64_decode($page['data']);
				$diydata = json_decode($data, true);
				$seckill_color = $diydata['page']['seckill']['color'];
			}
		}

		$isonlyverifygoods = m('order')->checkisonlyverifygoods($order['id']);

		if (empty($order)) {
			return app_error(AppError::$OrderNotFound);
		}

		if ($order['merchshow'] == 1) {
			return app_error(AppError::$OrderNotFound);
		}

		if ($order['userdeleted'] == 2) {
			return app_error(AppError::$OrderNotFound);
		}

		$merchdata = $this->merchData();
		extract($merchdata);
		$merchid = $order['merchid'];
		$diyform_plugin = p('diyform');
		$diyformfields = '';

		if ($diyform_plugin) {
			$diyformfields = ',og.diyformfields,og.diyformdata';
		}

		$param = array();
		$param[':uniacid'] = $_W['uniacid'];

		if ($order['isparent'] == 1) {
			$scondition = ' og.parentorderid=:parentorderid';
			$param[':parentorderid'] = $orderid;
		}
		else {
			$scondition = ' og.orderid=:orderid';
			$param[':orderid'] = $orderid;
		}

		$gift = array();
		$nogift = array();
		$gn = 0;
		$nog = 0;
		$goods = pdo_fetchall('select og.id as ordergoodsid,og.single_refundstate,og.sendtime,g.id,g.type, og.goodsid,og.price,g.title,g.thumb,g.status,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.isfullback,g.storeids' . $diyformfields . '  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . (' where ' . $scondition . ' and og.uniacid=:uniacid '), $param);
		$goods = set_medias($goods, array('thumb'));

		if (!empty($goods)) {
			$isfullback = false;

			foreach ($goods as &$g) {
				if ($g['isfullback']) {
					$isfullback = true;
					$fullbackgoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE goodsid = :goodsid and uniacid = :uniacid  limit 1 ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid));

					if ($g['optionid']) {
						$option = pdo_fetch('select `day`,allfullbackprice,fullbackprice,allfullbackratio,fullbackratio,isfullback
                      from ' . tablename('ewei_shop_goods_option') . ' where id = :id and uniacid = :uniacid ', array(':id' => $g['optionid'], ':uniacid' => $uniacid));
						$fullbackgoods['minallfullbackallprice'] = $option['allfullbackprice'];
						$fullbackgoods['fullbackprice'] = $option['fullbackprice'];
						$fullbackgoods['minallfullbackallratio'] = $option['allfullbackratio'];
						$fullbackgoods['fullbackratio'] = $option['fullbackratio'];
						$fullbackgoods['day'] = $option['day'];
					}

					$g['fullbackgoods'] = $fullbackgoods;
					unset($fullbackgoods);
					unset($option);
				}

				if (!empty($g['optionid'])) {
					$thumb = m('goods')->getOptionThumb($g['goodsid'], $g['optionid']);

					if (!empty($thumb)) {
						$g['thumb'] = $thumb;
					}
				}
			}
		}

		$diyform_flag = 0;

		if ($diyform_plugin) {
			foreach ($goods as &$g) {
				$g['diyformfields'] = iunserializer($g['diyformfields']);
				$g['diyformdata'] = iunserializer($g['diyformdata']);
				unset($g);
			}

			if (!empty($order['diyformfields']) && !empty($order['diyformdata'])) {
				$order_fields = iunserializer($order['diyformfields']);
				$order_data = iunserializer($order['diyformdata']);
			}
		}

		$address = false;

		if (!empty($order['addressid'])) {
			$address = iunserializer($order['address']);

			if (!is_array($address)) {
				$address = pdo_fetch('select * from  ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $order['addressid']));
			}
		}

		$carrier = @iunserializer($order['carrier']);
		if (!is_array($carrier) || empty($carrier)) {
			$carrier = false;
		}

		$store = false;

		if (!empty($order['storeid'])) {
			if (0 < $merchid) {
				$store = pdo_fetch('select * from  ' . tablename('ewei_shop_merch_store') . ' where id=:id limit 1', array(':id' => $order['storeid']));
			}
			else {
				$store = pdo_fetch('select * from  ' . tablename('ewei_shop_store') . ' where id=:id limit 1', array(':id' => $order['storeid']));
			}
		}

		$stores = false;
		$showverify = false;
		$canverify = false;
		$verifyinfo = false;

		if (com('verify')) {
			$showverify = $order['dispatchtype'] || $order['isverify'];

			if ($order['isverify']) {
				$storeids = array();

				foreach ($goods as $g) {
					if (!empty($g['storeids'])) {
						$storeids = array_merge(explode(',', $g['storeids']), $storeids);
					}
				}

				if (empty($storeids)) {
					if (0 < $merchid) {
						$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
					}
					else {
						$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
					}
				}
				else if (0 < $merchid) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}

				if (!$isonlyverifygoods) {
					if ($order['verifytype'] == 0 || $order['verifytype'] == 1) {
						$vs = iunserializer($order['verifyinfo']);
						$verifyinfo = array(
							array('verifycode' => $order['verifycode'], 'verified' => $order['verifytype'] == 0 ? $order['verified'] : $goods[0]['total'] <= count($vs))
						);

						if ($order['verifytype'] == 0) {
							$canverify = empty($order['verified']) && $showverify;
						}
						else {
							if ($order['verifytype'] == 1) {
								$canverify = count($vs) < $goods[0]['total'] && $showverify;
							}
						}
					}
					else {
						$verifyinfo = iunserializer($order['verifyinfo']);
						$last = 0;

						foreach ($verifyinfo as $v) {
							if (!$v['verified']) {
								++$last;
							}
						}

						$canverify = 0 < $last && $showverify;
					}
				}
			}
			else {
				if (!empty($order['dispatchtype'])) {
					$verifyinfo = array(
						array('verifycode' => $order['verifycode'], 'verified' => $order['status'] == 3)
					);
					$canverify = $order['status'] == 1 && $showverify;
				}
			}
		}

		$order['canverify'] = $canverify;
		$order['showverify'] = $showverify;
		$tradeset = m('common')->getSysset('trade');
		if ($order['status'] == 1 || $order['status'] == 2) {
			$canrefund = true;
			if ($order['status'] == 2 && $order['price'] == $order['dispatchprice']) {
				if (0 < $order['refundstate']) {
					$canrefund = true;
				}
				else {
					$canrefund = false;
				}
			}
		}
		else {
			if ($order['status'] == 3) {
				if ($order['isverify'] != 1 && empty($order['virtual'])) {
					if (0 < $order['refundstate']) {
						$canrefund = true;
					}
					else {
						$refunddays = intval($tradeset['refunddays']);

						if (0 < $refunddays) {
							$days = intval((time() - $order['finishtime']) / 3600 / 24);

							if ($days <= $refunddays) {
								$canrefund = true;
							}
						}
					}
				}
			}
		}

		$order['canrefund'] = $canrefund;
		if (empty($order['ispackage']) && empty($ispeerpay) && empty($isfullback) && !empty($tradeset['single_refund']) || $order['refundstate'] == 3) {
			$is_single_refund = true;
		}
		else {
			$is_single_refund = false;
		}

		$express = false;
		if (2 <= $order['status'] && empty($order['isvirtual']) && empty($order['isverify'])) {
			$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);

			if (0 < count($expresslist)) {
				$express = $expresslist[0];
			}
		}

		$shopname = $_W['shopset']['shop']['name'];
		if (!empty($order['merchid']) && $is_openmerch == 1) {
			$merch_user = $merch_plugin->getListUser($order['merchid']);
			$shopname = $merch_user['merchname'];
			$shoplogo = tomedia($merch_user['logo']);
		}

		$order['statusstr'] = '';

		if (empty($order['status'])) {
			if ($order['paytype'] == 3) {
				$order['statusstr'] = '货到付款，等待发货';
			}
			else {
				$order['statusstr'] = '等待付款';
			}
		}
		else if ($order['status'] == 1) {
			$order['statusstr'] = '买家已付款';
		}
		else if ($order['status'] == 2) {
			$order['statusstr'] = '卖家已发货';
		}
		else if ($order['status'] == 3) {
			$order['statusstr'] = '交易完成';
		}
		else {
			if ($order['status'] == -1) {
				$order['statusstr'] = '交易关闭';
			}
		}

		if (is_array($verifyinfo) && isset($verifyinfo)) {
			foreach ($verifyinfo as &$v) {
				$status = '';

				if ($v['verified']) {
					$status = '已使用';
				}
				else if ($order['dispatchtype']) {
					$status = '未取货';
				}
				else if ($order['verifytype'] == 1) {
					$status = '剩余' . ($goods[0]['total'] - count($vs)) . '次';
				}
				else {
					$status = '未使用';
				}

				$v['status'] = $status;
			}

			unset($v);
		}

		$newFields = array();
		if (is_array($order_fields) && !empty($order_fields)) {
			foreach ($order_fields as $k => $v) {
				$v['diy_type'] = $k;
				$newFields[] = $v;
				if ($v['data_type'] == 5 && !empty($order_data[$k]) && is_array($order_data[$k])) {
					$order_data[$k] = set_medias($order_data[$k]);
				}
			}
		}

		if (!empty($verifyinfo) && empty($order['status'])) {
			foreach ($verifyinfo as &$lala) {
				$lala['verifycode'] = '';
			}

			unset($lala);
		}

		$icon = '';

		if (empty($order['status'])) {
			if ($order['paytype'] == 3) {
				$icon = 'e623';
			}
			else {
				$icon = 'e711';
			}
		}
		else if ($order['status'] == 1) {
			$icon = 'e74c';
		}
		else if ($order['status'] == 2) {
			$icon = 'e623';
		}
		else if ($order['status'] == 3) {
			$icon = 'e601';
		}
		else {
			if ($order['status'] == -1) {
				$icon = 'e60e';
			}
		}

		$cycelbuy_periodic = explode(',', $order['cycelbuy_periodic']);
		$order = array('id' => $order['id'], 'ordersn' => $order['ordersn'], 'createtime' => date('Y-m-d H:i:s', $order['createtime']), 'paytime' => !empty($order['paytime']) ? date('Y-m-d H:i:s', $order['paytime']) : '', 'sendtime' => !empty($order['sendtime']) ? date('Y-m-d H:i:s', $order['sendtime']) : '', 'finishtime' => !empty($order['finishtime']) ? date('Y-m-d H:i:s', $order['finishtime']) : '', 'status' => $order['status'], 'statusstr' => $order['statusstr'], 'price' => $order['price'], 'goodsprice' => $order['goodsprice'], 'dispatchprice' => $order['dispatchprice'], 'ispackage' => $order['ispackage'], 'seckilldiscountprice' => $order['seckilldiscountprice'], 'deductenough' => $order['deductenough'], 'couponprice' => $order['couponprice'], 'discountprice' => $order['discountprice'], 'isdiscountprice' => $order['isdiscountprice'], 'deductprice' => $order['deductprice'], 'deductcredit2' => $order['deductcredit2'], 'diyformfields' => empty($newFields) ? array() : $newFields, 'diyformdata' => empty($order_data) ? array() : $order_data, 'showverify' => $order['showverify'], 'verifytitle' => $order['dispatchtype'] ? '自提码' : '消费码', 'dispatchtype' => $order['dispatchtype'], 'verifyinfo' => $verifyinfo, 'invoicename' => empty($order['invoicename']) ? NULL : m('sale')->parseInvoiceInfo($order['invoicename']), 'merchid' => intval($order['merchid']), 'virtual' => $order['virtual'], 'virtual_str' => $order['status'] == 3 ? $order['virtual_str'] : '', 'virtual_info' => $order['status'] == 3 ? $order['virtual_info'] : '', 'isvirtualsend' => $order['isvirtualsend'], 'virtualsend_info' => empty($order['virtualsend_info']) ? '' : $order['virtualsend_info'], 'canrefund' => $order['canrefund'], 'is_single_refund' => $is_single_refund, 'refundtext' => ($order['status'] == 1 ? '申请退款' : '申请售后') . (!empty($order['refundstate']) ? '中' : ''), 'refundtext_btn' => '', 'cancancel' => !$order['userdeleted'] && !$order['status'], 'canpay' => $order['paytype'] != 3 && !$order['userdeleted'] && $order['status'] == 0, 'canverify' => $order['canverify'] && $order['status'] != -1 && $order['status'] != 0, 'candelete' => $order['status'] == 3 || $order['status'] == -1, 'cancomment' => $order['status'] == 3 && $order['iscomment'] == 0 && empty($_W['shopset']['trade']['closecomment']), 'cancomment2' => $order['status'] == 3 && $order['iscomment'] == 1 && empty($_W['shopset']['trade']['closecomment']), 'cancomplete' => $order['status'] == 2, 'cancancelrefund' => 0 < $order['refundstate'], 'candelete2' => $order['userdeleted'] == 1, 'canrestore' => $order['userdeleted'] == 1, 'verifytype' => $order['verifytype'], 'refundstate' => $order['refundstate'], 'icon' => $icon, 'city_express_state' => $order['city_express_state'], 'iscycelbuy' => $order['iscycelbuy'], 'isonlyverifygoods' => $isonlyverifygoods, 'ramark' => empty($order['remark']) ? '' : $order['remark']);

		if ($order['iscycelbuy'] == 1) {
			$order['cycelComboPeriods'] = $cycelbuy_periodic[2];
		}

		if ($order['isonlyverifygoods']) {
			$order['canverify'] = false;
			$verifygood = pdo_fetch('select * from ' . tablename('ewei_shop_verifygoods') . ' where orderid=:orderid limit 1', array(':orderid' => $order['id']));

			if (!empty($verifygood)) {
				$order['verifygoods_id'] = $verifygood['id'];
				$verifynum = pdo_fetchcolumn('select sum(verifynum) from ' . tablename('ewei_shop_verifygoods_log') . '    where verifygoodsid =:id  ', array(':id' => $verifygood['id']));

				if (empty($verifygood['limittype'])) {
					$limitdate = intval($verifygood['starttime']) + intval($verifygood['limitdays']) * 86400;
				}
				else {
					$limitdate = intval($verifygood['limitdate']);
				}

				$order['canverify'] = time() <= $limitdate;

				if (0 < $verifygood['limitnum']) {
					$order['canverify'] = $verifynum < $verifygood['limitnum'];
				}
			}
		}

		if ($order['canrefund']) {
			if (!empty($order['refundstate'])) {
				$order['refundtext_btn'] = '查看';
			}

			if ($order['status'] == 1) {
				$order['refundtext_btn'] .= '申请退款';
			}
			else {
				$order['refundtext_btn'] .= '申请售后';
			}

			if (!empty($order['refundstate'])) {
				$order['refundtext_btn'] .= '进度';
			}
		}

		$allgoods = array();

		foreach ($goods as &$g) {
			$newFields = array();

			if (is_array($g['diyformfields'])) {
				foreach ($g['diyformfields'] as $k => $v) {
					$v['diy_type'] = $k;
					$newFields[] = $v;
				}
			}

			$allgoods[] = array('id' => $g['goodsid'], 'title' => $g['title'], 'price' => $g['price'], 'thumb' => tomedia($g['thumb']), 'total' => $g['total'], 'isfullback' => $g['isfullback'], 'fullbackgoods' => $g['fullbackgoods'], 'status' => $g['status'], 'optionname' => $g['optiontitle'], 'diyformdata' => empty($g['diyformdata']) ? array() : $g['diyformdata'], 'diyformfields' => $newFields, 'ordergoodsid' => $g['ordergoodsid'], 'single_refundstate' => $g['single_refundstate'], 'sendtime' => $g['sendtime']);
		}

		unset($g);

		if (!empty($allgoods)) {
			foreach ($allgoods as $gk => $og) {
				if ($og['status'] == 2) {
					$gift[$gn] = $og;
					++$gn;
				}
				else {
					$nogift[$nog] = $og;
					++$nog;
				}
			}
		}

		foreach ($gift as $kek => $val) {
			$giftinfo = pdo_fetch('select id,title,thumb,marketprice,total from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $uniacid . ' and status = 2  and id = ' . $val['id'] . ' ');
			if (empty($giftinfo) || $giftinfo['total'] == 0) {
				unset($gift[$kek]);
			}
		}

		$shop = array('name' => $shopname, 'logo' => $shoplogo);
		$result = array('order' => $order, 'goods' => $allgoods, 'gift' => $gift, 'nogift' => $nogift, 'address' => $address, 'express' => $express, 'carrier' => $carrier, 'store' => $store, 'stores' => $stores, 'shop' => $shop, 'customer' => intval($_W['shopset']['app']['customer']), 'phone' => intval($_W['shopset']['app']['phone']));

		if (!empty($result['customer'])) {
			$result['customercolor'] = empty($_W['shopset']['app']['customercolor']) ? '#ff5555' : $_W['shopset']['app']['customercolor'];
		}

		if (!empty($result['phone'])) {
			$result['phonecolor'] = empty($_W['shopset']['app']['phonecolor']) ? '#ff5555' : $_W['shopset']['app']['phonecolor'];
			$result['phonenumber'] = empty($_W['shopset']['app']['phonenumber']) ? '#ff5555' : $_W['shopset']['app']['phonenumber'];
		}

		if (!empty($order['virtual']) && !empty($order['virtual_str'])) {
			if ($order['status'] == 3) {
				$result['ordervirtual'] = m('order')->getOrderVirtual($order);
			}
			else {
				$result['ordervirtual'] = '';
			}

			$result['virtualtemp'] = pdo_fetch('SELECT linktext, linkurl,description FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id AND uniacid=:uniacid LIMIT 1', array(':id' => $order['virtual'], ':uniacid' => $_W['uniacid']));
		}

		if ($order['iscycelbuy'] == 1) {
			$cycelSql = 'SELECT * FROM ' . tablename('ewei_shop_cycelbuy_periods') . ' WHERE orderid=:orderid AND uniacid=:uniacid';
			$cycelParams = array(':orderid' => $order['id'], ':uniacid' => $_W['uniacid']);
			$cycelData = pdo_fetchall($cycelSql, $cycelParams);
			$cycelUnderway = pdo_fetch('SELECT count(*) as count FROM ' . tablename('ewei_shop_cycelbuy_periods') . ' WHERE orderid=' . $order['id'] . ' AND status<=1 AND uniacid=' . $_W['uniacid']);

			if (count($cycelData) == $cycelUnderway['count']) {
				$result['notStart'] = 1;
			}
			else {
				$result['notStart'] = 0;
			}

			if (!empty($cycelData)) {
				$cycelids = array();
				$notArray = array();
				$start = false;

				foreach ($cycelData as $ck => $cv) {
					$cycelData[$ck]['receipttime'] = date('Y-m-d', $cv['receipttime']);

					if ($cv['status'] == 1) {
						$cycelids[] = $cv['id'];
					}
				}

				$showCycelid = max($cycelids);

				foreach ($cycelData as $ck => $cv) {
					if ($cv['status'] == 0) {
						$notArray[] = $ck;
					}
					else if ($cv['status'] == 1) {
						$start = true;
						$period_index = $ck;
						$receipttime = $cv['receipttime'];
					}
					else {
						if ($cv['status'] == 2) {
						}
					}

					if ($cv['id'] == $showCycelid) {
						$result['selectIndex'] = $ck;
					}
				}

				if (empty($start) && !empty($notArray)) {
					$period_index = min($notArray);
				}

				$result['selectid'] = $showCycelid;
			}

			$result['period_index'] = $period_index;
			$result['cycelUnderway'] = $cycelUnderway['count'];
			$result['cycelData'] = $cycelData;
		}

		$result['fullbacktext'] = m('sale')->getFullBackText();
		$result['seckill_color'] = $seckill_color;
		$use_membercard = false;
		$card_free_dispatch = false;
		$membercard_info = array();
		$plugin_membercard = p('membercard');

		if ($plugin_membercard) {
			$ifuse = $plugin_membercard->if_order_use_membercard($orderid);

			if ($ifuse) {
				$use_membercard = true;
				$membercard_info['card_text'] = $ifuse['name'] . '优惠';
				$membercard_info['card_dec_price'] = $ifuse['dec_price'];
				$membercard_info['discount_rate'] = $ifuse['discount_rate'];

				if ($ifuse['shipping']) {
					$card_free_dispatch = true;
				}

				$membercard_info['card_free_dispatch'] = $card_free_dispatch;
			}
		}

		$result['use_membercard'] = $use_membercard;
		$result['membercard_info'] = $membercard_info;
		return app_json($result);
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['id']);
		$sendtype = intval($_GPC['sendtype']);
		$bundle = trim($_GPC['bundle']);
		$cycelid = intval($_GPC['cycelid']);

		if (empty($orderid)) {
			return app_error(AppError::$OrderNotFound);
		}

		if (!empty($cycelid)) {
			$order = pdo_fetch('select expresscom,expresssn,addressid,status,express,sendtype from ' . tablename('ewei_shop_cycelbuy_periods') . ' where id=:id and uniacid=:uniacid', array(':id' => $cycelid, ':uniacid' => $uniacid));
		}
		else {
			$order = pdo_fetch('select expresscom,expresssn,addressid,status,express,sendtype from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

			if (empty($order)) {
				return app_error(AppError::$OrderNotFound);
			}

			if (empty($order['addressid'])) {
				return app_error(AppError::$OrderNoExpress);
			}

			if ($order['status'] < 2) {
				return app_error(AppError::$OrderNoExpress);
			}
		}

		$bundlelist = array();
		if (!empty($order['sendtype']) && $sendtype == 0) {
			$i = 1;

			while ($i <= intval($order['sendtype'])) {
				$bundlelist[$i]['code'] = chr($i + 64);
				$bundlelist[$i]['sendtype'] = $i;
				$bundlelist[$i]['orderid'] = $orderid;
				$goods_arr = pdo_fetchall('select g.title,g.thumb,og.total,og.optionname as optiontitle,og.expresssn,og.express,
                    og.sendtype,og.expresscom,og.sendtime from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.sendtype = ' . $i . ' and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));

				foreach ($goods_arr as &$goods) {
					$goods['thumb'] = tomedia($goods['thumb']);
				}

				unset($goods);
				$bundlelist[$i]['goods'] = $goods_arr;

				if (empty($bundlelist[$i]['goods'])) {
					unset($bundlelist[$i]);
				}

				++$i;
			}

			$bundlelist = array_values($bundlelist);
		}

		$condition = '';

		if (0 < $sendtype) {
			$condition = ' and og.sendtype = ' . $sendtype;
		}

		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,og.expresssn,og.express,
            og.sendtype,og.expresscom,og.sendtime,g.storeids from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.single_refundtime=0 ' . $condition . ' and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));

		if (0 < $sendtype) {
			$order['express'] = $goods[0]['express'];
			$order['expresssn'] = $goods[0]['expresssn'];
			$order['expresscom'] = $goods[0]['expresscom'];
		}

		$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);
		$status = '';

		if (!empty($expresslist)) {
			if (strexists($expresslist[0]['step'], '已签收')) {
				$status = '已签收';
			}
			else if (count($expresslist) <= 2) {
				$status = '备货中';
			}
			else {
				$status = '配送中';
			}
		}

		return app_json(array('com' => $order['expresscom'], 'sn' => $order['expresssn'], 'status' => $status, 'count' => count($goods), 'thumb' => tomedia($goods[0]['thumb']), 'expresslist' => $expresslist, 'bundlelist' => $bundlelist));
	}

	public function cycelbuy_list()
	{
		global $_GPC;
		global $_W;
		$orderid = intval($_GPC['id']);

		if (empty($orderid)) {
			return app_error(AppError::$OrderNotFound);
		}

		$cycelbuy_set = m('common')->getSysset('cycelbuy');
		$sql = 'SELECT id,cycelbuy_periodic,refundstate FROM ' . tablename('ewei_shop_order') . ' WHERE id=:orderid AND uniacid =:uniacid ';
		$orderData = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));
		$cycelSql = 'SELECT * FROM ' . tablename('ewei_shop_cycelbuy_periods') . ' WHERE orderid=:orderid AND uniacid=:uniacid';
		$cycelParams = array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']);
		$cycelData = pdo_fetchall($cycelSql, $cycelParams);
		$cycelUnderway = pdo_fetch('SELECT count(*) as count FROM ' . tablename('ewei_shop_cycelbuy_periods') . ' WHERE orderid=' . $orderid . ' AND status<=1 AND uniacid=' . $_W['uniacid']);
		$notStart = false;
		$status0 = 0;
		$status2 = 0;
		$period_index = 1;
		$receipttime = $cycelData[0]['receipttime'];
		$weekArr = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');

		if (!empty($cycelData)) {
			$notArray = array();
			$start = false;

			foreach ($cycelData as $ck => $cv) {
				$cycelData[$ck]['week'] = $weekArr[date('w', $cv['receipttime'])];
				$cycelData[$ck]['receipttime'] = date('Y-m-d', $cv['receipttime']);
				$address = unserialize($cv['address']);
				$cycelData[$ck]['addressInfo'] = $address['province'] . $address['city'] . $address['area'] . $address['address'];

				if ($cv['status'] == 0) {
					$status0 += 1;
					$notArray[] = $ck;
				}
				else if ($cv['status'] == 1) {
					$start = true;
					$period_index = $ck;
					$receipttime = $cv['receipttime'];
				}
				else {
					if ($cv['status'] == 2) {
						$status2 += 1;
					}
				}
			}

			if (empty($start) && !empty($notArray)) {
				$period_index = min($notArray);
			}

			if ($status0 == count($cycelData)) {
				$notStart = true;
			}

			$existApply = '';
			$existApply = pdo_get('ewei_shop_address_applyfor', array('orderid' => $orderid, 'uniacid' => $_W['uniacid'], 'isdelete' => 0));

			if (!empty($existApply)) {
				$applyid = $existApply['id'];
			}
		}

		$applyfor = pdo_get('ewei_shop_address_applyfor', array('orderid' => $orderid, 'uniacid' => $_W['uniacid']));
		$result = array('list' => $cycelData, 'cycelUnderway' => $cycelUnderway['count'], 'cycelbuy_periodic' => $orderData['cycelbuy_periodic'], 'maxday' => $cycelbuy_set['max_day'], 'notStart' => $notStart, 'period_index' => $period_index, 'orderid' => $orderData['id'], 'applyid' => $applyid, 'refundstate' => $orderData['refundstate'], 'applyforid' => $applyfor['id']);
		return app_json($result);
	}

	public function getCycelbuyDate()
	{
		global $_W;
		global $_GPC;
		$cycelid = intval($_GPC['cycelid']);

		if (empty($cycelid)) {
			return app_error(AppError::$OrderNotFound);
		}

		$cycelSql = 'SELECT * FROM ' . tablename('ewei_shop_cycelbuy_periods') . ' WHERE id=:cycelid AND uniacid=:uniacid';
		$cycelParams = array(':cycelid' => $cycelid, ':uniacid' => $_W['uniacid']);
		$cycelData = pdo_fetch($cycelSql, $cycelParams);
		$result = array('receipttime' => date('Ymd', $cycelData['receipttime']));
		return app_json($result);
	}

	public function do_deferred()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$time = intval($_GPC['time']);
		$day = 86400;
		$order_id = $_GPC['orderid'];
		$is_all = intval($_GPC['is_all']);

		if (empty($order_id)) {
			show_json(0, '缺少订单ID');
		}

		if (empty($_GPC['time'])) {
			show_json(0, '缺少顺延时间');
		}

		$order = pdo_get('ewei_shop_order', array('id' => $order_id));

		if (empty($order)) {
			show_json(0, '没有查到该订单');
		}

		if (!empty($order['cycelbuy_periodic'])) {
			$arr = explode(',', $order['cycelbuy_periodic']);
		}
		else {
			show_json(0, '无法获取周期');
		}

		if ($arr[1] == 0) {
			$interval = $arr[0] * $day;
		}
		else if ($arr[1] == 1) {
			$interval = $arr[0] * ($day * 7);
		}
		else {
			$interval = $arr[0] * ($day * 30);
		}

		$condition = 'orderid = :order_id and uniacid = :uniacid and status = 0 order by receipttime asc ';

		if (empty($is_all)) {
			$condition .= 'limit 1';
		}

		$param = array('order_id' => $order_id, 'uniacid' => $_W['uniacid']);
		$data = pdo_fetchall('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where ' . $condition, $param);

		foreach ($data as $k => $v) {
			$receipttime = $time + $interval * $k;
			pdo_update('ewei_shop_cycelbuy_periods', array('receipttime' => $receipttime), array('id' => $v['id']));
		}

		$this->model->sendMessage(NULL, $data, 'TM_CYCELBUY_SELLER_DATE');
		$this->model->sendMessage($openid, $data, 'TM_CYCELBUY_BUYER_DATE');
		$result = array('show' => 1, 'showText' => '修改成功');
		return app_json($result);
	}

	public function address()
	{
		global $_W;
		global $_GPC;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);
		$show_data = 1;
		$applyforid = intval($_GPC['applyid']);
		$orderid = intval($_GPC['id']);
		$cycelid = intval($_GPC['cycelid']);
		$sql = 'SELECT id,cycelbuy_periodic FROM ' . tablename('ewei_shop_order') . ' WHERE id=:orderid AND uniacid =:uniacid ';
		$orderData = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));
		$ordersn = $orderData['ordersn'];

		if (!empty($orderid)) {
			$address = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where id=:id and orderid=:orderid and status = 0', array(':orderid' => $orderid, ':id' => $cycelid));
			$address = iunserializer($address['address']);
		}

		if (!empty($applyforid)) {
			$new_address = pdo_fetch('select * from ' . tablename('ewei_shop_address_applyfor') . ' where cycleid = :cycleid and isdelete = 0 order by createtime desc limit 1', array(':cycleid' => $cycelid));

			if (!empty($new_address)) {
				$data = iunserializer($new_address['data']);
				$address = array_merge($new_address, $data);
			}
		}

		if (!empty($new_area) && empty($address['datavalue']) || empty($new_area) && !empty($address['datavalue'])) {
			$show_data = 0;
		}

		$result = array('detail' => $address);

		if (!empty($applyforid)) {
			$result['isdispose'] = $address['isdispose'];
		}

		return app_json($result);
	}

	public function addressSubmit()
	{
		global $_W;
		global $_GPC;
		$applyid = intval($_GPC['applyid']);
		$orderid = intval($_GPC['orderid']);
		$data = array();
		$data['realname'] = trim($_GPC['realname']);
		$data['mobile'] = trim($_GPC['mobile']);
		$data['province'] = $_GPC['province'];
		$data['city'] = $_GPC['city'];
		$data['area'] = $_GPC['area'];
		$data['address'] = $_GPC['address'];
		$data['street'] = trim($_GPC['street']);
		$data['datavalue'] = trim($_GPC['datavalue']);
		$data['streetdatavalue'] = trim($_GPC['streetdatavalue']);
		$new_data['data'] = iserializer($data);
		$new_data['orderid'] = $orderid;
		$new_data['uniacid'] = $_W['uniacid'];
		$new_data['openid'] = $_W['openid'];
		$new_data['createtime'] = time();

		if (!empty($_GPC['isall'])) {
			$new_data['isall'] = 1;
		}
		else {
			$new_data['cycleid'] = $_GPC['cycelid'];
			$new_data['isall'] = 0;
		}

		if (!empty($applyid)) {
			$res = pdo_update('ewei_shop_address_applyfor', $new_data, array('id' => $applyid));
		}
		else {
			$is_submit = pdo_get('ewei_shop_address_applyfor', array('orderid' => $orderid, 'isdelete' => 0, 'isdispose' => 0));

			if ($is_submit) {
				return app_json(1, '请勿重复提交');
			}

			$address = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where orderid=:orderid and (status = 0 or status = 1) order by receipttime asc limit 1', array(':orderid' => $orderid));
			$new_data['old_address'] = $address['address'];
			$res = pdo_insert('ewei_shop_address_applyfor', $new_data);
		}

		if ($res != false) {
			return app_json(0);
		}

		return app_json(1);
	}

	public function confirm_receipt()
	{
		global $_W;
		global $_GPC;
		$p = p('commission');
		$pcoupon = com('coupon');
		$id = $_GPC['id'];
		$orderid = $_GPC['orderid'];

		if (empty($id)) {
			return app_json(0, array('message' => '参数错误'));
		}

		if (empty($orderid)) {
			return app_json(0, array('message' => '参数错误'));
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and id=:id  limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $orderid));
		$last_periods = pdo_fetch('select * from ' . tablename('ewei_shop_cycelbuy_periods') . ' where uniacid=:uniacid and orderid=:orderid order by id desc  limit 1', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));

		if (!empty($last_periods)) {
			if ($last_periods['id'] == $id) {
				pdo_update('ewei_shop_order', array('status' => 3, 'finishtime' => time()), array('id' => $orderid, 'status' => 2));
				$result = pdo_update('ewei_shop_cycelbuy_periods', array('status' => 2, 'finishtime' => time()), array('orderid' => $orderid, 'uniacid' => $_W['uniacid']));
				m('member')->upgradeLevel($order['openid'], $orderid);
				m('order')->setGiveBalance($orderid, 1);
				m('notice')->sendOrderMessage($orderid);
				m('order')->fullback($orderid);
				m('order')->setStocksAndCredits($orderid, 3);

				if ($pcoupon) {
					com('coupon')->sendcouponsbytask($orderid);

					if (!empty($order['couponid'])) {
						$pcoupon->backConsumeCoupon($orderid);
					}
				}

				if ($p) {
					$p->checkOrderFinish($orderid);
				}
			}
			else {
				$result = pdo_update('ewei_shop_cycelbuy_periods', array('status' => 2, 'finishtime' => time()), array('id' => $id, 'uniacid' => $_W['uniacid']));
			}

			if (!empty($result)) {
				return app_json(1, array('message' => '收货成功'));
			}

			return app_json(0, array('message' => '操作失败'));
		}
	}

	public function cycel_orderList()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];

		if (empty($openid)) {
			return app_error(AppError::$ParamsError);
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$show_status = $_GPC['status'];
		$r_type = array('退款', '退货退款', '换货');
		$condition = ' and openid=:openid and ismr=0 and deleted=0 and uniacid=:uniacid and iscycelbuy = 1';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$merchdata = $this->merchData();
		extract($merchdata);
		$condition .= ' and merchshow=0 ';

		if ($show_status != '') {
			$show_status = intval($show_status);

			switch ($show_status) {
			case 0:
				$condition .= ' and status=0 and paytype!=3';
				break;

			case 2:
				$condition .= ' and (status=2 or status=0 and paytype=3)';
				break;

			case 4:
				$condition .= ' and refundstate>0';
				break;

			case 5:
				$condition .= ' and userdeleted=1 ';
				break;

			default:
				$condition .= ' and status=' . intval($show_status);
			}

			if ($show_status != 5) {
				$condition .= ' and userdeleted=0 ';
			}
		}
		else {
			$condition .= ' and userdeleted=0 ';
		}

		$com_verify = com('verify');
		$list = pdo_fetchall('select id,ordersn,price,userdeleted,isparent,refundstate,paytype,status,addressid,refundid,isverify,dispatchtype,verifytype,verifyinfo,verifycode,iscomment from ' . tablename('ewei_shop_order') . (' where 1 ' . $condition . ' order by createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . (' where 1 ' . $condition), $params);
		$refunddays = intval($_W['shopset']['trade']['refunddays']);

		if ($is_openmerch == 1) {
			$merch_user = $merch_plugin->getListUser($list, 'merch_user');
		}

		foreach ($list as &$row) {
			$param = array();

			if ($row['isparent'] == 1) {
				$scondition = ' og.parentorderid=:parentorderid';
				$param[':parentorderid'] = $row['id'];
			}
			else {
				$scondition = ' og.orderid=:orderid';
				$param[':orderid'] = $row['id'];
			}

			$sql = 'SELECT og.id,og.goodsid,og.total,g.title,g.thumb,og.price,og.optionname as optiontitle,og.optionid,op.specs,g.merchid,g.status,og.single_refundid,og.single_refundstate FROM ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . (' where ' . $scondition . ' order by og.id asc');
			$goods = pdo_fetchall($sql, $param);
			$goods = set_medias($goods, array('thumb'));
			$ismerch = 0;
			$merch_array = array();
			$g = 0;
			$nog = 0;

			foreach ($goods as &$r) {
				$merchid = $r['merchid'];
				$merch_array[$merchid] = $merchid;

				if (!empty($r['specs'])) {
					$thumb = m('goods')->getSpecThumb($r['specs']);

					if (!empty($thumb)) {
						$r['thumb'] = tomedia($thumb);
					}
				}

				if ($r['status'] == 2) {
					$row['gift'][$g] = $r;
					++$g;
				}
				else {
					$row['nogift'][$nog] = $r;
					++$nog;
				}
			}

			unset($r);

			if (!empty($merch_array)) {
				if (1 < count($merch_array)) {
					$ismerch = 1;
				}
			}

			if (empty($goods)) {
				$goods = array();
			}

			foreach ($goods as &$r) {
				$r['thumb'] .= '?t=' . random(50);
			}

			unset($r);
			$goods_list = array();
			$i = 0;

			if ($ismerch) {
				$getListUser = $merch_plugin->getListUser($goods);
				$merch_user = $getListUser['merch_user'];

				foreach ($getListUser['merch'] as $k => $v) {
					if (empty($merch_user[$k]['merchname'])) {
						$goods_list[$i]['shopname'] = $_W['shopset']['shop']['name'];
					}
					else {
						$goods_list[$i]['shopname'] = $merch_user[$k]['merchname'];
					}

					$goods_list[$i]['goods'] = $v;
					++$i;
				}
			}
			else {
				if ($merchid == 0) {
					$goods_list[$i]['shopname'] = $_W['shopset']['shop']['name'];
				}
				else {
					$merch_data = $merch_plugin->getListUserOne($merchid);
					$goods_list[$i]['shopname'] = $merch_data['merchname'];
				}

				$goods_list[$i]['goods'] = $goods;
			}

			$row['goods'] = $goods_list;
			$statuscss = 'text-cancel';

			switch ($row['status']) {
			case '-1':
				$status = '已取消';
				break;

			case '0':
				if ($row['paytype'] == 3) {
					$status = '待发货';
				}
				else {
					$status = '待付款';
				}

				$statuscss = 'text-cancel';
				break;

			case '1':
				if ($row['isverify'] == 1) {
					$status = '使用中';
				}
				else if (empty($row['addressid'])) {
					$status = '待取货';
				}
				else {
					$status = '待发货';
				}

				$statuscss = 'text-warning';
				break;

			case '2':
				$status = '待收货';
				$statuscss = 'text-danger';
				break;

			case '3':
				if (empty($row['iscomment'])) {
					if ($show_status == 5) {
						$status = '已完成';
					}
					else {
						$status = empty($_W['shopset']['trade']['closecomment']) ? '待评价' : '已完成';
					}
				}
				else {
					$status = '交易完成';
				}

				$statuscss = 'text-success';
				break;
			}

			$row['statusstr'] = $status;
			$row['statuscss'] = $statuscss;
			if (0 < $row['refundstate'] && !empty($row['refundid'])) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $row['refundid'], ':uniacid' => $uniacid, ':orderid' => $row['id']));

				if (!empty($refund)) {
					$row['statusstr'] = '待' . $r_type[$refund['rtype']];
				}
			}

			$row['canverify'] = false;
			$canverify = false;

			if ($com_verify) {
				$showverify = $row['dispatchtype'] || $row['isverify'];

				if ($row['isverify']) {
					if ($row['verifytype'] == 0 || $row['verifytype'] == 1) {
						$vs = iunserializer($row['verifyinfo']);
						$verifyinfo = array(
							array('verifycode' => $row['verifycode'], 'verified' => $row['verifytype'] == 0 ? $row['verified'] : $row['goods'][0]['total'] <= count($vs))
						);

						if ($row['verifytype'] == 0) {
							$canverify = empty($row['verified']) && $showverify;
						}
						else {
							if ($row['verifytype'] == 1) {
								$canverify = count($vs) < $row['goods'][0]['total'] && $showverify;
							}
						}
					}
					else {
						$verifyinfo = iunserializer($row['verifyinfo']);
						$last = 0;

						foreach ($verifyinfo as $v) {
							if (!$v['verified']) {
								++$last;
							}
						}

						$canverify = 0 < $last && $showverify;
					}
				}
				else {
					if (!empty($row['dispatchtype'])) {
						$canverify = $row['status'] == 1 && $showverify;
					}
				}
			}

			$row['canverify'] = $canverify;

			if ($is_openmerch == 1) {
				$row['merchname'] = $merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name'];
			}

			$row['cancancel'] = !$row['userdeleted'] && !$row['status'];
			$row['canpay'] = $row['paytype'] != 3 && !$row['userdeleted'] && $row['status'] == 0;
			$row['canverify'] = $row['canverify'] && $row['status'] != -1 && $row['status'] != 0;
			$row['candelete'] = $row['status'] == 3 || $row['status'] == -1;
			$row['cancomment'] = $row['status'] == 3 && $row['iscomment'] == 0 && empty($_W['shopset']['trade']['closecomment']);
			$row['cancomment2'] = $row['status'] == 3 && $row['iscomment'] == 1 && empty($_W['shopset']['trade']['closecomment']);
			$row['cancomplete'] = $row['status'] == 2;
			$row['cancancelrefund'] = 0 < $row['refundstate'] && isset($refund) && $refund['status'] != 5;
			$row['candelete2'] = $row['userdeleted'] == 1;
			$row['canrestore'] = $row['userdeleted'] == 1;
			$row['hasexpress'] = 1 < $row['status'] && 0 < $row['addressid'];
		}

		unset($row);
		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total, 'page' => $pindex));
	}

	public function express_number()
	{
		global $_W;
		global $_GPC;
		$refundid = intval($_GPC['refundid']);
		$uniacid = intval($_W['uniacid']);

		if ($_GPC['submit']) {
			if (empty($refundid)) {
				return app_error(AppError::$ParamsError);
			}

			$refund = array('status' => 4, 'express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['express_number']), 'sendtime' => time());
			$res = pdo_update('ewei_shop_order_refund', $refund, array('id' => $refundid, 'uniacid' => $uniacid));

			if ($res) {
				return app_json();
			}
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_order_refund') . ' WHERE id = :id AND uniacid = :uniacid';
		$params = array(':id' => $refundid, ':uniacid' => $uniacid);
		$refund = pdo_fetch($sql, $params);
		$express_list = m('express')->getExpressList();
		$index = '';

		if (!empty($refund['express'])) {
			foreach ($express_list as $k => $v) {
				if ($v['express'] == $refund['express']) {
					$index = $k;
				}
			}
		}

		return app_json(array('express' => $refund['express'], 'expresscom' => $refund['expresscom'], 'express_number' => $refund['expresssn'], 'express_list' => $express_list, 'index' => $index));
	}

	public function single_express_number()
	{
		global $_W;
		global $_GPC;
		$refundid = intval($_GPC['refundid']);
		$uniacid = intval($_W['uniacid']);

		if ($_GPC['submit']) {
			if (empty($refundid)) {
				return app_error(AppError::$ParamsError);
			}

			$refund = array('status' => 4, 'express' => trim($_GPC['express']), 'expresscom' => trim($_GPC['expresscom']), 'expresssn' => trim($_GPC['express_number']), 'sendtime' => time());
			$res = pdo_update('ewei_shop_order_single_refund', $refund, array('id' => $refundid, 'uniacid' => $uniacid));

			if ($res) {
				return app_json();
			}
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_order_single_refund') . ' WHERE id = :id AND uniacid = :uniacid';
		$params = array(':id' => $refundid, ':uniacid' => $uniacid);
		$refund = pdo_fetch($sql, $params);
		$express_list = m('express')->getExpressList();
		$index = '';

		if (!empty($refund['express'])) {
			foreach ($express_list as $k => $v) {
				if ($v['express'] == $refund['express']) {
					$index = $k;
				}
			}
		}

		return app_json(array('express' => $refund['express'], 'expresscom' => $refund['expresscom'], 'express_number' => $refund['expresssn'], 'express_list' => $express_list, 'index' => $index));
	}
}

?>
