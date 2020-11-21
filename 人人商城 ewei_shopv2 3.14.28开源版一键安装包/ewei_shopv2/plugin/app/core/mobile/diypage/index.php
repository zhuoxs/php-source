<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pageid = intval($_GPC['id']);

		if (empty($pageid)) {
			$pageid = trim($_GPC['type']);
		}

		if (empty($pageid)) {
			return app_error(AppError::$PageNotFound);
		}

		$page = $this->model->getPage($pageid, true);

		if ($page === 'default') {
			return app_json(array('diypage' => false));
		}

		if (empty($page) || empty($page['data'])) {
			return app_error(AppError::$PageNotFound);
		}

		$startadv = array();
		if (is_array($page['data']['page']) && !empty($page['data']['page']['diyadv'])) {
			$startadvitem = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_startadv') . ' WHERE id=:id AND uniacid=:uniacid', array(':id' => intval($page['data']['page']['diyadv']), ':uniacid' => $_W['uniacid']));
			if (!empty($startadvitem) && !empty($startadvitem['data'])) {
				$startadv = base64_decode($startadvitem['data']);
				$startadv = json_decode($startadv, true);
				$startadv['status'] = intval($startadvitem['status']);

				if (!empty($startadv['data'])) {
					foreach ($startadv['data'] as $itemid => &$item) {
						$item['imgurl'] = tomedia($item['imgurl']);
					}

					unset($itemid);
					unset($item);
				}

				if (is_array($startadv['params'])) {
					$startadv['params']['style'] = 'small-bot';
				}

				if (is_array($startadv['style'])) {
					$startadv['style']['opacity'] = '0.6';
				}
			}
		}

		$result = array('diypage' => $page['data'], 'startadv' => $startadv, 'customer' => intval($_W['shopset']['app']['customer']), 'phone' => intval($_W['shopset']['app']['phone']));

		if (!empty($result['customer'])) {
			$result['customercolor'] = empty($_W['shopset']['app']['customercolor']) ? '#ff5555' : $_W['shopset']['app']['customercolor'];
		}

		if (!empty($result['phone'])) {
			$result['phonecolor'] = empty($_W['shopset']['app']['phonecolor']) ? '#ff5555' : $_W['shopset']['app']['phonecolor'];
			$result['phonenumber'] = empty($_W['shopset']['app']['phonenumber']) ? '#ff5555' : $_W['shopset']['app']['phonenumber'];
		}

		return app_json($result);
	}

	public function main2()
	{
		global $_W;
		global $_GPC;
		$diypage = p('diypage');

		if (!$diypage) {
			return app_error(AppError::$PluginNotFound);
		}

		$pagetype = trim($_GPC['type']);

		if (!empty($pagetype)) {
			$pageid = $this->type2Pageid($pagetype);
		}
		else {
			$pageid = intval($_GPC['id']);
		}

		if (empty($pageid)) {
			return app_error(AppError::$PageNotFound);
		}

		$page = $diypage->getPage($pageid, true);
		if (empty($page) || empty($page['data'])) {
			return app_error(AppError::$PageNotFound);
		}

		return app_json(array('diypage' => $page['data']));
	}

	/**
     * 根据type获取id
     * @param null $type
     * @return int
     */
	public function type2Pageid($type = NULL)
	{
		if (empty($type)) {
			return 0;
		}

		$set = m('common')->getPluginset('diypage');
		$pageset = $set['page'];
		$pageid = intval($pageset[$type . '_wxapp']);
		return $pageid;
	}

	public function getInfo()
	{
		global $_GPC;
		global $_W;
		$dataurl = $_GPC['dataurl'];
		$set = m('common')->getPluginset('commission');
		$level = $this->getLevel($_W['openid']);

		if (empty($dataurl)) {
			return app_json(array(
				'goods' => array(),
				'type'  => 'stores'
			));
		}

		if (!empty($_GPC['num']) && $_GPC['paramsType'] == 'stores') {
			$storenum = 6 + intval($_GPC['num']);
		}
		else {
			$storenum = 6;
		}

		if (!empty($_GPC['num']) && $_GPC['paramsType'] == 'goods') {
			$goodsnum = 20 + intval($_GPC['num']);
		}
		else {
			$goodsnum = 20;
		}

		if (!empty($dataurl)) {
			if (strpos($dataurl, '/pages/') === false) {
				$dataParams = explode('=', $dataurl);

				if ($dataParams[0] == 'category') {
					$pcate = $dataParams[1];
					$goodsql = 'SELECT id,displayorder,title,subtitle,thumb,marketprice,hascommission,nocommission,commission,commission1_rate,commission1_rate,marketprice,commission1_pay,maxprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video FROM ' . tablename('ewei_shop_goods') . ' WHERE FIND_IN_SET(' . $pcate . ',cates) AND status = 1 AND deleted = 0 AND uniacid =' . $_W['uniacid'] . ' ORDER BY displayorder DESC' . ' limit 0,' . $goodsnum;
					$count = pdo_fetch('SELECT count(id) as count FROM ' . tablename('ewei_shop_goods') . ' WHERE FIND_IN_SET(' . $pcate . ',cates) AND status = 1 AND deleted = 0 AND uniacid =' . $_W['uniacid']);
					$list['list'] = pdo_fetchall($goodsql);
					$list['count'] = $count['count'];

					foreach ($list['list'] as $k => $v) {
						$list['list'][$k]['thumb'] = tomedia($v['thumb']);

						if ($v['hasoption'] == 1) {
							$pricemax = array();
							$options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and                               uniacid=:uniacid order by displayorder asc', array(':goodsid' => $v['id'], ':uniacid' => $_W['uniacid']));

							foreach ($options as $ke => $va) {
								array_push($pricemax, $va['marketprice']);
							}

							$v['marketprice'] = max($pricemax);
						}

						if ($v['nocommission'] == 0) {
							if (p('seckill')) {
								if (p('seckill')->getSeckill($v['id'])) {
									continue;
								}
							}

							if (0 < $v['bargain']) {
								continue;
							}

							$list['list'][$k]['seecommission'] = $this->getCommission($v, $level, $set);

							if (0 < $list['list'][$k]['seecommission']) {
								$list['list'][$k]['seecommission'] = round($list['list'][$k]['seecommission'], 2);
							}

							$list['list'][$k]['cansee'] = $set['cansee'];
							$list['list'][$k]['seetitle'] = $set['seetitle'];
						}
						else {
							$list['list'][$k]['seecommission'] = 0;
							$list['list'][$k]['cansee'] = $set['cansee'];
							$list['list'][$k]['seetitle'] = $set['seetitle'];
						}
					}

					return app_json(array('goods' => $list, 'type' => 'goods'));
				}

				if ($dataParams[0] == 'groups') {
					$sql = 'SELECT * FROM ' . tablename('ewei_shop_goods_group') . ' WHERE id = :id AND uniacid = :uniacid';
					$params = array(':uniacid' => $_W['uniacid'], ':id' => $dataParams[1]);
					$groupsData = pdo_fetch($sql, $params);
					$goodsid = $groupsData['goodsids'];
					$goodsql = 'SELECT id,displayorder,title,subtitle,thumb,hascommission,nocommission,commission,commission1_rate,commission1_rate,marketprice,commission1_pay,maxprice,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video FROM ' . tablename('ewei_shop_goods') . ' WHERE id in(' . $goodsid . ') AND status = 1 AND deleted = 0 AND uniacid =' . $_W['uniacid'] . ' ORDER BY displayorder DESC' . ' limit 0,' . $goodsnum;
					$count = pdo_fetch('SELECT count(id) as count FROM ' . tablename('ewei_shop_goods') . ' WHERE id in(' . $goodsid . ') AND status = 1 AND deleted = 0 AND uniacid =' . $_W['uniacid']);
					$list['list'] = pdo_fetchall($goodsql);
					$list['count'] = $count['count'];

					foreach ($list['list'] as $k => $v) {
						$list['list'][$k]['thumb'] = tomedia($v['thumb']);

						if ($v['hasoption'] == 1) {
							$pricemax = array();
							$options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and                               uniacid=:uniacid order by displayorder asc', array(':goodsid' => $v['id'], ':uniacid' => $_W['uniacid']));

							foreach ($options as $ke => $va) {
								array_push($pricemax, $va['marketprice']);
							}

							$v['marketprice'] = max($pricemax);
						}

						if ($v['nocommission'] == 0) {
							if (p('seckill')) {
								if (p('seckill')->getSeckill($v['id'])) {
									continue;
								}
							}

							if (0 < $v['bargain']) {
								continue;
							}

							$list['list'][$k]['seecommission'] = $this->getCommission($v, $level, $set);

							if (0 < $list['list'][$k]['seecommission']) {
								$list['list'][$k]['seecommission'] = round($list['list'][$k]['seecommission'], 2);
							}

							$list['list'][$k]['cansee'] = $set['cansee'];
							$list['list'][$k]['seetitle'] = $set['seetitle'];
						}
						else {
							$list['list'][$k]['seecommission'] = 0;
							$list['list'][$k]['cansee'] = $set['cansee'];
							$list['list'][$k]['seetitle'] = $set['seetitle'];
						}
					}

					return app_json(array('goods' => $list, 'type' => 'goods'));
				}

				if ($dataParams[0] == 'goodsids') {
					$goodsids = explode(',', $dataParams[1]);

					if (!empty($goodsids)) {
						foreach ($goodsids as $gk => $gv) {
							if ($gv == '') {
								unset($goodsids[$gk]);
							}
						}

						$goodsid = implode(',', $goodsids);
						$sql = 'SELECT id,displayorder,title,subtitle,thumb,marketprice,hascommission,nocommission,commission,commission1_rate,commission1_rate,marketprice,commission1_pay,maxprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video FROM ' . tablename('ewei_shop_goods') . ' WHERE id in(' . $goodsid . ') AND uniacid =' . $_W['uniacid'] . ' ORDER BY displayorder DESC' . ' limit 0,' . $goodsnum;
						$count = pdo_fetch('SELECT count(id) as count FROM ' . tablename('ewei_shop_goods') . ' WHERE id in(' . $goodsid . ') AND uniacid =' . $_W['uniacid']);
						$list['list'] = pdo_fetchall($sql);
						$list['count'] = $count['count'];

						foreach ($list['list'] as $k => $v) {
							$list['list'][$k]['thumb'] = tomedia($v['thumb']);

							if ($v['hasoption'] == 1) {
								$pricemax = array();
								$options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and                               uniacid=:uniacid order by displayorder asc', array(':goodsid' => $v['id'], ':uniacid' => $_W['uniacid']));

								foreach ($options as $ke => $va) {
									array_push($pricemax, $va['marketprice']);
								}

								$v['marketprice'] = max($pricemax);
							}

							if ($v['nocommission'] == 0) {
								if (p('seckill')) {
									if (p('seckill')->getSeckill($v['id'])) {
										continue;
									}
								}

								if (0 < $v['bargain']) {
									continue;
								}

								$list['list'][$k]['seecommission'] = $this->getCommission($v, $level, $set);

								if (0 < $list['list'][$k]['seecommission']) {
									$list['list'][$k]['seecommission'] = round($list['list'][$k]['seecommission'], 2);
								}

								$list['list'][$k]['cansee'] = $set['cansee'];
								$list['list'][$k]['seetitle'] = $set['seetitle'];
							}
							else {
								$list['list'][$k]['seecommission'] = 0;
								$list['list'][$k]['cansee'] = $set['cansee'];
								$list['list'][$k]['seetitle'] = $set['seetitle'];
							}
						}

						return app_json(array('goods' => $list, 'type' => 'goods'));
					}
				}
				else {
					if ($dataParams[0] == 'stores') {
						$urlValue = explode('?', $dataParams[1]);
						$storesids = explode(',', $urlValue[0]);

						if (!empty($storesids)) {
							foreach ($storesids as $gk => $gv) {
								if ($gv == '') {
									unset($storesids[$gk]);
								}
							}

							$storesid = implode(',', $storesids);
							$sql = 'SELECT id,storename,displayorder FROM ' . tablename('ewei_shop_store') . ' WHERE id in(' . $storesid . ') AND uniacid =' . $_W['uniacid'] . ' ORDER BY displayorder DESC' . ' limit 0,' . $storenum;
							$count = pdo_fetch('SELECT count(id) as count FROM ' . tablename('ewei_shop_store') . ' WHERE id in(' . $storesid . ') AND uniacid =' . $_W['uniacid']);
							$list['list'] = pdo_fetchall($sql);
							$list['count'] = $count['count'];
							return app_json(array('goods' => $list, 'type' => 'stores'));
						}
					}
				}
			}
		}
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
				$commission = 1 <= $set['level'] ? round($level['commission1'] * $goods['marketprice'] / 100, 2) : 0;
			}
			else {
				$commission = 1 <= $set['level'] ? round($set['commission1'] * $goods['marketprice'] / 100, 2) : 0;
			}
		}

		return $commission;
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
}

?>
