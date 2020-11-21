<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Scan_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and scan.uniacid=:uniacid ';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND ( m.nickname LIKE :keyword or m.realname LIKE :keyword or m.mobile LIKE :keyword ) ';
			$params[':keyword'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if (!empty($_GPC['keyword1'])) {
			$_GPC['keyword1'] = trim($_GPC['keyword1']);
			$condition .= ' AND ( m1.nickname LIKE :keyword1 or m1.realname LIKE :keyword1 or m1.mobile LIKE :keyword1 ) ';
			$params[':keyword1'] = '%' . trim($_GPC['keyword1']) . '%';
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);

			if ($_GPC['searchtime'] == '1') {
				$condition .= ' AND scan.scantime >= :starttime AND scan.scantime <= :endtime ';
				$params[':starttime'] = $starttime;
				$params[':endtime'] = $endtime;
			}
		}

		$condition .= ' and scan.posterid=' . intval($_GPC['id']);
		$list = pdo_fetchall('SELECT m.avatar,m.nickname,m.realname,m.mobile,m1.avatar as avatar1,m1.nickname as nickname1,m1.realname as realname1,m1.mobile as mobile1,scan.scantime FROM ' . tablename('ewei_shop_poster_scan') . ' scan ' . ' left join ' . tablename('ewei_shop_member') . ' m1 on m1.openid = scan.openid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = scan.from_openid ' . (' WHERE 1 ' . $condition . '  ORDER BY scan.scantime desc ') . '  LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_poster_scan') . ' scan ' . ' left join ' . tablename('ewei_shop_member') . ' m1 on m1.openid = scan.openid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = scan.from_openid ' . (' where 1 ' . $condition . '  '), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
