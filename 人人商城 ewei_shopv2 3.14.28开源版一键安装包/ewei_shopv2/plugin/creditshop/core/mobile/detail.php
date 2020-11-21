<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'creditshop/core/page_mobile.php';
class Detail_EweiShopV2Page extends CreditshopMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$merchid = intval($_GPC['merchid']);
		$_W['merchid'] = $merchid;

		if (!$id) {
			$this->message('该商品不存在或已删除!', mobileUrl('creditshop'), 'error');
		}

		$shop = m('common')->getSysset('shop');
		$member = m('member')->getMember($openid);
		$goods = $this->model->getGoods($id, $member);

		if (empty($goods)) {
			$this->message('该商品不存在或已删除!', mobileUrl('creditshop'), 'error');
		}

		$showgoods = m('goods')->visit($goods, $member);

		if (empty($showgoods)) {
			$this->message('您没有权限浏览此商品!', mobileUrl('creditshop'), 'error');
		}

		$pay = m('common')->getSysset('pay');
		$set = m('common')->getPluginset('creditshop');
		$goods['subdetail'] = m('ui')->lazy($goods['subdetail']);
		$goods['noticedetail'] = m('ui')->lazy($goods['noticedetail']);
		$goods['usedetail'] = m('ui')->lazy($goods['usedetail']);
		$goods['goodsdetail'] = m('ui')->lazy($goods['goodsdetail']);
		$credit = $member['credit1'];
		$money = $member['credit2'];

		if (!empty($goods)) {
			pdo_update('ewei_shop_creditshop_goods', array('views' => $goods['views'] + 1), array('id' => $id));
			$goods['followed'] = m('user')->followed($openid);
		}
		else {
			$this->message('商品已下架或被删除!', mobileUrl('creditshop'), 'error');
		}

		$log = array();
		$log = pdo_fetchall('select openid,createtime from ' . tablename('ewei_shop_creditshop_log') . '
                where uniacid = ' . $uniacid . ' and goodsid = ' . $id . ' and status > 0 order by createtime desc limit 2 ');

		foreach ($log as $key => $value) {
			$mem = m('member')->getMember($value['openid']);
			$log[$key]['avatar'] = $mem['avatar'];
			$log[$key]['nickname'] = $mem['nickname'];
			$log[$key]['createtime_str'] = date('Y/m/d H:i', $value['createtime']);
			unset($mem);
		}

		$logtotal = 0;
		$logtotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_creditshop_log') . ' where uniacid = ' . $uniacid . ' and goodsid = ' . $id . ' and status > 0 ');
		$replys = array();
		$replys = pdo_fetchall('select * from ' . tablename('ewei_shop_creditshop_comment') . '
                where uniacid = ' . $uniacid . ' and goodsid = ' . $id . ' and checked = 1 and deleted = 0 order by `time` desc limit 2 ');
		$replykeywords = explode(',', $set['desckeyword']);
		$replykeystr = trim($set['replykeyword']);

		if (empty($replykeystr)) {
			$replykeystr = '**';
		}

		foreach ($replys as $key => $value) {
			foreach ($replykeywords as $k => $val) {
				if (!empty($value['content'])) {
					if (!strstr($val, $value['content'])) {
						$value['content'] = str_replace($val, $replykeystr, $value['content']);
					}
				}

				if (!empty($value['reply_content'])) {
					if (!strstr($val, $value['reply_content'])) {
						$value['reply_content'] = str_replace($val, $replykeystr, $value['reply_content']);
					}
				}

				if (!empty($value['append_content'])) {
					if (!strstr($val, $value['append_content'])) {
						$value['append_content'] = str_replace($val, $replykeystr, $value['append_content']);
					}
				}

				if (!empty($value['append_reply_content'])) {
					if (!strstr($val, $value['append_reply_content'])) {
						$value['append_reply_content'] = str_replace($val, $replykeystr, $value['append_reply_content']);
					}
				}
			}

			$replys[$key]['content'] = $value['content'];
			$replys[$key]['reply_content'] = $value['reply_content'];
			$replys[$key]['append_content'] = $value['append_content'];
			$replys[$key]['append_reply_content'] = $value['append_reply_content'];
			$replys[$key]['time_str'] = date('Y/m/d', $value['time']);
			$replys[$key]['images'] = set_medias(iunserializer($value['images']));
			$replys[$key]['reply_images'] = set_medias(iunserializer($value['reply_images']));
			$replys[$key]['append_images'] = set_medias(iunserializer($value['append_images']));
			$replys[$key]['append_reply_images'] = set_medias(iunserializer($value['append_reply_images']));
			$replys[$key]['nickname'] = cut_str($value['nickname'], 1, 0) . '**' . cut_str($value['nickname'], 1, -1);
			$replys[$key]['content'] = str_replace('=', '**', $value['content']);
		}

		$replytotal = 0;
		$replytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_creditshop_comment') . '
                where uniacid = ' . $uniacid . ' and goodsid = ' . $id . ' and checked = 1 and deleted = 0 order by `time` desc ');

		if ($goods['goodstype'] == 0) {
			$stores = array();

			if (!empty($goods['isverify'])) {
				$storeids = array();

				if (!empty($goods['storeids'])) {
					$storeids = array_merge(explode(',', $goods['storeids']), $storeids);
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
			}
		}

		$goodsrec = pdo_fetchall('select id,thumb,title,credit,money,mincredit,minmoney from ' . tablename('ewei_shop_creditshop_goods') . '
                    where uniacid = ' . $uniacid . ' and goodstype = ' . $goods['goodstype'] . ' and `type` = ' . $goods['type'] . ' and status = 1 and deleted = 0 ORDER BY rand() limit 3 ');

		foreach ($goodsrec as $key => $value) {
			$goodsrec[$key]['credit'] = intval($value['credit']);

			if (intval($value['money']) - $value['money'] == 0) {
				$goodsrec[$key]['money'] = intval($value['money']);
			}

			$goodsrec[$key]['mincredit'] = intval($value['mincredit']);

			if (intval($value['minmoney']) - $value['minmoney'] == 0) {
				$goodsrec[$key]['minmoney'] = intval($value['minmoney']);
			}
		}

		$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'link' => mobileUrl('creditshop/detail', array('id' => $id), true), 'desc' => !empty($goods['share_desc']) ? $goods['share_desc'] : $goods['title']);
		$com = p('commission');

		if ($com) {
			$cset = $com->getSet();

			if (!empty($cset)) {
				if ($member['isagent'] == 1 && $member['status'] == 1) {
					$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('id' => $id, 'mid' => $member['id']), true);
					if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
						$trigger = true;
					}
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('id' => $id, 'mid' => $_GPC['mid']), true);
					}
				}
			}
		}

		include $this->template();
	}

	public function getlistlog()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$goodsid = intval($_GPC['goodsid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 5;
		$log = array();
		$log = pdo_fetchall('select openid,createtime from ' . tablename('ewei_shop_creditshop_log') . '
                where uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' order by createtime desc LIMIT ' . (($pindex - 1) * $psize + 2) . ' , ' . $psize);

		foreach ($log as $key => $value) {
			$mem = m('member')->getMember($value['openid']);
			$log[$key]['avatar'] = $mem['avatar'];
			$log[$key]['nickname'] = $mem['nickname'];
			$log[$key]['createtime_str'] = date('Y/m/d H:i', $value['createtime']);
			unset($mem);
		}

		$logtotal = 0;
		$logtotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_creditshop_log') . ' where uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and status > 0 ');
		show_json(1, array('list' => $log, 'pagesize' => $psize, 'total' => $logtotal));
	}

	public function getlistreply()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$goodsid = intval($_GPC['goodsid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 5;
		$replys = array();
		$replys = pdo_fetchall('select * from ' . tablename('ewei_shop_creditshop_comment') . '
                where uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and checked = 1 and deleted = 0 order by `time` desc LIMIT ' . (($pindex - 1) * $psize + 2) . ' , ' . $psize);

		foreach ($replys as $key => $value) {
			$replys[$key]['time_str'] = date('Y/m/d', $value['time']);
			$replys[$key]['images'] = set_medias(iunserializer($value['images']));
			$replys[$key]['reply_images'] = set_medias(iunserializer($value['reply_images']));
			$replys[$key]['append_images'] = set_medias(iunserializer($value['append_images']));
			$replys[$key]['append_reply_images'] = set_medias(iunserializer($value['append_reply_images']));
			$replys[$key]['nickname'] = cut_str($value['nickname'], 1, 0) . '**' . cut_str($value['nickname'], 1, -1);
		}

		$replytotal = 0;
		$replytotal = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_creditshop_comment') . '
                where uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and checked = 1 and deleted = 0 ');
		show_json(1, array('list' => $replys, 'pagesize' => $psize, 'total' => $replytotal));
	}

	public function option()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['goodsid']);
		$uniacid = intval($_W['uniacid']);
		$goods = pdo_fetch('select id,thumb,credit,money,total,title from ' . tablename('ewei_shop_creditshop_goods') . ' where id= ' . $id . ' and uniacid = ' . $uniacid . ' ');
		$goods = set_medias($goods, 'thumb');
		$specs = false;
		$options = false;
		$specs = pdo_fetchall('select * from ' . tablename('ewei_shop_creditshop_spec') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));

		foreach ($specs as &$spec) {
			$spec['items'] = pdo_fetchall('select * from ' . tablename('ewei_shop_creditshop_spec_item') . ' where specid=:specid and `show`=1 order by displayorder asc', array(':specid' => $spec['id']));
		}

		unset($spec);
		$options = pdo_fetchall('select * from ' . tablename('ewei_shop_creditshop_option') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($specs)) {
			foreach ($specs as $key => $value) {
				foreach ($specs[$key]['items'] as $k => &$v) {
					$v['thumb'] = tomedia($v['thumb']);
				}
			}
		}

		if (!$options) {
			show_json(0, '商品规格不存在！');
		}

		show_json(1, array('specs' => $specs, 'options' => $options, 'goods' => $goods));
	}

	public function pay($a = array(), $b = array())
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$num = max(1, $_GPC['num']);
		$id = intval($_GPC['id']);
		$shop = m('common')->getSysset('shop');
		$member = m('member')->getMember($openid);
		$optionid = intval($_GPC['optionid']);
		$goods = $this->model->getGoods($id, $member, $optionid, $num);
		$credit = $member['credit1'];
		$money = $member['credit2'];
		$paytype = $_GPC['paytype'];
		$addressid = intval($_GPC['addressid']);
		$storeid = intval($_GPC['storeid']);
		$paystatus = 0;
		$dispatch = 0;
		if ($goods['hasoption'] && $optionid) {
			$option = pdo_fetch('select total from ' . tablename('ewei_shop_creditshop_option') . ' where uniacid = ' . $uniacid . ' and id = ' . $optionid . ' and goodsid = ' . $id . ' ');

			if ($option['total'] <= 0) {
				show_json(0, $goods['buymsg']);
			}
		}

		if ($addressid) {
			$dispatch = $this->model->dispatchPrice($id, $addressid, $optionid, $num);
		}

		$goods['dispatch'] = $dispatch;

		if (empty($goods['canbuy'])) {
			show_json(0, $goods['buymsg']);
		}

		$needpay = false;
		if (0 < $goods['money'] || $goods['dispatch']) {
			$needpay = true;
			$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where goodsid=:goodsid and openid=:openid  and status=0 and paystatus=1 and uniacid=:uniacid limit 1', array(':goodsid' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

			if (!empty($lastlog)) {
				show_json(1, array('logid' => $lastlog['id']));
			}
		}

		$dispatchstatus = 0;
		if ($goods['isverify'] == 1 || 0 < $goods['goodstype'] || $goods['dispatch'] == 0 || $goods['type'] == 1) {
			$dispatchstatus = -1;
		}

		$address = false;

		if (!empty($addressid)) {
			$address = pdo_fetch('select id,realname,mobile,address,province,city,area,street from ' . tablename('ewei_shop_member_address') . '
            where id=:id and uniacid=:uniacid limit 1', array(':id' => $addressid, ':uniacid' => $_W['uniacid']));

			if (empty($address)) {
				show_json(0, '未找到地址');
			}
		}

		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['uniacid'] . '_credit_log__add_' . $_W['openid'];
			$redis = redis();

			if (!is_error($redis)) {
				if ($redis->get($redis_key)) {
					show_json(0, '请勿重复点击');
				}

				$redis->setex($redis_key, 1, time());
			}
		}

		$log = array('uniacid' => $uniacid, 'merchid' => intval($goods['merchid']), 'openid' => $openid, 'logno' => m('common')->createNO('creditshop_log', 'logno', $goods['type'] == 0 ? 'EE' : 'EL'), 'goodsid' => $id, 'storeid' => $storeid, 'optionid' => $optionid, 'addressid' => $addressid, 'address' => iserializer($address), 'status' => 0, 'paystatus' => 0 <= $goods['money'] ? 0 : -1, 'dispatchstatus' => $dispatchstatus, 'createtime' => time(), 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']), 'goods_num' => $num);
		pdo_insert('ewei_shop_creditshop_log', $log);
		$logid = pdo_insertid();
		if (!empty($log['realname']) && !empty($log['mobile'])) {
			$up = array('realname' => $log['realname'], 'carrier_mobile' => $log['mobile']);
			pdo_update('ewei_shop_member', $up, array('id' => $member['id'], 'uniacid' => $_W['uniacid']));

			if (!empty($member['uid'])) {
				mc_update($member['uid'], array('realname' => $log['realname']));
			}
		}

		if ($needpay) {
			$set = m('common')->getSysset();

			if ($paytype == 'balance') {
				if ($goods['money'] + $goods['dispatch'] <= $money) {
					$paytype = 0;
				}
				else {
					show_json(0, '余额不足!');
				}

				pdo_update('ewei_shop_creditshop_log', array('paytype' => $paytype), array('id' => $logid));
			}
			else if ($paytype == 'wechat') {
				$paytype = 1;
				pdo_update('ewei_shop_creditshop_log', array('paytype' => $paytype), array('id' => $logid));
				$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
				$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];
				$wechat = array('success' => false);
				$jie = intval($_GPC['jie']);
				if (empty($set['pay']['weixin']) && empty($set['pay']['weixin_jie']) && is_weixin() || empty($set['pay']['app_wechat']) && is_h5app()) {
					show_json(0, '未开启微信支付!');
				}

				if (is_weixin()) {
					$params = array();
					$params['tid'] = $log['logno'];
					$params['user'] = $openid;
					$params['fee'] = $goods['money'] * $num + $goods['dispatch'];
					$params['title'] = $set['shop']['name'] . (empty($goods['type']) ? '积分兑换' : '积分抽奖') . ' 单号:' . $log['logno'];
					if (isset($set['pay']) && $set['pay']['weixin'] == 1 && $jie !== 1) {
						load()->model('payment');
						$setting = uni_setting($_W['uniacid'], array('payment'));
						$options = array();

						if (is_array($setting['payment'])) {
							$options = $setting['payment']['wechat'];
							$options['appid'] = $_W['account']['key'];
							$options['secret'] = $_W['account']['secret'];
						}

						$wechat = m('common')->wechat_build($params, $options, 2);
						$wechat['success'] = false;

						if (!is_error($wechat)) {
							$wechat['success'] = true;

							if (!empty($wechat['code_url'])) {
								$wechat['weixin_jie'] = true;
							}
							else {
								$wechat['weixin'] = true;
							}
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

						$wechat = m('common')->wechat_native_build($params, $options, 2);

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

					$wechat['jie'] = $jie;

					if (!$wechat['success']) {
						show_json(0, $wechat);
					}

					show_json(1, array('logid' => $logid, 'wechat' => $wechat));
				}

				if (is_h5app()) {
					$payinfo = array('ordersn' => $log['logno'], 'money' => $goods['money'] * $num + $goods['dispatch']);
					show_json(1, array('logid' => $logid, 'wechat' => true, 'payinfo' => $payinfo));
				}
			}
			else {
				if ($paytype == 'alipay') {
					$paytype = 2;
					pdo_update('ewei_shop_creditshop_log', array('paytype' => $paytype), array('id' => $logid));
					$lognoother = str_replace('EE', 'EP', $log['logno']);
					$params = array();
					$params['tid'] = $log['logno'];
					$params['user'] = $openid;
					$params['fee'] = $goods['money'] * $num + $goods['dispatch'];
					$params['title'] = $set['shop']['name'] . (empty($goods['type']) ? '积分兑换' : '积分抽奖') . ' 单号:' . $log['logno'];
					if (isset($set['pay']) && $set['pay']['alipay'] == 1) {
						load()->func('communication');
						load()->model('payment');
						$setting = uni_setting($_W['uniacid'], array('payment'));

						if (is_array($setting['payment'])) {
							$options = $setting['payment']['alipay'];
							$alipay = m('common')->alipay_build($params, $options, 20, $_W['openid']);

							if (!empty($alipay['url'])) {
								$alipay['url'] = urlencode($alipay['url']);
								$alipay['success'] = true;
							}
						}
					}

					if (!$alipay['success']) {
						show_json(0, '支付宝支付参数错误!');
					}

					show_json(1, array('logid' => $logid, 'alipay' => $alipay));
				}
			}
		}

		show_json(1, array('logid' => $logid));
	}

	public function wechat_complete()
	{
		global $_W;
		global $_GPC;
		$openid = $_GPC['openid'];
		$logid = intval($_GPC['logid']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $_W['uniacid']));

		if (empty($log)) {
			$logno = intval($_GPC['logno']);
			$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where logno=:logno and uniacid=:uniacid limit 1', array(':logno' => $logno, ':uniacid' => $_W['uniacid']));
		}

		$member = m('member')->getMember($openid);
		$goods = $this->model->getGoods($log['goodsid'], $member, $log['optionid']);
		$goods['dispatch'] = $this->model->dispatchPrice($log['goodsid'], $log['addressid'], $log['optionid']);

		if (!empty($log)) {
			$payquery = m('finance')->isWeixinPay($log['logno'], $goods['money'] + $goods['dispatch'], is_h5app() ? true : false);
			$payqueryborrow = m('finance')->isWeixinPayBorrow($log['logno'], $goods['money'] + $goods['dispatch']);
			if (!is_error($payquery) || !is_error($payqueryborrow)) {
				if ($log['status'] < 1) {
					$record = array();
					$record['paystatus'] = 1;
					$record['paytype'] = 1;
					pdo_update('ewei_shop_creditshop_log', $record, array('logno' => $log['logno']));
					$creditlog = pdo_fetch('select id from ' . tablename('ewei_shop_creditshop_log') . '
                    where logno=:logno and openid=:openid  and status=0 and paystatus=1 and uniacid=:uniacid limit 1', array(':logno' => $log['logno'], ':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));

					if (is_h5app()) {
						pdo_update('ewei_shop_creditshop_log', array('apppay' => 1), array('logno' => $log['logno']));
					}
				}

				if (is_h5app()) {
					$url = mobileUrl('creditshop/log/detail', array('id' => $log['id']), true);
					exit('<script>top.window.location.href=\'' . $url . '\'</script>');
				}
			}
		}

		if ($_W['ispost']) {
			show_json(0);
		}
		else if (is_h5app()) {
			header('location: ' . mobileUrl('creditshop/log', array(), true));
		}
		else {
			header('location: ' . mobileUrl('member'));
		}
	}

	public function creditshop_complete()
	{
		global $_GPC;
		global $_W;
		$set = m('common')->getSysset(array('shop', 'pay'));
		$fromwechat = intval($_GPC['fromwechat']);
		$tid = $_GPC['out_trade_no'];

		if (is_h5app()) {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$public_key = $sec['app_alipay']['public_key'];
			if (empty($set['pay']['app_alipay']) || empty($public_key)) {
				$this->message('支付出现错误，请重试(1)!', mobileUrl('order'));
			}

			$alidata = base64_decode($_GET['alidata']);
			$alidata = json_decode($alidata, true);
			$alisign = m('finance')->RSAVerify($alidata, $public_key, false);
			$tid = $this->str($alidata['out_trade_no']);

			if ($alisign == 0) {
				$this->message('支付出现错误，请重试(2)!', mobileUrl('order'));
			}
		}
		else {
			if (empty($set['pay']['alipay'])) {
				$this->message('未开启支付宝支付!', mobileUrl('order'));
			}

			if (!m('finance')->isAlipayNotify($_GET)) {
				$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . '
                    where logno=:logno  and uniacid=:uniacid limit 1', array(':logno' => $tid, ':uniacid' => $_W['uniacid']));
				if ($lastlog['status'] == 1 && 0 < $lastlog['paystatus']) {
					if ($fromwechat) {
						$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
					}
					else {
						$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('creditshop/log'), 'success');
					}
				}

				$this->message(array('message' => '支付出现错误，请重试(支付验证失败)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('order'));
			}
		}

		$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . '
                    where logno=:logno and uniacid=:uniacid limit 1', array(':logno' => $tid, ':uniacid' => $_W['uniacid']));

		if (empty($lastlog)) {
			$this->message(array('message' => '支付出现错误，请重试(支付验证失败2)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('order'));
		}

		if (is_h5app()) {
			$alidatafee = $this->str($alidata['total_fee']);
			$alidatastatus = $this->str($alidata['success']);
			if ($lastlog['fee'] != $alidatafee || !$alidatastatus) {
				$this->message('支付出现错误，请重试(4)!', mobileUrl('creditshop/log'));
			}
		}

		if ($lastlog['status'] < 1) {
			$record = array();
			$record['paystatus'] = 1;
			pdo_update('ewei_shop_creditshop_log', $record, array('logno' => $tid));
			$creditlog = pdo_fetch('select id from ' . tablename('ewei_shop_creditshop_log') . '
                    where logno=:logno and openid=:openid  and status=0 and paystatus=1 and uniacid=:uniacid limit 1', array(':logno' => $tid, ':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));

			if (is_h5app()) {
				pdo_update('ewei_shop_creditshop_log', array('apppay' => 1), array('logno' => $tid));
			}
		}

		if (is_h5app()) {
			$url = mobileUrl('creditshop/log', array(), true);
			exit('<script>top.window.location.href=\'' . $url . '\'</script>');
		}
		else if ($fromwechat) {
			$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
		}
		else {
			$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('creditshop/log'), 'success');
		}
	}

	public function lottery()
	{
		global $_W;
		global $_GPC;
		$number = max(1, $_GPC['num']);
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['setting']['site']['key'] . '_' . $_W['account']['key'] . '_' . $uniacid . '_creditshop_lottery_' . $openid;
			$redis = redis();

			if (!is_error($redis)) {
				if ($redis->setnx($redis_key, time())) {
					$redis->expireAt($redis_key, time() + 2);
				}
				else {
					show_json(0, array('status' => '-1', 'message' => '操作频繁，请稍后再试!'));
				}
			}
		}

		$id = intval($_GPC['id']);
		$logid = intval($_GPC['logid']);

		if (!$logid) {
			$logid = $id;
		}

		$shop = m('common')->getSysset('shop');
		$member = m('member')->getMember($openid);
		$goodsid = intval($_GPC['goodsid']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $uniacid));

		if (empty($log)) {
			$logno = $_GPC['logno'];
			$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where logno=:logno and uniacid=:uniacid limit 1', array(':logno' => $logno, ':uniacid' => $uniacid));
		}

		$optionid = $log['optionid'];
		$goods = $this->model->getGoods($log['goodsid'], $member, $log['optionid'], $number);
		$goods['money'] *= $number;
		$goods['credit'] *= $number;
		$goods['dispatch'] = $this->model->dispatchPrice($log['goodsid'], $log['addressid'], $log['optionid'], $number);
		$credit = $member['credit1'];
		$money = $member['credit2'];

		if (empty($log)) {
			show_json(0, array('status' => '-1', 'message' => '服务器错误!'));
		}

		if (empty($goods['canbuy'])) {
			show_json(0, array('status' => '-1', 'message' => $goods['buymsg']));
		}

		$update = array('couponid' => $goods['couponid']);

		if (empty($log['paystatus'])) {
			if (0 < $goods['credit'] && $credit < $goods['credit']) {
				show_json(0, array('status' => '-1', 'message' => '积分不足!'));
			}

			if (0 < $goods['money'] && $money < $goods['money'] && $log['paytype'] == 0) {
				show_json(0, array('status' => '-1', 'message' => '余额不足!'));
			}
		}

		$update['money'] = $goods['money'];
		if (0 < $goods['money'] + $goods['dispatch'] && $log['paystatus'] < 1) {
			if ($log['paytype'] == 0) {
				m('member')->setCredit($openid, 'credit2', 0 - ($goods['money'] + $goods['dispatch']), '积分商城扣除余额度 ' . $goods['money'] . ',编号:' . $log['logno']);
				$update['paystatus'] = 1;
			}

			if ($log['paytype'] == 1) {
				$payquery = m('finance')->isWeixinPay($log['logno'], $goods['money'] + $goods['dispatch'], is_h5app() ? true : false);
				$payqueryBorrow = m('finance')->isWeixinPayBorrow($log['logno'], $goods['money'] + $goods['dispatch']);
				if (!is_error($payquery) || !is_error($payqueryBorrow)) {
					$this->model->payResult($log['logno'], 'wechat', $goods['money'] + $goods['dispatch'], is_h5app() ? true : false);
				}
				else {
					show_json(0, array('status' => '-1', 'message' => '支付出错,请重试(1)!'));
				}
			}

			if ($log['paytype'] == 2) {
				if ($log['paystatus'] < 1) {
					show_json(0, array('status' => '-1', 'message' => '未支付成功!'));
				}
			}
		}

		if (0 < $goods['credit'] && empty($log['creditpay'])) {
			$update['credit'] = $goods['credit'];
			m('member')->setCredit($openid, 'credit1', 0 - $goods['credit'], '积分商城扣除积分 ' . $goods['credit'] . ',编号:' . $log['logno']);
			$update['creditpay'] = 1;
			pdo_query('update ' . tablename('ewei_shop_creditshop_goods') . ' set joins=joins+1 where id=' . $log['goodsid']);
		}

		$status = 1;

		if ($goods['type'] == 1) {
			if (0 < $goods['rate1'] && 0 < $goods['rate2']) {
				if ($goods['rate1'] == $goods['rate2']) {
					$status = 2;
				}
				else {
					$rand = rand(0, intval($goods['rate2']));

					if ($rand <= intval($goods['rate1'])) {
						$status = 2;
					}
				}
			}
		}
		else {
			$status = 2;
		}

		if ($status == 2 && $goods['isverify'] == 1) {
			$update['eno'] = $this->model->createENO();
		}

		if ($goods['isverify'] == 1) {
			$update['verifynum'] = 0 < $goods['verifynum'] ? $goods['verifynum'] : 1;

			if ($goods['isendtime'] == 0) {
				if (0 < $goods['usetime']) {
					$update['verifytime'] = time() + 3600 * 24 * intval($goods['usetime']);
				}
				else {
					$update['verifytime'] = 0;
				}
			}
			else {
				$update['verifytime'] = intval($goods['endtime']);
			}
		}

		$update['status'] = $status;
		if (0 < $goods['dispatch'] && $goods['goodstype'] == 0 && $goods['type'] == 0) {
			$update['dispatchstatus'] = '1';
			$update['dispatch'] = $goods['dispatch'];
		}

		pdo_update('ewei_shop_creditshop_log', $update, array('id' => $log['id']));
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $uniacid));
		if ($status == 2 && $update['creditpay'] == 1) {
			if ($goods['goodstype'] == 1) {
				if (com('coupon')) {
					$i = 0;

					while ($i < $number) {
						com('coupon')->creditshop($logid);
						++$i;
					}

					$status = 3;
				}

				$update['time_finish'] = time();
			}
			else if ($goods['goodstype'] == 2) {
				$credittype = 'credit2';
				$creditstr = '积分商城兑换余额,编号:' . $log['logno'];
				$num = abs($goods['grant1']) * intval($log['goods_num']);
				$member = m('member')->getMember($openid);
				$credit2 = floatval($member['credit2']) + $num;
				m('member')->setCredit($openid, $credittype, $num, array($_W['uid'], $creditstr));
				$set = m('common')->getSysset('shop');
				$logno = m('common')->createNO('member_log', 'logno', 'RC');
				$data = array('openid' => $openid, 'logno' => $logno, 'uniacid' => $_W['uniacid'], 'type' => '0', 'createtime' => TIMESTAMP, 'status' => '1', 'title' => $set['name'] . '积分商城兑换余额', 'money' => $num, 'remark' => $creditstr, 'rechargetype' => 'creditshop');
				pdo_insert('ewei_shop_member_log', $data);
				$mlogid = pdo_insertid();
				m('notice')->sendMemberLogMessage($mlogid);
				plog('finance.recharge.' . $credittype, '充值' . $creditstr . ': ' . $num . ' <br/>会员信息: ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
				$status = 3;
				$update['time_finish'] = time();
			}
			else {
				if ($goods['goodstype'] == 3) {
				}
			}

			$update['status'] = $status;
			pdo_update('ewei_shop_creditshop_log', $update, array('id' => $logid));
			$this->model->sendMessage($logid);

			if ($status == 3) {
				pdo_query('update ' . tablename('ewei_shop_creditshop_goods') . ' set total=total-' . $number . ' where id=' . $log['goodsid']);
			}

			if ($goods['goodstype'] == 0 && $status == 2) {
				pdo_query('update ' . tablename('ewei_shop_creditshop_goods') . ' set total=total-' . $number . ' where id=' . $log['goodsid']);
			}

			if ($goods['goodstype'] == 3 && $status == 2) {
				pdo_query('update ' . tablename('ewei_shop_creditshop_goods') . ' set packetsurplus=packetsurplus-' . $number . ' where id=' . $log['goodsid']);
			}

			if ($goods['hasoption'] && $log['optionid']) {
				pdo_query('update ' . tablename('ewei_shop_creditshop_option') . ' set total=total-' . $number . ' where id=' . $log['optionid']);
			}
		}

		show_json(1, array('status' => $status, 'goodstype' => $goods['goodstype']));
	}

	protected function getGoodsDispatchPrice($goods)
	{
		if ($goods['type'] == 2 || $goods['type'] == 3 || $goods['type'] == 20) {
			return 0;
		}

		if ($goods['dispatchtype'] == 1) {
			return $goods['dispatch'];
		}

		if (empty($goods['dispatchid'])) {
			$dispatch = m('dispatch')->getDefaultDispatch($goods['merchid']);
		}
		else {
			$dispatch = m('dispatch')->getOneDispatch($goods['dispatchid']);
		}

		if (empty($dispatch)) {
			$dispatch = m('dispatch')->getNewDispatch($goods['merchid']);
		}

		$areas = iunserializer($dispatch['areas']);
		if (!empty($areas) && is_array($areas)) {
			$firstprice = array();

			foreach ($areas as $val) {
				if (empty($dispatch['calculatetype'])) {
					$firstprice[] = $val['firstprice'];
				}
				else {
					$firstprice[] = $val['firstnumprice'];
				}
			}

			array_push($firstprice, m('dispatch')->getDispatchPrice(1, $dispatch));
			$ret = array('min' => round(min($firstprice), 2), 'max' => round(max($firstprice), 2));
		}
		else {
			$ret = m('dispatch')->getDispatchPrice(1, $dispatch);
		}

		return $ret;
	}
}

?>
