<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		$condition = ' and o.uniacid=:uniacid and o.deleted = :deleted and o.status = :status and (o.success = :success or o.is_team = :is_team) ';
		$params = array(':uniacid' => $_W['uniacid'], ':deleted' => 0, ':success' => 1, ':status' => 1, ':is_team' => 0);
		$order_ok = pdo_fetchall('SELECT o.*,g.title,g.category,g.groupsprice,c.name,g.thumb,m.nickname,m.realname,m.mobile
				FROM ' . tablename('ewei_shop_groups_order') . ' as o
				left join ' . tablename('ewei_shop_groups_goods') . ' as g on g.id = o.goodid
				left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid
				right join ' . tablename('ewei_shop_groups_category') . (' as c on c.id = g.category
				WHERE 1 ' . $condition . '  ORDER BY o.createtime DESC limit 0,10 '), $params);
		include $this->template();
	}

	public function notice()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('notice', false);
		$salers = array();

		if (isset($data['openid'])) {
			if (!empty($data['openid'])) {
				$openids = array();
				$strsopenids = explode(',', $data['openid']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		$newtype = explode(',', $data['newtype']);

		if ($_W['ispost']) {
			ca('sysset.notice.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (is_array($_GPC['openids'])) {
				$data['openid'] = implode(',', $_GPC['openids']);
			}

			if (is_array($data['newtype'])) {
				$data['newtype'] = implode(',', $data['newtype']);
			}

			m('common')->updateSysset(array('notice' => $data));
			plog('sysset.notice.edit', '修改系统设置-模板消息通知设置');
			show_json(1);
		}

		$template_list = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		include $this->template();
	}

	public function notice_user()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('notice', false);
		$salers = array();

		if (isset($data['openid'])) {
			if (!empty($data['openid'])) {
				$openids = array();
				$strsopenids = explode(',', $data['openid']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		$newtype = explode(',', $data['newtype']);
		include $this->template('groups/set/user');
	}
}

?>
