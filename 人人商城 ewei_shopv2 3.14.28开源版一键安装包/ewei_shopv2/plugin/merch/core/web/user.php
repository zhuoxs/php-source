<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class User_EweiShopV2Page extends PluginWebPage
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
			$condition .= ' and ( u.merchname like :keyword or u.realname like :keyword or u.mobile like :keyword)';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		if ($_GPC['groupid'] != '') {
			$condition .= ' and u.groupid=' . intval($_GPC['groupid']);
		}

		if ($_GPC['status'] != '') {
			$status = intval($_GPC['status']);

			if ($status == 4) {
				$condition .= ' and u.status=1 and TIMESTAMPDIFF(DAY,now(),FROM_UNIXTIME(u.accounttime)) <= 0';
			}
			else if ($status == 3) {
				$condition .= ' and u.status=1 and TIMESTAMPDIFF(DAY,now(),FROM_UNIXTIME(u.accounttime)) > 0 and TIMESTAMPDIFF(DAY,now(),FROM_UNIXTIME(u.accounttime)) <= 30 ';
			}
			else {
				$condition .= ' and u.status=' . $status;
			}
		}

		if ($_GPC['status'] == '0') {
			$sortfield = 'u.applytime';
		}
		else {
			$sortfield = 'u.jointime';
		}

		$sql = 'select  u.*,g.groupname  from ' . tablename('ewei_shop_merch_user') . '  u ' . ' left join  ' . tablename('ewei_shop_merch_group') . ' g on u.groupid = g.id ' . (' where u.uniacid=:uniacid ' . $condition . ' ORDER BY ' . $sortfield . ' desc');

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from' . tablename('ewei_shop_merch_user') . ' u  ' . ' left join  ' . tablename('ewei_shop_merch_group') . ' g on u.groupid = g.id ' . (' where u.uniacid = :uniacid ' . $condition), $params);

		if ($_GPC['export'] == '1') {
			ca('merch.user.export');
			plog('merch.user.export', '导出商户数据');

			foreach ($list as &$row) {
				$row['applytime'] = empty($row['applytime']) ? '-' : date('Y-m-d H:i', $row['applytime']);
				$row['checktime'] = empty($row['checktime']) ? '-' : date('Y-m-d H:i', $row['checktime']);
				$row['groupname'] = empty($row['groupid']) ? '无分组' : $row['groupname'];
				$row['statusstr'] = empty($row['status']) ? '待审核' : ($row['status'] == 1 ? '通过' : '未通过');
				$row['accounttime'] = date('Y-m-d H:i', $row['accounttime']);
			}

			unset($row);
			m('excel')->export($list, array(
				'title'   => '商户数据-' . date('Y-m-d-H-i', time()),
				'columns' => array(
					array('title' => 'ID', 'field' => 'id', 'width' => 12),
					array('title' => '商户名', 'field' => 'merchname', 'width' => 24),
					array('title' => '主营项目', 'field' => 'salecate', 'width' => 12),
					array('title' => '联系人', 'field' => 'realname', 'width' => 12),
					array('title' => '手机号', 'field' => 'moible', 'width' => 12),
					array('title' => '子帐号数', 'field' => 'accounttotal', 'width' => 12),
					array('title' => '可提现金额', 'field' => 'status0', 'width' => 12),
					array('title' => '已结算金额', 'field' => 'status3', 'width' => 12),
					array('title' => '到期时间', 'field' => 'accounttime', 'width' => 12),
					array('title' => '申请时间', 'field' => 'applytime', 'width' => 12),
					array('title' => '审核时间', 'field' => 'checktime', 'width' => 12),
					array('title' => '状态', 'field' => 'createtime', 'width' => 12)
				)
			));
		}

		$pager = pagination2($total, $pindex, $psize);
		load()->func('tpl');
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);

		if (empty($id)) {
			$max_flag = $this->model->checkMaxMerchUser(1);

			if ($max_flag == 1) {
				$this->message('已经达到最大商户数量,不能再添加商户', webUrl('merch/user'), 'error');
			}
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($item)) {
			$item['iscredit'] = 1;
			$item['iscreditmoney'] = 1;
		}

		if (!empty($item['openid'])) {
			$member = m('member')->getMember($item['openid']);
		}

		if (!empty($item['payopenid'])) {
			$user = m('member')->getMember($item['payopenid']);
		}

		if (empty($item) || empty($item['accounttime'])) {
			$accounttime = strtotime('+365 day');
		}
		else {
			$accounttime = $item['accounttime'];
		}

		if (!empty($item['accountid'])) {
			$account = pdo_fetch('select * from ' . tablename('ewei_shop_merch_account') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['accountid'], ':uniacid' => $_W['uniacid']));
		}

		if (!empty($item['pluginset'])) {
			$item['pluginset'] = iunserializer($item['pluginset']);
		}

		if (empty($account)) {
			$show_name = $item['uname'];
			$show_pass = m('util')->pwd_encrypt($item['upass'], 'D');
		}
		else {
			$show_name = $account['username'];
		}

		$diyform_flag = 0;
		$diyform_plugin = p('diyform');
		$f_data = array();
		if ($diyform_plugin && !empty($_W['shopset']['merch']['apply_diyform'])) {
			if (!empty($item['diyformdata'])) {
				$diyform_flag = 1;
				$fields = iunserializer($item['diyformfields']);
				$f_data = iunserializer($item['diyformdata']);
			}
			else {
				$diyform_id = $_W['shopset']['merch']['apply_diyformid'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);

					if (!empty($formInfo)) {
						$diyform_flag = 1;
						$fields = $formInfo['fields'];
					}
				}
			}
		}

		if ($_W['ispost']) {
			$fdata = array();

			if ($diyform_flag) {
				$fdata = p('diyform')->getPostDatas($fields);

				if (is_error($fdata)) {
					show_json(0, $fdata['message']);
				}
			}

			$status = intval($_GPC['status']);
			$username = trim($_GPC['username']);
			$checkUser = false;

			if (0 < $status) {
				$checkUser = true;
			}

			if (empty($_GPC['groupid'])) {
				show_json(0, '请选择商户组!');
			}

			if (empty($_GPC['cateid'])) {
				show_json(0, '请选择商户分类!');
			}

			if ($checkUser) {
				if (empty($username)) {
					show_json(0, '请填写账户名!');
				}

				if (empty($account) && empty($_GPC['pwd'])) {
					show_json(0, '请填写账户密码!');
				}

				$where = ' username=:username';
				$params = array(':username' => $username);
				$where .= ' and uniacid = :uniacid ';
				$params[':uniacid'] = $_W['uniacid'];

				if (!empty($account)) {
					$where .= ' and id<>:id';
					$params[':id'] = $account['id'];
				}

				$usercount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_merch_account') . (' where ' . $where . ' limit 1'), $params);

				if (0 < $usercount) {
					show_json(0, '账户名 ' . $username . ' 已经存在!');
				}

				if (!empty($account)) {
					if (empty($account['pwd']) && empty($_GPC['pwd'])) {
						show_json(0, '请填写账户密码!');
					}
				}
			}

			$where = ' username=:username';
			$params = array(':username' => $username);
			$where .= ' and uniacid = :uniacid ';
			$params[':uniacid'] = $_W['uniacid'];

			if (!empty($account)) {
				$where .= ' and id<>:id';
				$params[':id'] = $account['id'];
			}

			$usercount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_merch_account') . (' where ' . $where . ' limit 1'), $params);

			if (0 < $usercount) {
				show_json(0, '账户名 ' . $username . ' 已经存在!');
			}

			$salt = '';
			$pwd = '';
			if (empty($account) || empty($account['salt']) || !empty($_GPC['pwd'])) {
				$salt = random(8);

				while (1) {
					$saltcount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_merch_account') . ' where salt=:salt limit 1', array(':salt' => $salt));

					if ($saltcount <= 0) {
						break;
					}

					$salt = random(8);
				}

				$pwd = md5(trim($_GPC['pwd']) . $salt);
			}
			else {
				$salt = $account['salt'];
				$pwd = $account['pwd'];
			}

			if ($_GPC['iscreditmoney'] == 0 && $_GPC['creditrate'] == 0) {
				show_json(0, '开启积分提现，比例不能为0');
			}

			if ($_GPC['iscreditmoney'] == 1) {
				$_GPC['creditrate'] = 0;
			}

			$data = array('uniacid' => $_W['uniacid'], 'merchname' => trim($_GPC['merchname']), 'salecate' => trim($_GPC['salecate']), 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']), 'address' => trim($_GPC['address']), 'tel' => trim($_GPC['tel']), 'lng' => $_GPC['map']['lng'], 'lat' => $_GPC['map']['lat'], 'accounttime' => strtotime($_GPC['accounttime']), 'accounttotal' => intval($_GPC['accounttotal']), 'maxgoods' => intval($_GPC['maxgoods']), 'groupid' => intval($_GPC['groupid']), 'cateid' => intval($_GPC['cateid']), 'isrecommand' => intval($_GPC['isrecommand']), 'remark' => trim($_GPC['remark']), 'status' => $status, 'desc' => trim($_GPC['desc1']), 'logo' => save_media($_GPC['logo']), 'payopenid' => trim($_GPC['payopenid']), 'payrate' => trim($_GPC['payrate'], '%'), 'pluginset' => iserializer($_GPC['pluginset']), 'creditrate' => intval($_GPC['creditrate']), 'iscredit' => intval($_GPC['iscredit']), 'iscreditmoney' => intval($_GPC['iscreditmoney']));

			if ($diyform_flag) {
				$data['diyformdata'] = iserializer($fdata);
				$data['diyformfields'] = iserializer($fields);
			}

			if (empty($item['jointime']) && $status == 1) {
				$data['jointime'] = time();
			}

			$account = array('uniacid' => $_W['uniacid'], 'merchid' => $id, 'username' => $username, 'pwd' => $pwd, 'salt' => $salt, 'status' => 1, 'perms' => serialize(array()), 'isfounder' => 1);
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if (empty($item)) {
				$item['applytime'] = time();
				pdo_insert('ewei_shop_merch_user', $data);
				$id = pdo_insertid();
				$account['merchid'] = $id;
				pdo_insert('ewei_shop_merch_account', $account);
				$accountid = pdo_insertid();
				pdo_update('ewei_shop_merch_user', array('accountid' => $accountid), array('id' => $id));
				plog('merch.user.add', '添加商户 ID: ' . $data['id'] . ' 商户名: ' . $data['merchname'] . '<br/>帐号: ' . $data['username'] . '<br/>子帐号数: ' . $data['accounttotal'] . '<br/>到期时间: ' . date('Y-m-d', $data['accounttime']));
			}
			else {
				pdo_update('ewei_shop_merch_user', $data, array('id' => $id));

				if (!empty($item['accountid'])) {
					pdo_update('ewei_shop_merch_account', $account, array('id' => $item['accountid']));
				}
				else {
					pdo_insert('ewei_shop_merch_account', $account);
					$accountid = pdo_insertid();
					pdo_update('ewei_shop_merch_user', array('accountid' => $accountid), array('id' => $id));
				}

				plog('merch.user.edit', '编辑商户 ID: ' . $data['id'] . ' 商户名: ' . $item['merchname'] . ' -> ' . $data['merchname'] . '<br/>帐号: ' . $item['username'] . ' -> ' . $data['username'] . '<br/>子帐号数: ' . $item['accounttotal'] . ' -> ' . $data['accounttotal'] . '<br/>到期时间: ' . date('Y-m-d', $item['accounttime']) . ' -> ' . date('Y-m-d', $data['accounttime']));
			}

			show_json(1, array('url' => webUrl('merch/user', array('status' => $item['status']))));
		}

		$plugins_data = $this->model->getPluginList();
		$plugins_list = $plugins_data['plugins_list'];
		$groups = $this->model->getGroups();
		$category = $this->model->getCategory();
		include $this->template();
	}

	public function get_show_money()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$tmoney = $this->model->getMerchOrderTotalPrice($id);
			show_json(1, array('status0' => $tmoney['status0'], 'status3' => $tmoney['status3']));
		}
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,merchname FROM ' . tablename('ewei_shop_merch_user') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_merch_user', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('merch.group.edit', '修改商户分组账户状态<br/>ID: ' . $item['id'] . '<br/>商户名称: ' . $item['merchname'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '启用' : '禁用');
		}

		show_json(1);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$uniacid = $_W['uniacid'];
		$change_data = array();
		$change_data['merchid'] = 0;
		$change_data['status'] = 0;
		$items = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_merch_user') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_goods', $change_data, array('merchid' => $item['id'], 'uniacid' => $uniacid));
			pdo_delete('ewei_shop_merch_reg', array('id' => $item['regid']));
			pdo_delete('ewei_shop_merch_account', array('merchid' => $item['id'], 'uniacid' => $uniacid));
			pdo_delete('ewei_shop_merch_user', array('id' => $item['id'], 'uniacid' => $uniacid));
			plog('merch.user.delete', '删除`商户 <br/>商户:  ID: ' . $item['id'] . ' / 名称:   ' . $item['merchname']);
		}

		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = 'uniacid=:uniacid AND status=1';

		if (!empty($kwd)) {
			$condition .= ' AND `merchname` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,merchname FROM ' . tablename('ewei_shop_merch_user') . (' WHERE ' . $condition . ' order by id asc'), $params);
		include $this->template();
		exit();
	}

	public function querymerchs()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid  and status =1';

		if (!empty($kwd)) {
			$condition .= ' AND `merchname` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,merchname as title ,logo as thumb FROM ' . tablename('ewei_shop_merch_user') . (' WHERE 1 ' . $condition . ' order by id desc'), $params);
		$ds = set_medias($ds, array('thumb', 'share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}
}

?>
