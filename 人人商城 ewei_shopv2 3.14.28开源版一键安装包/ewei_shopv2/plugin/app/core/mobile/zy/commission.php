<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}
require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Commission_EweiShopV2Page extends AppMobilePage
{
	public function shopset()
	{
		global $_GPC,$_W;
		if (empty($_W['openid'])) {
			return app_error('您的身份信息未获取!');
		}
		$member = m('member')->getMember($_W['openid']);
		$shop = pdo_fetch('select * from ' . tablename('ewei_shop_commission_shop') . ' where uniacid=:uniacid and mid=:mid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));
		if ($_GPC['save']==1) {
			//$shopdata = (is_array($_GPC['shopdata']) ? $_GPC['shopdata'] : array());
			$shopdata['uniacid'] = $_W['uniacid'];
			$shopdata['mid'] = $member['id'];
			$shopdata['name'] = trim($_GPC['shopname']);
			$shopdata['desc'] = trim($_GPC['shopdesc']);
			$imgs = $_GPC['imgs'];
			if(!empty($imgs)) $shopdata['logo'] = $imgs[0];
			else $shopdata['logo'] = '';
			if(!empty($imgs) && !empty($imgs[1])) $shopdata['img'] = $imgs[1];
			else $shopdata['img'] = '';
			if (empty($shop['id'])) {
				pdo_insert('ewei_shop_commission_shop', $shopdata);
			}
			else {
				pdo_update('ewei_shop_commission_shop', $shopdata, array('id' => $shop['id']));
			}

			return app_json(array('success'=>1));
		}
		$shop = set_medias($shop, array('img', 'logo'));
		$openselect = false;
		$shop['imgs'] = array();
		if(!empty($shop['logo'])) $shop['imgs'][] = $shop['logo'];
		if(!empty($shop['img'])) $shop['imgs'][] = $shop['img'];
		if ($this->set['select_goods'] == '1') {
			if (empty($member['agentselectgoods']) || ($member['agentselectgoods'] == 2)) {
				$openselect = true;
			}
		}
		else {
			if ($member['agentselectgoods'] == 2) {
				$openselect = true;
			}
		}

		$shop['openselect'] = $openselect;
		return app_json(array('shop'=>$shop));
	}
	public function rank()
	{
		global $_GPC,$_W;
		if (empty($_W['openid'])) {
			return app_error('您的身份信息未获取!');
		}
		$this->commission_rank = $_W['shopset']['commission']['rank'];
		if (empty($this->commission_rank) || empty($this->commission_rank['status'])) {
			return app_error('未开启排行榜功能！');
		}
		$commission_rank = $this->commission_rank;
		switch ($this->commission_rank['type']) {
		case '0':
			$user = pdo_fetch('SELECT id,uid,credit1,nickname,avatar,commission_total FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			$user['paiming'] = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND commission_total >= :commission_total', array(':uniacid' => $_W['uniacid'], ':commission_total' => $user['commission_total']));
			$commission_title = '累计佣金';
			break;

		case '1':
			$user = pdo_fetch('SELECT id,uid,credit1,nickname,avatar,commission_total FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			$user['commission_total'] = pdo_fetchcolumn('SELECT SUM(commission_pay) FROM ' . tablename('ewei_shop_commission_apply') . ' WHERE uniacid = :uniacid AND mid = :mid and status=3 ', array(':uniacid' => $_W['uniacid'], ':mid' => $user['id']));
			if(!$user['commission_total']) $user['commission_total'] = '0.00';
			$result = pdo_fetchall('SELECT c.id,c.mid,SUM(c.commission_pay)  as commission_pay,m.nickname,m.avatar FROM ' . tablename('ewei_shop_commission_apply') . ' c LEFT JOIN ' . tablename('ewei_shop_member') . ' m ON c.mid=m.id WHERE c.uniacid = :uniacid AND c.status=3  GROUP BY c.mid ORDER BY commission_pay DESC LIMIT ' . intval($commission_rank['num']), array(':uniacid' => $_W['uniacid']));
			$paiming = 0;

			foreach ($result as $key => $val) {
				if ($val['mid'] == $user['id']) {
					$paiming += $key + 1;
				}
			}

			$user['paiming'] = empty($paiming) ? '未上榜' : $paiming;
			$commission_title = '已提现佣金';
			break;

		case '2':
			$user = pdo_fetch('SELECT id,uid,credit1,nickname,avatar,commission_total FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			$user['paiming'] = empty($paiming) ? '未上榜' : $paiming;
			$commission_title = $this->commission_rank['title'];
		}
		return app_json(array('user'=>$user,'commission_title'=>$commission_title,'maxnum'=>intval($this->commission_rank['num'])));
	}
	public function rank_list()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, (int) $_GPC['page']);
		$psize = 20;
		$this->commission_rank = $_W['shopset']['commission']['rank'];
		if (empty($this->commission_rank) || empty($this->commission_rank['status'])) return app_json(array('total' => 0, 'list' => array(), 'pagesize' => 0));
		/*if ($this->commission_rank['num'] <= $pindex * $psize) {
			$psize = (($this->commission_rank['num'] % $psize) == 0 ? 20 : $this->commission_rank['num'] % $psize);
			$pindex = ceil($this->commission_rank['num'] / $psize);
			$this->len = 0;
		}
		if(empty($pindex)) $pindex = 1;*/
		switch ($this->commission_rank['type']) {
		case '0':
			$this->commissionTotal($pindex, $psize);
			break;

		case '1':
			$this->commissionPay($pindex, $psize);
			break;

		case '2':
			$this->commissionVirtual($pindex, $psize);
			break;
		}
	}
	/**
     * 查询累计佣金排名
     * @param $pindex
     * @param $psize
     */
	protected function commissionTotal($pindex, $psize)
	{
		global $_W;
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$result = pdo_fetchall('SELECT id,uid,nickname,avatar,commission_total FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid ORDER BY commission_total DESC,id ' . $limit, array(':uniacid' => $_W['uniacid']));
//print_r($this->commission_rank);exit;
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $_W['uniacid']));
		if (!empty($result)) {
			$result_tmp = array();

			foreach ($result as $k=>$val) {
				$val['index'] = (($pindex - 1) * $psize)+$k+1;
				if($this->commission_rank['num']<$val['index']) break;
				$val['gold'] = $this->rankIcon($val['index']);
				$val['commission_total'] = number_format($val['commission_total'], 2);
				$result_tmp[] = $val;
			}

			$result = $result_tmp;
		}else $result = array();
		return app_json(array('total' => $total, 'list' => $result, 'pagesize' => $psize));
		//show_json(1, array('list' => $result, 'len' => $this->len));
	}

	/**
     * 查询已提现佣金排名
     * @param $pindex
     * @param $psize
     */
	protected function commissionPay($pindex, $psize)
	{
		global $_W;
		$limit = ' LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$result = pdo_fetchall('SELECT c.id,c.mid,SUM(c.commission_pay)  as commission_pay,m.nickname,m.avatar FROM ' . tablename('ewei_shop_commission_apply') . ' c LEFT JOIN ' . tablename('ewei_shop_member') . ' m ON c.mid=m.id WHERE c.uniacid = :uniacid AND c.status=3  GROUP BY c.mid ORDER BY commission_pay DESC' . $limit, array(':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_commission_apply') . ' c LEFT JOIN ' . tablename('ewei_shop_member') . ' m ON c.mid=m.id WHERE c.uniacid = :uniacid AND c.status=3', array(':uniacid' => $_W['uniacid']));
		if (!empty($result)) {
			$result_tmp = array();

			foreach ($result as $k=>$val) {
				$val['index'] = (($pindex - 1) * $psize)+$k+1;
				if($this->commission_rank['num']<$val['index']) break;
				$val['gold'] = $this->rankIcon($val['index']);
				$val['commission_total'] = number_format($val['commission_pay'], 2);
				$result_tmp[] = $val;
			}

			$result = $result_tmp;
		}else $result = array();
		return app_json(array('total' => $total, 'list' => $result, 'pagesize' => $psize));
		//show_json(1, array('list' => $result, 'len' => $this->len));
	}

	protected function commissionVirtual($pindex, $psize)
	{
		global $_W;

		if (!is_array($this->commission_rank['content'])) {
			$list = @json_decode($this->commission_rank['content'], true);
		}
		else {
			$list = $this->commission_rank['content'];
		}
		$total = 0;
		if (!empty($list)) {
			$total = count($list);
			usort($list, function($a, $b) {
				$al = (int) $a['commission_total'];
				$bl = (int) $b['commission_total'];

				if ($al == $bl) {
					return 0;
				}

				return $bl < $al ? -1 : 1;
			});
			$list_tmp = array();

			foreach ($list as $k=>$val) {
				$val['index'] = (($pindex - 1) * $psize)+$k+1;
				if($this->commission_rank['num']<$val['index']) break;
				$val['commission_total'] = number_format($val['commission_total'], 2);
				$list_tmp[] = array('index'=>$val['index'], 'gold' => $this->rankIcon($val['index']), 'commission_total' => $val['commission_total'], 'nickname' => $val['nickname'], 'avatar' => tomedia($val['avatar']));
			}

			$list = array_slice($list_tmp, ($pindex - 1) * $psize, $psize);
		}else $list = array();
		return app_json(array('total' => $total, 'list' => $list, 'pagesize' => $psize));
		//show_json(1, array('list' => $list, 'len' => $this->len));
	}
	protected function rankIcon($index=0){
		if($index>=1 && $index<=3) return tomedia('../addons/ewei_shopv2/template/mobile/default/static/images/rank_list_icon_'.$index.'.png');
		else return '';
	}
	public function myshop()
	{
		global $_W,$_GPC;
		$mid = intval($_GPC['mid']);
		$openid = $_W['openid'];
		if (empty($openid)) {
			return app_error('您的身份信息未获取!');
		}
		$member = m('member')->getMember($openid);
		$set = $_W['shopset']['commission'];
		$uniacid = $_W['uniacid'];
		$plugin = p('commission');
		if (!empty($mid)) {
			if (!$plugin->isAgent($mid)) {
				return app_error('用户还不是分销商!');
			}

			if (!empty($set['closemyshop'])) {
				return app_error('小店功能未开放!');
			}
		}
		else {
			if (($member['isagent'] == 1) && ($member['status'] == 1)) {
				$mid = $member['id'];

				if (!empty($set['closemyshop'])) {
					return app_error('小店功能未开放!');
				}
			}
			else {
				return app_error('您还不是分销商!');
			}
		}
		if (empty($shop['img'])) {
			$shop['img'] = $_W['shopset']['shop']['img'];
		}
		$shop = set_medias($plugin->getShop($mid), array('img', 'logo'));

		if (empty($shop['selectgoods'])) {
			$goodscount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and status=1 and deleted=0', array(':uniacid' => $_W['uniacid']));
		}
		else {
			$goodscount = count(explode(',', $shop['goodsids']));
		}
		$shop['goodscount'] = $goodscount;
		//$cubes = $_W['shopset']['shop']['cubes'];
		//$banners = pdo_fetchall('select id,bannername,link,thumb from ' . tablename('ewei_shop_banner') . ' where uniacid=:uniacid and enabled=1 and iswxapp=0 order by displayorder desc', array(':uniacid' => $uniacid));
		//$bannerswipe = $_W['shopset']['shop']['bannerswipe'];

		/*if (!empty($_W['shopset']['shop']['indexrecommands'])) {
			$goodids = implode(',', $_W['shopset']['shop']['indexrecommands']);

			if (!empty($goodids)) {
				$indexrecommands = pdo_fetchall('select id, title, thumb, marketprice, productprice ,minprice, total from ' . tablename('ewei_shop_goods') . ' where id in( ' . $goodids . ' ) and uniacid=:uniacid and status=1 order by displayorder desc', array(':uniacid' => $uniacid));
			}
		}*/

		$goodsstyle = $_W['shopset']['shop']['goodsstyle'];
		$notices = pdo_fetchall('select id, title, link, thumb from ' . tablename('ewei_shop_notice') . ' where uniacid=:uniacid and status=1 order by displayorder desc limit 5', array(':uniacid' => $uniacid));
		$shareid = $mid;
		if (($member['isagent'] == 1) && ($member['status'] == 1)) {
			$shareid = $member['id'];
		}
		$posercount = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('ewei_shop_wxapp_poster') . ' WHERE uniacid=:uniacid AND status=1', array(':uniacid' => $_W['uniacid']));
		$shop['postercount'] = intval($posercount);
		$_W['shopshare'] = array('title' => $shop['name']?$shop['name']:$member['nickname'].'的小店', 'imgUrl' => $shop['logo'], 'desc' => $shop['desc'], 'link' => mobileUrl('commission/myshop', array('mid' => $shareid), true));
		return app_json(array('myshop' => $shop, 'share' => $_W['shopshare']));
	}
	public function myshopgoods()
	{
		global $_W,$_GPC;
		$mid = intval($_GPC['mid']);

		if (empty($mid)) {
			$mid = m('member')->getMid();
		}
		$plugin = p('commission');
		$shop = $plugin->getShop($mid);
		$args = array('page' => $_GPC['page'], 'pagesize' => 10, 'nocommission' => 0, 'order' => 'displayorder desc,createtime desc', 'by' => '');

		if (!empty($shop['selectgoods'])) {
			$goodsids = explode(',', $shop['goodsids']);

			if (!empty($goodsids)) {
				$args['ids'] = trim($shop['goodsids']);
			}
			else {
				$args['isrecommand'] = 1;
			}
		}

		$list = m('goods')->getList($args);
		return app_json(array('list' => $list['list'], 'total' => $list['total'], 'pagesize' => $args['pagesize']));
	}
}

?>
