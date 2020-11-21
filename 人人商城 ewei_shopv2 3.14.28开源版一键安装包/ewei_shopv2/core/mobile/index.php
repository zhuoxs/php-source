<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$_SESSION['newstoreid'] = 0;
		$this->diypage('home');
		$trade = m('common')->getSysset('trade');

		if (empty($trade['shop_strengthen'])) {
			$order = pdo_fetch('select id,price,`virtual`,createtime  from ' . tablename('ewei_shop_order') . ' where uniacid=:uniacid and status = 0 and paytype<>3 and openid=:openid order by createtime desc limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			if (!empty($order)) {
				$close_time = 0;
				$mintimes = 0;

				if (!empty($order['virtual'])) {
					if (isset($trade['closeorder_virtual']) && !empty($trade['closeorder_virtual'])) {
						$mintimes = 60 * intval($trade['closeorder_virtual']);
					}
					else {
						$mintimes = 60 * 15;
					}
				}
				else {
					$days = intval($trade['closeorder']);

					if (0 < $days) {
						$mintimes = 86400 * $days;
					}
				}

				if (!empty($mintimes)) {
					$close_time = intval($order['createtime']) + $mintimes;
				}

				$goods = pdo_fetchall('select g.*,og.total as totals  from ' . tablename('ewei_shop_order_goods') . ' og inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id   where og.uniacid=:uniacid    and og.orderid=:orderid  limit 3', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']));
				$goodstotal = pdo_fetchcolumn('select COUNT(*)  from ' . tablename('ewei_shop_order_goods') . ' og inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id   where og.uniacid=:uniacid    and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']));
			}
		}

		$mid = intval($_GPC['mid']);
		$index_cache = $this->getpage();

		if (!empty($mid)) {
			$index_cache = preg_replace_callback('/href=[\\\'"]?([^\\\'" ]+).*?[\\\'"]/', function($matches) use($mid) {
				$preg = $matches[1];

				if (strexists($preg, 'mid=')) {
					return 'href=\'' . $preg . '\'';
				}

				if (!strexists($preg, 'javascript')) {
					$preg = preg_replace('/(&|\\?)mid=[\\d+]/', '', $preg);

					if (strexists($preg, '?')) {
						$newpreg = $preg . ('&mid=' . $mid);
					}
					else {
						$newpreg = $preg . ('?mid=' . $mid);
					}

					return 'href=\'' . $newpreg . '\'';
				}
			}, $index_cache);
		}

		$shop_data = m('common')->getSysset('shop');
		$sale_sql = 'SELECT * FROM ' . tablename('ewei_shop_sendticket') . ' WHERE uniacid = ' . intval($_W['uniacid']);
		$sale_set = pdo_fetch($sale_sql);
		if (!empty($sale_set) && $sale_set['status'] == 1) {
			if (com('coupon')) {
				$cpinfos = com('coupon')->getInfo();
			}
		}

		include $this->template();
	}

	public function get_recommand()
	{
		global $_W;
		global $_GPC;
		$args = array('page' => $_GPC['page'], 'pagesize' => 6, 'isrecommand' => 1, 'order' => 'displayorder desc,createtime desc', 'by' => '');
		$recommand = m('goods')->getList($args);
		show_json(1, array('list' => $recommand['list'], 'pagesize' => $args['pagesize'], 'total' => $recommand['total'], 'page' => intval($_GPC['page'])));
	}

	private function getcache()
	{
		global $_W;
		global $_GPC;
		return m('common')->createStaticFile(mobileUrl('getpage', NULL, true));
	}

	public function getpage()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$defaults = array(
			'adv'    => array('text' => '幻灯片', 'visible' => 1),
			'search' => array('text' => '搜索栏', 'visible' => 1),
			'nav'    => array('text' => '导航栏', 'visible' => 1),
			'notice' => array('text' => '公告栏', 'visible' => 1),
			'cube'   => array('text' => '魔方栏', 'visible' => 1),
			'banner' => array('text' => '广告栏', 'visible' => 1),
			'goods'  => array('text' => '推荐栏', 'visible' => 1)
		);
		$sorts = isset($_W['shopset']['shop']['indexsort']) ? $_W['shopset']['shop']['indexsort'] : $defaults;
		$sorts['recommand'] = array('text' => '系统推荐', 'visible' => 1);
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_adv') . ' where uniacid=:uniacid and iswxapp=0 and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$navs = pdo_fetchall('select id,navname,url,icon from ' . tablename('ewei_shop_nav') . ' where uniacid=:uniacid and iswxapp=0 and status=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$cubes = is_array($_W['shopset']['shop']['cubes']) ? $_W['shopset']['shop']['cubes'] : array();
		$banners = pdo_fetchall('select id,bannername,link,thumb from ' . tablename('ewei_shop_banner') . ' where uniacid=:uniacid and iswxapp=0 and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$bannerswipe = $_W['shopset']['shop']['bannerswipe'];

		if (!empty($_W['shopset']['shop']['indexrecommands'])) {
			$goodids = implode(',', $_W['shopset']['shop']['indexrecommands']);

			if (!empty($goodids)) {
				$indexrecommands = pdo_fetchall('select * from ' . tablename('ewei_shop_goods') . (' where id in( ' . $goodids . ' ) and uniacid=:uniacid and deleted = 0 and status=1 order by instr(\'' . $goodids . '\',id),displayorder desc'), array(':uniacid' => $uniacid));
				$level = $this->getLevel($_W['openid']);
				$set = $this->getSet();

				foreach ($indexrecommands as $key => $value) {
					if (0 < $value['ispresell']) {
						$indexrecommands[$key]['minprice'] = $value['presellprice'];
					}

					$indexrecommands[$key]['seecommission'] = $this->getCommission($value, $level, $set);

					if (0 < $indexrecommands[$key]['seecommission']) {
						$indexrecommands[$key]['seecommission'] = round($indexrecommands[$key]['seecommission'], 2);
					}

					$indexrecommands[$key]['cansee'] = $set['cansee'];
					$indexrecommands[$key]['seetitle'] = $set['seetitle'];
				}
			}
		}

		$goodsstyle = $_W['shopset']['shop']['goodsstyle'];
		$notices = pdo_fetchall('select id, title, link, thumb from ' . tablename('ewei_shop_notice') . ' where uniacid=:uniacid and iswxapp=0 and status=1 order by displayorder desc limit 5', array(':uniacid' => $uniacid));
		$seckillinfo = plugin_run('seckill::getTaskSeckillInfo');
		ob_start();
		ob_implicit_flush(false);
		require $this->template('index_tpl');
		return ob_get_clean();
	}

	public function seckillinfo()
	{
		$seckillinfo = plugin_run('seckill::getTaskSeckillInfo');
		include $this->template('shop/index/seckill_tpl');
		exit();
	}

	public function qr()
	{
		global $_W;
		global $_GPC;
		$url = trim($_GPC['url']);
		require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
		QRcode::png($url, false, QR_ECLEVEL_L, 16, 1);
	}

	public function share_url()
	{
		global $_W;
		global $_GPC;
		$url = trim($_GPC['url']);
		$account_api = WeAccount::create($_W['acid']);
		$jssdkconfig = $account_api->getJssdkConfig($url);
		show_json(1, $jssdkconfig);
	}

	public function getLevel($openid)
	{
		global $_W;
		$level = 'false';

		if (empty($openid)) {
			return $level;
		}

		$member = m('member')->getMember($openid);
		if (empty($member['isagent']) || $member['status'] == 0 || $member['agentblack'] == 1) {
			return $level;
		}

		$level = pdo_fetch('select * from ' . tablename('ewei_shop_commission_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $member['agentlevel']));
		return $level;
	}

	public function getSet()
	{
		$set = m('common')->getPluginset('commission');
		$set['texts'] = array('agent' => empty($set['texts']['agent']) ? '分销商' : $set['texts']['agent'], 'shop' => empty($set['texts']['shop']) ? '小店' : $set['texts']['shop'], 'myshop' => empty($set['texts']['myshop']) ? '我的小店' : $set['texts']['myshop'], 'center' => empty($set['texts']['center']) ? '分销中心' : $set['texts']['center'], 'become' => empty($set['texts']['become']) ? '成为分销商' : $set['texts']['become'], 'withdraw' => empty($set['texts']['withdraw']) ? '提现' : $set['texts']['withdraw'], 'commission' => empty($set['texts']['commission']) ? '佣金' : $set['texts']['commission'], 'commission1' => empty($set['texts']['commission1']) ? '分销佣金' : $set['texts']['commission1'], 'commission_total' => empty($set['texts']['commission_total']) ? '累计佣金' : $set['texts']['commission_total'], 'commission_ok' => empty($set['texts']['commission_ok']) ? '可提现佣金' : $set['texts']['commission_ok'], 'commission_apply' => empty($set['texts']['commission_apply']) ? '已申请佣金' : $set['texts']['commission_apply'], 'commission_check' => empty($set['texts']['commission_check']) ? '待打款佣金' : $set['texts']['commission_check'], 'commission_lock' => empty($set['texts']['commission_lock']) ? '未结算佣金' : $set['texts']['commission_lock'], 'commission_detail' => empty($set['texts']['commission_detail']) ? '提现明细' : ($set['texts']['commission_detail'] == '佣金明细' ? '提现明细' : $set['texts']['commission_detail']), 'commission_pay' => empty($set['texts']['commission_pay']) ? '成功提现佣金' : $set['texts']['commission_pay'], 'commission_wait' => empty($set['texts']['commission_wait']) ? '待收货佣金' : $set['texts']['commission_wait'], 'commission_fail' => empty($set['texts']['commission_fail']) ? '无效佣金' : $set['texts']['commission_fail'], 'commission_charge' => empty($set['texts']['commission_charge']) ? '扣除提现手续费' : $set['texts']['commission_charge'], 'order' => empty($set['texts']['order']) ? '分销订单' : $set['texts']['order'], 'c1' => empty($set['texts']['c1']) ? '一级' : $set['texts']['c1'], 'c2' => empty($set['texts']['c2']) ? '二级' : $set['texts']['c2'], 'c3' => empty($set['texts']['c3']) ? '三级' : $set['texts']['c3'], 'mydown' => empty($set['texts']['mydown']) ? '我的下线' : $set['texts']['mydown'], 'down' => empty($set['texts']['down']) ? '下线' : $set['texts']['down'], 'up' => empty($set['texts']['up']) ? '推荐人' : $set['texts']['up'], 'yuan' => empty($set['texts']['yuan']) ? '元' : $set['texts']['yuan'], 'icode' => empty($set['texts']['icode']) ? '邀请码' : $set['texts']['icode']);
		return $set;
	}

	/**
     * 计算出此商品的佣金
     * @param type $goodsid
     * @return type
     */
	public function getCommission($goods, $level, $set)
	{
		global $_W;
		$commission = 0;

		if ($level == 'false') {
			return $commission;
		}

		if ($goods['hascommission'] == 1) {
			$price = $goods['maxprice'];
			$levelid = 'default';

			if ($level) {
				$levelid = 'level' . $level['id'];
			}

			$goods_commission = !empty($goods['commission']) ? json_decode($goods['commission'], true) : array();

			if ($goods_commission['type'] == 0) {
				$commission = 1 <= $set['level'] ? (0 < $goods['commission1_rate'] ? $goods['commission1_rate'] * $goods['marketprice'] / 100 : $goods['commission1_pay']) : 0;
			}
			else {
				$price_all = array();

				foreach ($goods_commission[$levelid] as $key => $value) {
					foreach ($value as $k => $v) {
						if (strexists($v, '%')) {
							array_push($price_all, floatval(str_replace('%', '', $v) / 100) * $price);
							continue;
						}

						array_push($price_all, $v);
					}
				}

				$commission = max($price_all);
			}
		}
		else {
			if ($level != 'false' && !empty($level)) {
				if ($goods['marketprice'] <= 0) {
					$goods['marketprice'] = $goods['maxprice'];
				}

				$commission = 1 <= $set['level'] ? round($level['commission1'] * $goods['marketprice'] / 100, 2) : 0;
			}
			else {
				if ($goods['marketprice'] <= 0) {
					$goods['marketprice'] = $goods['maxprice'];
				}

				$commission = 1 <= $set['level'] ? round($set['commission1'] * $goods['marketprice'] / 100, 2) : 0;
			}
		}

		return $commission;
	}
}

?>
