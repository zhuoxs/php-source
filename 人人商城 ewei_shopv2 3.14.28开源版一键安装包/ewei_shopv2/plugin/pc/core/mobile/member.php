<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class MemberController extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		p('pc')->checkLogin();
		$data = $this->memberData('member');
		$data['title'] = '会员中心';
		return $this->view('member', $data);
	}

	/**
     * @param string $tag
     * @return array
     */
	public function memberData($tag = 'member')
	{
		global $_W;
		p('pc')->checkLogin();
		$userinfo = m('member')->getInfo($_W['openid']);
		$trade = m('common')->getSysset('trade');
		$shop = m('common')->getSysset('shop');
		$userinfo['credittext'] = $trade['credittext'];
		$userinfo['moneytext'] = $trade['moneytext'];
		$userinfo['credit1'] = m('member')->getCredit($userinfo['openid'], 'credit1');
		$userinfo['credit2'] = m('member')->getCredit($userinfo['openid'], 'credit2');

		if (0 < $userinfo['level']) {
			$levelname = pdo_get('ewei_shop_member_level', array('id' => $userinfo['level'], 'enabled' => 1), 'levelname');

			if ($levelname['levelname']) {
				$userinfo['levelname'] = $levelname['levelname'];
			}
		}
		else {
			if (!$shop['levelname']) {
				$shop['levelname'] = '普通等级';
			}

			$userinfo['levelname'] = $shop['levelname'];
		}

		$data = array('userinfo' => $userinfo, 'neworderlist' => $this->getOrderList(), 'ordercount' => p('pc')->getOrderCount());

		if (p('membercard')) {
			$data['membercard'] = $this->getMemberCard();
		}
		else {
			$data['membercard'] = array();
		}

		$data['count'] = p('pc')->getOrderCount();
		return $data;
	}

	public function getOrderList()
	{
		global $_W;
		p('pc')->checkLogin();
		$orders = pdo_fetchall('select o.price,o.ordersn,o.paytime,o.createtime,o.paytype,o.addressid,o.isverify,o.sendtype,o.status,o.id,og.goodsid,g.thumb from ' . tablename('ewei_shop_order') . ' as o
				left join ' . tablename('ewei_shop_order_goods') . ' as og on og.orderid = o.id
				left join ' . tablename('ewei_shop_goods') . ' as g on g.id = og.goodsid
				where o.openid = :openid and o.deleted = 0 and o.status>2 and o.sendtime>0 and o.uniacid = :uniacid  GROUP by o.ordersn order by o.createtime desc limit 2 ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		$orderstatus = array(
			-1 => array('css' => 'default', 'name' => '已关闭'),
			0  => array('css' => 'danger', 'name' => '待付款'),
			1  => array('css' => 'info', 'name' => '待发货'),
			2  => array('css' => 'warning', 'name' => '待收货'),
			3  => array('css' => 'success', 'name' => '已完成')
		);

		foreach ($orders as &$value) {
			$value['thumb'] = tomedia($value['thumb']);
			$s = $value['status'];
			$pt = $value['paytype'];
			$value['statusvalue'] = $s;
			$value['status'] = $orderstatus[$value['status']]['name'];
			if ($pt == 3 && empty($value['statusvalue'])) {
				$value['status'] = $orderstatus[1]['name'];
			}

			if ($s == 1) {
				if ($value['isverify'] == 1) {
					$value['status'] = '待使用';

					if (0 < $value['sendtype']) {
						$value['status'] = '部分使用';
					}
				}
				else if (empty($value['addressid'])) {
					$value['status'] = '待取货';
				}
				else {
					if (0 < $value['sendtype']) {
						$value['status'] = '部分发货';
					}
				}
			}
		}

		unset($value);
		return $orders;
	}

	/**
     * 获取会员卡信息
     * @return array
     * author   sunc
     */
	public function getMemberCard()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$results = p('membercard')->get_Allcard($pindex, $psize);
		$results['count'] = count($results['list']);

		foreach ($results['list'] as $key => &$value) {
			$card_history = p('membercard')->getMembercard_order_history($value['id']);

			if ($card_history) {
				$kaitong = false;
			}
			else {
				$kaitong = true;
			}

			$expire_card_history = $card_history = p('membercard')->getExpireMembercard_order_history($value['id']);

			if ($expire_card_history) {
				$chongxin_kaitong = true;
			}
			else {
				$chongxin_kaitong = false;
			}

			$value['kaitong'] = $kaitong;
			$value['chongxin_kaitong'] = $chongxin_kaitong;
			$value['expire_time'] = $card_history['expire_time'];
			$results['list'][$key] = $value;
		}

		unset($value);
		$results_my = p('membercard')->get_Mycard('', 0, 10);
		$results_my['count'] = count($results_my['list']);
		return array('list' => $results, 'list_my' => $results_my);
	}

	/**
     * 我的收藏
     */
	public function getMyFavorite()
	{
		global $_W;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		$condition = ' and f.uniacid = :uniacid and f.openid=:openid and f.deleted=0';
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$condition = ' and f.uniacid = :uniacid and f.openid=:openid and f.deleted=0 and f.type=0';
		}

		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_favorite') . (' f where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT f.id,f.goodsid,g.title,g.thumb,g.marketprice,g.productprice,g.merchid,g.minprice,g.maxprice FROM ' . tablename('ewei_shop_member_favorite') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC LIMIT 3 ';
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb');

			if (!empty($list)) {
				foreach ($list as &$item) {
					if ((double) $item['marketprice'] == 0 && (double) $item['productprice'] == 0) {
						$item['marketprice'] = $item['minprice'];
					}
				}
			}

			unset($item);
		}

		return $list;
	}

	/**
     * @return array
     * 获取足迹
     *
     */
	public function getMyHistory()
	{
		global $_W;
		global $_GPC;
		$condition = ' and f.uniacid = :uniacid and f.openid=:openid and f.deleted=0';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_history') . (' f where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'SELECT f.id,f.goodsid,g.title,g.thumb,g.marketprice,g.productprice,f.createtime,g.merchid FROM ' . tablename('ewei_shop_member_history') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC LIMIT 3 ';
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$row['thumb'] = tomedia($row['thumb']);
		}

		unset($row);
		return $list;
	}

	/**
     * 注册信息
     *
     */
	public function register()
	{
		global $_W;
		$data['title'] = '会员注册';
		$data['uniacid'] = $_W['uniacid'];
		return $this->view('member.register', $data);
	}

	/**
     * 注册信息提交
     *
     */
	public function regiinfo()
	{
		global $_W;
		global $_GPC;
		$data = $this->rf(0);
		return json_encode($data);
	}

	/**
     *登录信息
     */
	public function login()
	{
		global $_W;
		$data['title'] = '会员登录';
		$data['mobile'] = $_SESSION['registermobile'];
		$data['uniacid'] = $_W['uniacid'];
		return $this->view('member.login', $data);
	}

	public function loginin()
	{
		global $_W;
		global $_GPC;
		if (is_weixin() || !empty($_GPC['__ewei_shopv2_member_session_' . $_W['uniacid']])) {
			show_json(1, '您已登陆过,请勿重新登录');
		}

		if ($_W['ispost']) {
			$mobile = trim($_GPC['mobile']);
			$pwd = trim($_GPC['pwd']);
			$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and mobileverify=1 and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));

			if (empty($member)) {
				show_json(0, '用户不存在');
			}

			if (md5($pwd . $member['salt']) !== $member['pwd']) {
				show_json(0, '用户或密码错误');
			}

			m('account')->setLogin($member);
			show_json(1, '登录成功');
		}

		show_json(0, '系统错误');
	}

	/**
     * 登出会员信息
     */
	public function logout()
	{
		global $_W;
		global $_GPC;
		$key = '__ewei_shopv2_member_session_' . $_W['uniacid'];
		isetcookie($key, false, -100);
		header('location: ' . mobileUrl('pc'));
		exit();
	}

	/**
     * 忘记密码
     * @return string
     * @throws \Twig\Error\SyntaxError
     */
	public function forget()
	{
		global $_W;
		$data['title'] = '找回密码';
		$data['uniacid'] = $_W['uniacid'];
		return $this->view('member.forget', $data);
	}

	/**
     * 忘记密码提交
     * @return string
     * @throws \Twig\Error\SyntaxError
     */
	public function forgetinfo()
	{
		global $_W;
		global $_GPC;
		$data = $this->rf(1);
		return json_encode($data);
	}

	/**
     * 注册和找回密码逻辑
     * @param $type
     * @return array
     */
	protected function rf($type)
	{
		global $_W;
		global $_GPC;
		if (is_weixin() || !empty($_GPC['__ewei_shopv2_member_session_' . $_W['uniacid']])) {
			show_json(1, '您已登陆过,请勿重新登录');
		}

		if ($_W['ispost']) {
			$mobile = trim($_GPC['mobile']);
			$verifycode = trim($_GPC['verifycode']);
			$pwd = trim($_GPC['pwd']);

			if (empty($mobile)) {
				show_json(0, '请输入正确的手机号');
			}

			if (empty($verifycode)) {
				show_json(0, '请输入验证码');
			}

			if (empty($pwd)) {
				show_json(0, '请输入密码');
			}

			$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
			if (!isset($_SESSION[$key]) || $_SESSION[$key] !== $verifycode || !isset($_SESSION['verifycodesendtime']) || $_SESSION['verifycodesendtime'] + 600 < time()) {
				show_json(0, '验证码错误或已过期!');
			}

			$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and mobileverify=1 and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));

			if (empty($type)) {
				if (!empty($member)) {
					show_json(0, '此手机号已注册, 请直接登录');
				}

				$salt = empty($member) ? '' : $member['salt'];

				if (empty($salt)) {
					$salt = m('account')->getSalt();
				}

				$openid = empty($member) ? '' : $member['openid'];
				$nickname = empty($member) ? '' : $member['nickname'];

				if (empty($openid)) {
					$openid = 'wap_user_' . $_W['uniacid'] . '_' . $mobile;
					$nickname = substr($mobile, 0, 3) . 'xxxx' . substr($mobile, 7, 4);
				}

				$data = array('uniacid' => $_W['uniacid'], 'mobile' => $mobile, 'nickname' => $nickname, 'openid' => $openid, 'pwd' => md5($pwd . $salt), 'salt' => $salt, 'createtime' => time(), 'mobileverify' => 1, 'comefrom' => 'mobile');
			}
			else {
				if (empty($member)) {
					show_json(0, '此手机号未注册');
				}

				$salt = m('account')->getSalt();
				$data = array('salt' => $salt, 'pwd' => md5($pwd . $salt));
			}

			if (empty($member)) {
				pdo_insert('ewei_shop_member', $data);

				if (method_exists(m('member'), 'memberRadisCountDelete')) {
					m('member')->memberRadisCountDelete();
				}
			}
			else {
				pdo_update('ewei_shop_member', $data, array('id' => $member['id']));
			}

			if (p('commission')) {
				p('commission')->checkAgent($openid);
			}

			unset($_SESSION[$key]);
			session_start();
			$_SESSION['registermobile'] = $mobile;
			return array('status' => 1, 'message' => empty($type) ? '注册成功' : '密码重置成功');
		}
	}

	public function cart()
	{
		global $_W;
		global $_GPC;
		p('pc')->checkLogin();
		$data['title'] = '购物车';
		$info = p('pc')->invoke('member.cart::get_cart');
		$list = array();
		$notlist = array();

		if (!empty($info['merch_list'])) {
			foreach ($info['merch_list'] as $key => $value) {
				$list = array_merge($value['list'], $list);
			}
		}

		foreach ($list as $key => $val) {
			if ($val['cantbuy'] == 1) {
				$notlist[] = $val;
				unset($list[$key]);
			}
		}

		$data['canbuycount'] = count($list);
		$data['notbuycount'] = count($notlist);

		if ($_GPC['type'] == 1) {
			$list = $notlist;
		}

		$data['list'] = $list;
		$data['total'] = $info['total'];
		$data['totalprice'] = $info['totalprice'];
		$data['favorite'] = p('pc')->getGuessFavorGoods();
		$url = mobileUrl('member/cart', NULL, true);
		$qrcode = m('qrcode')->createQrcode($url);
		$data['url'] = $qrcode;
		$data['type'] = $_GPC['type'];
		return $this->view('member.cart', $data);
	}

	public function cartSelect()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$id = rtrim($id, ',');
		$id = explode(',', $id);
		$select = intval($_GPC['select']);

		foreach ($id as $value) {
			if (!empty($value)) {
				$data = pdo_fetch('select id,goodsid,optionid, total from ' . tablename('ewei_shop_member_cart') . ' ' . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1 ', array(':id' => $value, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

				if (!empty($data)) {
					pdo_update('ewei_shop_member_cart', array('selected' => $select), array('id' => $value, 'uniacid' => $_W['uniacid']));
				}
			}
			else {
				pdo_update('ewei_shop_member_cart', array('selected' => $select), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
			}
		}

		return json_encode(array('status' => 1));
	}

	public function cartUpdate()
	{
		global $_W;
		global $_GPC;
		$info = p('pc')->invoke('member.cart::update');

		if ($info['erron'] == 0) {
			return json_encode(array('status' => 1));
		}
	}

	public function cartDelete()
	{
		global $_W;
		global $_GPC;
		$_GPC['ids'] = rtrim($_GPC['ids'], ',');
		$_GPC['ids'] = explode(',', $_GPC['ids']);
		$info = p('pc')->invoke('member.cart::remove');

		if ($info['erron'] == 0) {
			return json_encode(array('status' => 1));
		}
	}

	public function verifycode()
	{
		global $_W;
		global $_GPC;
		@session_start();
		$set = $this->getWapSet();
		$mobile = trim($_GPC['mobile']);
		$temp = trim($_GPC['temp']);
		$imgcode = trim($_GPC['imgcode']);

		if (empty($mobile)) {
			show_json(0, '请输入手机号');
		}

		if (empty($temp)) {
			show_json(0, '参数错误');
		}

		if (!empty($_SESSION['verifycodesendtime']) && time() < $_SESSION['verifycodesendtime'] + 60) {
			show_json(0, '请求频繁请稍后重试');
		}

		$member = pdo_fetch('select id,openid,mobile,pwd,salt from ' . tablename('ewei_shop_member') . ' where mobile=:mobile and mobileverify=1 and uniacid=:uniacid limit 1', array(':mobile' => $mobile, ':uniacid' => $_W['uniacid']));
		if ($temp == 'sms_forget' && empty($member)) {
			show_json(0, '此手机号未注册');
		}

		if ($temp == 'sms_reg' && !empty($member)) {
			show_json(0, '此手机号已注册，请直接登录');
		}

		$sms_id = $set['wap'][$temp];

		if (empty($sms_id)) {
			show_json(0, '短信发送失败(NOSMSID)');
		}

		$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
		@session_start();
		$code = random(5, true);
		$shopname = $_W['shopset']['shop']['name'];
		$ret = array('status' => 0, 'message' => '发送失败');

		if (com('sms')) {
			$ret = com('sms')->send($mobile, $sms_id, array('验证码' => $code, '商城名称' => !empty($shopname) ? $shopname : '商城名称'));
		}

		if ($ret['status']) {
			$_SESSION[$key] = $code;
			$_SESSION['verifycodesendtime'] = time();
			show_json(1, '短信发送成功');
		}

		show_json(0, $ret['message']);
	}

	protected function getWapSet()
	{
		global $_W;
		global $_GPC;
		$set = m('common')->getSysset(array('shop', 'wap'));
		$set['wap']['color'] = empty($set['wap']['color']) ? '#fff' : $set['wap']['color'];
		$params = array();

		if (!empty($_GPC['mid'])) {
			$params['mid'] = $_GPC['mid'];
		}

		if (!empty($_GPC['backurl'])) {
			$params['backurl'] = $_GPC['backurl'];
		}

		$set['wap']['loginurl'] = mobileUrl('pc/member/login', $params);
		$set['wap']['regurl'] = mobileUrl('pc/member/register', $params);
		$set['wap']['forgeturl'] = mobileUrl('pc/member/forget', $params);
		return $set;
	}
}

?>
