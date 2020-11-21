<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Log_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$permset = intval(m('cache')->getString('permset', 'global'));
		$is_perm_plugin = true;
		if ($permset && !com_run('perm::is_perm_plugin', 'perm', true)) {
			$is_perm_plugin = false;
		}

		if (!cv('perm') || !$is_perm_plugin) {
			show_message('暂无此操作权限', '', 'error');
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and log.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

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

		if (!empty($_GPC['time'])) {
			if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
				$starttime = strtotime($_GPC['time']['start']);
				$endtime = strtotime($_GPC['time']['end']);
				$condition .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
				$params[':starttime'] = $starttime;
				$params[':endtime'] = $endtime;
			}
		}

		$extendCondition = ' and u.username <> ""';
		$list = pdo_fetchall('SELECT  log.* ,u.username FROM ' . tablename('ewei_shop_perm_log') . ' log  ' . ' left join ' . tablename('users') . ' u on log.uid = u.uid  ' . (' WHERE 1 ' . $condition . $extendCondition . ' ORDER BY id desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_perm_log') . ' log  ' . ' left join ' . tablename('users') . ' u on log.uid = u.uid  ' . (' WHERE 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);
		$types = com('perm')->getLogTypes();
		include $this->template('perm/log/index');
	}

	public function merch()
	{
		global $_W;
		global $_GPC;

		if (!m('common')->pluginPermissions('merch')) {
			show_message('暂无此操作权限', '', 'error');
		}

		$permset = intval(m('cache')->getString('permset', 'global'));
		$is_perm_plugin = true;
		if ($permset && !com_run('perm::is_perm_plugin', 'perm', true)) {
			$is_perm_plugin = false;
		}

		if (!cv('perm') || !$is_perm_plugin) {
			show_message('暂无此操作权限', '', 'error');
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and log.uniacid=:uniacid';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and ( log.op like :keyword or user.merchname like :keyword)';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time'])) {
			if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
				$starttime = strtotime($_GPC['time']['start']);
				$endtime = strtotime($_GPC['time']['end']);
				$condition .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
				$params[':starttime'] = $starttime;
				$params[':endtime'] = $endtime;
			}
		}

		$sql = 'select log.id,user.merchname as username,log.name,log.op,log.ip,log.createtime from' . tablename('ewei_shop_merch_perm_log') . ' log ' . ' left join ' . tablename('ewei_shop_merch_user') . ' user' . ' on log.merchid = user.id' . (' where 1 ' . $condition) . ' order by log.id desc' . ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		array_walk($list, function(&$item, $key) {
			if (empty($item['username'])) {
				$item['username'] = '该用户已被删除';
			}
		});
		$total = pdo_fetchcolumn('select count(log.id) from' . tablename('ewei_shop_merch_perm_log') . ' log ' . ' left join ' . tablename('ewei_shop_merch_user') . ' user' . ' on log.merchid = user.id' . (' where 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
