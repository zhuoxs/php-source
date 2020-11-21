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
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$this->message('参数错误');
		}

		$invitation = pdo_fetch('SELECT id,title,scan,follow FROM ' . tablename('ewei_shop_invitation') . ' WHERE id=:id AND uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($invitation)) {
			$this->message('邀请卡不存在');
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' AND log.invitation_id=:invitationid AND log.uniacid=:uniacid AND mc.uniacid=:uniacid AND ms.uniacid=:uniacid';
		$params = array(':invitationid' => $id, ':uniacid' => $_W['uniacid']);
		$searchfield = trim($_GPC['searchfield']);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			if ($searchfield == 'scan') {
				$condition .= ' AND (mc.nickname LIKE :keyword OR mc.realname LIKE :keyword OR mc.mobile LIKE :keyword)';
			}
			else {
				$condition .= ' AND (ms.nickname LIKE :keyword OR ms.realname LIKE :keyword OR ms.mobile LIKE :keyword)';
			}

			$params[':keyword'] = '%' . $keyword . '%';
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND log.scan_time >= :starttime AND log.scan_time <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$list = pdo_fetchall('SELECT log.*, mc.id as mcid, mc.nickname as nickname_mc, mc.avatar as avatar_mc, ms.id as msid, ms.nickname as nickname_ms, ms.avatar as avatar_ms FROM ' . tablename('ewei_shop_invitation_log') . ' log LEFT JOIN ' . tablename('ewei_shop_member') . ' mc ON mc.openid=log.openid LEFT JOIN' . tablename('ewei_shop_member') . ' ms ON ms.openid=log.invitation_openid WHERE 1' . $condition . ' ORDER BY log.scan_time DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_invitation_log') . ' log LEFT JOIN ' . tablename('ewei_shop_member') . ' mc ON mc.openid=log.openid LEFT JOIN' . tablename('ewei_shop_member') . ' ms ON ms.openid=log.invitation_openid WHERE 1' . $condition, $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}
}

?>
