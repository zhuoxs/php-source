<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class PolyapiModel extends PluginModel
{
	public function get_key_info($array)
	{
		$params = array(':appkey' => $array['appkey'], ':token' => $array['token']);
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_polyapi_key') . ' where appkey=:appkey and token=:token limit 1', $params);
		return $item;
	}

	public function check_request($array)
	{
		if (empty($array['appkey'])) {
			$this->errorData('appkey为空', 3);
		}

		if (empty($array['token'])) {
			$this->errorData('token为空', 3);
		}

		if (empty($array['method'])) {
			$this->errorData('method为空', 3);
		}

		if (empty($array['sign'])) {
			$this->errorData('sign为空', 3);
		}
	}

	public function check_sign($array, $key_info)
	{
		$method = $array['method'];
		$appkey = $array['appkey'];
		$token = $array['token'];
		$bizcontent = $array['bizcontent'];
		$sign = $array['sign'];
		$appSecret = $key_info['appsecret'];
		$unsign = $appSecret . 'appkey' . $appkey . 'bizcontent' . $bizcontent . 'method' . $method . 'token' . $token . $appSecret;
		$newsign = md5(strtolower($unsign));

		if ($sign != $newsign) {
			echo '{"code":"40000","message":"Logical Error","subcode":"GSE.VERIFYSIGN_FAILURE","submessage":"签名验证失败"}';
			exit();
		}
	}

	public function GetOrder($array)
	{
		global $_W;
		global $_GPC;
		$uniacid = $array['uniacid'];
		$bizcontent = $array['bizcontent'];
		$order_status = array();
		$order_status[0] = 'JH_01';
		$order_status[1] = 'JH_02';
		$order_status[2] = 'JH_03';
		$order_status[3] = 'JH_04';
		$order_status[-1] = 'JH_05';
		$order_status[-10] = 'JH_99';
		$status_order = array_flip($order_status);
		$status_text = array();
		$status_text[0] = '待付款';
		$status_text[1] = '待发货';
		$status_text[2] = '待收货';
		$status_text[3] = '已完成';
		$status_text[-1] = '已关闭';
		$time_type = array();
		$time_type['JH_01'] = 'createtime';
		$time_type['JH_02'] = 'createtime';
		$time_type['JH_03'] = 'paytime';
		$time_type['JH_04'] = 'sendtime';
		$time_type['JH_05'] = 'finishtime';
		$refund_status = $this->get_refund_status();
		$p = p('commission');
		$level = 0;

		if ($p) {
			$cset = $p->getSet();
			$level = intval($cset['level']);
		}

		$orders = array();
		$pindex = intval($bizcontent['PageIndex']);
		$psize = intval($bizcontent['PageSize']);
		$paras = array();
		$paras[':uniacid'] = $uniacid;
		$condition = ' o.uniacid = :uniacid and o.ismr=0 and o.deleted=0 and o.isparent=0 and o.merchid=0 and o.`virtual`=0 and o.`isverify`=0';
		$searchtime = trim($_GPC['searchtime']);
		if (!empty($searchtime) && is_array($_GPC['time']) && in_array($searchtime, array('create', 'pay', 'send', 'finish'))) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND o.' . $searchtime . 'time >= :starttime AND o.' . $searchtime . 'time <= :endtime ';
			$paras[':starttime'] = $starttime;
			$paras[':endtime'] = $endtime;
		}

		$OrderStatus = trim($bizcontent['OrderStatus']);

		if ($OrderStatus != 'JH_99') {
			$paras[':status'] = $status_order[$OrderStatus];
			$condition .= ' and o.status=:status';
		}

		$PlatOrderNo = trim($bizcontent['PlatOrderNo']);

		if (!empty($PlatOrderNo)) {
			$paras[':ordersn'] = $PlatOrderNo;
			$condition .= ' AND locate(:ordersn,o.ordersn)>0';
		}

		$TimeType = trim($bizcontent['TimeType']);

		if (!empty($TimeType)) {
			$starttime = strtotime($bizcontent['StartTime']);
			$endtime = strtotime($bizcontent['EndTime']);
			$condition .= ' AND o.' . $time_type[$TimeType] . ' >= :starttime AND o.' . $time_type[$TimeType] . ' <= :endtime ';
			$paras[':starttime'] = $starttime;
			$paras[':endtime'] = $endtime;
		}

		$sql = "select o.* , a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea,a.address as aaddress,\r\n                  d.dispatchname,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,sm.id as salerid,sm.nickname as salernickname,s.salername,\r\n                  r.rtype,r.status as rstatus,o.sendtype from " . tablename('ewei_shop_order') . ' o' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id=o.addressid ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . ' left join ' . tablename('ewei_shop_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . (' where ' . $condition . ' GROUP BY o.id ORDER BY o.createtime DESC  ');
		$sql .= 'LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $paras);
		$t = pdo_fetch('SELECT COUNT(1) as count FROM ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('ewei_shop_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . (' where ' . $condition), $paras);
		$total = $t['count'];

		if (!empty($list)) {
			foreach ($list as $k => $v) {
				$orders[$k]['PlatOrderNo'] = $v['ordersn'];
				$orders[$k]['tradeStatus'] = $order_status[$v['status']];
				$orders[$k]['tradeStatusdescription'] = $status_text[$v['status']];
				$orders[$k]['tradetime'] = date('Y-m-d H:i:s', $v['createtime']);

				if (0 < $v['parentid']) {
					$parent_item = pdo_fetch('SELECT id,ordersn,ordersn2,price FROM ' . tablename('ewei_shop_order') . ' WHERE id = :id and uniacid=:uniacid Limit 1', array(':id' => $v['parentid'], ':uniacid' => $uniacid));
					$ordersn = $parent_item['ordersn'];

					if (!empty($parent_item['ordersn2'])) {
						$var = sprintf('%02d', $parent_item['ordersn2']);
						$ordersn .= 'GJ' . $var;
					}
				}
				else {
					$ordersn = $v['ordersn'];

					if (!empty($v['ordersn2'])) {
						$var = sprintf('%02d', $v['ordersn2']);
						$ordersn .= 'GJ' . $var;
					}
				}

				$orders[$k]['payorderno'] = $ordersn;
				$orders[$k]['country'] = 'CN';

				if (empty($v['addressid'])) {
					$user = unserialize($v['carrier']);
				}
				else {
					$user = iunserializer($v['address']);

					if (!is_array($user)) {
						$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $v['addressid'], ':uniacid' => $uniacid));
					}

					$address_info = $user['address'];
					$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['street'] . ' ' . $user['address'];
					$v['addressdata'] = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
				}

				$orders[$k]['province'] = $user['province'];
				$orders[$k]['city'] = $user['city'];
				$orders[$k]['area'] = $user['area'];
				$orders[$k]['town'] = $user['street'];
				$orders[$k]['address'] = $user['address'];
				$orders[$k]['zip'] = '';
				$orders[$k]['phone'] = $user['mobile'];
				$orders[$k]['mobile'] = $user['mobile'];
				$orders[$k]['email'] = '';
				$orders[$k]['customerremark'] = $v['remark'];
				$orders[$k]['sellerremark'] = $v['remarksaler'];
				$orders[$k]['postfee'] = $v['dispatchprice'];
				$orders[$k]['goodsfee'] = $v['goodsprice'];
				$orders[$k]['totalmoney'] = $v['price'];
				$favourablemoney = $v['taskdiscountprice'] + $v['lotterydiscountprice'] + $v['discountprice'] + $v['deductprice'] + $v['deductcredit2'] + $v['deductenough'] + $v['merchdeductenough'] + $v['couponprice'] + $v['isdiscountprice'] + $v['buyagainprice'] + $v['seckilldiscountprice'];
				$orders[$k]['favourablemoney'] = $favourablemoney;
				$commission1 = 0;
				$commission2 = 0;
				$commission3 = 0;
				$m1 = false;
				$m2 = false;
				$m3 = false;

				if (!empty($level)) {
					if (!empty($v['agentid'])) {
						$m1 = m('member')->getMember($v['agentid']);
						$commission1 = 0;
						if (!empty($m1['agentid']) && 1 < $level) {
							$m2 = m('member')->getMember($m1['agentid']);
							$commission2 = 0;
							if (!empty($m2['agentid']) && 2 < $level) {
								$m3 = m('member')->getMember($m2['agentid']);
								$commission3 = 0;
							}
						}
					}
				}

				$orders[$k]['sendstyle'] = '';
				$orders[$k]['qq'] = '';
				$orders[$k]['paytime'] = empty($v['paytime']) ? '' : date('Y-m-d H:i:s', $v['paytime']);
				$orders[$k]['invoicetitle'] = $v['invoicename'];
				$orders[$k]['codservicefee'] = 0;
				$orders[$k]['cardtype'] = '';
				$orders[$k]['idcard'] = '';
				$orders[$k]['idcardtruename'] = '';
				$orders[$k]['receivername'] = $user['realname'];
				$orders[$k]['nick'] = $v['nickname'];
				$orders[$k]['whsecode'] = '';
				$orders[$k]['IsHwgFlag'] = 0;
				$orders[$k]['ShouldPayType'] = $v['paytype'] == 3 ? '货到付款' : '';
				$refundid = $v['refundid'];

				if (!empty($refundid)) {
					$refund = pdo_fetch('select status from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $refundid));
				}

				$refund_info = '';

				if (!empty($v['refundtime'])) {
					$refund_info = 'JH_06';
				}
				else if (!empty($v['refundstate'])) {
					$refund_info = $refund_status[$refund['status']];
				}
				else {
					$refund_info = 'JH_07';
				}

				$goods = array();
				$order_goods = pdo_fetchall("select g.id,g.title,g.thumb,g.goodssn,g.hasoption,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,\r\n                    og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,\r\n                    og.diyformfields,op.specs,g.merchid,og.seckill,og.seckill_taskid,og.seckill_roomid,g.ispresell,og.id as ogid from " . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $uniacid, ':orderid' => $v['id']));

				if (!empty($order_goods)) {
					foreach ($order_goods as $k1 => $v1) {
						$goods[$k1]['ProductId'] = $v1['id'];
						$goods[$k1]['suborderno'] = '';
						$gn = 'RR' . $v1['id'];

						if ($v1['hasoption'] == 1) {
							if (!empty($v1['option_goodssn'])) {
								$gn = $v1['option_goodssn'];
							}
							else {
								if (!empty($v1['option_productsn'])) {
									$gn = $v1['option_productsn'];
								}
							}
						}
						else if (!empty($v1['goodssn'])) {
							$gn = $v1['goodssn'];
						}
						else {
							if (!empty($v1['productsn'])) {
								$gn = $v1['productsn'];
							}
						}

						$goods[$k1]['tradegoodsno'] = $gn;
						$goods[$k1]['tradegoodsname'] = $v1['title'];
						$goods[$k1]['tradegoodsspec'] = $v1['optiontitle'];
						$goods[$k1]['goodscount'] = $v1['total'];
						$goods[$k1]['price'] = round($v1['price'] / $v1['total'], 2);
						$goods[$k1]['discountmoney'] = 0;
						$goods[$k1]['taxamount'] = 0;
						$goods[$k1]['refundStatus'] = $refund_info;
						$goods[$k1]['Status'] = $orders[$k]['tradeStatus'];
						$goods[$k1]['remark'] = '';

						if (!empty($level)) {
							$commissions = iunserializer($v1['commissions']);

							if (!empty($m1)) {
								if (is_array($commissions)) {
									$commission1 += isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
								}
								else {
									$c1 = iunserializer($v1['commission1']);
									$l1 = $p->getLevel($m1['openid']);

									if (!empty($c1)) {
										$commission1 += isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default'];
									}
								}
							}

							if (!empty($m2)) {
								if (is_array($commissions)) {
									$commission2 += isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
								}
								else {
									$c2 = iunserializer($v1['commission2']);
									$l2 = $p->getLevel($m2['openid']);

									if (!empty($c2)) {
										$commission2 += isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default'];
									}
								}
							}

							if (!empty($m3)) {
								if (is_array($commissions)) {
									$commission3 += isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
								}
								else {
									$c3 = iunserializer($v1['commission3']);
									$l3 = $p->getLevel($m3['openid']);

									if (!empty($c3)) {
										$commission3 += isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default'];
									}
								}
							}
						}
					}
				}

				$orders[$k]['goodinfos'] = $goods;
				$commissionvalue = $commission1 + $commission2 + $commission3;
				$orders[$k]['commissionvalue'] = $commissionvalue;
			}
		}
		else {
			$this->errorData('没有找到订单', 7);
		}

		$return_data = array();
		$return_data['code'] = '10000';
		$return_data['message'] = 'SUCCESS';
		$return_data['numtotalorder'] = $total;
		$return_data['orders'] = $orders;
		return $return_data;
	}

	public function CheckRefundStatus($array)
	{
		global $_W;
		global $_GPC;
		$uniacid = $array['uniacid'];
		$bizcontent = $array['bizcontent'];
		$ordersn = trim($bizcontent['OrderID']);

		if (empty($ordersn)) {
			$this->errorData('订单ID为空', 3);
		}

		$item = $this->getOrderData($ordersn, $uniacid);
		$return_data = array();
		$return_data['code'] = '10000';
		$return_data['message'] = 'SUCCESS';

		if (empty($item)) {
			$this->errorData('该订单不存在', 7);
		}
		else {
			$refundid = $item['refundid'];

			if (!empty($refundid)) {
				$refund = pdo_fetch('select status from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $refundid));
			}

			$refund_status = $this->get_refund_status();
			$refund_text = $this->get_refund_text();

			if (!empty($item['refundtime'])) {
				$refund_info = 'JH_06';
			}
			else if (!empty($item['refundstate'])) {
				$refund_info = $refund_status[$refund['status']];
			}
			else {
				$refund_info = 'JH_07';
			}

			$return_data['refundStatus'] = $refund_info;
			$return_data['childrenrefundStatus'] = '';
			$return_data['refundStatusdescription'] = $refund_text[$refund['status']];
			$return_data['submessage'] = $refund_text[$refund['status']];
		}

		return $return_data;
	}

	public function Send($array)
	{
		global $_W;
		$uniacid = $array['uniacid'];
		$bizcontent = $array['bizcontent'];
		$ordersn = trim($bizcontent['PlatOrderNo']);
		$item = $this->getOrderData($ordersn, $uniacid);
		$return_data = array();
		$return_data['code'] = 40000;
		$return_data['subcode'] = 'GSE.LOGIC_ERROR';

		if (empty($item)) {
			$this->errorData('该订单不存在', 7);
		}
		else {
			$LogisticType = trim($bizcontent['LogisticType']);
			$LogisticNo = trim($bizcontent['LogisticNo']);
			$IsSplit = intval($bizcontent['IsSplit']);
			$SubPlatOrderNo = $bizcontent['SubPlatOrderNo'];

			if (empty($LogisticType)) {
				$this->errorData('快递类别不能为空', 3);
			}
			else {
				$express_info = $this->getExpressInfo($LogisticType);
			}

			if (empty($LogisticNo)) {
				$this->errorData('快递运单号不能为空', 3);
			}
		}

		$return_data['code'] = '10000';
		$return_data['message'] = 'SUCCESS';
		$time = time();
		$change_data = array();
		$change_data['sendtime'] = $time;
		$change_data['expresssn'] = $LogisticNo;

		if (empty($express_info)) {
			$change_data['express'] = '';
			$change_data['expresscom'] = $express_info['LogisticName'];
		}
		else {
			$change_data['express'] = $express_info['express'];
			$change_data['expresscom'] = $express_info['name'];
		}

		if (empty($IsSplit)) {
			$change_data['status'] = 2;
			pdo_update('ewei_shop_order', $change_data, array('id' => $item['id'], 'uniacid' => $uniacid));
		}
		else {
			$goods_array = explode('|', $SubPlatOrderNo);
			$goodsid = array();

			if (!empty($goods_array)) {
				foreach ($goods_array as $k => $v) {
					$goodsid_array = explode(':', $v);
					$gid = intval($goodsid_array[0]);

					if ($gid) {
						$goodsid[] = $gid;
					}
				}
			}

			$ogoods = array();
			$ogoods = pdo_fetchall('select sendtype from ' . tablename('ewei_shop_order_goods') . "\r\n                where orderid = " . $item['id'] . ' and uniacid = ' . $uniacid . ' order by sendtype desc ');
			$senddata = array('sendtype' => $ogoods[0]['sendtype'] + 1);
			$change_data['sendtype'] = $ogoods[0]['sendtype'] + 1;

			foreach ($goodsid as $key => $value) {
				pdo_update('ewei_shop_order_goods', $change_data, array('orderid' => $item['id'], 'goodsid' => $value, 'uniacid' => $uniacid));
			}

			$send_goods = pdo_fetch('select * from ' . tablename('ewei_shop_order_goods') . "\r\n                where orderid = " . $item['id'] . ' and sendtype = 0 and uniacid = ' . $uniacid . ' limit 1 ');

			if (empty($send_goods)) {
				$senddata['status'] = 2;
			}

			pdo_update('ewei_shop_order', $senddata, array('id' => $item['id'], 'uniacid' => $uniacid));
		}

		if (!empty($item['refundid'])) {
			$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $item['refundid']));

			if (!empty($refund)) {
				pdo_update('ewei_shop_order_refund', array('status' => -1, 'endtime' => $time), array('id' => $item['refundid']));
				pdo_update('ewei_shop_order', array('refundstate' => 0), array('id' => $item['id']));
			}
		}

		if ($item['paytype'] == 3) {
			m('order')->setStocksAndCredits($item['id'], 1);
		}

		m('notice')->sendOrderMessage($item['id']);
		plog('order.op.send', '订单发货 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' <br/>快递公司: ' . $change_data['expresscom'] . ' 快递单号: ' . $change_data['expresssn']);
		return $return_data;
	}

	public function DownloadProduct($array)
	{
		global $_W;
		$uniacid = $array['uniacid'];
		$bizcontent = $array['bizcontent'];
		$ProductId = trim($bizcontent['ProductId']);
		$ProductName = trim($bizcontent['ProductName']);
		$Status = trim($bizcontent['Status']);
		$goods = array();
		$pindex = intval($bizcontent['PageIndex']);
		$psize = intval($bizcontent['PageSize']);
		$params = array();
		$params[':uniacid'] = $uniacid;
		$sqlcondition = $groupcondition = '';
		$condition = ' WHERE g.`uniacid` = :uniacid';
		$params = array(':uniacid' => $uniacid);

		if (!empty($ProductId)) {
			$condition .= ' AND g.`id` = :id and g.meichid=0';
			$params[':id'] = $ProductId;
		}

		if (!empty($ProductName)) {
			$sqlcondition = ' left join ' . tablename('ewei_shop_goods_option') . ' op on g.id = op.goodsid';
			$groupcondition = ' group by g.`id`';
			$condition .= ' AND (g.`title` LIKE :keyword or g.`keywords` LIKE :keyword or g.`goodssn` LIKE :keyword or g.`productsn` LIKE :keyword or op.`title` LIKE :keyword or op.`goodssn` LIKE :keyword or op.`productsn` LIKE :keyword';
			$condition .= ' )';
			$params[':keyword'] = '%' . $ProductName . '%';
		}

		if (!empty($Status)) {
			switch ($Status) {
			case 'JH_01':
				$condition .= ' AND g.`status` = 1';
				break;

			case 'JH_02':
				$condition .= ' AND g.`status` = 0';
				break;

			case 'JH_99':
				break;
			}
		}

		$sql = 'SELECT g.id FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . $groupcondition;
		$total_all = pdo_fetchall($sql, $params);
		$total = count($total_all);
		unset($total_all);

		if (!empty($total)) {
			$sql = 'SELECT g.* FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . $groupcondition . " ORDER BY g.`status` DESC, g.`displayorder` DESC,\r\n                g.`id` DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);

			foreach ($list as $k => &$v) {
				$goods[$k]['PlatProductID'] = $v['id'];
				$goods[$k]['name'] = $v['title'];
				$gn = 'RR' . $v['id'];

				if (!empty($v['goodssn'])) {
					$gn = $v['goodssn'];
				}
				else {
					if (!empty($v['productsn'])) {
						$gn = $v['productsn'];
					}
				}

				$goods[$k]['OuterID'] = $gn;
				$goods[$k]['price'] = $v['marketprice'];
				$goods[$k]['num'] = $v['total'];
				$goods[$k]['pictureurl'] = tomedia($v['thumb']);
				$op = array();

				if ($v['hasoption'] == 1) {
					$options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:id order by id asc', array(':id' => $v['id']));

					if (!empty($options)) {
						foreach ($options as $k1 => $v2) {
							$op[$k1]['SkuID'] = $v2['id'];
							$gn = 'RO' . $v2['id'];

							if (!empty($v2['goodssn'])) {
								$gn = $v2['goodssn'];
							}
							else {
								if (!empty($v2['productsn'])) {
									$gn = $v2['productsn'];
								}
							}

							$op[$k1]['skuOuterID'] = $gn;
							$op[$k1]['skuprice'] = $v2['marketprice'];
							$op[$k1]['skuQuantity'] = $v2['stock'];
							$op[$k1]['skuname'] = $v2['title'];
							$op[$k1]['skuproperty'] = '';
							$op[$k1]['skupictureurl'] = $goods[$k]['pictureurl'];
						}
					}
				}

				$goods[$k]['skus'] = $op;
			}
		}

		$return_data = array();

		if (!empty($total)) {
			$return_data['code'] = '10000';
			$return_data['message'] = 'SUCCESS';
			$return_data['totalcount'] = $total;
			$return_data['goodslist'] = $goods;
		}
		else {
			$this->errorData('没有找到商品', 7);
		}

		return $return_data;
	}

	public function SyncStock($array)
	{
		global $_W;
		$uniacid = $array['uniacid'];
		$bizcontent = $array['bizcontent'];
		$PlatProductID = trim($bizcontent['PlatProductID']);
		$SkuID = trim($bizcontent['SkuID']);
		$OuterID = trim($bizcontent['OuterID']);
		$Quantity = intval($bizcontent['Quantity']);
		$OutSkuID = trim($bizcontent['OutSkuID']);
		$change_num = 0;
		$return_data = array();
		$return_data['code'] = '10000';
		$return_data['message'] = 'SUCCESS';

		if (empty($PlatProductID)) {
			$this->errorData('商品ID为空', 3);
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid Limit 1', array(':id' => $PlatProductID, ':uniacid' => $uniacid));

		if (empty($item)) {
			$this->errorData('没有找到商品', 7);
		}

		if ($item['hasoption'] == 1) {
			if (empty($SkuID)) {
				$this->errorData('商品规格ID为空', 7);
			}

			$option = m('goods')->getOption($PlatProductID, $SkuID);

			if (empty($option)) {
				$this->errorData('该规格不存在', 7);
			}

			$change_num = $option['stock'] - $Quantity;
			$goods_total = $item['stock'] + $change_num;
			pdo_update('ewei_shop_goods_option', array('stock' => $Quantity), array('id' => $SkuID, 'goodsid' => $PlatProductID));
			pdo_update('ewei_shop_goods', array('total' => $goods_total), array('id' => $PlatProductID));
		}
		else {
			pdo_update('ewei_shop_goods', array('total' => $Quantity), array('id' => $PlatProductID));
		}

		$return_data['Quantity'] = $Quantity;
		return $return_data;
	}

	public function errorData($submessage = '', $subcode = 0, $message = '')
	{
		$subcode_array = array();
		$subcode_array[0][0] = 'GSE.SYSTEM_ERROR';
		$subcode_array[0][1] = '系统错误';
		$subcode_array[1][0] = 'GSE.VERIFYSIGN_FAILURE';
		$subcode_array[1][1] = '验签失败';
		$subcode_array[2][0] = 'GSE.ILLEGAL_ACCESS';
		$subcode_array[2][1] = '未知的请求方法';
		$subcode_array[3][0] = 'GSE.MISS_PARAMETER';
		$subcode_array[3][1] = '缺少参数';
		$subcode_array[4][0] = 'GSE.INVALID_PARAMETER';
		$subcode_array[4][1] = '非法参数';
		$subcode_array[5][0] = 'GSE.APPKEY_FAILURE';
		$subcode_array[5][1] = '获取ERP密钥失败';
		$subcode_array[6][0] = 'GSE.PLAT_NOT_SUPPORT';
		$subcode_array[6][1] = '平台不支持此接口';
		$subcode_array[7][0] = 'GSE.LOGIC_ERROR';
		$subcode_array[7][1] = '平台业务错误';
		$return_data['code'] = '40000';
		$return_data['subcode'] = $subcode_array[$subcode][0];

		if (empty($message)) {
			$message = str_replace('GSE.', '', $return_data['subcode']);
			$message = strtolower($message);
		}

		$return_data['message'] = $message;

		if (empty($submessage)) {
			$submessage = $subcode_array[$subcode][1];
		}

		$return_data['submessage'] = $submessage;
		$data = json_encode($return_data);
		echo $data;
		exit();
	}

	public function getExpressInfo($LogisticType)
	{
		global $_W;
		$express = pdo_fetch('select * from ' . tablename('ewei_shop_express') . ' where code=:code limit 1', array(':code' => $LogisticType));
		return $express;
	}

	public function getOrderData($ordersn, $uniacid)
	{
		global $_W;
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where  ordersn=:ordersn and uniacid=:uniacid Limit 1', array(':ordersn' => $ordersn, ':uniacid' => $uniacid));
		return $item;
	}

	public function get_refund_text()
	{
		$refund_text = array();
		$refund_text[-1] = '卖家拒绝维权申请';
		$refund_text[0] = '等待卖家处理维权申请';
		$refund_text[1] = '维权申请完成';
		$refund_text[3] = '卖家通过维权申请,等待买家寄回商品';
		$refund_text[4] = '买家已经退货等待卖家确认收货';
		$refund_text[5] = '卖家重新发货,等待买家确认';
		return $refund_text;
	}

	public function get_refund_status()
	{
		$refund_status = array();
		$refund_status[-1] = 'JH_04';
		$refund_status[0] = 'JH_01';
		$refund_status[1] = 'JH_06';
		$refund_status[3] = 'JH_02';
		$refund_status[4] = 'JH_03';
		$refund_status[5] = 'JH_99';
		return $refund_status;
	}

	public function insert_data($data, $uniacid)
	{
		global $_W;
		global $_GPC;
		$time = time();
		$insert_data = array();
		$insert_data['uniacid'] = $uniacid;
		$insert_data['gpc'] = iserializer($_GPC);
		$insert_data['post'] = $data;
		$insert_data['createtime'] = $time;
		pdo_insert('ewei_shop_polyapi_data', $insert_data);
	}

	public function get_data($uniacid)
	{
		global $_W;
		global $_GPC;
		$params = array();
		$params[':uniacid'] = $uniacid;
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_polyapi_data') . ' WHERE uniacid=:uniacid order by id desc';
		$list = pdo_fetchall($sql, $params);

		if (!empty($list)) {
			foreach ($list as $k => $v) {
				$list[$k]['gpc'] = iunserializer($v['gpc']);
			}
		}

		return $list;
	}
}

?>
