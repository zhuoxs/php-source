<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends ComWebPage
{
	public function __construct($_com = 'coupon')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid and merchid=0 and isfriendcoupon = 0';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND couponname LIKE :couponname';
			$params[':couponname'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if (!empty($_GPC['catid'])) {
			$_GPC['catid'] = trim($_GPC['catid']);
			$condition .= ' AND catid = :catid';
			$params[':catid'] = (int) $_GPC['catid'];
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);

			if (!empty($starttime)) {
				$condition .= ' AND createtime >= :starttime';
				$params[':starttime'] = $starttime;
			}

			if (!empty($endtime)) {
				$condition .= ' AND createtime <= :endtime';
				$params[':endtime'] = $endtime;
			}
		}

		if ($_GPC['gettype'] != '') {
			$condition .= ' AND gettype = :gettype';
			$params[':gettype'] = intval($_GPC['gettype']);
		}

		if ($_GPC['type'] != '') {
			$condition .= ' AND coupontype = :coupontype';
			$params[':coupontype'] = intval($_GPC['type']);
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . ' ' . (' where  1 and ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$row['gettotal'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and uniacid=:uniacid limit 1', array(':couponid' => $row['id'], ':uniacid' => $_W['uniacid']));
			$row['usetotal'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where used = 1 and couponid=:couponid and uniacid=:uniacid limit 1', array(':couponid' => $row['id'], ':uniacid' => $_W['uniacid']));
			$row['pwdjoins'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_guess') . ' where couponid=:couponid and uniacid=:uniacid limit 1', array(':couponid' => $row['id'], ':uniacid' => $_W['uniacid']));
			$row['pwdoks'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_guess') . ' where couponid=:couponid and uniacid=:uniacid and ok=1 limit 1', array(':couponid' => $row['id'], ':uniacid' => $_W['uniacid']));
			$url = mobileUrl('sale/coupon/detail', array('id' => $row['id']), true);
			$row['qrcode'] = m('qrcode')->createQrcode($url);

			if ($row['quickget']) {
				$quickurl = mobileUrl('sale/coupon/quickget', array('id' => $row['id']), true);
				$row['quickqrcode'] = m('qrcode')->createQrcode($quickurl);
			}
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_coupon') . (' where 1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_coupon_category') . ' where uniacid=:uniacid and merchid=0 order by id desc', array(':uniacid' => $_W['uniacid']), 'id');
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = intval($_GPC['type']);

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'couponname' => trim($_GPC['couponname']), 'coupontype' => intval($_GPC['coupontype']), 'catid' => intval($_GPC['catid']), 'timelimit' => intval($_GPC['timelimit']), 'usetype' => intval($_GPC['usetype']), 'returntype' => 0, 'enough' => trim($_GPC['enough']), 'timedays' => intval($_GPC['timedays']), 'timestart' => strtotime($_GPC['time']['start']), 'timeend' => strtotime($_GPC['time']['end']) + 86399, 'backtype' => intval($_GPC['backtype']), 'deduct' => trim($_GPC['deduct']), 'discount' => trim($_GPC['discount']), 'backmoney' => trim($_GPC['backmoney']), 'backcredit' => trim($_GPC['backcredit']), 'backredpack' => trim($_GPC['backredpack']), 'backwhen' => intval($_GPC['backwhen']), 'gettype' => intval($_GPC['gettype']), 'getmax' => intval($_GPC['getmax']), 'credit' => intval($_GPC['credit']), 'money' => trim($_GPC['money']), 'usecredit2' => intval($_GPC['usecredit2']), 'total' => intval($_GPC['total']), 'bgcolor' => trim($_GPC['bgcolor']), 'thumb' => save_media($_GPC['thumb']), 'remark' => trim($_GPC['remark']), 'desc' => m('common')->html_images($_GPC['desc']), 'descnoset' => intval($_GPC['descnoset']), 'status' => intval($_GPC['status']), 'resptitle' => trim($_GPC['resptitle']), 'respthumb' => save_media($_GPC['respthumb']), 'respdesc' => trim($_GPC['respdesc']), 'respurl' => trim($_GPC['respurl']), 'pwdkey2' => trim($_GPC['pwdkey2']), 'pwdwords' => trim($_GPC['pwdwords']), 'pwdask' => trim($_GPC['pwdask']), 'pwdsuc' => trim($_GPC['pwdsuc']), 'pwdfail' => trim($_GPC['pwdfail']), 'pwdfull' => trim($_GPC['pwdfull']), 'pwdurl' => trim($_GPC['pwdurl']), 'pwdtimes' => intval($_GPC['pwdtimes']), 'pwdopen' => intval($_GPC['pwdopen']), 'pwdown' => trim($_GPC['pwdown']), 'pwdexit' => trim($_GPC['pwdexit']), 'pwdexitstr' => trim($_GPC['pwdexitstr']), 'displayorder' => intval($_GPC['displayorder']), 'tagtitle' => $_GPC['tagtitle'], 'settitlecolor' => intval($_GPC['settitlecolor']), 'titlecolor' => $_GPC['titlecolor'], 'limitdiscounttype' => intval($_GPC['limitdiscounttype']), 'templateid' => trim($_GPC['templateid']), 'quickget' => intval($_GPC['quickget']));
			$limitgoodcatetype = intval($_GPC['limitgoodcatetype']);
			$limitgoodtype = intval($_GPC['limitgoodtype']);
			$data['limitgoodcatetype'] = $limitgoodcatetype;
			$data['limitgoodtype'] = $limitgoodtype;
			if ($limitgoodcatetype == 1 || $limitgoodcatetype == 2) {
				$data['limitgoodcateids'] = '';
				$cates = array();

				if (is_array($_GPC['cates'])) {
					$cates = $_GPC['cates'];
					$data['limitgoodcateids'] = implode(',', $cates);
				}
			}
			else {
				$data['limitgoodcateids'] = '';
			}

			if ($limitgoodtype == 1 || $limitgoodtype == 2) {
				$data['limitgoodids'] = '';
				$goodids = array();

				if (is_array($_GPC['goodsid'])) {
					$goodids = $_GPC['goodsid'];
					$data['limitgoodids'] = implode(',', $goodids);
				}
			}
			else {
				$data['limitgoodids'] = '';
			}

			$islimitlevel = intval($_GPC['islimitlevel']);
			$data['islimitlevel'] = $islimitlevel;

			if ($islimitlevel == 1) {
				if (is_array($_GPC['limitmemberlevels'])) {
					$data['limitmemberlevels'] = implode(',', $_GPC['limitmemberlevels']);
				}
				else {
					$data['limitmemberlevels'] = '';
				}

				if (is_array($_GPC['limitagentlevels'])) {
					$data['limitagentlevels'] = implode(',', $_GPC['limitagentlevels']);
				}
				else {
					$data['limitagentlevels'] = '';
				}

				if (is_array($_GPC['limitpartnerlevels'])) {
					$data['limitpartnerlevels'] = implode(',', $_GPC['limitpartnerlevels']);
				}
				else {
					$data['limitpartnerlevels'] = '';
				}

				if (is_array($_GPC['limitaagentlevels'])) {
					$data['limitaagentlevels'] = implode(',', $_GPC['limitaagentlevels']);
				}
				else {
					$data['limitaagentlevels'] = '';
				}
			}
			else {
				$data['limitmemberlevels'] = '';
				$data['limitagentlevels'] = '';
				$data['limitpartnerlevels'] = '';
				$data['limitaagentlevels'] = '';
			}

			if (10 < $data['discount'] || $data['discount'] < 0) {
				show_json(0, '您好,您输入的折扣范围不对! 请输入 0.1 ~ 10 之间数');
			}

			if (!empty($id)) {
				if (!empty($data['pwdkey2'])) {
					$pwdkey2 = pdo_fetch('SELECT pwdkey2 FROM ' . tablename('ewei_shop_coupon') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid']));

					if ($pwdkey2['pwdkey2'] != $data['pwdkey2']) {
						$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid and id<>:id  limit 1 ', array(':content' => $data['pwdkey2'], ':uniacid' => $_W['uniacid'], ':id' => $id));

						if (!empty($keyword)) {
							show_json(0, array('url' => webUrl('sale/coupon/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab']))), 'message' => '口令关键词已存在!'));
						}
					}
				}

				pdo_update('ewei_shop_coupon', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('sale.coupon.edit', '编辑优惠券 ID: ' . $id . ' <br/>优惠券名称: ' . $data['couponname']);
			}
			else {
				if (!empty($data['pwdkey2'])) {
					$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid limit 1 ', array(':content' => $data['pwdkey2'], ':uniacid' => $_W['uniacid']));

					if (!empty($keyword)) {
						show_json(0, array('url' => webUrl('sale/coupon/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab']))), 'message' => '口令关键词已存在!'));
					}
				}

				$data['createtime'] = time();
				pdo_insert('ewei_shop_coupon', $data);
				$id = pdo_insertid();
				plog('sale.coupon.add', '添加优惠券 ID: ' . $id . '  <br/>优惠券名称: ' . $data['couponname']);
			}

			$key = 'ewei_shopv2:com:coupon:' . $id;
			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => $key));

			if (!empty($data['pwdkey2'])) {
				if (empty($rule)) {
					$rule_data = array('uniacid' => $_W['uniacid'], 'name' => $key, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => $data['pwdopen']);
					pdo_insert('rule', $rule_data);
					$rid = pdo_insertid();
					$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => $data['pwdkey2'], 'type' => 1, 'displayorder' => 0, 'status' => $data['pwdopen']);
					pdo_insert('rule_keyword', $keyword_data);
				}
				else {
					pdo_update('rule_keyword', array('content' => $data['pwdkey2'], 'status' => $data['pwdopen']), array('rid' => $rule['id']));
				}
			}
			else {
				if (!empty($rule)) {
					pdo_delete('rule_keyword', array('rid' => $rule['id']));
					pdo_delete('rule', array('id' => $rule['id']));
				}
			}

			show_json(1, array('url' => webUrl('sale/coupon/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE id =:id and uniacid=:uniacid and merchid=0 limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($item)) {
			$starttime = time();
			$endtime = strtotime(date('Y-m-d H:i:s', $starttime) . '+7 days');
		}
		else {
			$type = $item['coupontype'];
			$starttime = $item['timestart'];
			$endtime = $item['timeend'];
			if ($item['limitgoodcatetype'] == 1 || $item['limitgoodcatetype'] == 2) {
				$cates = array();
				$cates = explode(',', $item['limitgoodcateids']);
			}

			if ($item['limitgoodtype'] == 1 || $item['limitgoodtype'] == 2) {
				if ($item['limitgoodids']) {
					$goods = pdo_fetchall('SELECT id,title,thumb FROM ' . tablename('ewei_shop_goods') . (' WHERE uniacid = :uniacid and id in (' . $item['limitgoodids'] . ') '), array(':uniacid' => $_W['uniacid']));
				}
			}

			$limitmemberlevels = explode(',', $item['limitmemberlevels']);
			$limitagentlevels = explode(',', $item['limitagentlevels']);
			$limitpartnerlevels = explode(',', $item['limitpartnerlevels']);
			$limitaagentlevels = explode(',', $item['limitaagentlevels']);
			$left_count = 0;

			if ($item['total'] == '-1') {
				$left_count = '不限';
			}
			else {
				$gettotal = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and uniacid=:uniacid limit 1', array(':couponid' => $id, ':uniacid' => $_W['uniacid']));
				$left_count = $item['total'] - $gettotal;
				$left_count = intval($left_count);
			}
		}

		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_coupon_category') . ' where uniacid=:uniacid and merchid=0 order by id desc', array(':uniacid' => $_W['uniacid']), 'id');
		$goodcategorys = m('shop')->getFullCategory(true, true);
		$shop = $_W['shopset']['shop'];
		$levels = m('member')->getLevels();
		$hascommission = false;
		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();
			$hascommission = !empty($plugin_com_set['level']);
		}

		$hasglobonus = false;
		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !empty($plugin_globonus_set['open']);
		}

		$hasabonus = false;
		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !empty($plugin_abonus_set['open']);
		}

		if ($hascommission) {
			$agentlevels = $plugin_com->getLevels();
		}

		if ($hasglobonus) {
			$partnerlevels = $plugin_globonus->getLevels();
		}

		if ($hasabonus) {
			$aagentlevels = $plugin_abonus->getLevels();
		}

		$item['desc'] = M('common')->html_to_images($item['desc']);
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,couponname FROM ' . tablename('ewei_shop_coupon') . (' WHERE id in( ' . $id . ' ) and merchid=0 AND uniacid=') . $_W['uniacid']);
		$key = 'ewei_shopv2:com:coupon:' . $id;
		$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => $key));

		if (!empty($rule)) {
			pdo_delete('rule_keyword', array('rid' => $rule['id']));
			pdo_delete('rule', array('id' => $rule['id']));
		}

		foreach ($items as $item) {
			pdo_delete('ewei_shop_coupon', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_coupon_data', array('couponid' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('sale.coupon.delete', '删除优惠券 ID: ' . $id . '  <br/>优惠券名称: ' . $item['couponname'] . ' ');
		}

		show_json(1, array('url' => webUrl('sale/coupon')));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$displayorder = intval($_GPC['value']);
		$items = pdo_fetchall('SELECT id,couponname FROM ' . tablename('ewei_shop_coupon') . (' WHERE id in( ' . $id . ' ) and merchid=0 AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_coupon', array('displayorder' => $displayorder), array('id' => $id));
			plog('sale.coupon.displayorder', '修改优惠券排序 ID: ' . $item['id'] . ' 名称: ' . $item['couponname'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$diy = intval($_GPC['diy']);
		$live = intval($_GPC['live']);
		$merch = $_GPC['merch'];
		$canmerch = intval($_GPC['canmerch']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];

		if ($merch) {
			$condition = ' and c.uniacid=:uniacid ';

			if ($diy) {
				$condition .= ' and c.gettype = 1 ';
			}
		}
		else {
			$condition = ' and uniacid=:uniacid ';

			if ($diy) {
				$condition .= ' and gettype = 1 ';
			}

			if (!$canmerch) {
				$condition .= 'and merchid=0';
			}
		}

		if (!empty($kwd)) {
			$condition .= ' AND couponname like :couponname';
			$params[':couponname'] = '%' . $kwd . '%';
		}

		$time = time();

		if ($merch) {
			$ds = pdo_fetchall('SELECT c.*,m.merchname FROM ' . tablename('ewei_shop_coupon') . ' as c
                 left join ' . tablename('ewei_shop_merch_user') . (' as m on m.id = c.merchid
                 WHERE 1 ' . $condition . ' ORDER BY c.id asc'), $params);
		}
		else {
			$ds = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_coupon') . ('  WHERE 1 ' . $condition . ' ORDER BY id asc'), $params);
		}

		if (!empty($ds)) {
			foreach ($ds as &$d) {
				$d = com('coupon')->setCoupon($d, $time, false);
				$d['last'] = com('coupon')->get_last_count($d['id']);

				if ($d['last'] == -1) {
					$d['last'] = '不限';
				}

				if ($diy) {
					if ($d['coupontype'] == 0) {
						if (0 < $d['enough']) {
							$d['uselimit'] = '满' . (double) $d['enough'] . '元可用';
						}
						else {
							$d['uselimit'] = '无门槛使用';
						}
					}
					else {
						if ($d['coupontype'] == 1) {
							if (0 < $d['enough']) {
								$d['uselimit'] = '充值满' . (double) $d['enough'] . '元可用';
							}
							else {
								$d['uselimit'] = '充值任意金额';
							}
						}
					}

					if ($d['backtype'] == 0) {
						$d['values'] = '￥' . (double) $d['deduct'];
					}
					else if ($d['backtype'] == 1) {
						$d['values'] = (double) $d['discount'] . '折 ';
					}
					else {
						if ($d['backtype'] == 2) {
							$values = 0;
							if (!empty($d['backmoney']) && 0 < $d['backmoney']) {
								$values = $values + $d['backmoney'];
							}

							if (!empty($d['backcredit']) && 0 < $d['backcredit']) {
								$values = $values + $d['backcredit'];
							}

							if (!empty($d['backredpack']) && 0 < $d['backredpack']) {
								$values = $values + $d['backredpack'];
							}

							$d['values'] = '￥' . $values;
						}
					}
				}
				else {
					if ($live) {
						if ($d['backtype'] == 0) {
							$d['value_text'] = '0';
							$d['value_total'] = price_format($d['deduct']);
						}
						else if ($d['backtype'] == 1) {
							$d['value_text'] = '折';
							$d['value_total'] = $d['discount'];
						}
						else {
							if ($d['backtype'] == 2) {
								if (!empty($d['backmoney']) && 0 < $d['backmoney']) {
									$d['value_text'] = '0';
									$d['value_total'] = price_format($d['backmoney']);
								}
								else {
									if (!empty($d['backcredit']) && 0 < $d['backcredit']) {
										$d['value_text'] = '积分';
										$d['value_total'] = $d['backcredit'];
									}
									else {
										if (!empty($d['backredpack']) && 0 < $d['backredpack']) {
											$d['value_text'] = '0';
											$d['value_total'] = price_format($d['backredpack']);
										}
										else {
											$d['value_text'] = '0';
											$d['value_total'] = '0';
										}
									}
								}
							}
						}
					}
				}

				unset($d['respdesc']);
				unset($d['respthumb']);
				unset($d['resptitle']);
			}

			unset($d);
		}

		include $this->template();
	}

	public function querycplist()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$diy = intval($_GPC['diy']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid and merchid=0';

		if (!empty($kwd)) {
			$condition .= ' AND couponname like :couponname';
			$params[':couponname'] = '%' . $kwd . '%';
		}

		$time = time();
		$ds = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_coupon') . ('  WHERE 1 ' . $condition . ' ORDER BY id asc'), $params);

		if (!empty($ds)) {
			foreach ($ds as &$d) {
				$d = com('coupon')->setCoupon($d, $time, false);
				$d['last'] = com('coupon')->get_last_count($d['id']);

				if ($d['last'] == -1) {
					$d['last'] = '不限';
				}

				if ($diy) {
					if ($d['coupontype'] == 0) {
						if (0 < $d['enough']) {
							$d['uselimit'] = '满' . (double) $d['enough'] . '元可用';
						}
						else {
							$d['uselimit'] = '无门槛使用';
						}
					}
					else {
						if ($d['coupontype'] == 1) {
							if (0 < $d['enough']) {
								$d['uselimit'] = '充值满' . (double) $d['enough'] . '元可用';
							}
							else {
								$d['uselimit'] = '充值任意金额';
							}
						}
					}

					if ($d['backtype'] == 0) {
						$d['values'] = '￥' . (double) $d['deduct'];
					}
					else if ($d['backtype'] == 1) {
						$d['values'] = (double) $d['discount'] . '折 ';
					}
					else {
						if ($d['backtype'] == 2) {
							$values = 0;
							if (!empty($d['backmoney']) && 0 < $d['backmoney']) {
								$values = $values + $d['backmoney'];
							}

							if (!empty($d['backcredit']) && 0 < $d['backcredit']) {
								$values = $values + $d['backcredit'];
							}

							if (!empty($d['backredpack']) && 0 < $d['backredpack']) {
								$values = $values + $d['backredpack'];
							}

							$d['values'] = '￥' . $values;
						}
					}
				}
			}

			unset($d);
		}

		include $this->template();
	}

	public function querygoods()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid and deleted = 0 and (bargain =0 or bargain is null) and status =1';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,thumb FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		$replace_str = array('“', '"');

		foreach ($ds as &$row) {
			$row['title'] = str_replace($replace_str, '', htmlspecialchars_decode($row['title']));
		}

		unset($row);
		$ds = set_medias($ds, array('thumb', 'share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}

	public function querycoupons()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid ';

		if (!empty($kwd)) {
			$condition .= ' AND `couponname` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,couponname as title , thumb FROM ' . tablename('ewei_shop_coupon') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		$ds = set_medias($ds, 'thumb');

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}

	public function send()
	{
		global $_W;
		global $_GPC;
		$couponid = intval($_GPC['couponid']);
		$coupon = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE id=:id and uniacid=:uniacid and merchid=0', array(':id' => $couponid, ':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			if (empty($coupon)) {
				show_json(0, '未找到优惠券!');
			}

			$class1 = intval($_GPC['send1']);
			$plog = '';

			if ($class1 == 1) {
				$openids = $_GPC['send_openid'];
				$plog = '发放优惠券 ID: ' . $couponid . ' 方式: 指定 OPENID 人数: ' . count($openids);
			}
			else if ($class1 == 2) {
				$where = '';

				if (!empty($_GPC['send_level'])) {
					$where .= ' and level =' . intval($_GPC['send_level']);
				}

				$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\'') . $where, array(), 'openid');

				if (!empty($_GPC['send_level'])) {
					$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_member_level') . ' where id=:id limit 1', array(':id' => $_GPC['send_level']));
				}
				else {
					$levelname = '全部';
				}

				$openids = array_keys($members);
				$plog = '发放优惠券 ID: ' . $couponid . ' 方式: 等级-' . $levelname . ' 人数: ' . count($members);
			}
			else if ($class1 == 3) {
				$where = '';

				if (!empty($_GPC['send_group'])) {
					$where .= ' and groupid =' . intval($_GPC['send_group']);
				}

				$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\'') . $where, array(), 'openid');

				if (!empty($_GPC['send_group'])) {
					$groupname = pdo_fetchcolumn('select groupname from ' . tablename('ewei_shop_member_group') . ' where id=:id limit 1', array(':id' => $_GPC['send_group']));
				}
				else {
					$groupname = '全部分组';
				}

				$openids = array_keys($members);
				$plog = '发放优惠券 ID: ' . $couponid . '  方式: 分组-' . $groupname . ' 人数: ' . count($members);
			}
			else if ($class1 == 4) {
				$where = '';
				$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\'') . $where, array(), 'openid');
				$openids = array_keys($members);
				$plog = '发放优惠券 ID: ' . $couponid . '  方式: 全部会员 人数: ' . count($members);
			}
			else if ($class1 == 5) {
				$where = '';
				if (!empty($_GPC['send_agentlevel']) || $_GPC['send_partnerlevels'] === '0') {
					$where .= ' and agentlevel =' . intval($_GPC['send_agentlevel']);
				}

				$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and isagent=1 and status=1 ') . $where, array(), 'openid');

				if ($_GPC['send_agentlevel'] != '') {
					$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_commission_level') . ' where id=:id limit 1', array(':id' => $_GPC['send_agentlevel']));
				}
				else {
					$levelname = '全部';
				}

				$openids = array_keys($members);
				$plog = '发放优惠券 ID: ' . $couponid . '  方式: 分销商-' . $levelname . ' 人数: ' . count($members);
			}
			else if ($class1 == 6) {
				$where = '';
				if (!empty($_GPC['send_partnerlevels']) || $_GPC['send_partnerlevels'] === '0') {
					$where .= ' and partnerlevel =' . intval($_GPC['send_partnerlevels']);
				}

				$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and ispartner=1 and partnerstatus=1 ') . $where, array(), 'openid');

				if ($_GPC['send_partnerlevels'] != '') {
					$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_globonus_level') . ' where id=:id limit 1', array(':id' => $_GPC['send_partnerlevels']));
				}
				else {
					$levelname = '全部';
				}

				$openids = array_keys($members);
				$plog = '发放优惠券 ID: ' . $couponid . '  方式: 股东-' . $levelname . ' 人数: ' . count($members);
			}
			else {
				if ($class1 == 7) {
					$where = '';
					if (!empty($_GPC['send_aagentlevels']) || $_GPC['send_partnerlevels'] === '0') {
						$where .= ' and aagentlevel =' . intval($_GPC['send_aagentlevels']);
					}

					$members = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' and isaagent=1 and aagentstatus=1 ') . $where, array(), 'openid');

					if ($_GPC['send_aagentlevels'] != '') {
						$levelname = pdo_fetchcolumn('select levelname from ' . tablename('ewei_shop_abonus_level') . ' where id=:id limit 1', array(':id' => $_GPC['send_aagentlevels']));
					}
					else {
						$levelname = '全部';
					}

					$openids = array_keys($members);
					$plog = '发放优惠券 ID: ' . $couponid . '  方式: 区域代理-' . $levelname . ' 人数: ' . count($members);
				}
			}

			$mopenids = array();

			foreach ($openids as $openid) {
				$mopenids[] = '\'' . str_replace('\'', '\'\'', $openid) . '\'';
			}

			if (empty($mopenids)) {
				show_json(0, '未找到发送的会员!');
			}

			$members = pdo_fetchall('select id,openid,nickname from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $mopenids) . (') and uniacid=' . $_W['uniacid']));

			if (empty($members)) {
				show_json(0, '未找到发送的会员!');
			}

			if ($coupon['total'] != -1) {
				$last = com('coupon')->get_last_count($couponid);

				if ($last <= 0) {
					show_json(0, '优惠券数量不足,无法发放!');
				}

				$need = count($members) - $last;

				if (0 < $need) {
					show_json(0, '优惠券数量不足,请补充 ' . $need . ' 张优惠券才能发放!');
				}
			}

			$upgrade = array('resptitle' => trim($_GPC['send_title']), 'respthumb' => trim($_GPC['send_thumb']), 'respdesc' => trim($_GPC['send_desc']), 'respurl' => trim($_GPC['send_url']));
			pdo_update('ewei_shop_coupon', $upgrade, array('id' => $coupon['id']));
			$send_total = intval($_GPC['send_total']);
			$send_total <= 0 && ($send_total = 1);
			$account = m('common')->getAccount();
			$time = time();

			foreach ($members as $m) {
				$i = 1;

				while ($i <= $send_total) {
					$log = array('uniacid' => $_W['uniacid'], 'merchid' => $coupon['merchid'], 'openid' => $m['openid'], 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $couponid, 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => $time, 'getfrom' => 0);
					pdo_insert('ewei_shop_coupon_log', $log);
					$logid = pdo_insertid();
					$data = array('uniacid' => $_W['uniacid'], 'merchid' => $coupon['merchid'], 'openid' => $m['openid'], 'couponid' => $couponid, 'gettype' => 0, 'gettime' => $time, 'senduid' => $_W['uid']);
					pdo_insert('ewei_shop_coupon_data', $data);
					++$i;
				}

				com('coupon')->sendMessage($coupon, $send_total, $m, $account);
			}

			plog('sale.coupon.send', $plog);
			show_json(1, array('message' => '优惠券发放成功!', 'url' => webUrl('sale/coupon')));
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_level') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY level asc'));
		$list2 = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_group') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY id asc'));
		$coupons = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_coupon') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY id asc'));
		$hascommission = false;
		$plugin_com = p('commission');

		if ($plugin_com) {
			$plugin_com_set = $plugin_com->getSet();
			$hascommission = !empty($plugin_com_set['level']);
		}

		$hasglobonus = false;
		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !empty($plugin_globonus_set['open']);
		}

		$hasabonus = false;
		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !empty($plugin_abonus_set['open']);
		}

		if ($hascommission) {
			$list3 = $plugin_com->getLevels();
		}

		if ($hasglobonus) {
			$list4 = $plugin_globonus->getLevels();
		}

		if ($hasabonus) {
			$list5 = $plugin_abonus->getLevels();
		}

		load()->func('tpl');
		include $this->template();
	}

	public function set()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['consumedesc'] = m('common')->html_images($data['consumedesc']);
			$data['rechargedesc'] = m('common')->html_images($data['rechargedesc']);
			$imgs = $_GPC['adv_img'];
			$urls = $_GPC['adv_url'];
			$advs = array();

			if (is_array($imgs)) {
				foreach ($imgs as $key => $img) {
					$advs[] = array('img' => save_media($img), 'url' => trim($urls[$key]));
				}
			}

			$data['advs'] = $advs;
			m('common')->updatePluginset(array('coupon' => $data));
			plog('sale.coupon.set', '修改基本设置');
			show_json(1, array('url' => webUrl('sale/coupon/set', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$data = m('common')->getPluginset('coupon');
		$advs = is_array($data['advs']) ? $data['advs'] : array();
		$data['consumedesc'] = M('common')->html_to_images($data['consumedesc']);
		$data['rechargedesc'] = M('common')->html_to_images($data['rechargedesc']);
		include $this->template();
	}
}

?>
