<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Log_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and log.uniacid=:uniacid and posterid=' . intval($_GPC['id']);
		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'rec') {
				$condition .= ' AND ( m.nickname LIKE :keyword or m.realname LIKE :keyword or m.mobile LIKE :keyword ) ';
			}
			else {
				if ($searchfield == 'sub') {
					$condition .= ' AND ( m1.nickname LIKE :keyword or m1.realname LIKE :keyword or m1.mobile LIKE :keyword ) ';
				}
			}

			$params[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$list = pdo_fetchall('SELECT log.*, m.avatar,m.nickname,m.realname,m.mobile,m1.avatar as avatar1,m1.nickname as nickname1,m1.realname as realname1,m1.mobile as mobile1,c.couponname as couponname,cl.couponname as couponname1 FROM ' . tablename('ewei_shop_poster_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m1 on m1.openid = log.openid and m1.uniacid = log.uniacid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = log.from_openid  and m.uniacid = log.uniacid' . ' left join ' . tablename('ewei_shop_coupon') . ' c on c.id = log.reccouponid  and c.uniacid = log.uniacid' . ' left join ' . tablename('ewei_shop_coupon') . ' cl on cl.id = log.subcouponid  and cl.uniacid = log.uniacid' . (' WHERE 1 ' . $condition . ' ORDER BY log.createtime desc ') . '  LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*)  FROM ' . tablename('ewei_shop_poster_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m1 on m1.openid = log.openid and m1.uniacid = log.uniacid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = log.from_openid and m.uniacid = log.uniacid ' . (' where 1 ' . $condition . '  '), $params);

		foreach ($list as &$row) {
			$row['times'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_poster_log') . ' where from_openid=:from_openid and posterid=:posterid and uniacid=:uniacid', array(':from_openid' => $row['from_openid'], ':posterid' => intval($_GPC['id']), ':uniacid' => $_W['uniacid']));
		}

		unset($row);
		$pager = pagination2($total, $pindex, $psize);
		load()->func('tpl');
		include $this->template();
	}
}

?>
