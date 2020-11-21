<?php
require EWEI_SHOPV2_PLUGIN . 'newstore/core/inc/page_newstore.php';
class Index_EweiShopV2Page extends NewstoreWebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}
	public function checkverifygoods() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['newstore_openid'];
		$verifycode = trim($_GPC['code']);
		if (empty($verifycode)) 
		{
			show_json(0, array('message' => '未查询到记次时商品或核销码已失效,请核对核销码!'));
		}
		$verifygood = pdo_fetch('select vg.*,g.id as goodsid ,g.title,g.subtitle,g.thumb,o.openid,o.paytime,vg.storeid  from ' . tablename('ewei_shop_verifygoods') . '   vg' . "\r\n\t\t" . ' inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id' . "\r\n\t\t" . ' inner join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid' . "\r\n\t\t" . ' inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id' . "\r\n\t\t" . ' where   vg.verifycode=:verifycode and vg.uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':verifycode' => $verifycode));
		if (empty($verifygood)) 
		{
			show_json(0, array('message' => '未查询到记次时商品,请核对核销码!'));
		}
		if (intval($verifygood['codeinvalidtime']) < time()) 
		{
			show_json(0, array('message' => '核销码已失效，请联系用户刷新页面获取最新核销码!'));
		}
		$saler = pdo_fetch('select * from ' . tablename('ewei_shop_saler') . ' where  status=1  and openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
		if (empty($saler)) 
		{
			show_json(0, array('message' => '您不是核销员,无权核销'));
		}
		$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $saler['storeid'], ':uniacid' => $_W['uniacid']));
		if (!(empty($verifygood['storeid'])) && !(empty($store)) && ($verifygood['storeid'] != $store['id'])) 
		{
			show_json(0, array('message' => '该商品无法在您所属门店核销!请重新确认!'));
		}
		$setverifynum = 0;
		if (!(empty($verifygood['limitnum']))) 
		{
			$verifygoodlogs = pdo_fetchall('select *  from ' . tablename('ewei_shop_verifygoods_log') . '    where verifygoodsid =:id  ', array(':id' => $verifygood['id']));
			$verifynum = 0;
			foreach ($verifygoodlogs as $verifygoodlog ) 
			{
				$verifynum += intval($verifygoodlog['verifynum']);
			}
			$lastverifys = intval($verifygood['limitnum']) - $verifynum;
			$setverifynum = 1;
		}
		else 
		{
			$lastverifys = '不限';
		}
		$termofvalidity = date('Y-m-d H:i', intval($verifygood['starttime']) + ($verifygood['limitdays'] * 86400));
		$paytime = date('Y-m-d H:i', intval($verifygood['paytime']));
		$showgoods = array();
		$showgoods[] = array('thumb' => tomedia($verifygood['thumb']), 'title' => $verifygood['title'], 'subtitle' => $verifygood['subtitle'], 'lastverifys' => $lastverifys);
		$member = m('member')->getMember($verifygood['openid']);
		$info = array();
		$info[] = '购买时间:' . $paytime;
		$info[] = '有效天数:' . $verifygood['limitdays'];
		$info[] = '有效期至:' . $termofvalidity;
		$info[] = '剩余次数:' . $lastverifys;
		if (!(empty($member))) 
		{
			$info[] = '客户ID:' . $member['id'];
			$info[] = '客户姓名:' . $member['nickname'];
			$info[] = '客户电话:' . $member['mobile'];
		}
		show_json(1, array('showgood' => $showgoods, 'type' => '1', 'info' => $info, 'setverifynum' => $setverifynum));
	}
	public function completeverifygoods() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['newstore_openid'];
		$times = intval($_GPC['times']);
		$verifycode = trim($_GPC['verifycode']);
		$remarks = trim($_GPC['remarks']);
		$verifygood = pdo_fetch('select *  from ' . tablename('ewei_shop_verifygoods') . ' where uniacid=:uniacid and  verifycode=:verifycode  limit 1 ', array(':uniacid' => $_W['uniacid'], ':verifycode' => $verifycode));
		if (empty($verifygood)) 
		{
			show_json(0, array('message' => '核销码已过期,请重新输入核销码或扫取二维码'));
		}
		if (intval($verifygood['codeinvalidtime']) < time()) 
		{
			show_json(0, array('message' => '核销码已过期,请重新输入核销码或扫取二维码'));
		}
		$saler = pdo_fetch('select * from ' . tablename('ewei_shop_saler') . ' where  status=1  and openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
		if (empty($saler)) 
		{
			show_json(0, array('message' => '您不是核销员,无权核销'));
		}
		$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $saler['storeid'], ':uniacid' => $_W['uniacid']));
		if (!(empty($verifygood['storeid'])) && !(empty($store)) && ($verifygood['storeid'] != $store['id'])) 
		{
			show_json(0, array('message' => '该商品无法在您所属门店核销!请重新确认!'));
		}
		$used = 0;
		if (!(empty($verifygood['limitnum']))) 
		{
			$verifygoodlogs = pdo_fetchall('select *  from ' . tablename('ewei_shop_verifygoods_log') . '    where verifygoodsid =:id  ', array(':id' => $verifygood['id']));
			$verifynum = 0;
			foreach ($verifygoodlogs as $verifygoodlog ) 
			{
				$verifynum += intval($verifygoodlog['verifynum']);
			}
			$lastverifys = intval($verifygood['limitnum']) - $verifynum;
			if ($lastverifys < $times) 
			{
				show_json(0, array('message' => '商品可核销次数不足'));
			}
			if ($lastverifys == $times) 
			{
				$used = 1;
			}
		}
		if (empty($verifygood['limittype'])) 
		{
			$limitdate = intval($verifygood['starttime']) + (intval($verifygood['limitdays']) * 86400);
		}
		else 
		{
			$limitdate = intval($verifygood['limitdate']);
		}
		if ($limitdate < time()) 
		{
			show_json(0, array('message' => '该商品已过期,无法核销!\''));
		}
		$data = array('uniacid' => $_W['uniacid'], 'verifygoodsid' => $verifygood['id'], 'salerid' => $saler['id'], 'storeid' => $store['id'], 'verifynum' => $times, 'verifydate' => time(), 'remarks' => $remarks);
		pdo_insert('ewei_shop_verifygoods_log', $data);
		pdo_query('update ' . tablename('ewei_shop_verifygoods') . ' set used=:used , verifycode=null ,codeinvalidtime=0 where id=:id', array(':id' => $verifygood['id'], ':used' => $used));
		if (!(empty($verifygood['activecard']))) 
		{
			com_run('wxcard::updateusercardbyvarifygoodid', $verifygood['id']);
		}
		show_json(1, array('message' => '核销成功!\''));
	}
	public function success() 
	{
		include $this->template();
	}
	public function checkverifycode() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['newstore_openid'];
		$verifycode = trim($_GPC['code']);
		if (empty($verifycode)) 
		{
			show_json(0, array('message' => '请填写消费码或自提码!\''));
		}
		$orderid = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and ( verifycode=:verifycode or verifycodes like :verifycodes ) limit 1 ', array(':uniacid' => $_W['uniacid'], ':verifycode' => $verifycode, ':verifycodes' => '%|' . $verifycode . '|%'));
		if (empty($orderid)) 
		{
			show_json(0, array('message' => '未查询到订单,请核对!'));
		}
		$allow = com('verify')->allow($orderid, 0, $verifycode, $openid);
		if (is_error($allow)) 
		{
			show_json(0, array('message' => $allow['message']));
		}
		extract($allow);
		$showgoods = array();
		foreach ($allgoods as $good ) 
		{
			$item = array('thumb' => tomedia($good['thumb']), 'title' => $good['title'], 'optiontitle' => (empty($good['optiontitle']) ? ' ' : $good['optiontitle']), 'price' => $good['price'], 'total' => $good['total']);
			$showgoods[] = $item;
		}
		$paytime = date('Y-m-d H:i', intval($order['paytime']));
		$verifytype = $order['verifytype'];
		$verifytitle = '';
		$setverifynum = 0;
		if ($verifytype == 0) 
		{
			$verifytitle = '核销方式:按订单核销';
		}
		else if ($verifytype == 1) 
		{
			$verifytitle = '核销方式:按次核销';
			$setverifynum = 1;
		}
		else if ($verifytype == 2) 
		{
			$verifytitle = '核销方式:按消费码核销';
		}
		else if ($verifytype == 3) 
		{
			$verifytitle = '核销方式:门店核销';
		}
		$info = array();
		$info[] = '购买时间:' . $paytime;
		if ($verifytype == 1) 
		{
			$info[] = '剩余次数:' . $lastverifys;
		}
		$info[] = $verifytitle;
		$info[] = '';
		$member = m('member')->getMember($order['openid']);
		if (!(empty($member))) 
		{
			$info[] = '客户ID:' . $member['id'];
			$info[] = '客户姓名:' . $member['nickname'];
			$info[] = '客户电话:' . $member['mobile'];
		}
		show_json(1, array('showgood' => $showgoods, 'type' => '2', 'info' => $info, 'setverifynum' => $setverifynum, 'orderid' => $orderid));
	}
	public function checkngoods() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['newstore_openid'];
		$verifycode = trim($_GPC['code']);
		if (empty($verifycode)) 
		{
			show_json(0, array('message' => '请填写消费码或自提码!\''));
		}
		$orderid = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and ( verifycode=:verifycode or verifycodes like :verifycodes ) limit 1 ', array(':uniacid' => $_W['uniacid'], ':verifycode' => $verifycode, ':verifycodes' => '%|' . $verifycode . '|%'));
		if (empty($orderid)) 
		{
			show_json(0, array('message' => '未查询到订单,请核对!'));
		}
		$allow = com('verify')->allow($orderid, 0, $verifycode, $openid);
		if (is_error($allow)) 
		{
			show_json(0, array('message' => $allow['message']));
		}
		extract($allow);
		$paytime = date('Y-m-d H:i', intval($order['paytime']));
		$verifytitle = '核销方式:预约核销';
		$temp_type = $this->model->getTempType();
		$tempinfo = $this->model->getTempInfo($goods['tempid']);
		if (!(empty($goods['peopleid']))) 
		{
			$goods['peopleinfo'] = $this->model->getPeopleInfo($goods['peopleid']);
		}
		$info = array();
		$info[] = '订金:' . $order['dowpayment'] . $item['payinfo'];
		$info[] = '尾款:' . $order['betweenprice'] . $item['tradepayinfo'];
		$info[] = '购买时间:' . $paytime;
		$info[] = '预约时间:' . date('Y-m-d', $goods['trade_time']) . ' ' . $goods['optime'];
		if (!(empty($carrier['carrier_realname']))) 
		{
			$info[] = '姓名:' . $carrier['carrier_realname'];
		}
		if (!(empty($carrier['carrier_mobile']))) 
		{
			$info[] = '电话:' . $carrier['carrier_mobile'];
		}
		if (!(empty($goods['peopleinfo']))) 
		{
			$info[] = '预约' . $temp_type[$tempinfo['type']]['trade'] . ':' . $goods['peopleinfo']['nickname'];
		}
		if (!(empty($carrier['carrier_id']))) 
		{
			$info[] = '身份证:' . $carrier['carrier_id'];
		}
		$info[] = $verifytitle;
		$info[] = '';
		$member = m('member')->getMember($order['openid']);
		if (!(empty($member))) 
		{
			$info[] = '客户ID:' . $member['id'];
			$info[] = '客户姓名:' . $member['nickname'];
		}
		$showgoods = array();
		foreach ($allgoods as $good ) 
		{
			$item = array('thumb' => tomedia($good['thumb']), 'title' => $good['title'], 'optiontitle' => (empty($good['optiontitle']) ? ' ' : $good['optiontitle']), 'price' => $good['price'], 'dowpayment' => $order['dowpayment'], 'betweenprice' => $order['betweenprice'], 'tradestatus' => $order['tradestatus'], 'total' => $good['total']);
			if (0 < $order['tradestatus']) 
			{
				$item['payinfo'] = '(定金已付款)';
			}
			else 
			{
				$item['payinfo'] = '(定金未支付)';
			}
			if ($order['tradestatus'] == 2) 
			{
				$item['tradepayinfo'] = '(尾款已付款)';
			}
			else 
			{
				$item['tradepayinfo'] = '(尾款未支付)';
			}
			$item['tradetime'] = '预约时间:' . date('Y-m-d', $goods['trade_time']) . ' ' . $goods['optime'];
			if (!(empty($goods['peopleinfo']))) 
			{
				$item['peopletype'] = $temp_type[$tempinfo['type']]['trade'];
				$item['peopleinfo'] = $goods['peopleinfo']['nickname'];
			}
			$showgoods[] = $item;
		}
		show_json(1, array('showgood' => $showgoods, 'type' => '3', 'info' => $info, 'orderid' => $orderid));
	}
	public function completeverifycode() 
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['orderid']);
		$times = intval($_GPC['times']);
		$verifycode = trim($_GPC['verifycode']);
		$openid = $_W['newstore_openid'];
		com('verify')->verify($orderid, $times, $verifycode, $openid);
		show_json(1, array('message' => '核销成功!\''));
	}
}
?>