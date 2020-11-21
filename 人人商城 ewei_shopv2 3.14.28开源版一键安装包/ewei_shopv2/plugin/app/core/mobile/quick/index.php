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
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM' . tablename('ewei_shop_quick') . ' WHERE id=:id AND uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$datas = htmlspecialchars_decode(base64_decode($item['datas']));
		$merchid = empty($item['merchid']) ? 0 : intval($item['merchid']);
		$data = $this->mobile($datas, $merchid);

		if (empty($data['template'])) {
			$data['cartList'] = $this->getAllCart(!empty($data['cartdata']) ? $item['id'] : 0, false);
		}
		else {
			$data['cartList'] = $this->getAllCart(0, false);
		}

		foreach ($data['goodsArr'] as $k => $goodsInfo) {
			foreach ($goodsInfo as $key => $value) {
				if (!empty($data['cartList'])) {
					$cartTotal = 0;

					foreach ($data['cartList']['list'] as $cartInfo) {
						if ($cartInfo['goodsid'] == $value['id']) {
							$cartTotal += $cartInfo['total'];
						}
					}
				}

				$data['goodsArr'][$k][$key]['cartTotal'] = $cartTotal;
			}
		}

		return app_json($data);
	}

	/**
     * 处理一下数据
     * @param $data
     * @param int $merchid
     * @return array|mixed
     */
	public function mobile($data, $merchid = 0)
	{
		global $_W;

		if (empty($data)) {
			return $data;
		}

		if (!is_array($data)) {
			$data = json_decode($data, true);
		}

		if (!is_array($data) || !is_array($data['datas']) || empty($data['datas'])) {
			return $data;
		}

		foreach ($data['datas'] as $index => &$item) {
			if ($item['datatype'] == 0) {
				unset($item['data']);
				unset($item['cateid']);
				unset($item['catename']);
				unset($item['groupid']);
				unset($item['groupname']);

				if (!empty($item['goodsids'])) {
					$item['goodsids'] = implode(',', $item['goodsids']);
				}
			}
			else if ($item['datatype'] == 1) {
				unset($item['data']);
				unset($item['goodsids']);
				unset($item['catename']);
				unset($item['groupid']);
				unset($item['groupname']);
			}
			else {
				if ($item['datatype'] == 2) {
					unset($item['data']);
					unset($item['goodsids']);
					unset($item['cateid']);
					unset($item['catename']);
					unset($item['groupname']);
				}
			}

			$item['page'] = 1;
			$item['num'] = 0;
		}

		unset($item);
		$template = $data['template'];
		$returnData = array('template' => $template, 'style' => $data['style'][$template], 'pagetitle' => empty($data['pagetitle']) ? '快速购买' : $data['pagetitle']);

		if ($template == 1) {
			$returnData['style']['shopbg'] = tomedia($returnData['style']['shopbg']);
			$returnData['style']['shoplogo'] = tomedia($_W['shopset']['shop']['logo']);
		}

		if ($data['template'] == 0) {
			$returnData['cartdata'] = intval($data['cartdata']);
			$returnData['group'] = $data['datas'];
			$newDatas = array();

			if (!empty($data['datas'])) {
				foreach ($data['datas'] as $index => $d) {
					$returnData['group'][$index]['type'] = 'group' . $index;
					$datatype = $d['datatype'];
					$orderby = '';
					$goodssort = $d['goodssort'];
					if ($d['datatype'] == 1 || $d['datatype'] == 2) {
						if ($goodssort == 1) {
							$orderby = ' sales desc, displayorder desc';
						}
						else if ($goodssort == 2) {
							$orderby = ' minprice desc, displayorder desc';
						}
						else {
							if ($goodssort == 3) {
								$orderby = ' minprice asc, displayorder desc';
							}
						}
					}

					if ($datatype == 0) {
						if (is_string($d['goodsids'])) {
							$goodsids = trim($d['goodsids']);
						}

						if (!empty($goodsids)) {
							$goodslist = $this->getList(array('ids' => $goodsids));
							$newDatas['group' . $index] = $this->sort($goodsids, $goodslist['list']);
						}
					}
					else if ($datatype == 1) {
						$cateid = intval($d['cateid']);

						if (!empty($cateid)) {
							$goodslist = $this->getList(array('cate' => $cateid, 'merchid' => $merchid, 'order' => $orderby));
							$newDatas['group' . $index] = $goodslist['list'];
						}
					}
					else if ($datatype == 2) {
						$groupid = intval($d['groupid']);

						if (!empty($groupid)) {
							$group = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_group') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid and enabled=1 limit 1 ', array(':id' => $groupid, ':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
							$goodsids = $group['goodsids'];

							if (!empty($goodsids)) {
								$goodslist = $this->getList(array('ids' => $goodsids, 'order' => $orderby));
								$newDatas['group' . $index] = $goodslist['list'];
							}
						}
					}
					else {
						$newDatas['group' . $index] = array();
					}
				}
			}

			$returnData['goodsArr'] = $newDatas;
			if ($data['showadv'] == 2 && !empty($data['advs'])) {
				$returnData['advs'] = array();

				foreach ($data['advs'] as $advitem) {
					$returnData['advs'][] = array('link' => $advitem['linkurl'], 'thumb' => tomedia($advitem['imgurl']));
				}

				unset($advitem);
			}
		}
		else {
			$returnData['group'] = $data['datas'];
			$newDatas = array();

			if (!empty($data['datas'])) {
				foreach ($data['datas'] as $index => $d) {
					$returnData['group'][$index]['type'] = 'group' . $index;
					$orderby = '';
					if ($d['datatype'] == 1 || $d['datatype'] == 2) {
						if ($d['goodssort'] == 1) {
							$orderby = ' sales desc, displayorder desc';
						}
						else if ($d['goodssort'] == 2) {
							$orderby = ' minprice desc, displayorder desc';
						}
						else {
							if ($d['goodssort'] == 3) {
								$orderby = ' minprice asc, displayorder desc';
							}
						}
					}

					if ($d['datatype'] == 2 && !empty($d['groupid'])) {
						$group = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_group') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid and enabled=1 limit 1 ', array(':id' => $d['groupid'], ':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
						$goodsids = $group['goodsids'];
						$pagesize = !empty($d['goodsnum']) ? $d['goodsnum'] : 5;

						if (!empty($goodsids)) {
							$goodslist = $this->getList(array('ids' => $goodsids, 'pagesize' => $pagesize, 'order' => $orderby));
							$newDatas['group' . $index] = $goodslist['list'];
						}
					}
					else {
						if ($d['datatype'] == 1 && !empty($d['cateid'])) {
							$pagesize = !empty($d['goodsnum']) ? $d['goodsnum'] : 5;
							$goodslist = $this->getList(array('cate' => $d['cateid'], 'order' => $orderby, 'pagesize' => $pagesize, 'page' => 1));
							$newDatas['group' . $index] = $goodslist['list'];
						}
						else {
							if ($d['datatype'] == 0 && !empty($d['goodsids'])) {
								$goodslist = $this->getList(array('ids' => $d['goodsids'], 'order' => $orderby));
								$newDatas['group' . $index] = $this->sort($d['goodsids'], $goodslist['list']);
							}
							else {
								$newDatas['group' . $index] = array();
							}
						}
					}
				}
			}

			$returnData['goodsArr'] = $newDatas;

			if ($returnData['style']['notice'] == 1) {
				$limit = !empty($returnData['style']['noticenum']) ? $returnData['style']['noticenum'] : 5;

				if (0 < $merchid) {
					$returnData['notices'] = pdo_fetchall('SELECT id, title FROM' . tablename('ewei_shop_merch_notice') . 'WHERE uniacid=:uniacid AND status=1 AND merchid=:merchid LIMIT ' . $limit, array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$returnData['notices'] = pdo_fetchall('SELECT id, title FROM' . tablename('ewei_shop_notice') . 'WHERE uniacid=:uniacid AND status=1 AND iswxapp=0 LIMIT ' . $limit, array(':uniacid' => $_W['uniacid']));
				}
			}
			else {
				if ($returnData['style']['notice'] == 2 && !empty($data['notices'])) {
					$returnData['notices'] = $data['notices'];
				}
			}

			$returnData['shopmenu'] = $data['shopmenu'];
			$returnData['diymenu'] = $data['diymenu'];
		}

		return $returnData;
	}

	/**
     * 获取商品列表
     * @param $args
     * @return array
     */
	public function getList($args)
	{
		global $_W;
		$page = !empty($args['page']) ? intval($args['page']) : 1;
		$merchid = !empty($args['merchid']) ? intval($args['merchid']) : 0;
		$pagesize = !empty($args['pagesize']) ? intval($args['pagesize']) : 50;
		$displayorder = 'displayorder';
		$order = !empty($args['order']) ? $args['order'] : ' ' . $displayorder . ' desc,createtime desc';
		$orderby = empty($args['order']) ? '' : (!empty($args['by']) ? $args['by'] : '');
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		}
		else {
			$is_openmerch = 0;
		}

		$condition = ' and `uniacid` = :uniacid AND `deleted` = 0 and status=1 and bargain=0 and `type`!=4 ';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($merchid)) {
			$condition .= ' and merchid=:merchid and checked=0 ';
			$params[':merchid'] = $merchid;
		}
		else if ($is_openmerch == 0) {
			$condition .= ' and `merchid` = 0';
		}
		else {
			$condition .= ' and `checked` = 0';
		}

		$ids = !empty($args['ids']) ? trim($args['ids']) : '';

		if (!empty($ids)) {
			$condition .= ' and id in ( ' . $ids . ')';
		}

		if (!empty($args['cate'])) {
			$category = m('shop')->getAllCategory();
			$catearr = array($args['cate']);

			foreach ($category as $index => $row) {
				if ($row['parentid'] == $args['cate']) {
					$catearr[] = $row['id'];

					foreach ($category as $ind => $ro) {
						if ($ro['parentid'] == $row['id']) {
							$catearr[] = $ro['id'];
						}
					}
				}
			}

			$catearr = array_unique($catearr);
			$condition .= ' AND ( ';

			foreach ($catearr as $key => $value) {
				if ($key == 0) {
					$condition .= 'FIND_IN_SET(' . $value . ',cates)';
				}
				else {
					$condition .= ' || FIND_IN_SET(' . $value . ',cates)';
				}
			}

			$condition .= ' <>0 )';
		}

		$member = m('member')->getMember($_W['openid']);

		if (!empty($member)) {
			$levelid = intval($member['level']);
			$groupid = $member['groupid'];
			$group_id_arr = explode(',', trim($member['groupid']));
			$group_id_arr = array_filter($group_id_arr);

			if ($group_id_arr) {
				$temp = '';

				foreach ($group_id_arr as $gid) {
					$temp .= 'or FIND_IN_SET( ' . $gid . ',showgroups)<>0 ';
				}
			}
			else {
				$groupid = intval($groupid);
				$temp = 'or FIND_IN_SET( ' . $groupid . ',showgroups)<>0 ';
			}

			$condition .= ' and ( ifnull(showlevels,\'\')=\'\' or FIND_IN_SET( ' . $levelid . ',showlevels)<>0 ) ';
			$condition .= ' and ( ifnull(showgroups,\'\')=\'\' ' . $temp . ' )';
		}
		else {
			$condition .= ' and ifnull(showlevels,\'\')=\'\' ';
			$condition .= ' and   ifnull(showgroups,\'\')=\'\' ';
		}

		$sql = 'SELECT id,title,subtitle,thumb,minprice,marketprice,sales,salesreal,total,bargain,`type`,ispresell,presellend,preselltimeend,hasoption,total,maxbuy,minbuy,usermaxbuy,isverify,cannotrefund,diyformtype,diyformid FROM ' . tablename('ewei_shop_goods') . (' where 1 ' . $condition . ' ORDER BY ' . $order . ' ' . $orderby . ' LIMIT ') . ($page - 1) * $pagesize . ',' . $pagesize;
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . (' where 1 ' . $condition . ' '), $params);
		$list = pdo_fetchall($sql, $params);
		$list = set_medias($list, 'thumb');
		if (!empty($list) && is_array($list)) {
			foreach ($list as $i => &$g) {
				$g['sales'] = $g['sales'] + $g['salesreal'];
				$totalmaxbuy = $g['total'];

				if (0 < $g['maxbuy']) {
					if ($totalmaxbuy != -1) {
						if ($g['maxbuy'] < $totalmaxbuy) {
							$totalmaxbuy = $g['maxbuy'];
						}
					}
					else {
						$totalmaxbuy = $g['maxbuy'];
					}
				}

				if (0 < $g['usermaxbuy']) {
					$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['id'], ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
					$last = $g['usermaxbuy'] - $order_goodscount;

					if ($last <= 0) {
						$last = 0;
					}

					if ($totalmaxbuy != -1) {
						if ($last < $totalmaxbuy) {
							$totalmaxbuy = $last;
						}
					}
					else {
						$totalmaxbuy = $last;
					}
				}

				if (0 < $g['minbuy']) {
					if ($totalmaxbuy < $g['minbuy']) {
						$g['minbuy'] = $totalmaxbuy;
					}
				}

				$g['totalmaxbuy'] = $totalmaxbuy;
				$g['cannotbuy'] = empty($totalmaxbuy) ? '超出最高购买数量' : '';
				$g['unit'] = empty($g['unit']) ? '件' : $g['unit'];
				$g['num'] = 0;
				if (0 < $g['ispresell'] && (0 < $g['presellend'] && time() < $g['preselltimeend'] || $g['preselltimeend'] == 0)) {
					$g['gotodetail'] = 1;
					$g['presell'] = 1;
				}

				if (p('bargain') && !empty($g['bargain']) && empty($g['gotodetail'])) {
					$bargain = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id = :id AND unix_timestamp(start_time)<' . time() . ' AND unix_timestamp(end_time)>' . time() . ' AND status = 0', array(':id' => $g['bargain']));

					if ($bargain) {
						$g['gotodetail'] = 1;
						$g['isbargain'] = 1;
					}
				}

				$g['canAddCart'] = true;
				if ($g['isverify'] == 2 || $g['type'] == 2 || $g['type'] == 3 || $g['type'] == 20 || !empty($g['cannotrefund'])) {
					$g['canAddCart'] = false;
				}

				unset($g['ispresell']);
				unset($g['bargain']);
				unset($g['isverify']);
				unset($g['cannotrefund']);
				unset($g['salesreal']);
				unset($g['type']);
				unset($g['presellend']);
				unset($g['preselltimeend']);
				unset($g['bargain']);
			}

			unset($g);
		}

		return array('list' => $list, 'total' => $total);
	}

	/**
     * 数据选择为手动选择的时候对其进行商品排序
     * @param $ids
     * @param $list
     * @return array
     */
	public function sort($ids, $list)
	{
		if (empty($ids) || empty($list)) {
			return array();
		}

		if (!is_array($ids)) {
			$ids = explode(',', $ids);
			if (!is_array($ids) || empty($ids)) {
				return $list;
			}
		}

		$newArr = array();

		foreach ($ids as $k => $v) {
			foreach ($list as $i => $g) {
				if ($v == $g['id']) {
					$newArr[] = $g;
				}
			}
		}

		return $newArr;
	}

	/**
     * 获取商品数据
     */
	public function get_list()
	{
		global $_W;
		global $_GPC;
		$pagesize = 200;
		$page = max(1, intval($_GPC['page']));
		$datatype = intval($_GPC['datatype']);
		$merchid = intval($_GPC['merchid']);
		$goodssort = intval($_GPC['goodssort']);
		$orderby = '';

		if ($goodssort == 1) {
			$orderby = ' sales desc, displayorder desc';
		}
		else if ($goodssort == 2) {
			$orderby = ' minprice desc, displayorder desc';
		}
		else {
			if ($goodssort == 3) {
				$orderby = ' minprice asc, displayorder desc';
			}
		}

		$result = array(
			'pagesize' => $pagesize,
			'page'     => $page,
			'list'     => array()
		);

		if ($datatype == 0) {
			$goodsids = trim($_GPC['goodsids']);

			if (!empty($goodsids)) {
				$ids = $this->page($goodsids, $pagesize, $page);

				if (!empty($ids)) {
					$goodslist = $this->model->getList(array('ids' => $ids));
					$result['list'] = $this->model->sort($ids, $goodslist['list']);
					$result['total'] = $goodslist['total'];
					$result['pagesize'] = $pagesize;
				}
			}
		}
		else if ($datatype == 1) {
			$cateid = intval($_GPC['cateid']);

			if (!empty($cateid)) {
				$goodslist = $this->model->getList(array('cate' => $cateid, 'page' => $page, 'pagesize' => $pagesize, 'order' => $orderby, 'merchid' => $merchid));
				$result['list'] = $goodslist['list'];
				$result['total'] = $goodslist['total'];
				$result['pagesize'] = $pagesize;
			}
		}
		else {
			if ($datatype == 2) {
				$groupid = intval($_GPC['groupid']);

				if (!empty($groupid)) {
					$group = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_group') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid and enabled=1 limit 1 ', array(':id' => $groupid, ':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
					$goodsids = $group['goodsids'];

					if (!empty($goodsids)) {
						$ids = $this->page($goodsids, $pagesize, $page);

						if (!empty($ids)) {
							$goodslist = $this->model->getList(array('ids' => $ids, 'order' => $orderby));
							$result['list'] = $goodslist['list'];
							$result['total'] = $goodslist['total'];
							$result['pagesize'] = $pagesize;
						}
					}
				}
			}
		}

		return app_json(1, $result);
	}

	/**
     * 获取购物车商品  只有是单独购物车时候
     * @param $pageid
     * @param bool $json
     * @return array|mixed|string
     */
	public function getAllCart($pageid, $json = true)
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$list = array();
		$simple_list = array();
		$condition = ' and f.uniacid= :uniacid and f.openid=:openid and f.deleted=0';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$total = 0;
		$totalprice = 0;
		$ischeckall = true;
		$tablename = empty($pageid) ? 'ewei_shop_member_cart' : 'ewei_shop_quick_cart';

		if (!empty($pageid)) {
			$condition .= ' and quickid=:quickid';
			$params[':quickid'] = $pageid;
		}

		$level = m('member')->getLevel($openid);
		$sql = 'SELECT f.id,f.total,f.goodsid,g.total as stock,g.preselltimeend,g.presellprice as gpprice,g.hasoption, o.stock as optionstock,g.presellprice,g.ispresell, g.maxbuy,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,' . ' g.productprice,o.title as optiontitle,o.presellprice,f.optionid,o.specs,g.minbuy,g.maxbuy,g.unit,f.merchid,g.checked,g.isdiscount,g.isdiscount_discounts,g.isdiscount_time,g.isnodiscount,g.discounts,g.merchsale' . ' ,f.selected FROM ' . tablename($tablename) . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on f.optionid = o.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC ';
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$g) {
			if (0 < $g['ispresell'] && ($g['preselltimeend'] == 0 || time() < $g['preselltimeend'])) {
				$g['marketprice'] = 0 < intval($g['hasoption']) ? $g['presellprice'] : $g['gpprice'];
			}

			$g['thumb'] = tomedia($g['thumb']);
			$seckillinfo = plugin_run('seckill::getSeckill', $g['goodsid'], $g['optionid'], true, $_W['openid']);

			if (!empty($g['optionid'])) {
				$g['stock'] = $g['optionstock'];

				if (!empty($g['specs'])) {
					$thumb = m('goods')->getSpecThumb($g['specs']);

					if (!empty($thumb)) {
						$g['thumb'] = tomedia($thumb);
					}
				}
			}

			if ($g['selected']) {
				$prices = m('order')->getGoodsDiscountPrice($g, $level, 1);
				$total += $g['total'];
				$g['marketprice'] = $g['ggprice'] = $prices['price'];
				if ($seckillinfo && $seckillinfo['status'] == 0) {
					$seckilllast = 0;

					if (0 < $seckillinfo['maxbuy']) {
						$seckilllast = $seckillinfo['maxbuy'] - $seckillinfo['selfcount'];
					}

					$normal = $g['total'] - $seckilllast;

					if ($normal <= 0) {
						$normal = 0;
					}

					$totalprice += $seckillinfo['price'] * $seckilllast + $g['marketprice'] * $normal;
					$g['seckillmaxbuy'] = $seckillinfo['maxbuy'];
					$g['seckillselfcount'] = $seckillinfo['selfcount'];
					$g['seckillprice'] = $seckillinfo['price'];
					$g['seckilltag'] = $seckillinfo['tag'];
					$g['seckilllast'] = $seckilllast;
				}
				else {
					$totalprice += $g['marketprice'] * $g['total'];
				}
			}

			$totalmaxbuy = $g['stock'];
			if ($seckillinfo && $seckillinfo['status'] == 0) {
				if ($g['seckilllast'] < $totalmaxbuy) {
					$totalmaxbuy = $g['seckilllast'];
				}

				if ($totalmaxbuy < $g['total']) {
					$g['total'] = $totalmaxbuy;
				}

				$g['minbuy'] = 0;
			}
			else {
				if (0 < $g['maxbuy']) {
					if ($totalmaxbuy != -1) {
						if ($g['maxbuy'] < $totalmaxbuy) {
							$totalmaxbuy = $g['maxbuy'];
						}
					}
					else {
						$totalmaxbuy = $g['maxbuy'];
					}
				}

				if (0 < $g['usermaxbuy']) {
					$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));
					$last = $g['usermaxbuy'] - $order_goodscount;

					if ($last <= 0) {
						$last = 0;
					}

					if ($totalmaxbuy != -1) {
						if ($last < $totalmaxbuy) {
							$totalmaxbuy = $last;
						}
					}
					else {
						$totalmaxbuy = $last;
					}
				}

				if (0 < $g['minbuy']) {
					if ($totalmaxbuy < $g['minbuy']) {
						$g['minbuy'] = $totalmaxbuy;
					}
				}
			}

			$g['totalmaxbuy'] = $totalmaxbuy;
			$g['unit'] = empty($g['unit']) ? '件' : $g['unit'];

			if (empty($g['selected'])) {
				$ischeckall = false;
			}

			$g['total'] = intval($g['total']);
			$g['totalmaxbuy'] = intval($g['totalmaxbuy']);

			if ($g['total'] == $g['totalmaxbuy']) {
				$g['dismax'] = 1;
			}

			if ($g['total'] == $g['minbuy']) {
				$g['dismin'] = 1;
			}

			if (!isset($simple_list[$g['goodsid']])) {
				$simple_list[$g['goodsid']] = 0;
			}

			$simple_list[$g['goodsid']] += $g['total'];
			unset($g['checked']);
			unset($g['discounts']);
			unset($g['isdiscount']);
			unset($g['isdiscount_discounts']);
			unset($g['isdiscount_time']);
			unset($g['isnodiscount']);
			unset($g['selected']);
			unset($g['thumb']);
		}

		unset($g);
		$list = set_medias($list, 'thumb');

		foreach ($list as $k => $info) {
			$list[$k]['priceTotal'] = round($info['total'] * $info['ggprice'], 2);
		}

		$result = array('list' => $list, 'simple_list' => $simple_list, 'total' => $total, 'totalprice' => round($totalprice, 2));

		if ($json) {
			return json_encode($result);
		}

		return $result;
	}

	/**
     * @param $goodsids
     * @param $pagesize
     * @param $page
     * @return string
     */
	protected function page($goodsids, $pagesize, $page)
	{
		$goodsids = explode(',', $goodsids);

		if (count($goodsids) <= $pagesize) {
			if ($page == 1) {
				return implode(',', $goodsids);
			}

			return '';
		}

		$page = max(1, $page);
		$pindex = ($page - 1) * $pagesize;
		$arr = array_slice($goodsids, $pindex, $pagesize);
		return implode(',', $arr);
	}

	/**
     * 获取购物车数据
     */
	public function getCart()
	{
		global $_W;
		global $_GPC;
		$quickid = intval($_GPC['quickid']);
		$carts = $this->getAllCart($quickid, false);
		return app_json($carts);
	}

	/**
     * 清空购物车数据
     */
	public function clearCart()
	{
		global $_W;
		global $_GPC;
		$quickid = intval($_GPC['quickid']);
		$tablename = empty($quickid) ? 'ewei_shop_member_cart' : 'ewei_shop_quick_cart';
		$arr = array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']);

		if (!empty($quickid)) {
			$arr['quickid'] = $quickid;
		}

		pdo_update($tablename, array('deleted' => 1), $arr);
		return app_json(0);
	}

	/**
     * 更新购物车
     */
	public function update()
	{
		global $_W;
		global $_GPC;
		$quickid = intval($_GPC['quickid']);
		$goodsid = intval($_GPC['goodsid']);
		$optionid = intval($_GPC['optionid']);
		$type = $_GPC['type'];
		$typeValue = $_GPC['typevalue'];

		if (empty($goodsid)) {
			return app_error(AppError::$OrderCreateNoGoods);
		}

		$goods = pdo_fetch('select id,maxbuy,usermaxbuy,minbuy,total,marketprice,diyformid,diyformtype,diyfields, isverify, `type`,merchid, cannotrefund from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $goodsid, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			return app_error(AppError::$OrderCreateNoGoods);
		}

		if (0 < $optionid) {
			$optionInfo = pdo_fetch('select id,stock from' . tablename('ewei_shop_goods_option') . 'where id=:id limit 1', array(':id' => $optionid));
		}

		$diyform_plugin = p('diyform');
		$diyformid = 0;
		$diyformfields = iserializer(array());
		$diyformdata = iserializer(array());

		if ($diyform_plugin) {
			$diyformdata = $_GPC['diyformdata']['diyformdata'];
			if (!empty($diyformdata) && is_array($diyformdata)) {
				$diyformfields = false;

				if ($goods['diyformtype'] == 1) {
					$diyformid = intval($goods['diyformid']);
					$formInfo = $diyform_plugin->getDiyformInfo($diyformid);

					if (!empty($formInfo)) {
						$diyformfields = $formInfo['fields'];
					}
				}
				else {
					if ($goods['diyformtype'] == 2) {
						$diyformfields = iunserializer($goods['diyfields']);
					}
				}

				if (!empty($diyformfields)) {
					$insert_data = $diyform_plugin->getInsertData($diyformfields, $diyformdata);
					$diyformdata = $insert_data['data'];
					$diyformfields = iserializer($diyformfields);
				}
			}
		}

		$tablename = empty($quickid) ? 'ewei_shop_member_cart' : 'ewei_shop_quick_cart';
		$condition = ' goodsid=:id and openid=:openid and deleted=0 and  uniacid=:uniacid ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':id' => $goodsid);

		if (!empty($optionid)) {
			$condition .= ' and optionid=:optionid ';
			$params[':optionid'] = $optionid;
		}

		if (!empty($quickid)) {
			$condition .= ' and quickid=:quickid ';
			$params[':quickid'] = $quickid;
			$data = pdo_fetch('select id,total,optionid from ' . tablename($tablename) . ' where ' . $condition . ' limit 1', $params);
		}
		else {
			$data = pdo_fetch('select id,total,optionid from ' . tablename($tablename) . ' where ' . $condition . ' limit 1', $params);
		}

		if (empty($data)) {
			if ($type == 'add') {
				if (0 < $goods['minbuy']) {
					$total = $goods['minbuy'];
				}
				else {
					$total = 1;
				}
			}
			else {
				if ($type == 'value') {
					if ($typeValue == 0) {
						return app_error(AppError::$ParamsError);
					}

					if ($goods['minbuy'] == 0) {
						$total = intval($typeValue);
					}
					else if (intval($typeValue) < $goods['minbuy']) {
						$total = $goods['minbuy'];
					}
					else {
						$total = intval($typeValue);
					}
				}
			}

			if (0 < $goods['maxbuy']) {
				if ($goods['maxbuy'] < $total) {
					return app_error(AppError::$OrderCreateMaxBuyLimit);
				}
			}

			if (0 < $optionid) {
				if ($optionInfo['stock'] < $total) {
					return app_error(AppError::$OrderCreateStockError);
				}
			}
			else {
				if ($goods['total'] < $total) {
					return app_error(AppError::$OrderCreateStockError);
				}
			}

			$data = array('uniacid' => $_W['uniacid'], 'merchid' => intval($_GPC['merchid']), 'openid' => $_W['openid'], 'goodsid' => $goodsid, 'optionid' => $optionid, 'marketprice' => $goods['marketprice'], 'total' => $total, 'diyformid' => $diyformid, 'diyformdata' => $diyformdata, 'diyformfields' => $diyformfields, 'createtime' => time());

			if (!empty($quickid)) {
				$data['quickid'] = $quickid;
			}

			pdo_insert($tablename, $data);
			$cartArray = array();
			$newsCartArray = array();

			if (!empty($quickid)) {
				$cartArray['cartList'] = $this->getAllCart(!empty($quickid) ? $quickid : 0, false);
			}
			else {
				$cartArray['cartList'] = $this->getAllCart(0, false);
			}

			$newsCartArray['goodstotal'] = $this->getGoodsTotal($cartArray['cartList']['list'], $goodsid);
			$newsCartArray['total'] = $cartArray['cartList']['total'];
			$newsCartArray['totalprice'] = $cartArray['cartList']['totalprice'];
			return app_json($newsCartArray);
		}

		if ($type == 'add') {
			$data['total'] = $data['total'] + 1;
		}
		else if ($type == 'reduce') {
			$data['total'] = $data['total'] - 1;
		}
		else if ($type == 'value') {
			if ($typeValue <= 0) {
				return app_error(AppError::$ParamsError);
			}

			$data['total'] = $data['total'] + intval($typeValue);
		}
		else {
			if ($type == 'delete') {
				$data['total'] = 0;
			}
		}

		if (0 < $goods['maxbuy']) {
			if ($goods['maxbuy'] < $data['total']) {
				return app_error(AppError::$OrderCreateMaxBuyLimit);
			}
		}

		if (0 < $optionid) {
			if ($optionInfo['stock'] < $data['total']) {
				return app_error(AppError::$OrderCreateStockError);
			}
		}
		else {
			if ($goods['total'] < $data['total']) {
				return app_error(AppError::$OrderCreateStockError);
			}
		}

		if (empty($data['total'])) {
			$data['deleted'] = 1;
		}

		$data['diyformid'] = $diyformid;
		$data['diyformdata'] = $diyformdata;
		$data['diyformfields'] = $diyformfields;
		$arr2 = array('id' => $data['id'], 'uniacid' => $_W['uniacid']);

		if (!empty($quickid)) {
			$arr['quickid'] = $quickid;
		}

		pdo_update($tablename, $data, $arr2);
		$cartArray = array();
		$newsCartArray = array();

		if (!empty($quickid)) {
			$cartArray['cartList'] = $this->getAllCart(!empty($quickid) ? $quickid : 0, false);
		}
		else {
			$cartArray['cartList'] = $this->getAllCart(0, false);
		}

		$newsCartArray['goodstotal'] = $this->getGoodsTotal($cartArray['cartList']['list'], $goodsid);

		if (0 < $optionid) {
			$newsCartArray['goodsOptionTotal'] = $this->getGoodsTotal($cartArray['cartList']['list'], $goodsid, $optionid);
		}

		$newsCartArray['total'] = $cartArray['cartList']['total'];
		$newsCartArray['totalprice'] = $cartArray['cartList']['totalprice'];
		return app_json($newsCartArray);
	}

	/**
     * 获取当前商品购物车的数量
     * @param $cartArr
     * @param $goodsId
     * @return int
     */
	public function getGoodsTotal($cartArr, $goodsId, $optionid = 0)
	{
		$total = 0;

		if (0 < $optionid) {
			foreach ($cartArr as $info) {
				if ($info['goodsid'] == $goodsId && $info['optionid'] == $optionid) {
					$total += $info['total'];
				}
			}
		}
		else {
			foreach ($cartArr as $info) {
				if ($info['goodsid'] == $goodsId) {
					$total += $info['total'];
				}
			}
		}

		return $total;
	}
}

?>
