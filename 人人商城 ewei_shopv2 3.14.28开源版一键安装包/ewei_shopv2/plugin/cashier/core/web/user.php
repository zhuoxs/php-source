<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class User_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = '';
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' and ( name like :keyword or mobile like :keyword or title like :keyword)';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		if ($_GPC['categoryid'] != '') {
			$condition .= ' and categoryid=' . intval($_GPC['categoryid']);
		}

		if ($_GPC['status'] != '') {
			$condition .= ' and status=' . intval($_GPC['status']);
		}

		$sql = 'select * from ' . tablename('ewei_shop_cashier_user') . (' where uniacid=:uniacid AND deleted=0 ' . $condition . ' ORDER BY id desc limit ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_cashier_user') . (' where uniacid=:uniacid AND deleted=0 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$category = $this->model->categoryAll();
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
		$userset = array();

		if ($id) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_cashier_user') . ' where id=:id AND deleted=0 and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

			if ($item['set']) {
				$userset = json_decode($item['set'], true);
			}

			if (!empty($item['openid'])) {
				$openid = m('member')->getMember($item['openid']);
			}

			if (!empty($item['manageopenid'])) {
				$manageopenid = m('member')->getMember($item['manageopenid']);
			}

			if (!empty($item['management'])) {
				$item['management'] = trim($item['management'], ',');
				$item['management'] = str_replace(',', '\',\'', $item['management']);
				$management = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member') . (' WHERE  uniacid=:uniacid AND `openid` IN (\'' . $item['management'] . '\')'), array(':uniacid' => $_W['uniacid']));
			}

			$operator = array();

			if (!empty($item['notice_openids'])) {
				$openids = array();
				$strsopenids = explode(',', $item['notice_openids']);

				foreach ($strsopenids as $value) {
					$openids[] = '\'' . $value . '\'';
				}

				$operator = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

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

		if ($_W['ispost']) {
			$wechatpay = '';

			if (is_array($_GPC['wechatpay'])) {
				$wechatpay = $_GPC['wechatpay'];

				if ($_FILES['cert_file']['name']) {
					$wechatpay['cert'] = $this->model->upload_cert('cert_file');
				}

				if ($_FILES['key_file']['name']) {
					$wechatpay['key'] = $this->model->upload_cert('key_file');
				}

				if ($_FILES['root_file']['name']) {
					$wechatpay['root'] = $this->model->upload_cert('root_file');
				}

				$wechatpay = json_encode($wechatpay);
			}

			if (!empty($item)) {
				$alipay_yuan = json_decode($item['alipay'], true);

				if (empty($_GPC['alipay']['publickey'])) {
					$_GPC['alipay']['publickey'] = $alipay_yuan['publickey'];
				}

				if (empty($_GPC['alipay']['privatekey'])) {
					$_GPC['alipay']['privatekey'] = $alipay_yuan['privatekey'];
				}

				if (empty($_GPC['alipay']['alipublickey'])) {
					$_GPC['alipay']['alipublickey'] = $alipay_yuan['alipublickey'];
				}

				$userset['printer_status'] = intval($_GPC['printer_status']);
				$userset['printer'] = isset($_GPC['printer']) ? implode(',', $_GPC['printer']) : '';
				$userset['printer_template'] = trim($_GPC['printer_template']);
				$userset['printer_template_default'] = trim($_GPC['printer_template_default']);
				$userset['credit1'] = trim($_GPC['credit1']);
				$userset['credit1_double'] = empty($_GPC['credit1_double']) ? 1 : (double) $_GPC['credit1_double'];
			}

			$alipay = is_array($_GPC['alipay']) ? json_encode($_GPC['alipay']) : '';
			$lifetime = $_GPC['lifetime'];
			$params = array('uniacid' => $_W['uniacid'], 'storeid' => $_GPC['storeid'], 'merchid' => $_GPC['merchid'], 'setmeal' => $_GPC['setmeal'], 'title' => $_GPC['title'], 'logo' => $_GPC['logo'], 'manageopenid' => $_GPC['manageopenid'], 'isopen_commission' => $_GPC['isopen_commission'], 'openid' => $_GPC['openid'], 'name' => $_GPC['name'], 'mobile' => $_GPC['mobile'], 'categoryid' => $_GPC['categoryid'], 'wechat_status' => $_GPC['wechat_status'], 'wechatpay' => $wechatpay, 'alipay_status' => $_GPC['alipay_status'], 'alipay' => $alipay, 'withdraw' => $_GPC['withdraw'], 'username' => $_GPC['username'], 'password' => !empty($_GPC['password']) ? $_GPC['password'] : '', 'status' => $_GPC['status'], 'lifetimestart' => strtotime($lifetime['start']), 'lifetimeend' => strtotime($lifetime['end']), 'set' => json_encode($userset), 'can_withdraw' => intval($_GPC['can_withdraw']), 'show_paytype' => intval($_GPC['show_paytype']), 'couponid' => is_array($_GPC['couponid']) ? implode(',', $_GPC['couponid']) : '', 'management' => is_array($_GPC['management']) ? implode(',', $_GPC['management']) : '', 'notice_openids' => is_array($_GPC['notice_openids']) ? implode(',', $_GPC['notice_openids']) : '');
			$user_totle = (int) pdo_fetchcolumn('SELECT id FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE username=:username AND uniacid=:uniacid AND deleted=0 LIMIT 1', array(':username' => $params['username'], ':uniacid' => $_W['uniacid']));
			$store = pdo_fetch('SELECT id,storeid FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE uniacid=:uniacid AND deleted=0 LIMIT 1', array(':uniacid' => $_W['uniacid']));
			$merch = pdo_fetch('SELECT id,merchid FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE uniacid=:uniacid AND deleted=0 LIMIT 1', array(':uniacid' => $_W['uniacid']));

			if ($id) {
				if ($user_totle && $user_totle != $id) {
					show_json(0, '该登录用户名称,已经存在!请更换!');
				}

				if ($merch && !empty($params['merchid']) && $merch['merchid'] == $params['merchid'] && $merch['id'] != $id) {
					show_json(0, '该商户收银台,已经存在!请更换!');
				}

				if ($store && !empty($params['storeid']) && $store['storeid'] == $params['storeid'] && $store['id'] != $id) {
					show_json(0, '该门店收银台,已经存在!请更换!');
				}

				$params['id'] = $id;

				if ($item['status'] != $params['status']) {
					if ($params['status'] == 0) {
						$message = '关闭';
					}
					else {
						if ($params['status'] == 1) {
							$message = '开启';
						}
					}

					$this->model->sendMessage(array('name' => $params['name'], 'mobile' => $params['mobile'], 'status' => $message, 'createtime' => time()), 'checked', $params['manageopenid']);
				}
			}
			else {
				if ($user_totle) {
					show_json(0, '该登录用户名称,已经存在!请更换!');
				}

				if ($merch && !empty($params['merchid']) && $merch['merchid'] == $params['merchid']) {
					show_json(0, '该商户收银台,已经存在!请更换!');
				}

				if ($store && !empty($params['storeid']) && $store['storeid'] == $params['storeid']) {
					show_json(0, '该门店收银台,已经存在!请更换!');
				}
			}

			$res = $this->model->savaUser($params);

			if (isset($res['createtime'])) {
				plog('cashier.user.add', '添加收银台 ID: ' . $res['id'] . ' 收银台名: ' . $res['title'] . '<br/>帐号: ' . $res['username']);
			}
			else {
				plog('cashier.user.edit', '编辑收银台 ID: ' . $res['id'] . ' 收银台名: ' . $item['title'] . ' -> ' . $res['title'] . '<br/>帐号: ' . $item['username'] . ' -> ' . $res['username']);
			}

			show_json(1, array('url' => webUrl('cashier/user/edit', array('id' => $res['id'], 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$category = $this->model->categoryAll();

		if (!empty($item['storeid'])) {
			$store = pdo_fetch('SELECT id,storename FROM ' . tablename('ewei_shop_store') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $item['storeid']));
		}

		$merch = p('merch');

		if ($merch) {
			$data = m('common')->getPluginset('merch');
			if (!empty($item['merchid']) && !empty($data['is_openmerch'])) {
				$merchres = pdo_fetch('select id,merchname from ' . tablename('ewei_shop_merch_user') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['merchid'], ':uniacid' => $_W['uniacid']));
			}
		}

		$wechatpay = json_decode($item['wechatpay'], true);
		$alipay = json_decode($item['alipay'], true);
		$order_template = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_printer_template') . ' WHERE uniacid=:uniacid  AND merchid=0', array(':uniacid' => $_W['uniacid']));
		$order_printer_array = array();

		if (!empty($userset['printer'])) {
			$order_printer_array = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_printer') . ' WHERE uniacid=:uniacid AND id IN (' . $userset['printer'] . ')', array(':uniacid' => $_W['uniacid']));
		}

		if (!empty($item['couponid'])) {
			$coupon = pdo_fetchall('SELECT id,couponname as title , thumb  FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . $_W['uniacid'] . ' and id in (' . $item['couponid'] . ')');
		}

		include $this->template();
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_cashier_user') . (' WHERE id in(' . $id . ') AND deleted=0 AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_cashier_user', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('cashier.user.edit', '修改收银台账户状态<br/>ID: ' . $item['id'] . '<br/>收银台名称: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '启用' : '禁用');
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_cashier_user') . (' WHERE id in(' . $id . ') AND deleted=0 AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_cashier_user', array('deleted' => 1), array('id' => $item['id']));
			plog('cashier.user.delete', '删除`收银台 <br/>收银台:  ID: ' . $item['id'] . ' / 名称:   ' . $item['title']);
		}

		show_json(1);
	}
}

?>
