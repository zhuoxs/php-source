<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Setting_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (empty($_W['shopversion'])) {
			$this->message('请使用新版本访问');
		}

		$sets = m('common')->getSysset(array('app', 'pay'));

		if (cv('app.setting.pay')) {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			if (!is_array($sec['wxapp']) || !isset($sec['wxapp'])) {
				$sec['wxapp'] = array();
			}
		}

		if ($_W['ispost']) {
			if ($_GPC['set']['phone'] == 1) {
				if ($_GPC['set']['phonenumber'] == '' || empty($_GPC['set']['phonenumber'])) {
					show_json(0, '请输入客服电话号码');
				}
			}

			if (cv('app.setting.edit')) {
				$arr_set = $sets['app'];
				$arr_set['appid'] = trim($_GPC['set']['appid']);
				$arr_set['secret'] = trim($_GPC['set']['secret']);
				$arr_set['isclose'] = intval($_GPC['set']['isclose']);
				$arr_set['closetext'] = trim($_GPC['set']['closetext']);
				$arr_set['openbind'] = intval($_GPC['set']['openbind']);
				$arr_set['sms_bind'] = intval($_GPC['set']['sms_bind']);
				$arr_set['bindtext'] = trim($_GPC['set']['bindtext']);
				$arr_set['hidecom'] = intval($_GPC['set']['hidecom']);
				$arr_set['navbar'] = intval($_GPC['set']['navbar']);
				$arr_set['sendappurl'] = trim($_GPC['set']['sendappurl']);
				$arr_set['customer'] = intval($_GPC['set']['customer']);
				$arr_set['customercolor'] = trim($_GPC['set']['customercolor']);
				$arr_set['tmessage_pay'] = intval($_GPC['set']['tmessage_pay']);
				$arr_set['tmessage_send'] = intval($_GPC['set']['tmessage_send']);
				$arr_set['tmessage_virtualsend'] = intval($_GPC['set']['tmessage_virtualsend']);
				$arr_set['tmessage_finish'] = intval($_GPC['set']['tmessage_finish']);
				$arr_set['phone'] = intval($_GPC['set']['phone']);
				$arr_set['phonenumber'] = trim($_GPC['set']['phonenumber']);
				$arr_set['phonecolor'] = trim($_GPC['set']['phonecolor']);
				$arr_set['force_auth'] = $_GPC['set']['force_auth'] ? $_GPC['set']['force_auth'] : NULL;
				$arr_set['verifyurl'] = trim($_GPC['set']['verifyurl']);
				if (!strexists($arr_set['verifyurl'], 'http') && !empty($arr_set['verifyurl'])) {
					show_json(0, '请输入正确的核销二维码生成链接');
				}

				if (!empty($arr_set['verifyurl']) && substr($arr_set['verifyurl'], -1) == '/') {
					$arr_set['verifyurl'] = rtrim($arr_set['verifyurl'], '/');
				}

				m('common')->updateSysset(array('app' => $arr_set));
				plog('app.setting.edit', '保存基本设置');
			}

			if (cv('app.setting.pay')) {
				if ($_FILES['wxapp_cert_file']['name']) {
					$sec['wxapp_cert'] = $this->upload_cert('wxapp_cert_file');
				}

				if ($_FILES['wxapp_key_file']['name']) {
					$sec['wxapp_key'] = $this->upload_cert('wxapp_key_file');
				}

				if ($_FILES['wxapp_root_file']['name']) {
					$sec['wxapp_root'] = $this->upload_cert('wxapp_root_file');
				}

				$sec['wxapp']['mchid'] = trim($_GPC['pay']['wxapp_mchid']);
				$sec['wxapp']['apikey'] = trim($_GPC['pay']['wxapp_apikey']);
				pdo_update('ewei_shop_sysset', array('sec' => iserializer($sec)), array('uniacid' => $_W['uniacid']));
				$arr_pay = $sets['pay'];
				$arr_pay['wxapp'] = intval($_GPC['pay']['wxapp']);
				m('common')->updateSysset(array('pay' => $arr_pay));
				plog('app.setting.pay', '保存支付设置');
			}

			show_json(1);
		}

		if (com('sms')) {
			$sms_list = com('sms')->sms_temp();
		}

		$tmsg_list = pdo_fetchall('SELECT id, `name` FROM ' . tablename('ewei_shop_wxapp_tmessage') . 'WHERE uniacid=:uniacid AND status=1', array(':uniacid' => $_W['uniacid']));
		$commission = false;

		if (p('commission')) {
			if (intval(0 < $_W['shopset']['commission']['level'])) {
				$commission = true;
			}
		}

		$customercolors = array('#ff5555', '#000000', '#2ad329', '#46aaff', '#ffb137');
		$customercolor = empty($sets['app']['customercolor']) ? '#ff5555' : $sets['app']['customercolor'];
		$phonecolors = array('#ff5555', '#000000', '#2ad329', '#46aaff', '#ffb137');
		$phonecolor = empty($sets['app']['phonecolor']) ? '#ff5555' : $sets['app']['phonecolor'];
		include $this->template();
	}

	protected function upload_cert($fileinput)
	{
		global $_W;
		$path = IA_ROOT . '/addons/ewei_shopv2/cert';
		load()->func('file');
		mkdirs($path);
		$f = $fileinput . '_' . $_W['uniacid'] . '.pem';
		$outfilename = $path . '/' . $f;
		$filename = $_FILES[$fileinput]['name'];
		$tmp_name = $_FILES[$fileinput]['tmp_name'];
		if (!empty($filename) && !empty($tmp_name)) {
			$ext = strtolower(substr($filename, strrpos($filename, '.')));

			if ($ext != '.pem') {
				$errinput = '';

				if ($fileinput == 'weixin_cert_file') {
					$errinput = 'CERT文件格式错误';
				}
				else if ($fileinput == 'weixin_key_file') {
					$errinput = 'KEY文件格式错误';
				}
				else {
					if ($fileinput == 'weixin_root_file') {
						$errinput = 'ROOT文件格式错误';
					}
				}

				show_json(0, $errinput . ',请重新上传!');
			}

			return file_get_contents($tmp_name);
		}

		return '';
	}
}

?>
