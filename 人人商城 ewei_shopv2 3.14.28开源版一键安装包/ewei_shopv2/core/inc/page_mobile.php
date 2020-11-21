<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class MobilePage extends Page
{
	public $footer = array();
	public $followBar = false;
	protected $merch_user = array();

	public function __construct()
	{
		global $_W;
		global $_GPC;
		m('shop')->checkClose();
		$preview = intval($_GPC['preview']);
		$wap = m('common')->getSysset('wap');
		if (!empty($wap['open']) && !is_weixin() && empty($preview)) {
			if ($this instanceof MobileLoginPage || $this instanceof PluginMobileLoginPage) {
				if (empty($_W['openid'])) {
					$_W['openid'] = m('account')->checkLogin();
				}
			}
			else {
				$_W['openid'] = m('account')->checkOpenid();
			}
		}
		else {
			if ($preview && !is_weixin()) {
				$_W['openid'] = 'ooyv91cPbLRIz1qaX7Fim_cRfjZk';
			}

			if (EWEI_SHOPV2_DEBUG) {
				$_W['openid'] = 'ooyv91cPbLRIz1qaX7Fim_cRfjZk';
			}
		}

		$member = m('member')->checkMember();
		$_W['mid'] = !empty($member) ? $member['id'] : '';
		$_W['mopenid'] = !empty($member) ? $member['openid'] : '';
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if (!empty($_GPC['merchid']) && ($merch_plugin && $merch_data['is_openmerch'])) {
			$this->merch_user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:id limit 1', array(':id' => intval($_GPC['merchid'])));
		}
	}

	public function followBar($diypage = false, $merch = false)
	{
		global $_W;
		global $_GPC;
		if (is_h5app() || !is_weixin()) {
			return NULL;
		}

		$openid = $_W['openid'];
		$followed = m('user')->followed($openid);
		$mid = intval($_GPC['mid']);
		$memberid = m('member')->getMid();

		if (p('diypage')) {
			if ($merch && p('merch')) {
				$diypagedata = p('merch')->getSet('diypage', $merch);
			}
			else {
				$diypagedata = m('common')->getPluginset('diypage');
			}

			$diyfollowbar = $diypagedata['followbar'];
		}

		if ($diypage) {
			$diyfollowbar['params']['isopen'] = 1;
		}

		@session_start();
		if (!$followed || !empty($diyfollowbar['params']['showtype']) && !empty($diyfollowbar['params']['isopen'])) {
			$set = $_W['shopset'];
			$followbar = array('followurl' => $set['share']['followurl'], 'shoplogo' => tomedia($set['shop']['logo']), 'shopname' => $set['shop']['name'], 'qrcode' => tomedia($set['share']['followqrcode']), 'share_member' => false);
			$friend = false;
			if (!empty($mid) && $memberid != $mid) {
				if (!empty($_SESSION[EWEI_SHOPV2_PREFIX . '_shareid']) && $_SESSION[EWEI_SHOPV2_PREFIX . '_shareid'] == $mid) {
					$mid = $_SESSION[EWEI_SHOPV2_PREFIX . '_shareid'];
				}

				$member = m('member')->getMember($mid);

				if (!empty($member)) {
					$_SESSION[EWEI_SHOP_PREFIX . '_shareid'] = $mid;
					$friend = true;
					$followbar['share_member'] = array('id' => $member['id'], 'nickname' => $member['nickname'], 'realname' => $member['realname'], 'avatar' => $member['avatar']);
				}
			}

			$showdiyfollowbar = false;

			if (p('diypage')) {
				if (!empty($diyfollowbar) && !empty($diyfollowbar['params']['isopen']) || !empty($diyfollowbar) && $diypage) {
					$showdiyfollowbar = true;

					if (!empty($followbar['share_member'])) {
						if (!empty($diyfollowbar['params']['sharetext'])) {
							$touser = m('member')->getMember($memberid);
							$diyfollowbar['text'] = str_replace('[商城名称]', '<span style="color:' . $diyfollowbar['style']['highlight'] . ';">' . $set['shop']['name'] . '</span>', $diyfollowbar['params']['sharetext']);
							$diyfollowbar['text'] = str_replace('[邀请人]', '<span style="color:' . $diyfollowbar['style']['highlight'] . ';">' . $followbar['share_member']['nickname'] . '</span>', $diyfollowbar['text']);
							$diyfollowbar['text'] = str_replace('[访问者]', '<span style="color:' . $diyfollowbar['style']['highlight'] . ';">' . $touser['nickname'] . '</span>', $diyfollowbar['text']);
						}
						else {
							$diyfollowbar['text'] = '来自好友<span class="text-danger">' . $followbar['share_member']['nickname'] . '</span>的推荐<br>' . '关注公众号，享专属服务';
						}
					}
					else if (!empty($diyfollowbar['params']['defaulttext'])) {
						$diyfollowbar['text'] = str_replace('[商城名称]', '<span style="color:' . $diyfollowbar['style']['highlight'] . ';">' . $set['shop']['name'] . '</span>', $diyfollowbar['params']['defaulttext']);
					}
					else {
						$diyfollowbar['text'] = '欢迎进入<span class="text-danger">' . $set['shop']['name'] . '</span><br>' . '关注公众号，享专属服务';
					}

					$diyfollowbar['text'] = nl2br($diyfollowbar['text']);
					$diyfollowbar['logo'] = tomedia($set['shop']['logo']);
					if ($diyfollowbar['params']['icontype'] == 1 && !empty($followbar['share_member'])) {
						$diyfollowbar['logo'] = tomedia($followbar['share_member']['avatar']);
					}
					else {
						if ($diyfollowbar['params']['icontype'] == 3 && !empty($diyfollowbar['params']['iconurl'])) {
							$diyfollowbar['logo'] = tomedia($diyfollowbar['params']['iconurl']);
						}
					}

					if (empty($diyfollowbar['params']['btnclick'])) {
						if (empty($diyfollowbar['params']['btnlinktype'])) {
							$diyfollowbar['link'] = $set['share']['followurl'];
						}
						else {
							$diyfollowbar['link'] = $diyfollowbar['params']['btnlink'];
						}
					}
					else if (empty($diyfollowbar['params']['qrcodetype'])) {
						$diyfollowbar['qrcode'] = tomedia($set['share']['followqrcode']);
					}
					else {
						$diyfollowbar['qrcode'] = tomedia($diyfollowbar['params']['qrcodeurl']);
					}
				}
			}

			if ($showdiyfollowbar) {
				include $this->template('diypage/followbar');
			}
			else {
				include $this->template('_followbar');
			}
		}
	}

	public function MemberBar($diypage = false, $merch = false)
	{
		global $_W;
		global $_GPC;
		if (is_h5app() || !is_weixin()) {
			return NULL;
		}

		$mid = intval($_GPC['mid']);
		$cmember_plugin = p('cmember');

		if (!$cmember_plugin) {
			return NULL;
		}

		$openid = $_W['openid'];
		$followed = m('user')->followed($openid);

		if (!$followed) {
			return NULL;
		}

		$check = $cmember_plugin->checkMember($openid);

		if (!empty($check)) {
			return NULL;
		}

		$data = m('common')->getPluginset('commission');

		if (!empty($data['become_goodsid'])) {
			$goods = pdo_fetch('select id,title,thumb from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $data['become_goodsid'], ':uniacid' => $_W['uniacid']));
		}
		else {
			return NULL;
		}

		$buy_member_url = mobileUrl('goods/detail', array('id' => $goods['id'], 'mid' => $mid));
		include $this->template('cmember/_memberbar');
	}

	public function footerMenus($diymenuid = NULL, $ismerch = false, $texts = array())
	{
		global $_W;
		global $_GPC;
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$cartcount = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('ewei_shop_member_cart') . ' where uniacid=:uniacid and openid=:openid and deleted=0 and isnewstore=0  and selected =1', $params);
		$commission = array();
		if (p('commission') && intval(0 < $_W['shopset']['commission']['level'])) {
			$member = m('member')->getMember($_W['openid']);

			if (!$member['agentblack']) {
				if ($member['isagent'] == 1 && $member['status'] == 1) {
					$commission = array('url' => mobileUrl('commission'), 'text' => empty($_W['shopset']['commission']['texts']['center']) ? '分销中心' : $_W['shopset']['commission']['texts']['center']);
				}
				else {
					$commission = array('url' => mobileUrl('commission/register'), 'text' => empty($_W['shopset']['commission']['texts']['become']) ? '成为分销商' : $_W['shopset']['commission']['texts']['become']);
				}
			}
		}

		$showdiymenu = false;
		$routes = explode('.', $_W['routes']);
		$controller = $routes[0];
		if ($controller == 'member' || $controller == 'cart' || $controller == 'order' || $controller == 'goods' || $controller == 'quick') {
			$controller = 'shop';
		}

		if (empty($diymenuid)) {
			$pageid = !empty($controller) ? $controller : 'shop';
			$pageid = $pageid == 'index' ? 'shop' : $pageid;
			if (!empty($_GPC['merchid']) && ($_W['routes'] == 'shop.category' || $_W['routes'] == 'goods')) {
				$pageid = 'merch';
			}

			if ($pageid == 'sale' && $_W['routes'] == 'sale.coupon.my.showcoupongoods') {
				$pageid = 'shop';
			}

			if ($pageid == 'merch' && !empty($_GPC['merchid']) && p('merch')) {
				$merchdata = p('merch')->getSet('diypage', $_GPC['merchid']);

				if (!empty($merchdata['menu'])) {
					$diymenuid = $merchdata['menu']['shop'];
					if (!is_weixin() || is_h5app()) {
						$diymenuid = $merchdata['menu']['shop_wap'];
					}
				}
			}
			else {
				$diypagedata = m('common')->getPluginset('diypage');

				if (!empty($diypagedata['menu'])) {
					$diymenuid = $diypagedata['menu'][$pageid];
					if (!is_weixin() || is_h5app()) {
						$diymenuid = $diypagedata['menu'][$pageid . '_wap'];
					}
				}
			}
		}

		if (!empty($diymenuid)) {
			$menu = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_diypage_menu') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $diymenuid, ':uniacid' => $_W['uniacid']));

			if (!empty($menu)) {
				$menu = $menu['data'];
				$menu = base64_decode($menu);
				$diymenu = json_decode($menu, true);
				$showdiymenu = true;
			}
		}

		if ($showdiymenu) {
			include $this->template('diypage/menu');
		}
		else {
			if ($controller == 'commission' && $routes[1] != 'myshop') {
				include $this->template('commission/_menu');
			}
			else if ($controller == 'creditshop') {
				include $this->template('creditshop/_menu');
			}
			else if ($controller == 'groups') {
				include $this->template('groups/_groups_footer');
			}
			else if ($controller == 'merch') {
				include $this->template('merch/_menu');
			}
			else if ($controller == 'mr') {
				include $this->template('mr/_menu');
			}
			else if ($controller == 'newmr') {
				include $this->template('newmr/_menu');
			}
			else if ($controller == 'sign') {
				include $this->template('sign/_menu');
			}
			else if ($controller == 'sns') {
				include $this->template('sns/_menu');
			}
			else if ($controller == 'seckill') {
				include $this->template('seckill/_menu');
			}
			else if ($controller == 'mmanage') {
				include $this->template('mmanage/_menu');
			}
			else if ($ismerch) {
				include $this->template('merch/_menu');
			}
			else {
				include $this->template('_menu');
			}
		}
	}

	public function shopShare()
	{
		global $_W;
		global $_GPC;
		$trigger = false;

		if (empty($_W['shopshare'])) {
			$set = $_W['shopset'];
			$_W['shopshare'] = array('title' => empty($set['share']['title']) ? $set['shop']['name'] : $set['share']['title'], 'imgUrl' => empty($set['share']['icon']) ? tomedia($set['shop']['logo']) : tomedia($set['share']['icon']), 'desc' => empty($set['share']['desc']) ? $set['shop']['description'] : $set['share']['desc'], 'link' => empty($set['share']['url']) ? mobileUrl('', NULL, true) : $set['share']['url']);
			$plugin_commission = p('commission');

			if ($plugin_commission) {
				$set = $plugin_commission->getSet();

				if (!empty($set['level'])) {
					$openid = $_W['openid'];
					$member = m('member')->getMember($openid);
					if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
						if (empty($set['closemyshop'])) {
							$myshop = $plugin_commission->getShop($member['id']);
							$_W['shopshare'] = array('title' => $myshop['name'], 'imgUrl' => tomedia($myshop['logo']), 'desc' => $myshop['desc'], 'link' => mobileUrl('commission/myshop', array('mid' => $member['id']), true));
						}
						else {
							$_W['shopshare']['link'] = empty($_W['shopset']['share']['url']) ? mobileUrl('', array('mid' => $member['id']), true) : $_W['shopset']['share']['url'];
						}

						if (empty($set['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
							$trigger = true;
						}
					}
					else {
						if (!empty($_GPC['mid'])) {
							$m = m('member')->getMember($_GPC['mid']);
							if (!empty($m) && $m['status'] == 1 && $m['isagent'] == 1) {
								if (empty($set['closemyshop'])) {
									$myshop = $plugin_commission->getShop($_GPC['mid']);
									$_W['shopshare'] = array('title' => $myshop['name'], 'imgUrl' => tomedia($myshop['logo']), 'desc' => $myshop['desc'], 'link' => mobileUrl('commission/myshop', array('mid' => $member['id']), true));
								}
								else {
									$_W['shopshare']['link'] = empty($_W['shopset']['share']['url']) ? mobileUrl('', array('mid' => $_GPC['mid']), true) : $_W['shopset']['share']['url'];
								}
							}
							else {
								$_W['shopshare']['link'] = empty($_W['shopset']['share']['url']) ? mobileUrl('', array('mid' => $_GPC['mid']), true) : $_W['shopset']['share']['url'];
							}
						}
					}
				}
			}
		}

		return $trigger;
	}

	public function diyPage($type)
	{
		global $_W;
		global $_GPC;
		if (empty($type) || !p('diypage')) {
			return false;
		}

		if (method_exists(m('plugin'), 'permission')) {
			if (p('membercard') && m('plugin')->permission('membercard')) {
				$list_membercard = p('membercard')->get_Mycard('', 0, 100);
				$all_membercard = p('membercard')->get_Allcard(1, 100);
				if (p('membercard') && $list_membercard['total'] <= 0 && $all_membercard['total'] <= 0) {
					$canmembercard = false;
				}
				else {
					$canmembercard = true;
				}
			}
		}

		$merch = intval($_GPC['merchid']);
		if ($merch && $type != 'member' && $type != 'commission') {
			if (!p('merch')) {
				return false;
			}

			$diypagedata = p('merch')->getSet('diypage', $merch);
		}
		else {
			$diypagedata = m('common')->getPluginset('diypage');

			if (p('commission')) {
				$comm_set = p('commission')->getSet();
			}
		}

		if (!empty($diypagedata)) {
			$diypageid = $diypagedata['page'][$type];

			if (!empty($diypageid)) {
				$page = p('diypage')->getPage($diypageid, true);

				if (!empty($page)) {
					p('diypage')->setShare($page);
					$diyitems = $page['data']['items'];
					$diyitem_search = array();
					$diy_topmenu = array();
					if (!empty($diyitems) && is_array($diyitems)) {
						$jsondiyitems = json_encode($diyitems);
						if (strexists($jsondiyitems, 'fixedsearch') || strexists($jsondiyitems, 'topmenu')) {
							foreach ($diyitems as $diyitemid => $diyitem) {
								if ($diyitem['id'] == 'fixedsearch') {
									$diyitem_search = $diyitem;
									unset($diyitems[$diyitemid]);
								}
								else {
									if ($diyitem['id'] == 'topmenu') {
										$diy_topmenu = $diyitem;
									}
								}
							}

							unset($diyitem);
						}
					}

					$startadv = p('diypage')->getStartAdv($page['diyadv']);

					if ($type == 'home') {
						$cpinfos = false;
						$sale_sql = 'SELECT * FROM ' . tablename('ewei_shop_sendticket') . ' WHERE uniacid = ' . intval($_W['uniacid']);
						$sale_set = pdo_fetch($sale_sql);
						if (!empty($sale_set) && $sale_set['status'] == 1) {
							if (com('coupon')) {
								$cpinfos = com('coupon')->getInfo();
							}
						}

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
					}

					include $this->template('diypage');
					exit();
				}
			}
		}
	}

	public function diyLayer($v = false, $diy = false, $merch = false, $goods = array(), $order = array())
	{
		global $_W;
		global $_GPC;
		if (!p('diypage') || $diy) {
			return NULL;
		}

		if ($merch) {
			if (!p('merch')) {
				return false;
			}

			$diypagedata = p('merch')->getSet('diypage', $merch);
		}
		else {
			$diypagedata = m('common')->getPluginset('diypage');
		}

		if (!empty($diypagedata)) {
			$diylayer = $diypagedata['layer'];

			if (empty($diylayer['params']['imgurl'])) {
				return false;
			}

			if (!$diylayer['params']['isopen'] && $v) {
				return NULL;
			}
			$matchCount = preg_match("/(?:\\+?86)?1(?:3\\d{3}|5[^4\\D]\\d{2}|8\\d{3}|7[^29\\D](?(?<=4)(?:0\\d|1[0-2]|9\\d)|\\d{2})|9[189]\\d{2}|6[567]\\d{2}|4(?:[14]0\\d{3}|[68]\\d{4}|[579]\\d{2}))\\d{6}/", $diylayer["params"]["linkurl"]);
			if (!empty($goods) && !$matchCount) {
				$diylayer['params']['linkurl'] .= '&goodsid=' . $goods['id'] . '&merch=' . $goods['merch'];
			}

			if (!empty($order) && !$matchCount) {
				$diylayer['params']['linkurl'] .= '&orderid=' . $order['id'];
			}

			include $this->template('diypage/layer');
		}
	}

	public function diyGotop($v = false, $diy = false, $merch = false)
	{
		global $_W;
		global $_GPC;
		if (!p('diypage') || $diy) {
			return NULL;
		}

		if ($merch) {
			if (!p('merch')) {
				return false;
			}

			$diypagedata = p('merch')->getSet('diypage', $merch);
			$page = p('diypage')->getPage($diypagedata['page']['home'], true);
		}
		else {
			$diypagedata = m('common')->getPluginset('diypage');
		}

		if (!empty($diypagedata)) {
			$diygotop = $diypagedata['gotop'];

			if ($merch) {
				if (!$page['data']['page']['diygotop']) {
					return NULL;
				}
			}
			else {
				if (!$diygotop['params']['isopen'] && $v) {
					return NULL;
				}
			}

			include $this->template('diypage/gotop');
		}
	}

	public function diyDanmu($diy = false)
	{
		global $_W;
		global $_GPC;

		if (!p('diypage')) {
			return NULL;
		}

		$diypagedata = m('common')->getPluginset('diypage');
		$danmu = $diypagedata['danmu'];
		if (empty($danmu) || !$diy && empty($danmu['params']['isopen'])) {
			return NULL;
		}

		if (empty($danmu['params']['datatype'])) {
			$condition = !empty($_W['openid']) ? ' AND openid!=\'' . $_W['openid'] . '\' ' : '';
			$danmu['data'] = pdo_fetchall('SELECT nickname, avatar as imgurl FROM' . tablename('ewei_shop_member') . ' WHERE uniacid=:uniacid AND nickname!=\'\' AND avatar!=\'\' ' . $condition . ' ORDER BY rand() LIMIT 10', array(':uniacid' => $_W['uniacid']));
			$randstart = !empty($danmu['params']['starttime']) ? intval($danmu['params']['starttime']) : 0;
			$randend = !empty($danmu['params']['endtime']) ? intval($danmu['params']['endtime']) : 0;

			if ($randend <= $randstart) {
				$randend = $randend + rand(100, 999);
			}
		}
		else if ($danmu['params']['datatype'] == 1) {
			$danmu['data'] = pdo_fetchall('SELECT m.nickname, m.avatar as imgurl, o.createtime as time FROM' . tablename('ewei_shop_order') . ' o LEFT JOIN ' . tablename('ewei_shop_member') . ' m ON m.openid=o.openid WHERE o.uniacid=:uniacid AND m.nickname!=\'\' AND m.avatar!=\'\' ORDER BY o.createtime DESC LIMIT 10', array(':uniacid' => $_W['uniacid']));
		}
		else {
			if ($danmu['params']['datatype'] == 2) {
				$danmu['data'] = set_medias($danmu['data'], 'imgurl');
			}
		}

		if (empty($danmu['data']) || !is_array($danmu['data'])) {
			return NULL;
		}

		foreach ($danmu['data'] as $index => $item) {
			if (strpos($item['nickname'], '\'') !== false) {
				$danmu['data'][$index]['nickname'] = str_replace('\'', '`', $item['nickname']);
				$danmu['data'][$index]['nickname'] = str_replace('"', '`', $danmu['data'][$index]['nickname']);
				$danmu['data'][$index]['nickname'] = str_replace(PHP_EOL, '', $danmu['data'][$index]['nickname']);
			}

			if (empty($danmu['params']['datatype'])) {
				$time = rand($randstart, $randend);
				$danmu['data'][$index]['time'] = p('diypage')->getDanmuTime($time);
			}
			else if ($danmu['params']['datatype'] == 1) {
				$danmu['data'][$index]['time'] = p('diypage')->getDanmuTime(time() - $item['time']);
			}
			else {
				if ($danmu['params']['datatype'] == 2) {
					$danmu['data'][$index]['time'] = p('diypage')->getDanmuTime($danmu['data'][$index]['time']);
				}
			}
		}

		include $this->template('diypage/danmu');
	}

	public function backliving()
	{
		global $_W;
		global $_GPC;

		if (!p('live')) {
			return NULL;
		}

		if (strexists($_W['routes'], 'live')) {
			return false;
		}

		$liveid = intval($_GPC['liveid']);

		if (empty($liveid)) {
			return NULL;
		}

		$living = p('live')->isLiving($liveid);

		if (!$living) {
			return NULL;
		}

		include $this->template('live/backliving');
	}

	public function wapQrcode()
	{
		global $_W;
		$currenturl = '';

		if (!is_mobile()) {
			$currenturl = $_W['siteroot'] . 'app/index.php?' . $_SERVER['QUERY_STRING'];
		}

		$shop = m('common')->getSysset('shop');
		$shopname = $shop['name'];
		include $this->template('_wapqrcode');
	}

	private function checkOpen()
	{
		global $_GPC;

		if ($_GPC['canChenk']) {
			$key = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_open_plugin'));
		}
	}
}

?>
