<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


require EWEI_SHOPV2_PLUGIN . 'merchmanage/core/inc/page_merchmanage.php';
class Index_EweiShopV2Page extends MerchmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;


		include $this->template();
	}

	public function add()
	{
		global $_W;
		$this->post();
	}

	public function edit()
	{
		global $_W;

		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!(empty($id))) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id and uniacid = :uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$merchid = $_W['merchmanage']['merchid'];
			if ($item['merchid'] != $merchid) {
				$this->message('抱歉，商品不存在!', mobileUrl('merchmanage/goods'), 'error');
			}
		}


		if ($_W['ispost']) {
			$data = array('title' => trim($_GPC['title']), 'subtitle' => trim($_GPC['subtitle']), 'unit' => trim($_GPC['unit']), 'status' => intval($_GPC['status']), 'showtotal' => intval($_GPC['showtotal']), 'cash' => intval($_GPC['cash']), 'invoice' => intval($_GPC['invoice']), 'isnodiscount' => intval($_GPC['isnodiscount']), 'nocommission' => intval($_GPC['nocommission']), 'isrecommand' => intval($_GPC['isrecommand']), 'isnew' => intval($_GPC['isnew']), 'ishot' => intval($_GPC['ishot']), 'issendfree' => intval($_GPC['issendfree']), 'totalcnf' => intval($_GPC['totalcnf']), 'dispatchtype' => intval($_GPC['dispatchtype']), 'showlevels' => trim($_GPC['showlevels']), 'showgroups' => trim($_GPC['showgroups']), 'buylevels' => trim($_GPC['buylevels']), 'buygroups' => trim($_GPC['buygroups']), 'maxbuy' => intval($_GPC['maxbuy']), 'minbuy' => intval($_GPC['minbuy']), 'usermaxbuy' => intval($_GPC['usermaxbuy']), 'diypage' => intval($_GPC['diypage']), 'displayorder' => intval($_GPC['displayorder']));

			if (empty($item)) {
				$data['type'] = intval($_GPC['type']);
			}


			$thumbs = $_GPC['thumbs'];

			if (is_array($thumbs)) {
				$thumb_url = array();

				foreach ($thumbs as $th ) {
					$thumb_url[] = trim($th);
				}

				$data['thumb'] = save_media($thumb_url[0]);
				unset($thumb_url[0]);
				$data['thumb_url'] = serialize(m('common')->array_images($thumb_url));
			}


			if (empty($item['hasoption'])) {
				$data['hasoption'] = 0;
				$data['marketprice'] = trim($_GPC['marketprice']);
				$data['productprice'] = trim($_GPC['productprice']);
				$data['costprice'] = trim($_GPC['costprice']);
				$data['total'] = intval($_GPC['total']);
				$data['weight'] = trim($_GPC['weight']);
				$data['goodssn'] = trim($_GPC['goodssn']);
				$data['productsn'] = trim($_GPC['productsn']);
			}


			if ($item['diyformtype'] != 2) {
				$data['diyformid'] = intval($_GPC['diyformid']);

				if (!(empty($data['diyformid']))) {
					$data['diyformtype'] = 1;
				}

			}


			if (empty($data['dispatchtype'])) {
				$data['dispatchid'] = intval($_GPC['dispatchid']);
			}
			 else {
				$data['dispatchprice'] = trim($_GPC['dispatchprice']);
			}

			$cateset = m('common')->getSysset('shop');
			$pcates = array();
			$ccates = array();
			$tcates = array();
			$fcates = array();
			$cates = array();
			$pcateid = 0;
			$ccateid = 0;
			$tcateid = 0;
			$cates = $_GPC['cates'];

			if (!(is_array($cates)) && !(empty($cates))) {
				$cates = explode(',', $cates);
			}


			if (is_array($cates)) {
				foreach ($cates as $key => $cid ) {
					$c = pdo_fetch('select level from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));

					if ($c['level'] == 1) {
						$pcates[] = $cid;
					}
					 else if ($c['level'] == 2) {
						$ccates[] = $cid;
					}
					 else if ($c['level'] == 3) {
						$tcates[] = $cid;
					}


					if ($key == 0) {
						if ($c['level'] == 1) {
							$pcateid = $cid;
						}
						 else if ($c['level'] == 2) {
							$crow = pdo_fetch('select parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
							$pcateid = $crow['parentid'];
							$ccateid = $cid;
						}
						 else if ($c['level'] == 3) {
							$tcateid = $cid;
							$tcate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
							$ccateid = $tcate['parentid'];
							$ccate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $ccateid, ':uniacid' => $_W['uniacid']));
							$pcateid = $ccate['parentid'];
						}

					}

				}
			}


			$data['pcate'] = $pcateid;
			$data['ccate'] = $ccateid;
			$data['tcate'] = $tcateid;
			$data['cates'] = implode(',', $cates);
			$data['pcates'] = implode(',', $pcates);
			$data['ccates'] = implode(',', $ccates);
			$data['tcates'] = implode(',', $tcates);
			$result = array();

			if (!(empty($item))) {
				pdo_update('ewei_shop_goods', $data, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
				plog('goods.edit', '编辑商品 ID: ' . $id . '<br>' . ((!(empty($data['nocommission'])) ? '是否参与分销 -- 否' : '是否参与分销 -- 是')));
			}else {
				$data['createtime'] = time();
				$data['uniacid'] = $_W['uniacid'];
				$data['merchid'] = $_W['merchmanage']['merchid'];
				pdo_insert('ewei_shop_goods', $data);
				$id = pdo_insertid();
				$result['id'] = $id;
				plog('goods.add', '添加商品 ID: ' . $id . '<br>' . ((!(empty($data['nocommission'])) ? '是否参与分销 -- 否' : '是否参与分销 -- 是')));
			}

			if (!(empty($item['hasoption']))) {
				$sql = 'update ' . tablename('ewei_shop_goods') . ' g set' . "\r\n" . '            g.minprice = (select min(marketprice) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $id . '),' . "\r\n" . '            g.maxprice = (select max(marketprice) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $id . ')' . "\r\n" . '            where g.id = ' . $id . ' and g.hasoption=1';
				pdo_query($sql);
			}
			 else {
				pdo_query('delete from ' . tablename('ewei_shop_goods_option') . ' where goodsid=' . $id);
				$sql = 'update ' . tablename('ewei_shop_goods') . ' set minprice = marketprice,maxprice = marketprice where id = ' . $id . ' and hasoption=0;';
				pdo_query($sql);
			}

			$sqlgoods = 'SELECT id,title,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,total,description,merchsale FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1';
			$goodsinfo = pdo_fetch($sqlgoods, array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$goodsinfo = m('goods')->getOneMinPrice($goodsinfo);
			pdo_update('ewei_shop_goods', array('minprice' => $goodsinfo['minprice'], 'maxprice' => $goodsinfo['maxprice']), array('id' => $id, 'uniacid' => $_W['uniacid']));
			show_json(1, $result);
		}else {
			$merchid = 0;
			$merch_plugin = p('merch');
			$type_title = '实物商品';
			$prop_title = '无';
			$totalcnf_title = '拍下减库存';
			$dispatch_title = '模板: 默认模板';
			$viewlevel_title = $viewgroup_title = $buylevel_title = $buygroup_title = '不限制';

			if ((0 < $item['merchid']) && !(empty($item))) {
				$merchid = intval($item['merchid']);

				if ($merch_plugin) {
					$merch_user = $merch_plugin->getListUserOne($merchid);
				}

			}


			$dispatch_data = pdo_fetchall('select * from ' . tablename('ewei_shop_dispatch') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
			$levels = m('member')->getLevels();
			$levels = array_merge(array(
						array('id' => 0, 'levelname' => (empty($_W['shopset']['shop']['levelname']) ? '默认会员' : $_W['shopset']['shop']['levelname']))
						), $levels);
			$groups = m('member')->getGroups();
			$groups = array_merge(array(
						array('id' => 0, 'groupname' => '未分组')
					), $groups);
			$catlevel = intval($_W['shopset']['category']['level']);
			$category = m('shop')->getFullCategory(true, true);
			$allcategory = m('shop')->getCategory();
			$category_json = json_encode($allcategory);
			$cates = explode(',', $item['cates']);
			$category_title = '未分类';

			if (p('diypage')) {
				$diypage_title = '默认模板';
				$diypage = p('diypage')->getPageList('allpage', ' and type=5 ');
				$diypage = $diypage['list'];
			}


			if (p('diyform')) {
				$diyform = p('diyform')->getDiyformList();
				$diyform_title = '未设置';
			}


			if (!(empty($item))) {
				$item['marketprice'] = price_format($item['marketprice']);
				$item['productprice'] = price_format($item['productprice']);
				$item['costprice'] = price_format($item['costprice']);
				$item['dispatchprice'] = price_format($item['dispatchprice']);

				if ($item['type'] == 2) {
					$type_title = '虚拟商品';
				}
				 else if ($item['type'] == 3) {
					$type_title = '虚拟商品(卡密)';
				}


				$prop = array();

				if (!(empty($item['isrecommand']))) {
					$prop[] = '推荐';
				}


				if (!(empty($item['isnew']))) {
					$prop[] = '新品';
				}


				if (!(empty($item['ishot']))) {
					$prop[] = '热销';
				}


				if (!(empty($item['issendfree']))) {
					$prop[] = '包邮';
				}


				$prop_title = implode('、', $prop);

				if (empty($prop_title)) {
					$prop_title = '无';
				}


				if ($item['totalcnf'] == 1) {
					$totalcnf_title = '付款减库存';
				}
				 else if ($item['totalcnf'] == 2) {
					$totalcnf_title = '永不减库存';
				}


				if (!(empty($item['thumb']))) {
					$piclist = array_merge(array($item['thumb']), iunserializer($item['thumb_url']));
				}


				if (($item['showlevels'] != '') && !(empty($levels))) {
					$showlevels = explode(',', $item['showlevels']);
					$viewlevels = array();

					if ($showlevels) {
						foreach ($levels as $lindex => $level ) {
							foreach ($showlevels as $sindex => $showlevel ) {
								if ($level['id'] == $showlevel) {
									$viewlevels[] = $level['levelname'];
									$levels[$lindex]['checked_view'] = 1;
								}

							}
						}

						unset($lindex);
						unset($level);
						unset($sindex);
						unset($showlevel);
					}


					if (!(empty($viewlevels))) {
						$viewlevel_title = implode(',', $viewlevels);
					}

				}


				if (($item['showgroups'] != '') && !(empty($groups))) {
					$showgroups = explode(',', $item['showgroups']);
					$viewgroups = array();

					if ($showgroups != '') {
						foreach ($groups as $gindex => $group ) {
							foreach ($showgroups as $sindex => $showgroup ) {
								if ($group['id'] == $showgroup) {
									$viewgroups[] = $group['groupname'];
									$groups[$gindex]['checked_view'] = 1;
								}

							}
						}

						unset($gindex);
						unset($group);
						unset($sindex);
						unset($showgroup);
					}


					if (!(empty($viewgroups))) {
						$viewgroup_title = implode(',', $viewgroups);
					}

				}


				if (($item['buylevels'] != '') && !(empty($levels))) {
					$buylevels2 = explode(',', $item['buylevels']);
					$buylevels = array();

					if ($buylevels2 != '') {
						foreach ($levels as $lindex => $level ) {
							foreach ($buylevels2 as $bindex => $buylevel ) {
								if ($level['id'] == $buylevel) {
									$buylevels[] = $level['levelname'];
									$levels[$lindex]['checked_buy'] = 1;
								}

							}
						}

						unset($lindex);
						unset($level);
						unset($bindex);
						unset($buylevel);
					}


					if (!(empty($buylevels))) {
						$buylevel_title = implode(',', $buylevels);
					}

				}


				if (($item['buygroups'] != '') && !(empty($groups))) {
					$buygroups2 = explode(',', $item['buygroups']);
					$buygroups = array();

					if ($buygroups2 != '') {
						foreach ($groups as $gindex => $group ) {
							foreach ($buygroups2 as $bindex => $buygroup ) {
								if ($group['id'] == $buygroup) {
									$buygroups[] = $group['groupname'];
									$groups[$gindex]['checked_buy'] = 1;
								}

							}
						}

						unset($gindex);
						unset($group);
						unset($bindex);
						unset($showgroup);
					}


					if (!(empty($buygroups))) {
						$buygroup_title = implode(',', $buygroups);
					}

				}


				$category_arr = array();

				if (!(empty($cates)) && $category) {
					foreach ($category as $category_item ) {
						if (in_array($category_item['id'], $cates)) {
							$category_arr[] = $category_item['name'];
						}

					}
				}


				if (!(empty($category_arr))) {
					$category_title = implode(',', $category_arr);
				}


				$categoryshow = array();

				if (!(empty($item['diypage'])) && !(empty($diypage))) {
					foreach ($diypage as $diypage_item ) {
						if ($diypage_item['id'] == $item['diypage']) {
							$diypage_title = $diypage_item['name'];
							break;
						}
					}

					unset($diypage_item);
				}


				if (($item['diyformtype'] == 1) && !(empty($item['diyformid'])) && !(empty($diyform))) {
					foreach ($diyform as $diyform_item ) {
						if ($diyform_item['id'] == $item['diyformid']) {
							$diyform_title = $diyform_item['title'];
							break;
						}
					}
				}


				if (empty($item['dispatchtype'])) {
					if (!(empty($item['dispatchid'])) && !(empty($dispatch_data))) {
						foreach ($dispatch_data as $dispatch_item ) {
							if ($item['dispatchid'] == $dispatch_item['id']) {
								$dispatch_title = '模板: ' . $dispatch_item['dispatchname'];
								break;
							}
						}

						unset($dispatch_item);
					}

				}
				 else {
					$dispatch_title = '统一运费 ' . $item['dispatchprice'] . '元';
				}
			}

		}

		include $this->template('merchmanage/goods/post');
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$offset = intval($_GPC['offset']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$list = array();

		$condition = ' WHERE g.`uniacid` = :uniacid and type!=10 and merchid = "'.$_W['merchmanage']['merchid'].'"';
		$params = array(':uniacid' => $_W['uniacid']);
		$goodsfrom = strtolower(trim($_GPC['status']));
		empty($goodsfrom) && ($_GPC['status'] = $goodsfrom = 'sale');

		if ($goodsfrom == 'sale') {
			$condition .= ' AND g.`status` > 0 and g.`checked`=0 and g.`total`>0 and g.`deleted`=0';
		}
		 else if ($goodsfrom == 'out') {
			$condition .= ' AND g.`status` > 0 and g.`total` <= 0 and g.`deleted`=0';
		}
		 else if ($goodsfrom == 'stock') {
			$condition .= ' AND (g.`status` = 0 or g.`checked`=1) and g.`deleted`=0';
		}
		 else if ($goodsfrom == 'cycle') {
			$condition .= ' AND g.`deleted`=1';
		}


		$keywords = trim($_GPC['keywords']);

		if ($keywords) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $keywords . '%';
		}


		$sql = 'SELECT count(g.id) FROM ' . tablename('ewei_shop_goods') . 'g' . $condition;
		$total = pdo_fetchcolumn($sql, $params);

		if (0 < $total) {
			$presize = (($pindex - 1) * $psize) - $offset;
			$sql = 'SELECT g.* FROM ' . tablename('ewei_shop_goods') . 'g' . $condition . ' ORDER BY g.`status` DESC, g.`displayorder` DESC,' . "\r\n" . '                g.`id` DESC LIMIT ' . $presize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
		}


		$list = set_medias($list, 'thumb');
		show_json(1, array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		
		$id = intval($_GPC['id']);
		$ids = trim($_GPC['ids']);

		if (empty($id)) {
			if (!(empty($ids)) && strexists($ids, ',')) {
				$id = $ids;
			}

		}


		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);

		foreach ($items as $item ) {
			pdo_update('ewei_shop_goods', array('deleted' => 1), array('id' => $item['id']));
			plog('goods.delete', '删除商品 ID: ' . $item['id'] . ' 商品名称: ' . $item['title'] . ' ');
		}

		show_json(1);
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		
		$id = intval($_GPC['id']);
		$ids = trim($_GPC['ids']);

		if (empty($id)) {
			if (!(empty($ids)) && strexists($ids, ',')) {
				$id = $ids;
			}

		}


		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);

		foreach ($items as $item ) {
			pdo_update('ewei_shop_goods', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('goods.edit', (('修改商品状态<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title'] . '<br/>状态: ' . $_GPC['status']) == 1 ? '上架' : '下架'));
		}

		show_json(1);
	}

	public function restore()
	{
		global $_W;
		global $_GPC;
		
		$id = intval($_GPC['id']);
		$ids = trim($_GPC['ids']);

		if (empty($id)) {
			if (!(empty($ids)) && strexists($ids, ',')) {
				$id = $ids;
			}

		}


		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_goods') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);

		foreach ($items as $item ) {
			pdo_update('ewei_shop_goods', array('deleted' => 0, 'status' => 0), array('id' => $item['id']));
			plog('goods.restore', '从回收站恢复商品<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['title']);
		}

		show_json(1);
	}
}


?>