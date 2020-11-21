<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_login_mobile.php";
class Log_EweiShopV2Page extends PcMobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$status = intval($_GPC['status']);
		$_W['shopshare'] = array('title' => $this->set['share_title'], 'imgUrl' => tomedia($this->set['share_icon']), 'link' => mobileUrl('creditshop', array(), true), 'desc' => $this->set['share_desc']);
		$com = p('commission');
		if ($com) 
		{
			$cset = $com->getSet();
			if (!(empty($cset))) 
			{
				if (($member['isagent'] == 1) && ($member['status'] == 1)) 
				{
					$_W['shopshare']['link'] = mobileUrl('creditshop', array('mid' => $member['id']), true);
					if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) 
					{
						$trigger = true;
					}
				}
				else if (!(empty($_GPC['mid']))) 
				{
					$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('mid' => $_GPC['mid']), true);
				}
			}
		}
		include $this->template();
	}
	public function getlist() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$status = intval($_GPC['status']);
		$set = m('common')->getPluginset('creditshop');
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and log.openid=:openid and  log.uniacid = :uniacid and log.status>0';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		if ($status == 1) 
		{
			$condition .= ' and g.type = 0 ';
		}
		else if ($status == 2) 
		{
			$condition .= ' and g.type = 1 ';
		}
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_creditshop_log') . ' log' . "\n" . '                left join ' . tablename('ewei_shop_creditshop_goods') . ' g on log.goodsid = g.id' . "\n" . '                where 1 ' . $condition;
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();
		if (!(empty($total))) 
		{
			$sql = 'SELECT log.id,log.logno,log.goodsid,log.status,log.eno,log.paystatus,g.title,g.type,g.thumb,g.credit,g.money,g.isverify,g.goodstype,log.addressid,log.storeid,' . 'g.goodstype,log.time_send,log.time_finish,log.iscomment,op.title as optiontitle ' . ' FROM ' . tablename('ewei_shop_creditshop_log') . ' log ' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on log.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_creditshop_option') . ' op on op.id = log.optionid ' . ' where 1 ' . $condition . ' ORDER BY log.createtime DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb');
			foreach ($list as &$row ) 
			{
				if ((0 < $row['credit']) & (0 < $row['money'])) 
				{
					$row['acttype'] = 0;
				}
				else if (0 < $row['credit']) 
				{
					$row['acttype'] = 1;
				}
				else if (0 < $row['money']) 
				{
					$row['acttype'] = 2;
				}
				else 
				{
					$row['acttype'] = 3;
				}
				if (($row['money'] - intval($row['money'])) == 0) 
				{
					$row['money'] = intval($row['money']);
				}
				$row['isreply'] = $set['isreply'];
			}
			unset($row);
		}
		show_json(1, array("list" => $list, 'pagesize' => $psize, 'total' => $total));
	}
	public function detail() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$set = m('common')->getPluginset('creditshop');
		$pay = m('common')->getSysset('pay');
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));
		if (empty($log)) 
		{
			show_json(-1, '兑换记录不存在!');
		}
		$goods = $this->model->getGoods($log['goodsid'], $member, $log['optionid']);
		if (empty($goods['id'])) 
		{
			show_json(-1, '商品记录不存在!');
		}
		$address = false;
		if (!(empty($log['addressid']))) 
		{
			$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $log['addressid'], ':uniacid' => $uniacid, ':openid' => $openid));
			$goods['dispatch'] = $this->model->dispatch($log['addressid'], $goods);
		}
		$goods['currenttime'] = time();
		$stores = array();
		$store = false;
		if (!(empty($goods['isverify']))) 
		{
			$verifytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_creditshop_verify') . ' where logid = :id and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ', array(':id' => $id, ':openid' => $log['openid'], ':uniacid' => $log['uniacid'], ':verifycode' => $log['eno']));
			if ($goods['verifytype'] == 0) 
			{
				$verify = pdo_fetch('select isverify from ' . tablename('ewei_shop_creditshop_verify') . ' where logid = :id and openid = :openid and uniacid = :uniacid and verifycode = :verifycode ', array(':id' => $log['id'], ':openid' => $log['openid'], ':uniacid' => $log['uniacid'], ':verifycode' => $log['eno']));
			}
			$verifynum = $log['verifynum'] - $verifytotal;
			if ($verifynum < 0) 
			{
				$verifynum = 0;
			}
			$storeids = array();
			$storeids = array_merge(explode(',', $log['storeid']), $storeids);
			if (empty($log['storeid'])) 
			{
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and `type` in (2,3) ', array(':uniacid' => $_W['uniacid']));
			}
			else 
			{
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and `type` in(2,3)', array(':uniacid' => $_W['uniacid']));
			}
			$isverify = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_verify') . ' where logid = ' . $log['id'] . ' and uniacid = ' . $uniacid . ' and isverify = 1 limit 1 ');
			if (0 < $isverify['isverify']) 
			{
				$carrier = m('member')->getMember($isverify['verifier']);
				if (!(is_array($carrier)) || empty($carrier)) 
				{
					$carrier = false;
				}
				$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . "\n" . '                    where id = ' . $isverify['storeid'] . ' and uniacid=:uniacid and status=1 and `type` in(2,3)', array(':uniacid' => $_W['uniacid']));
			}
		}
		$_W['shopshare'] = array('title' => $this->set['share_title'], 'imgUrl' => tomedia($this->set['share_icon']), 'link' => mobileUrl('creditshop', array(), true), 'desc' => $this->set['share_desc']);
		$com = p('commission');
		if ($com) 
		{
			$cset = $com->getSet();
			if (!(empty($cset))) 
			{
				if (($member['isagent'] == 1) && ($member['status'] == 1)) 
				{
					$_W['shopshare']['link'] = mobileUrl('creditshop', array('mid' => $member['id']), true);
					if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) 
					{
						$trigger = true;
					}
				}
				else if (!(empty($_GPC['mid']))) 
				{
					$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('mid' => $_GPC['mid']), true);
				}
			}
		}
		include $this->template('pc/creditshop/log_detail');
	}
	public function Receivepacket() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$set = m('common')->getPluginset('creditshop');
		$logid = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id = ' . $logid . ' and uniacid = ' . $uniacid . ' ');
		if (!($log)) 
		{
			show_json(0, array('message' => '该订单不存在或已删除！'));
		}
		if ((2 < $log['status']) && (0 < $log['time_finish'])) 
		{
			show_json(0, array('message' => '红包已领取！'));
		}
		if ($log['status'] < 2) 
		{
			show_json(0, array('message' => '红包未满足领取条件！'));
		}
		$packet = $this->model->packetmoney($log['goodsid']);
		if (!($packet['status'])) 
		{
			show_json(0, $packet['message']);
		}
		$money = abs($packet['money']);
		$setting = uni_setting($_W['uniacid'], array('payment'));
		if (!(is_array($setting['payment']))) 
		{
			show_json(0, array('message' => '没有设定支付参数！'));
		}
		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);
		$certs = $sec;
		$wechat = $setting['payment']['wechat'];
		$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
		$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
		$params = array('openid' => $openid, 'tid' => $log['logno'], 'send_name' => ($set['sendname'] ? $set['sendname'] : $_W['shopset']['shop']['name']), 'money' => $money, 'wishing' => ($set['sendname'] ? $set['wishing'] : '红包领到手抽筋，别人加班你加薪!'), 'act_name' => '积分兑换红包', 'remark' => '积分兑换红包');
		$wechat = array('appid' => $row['key'], 'mchid' => $wechat['mchid'], 'apikey' => $wechat['apikey'], 'certs' => $certs);
		$goods = pdo_fetch('select surplusmoney from ' . tablename('ewei_shop_creditshop_goods') . ' where id = ' . $log['goodsid'] . ' and uniacid = ' . $uniacid . ' ');
		if (($goods['surplusmoney'] <= 0) || (($goods['surplusmoney'] - $money) < 0)) 
		{
			show_json(0, array('message' => '剩余金额不足，请联系管理员!'));
		}
		$err = m('common')->sendredpack($params, $wechat);
		if (is_error($err)) 
		{
			show_json(0, array('message' => '红包发放出错，请联系管理员!'));
		}
		else 
		{
			$update['time_finish'] = time();
			$update['status'] = 3;
			pdo_update("ewei_shop_creditshop_log", $update, array('id' => $logid));
			$updategoods['surplusmoney'] = $goods['surplusmoney'] - $money;
			pdo_update("ewei_shop_creditshop_goods", $updategoods, array('id' => $log['goodsid']));
		}
		show_json(1);
	}
	public function express() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$logid = intval($_GPC['id']);
		if (empty($logid)) 
		{
			header('location: ' . mobileUrl('creditshop/log'));
			exit();
		}
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:logid and uniacid=:uniacid and openid=:openid limit 1', array(':logid' => $logid, ':uniacid' => $uniacid, ':openid' => $openid));
		if (empty($log)) 
		{
			header('location: ' . mobileUrl('creditshop/log'));
			exit();
		}
		if (empty($log['addressid'])) 
		{
			$this->message('订单非快递单，无法查看物流信息!');
		}
		if (($log['status'] < 3) && empty($log['expresssn'])) 
		{
			$this->message('订单未发货，无法查看物流信息!');
		}
		$goods = pdo_fetch('select *  from ' . tablename('ewei_shop_creditshop_goods') . '  where id=:id and uniacid=:uniacid ', array(':uniacid' => $uniacid, ':id' => $log['goodsid']));
		$expresslist = m('util')->getExpressList($log['express'], $log['expresssn']);
		include $this->template('creditshop/log_express');
	}
	public function finish() 
	{
		global $_W;
		global $_GPC;
		$logid = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $logid, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		if (empty($log)) 
		{
			show_json(0, '订单未找到');
		}
		if (($log['status'] != 3) && empty($log['expresssn'])) 
		{
			show_json(0, '订单不能确认收货');
		}
		pdo_update("ewei_shop_creditshop_log", array("time_finish" => time()), array("id" => $logid, 'uniacid' => $_W['uniacid']));
		show_json(1);
	}
	public function paydispatch() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$paytype = trim($_GPC['paytype']);
		$id = intval($_GPC['id']);
		$addressid = intval($_GPC['addressid']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));
		if (empty($log)) 
		{
			show_json(0, '兑换记录不存在!');
		}
		$goods = $this->model->getGoods($log['goodsid'], $member);
		if (empty($goods['id'])) 
		{
			show_json(0, '商品记录不存在!');
		}
		if (!(empty($goods['isendtime']))) 
		{
			if ($goods['endtime'] < time()) 
			{
				show_json(0, '商品已过期!');
			}
		}
		if ($goods['dispatch'] <= 0) 
		{
			pdo_update('ewei_shop_creditshop_log', array('dispatchstatus' => 1, 'addressid' => $addressid), array('id' => $log['id']));
			show_json(1, array("logid" => $log['id']));
		}
		if (1 < $log['dispatchstatus']) 
		{
			show_json(0, '商品已支付运费!');
		}
		$set = m('common')->getSysset();
		if ($paytype == 'wechat') 
		{
			$set['pay']['weixin'] = ((!(empty($set['pay']['weixin_sub'])) ? 1 : $set['pay']['weixin']));
			$set['pay']['weixin_jie'] = ((!(empty($set['pay']['weixin_jie_sub'])) ? 1 : $set['pay']['weixin_jie']));
			if (!(is_weixin())) 
			{
				show_json(0, "非微信环境!");
			}
			if (empty($set['pay']['weixin']) && empty($set['pay']['weixin_jie'])) 
			{
				show_json(0, '未开启微信支付!');
			}
			$wechat = array('success' => false);
			$jie = intval($_GPC['jie']);
			$dispatchno = $log['dispatchno'];
			if (empty($dispatchno)) 
			{
				if (empty($goods['type'])) 
				{
					$dispatchno = str_replace('EE', 'EP', $log['logno']);
				}
				else 
				{
					$dispatchno = str_replace('EL', 'EP', $log['logno']);
				}
				pdo_update("ewei_shop_creditshop_log", array("dispatchno" => $dispatchno, 'addressid' => $addressid), array('id' => $log['id']));
			}
			$params = array();
			$params['tid'] = $dispatchno;
			$params['user'] = $openid;
			$params['fee'] = $goods['dispatch'];
			$params['title'] = $set['shop']['name'] . ((empty($goods['type']) ? '积分兑换' : '积分抽奖')) . ' 支付运费单号:' . $dispatchno;
			if (isset($set['pay']) && ($set['pay']['weixin'] == 1) && ($jie !== 1)) 
			{
				load()->model('payment');
				$setting = uni_setting($_W['uniacid'], array('payment'));
				$options = array();
				if (is_array($setting['payment'])) 
				{
					$options = $setting['payment']['wechat'];
					$options['appid'] = $_W['account']['key'];
					$options['secret'] = $_W['account']['secret'];
				}
				$wechat = m('common')->wechat_build($params, $options, 3);
				$wechat['success'] = false;
				if (!(is_error($wechat))) 
				{
					$wechat['weixin'] = true;
					$wechat['success'] = true;
				}
			}
			if ((isset($set['pay']) && ($set['pay']['weixin_jie'] == 1) && !($wechat['success'])) || ($jie === 1)) 
			{
				$params['tid'] = $params['tid'] . '_borrow';
				$sec = m('common')->getSec();
				$sec = iunserializer($sec['sec']);
				$options = array();
				$options['appid'] = $sec['appid'];
				$options['mchid'] = $sec['mchid'];
				$options['apikey'] = $sec['apikey'];
				if (!(empty($set['pay']['weixin_jie_sub'])) && !(empty($sec['sub_secret_jie_sub']))) 
				{
					$wxuser = m('member')->wxuser($sec['sub_appid_jie_sub'], $sec['sub_secret_jie_sub']);
					$params['openid'] = $wxuser['openid'];
				}
				else if (!(empty($sec['secret']))) 
				{
					$wxuser = m('member')->wxuser($sec['appid'], $sec['secret']);
					$params['openid'] = $wxuser['openid'];
				}
				$wechat = m('common')->wechat_native_build($params, $options, 3);
				if (!(is_error($wechat))) 
				{
					$wechat['success'] = true;
					if (!(empty($params['openid']))) 
					{
						$wechat['weixin'] = true;
					}
					else 
					{
						$wechat['weixin_jie'] = true;
					}
				}
			}
			if (!($wechat['success'])) 
			{
				show_json(0, '微信支付参数错误!');
			}
		}
		else if ($paytype == 'alipay') 
		{
			$paystatus = 2;
			$dispatchno = $log['dispatchno'];
			if (empty($dispatchno)) 
			{
				if (empty($goods['type'])) 
				{
					$dispatchno = str_replace('EE', 'EP', $log['logno']);
				}
				else 
				{
					$dispatchno = str_replace('EL', 'EP', $log['logno']);
				}
				pdo_update("ewei_shop_creditshop_log", array("dispatchno" => $dispatchno, 'addressid' => $addressid), array('id' => $log['id']));
			}
			$params = array();
			$params['tid'] = $dispatchno;
			$params['user'] = $openid;
			$params['fee'] = $goods['dispatch'];
			$params['title'] = $set['shop']['name'] . '积分兑换运费支付' . ' 单号:' . $log['logno'];
			if (isset($set['pay']) && ($set['pay']['alipay'] == 1)) 
			{
				load()->func('communication');
				load()->model("payment");
				$setting = uni_setting($_W['uniacid'], array('payment'));
				if (is_array($setting['payment'])) 
				{
					$options = $setting['payment']['alipay'];
					$alipay = m('common')->alipay_build($params, $options, 21, $_W['openid']);
					if (!(empty($alipay['url']))) 
					{
						$alipay['url'] = urlencode($alipay['url']);
						$alipay['success'] = true;
					}
				}
			}
			if (!($alipay['success'])) 
			{
				show_json(0, '支付宝支付参数错误!');
			}
		}
		show_json(1, array("logid" => $log['id'], 'wechat' => $wechat, 'alipay' => $alipay, 'jssdkconfig' => json_encode($_W['account']['jssdkconfig'])));
	}
	public function dispatch_complete() 
	{
		global $_GPC;
		global $_W;
		$set = m('common')->getSysset(array('shop', 'pay'));
		$fromwechat = intval($_GPC['fromwechat']);
		$tid = $_GPC['out_trade_no'];
		if (is_h5app()) 
		{
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$public_key = $sec['app_alipay']['public_key'];
			if (empty($set['pay']['app_alipay']) || empty($public_key)) 
			{
				$this->message('支付出现错误，请重试(1)!', mobileUrl('order'));
			}
			$alidata = base64_decode($_GET['alidata']);
			$alidata = json_decode($alidata, true);
			$alisign = m('finance')->RSAVerify($alidata, $public_key, false);
			$tid = $this->str($alidata['out_trade_no']);
			if ($alisign == 0) 
			{
				$this->message('支付出现错误，请重试(2)!', mobileUrl('order'));
			}
		}
		else 
		{
			if (empty($set['pay']['alipay'])) 
			{
				$this->message('未开启支付宝支付!', mobileUrl('order'));
			}
			if (!(m("finance")->isAlipayNotify($_GET))) 
			{
				$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . "\n" . '                    where dispatchno=:dispatchno  and uniacid=:uniacid limit 1', array(':dispatchno' => $tid, ':uniacid' => $_W['uniacid']));
				if (0 < $lastlog['dispatchstatus']) 
				{
					if ($fromwechat) 
					{
						$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
					}
					else 
					{
						$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('order'), 'success');
					}
				}
				$this->message(array('message' => '支付出现错误，请重试(支付验证失败)!', 'buttondisplay' => ($fromwechat ? false : true)), ($fromwechat ? NULL : mobileUrl('order')));
			}
		}
		$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . "\n" . '                    where dispatchno=:dispatchno and uniacid=:uniacid limit 1', array(':dispatchno' => $tid, ':uniacid' => $_W['uniacid']));
		if (empty($lastlog)) 
		{
			$this->message(array('message' => '支付出现错误，请重试(支付验证失败2)!', 'buttondisplay' => ($fromwechat ? false : true)), ($fromwechat ? NULL : mobileUrl('order')));
		}
		if (is_h5app()) 
		{
			$alidatafee = $this->str($alidata['total_fee']);
			$alidatastatus = $this->str($alidata['success']);
			if (($lastlog['fee'] != $alidatafee) || !($alidatastatus)) 
			{
				$this->message('支付出现错误，请重试(4)!', mobileUrl('order'));
			}
		}
		if ($lastlog['dispatchstatus'] < 1) 
		{
			$record = array();
			$record['dispatchstatus'] = '1';
			pdo_update("ewei_shop_creditshop_log", $record, array('dispatchno' => $tid));
			$creditlog = pdo_fetch('select id from ' . tablename('ewei_shop_creditshop_log') . "\n" . '                    where dispatchno=:dispatchno and openid=:openid and dispatchstatus=1 and uniacid=:uniacid limit 1', array(':dispatchno' => $tid, ':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
			if (is_h5app()) 
			{
				pdo_update("ewei_shop_creditshop_log", array("apppay" => 1), array("logno" => $tid));
			}
		}
		if (is_h5app()) 
		{
			$url = mobileUrl('creditshop/log/detail', array('id' => $creditlog['id']), true);
			exit('<script>top.window.location.href=\'' . $url . '\'</script>');
			return;
		}
		if ($fromwechat) 
		{
			$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
			return;
		}
		$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('creditshop/log/detail', array('id' => $creditlog['id'])), 'success');
	}
	public function payresult($a = array()) 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));
		if (empty($log)) 
		{
			show_json(0, '兑换记录不存在!');
		}
		if ($log['dispatchstatus'] < 1) 
		{
			show_json(0, '支付未成功!');
		}
		$goods = $this->model->getGoods($log['goodsid'], $member);
		if (empty($goods['id'])) 
		{
			show_json(0, '商品记录不存在!');
		}
		$this->model->sendMessage($id);
		show_json(1);
	}
	public function setstore() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$storeid = intval($_GPC['storeid']);
		if (empty($storeid)) 
		{
			show_json(0, '请选择兑换门店!');
		}
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));
		if (empty($log)) 
		{
			show_json(0, '兑换记录不存在!');
		}
		$goods = $this->model->getGoods($log['goodsid'], $member);
		if (empty($goods['id'])) 
		{
			show_json(0, '商品记录不存在!');
		}
		$upgrade = array();
		$upgradem = array();
		if (empty($log['storeid'])) 
		{
			$upgrade['storeid'] = $storeid;
		}
		if (empty($log['realname'])) 
		{
			$upgrade['realname'] = $upgrade1['realname'] = trim($_GPC['realname']);
		}
		if (empty($log['mobile'])) 
		{
			$upgrade['mobile'] = $upgrade1['mobile'] = trim($_GPC['mobile']);
		}
		if (!(empty($upgrade))) 
		{
			pdo_update('ewei_shop_creditshop_log', $upgrade, array('id' => $log['id']));
		}
		if (!(empty($upgrade1))) 
		{
			pdo_update('ewei_shop_member', $upgrade1, array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
			if (!(empty($member['uid']))) 
			{
				m('member')->mc_update($member['uid'], $upgrade1);
			}
		}
		show_json(1);
	}
}
?>