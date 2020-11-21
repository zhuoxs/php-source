<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Task_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$task_mode = m('cache')->getString('task_mode', 'global');
		$receive_time = m('cache')->getString('receive_time', 'global');
		$closeorder_time = m('cache')->getString('closeorder_time', 'global');
		$willcloseorder_time = m('cache')->getString('willcloseorder_time', 'global');
		$couponback_time = m('cache')->getString('couponback_time', 'global');
		$groups_order_cancelorder_time = m('cache')->getString('groups_order_cancelorder_time', 'global');
		$groups_team_refund_time = m('cache')->getString('groups_team_refund_time', 'global');
		$groups_receive_time = m('cache')->getString('groups_receive_time', 'global');
		$fullback_receive_time = m('cache')->getString('fullback_receive_time', 'global');
		$status_receive_time = m('cache')->getString('status_receive_time', 'global');
		$presell_status_time = m('cache')->getString('presell_status_time', 'global');
		$liveroom_receive_time = m('cache')->getString('liveroom_receive_time', 'global');

		if ($_W['ispost']) {
			m('cache')->set('task_mode', intval($_GPC['task_mode']), 'global');
			m('cache')->set('receive_time', intval($_GPC['receive_time']), 'global');
			m('cache')->set('closeorder_time', intval($_GPC['closeorder_time']), 'global');
			m('cache')->set('willcloseorder_time', intval($_GPC['willcloseorder_time']), 'global');
			m('cache')->set('couponback_time', intval($_GPC['couponback_time']), 'global');
			m('cache')->set('groups_order_cancelorder_time', intval($_GPC['groups_order_cancelorder_time']), 'global');
			m('cache')->set('groups_team_refund_time', intval($_GPC['groups_team_refund_time']), 'global');
			m('cache')->set('groups_receive_time', intval($_GPC['groups_receive_time']), 'global');
			m('cache')->set('fullback_receive_time', intval($_GPC['fullback_receive_time']), 'global');
			m('cache')->set('status_receive_time', intval($_GPC['status_receive_time']), 'global');
			m('cache')->set('presell_status_time', intval($_GPC['presell_status_time']), 'global');
			m('cache')->set('liveroom_receive_time', intval($_GPC['liveroom_receive_time']), 'global');
			show_json(1);
		}

		include $this->template();
	}
}

?>
