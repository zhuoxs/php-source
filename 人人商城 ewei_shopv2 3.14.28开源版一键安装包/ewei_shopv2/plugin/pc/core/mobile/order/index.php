<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_login_mobile.php";
class Index_EweiShopV2Page extends PcMobileLoginPage 
{
	protected function merchData() 
	{
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) 
		{
			$is_openmerch = 1;
		}
		else 
		{
			$is_openmerch = 0;
		}
		return array("is_openmerch" => $is_openmerch, 'merch_plugin' => $merch_plugin, 'merch_data' => $merch_data);
	}
	public function main() 
	{
		global $_W;
		global $_GPC;
		$trade = m('common')->getSysset('trade');
		$merchdata = $this->merchData();
		extract($merchdata);
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '交易订单') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '订单列表', 'menu_url' => mobileUrl('pc.order')), array('menu_key' => 'recycle', 'menu_name' => '回收站', 'menu_url' => mobileUrl('pc.order', array('mk' => 'recycle'))) );
		$all_list = $this->get_list();
		$list = $all_list['list'];
		$pindex = max(1, intval($_GPC['page']));
		$pager = fenye($all_list['total'], $pindex, $all_list['psize']);
		include $this->template();
	}
	public function get_list() 
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$show_status = $_GPC['status'];
		$r_type = array('退款', '退货退款', '换货');
		$condition = ' and openid=:openid and ismr=0 and deleted=0 and uniacid=:uniacid ';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$merchdata = $this->merchData();
		extract($merchdata);
		$condition .= ' and merchshow=0 ';
		$show_status = intval($show_status);
		switch ($show_status) 
		{
			case -2: $condition .= ' and status=0 and paytype!=3';
			break;
			case 0: if ($_GPC['mk'] == 'recycle') 
			{
				$condition .= ' ';
			}
			else 
			{
				$condition .= ' and status!=-1 ';
			}
			break;
			case 2: $condition .= ' and (status=2 or status=0 and paytype=3)';
			break;
			case 4: $condition .= ' and refundstate>0';
			break;
			case 5: $condition .= ' and userdeleted=1 ';
			break;
			$condition .= ' and status=' . intval($show_status);
			goto label85;
			label85: if ($_GPC['mk'] == 'recycle') 
			{
				$condition .= ' and userdeleted=1 ';
			}
			else if ($show_status != 5) 
			{
				$condition .= ' and userdeleted=0 ';
			}
			$order_sn_search = $_GPC['order_sn'];
			if (!(empty($order_sn_search))) 
			{
				$condition .= ' and ordersn LIKE \'%' . $order_sn_search . '%\' ';
			}
			$query_start_date = $_GPC['start_date'];
			$query_end_date = $_GPC['end_date'];
			if (!(empty($query_start_date))) 
			{
				$query_start_date = strtotime($query_start_date);
				$condition .= ' AND createtime >= ' . $query_start_date;
			}
			if (!(empty($query_end_date))) 
			{
				$query_end_date = strtotime($query_end_date);
				$condition .= ' AND createtime <=  ' . $query_end_date;
			}
			$com_verify = com('verify');
			$list = pdo_fetchall('select id,addressid,ordersn,price,dispatchprice,status,iscomment,isverify,' . "\n" . 'verified,verifycode,verifytype,iscomment,refundid,expresscom,express,expresssn,finishtime,`virtual`,' . "\n" . 'paytype,expresssn,refundstate,dispatchtype,verifyinfo,merchid,isparent,userdeleted' . "\n" . ' from ' . tablename('ewei_shop_order') . ' where 1 ' . $condition . ' order by createtime desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
			$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where 1 ' . $condition, $params);
			$refunddays = intval($_W['shopset']['trade']['refunddays']);
			if ($is_openmerch == 1) 
			{
				$merch_user = $merch_plugin->getListUser($list, 'merch_user');
			}
			foreach ($list as &$row ) 
			{
				$param = array();
				if ($row['isparent'] == 1) 
				{
					$scondition = ' og.parentorderid=:parentorderid';
					$param[':parentorderid'] = $row['id'];
				}
				else 
				{
					$scondition = ' og.orderid=:orderid';
					$param[':orderid'] = $row['id'];
				}
				$sql = 'SELECT og.goodsid,og.total,g.title,g.thumb,og.price,og.optionname as optiontitle,og.optionid,op.specs FROM ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . ' where ' . $scondition . ' order by og.id asc';
				$goods = pdo_fetchall($sql, $param);
				foreach ($goods as &$r ) 
				{
					if (!(empty($r['specs']))) 
					{
						$thumb = m('goods')->getSpecThumb($r['specs']);
						if (!(empty($thumb))) 
						{
							$r['thumb'] = $thumb;
						}
					}
				}
				unset($r);
				$row['goods'] = set_medias($goods, 'thumb');
				foreach ($row['goods'] as &$r ) 
				{
					$r['thumb'] .= '?t=' . random(50);
				}
				unset($r);
				$statuscss = 'text-cancel';
				switch ($row['status']) 
				{
					case '-1': $status = '已取消';
					break;
					case '0': if ($row['paytype'] == 3) 
					{
						$status = '待发货';
					}
					else 
					{
						$status = '待付款';
					}
					$statuscss = 'text-cancel';
					break;
					case '1': if ($row['isverify'] == 1) 
					{
						$status = '使用中';
					}
					else if (empty($row['addressid'])) 
					{
						$status = '待取货';
					}
					else 
					{
						$status = '待发货';
					}
					$statuscss = 'text-warning';
					break;
					case '2': $status = '待收货';
					$statuscss = 'text-danger';
					break;
					case '3': if (empty($row['iscomment'])) 
					{
						if ($show_status == 5) 
						{
							$status = '已完成';
						}
						else 
						{
							$status = ((empty($_W['shopset']['trade']['closecomment']) ? '待评价' : '已完成'));
						}
					}
					else 
					{
						$status = '交易完成';
					}
					$statuscss = 'text-success';
				}
				$row['statusstr'] = $status;
				$row['statuscss'] = $statuscss;
				if ((0 < $row['refundstate']) && !(empty($row['refundid']))) 
				{
					$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $row['refundid'], ':uniacid' => $uniacid, ':orderid' => $row['id']));
					if (!(empty($refund))) 
					{
						$row['statusstr'] = '待' . $r_type[$refund['rtype']];
					}
				}
				$canrefund = false;
				$row['canrefund'] = $canrefund;
				$row['canverify'] = false;
				$canverify = false;
				if ($com_verify) 
				{
					$showverify = $row['dispatchtype'] || $row['isverify'];
					if ($row['isverify']) 
					{
						if (($row['verifytype'] == 0) || ($row['verifytype'] == 1)) 
						{
							$vs = iunserializer($row['verifyinfo']);
							$verifyinfo = array( array('verifycode' => $row['verifycode'], 'verified' => ($row['verifytype'] == 0 ? $row['verified'] : $row['goods'][0]['total'] <= count($vs))) );
							if ($row['verifytype'] == 0) 
							{
								$canverify = empty($row['verified']) && $showverify;
							}
							else if ($row['verifytype'] == 1) 
							{
								$canverify = (count($vs) < $row['goods'][0]['total']) && $showverify;
							}
						}
						else 
						{
							$verifyinfo = iunserializer($row['verifyinfo']);
							$last = 0;
							foreach ($verifyinfo as $v ) 
							{
								if (!($v['verified'])) 
								{
									++$last;
								}
							}
							$canverify = (0 < $last) && $showverify;
						}
					}
					else if (!(empty($row['dispatchtype']))) 
					{
						$canverify = ($row['status'] == 1) && $showverify;
					}
				}
				$row['canverify'] = $canverify;
				if ($is_openmerch == 1) 
				{
					$row['merchname'] = (($merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name']));
				}
			}
		}
		unset($row);
		return array("list" => $list, 'total' => $total, 'psize' => $psize);
	}
	public function alipay() 
	{
		global $_W;
		global $_GPC;
		$url = urldecode($_GPC['url']);
		if (!(is_weixin())) 
		{
			header("location: " . $url);
			exit();
		}
		include $this->template();
	}
	public function detail() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$member = m('member')->getMember($openid, true);
		$orderid = intval($_GPC['id']);
		if (empty($orderid)) 
		{
			header('location: ' . mobileUrl('pc.order'));
			exit();
		}
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('link' => mobileUrl('pc.order'), 'title' => '交易订单'), array('title' => '订单详情') );
		$ice_menu_array = array( array('menu_key' => 'order', 'menu_name' => '订单列表', 'menu_url' => mobileUrl('pc.order')), array('menu_key' => 'index', 'menu_name' => '订单详情', 'menu_url' => mobileUrl('pc.order', array('id' => $orderid))) );
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		if (empty($order)) 
		{
			header('location: ' . mobileUrl('pc.order'));
			exit();
		}
		if ($order['merchshow'] == 1) 
		{
			header('location: ' . mobileUrl('pc.order'));
			exit();
		}
		if ($order['userdeleted'] == 2) 
		{
			$this->message('订单已经被删除!', '', 'error');
		}
		$merchdata = $this->merchData();
		extract($merchdata);
		$merchid = $order['merchid'];
		$diyform_plugin = p('diyform');
		$diyformfields = '';
		if ($diyform_plugin) 
		{
			$diyformfields = ',og.diyformfields,og.diyformdata';
		}
		$param = array();
		$param[':uniacid'] = $_W['uniacid'];
		if ($order['isparent'] == 1) 
		{
			$scondition = ' og.parentorderid=:parentorderid';
			$param[':parentorderid'] = $orderid;
		}
		else 
		{
			$scondition = ' og.orderid=:orderid';
			$param[':orderid'] = $orderid;
		}
		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids' . $diyformfields . '  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where ' . $scondition . ' and og.uniacid=:uniacid ', $param);
		if (!(empty($goods))) 
		{
			foreach ($goods as &$g ) 
			{
				if (!(empty($g['optionid']))) 
				{
					$thumb = m('goods')->getOptionThumb($g['goodsid'], $g['optionid']);
					if (!(empty($thumb))) 
					{
						$g['thumb'] = $thumb;
					}
				}
			}
			unset($g);
		}
		$diyform_flag = 0;
		if ($diyform_plugin) 
		{
			foreach ($goods as &$g ) 
			{
				$g['diyformfields'] = iunserializer($g['diyformfields']);
				$g['diyformdata'] = iunserializer($g['diyformdata']);
				unset($g);
			}
			if (!(empty($order['diyformfields'])) && !(empty($order['diyformdata']))) 
			{
				$order_fields = iunserializer($order['diyformfields']);
				$order_data = iunserializer($order['diyformdata']);
			}
		}
		$address = false;
		if (!(empty($order['addressid']))) 
		{
			$address = iunserializer($order['address']);
			if (!(is_array($address))) 
			{
				$address = pdo_fetch('select * from  ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $order['addressid']));
			}
		}
		$carrier = @iunserializer($order['carrier']);
		if (!(is_array($carrier)) || empty($carrier)) 
		{
			$carrier = false;
		}
		$store = false;
		if (!(empty($order['storeid']))) 
		{
			if (0 < $merchid) 
			{
				$store = pdo_fetch('select * from  ' . tablename('ewei_shop_merch_store') . ' where id=:id limit 1', array(':id' => $order['storeid']));
			}
			else 
			{
				$store = pdo_fetch('select * from  ' . tablename('ewei_shop_store') . ' where id=:id limit 1', array(':id' => $order['storeid']));
			}
		}
		$stores = false;
		$showverify = false;
		$canverify = false;
		$verifyinfo = false;
		if (com("verify")) 
		{
			$showverify = $order['dispatchtype'] || $order['isverify'];
			if ($order['isverify']) 
			{
				$storeids = array();
				foreach ($goods as $g ) 
				{
					if (!(empty($g['storeids']))) 
					{
						$storeids = array_merge(explode(',', $g['storeids']), $storeids);
					}
				}
				if (empty($storeids)) 
				{
					if (0 < $merchid) 
					{
						$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where  uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
					}
					else 
					{
						$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
					}
				}
				else if (0 < $merchid) 
				{
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_merch_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and merchid=:merchid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else 
				{
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}
				if (($order['verifytype'] == 0) || ($order['verifytype'] == 1)) 
				{
					$vs = iunserializer($order['verifyinfo']);
					$verifyinfo = array( array('verifycode' => $order['verifycode'], 'verified' => ($order['verifytype'] == 0 ? $order['verified'] : $goods[0]['total'] <= count($vs))) );
					if ($order['verifytype'] == 0) 
					{
						$canverify = empty($order['verified']) && $showverify;
					}
					else if ($order['verifytype'] == 1) 
					{
						$canverify = (count($vs) < $goods[0]['total']) && $showverify;
					}
				}
				else 
				{
					$verifyinfo = iunserializer($order['verifyinfo']);
					$last = 0;
					foreach ($verifyinfo as $v ) 
					{
						if (!($v['verified'])) 
						{
							++$last;
						}
					}
					$canverify = (0 < $last) && $showverify;
				}
			}
			else if (!(empty($order['dispatchtype']))) 
			{
				$verifyinfo = array( array('verifycode' => $order['verifycode'], 'verified' => $order['status'] == 3) );
				$canverify = ($order['status'] == 1) && $showverify;
			}
		}
		$order['canverify'] = $canverify;
		$order['showverify'] = $showverify;
		$order['virtual_str'] = str_replace("\n", '<br/>', $order['virtual_str']);
		if (($order['status'] == 1) || ($order['status'] == 2)) 
		{
			$canrefund = true;
			if (($order['status'] == 2) && ($order['price'] == $order['dispatchprice'])) 
			{
				if (0 < $order['refundstate']) 
				{
					$canrefund = true;
				}
				else 
				{
					$canrefund = false;
				}
			}
		}
		else if ($order['status'] == 3) 
		{
			if (($order['isverify'] != 1) && empty($order['virtual'])) 
			{
				if (0 < $order['refundstate']) 
				{
					$canrefund = true;
				}
				else 
				{
					$tradeset = m('common')->getSysset('trade');
					$refunddays = intval($tradeset['refunddays']);
					if (0 < $refunddays) 
					{
						$days = intval((time() - $order['finishtime']) / 3600 / 24);
						if ($days <= $refunddays) 
						{
							$canrefund = true;
						}
					}
				}
			}
		}
		$order['canrefund'] = $canrefund;
		$express = false;
		if ((2 <= $order['status']) && empty($order['isvirtual']) && empty($order['isverify'])) 
		{
			$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);
			if (0 < count($expresslist)) 
			{
				$express = $expresslist[0];
			}
		}
		$shopname = $_W['shopset']['shop']['name'];
		if (!(empty($order['merchid'])) && ($is_openmerch == 1)) 
		{
			$merch_user = $merch_plugin->getListUser($order['merchid']);
			$shopname = $merch_user['merchname'];
			$shoplogo = tomedia($merch_user['logo']);
		}
		include $this->template();
	}
	public function express() 
	{
		global $_W;
		global $_GPC;
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$orderid = intval($_GPC['id']);
		if (empty($orderid)) 
		{
			header('location: ' . mobileUrl('pc.order'));
			exit();
		}
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		if (empty($order)) 
		{
			header('location: ' . mobileUrl('pc.order'));
			exit();
		}
		if (empty($order['addressid'])) 
		{
			$this->message('订单非快递单，无法查看物流信息!');
		}
		if ($order['status'] < 2) 
		{
			$this->message('订单未发货，无法查看物流信息!');
		}
		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids' . $diyformfields . '  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));
		$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);
		include $this->template();
	}
}
?>