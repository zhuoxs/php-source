<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Reg_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$groups = $this->model->getGroups();
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = '';
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' and ( merchname like :keyword or realname like :keyword or mobile like :keyword)';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		$sql = 'select  *  from ' . tablename('ewei_shop_merch_reg') . ('   where uniacid=:uniacid ' . $condition . ' ORDER BY  applytime desc');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_merch_reg') . ('  where uniacid = :uniacid ' . $condition), $params);

		if ($_GPC['export'] == '1') {
			ca('merch.user.export');
			plog('merch.user.export', '导出商户申请数据');

			foreach ($list as &$row) {
				$row['applytime'] = empty($row['applytime']) ? '-' : date('Y-m-d H:i', $row['applytime']);
				$row['statusstr'] = empty($row['status']) ? '待审核' : ($row['status'] == 1 ? '已入驻' : '驳回');
			}

			unset($row);
			m('excel')->export($list, array(
	'title'   => '商户数据-' . date('Y-m-d-H-i', time()),
	'columns' => array(
		array('title' => 'ID', 'field' => 'id', 'width' => 12),
		array('title' => '商户名', 'field' => 'merchname', 'width' => 24),
		array('title' => '主营项目', 'field' => 'salecate', 'width' => 12),
		array('title' => '商家简介', 'field' => 'desc', 'width' => 24),
		array('title' => '联系人', 'field' => 'realname', 'width' => 12),
		array('title' => '手机号', 'field' => 'moible', 'width' => 12),
		array('title' => '申请时间', 'field' => 'applytime', 'width' => 12),
		array('title' => '状态', 'field' => 'statusstr', 'width' => 12)
		)
	));
		}

		$pager = pagination2($total, $pindex, $psize);
		load()->func('tpl');
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$id = intval($_GPC['id']);
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_merch_reg') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($item)) {
			if ($_W['ispost']) {
				show_json(0, '未找到商户入驻申请!');
			}

			$this->message('未找到商户入驻申请!', webUrl('merch/reg', array('status' => 0)), 'error');
		}

		$member = m('member')->getMember($item['openid']);
		$diyform_flag = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			if (!empty($item['diyformdata'])) {
				$diyform_flag = 1;
				$fields = iunserializer($item['diyformfields']);
				$f_data = iunserializer($item['diyformdata']);
			}
		}

		if ($_W['ispost']) {
			$status = intval($_GPC['status']);
			$reason = trim($_GPC['reason']);

			if ($status == -1) {
				if (empty($reason)) {
					show_json(0, '请填写驳回理由.');
				}
			}
			else {
				$this->model->checkMaxMerchUser();
			}

			if ($diyform_flag) {
				$item['diyformfields'] = iserializer($fields);
				$formdata = p('diyform')->getPostDatas($fields);

				if (is_error($formdata)) {
					show_json(0, $formdata['message']);
				}

				$item['diyformdata'] = iserializer($formdata);
			}

			$item['status'] = $status;
			$item['reason'] = $reason;
			$item['merchname'] = trim($_GPC['merchname']);
			$item['salecate'] = trim($_GPC['salecate']);
			$item['desc'] = trim($_GPC['desc']);
			$item['realname'] = trim($_GPC['realname']);
			$item['mobile'] = trim($_GPC['mobile']);
			pdo_update('ewei_shop_merch_reg', $item, array('id' => $item['id']));

			if ($status == 1) {
				$usercount = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where regid=:regid and uniacid=:uniacid limit 1', array(':regid' => $item['id'], ':uniacid' => $_W['uniacid']));

				if (empty($usercount)) {
					$user = $item;
					unset($user['id']);
					unset($user['reason']);
					$user['regid'] = $item['id'];
					$user['status'] = 0;
					pdo_insert('ewei_shop_merch_user', $user);
					$userid = pdo_insertid();
					pdo_update('ewei_shop_merch_reg', $item, array('id' => $item['id']));

					if (ca('merch.user.edit')) {
						show_json(1, array('message' => '允许入驻成功，请编辑商户账户资料!', 'url' => webUrl('merch/user/edit', array('id' => $userid))));
					}
					else {
						show_json(1);
					}
				}
				else {
					$user = $item;
					unset($user['id']);
					unset($user['reason']);
					$user['status'] = 0;
					pdo_update('ewei_shop_merch_user', $user, array('uniacid' => $_W['uniacid'], 'regid' => $item['id']));
					pdo_update('ewei_shop_merch_reg', $item, array('id' => $item['id']));

					if (ca('merch.user.edit')) {
						show_json(1, array('message' => '允许入驻成功，请编辑商户账户资料!', 'url' => webUrl('merch/user/edit', array('id' => $usercount['id']))));
					}
					else {
						show_json(1);
					}
				}
			}
			else {
				if ($status == -1) {
					pdo_update('ewei_shop_merch_reg', $item, array('id' => $item['id']));
				}
			}

			show_json(1);
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$regs = pdo_fetchall('SELECT id,merchname FROM ' . tablename('ewei_shop_merch_reg') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($regs as $reg) {
			pdo_delete('ewei_shop_merch_reg', array('id' => $reg['id']));
			plog('merch.reg.delete', '删除入驻申请 <br/> 商户名称:  ' . $reg['merchname']);
		}

		show_json(1, array('url' => referer()));
	}
}

?>
