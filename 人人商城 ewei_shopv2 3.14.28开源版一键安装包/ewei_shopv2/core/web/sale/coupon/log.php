<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Log_EweiShopV2Page extends ComWebPage
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
		$condition = ' d.uniacid = :uniacid and d.merchid=0';
		$params = array(':uniacid' => $_W['uniacid']);
		$couponid = intval($_GPC['couponid']);

		if (!empty($couponid)) {
			$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid and merchid=0 limit 1', array(':id' => $couponid, ':uniacid' => $_W['uniacid']));
			$condition .= ' AND c.id=' . intval($couponid);
		}

		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'member') {
				$condition .= ' and ( m.realname like :keyword or m.nickname like :keyword or m.mobile like :keyword)';
			}
			else {
				if ($searchfield == 'coupon') {
					$condition .= ' and c.couponname like :keyword';
				}
			}

			$params[':keyword'] = '%' . $keyword . '%';
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (empty($starttime1) || empty($endtime1)) {
			$starttime1 = strtotime('-1 month');
			$endtime1 = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND d.gettime >= :starttime AND d.gettime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		if (!empty($_GPC['time1']['start']) && !empty($_GPC['time1']['end'])) {
			$starttime1 = strtotime($_GPC['time1']['start']);
			$endtime1 = strtotime($_GPC['time1']['end']);
			$condition .= ' AND d.usetime >= :starttime1 AND d.gettime <= :endtime1 ';
			$params[':starttime1'] = $starttime1;
			$params[':endtime1'] = $endtime1;
		}

		if ($_GPC['type'] != '') {
			$condition .= ' AND c.coupontype = :coupontype';
			$params[':coupontype'] = intval($_GPC['type']);
		}

		if ($_GPC['used'] != '') {
			$condition .= ' AND d.used =' . intval($_GPC['used']);
		}

		if ($_GPC['gettype'] != '') {
			$condition .= ' AND d.gettype = :gettype';
			$params[':gettype'] = intval($_GPC['gettype']);
		}

		$sql = 'SELECT d.*, c.coupontype,c.couponname,m.nickname,m.avatar,m.realname,m.mobile FROM ' . tablename('ewei_shop_coupon_data') . ' d ' . ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = d.openid and m.uniacid = d.uniacid ' . (' where  1 and ' . $condition . ' ORDER BY gettime DESC');

		if (empty($_GPC['export'])) {
			$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$couponstr = '消费';

			if ($row['coupontype'] == 1) {
				$couponstr = '充值';
			}

			$row['couponstr'] = $couponstr;

			if ($row['gettype'] == 0) {
				$row['gettypestr'] = '后台发放';
			}
			else if ($row['gettype'] == 1) {
				$row['gettypestr'] = '领券中心';
			}
			else if ($row['gettype'] == 2) {
				$row['gettypestr'] = '积分商城';
			}
			else if ($row['gettype'] == 3) {
				$row['gettypestr'] = '任务海报';
			}
			else if ($row['gettype'] == 4) {
				$row['gettypestr'] = '超级海报';
			}
			else if ($row['gettype'] == 5) {
				$row['gettypestr'] = '活动海报';
			}
			else if ($row['gettype'] == 6) {
				$row['gettypestr'] = '任务发送';
			}
			else if ($row['gettype'] == 7) {
				$row['gettypestr'] = '兑换中心';
			}
			else if ($row['gettype'] == 8) {
				$row['gettypestr'] = '快速领取';
			}
			else if ($row['gettype'] == 9) {
				$row['gettypestr'] = '收银台发送';
			}
			else if ($row['gettype'] == 10) {
				$row['gettypestr'] = '微信会员卡激活发送';
			}
			else if ($row['gettype'] == 11) {
				$row['gettypestr'] = '直播间领取优惠券';
			}
			else if ($row['gettype'] == 12) {
				$row['gettypestr'] = '直播间推送优惠券';
			}
			else if ($row['gettype'] == 13) {
				$row['gettypestr'] = '口令优惠券';
			}
			else if ($row['gettype'] == 14) {
				$row['gettypestr'] = '新人领券';
			}
			else {
				if ($row['gettype'] == 15) {
					$row['gettypestr'] = '发券分享';
				}
			}
		}

		unset($row);

		if ($_GPC['export'] == 1) {
			ca('coupon.log.export');

			foreach ($list as &$row) {
				$row['gettime'] = date('Y-m-d H:i', $row['gettime']);

				if (!empty($row['usetime'])) {
					$row['usetime'] = date('Y-m-d H:i', $row['usetime']);
				}
				else {
					$row['usetime'] = '---';
				}
			}

			$columns = array(
				array('title' => 'ID', 'field' => 'id', 'width' => 12),
				array('title' => '优惠券', 'field' => 'couponname', 'width' => 24),
				array('title' => '类型', 'field' => 'couponstr', 'width' => 12),
				array('title' => '会员信息', 'field' => 'nickname', 'width' => 12),
				array('title' => '姓名', 'field' => 'realname', 'width' => 12),
				array('title' => '手机号', 'field' => 'mobile', 'width' => 12),
				array('title' => 'openid', 'field' => 'openid', 'width' => 24),
				array('title' => '获取方式', 'field' => 'gettypestr', 'width' => 12),
				array('title' => '获取时间', 'field' => 'gettime', 'width' => 12),
				array('title' => '使用时间', 'field' => 'usetime', 'width' => 12),
				array('title' => '使用单号', 'field' => 'ordersn', 'width' => 12)
				);
			m('excel')->export($list, array('title' => '优惠券数据-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
			plog('sale.coupon.log.export', '导出优惠券发放记录');
		}

		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_coupon_data') . ' d ' . ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = d.openid and m.uniacid = d.uniacid ' . ('where 1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
