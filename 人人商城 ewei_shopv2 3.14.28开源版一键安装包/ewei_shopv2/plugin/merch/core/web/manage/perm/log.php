<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Log_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and log.uniacid=:uniacid and log.merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( log.op like :keyword or u.username like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if (!empty($_GPC['logtype'])) {
			$condition .= ' and log.type=:logtype';
			$params[':logtype'] = trim($_GPC['logtype']);
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['searchtime'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);

			if (!empty($timetype)) {
				$condition .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
				$params[':starttime'] = $starttime;
				$params[':endtime'] = $endtime;
			}
		}

		$list = pdo_fetchall('SELECT  log.* ,u.username FROM ' . tablename('ewei_shop_merch_perm_log') . ' log  ' . ' left join ' . tablename('ewei_shop_merch_account') . ' u on log.uid = u.id and log.merchid = u.merchid and log.uniacid = u.uniacid' . (' WHERE 1 ' . $condition . ' ORDER BY id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_merch_perm_log') . ' log  ' . ' left join ' . tablename('ewei_shop_merch_account') . ' u on log.uid = u.id and log.merchid = u.merchid and log.uniacid = u.uniacid' . (' WHERE 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);
		$types = p('merch')->getLogTypes();
		include $this->template();
	}
}

?>
