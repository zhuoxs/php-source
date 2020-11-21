<?php
//QQ63779278
class Register_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['merch'];

		if (empty($set['apply_openmobile'])) {
			$this->message('未开启商户入驻申请', '', 'error');
		}

		$reg = pdo_fetch('select * from ' . tablename('ewei_shop_merch_reg') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
		$user = false;

		if (!empty($reg['status'])) {
			$user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
		}

		if (!empty($user) && 1 <= $user['status']) {
			$this->message('您已经申请，无需重复申请!', '', 'error');
		}

		$apply_set = array();
		$apply_set['open_protocol'] = $set['open_protocol'];

		if (empty($set['applytitle'])) {
			$apply_set['applytitle'] = '入驻申请协议';
		}
		else {
			$apply_set['applytitle'] = $set['applytitle'];
		}

		$template_flag = 0;
		$diyform_plugin = p('diyform');
		$fields = array();

		if ($diyform_plugin) {
			$area_set = m('util')->get_area_config_set();
			$new_area = intval($area_set['new_area']);
			if (!empty($set['apply_diyform']) && !empty($set['apply_diyformid'])) {
				$template_flag = 1;
				$diyform_id = $set['apply_diyformid'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);
					$fields = $formInfo['fields'];
					$diyform_data = iunserializer($reg['diyformdata']);
					$member = m('member')->getMember($_W['openid']);
					$f_data = $diyform_plugin->getDiyformData($diyform_data, $fields, $member);
				}
			}
		}

		if ($_W['ispost']) {
			if (empty($set['apply_openmobile'])) {
				show_json(0, '未开启商户入驻申请!');
			}

			if (!empty($user) && 1 <= $user['status']) {
				show_json(0, '您已经申请，无需重复申请!');
			}

			$uname = trim($_GPC['uname']);
			$upass = $_GPC['upass'];

			if (empty($uname)) {
				show_json(0, '请填写帐号!');
			}

			if (empty($upass)) {
				show_json(0, '请填写密码!');
			}

			$where1 = ' uname=:uname';
			$params1 = array(':uname' => $uname);
			$where1 .= ' and uniacid = :uniacid ';
			$params1[':uniacid'] = $_W['uniacid'];

			if (!empty($reg)) {
				$where1 .= ' and id<>:id';
				$params1[':id'] = $reg['id'];
			}

			$usercount1 = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_merch_reg') . (' where ' . $where1 . ' limit 1'), $params1);
			$where2 = ' username=:username';
			$where2 .= ' and uniacid=:uniacid';
			$params2 = array(':username' => $uname);
			$params2['uniacid'] = $_W['uniacid'];
			$usercount2 = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_merch_account') . (' where ' . $where2 . ' limit 1'), $params2);
			if (0 < $usercount1 || 0 < $usercount2) {
				show_json(0, '帐号 ' . $uname . ' 已经存在,请更改!');
			}

			$upass = m('util')->pwd_encrypt($upass, 'E');
			$data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'status' => 0, 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']), 'uname' => $uname, 'upass' => $upass, 'merchname' => trim($_GPC['merchname']), 'salecate' => trim($_GPC['salecate']), 'desc' => trim($_GPC['desc']));

			if ($template_flag == 1) {
				$mdata = $_GPC['mdata'];
				$insert_data = $diyform_plugin->getInsertData($fields, $mdata);
				$datas = $insert_data['data'];
				$m_data = $insert_data['m_data'];
				$mc_data = $insert_data['mc_data'];
				$data['diyformfields'] = iserializer($fields);
				$data['diyformdata'] = $datas;
			}

			if (empty($reg)) {
				$data['applytime'] = time();
				pdo_insert('ewei_shop_merch_reg', $data);
				$regid = pdo_insertid();
				$user = array('uniacid' => $_W['uniacid'], 'merchname' => trim($data['merchname']), 'salecate' => trim($data['salecate']), 'realname' => $data['realname'], 'mobile' => trim($data['mobile']), 'status' => -1, 'regid' => $regid, 'upass' => $data['upass'], 'openid' => $_W['openid'], 'uname' => $uname);
				pdo_insert('ewei_shop_merch_user', $user);
			}
			else {
				pdo_update('ewei_shop_merch_reg', $data, array('id' => $reg['id']));
				$user = array('uniacid' => $_W['uniacid'], 'merchname' => trim($data['merchname']), 'salecate' => trim($data['salecate']), 'realname' => $data['realname'], 'mobile' => trim($data['mobile']), 'status' => -1, 'regid' => $reg['id'], 'uname' => $uname, 'openid' => $_W['openid'], 'upass' => $data['upass']);
				pdo_update('ewei_shop_merch_user', $user, array('regid' => $reg['id'], 'uniacid' => $_W['uniacid']));
			}

			$this->model->sendMessage(array('merchname' => $data['merchname'], 'salecate' => $data['salecate'], 'realname' => $data['realname'], 'mobile' => $data['mobile'], 'applytime' => time()), 'merch_apply');
			show_json(1);
		}

		include $this->template();
	}

	public function notice()
	{
		global $_W;
		$set = $_W['shopset']['merch'];
		include $this->template('merch/register_notice');
	}

	public function message($msg, $redirect = '', $type = '')
	{
		global $_W;
		$title = '';
		$buttontext = '';
		$message = $msg;

		if (is_array($msg)) {
			$message = isset($msg['message']) ? $msg['message'] : '';
			$title = isset($msg['title']) ? $msg['title'] : '';
			$buttontext = isset($msg['buttontext']) ? $msg['buttontext'] : '';
		}

		if (empty($redirect)) {
			$redirect = 'javascript:history.back(-1);';
		}
		else {
			if ($redirect == 'close') {
				$redirect = 'javascript:WeixinJSBridge.call("closeWindow")';
			}
		}

		$buttondisplay = true;
		include $this->template('_message');
		exit();
	}
}

?>
