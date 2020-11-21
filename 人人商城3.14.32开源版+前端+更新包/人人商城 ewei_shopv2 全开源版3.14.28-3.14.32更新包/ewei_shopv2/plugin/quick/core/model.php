<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class QuickModel extends PluginModel
{
	public function getAdv()
	{
	}

	public function update($data, $page = array())
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

		$goodsids = array();
		$cateids = array();
		$groupids = array();

		foreach ($data['datas'] as $index => $item) {
			if ($item['datatype'] == 0) {
				$item_ids = !empty($item['goodsids']) ? $item['goodsids'] : array();
				if (empty($item_ids) && 0 < count($item['data'])) {
					$data['datas'][$index]['goodsids'] = $item_ids = $this->getGids($item['data']);
				}

				if (!empty($item_ids)) {
					$goodsids = array_merge($goodsids, $item_ids);
					$goodsids = array_unique($goodsids);
				}
			}
			else if ($item['datatype'] == 1) {
				if ($item['cateid'] && !in_array($item['cateid'], $cateids)) {
					$cateids[] = $item['cateid'];
				}
			}
			else {
				if ($item['datatype'] == 2) {
					if ($item['groupid'] && !in_array($item['groupid'], $groupids)) {
						$groupids[] = $item['groupid'];
					}
				}
			}
		}

		$goodsids = array_filter($goodsids);

		if (!empty($goodsids)) {
			$goodsids = implode(',', $goodsids);
			$allGoods = pdo_fetchall('SELECT id, title, subtitle, minprice, total, sales FROM' . tablename('ewei_shop_goods') . (' WHERE uniacid=:uniacid AND id in(' . $goodsids . ') AND `deleted`=0 AND `status`=1'), array(':uniacid' => $_W['uniacid']), 'id');
		}

		$cateids = array_filter($cateids);

		if (!empty($cateids)) {
			$cateids = implode(',', $cateids);
			$allCates = pdo_fetchall('SELECT * FROM' . tablename('ewei_shop_category') . (' WHERE uniacid=:uniacid AND id in(' . $cateids . ') AND enabled=1'), array(':uniacid' => $_W['uniacid']), 'id');
		}

		$groupids = array_filter($groupids);

		if (!empty($groupids)) {
			$groupids = implode(',', $groupids);
			$allGroups = pdo_fetchall('SELECT * FROM' . tablename('ewei_shop_goods_group') . (' WHERE uniacid=:uniacid AND id in(' . $groupids . ') AND enabled=1'), array(':uniacid' => $_W['uniacid']), 'id');
		}

		foreach ($data['datas'] as $index => &$item) {
			if ($item['datatype'] == 0) {
				if (!empty($item['data'])) {
					foreach ($item['data'] as $i => $g) {
						$gid = $g['gid'];

						if (empty($allGoods[$gid])) {
							unset($data['datas'][$index]['data'][$i]);
						}

						$item['data'][$i]['title'] = $allGoods[$gid]['title'];
						$item['data'][$i]['subtitle'] = $allGoods[$gid]['subtitle'];
						$item['data'][$i]['price'] = $allGoods[$gid]['minprice'];
						$item['data'][$i]['total'] = $allGoods[$gid]['total'];
					}
				}
			}
			else if ($item['datatype'] == 1) {
				$cateid = $item['cateid'];
				$item['catename'] = !empty($allCates[$cateid]) ? $allCates[$cateid]['name'] : $item['catename'];
			}
			else {
				if ($item['datatype'] == 2) {
					$groupid = $item['groupid'];
					$item['groupname'] = !empty($allGroups[$groupid]) ? $allGroups[$groupid]['name'] : $item['groupname'];
				}
			}
		}

		unset($item);

		if (!empty($page)) {
			$data['title'] = $page['title'];
		}

		return json_encode($data);
	}

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
		$returnData = array('template' => $template, 'style' => $data['style'][$template]);

		if ($data['template'] == 0) {
			$returnData['cartdata'] = intval($data['cartdata']);
			$returnData['datas'] = json_encode($data['datas']);

			if ($data['showadv'] == 1) {
				if (0 < $merchid) {
					$returnData['advs'] = pdo_fetchall('SELECT * FROM' . tablename('ewei_shop_quick_adv') . 'WHERE uniacid=:uniacid AND merchid=:merchid AND enabled=1', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
				}
				else {
					$returnData['advs'] = pdo_fetchall('SELECT * FROM' . tablename('ewei_shop_quick_adv') . 'WHERE uniacid=:uniacid AND enabled=1', array(':uniacid' => $_W['uniacid']));
				}
			}
			else {
				if ($data['showadv'] == 2 && !empty($data['advs'])) {
					$returnData['advs'] = array();

					foreach ($data['advs'] as $advitem) {
						$returnData['advs'][] = array('link' => $advitem['linkurl'], 'thumb' => $advitem['imgurl']);
					}

					unset($advitem);
				}
			}
		}
		else {
			$newDatas = array();

			if (!empty($data['datas'])) {
				foreach ($data['datas'] as $index => $d) {
					$orderby = '';
					if ($d['datatype'] == 0 || $d['datatype'] == 2) {
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
						$group = pdo_fetch('select * from ' . tablename('ewei_shop_goods_group') . ' where id=:id and uniacid=:uniacid and enabled=1 limit 1 ', array(':id' => $d['groupid'], ':uniacid' => $_W['uniacid']));
						if (!empty($group) && !empty($group['goodsids'])) {
							$d['goodsids'] = $group['goodsids'];
						}
					}

					if ($d['datatype'] == 1 && !empty($d['cateid'])) {
						$pagesize = !empty($d['goodsnum']) ? $d['goodsnum'] : 5;
						$goodslist = $this->getList(array('cate' => $d['cateid'], 'order' => $orderby, 'pagesize' => $pagesize, 'page' => 1));
						$d['data'] = $goodslist['list'];
					}
					else {
						if (!empty($d['goodsids'])) {
							$goodslist = $this->getList(array('ids' => $d['goodsids'], 'order' => $orderby));
							$d['data'] = $goodslist['list'];

							if ($d['datatype'] == 0) {
								$d['data'] = $this->sort($d['goodsids'], $d['data']);
							}
						}
					}

					$newDatas[] = $d;
				}
			}

			$returnData['datas'] = $newDatas;

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

	public function getQuick($id)
	{
		global $_W;

		if (empty($id)) {
			return array();
		}

		return pdo_fetch('SELECT * FROM' . tablename('ewei_shop_quick') . 'WHERE id=:id AND uniacid=:uniacid AND status=1 LIMIT 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
	}

	public function getPageList($merch = false, $type = 0, $condition = '', $params = array())
	{
		global $_W;
		$condition .= ' uniacid=:uniacid ';
		$params[':uniacid'] = $_W['uniacid'];
		$condition .= ' AND type=:type';

		if (!empty($merch)) {
			$condition .= ' AND merchid=:merchid ';
			$params[':merchid'] = $merch;
		}

		$params[':type'] = $type;
		return pdo_fetchall('SELECT id, title, status FROM' . tablename('ewei_shop_quick') . 'WHERE ' . $condition . ' ORDER BY createtime DESC', $params);
	}

	public function getList($args)
	{
		global $_W;
		$page = !empty($args['page']) ? intval($args['page']) : 1;
		$merchid = !empty($args['merchid']) ? intval($args['merchid']) : 0;
		$pagesize = !empty($args['pagesize']) ? intval($args['pagesize']) : 10;
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

		$condition = ' and `uniacid` = :uniacid AND `deleted` = 0 and status=1 and bargain=0 and `type`<>4 and `type`<>9 ';
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
			$groupid = intval($member['groupid']);
			$condition .= ' and ( ifnull(showlevels,\'\')=\'\' or FIND_IN_SET( ' . $levelid . ',showlevels)<>0 ) ';
			$condition .= ' and ( ifnull(showgroups,\'\')=\'\' or FIND_IN_SET( ' . $groupid . ',showgroups)<>0 ) ';
		}
		else {
			$condition .= ' and ifnull(showlevels,\'\')=\'\' ';
			$condition .= ' and   ifnull(showgroups,\'\')=\'\' ';
		}

		$sql = 'SELECT id,title,subtitle,thumb,minprice,marketprice,sales,salesreal,total,bargain,`type`,ispresell,presellend,preselltimeend,hasoption,total,maxbuy,minbuy,usermaxbuy,isverify,cannotrefund,diyformtype,diyformid,showsales,showtotal FROM ' . tablename('ewei_shop_goods') . (' where 1 ' . $condition . ' ORDER BY ' . $order . ' ' . $orderby . ' LIMIT ') . ($page - 1) * $pagesize . ',' . $pagesize;
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
				if (empty($totalmaxbuy) && $g["total"] != "0") {
                    $g["cannotbuy"] = "超出最高购买数量";
                } else {
                    if (empty($totalmaxbuy) && $g["total"] == "0") {
                        $g["cannotbuy"] = "该商品已售罄";
                    } else {
                        $g["cannotbuy"] = "";
                    }
                }
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
				if ($g['isverify'] == 2 || $g['type'] == 2 || $g['type'] == 3 || $g['type'] == 20 || !empty($g['cannotrefund']) || $g['type'] == 5) {
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

	public function getGids($arr)
	{
		$ids = array();
		if (empty($arr) || !is_array($arr)) {
			return $ids;
		}

		foreach ($arr as $index => $item) {
			if (empty($item['gid']) || in_array($item['gid'], $ids)) {
				continue;
			}

			$ids[] = $item['gid'];
		}

		return $ids;
	}

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

	public function getCart($pageid, $json = true)
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$list = array();
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
		$result = array('list' => $list, 'total' => $total, 'totalprice' => round($totalprice, 2));

		if ($json) {
			return json_encode($result);
		}

		return $result;
	}
}

?>
