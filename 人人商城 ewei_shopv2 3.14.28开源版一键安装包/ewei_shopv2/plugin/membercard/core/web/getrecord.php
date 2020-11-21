<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Getrecord_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'mch.uniacid=:uniacid';
		$condition .= ' AND mc.uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND ( mch.name LIKE :name OR m.nickname LIKE :nickname )';
			$params[':name'] = '%' . trim($_GPC['keyword']) . '%';
			$params[':nickname'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if ($_GPC['enabled'] != '') {
			$now_time = TIMESTAMP;

			if ($_GPC['enabled'] == 1) {
				$condition .= ' and (mch.expire_time=-1 or mch.expire_time>' . $now_time . ')';
			}
			else {
				if ($_GPC['enabled'] == 0) {
					$condition .= ' and mch.expire_time<>-1 and mch.expire_time<' . $now_time;
				}
			}
		}

		$sql = 'SELECT mch.*,mc.create_time,m.uid,m.avatar,m.nickname,m.id as mid FROM  
            ' . tablename('ewei_shop_member_card_history') . ' as mch 
            LEFT JOIN   ' . tablename('ewei_shop_member_card') . ' as mc on mch.member_card_id=mc.id 
            LEFT JOIN ' . tablename('ewei_shop_member') . (' as m on mch.openid=m.openid
            where ' . $condition . ' GROUP BY mch.id HAVING COUNT( m.openid ) >=1 ORDER BY mch.receive_time DESC limit ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT count(DISTINCT mch.id)  FROM   
            ' . tablename('ewei_shop_member_card_history') . ' mch 
            LEFT JOIN   ' . tablename('ewei_shop_member_card') . ' mc on mch.member_card_id=mc.id 
            LEFT JOIN ' . tablename('ewei_shop_member') . (' as m on mch.openid=m.openid
            where ' . $condition . '  ORDER BY mch.receive_time DESC '), $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
