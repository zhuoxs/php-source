<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Goods_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$groupsset = pdo_fetch('select description,groups_description,discount,headstype,headsmoney,headsdiscount from ' . tablename('ewei_shop_groups_set') . '
					where uniacid = :uniacid ', array(':uniacid' => $uniacid));
		$goods = pdo_fetch('select id,gid,title,stock,price,single,singleprice,units,freight,groupsprice,groupnum,endtime,sales,teamnum,thumb,thumb_url,description,content,more_spec,is_ladder,goodsid,deduct,isdiscount,discount,headstype,headsmoney,headsdiscount from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $uniacid, ':status' => 1));
		if (empty($id) || empty($goods)) {
			return app_error('您查找的商品不存在或已删除');
		}

		if (!empty($goods['thumb_url'])) {
			$goods['thumb_url'] = array_merge(iunserializer($goods['thumb_url']));
		}

		$goods['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid));
		$goods['sales'] = $goods['sales'] + $goods['fightnum'];
		$goods['fightnum'] = $goods['teamnum'] + $goods['fightnum'];
		$goods = set_medias($goods, 'thumb');
		$goods['thumb_url'] = set_medias($goods['thumb_url']);

		if (!empty($groupsset['discount'])) {
			if (empty($goods['discount'])) {
				$goods['headstype'] = $groupsset['headstype'];
				$goods['headsmoney'] = $groupsset['headsmoney'];
				$goods['headsdiscount'] = $groupsset['headsdiscount'];
			}

			if ($goods['groupsprice'] < $goods['headsmoney']) {
				$goods['headsmoney'] = $goods['groupsprice'];
			}
		}

		if ($groupsset['description'] == 1) {
			$goods['content'] = m('common')->html_to_images($groupsset['groups_description']);
		}
		else {
			$goods['content'] = m('common')->html_to_images($goods['content']);
		}

		$ladder = array();

		if ($goods['is_ladder'] == 1) {
			$ladder = pdo_getall('ewei_shop_groups_ladder', array('goods_id' => $id, 'uniacid' => $_W['uniacid']));
		}

		return app_json(array('data' => $goods, 'ladder' => $ladder));
	}

	public function get_spec()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$specArr = array();
		$group_goods = pdo_get('ewei_shop_groups_goods', array('id' => $id, 'uniacid' => $_W['uniacid']));

		if (empty($group_goods)) {
			return app_error('缺少商品');
		}

		$specArr = pdo_getall('ewei_shop_goods_spec', array('goodsid' => $group_goods['gid'], 'uniacid' => $_W['uniacid']), array('id', 'title'), '', array('displayorder asc'));

		foreach ($specArr as $k => $v) {
			$specArr[$k]['item'] = pdo_getall('ewei_shop_goods_spec_item', array('uniacid' => $_W['uniacid'], 'specid' => $v['id']), array('id', 'specid', 'title', 'thumb'), '', array('displayorder asc'));
		}

		return app_json(array('data' => $specArr));
	}

	public function get_option()
	{
		global $_W;
		global $_GPC;
		$specArr = $_GPC['spec_id'];
		asort($specArr);
		$groups_goods_id = $_GPC['groups_goods_id'];

		if (!empty($specArr)) {
			$spec_id = implode('_', $specArr);
			$goods_option = pdo_get('ewei_shop_groups_goods_option', array('groups_goods_id' => $groups_goods_id, 'specs' => $spec_id, 'uniacid' => $_W['uniacid']));
			return app_json(array('data' => $goods_option));
		}
	}

	public function openGroups()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error('你访问的商品不存在或已删除!');
		}

		$goods = pdo_fetch('select id,title,price,groupsprice,goodsnum,units,groupnum,teamnum,thumb,more_spec,is_ladder,isdiscount,discount,headstype,headsmoney,headsdiscount from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':status' => 1));
		$goods['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 ', array(':goodid' => $goods['id'], ':uniacid' => $_W['uniacid']));
		$goods['fightnum'] = $goods['teamnum'] + $goods['fightnum'];
		$goods = set_medias($goods, 'thumb');
		$teams = pdo_fetchall('select id,title,price,groupsprice,goodsnum,units,groupnum,teamnum,thumb,more_spec,headstype,headsmoney,headsdiscount from ' . tablename('ewei_shop_groups_goods') . ' where deleted = 0 and status = 1 and uniacid = :uniacid order by sales desc limit 4', array(':uniacid' => $_W['uniacid']));

		foreach ($teams as $key => $value) {
			$value['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 ', array(':goodid' => $value['id'], ':uniacid' => $_W['uniacid']));
			$value['fightnum'] = $value['teamnum'] + $value['fightnum'];
			$value = set_medias($value, 'thumb');
			$teams[$key] = $value;
		}

		$ladder = array();

		if ($goods['is_ladder'] == 1) {
			$ladder = pdo_getall('ewei_shop_groups_ladder', array('goods_id' => $goods['id'], 'uniacid' => $_W['uniacid']));
		}

		if (empty($goods)) {
			return app_error('商品已下架或被删除!');
		}

		return app_json(array('data' => $goods, 'teams' => $teams, 'ladder' => $ladder));
	}

	public function fight_groups()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$ladder_id = intval($_GPC['ladder_id']);

		if (empty($id)) {
			return app_error(1, '你访问的商品不存在或已删除!');
		}

		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
					where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $uniacid, ':status' => 1));

		if (empty($goods)) {
			return app_error(1, '你访问的商品不存在或已删除!');
		}

		if (!empty($goods)) {
			$goods['fightnum'] = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where goodid = :goodid and uniacid = :uniacid and deleted = 0 and is_team = 1 and status > 0 and ladder_id = :ladder_id ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid, ':ladder_id' => $ladder_id));
			$goods['fightnum'] = $goods['teamnum'] + $goods['fightnum'];
		}

		$goods = set_medias($goods, 'thumb');
		$teams = pdo_fetchall('select o.paytime,o.id,o.goodid,o.teamid,m.nickname,m.realname,m.mobile,m.avatar,g.endtime,g.groupnum,g.thumb_url from ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_member') . ' as m on m.openid=o.openid and m.uniacid =  o.uniacid
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				where o.goodid = :goodid and o.uniacid = :uniacid and o.openid != :openid and o.deleted = 0 and o.heads = 1 and o.paytime > 0 and o.success = 0 and o.ladder_id = :ladder_id limit 10 ', array(':goodid' => $goods['id'], ':uniacid' => $uniacid, ':openid' => $openid, 'ladder_id' => $ladder_id));

		foreach ($teams as $key => $value) {
			$num = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' where uniacid = :uniacid and deleted = 0 and teamid = :teamid and status > 0 ', array(':teamid' => $value['teamid'], ':uniacid' => $uniacid));

			if (!empty($ladder_id)) {
				$ladder = pdo_get('ewei_shop_groups_ladder', array('id' => $ladder_id));
				$value['num'] = $ladder['ladder_num'] - $num;
			}
			else {
				$value['num'] = $value['groupnum'] - $num;
			}

			$value['residualtime'] = $value['paytime'] + $value['endtime'] * 60 * 60 - time();
			$value['hour'] = intval($value['residualtime'] / 3600);
			$value['minite'] = intval($value['residualtime'] / 60 % 60);
			$value['second'] = intval($value['residualtime'] % 60);
			$teams[$key] = $value;
		}

		return app_json(array('data' => $goods, 'other' => $teams));
	}

	public function check_tuan()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$goods_id = intval($_GPC['id']);
		$openid = $_W['openid'];
		$ladder_id = $_GPC['ladder_id'];
		$data = array();

		if ($ladder_id) {
			$data['ladder_num'] = pdo_count('ewei_shop_groups_order', 'uniacid = ' . $uniacid . ' and goodid = ' . $goods_id . ' and heads = 1 and success = 0 and openid != \'' . $openid . '\' and ladder_id = ' . $ladder_id);
		}

		$data['order_num'] = pdo_count('ewei_shop_groups_order', 'uniacid = ' . $uniacid . ' and goodid = ' . $goods_id . ' and heads = 1 and success = 0 and openid != \'' . $openid . '\'');
		return app_json(array('data' => $data));
	}

	public function goodsCheck()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$type = $_GPC['type'];
		$open_id = $_W['openid'];

		if (empty($id)) {
			return app_error(1, '商品不存在');
		}

		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_groups_goods') . '
	  			where id = :id and status = :status and uniacid = :uniacid and deleted = 0 order by displayorder desc', array(':id' => $id, ':uniacid' => $uniacid, ':status' => 1));

		if (empty($goods)) {
			return app_error(1, '商品不存在');
		}

		if ($goods['stock'] <= 0) {
			return app_error(1, '您选择的商品库存不足，请浏览其他商品或联系商家！');
		}

		if (empty($goods['status'])) {
			return app_error(1, '您选择的商品已经下架，请浏览其他商品或联系商家！');
		}

		$ordernum = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_groups_order') . ' as o
			where openid = :openid and status >= :status and goodid = :goodid and uniacid = :uniacid ', array(':openid' => $open_id, ':status' => 0, ':goodid' => $id, ':uniacid' => $uniacid));
		if (!empty($goods['purchaselimit']) && $goods['purchaselimit'] <= $ordernum) {
			return app_error(1, '您已到达此商品购买上限，请浏览其他商品或联系商家！');
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_groups_order') . '
                where goodid = :goodid and status >= 0  and openid = :openid and uniacid = :uniacid and success = 0 and deleted = 0 order by createtime desc', array(':goodid' => $id, ':openid' => $open_id, ':uniacid' => $uniacid));
		if ($order && $order['status'] == 0) {
			return app_error(1, '您的订单已存在，请尽快完成支付！');
		}

		if ($order && $order['is_team'] == 1 && $type != 'single' && $order['status'] == 1) {
			return app_error(1, '您已经参与了该团，请等待拼团结束后再进行购买！');
		}

		if ($type == 'single') {
			if (empty($goods['single'])) {
				return app_error(1, '商品不允许单购，请重新选择！');
			}
		}

		$specArr = array();

		if ($goods['more_spec'] == 1) {
			$group_goods = pdo_get('ewei_shop_groups_goods', array('id' => $id, 'uniacid' => $_W['uniacid']));

			if (empty($group_goods['gid'])) {
				return app_error(1, '缺少商品');
			}
		}

		return app_json();
	}

	public function play()
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$rules = pdo_fetch('select rules from ' . tablename('ewei_shop_groups_set') . '
					where uniacid = :uniacid ', array(':uniacid' => $uniacid));
		return app_json(array('rules' => $rules['rules']));
	}
}

?>
