<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Index_EweiShopV2Page extends MerchWebPage
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
		$condition = ' uniacid = :uniacid and merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

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
			$url = mobileUrl('sale/coupon/detail', array('id' => $row['id']), true);
			$row['qrcode'] = m('qrcode')->createQrcode($url);
			$row['gettotal'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and uniacid=:uniacid and merchid=:merchid limit 1', array(':couponid' => $row['id'], ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
			$row['usetotal'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_data') . ' where used = 1 and couponid=:couponid and uniacid=:uniacid and merchid=:merchid limit 1', array(':couponid' => $row['id'], ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
			$row['pwdjoins'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_guess') . ' where couponid=:couponid and uniacid=:uniacid and merchid=:merchid limit 1', array(':couponid' => $row['id'], ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
			$row['pwdoks'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_coupon_guess') . ' where couponid=:couponid and uniacid=:uniacid and merchid=:merchid and ok=1 limit 1', array(':couponid' => $row['id'], ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_coupon') . (' where 1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_coupon_category') . ' where uniacid=:uniacid and merchid=:merchid order by id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']), 'id');
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

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid'], 'couponname' => trim($_GPC['couponname']), 'coupontype' => intval($_GPC['coupontype']), 'catid' => intval($_GPC['catid']), 'timelimit' => intval($_GPC['timelimit']), 'usetype' => intval($_GPC['usetype']), 'returntype' => 0, 'enough' => trim($_GPC['enough']), 'timedays' => intval($_GPC['timedays']), 'timestart' => strtotime($_GPC['time']['start']), 'timeend' => strtotime($_GPC['time']['end']), 'backtype' => intval($_GPC['backtype']), 'deduct' => trim($_GPC['deduct']), 'discount' => trim($_GPC['discount']), 'gettype' => intval($_GPC['gettype']), 'getmax' => intval($_GPC['getmax']), 'credit' => intval($_GPC['credit']), 'money' => trim($_GPC['money']), 'usecredit2' => intval($_GPC['usecredit2']), 'total' => intval($_GPC['total']), 'bgcolor' => trim($_GPC['bgcolor']), 'thumb' => save_media($_GPC['thumb']), 'remark' => trim($_GPC['remark']), 'desc' => m('common')->html_images($_GPC['desc']), 'descnoset' => intval($_GPC['descnoset']), 'status' => intval($_GPC['status']), 'resptitle' => trim($_GPC['resptitle']), 'respthumb' => save_media($_GPC['respthumb']), 'respdesc' => trim($_GPC['respdesc']), 'respurl' => trim($_GPC['respurl']), 'tagtitle' => $_GPC['tagtitle'], 'settitlecolor' => intval($_GPC['settitlecolor']), 'titlecolor' => $_GPC['titlecolor'], 'limitdiscounttype' => intval($_GPC['limitdiscounttype']));
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

			if (!empty($id)) {
				pdo_update('ewei_shop_coupon', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				mplog('sale.coupon.edit', '编辑优惠券 ID: ' . $id . ' <br/>优惠券名称: ' . $data['couponname']);
			}
			else {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_coupon', $data);
				$id = pdo_insertid();
				mplog('sale.coupon.add', '添加优惠券 ID: ' . $id . '  <br/>优惠券名称: ' . $data['couponname']);
			}

			show_json(1, array('url' => merchUrl('sale/coupon/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE id =:id and uniacid=:uniacid and merchid=:merchid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id, ':merchid' => $_W['merchid']));

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
		}

		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_coupon_category') . ' where uniacid=:uniacid and merchid=:merchid order by id desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']), 'id');
		$goodcategorys = m('shop')->getFullCategory(true, true);
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

		$items = pdo_fetchall('SELECT id,couponname FROM ' . tablename('ewei_shop_coupon') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid'] . ' AND merchid=' . $_W['merchid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_coupon', array('id' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			pdo_delete('ewei_shop_coupon_data', array('couponid' => $item['id'], 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']));
			mplog('sale.coupon.delete', '删除优惠券 ID: ' . $id . '  <br/>优惠券名称: ' . $item['couponname'] . ' ');
		}

		show_json(1, array('url' => merchUrl('sale/coupon')));
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
		$items = pdo_fetchall('SELECT id,couponname FROM ' . tablename('ewei_shop_coupon') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid'] . ' AND merchid=' . $_W['merchid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_coupon', array('displayorder' => $displayorder), array('id' => $id));
			mplog('sale.coupon.displayorder', '修改优惠券排序 ID: ' . $item['id'] . ' 名称: ' . $item['couponname'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$diy = intval($_GPC['diy']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$params[':merchid'] = $_W['merchid'];
		$condition = ' and uniacid=:uniacid and merchid=:merchid';

		if (!empty($kwd)) {
			$condition .= ' AND couponname like :couponname';
			$params[':couponname'] = '%' . $kwd . '%';
		}

		$time = time();
		$ds = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_coupon') . ('  WHERE 1 ' . $condition . ' ORDER BY id asc'), $params);

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
		include $this->template();
	}

	public function querygoods()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$params[':deleted'] = 0;
		$params[':merchid'] = $_W['merchid'];
		$condition = ' and uniacid=:uniacid and deleted = :deleted and  merchid=:merchid';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,thumb FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		$ds = set_medias($ds, array('thumb', 'share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

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
			$this->model->updateSet(array('coupon' => $data));
			mplog('sale.coupon.set', '修改基本设置');
			show_json(1, array('url' => merchUrl('sale/coupon/set', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$set = $this->model->getSet();
		$data = $set['coupon'];
		$advs = is_array($data['advs']) ? $data['advs'] : array();
		include $this->template();
	}
}

?>
