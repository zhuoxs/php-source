<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Sysset_EweiShopV2Page extends CashierWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_W['cashierid']);
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_cashier_user') . ' where id=:id AND deleted=0 and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

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
			}

			$alipay = is_array($_GPC['alipay']) ? json_encode($_GPC['alipay']) : '';
			$params = array('uniacid' => $_W['uniacid'], 'title' => $_GPC['title'], 'logo' => $_GPC['logo'], 'manageopenid' => $_GPC['manageopenid'], 'isopen_commission' => $_GPC['isopen_commission'], 'openid' => $_GPC['openid'], 'name' => $_GPC['name'], 'mobile' => $_GPC['mobile'], 'wechat_status' => $_GPC['wechat_status'], 'wechatpay' => $wechatpay, 'alipay_status' => $_GPC['alipay_status'], 'alipay' => $alipay, 'username' => $_GPC['username'], 'password' => !empty($_GPC['password']) ? $_GPC['password'] : '', 'management' => is_array($_GPC['management']) ? implode(',', $_GPC['management']) : '');

			if (empty($item['show_paytype'])) {
				unset($params['wechat_status']);
				unset($params['wechatpay']);
				unset($params['alipay_status']);
				unset($params['alipay']);
			}

			$user_totle = (int) pdo_fetchcolumn('SELECT id FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE username=:username AND uniacid=:uniacid AND deleted=0 LIMIT 1', array(':username' => $params['username'], ':uniacid' => $_W['uniacid']));

			if ($id) {
				if ($user_totle && $user_totle != $id) {
					show_json(0, '该登录用户名称,已经存在!请更换!');
				}
			}
			else {
				if ($user_totle) {
					show_json(0, '该登录用户名称,已经存在!请更换!');
				}
			}

			$res = $this->model->savaUser(array_merge($item, $params));

			if (isset($res['createtime'])) {
				plog('cashier.user.add', '添加收银台 ID: ' . $res['id'] . ' 收银台名: ' . $res['title'] . '<br/>帐号: ' . $res['username']);
			}
			else {
				plog('cashier.user.edit', '编辑收银台 ID: ' . $res['id'] . ' 收银台名: ' . $item['title'] . ' -> ' . $res['title'] . '<br/>帐号: ' . $item['username'] . ' -> ' . $res['username']);
			}

			$_SESSION['__cashier_' . (int) $_GPC['i'] . '_session'] = $res;
			show_json(1);
		}

		$wechatpay = json_decode($item['wechatpay'], true);
		$alipay = json_decode($item['alipay'], true);
		include $this->template();
	}

	public function userset()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = $_GPC['data'];
			$data['bg'] = $_GPC['bg'];
			$data['manageopenid'] = $_GPC['manageopenid'];
			$this->updateUserSet($data);
			show_json(1, array('url' => cashierUrl('sysset/userset', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$item = $this->getUserSet();
		$manageopenid = array();

		if (!empty($item['manageopenid'])) {
			$openids = '\'' . implode('\',\'', $item['manageopenid']) . '\'';
			$manageopenid = pdo_fetchall('SELECT id,openid,avatar,nickname FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid=:uniacid AND openid IN (' . $openids . ')', array(':uniacid' => $_W['uniacid']));
		}

		include $this->template();
	}
}

?>
