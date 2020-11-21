<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Pay_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('pay');
		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);
		if (!is_array($sec['wxapp']) || !isset($sec['wxapp'])) {
			$sec['wxapp'] = array();
		}

		if ($_W['ispost']) {
			ca('app.pay.edit');

			if ($_FILES['wxapp_cert_file']['name']) {
				$sec['wxapp_cert'] = $this->upload_cert('wxapp_cert_file');
			}

			if ($_FILES['wxapp_key_file']['name']) {
				$sec['wxapp_key'] = $this->upload_cert('wxapp_key_file');
			}

			if ($_FILES['wxapp_root_file']['name']) {
				$sec['wxapp_root'] = $this->upload_cert('wxapp_root_file');
			}

			$sec['wxapp']['mchid'] = trim($_GPC['data']['wxapp_mchid']);
			$sec['wxapp']['apikey'] = trim($_GPC['data']['wxapp_apikey']);
			pdo_update('ewei_shop_sysset', array('sec' => iserializer($sec)), array('uniacid' => $_W['uniacid']));
			$data['wxapp'] = intval($_GPC['data']['wxapp']);
			m('common')->updateSysset(array('pay' => $data));
			plog('app.pay.edit', '保存支付设置');
			show_json(1);
		}

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
