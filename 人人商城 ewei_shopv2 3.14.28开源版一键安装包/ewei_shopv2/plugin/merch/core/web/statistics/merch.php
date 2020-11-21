<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Merch_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and u.uniacid=:uniacid and o.`status`=3';
		$params = array(':uniacid' => $_W['uniacid']);
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['datetime']['start']) && !empty($_GPC['datetime']['end'])) {
			$starttime = strtotime($_GPC['datetime']['start']);
			$endtime = strtotime($_GPC['datetime']['end']);
			$condition .= ' AND o.createtime >= :starttime AND o.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if (!empty($_GPC['groupname'])) {
			$_GPC['groupname'] = intval($_GPC['groupname']);
			$condition .= ' and u.groupid=:groupid';
			$params[':groupid'] = $_GPC['groupname'];
		}

		if (!empty($_GPC['realname'])) {
			$_GPC['realname'] = trim($_GPC['realname']);
			$condition .= ' and ( u.merchname like :realname or u.mobile like :realname or u.realname like :realname)';
			$params[':realname'] = '%' . $_GPC['realname'] . '%';
		}

		$sql = 'select u.*,sum(o.price) price,sum(o.goodsprice) goodsprice,sum(o.dispatchprice) dispatchprice,sum(o.discountprice) discountprice,sum(o.deductprice) deductprice,sum(o.deductcredit2) deductcredit2,sum(o.isdiscountprice) isdiscountprice from ' . tablename('ewei_shop_merch_user') . ' u ' . ' left join ' . tablename('ewei_shop_order') . ' o on u.id=o.merchid' . (' where 1 ' . $condition . ' GROUP BY u.id ORDER BY u.id DESC');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);

		if ($_GPC['export'] == '1') {
			plog('merch.statistics.merch', '导出商户数据');

			foreach ($list as &$row) {
				$row['realprice'] = $row['goodsprice'] + $row['dispatchprice'];
			}

			unset($row);
			m('excel')->export($list, array(
	'title'   => '商户数据-' . date('Y-m-d-H-i', time()),
	'columns' => array(
		array('title' => '商城信息', 'field' => 'merchname', 'width' => 12),
		array('title' => '姓名', 'field' => 'realname', 'width' => 12),
		array('title' => '手机号', 'field' => 'mobile', 'width' => 12),
		array('title' => '订单应收', 'field' => 'realprice', 'width' => 12),
		array('title' => '积分抵扣', 'field' => 'deductprice', 'width' => 12),
		array('title' => '余额抵扣', 'field' => 'deductcredit2', 'width' => 12),
		array('title' => '会员抵扣', 'field' => 'discountprice', 'width' => 12),
		array('title' => '促销优惠', 'field' => 'isdiscountprice', 'width' => 12),
		array('title' => '订单实收', 'field' => 'price', 'width' => 12)
		)
	));
		}

		$total = pdo_fetchall('select u.id from ' . tablename('ewei_shop_merch_user') . ' u ' . ' left join ' . tablename('ewei_shop_order') . ' o on u.id=o.merchid' . (' where 1 ' . $condition . ' GROUP BY u.id'), $params);
		$total = count($total);
		$pager = pagination2($total, $pindex, $psize);
		$groups = $this->model->getGroups();
		include $this->template();
	}

	public function ajax_user_data()
	{
		global $_W;
		global $_GPC;
		$merchid = intval($_GPC['merchid']);
		$merch = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id = :id', array(':id' => $merchid));
		$condition = ' and u.uniacid=:uniacid and u.id=:merchid and o.`status`=3';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid);
		if (!empty($_GPC['starttime']) && !empty($_GPC['endtime'])) {
			$starttime = strtotime($_GPC['starttime']);
			$endtime = strtotime($_GPC['endtime']);
			$condition .= ' AND o.createtime >= :starttime AND o.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$sql = 'select u.id,u.merchname,u.payrate,sum(o.price) price,sum(o.goodsprice) goodsprice,sum(o.dispatchprice) dispatchprice,sum(o.discountprice) discountprice,sum(o.deductprice) deductprice,sum(o.deductcredit2) deductcredit2,sum(o.isdiscountprice) isdiscountprice,sum(o.deductenough) deductenough,sum(o.merchdeductenough) merchdeductenough,sum(o.couponmerchid) couponmerchid from ' . tablename('ewei_shop_merch_user') . ' u ' . ' left join ' . tablename('ewei_shop_order') . ' o on u.id=o.merchid' . (' where 1 ' . $condition . ' limit 1');
		$list = pdo_fetch($sql, $params);
		$merchcouponprice = pdo_fetchcolumn('select sum(o.couponprice) from ' . tablename('ewei_shop_merch_user') . ' u ' . ' left join ' . tablename('ewei_shop_order') . ' o on u.id=o.merchid' . (' where o.couponmerchid>0 ' . $condition . ' limit 1'), $params);
		$list['realprice'] = $list['goodsprice'] + $list['dispatchprice'] - $list['merchdeductenough'] - $merchcouponprice;
		$list['realpricerate'] = (100 - floatval($list['payrate'])) * $list['realprice'] / 100;
		$list['merchcouponprice'] = $merchcouponprice;
		exit(json_encode($list));
	}
}

?>
