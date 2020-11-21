<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Log_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$_W['shopshare'] = array('title' => $this->set['share_title'], 'imgUrl' => tomedia($this->set['share_icon']), 'link' => mobileUrl('creditshop', array(), true), 'desc' => $this->set['share_desc']);
		$com = p('commission');

		if ($com) {
			$cset = $com->getSet();

			if (!empty($cset)) {
				if ($member['isagent'] == 1 && $member['status'] == 1) {
					$_W['shopshare']['link'] = mobileUrl('creditshop', array('mid' => $member['id']), true);
					if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
						$trigger = true;
					}
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('mid' => $_GPC['mid']), true);
					}
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
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and log.openid=:openid and log.status>0 and  log.uniacid = :uniacid';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_creditshop_log') . (' log where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT log.id,log.goodsid,log.status,log.eno,log.paystatus,g.title,g.type,g.thumb,g.credit,g.money,g.isverify,g.goodstype,log.addressid,log.storeid FROM ' . tablename('ewei_shop_creditshop_log') . ' log ' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on log.goodsid = g.id ' . ' where 1 ' . $condition . ' ORDER BY log.createtime DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb');

			foreach ($list as &$row) {
				if (0 < $row['credit'] & 0 < $row['money']) {
					$row['acttype'] = 0;
				}
				else if (0 < $row['credit']) {
					$row['acttype'] = 1;
				}
				else if (0 < $row['money']) {
					$row['acttype'] = 2;
				}
				else {
					$row['acttype'] = 3;
				}
			}

			unset($row);
		}

		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

		if (empty($log)) {
			show_json(-1, '兑换记录不存在!');
		}

		$goods = $this->model->getGoods($log['goodsid'], $member);

		if (empty($goods['id'])) {
			show_json(-1, '商品记录不存在!');
		}

		$address = false;

		if (!empty($log['addressid'])) {
			$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $log['addressid'], ':uniacid' => $uniacid, ':openid' => $openid));
		}

		$goods['currenttime'] = time();
		$stores = array();
		$store = false;

		if (empty($log['storeid'])) {
			if (!empty($goods['isverify'])) {
				$storeids = array();

				if (!empty($goods['storeids'])) {
					$storeids = array_merge(explode(',', $goods['storeids']), $storeids);
				}

				if (empty($storeids)) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid']));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid']));
				}
			}
		}
		else {
			$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log['storeid'], ':uniacid' => $_W['uniacid']));
		}

		$_W['shopshare'] = array('title' => $this->set['share_title'], 'imgUrl' => tomedia($this->set['share_icon']), 'link' => mobileUrl('creditshop', array(), true), 'desc' => $this->set['share_desc']);
		$com = p('commission');

		if ($com) {
			$cset = $com->getSet();

			if (!empty($cset)) {
				if ($member['isagent'] == 1 && $member['status'] == 1) {
					$_W['shopshare']['link'] = mobileUrl('creditshop', array('mid' => $member['id']), true);
					if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
						$trigger = true;
					}
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('mid' => $_GPC['mid']), true);
					}
				}
			}
		}

		include $this->template('creditshop/log_detail');
	}

	public function paydispatch()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$addressid = intval($_GPC['addressid']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

		if (empty($log)) {
			show_json(0, '兑换记录不存在!');
		}

		$goods = $this->model->getGoods($log['goodsid'], $member);

		if (empty($goods['id'])) {
			show_json(0, '商品记录不存在!');
		}

		if (!empty($goods['isendtime'])) {
			if ($goods['endtime'] < time()) {
				show_json(0, '商品已过期!');
			}
		}

		if ($goods['dispatch'] <= 0) {
			pdo_update('ewei_shop_creditshop_log', array('dispatchstatus' => 1, 'addressid' => $addressid), array('id' => $log['id']));
			show_json(1, array('logid' => $log['id']));
		}

		if (!empty($log['dispatchstatus'])) {
			show_json(0, '商品已支付运费!');
		}

		$set = m('common')->getSysset();
		$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
		$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];

		if (!is_weixin()) {
			show_json(0, '非微信环境!');
		}

		if (empty($set['pay']['weixin']) && empty($set['pay']['weixin_jie'])) {
			show_json(0, '未开启微信支付!');
		}

		$wechat = array('success' => false);
		$jie = intval($_GPC['jie']);
		$dispatchno = $log['dispatchno'];

		if (empty($dispatchno)) {
			if (empty($goods['type'])) {
				$dispatchno = str_replace('EE', 'EP', $log['logno']);
			}
			else {
				$dispatchno = str_replace('EL', 'EP', $log['logno']);
			}

			pdo_update('ewei_shop_creditshop_log', array('dispatchno' => $dispatchno, 'addressid' => $addressid), array('id' => $log['id']));
		}

		$params = array();
		$params['tid'] = $dispatchno;
		$params['user'] = $openid;
		$params['fee'] = $goods['dispatch'];
		$params['title'] = $set['shop']['name'] . (empty($goods['type']) ? '积分兑换' : '积分抽奖') . ' 支付运费单号:' . $dispatchno;
		if (isset($set['pay']) && $set['pay']['weixin'] == 1 && $jie !== 1) {
			load()->model('payment');
			$setting = uni_setting($_W['uniacid'], array('payment'));
			$options = array();

			if (is_array($setting['payment'])) {
				$options = $setting['payment']['wechat'];
				$options['appid'] = $_W['account']['key'];
				$options['secret'] = $_W['account']['secret'];
			}

			$wechat = m('common')->wechat_build($params, $options, 3);
			$wechat['success'] = false;

			if (!is_error($wechat)) {
				$wechat['weixin'] = true;
				$wechat['success'] = true;
			}
		}

		if (isset($set['pay']) && $set['pay']['weixin_jie'] == 1 && !$wechat['success'] || $jie === 1) {
			$params['tid'] = $params['tid'] . '_borrow';
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$options = array();
			$options['appid'] = $sec['appid'];
			$options['mchid'] = $sec['mchid'];
			$options['apikey'] = $sec['apikey'];
			if (!empty($set['pay']['weixin_jie_sub']) && !empty($sec['sub_secret_jie_sub'])) {
				$wxuser = m('member')->wxuser($sec['sub_appid_jie_sub'], $sec['sub_secret_jie_sub']);
				$params['openid'] = $wxuser['openid'];
			}
			else {
				if (!empty($sec['secret'])) {
					$wxuser = m('member')->wxuser($sec['appid'], $sec['secret']);
					$params['openid'] = $wxuser['openid'];
				}
			}

			$wechat = m('common')->wechat_native_build($params, $options, 3);

			if (!is_error($wechat)) {
				$wechat['success'] = true;

				if (!empty($params['openid'])) {
					$wechat['weixin'] = true;
				}
				else {
					$wechat['weixin_jie'] = true;
				}
			}
		}

		if (!$wechat['success']) {
			show_json(0, '微信支付参数错误!');
		}

		show_json(1, array('logid' => $log['id'], 'wechat' => $wechat, 'jssdkconfig' => json_encode($_W['account']['jssdkconfig'])));
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

		if (empty($log)) {
			show_json(0, '兑换记录不存在!');
		}

		if (empty($log['dispatchstatus'])) {
			show_json(0, '支付未成功!');
		}

		$goods = $this->model->getGoods($log['goodsid'], $member);

		if (empty($goods['id'])) {
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

		if (empty($storeid)) {
			show_json(0, '请选择兑换门店!');
		}

		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

		if (empty($log)) {
			show_json(0, '兑换记录不存在!');
		}

		$goods = $this->model->getGoods($log['goodsid'], $member);

		if (empty($goods['id'])) {
			show_json(0, '商品记录不存在!');
		}

		$upgrade = array();
		$upgradem = array();

		if (empty($log['storeid'])) {
			$upgrade['storeid'] = $storeid;
		}

		if (empty($log['realname'])) {
			$upgrade['realname'] = $upgrade1['realname'] = trim($_GPC['realname']);
		}

		if (empty($log['mobile'])) {
			$upgrade['mobile'] = $upgrade1['mobile'] = trim($_GPC['mobile']);
		}

		if (!empty($upgrade)) {
			pdo_update('ewei_shop_creditshop_log', $upgrade, array('id' => $log['id']));
		}

		if (!empty($upgrade1)) {
			pdo_update('ewei_shop_member', $upgrade1, array('id' => $member['id'], 'uniacid' => $_W['uniacid']));

			if (!empty($member['uid'])) {
				m('member')->mc_update($member['uid'], $upgrade1);
			}
		}

		show_json(1);
	}

	public function create()
	{
		include $this->template();
	}
}

?>
