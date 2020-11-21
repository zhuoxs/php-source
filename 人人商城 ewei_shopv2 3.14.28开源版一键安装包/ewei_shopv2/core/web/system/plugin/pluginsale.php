<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Pluginsale_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and gl.type = \'pay\' ';
		$params = array();
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND gl.createtime >= :starttime AND gl.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'uniacid') {
				$condition .= ' and w.name like :keyword ';
			}
			else {
				if ($searchfield == 'plugin') {
					$condition .= ' and p.name like :keyword ';
				}
			}

			$params[':keyword'] = '%' . $keyword . '%';
		}

		$list = pdo_fetchall('SELECT gl.*,w.name as wname,p.name as pname,p.thumb,p.iscom,o.username,o.pluginid as opluginid,o.price,o.logno,o.price,o.paytype FROM ' . tablename('ewei_shop_system_plugingrant_log') . ' as gl
                    left join ' . tablename('account_wechats') . ' as w on w.uniacid = gl.uniacid
                    left join ' . tablename('ewei_shop_system_plugingrant_order') . ' as o on o.uniacid = gl.uniacid and o.logno = gl.logno
                    left join ' . tablename('ewei_shop_plugin') . (' as p on p.id = gl.pluginid
			        WHERE 1 ' . $condition . ' ORDER BY gl.id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_system_plugingrant_log') . ' as gl
                    left join ' . tablename('account_wechats') . ' as w on w.uniacid = gl.uniacid
                    left join ' . tablename('ewei_shop_system_plugingrant_order') . ' as o on o.uniacid = gl.uniacid and o.logno = gl.logno
                    left join ' . tablename('ewei_shop_plugin') . (' as p on p.id = gl.pluginid
			        WHERE 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
