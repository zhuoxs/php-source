<?php
//QQ63779278
require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/mobile_cashier.php';
class Register_EweiShopV2Page extends CashierMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['cashier'];

		if (empty($set['isopen'])) {
			$this->message('未开启收银台', '', 'error');
		}

		$user = $this->model->userInfo($_W['openid']);
		$id = $user ? $user['id'] : 0;
		$diyform_flag = 0;
		$diyform_plugin = p('diyform');
		$f_data = array();
		if ($diyform_plugin && !empty($_W['shopset']['cashier']['apply_diyform'])) {
			if (!empty($item['diyformdata'])) {
				$diyform_flag = 1;
				$fields = iunserializer($item['diyformfields']);
				$f_data = iunserializer($item['diyformdata']);
			}
			else {
				$diyform_id = $_W['shopset']['cashier']['apply_diyformid'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);

					if (!empty($formInfo)) {
						$diyform_flag = 1;
						$fields = $formInfo['fields'];
					}
				}
			}
		}

		$reason = $this->model->getUserSet('reason', $id);

		if ($_W['ispost']) {
			if (empty($set['apply_openmobile'])) {
				show_json(0, '未开启收银台申请!');
			}

			if (!empty($user) && 1 <= $user['status']) {
				show_json(0, '您已经申请，无需重复申请!');
			}

			$params = array('uniacid' => $_W['uniacid'], 'title' => $_GPC['title'], 'idcard1' => trim($_GPC['idcard1']), 'idcard2' => trim($_GPC['idcard2']), 'openid' => $_W['openid'], 'name' => $_GPC['name'], 'mobile' => $_GPC['mobile'], 'address' => isset($_GPC['address']) ? $_GPC['address'] : '', 'referrer' => isset($_GPC['referrer']) ? $_GPC['referrer'] : '', 'referrermobile' => isset($_GPC['referrermobile']) ? $_GPC['referrermobile'] : '', 'username' => $_GPC['username'], 'password' => isset($_GPC['password']) ? $_GPC['password'] : '', 'credit1' => isset($_GPC['credit1']) ? $_GPC['credit1'] : 0, 'status' => 0);

			if ($id) {
				$user_totle = pdo_fetch('SELECT id FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE username=:username AND uniacid=:uniacid AND status=1 LIMIT 1', array(':username' => $params['username'], ':uniacid' => $_W['uniacid']));
				if ($user_totle && $user_totle['id'] != $id) {
					show_json(0, '该登录用户名称,已经存在!请更换!');
				}

				$params['id'] = $id;
			}

			$res = $this->model->savaUser($params, isset($_GPC['mdata']) ? $_GPC['mdata'] : array());

			if (isset($res['createtime'])) {
				plog('cashier.user.add', '添加收银台 ID: ' . $res['id'] . ' 收银台名: ' . $res['title'] . '<br/>帐号: ' . $res['username']);
			}
			else {
				plog('cashier.user.edit', '编辑收银台 ID: ' . $res['id'] . ' 收银台名: ' . $user['title'] . ' -> ' . $res['title'] . '<br/>帐号: ' . $user['username'] . ' -> ' . $res['username']);
			}

			if (!$id) {
				$this->model->sendMessage(array('name' => $res['name'], 'mobile' => $res['mobile'], 'createtime' => $res['createtime']), 'apply');
			}

			show_json(1);
		}

		if (empty($set['apply_openmobile'])) {
			$this->message('未开启收银台申请!', '', 'error');
		}

		include $this->template();
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

		include $this->template('_message');
		exit();
	}
}

?>
