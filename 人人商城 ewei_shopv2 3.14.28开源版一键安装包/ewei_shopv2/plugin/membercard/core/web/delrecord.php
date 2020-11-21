<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Delrecord_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'uniacid=:uniacid';
		$condition .= ' AND isdelete=1';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and name  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_card') . (' WHERE  ' . $condition . '  ORDER BY del_time DESC limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member_card') . (' WHERE  ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function view()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$card_info = pdo_fetch('SELECT name,create_time FROM ' . tablename('ewei_shop_member_card') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'mch.uniacid=:uniacid';
		$condition .= ' AND mc.uniacid=:uniacid';
		$condition .= ' AND mch.isdelete=1';
		$condition .= ' AND mch.member_card_id=:id';
		$params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
		$sql = 'SELECT mch.user_name,mch.telephone,mch.receive_time,mch.expire_time,mc.del_time,m.uid,m.avatar,m.nickname,m.id as mid  FROM   ' . tablename('ewei_shop_member_card_history') . ' mch 
        LEFT JOIN   ' . tablename('ewei_shop_member_card') . ' mc on mch.member_card_id=mc.id 
        LEFT JOIN ' . tablename('ewei_shop_member') . (' as m on mch.openid=m.openid 
        where ' . $condition . '  ORDER BY del_time DESC limit ') . ($pindex - 1) * $psize . ',' . $psize . ' ';
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT count(mch.id)  FROM   ' . tablename('ewei_shop_member_card_history') . ' mch LEFT JOIN   ' . tablename('ewei_shop_member_card') . (' mc on mch.member_card_id=mc.id where ' . $condition . '  ORDER BY mc.del_time DESC limit ') . ($pindex - 1) * $psize . ',' . $psize . ' ', $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
