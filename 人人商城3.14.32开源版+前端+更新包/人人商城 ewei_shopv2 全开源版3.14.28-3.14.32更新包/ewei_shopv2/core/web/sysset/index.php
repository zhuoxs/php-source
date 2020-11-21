<?php
echo '  ';

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function main()
	{
		if (cv('sysset.shop')) {
			header('location: ' . webUrl('sysset/shop'));
		}
		else if (cv('sysset.follow')) {
			header('location: ' . webUrl('sysset/follow'));
		}
		else if (cv('sysset.wap')) {
			header('location: ' . webUrl('sysset/wap'));
		}
		else if (cv('sysset.pcset')) {
			header('location: ' . webUrl('sysset/pcset'));
		}
		else if (cv('sysset.notice')) {
			header('location: ' . webUrl('sysset/notice'));
		}
		else if (cv('sysset.trade')) {
			header('location: ' . webUrl('sysset/trade'));
		}
		else if (cv('sysset.payset')) {
			header('location: ' . webUrl('sysset/payset'));
		}
		else if (cv('sysset.templat')) {
			header('location: ' . webUrl('sysset/templat'));
		}
		else if (cv('sysset.member')) {
			header('location: ' . webUrl('sysset/member'));
		}
		else if (cv('sysset.category')) {
			header('location: ' . webUrl('sysset/category'));
		}
		else if (cv('sysset.contact')) {
			header('location: ' . webUrl('sysset/contact'));
		}
		else if (cv('sysset.qiniu')) {
			header('location: ' . webUrl('sysset/qiniu'));
		}
		else if (cv('sysset.sms.set')) {
			header('location: ' . webUrl('sysset/sms/set'));
		}
		else if (cv('sysset.sms.temp')) {
			header('location: ' . webUrl('sysset/sms/temp'));
		}
		else if (cv('sysset.close')) {
			header('location: ' . webUrl('sysset/close'));
		}
		else if (cv('sysset.tmessage')) {
			header('location: ' . webUrl('sysset/tmessage'));
		}
		else if (cv('sysset.cover')) {
			header('location: ' . webUrl('sysset/cover'));
		}
		else if (cv('sysset.area')) {
			header('location: ' . webUrl('sysset/area'));
		}
		else if (cv('sysset.notice_redis')) {
			header('location: ' . webUrl('sysset/notice_redis'));
		}
		else {
			header('location: ' . webUrl());
		}
	}

	public function shop()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('shop');

		if ($_W['ispost']) {
			ca('sysset.shop.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['name'] = trim($data['name']);
			$data['img'] = save_media($data['img']);
			$data['logo'] = save_media($data['logo']);
			$data['signimg'] = save_media($data['signimg']);
			$data['saleout'] = save_media($data['saleout']);
			$data['loading'] = save_media($data['loading']);
			$data['diycode'] = $_POST['data']['diycode'];
			m('common')->updateSysset(array('shop' => $data));
			plog('sysset.shop.edit', '修改系统设置-商城设置');
			show_json(1);
		}

		include $this->template('sysset/index');
	}

	public function follow()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('sysset.follow.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['logo'] = save_media($data['icon']);
			$data['desc'] = str_replace(array('
', '
', '
'), '', trim($data['desc']));
			m('common')->updateSysset(array('share' => $data));
			plog('sysset.follow.edit', '修改系统设置-分享及关注设置');
			show_json(1);
		}

		$data = m('common')->getSysset('share');
		include $this->template();
	}

	public function settemplateid()
	{
		global $_W;
		global $_GPC;
		$tag = $_GPC['tag'];
		load()->func('communication');
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=' . $token;
		$c = ihttp_request($url);
		$result = json_decode($c['content'], true);

		if (!is_array($result)) {
			show_json(1, array('status' => 0, 'messages' => '微信接口错误.', 'tag' => $tag));
		}

		if (!empty($result['errcode'])) {
			show_json(1, array('status' => 0, 'messages' => $result['errmsg'], 'tag' => $tag));
		}

		$error_message = '';
		$templatenum = count($result['template_list']);
		$templatetype = pdo_fetch('select `name`,templatecode,content  from ' . tablename('ewei_shop_member_message_template_type') . ' where typecode=:typecode  limit 1', array(':typecode' => $tag));

		if (empty($templatetype)) {
			show_json(1, array('status' => 0, 'messages' => '默认模板信息错误', 'tag' => $tag));
		}

		$content = str_replace(array('
', '
', '
', ' '), '', $templatetype['content']);
		$content = str_replace(array('：'), ':', $content);
		$issnoet = true;
		$defaulttemp = pdo_fetch('select *  from ' . tablename('ewei_shop_member_message_template_default') . ' where typecode=:typecode and uniacid=:uniacid  limit 1', array(':typecode' => $tag, ':uniacid' => $_W['uniacid']));
		$template_list = $result['template_list'];
		$templateIds = array_column($template_list, 'template_id');
		if (empty($defaulttemp) || !in_array($defaulttemp['templateid'], $templateIds)) {
			if (25 <= $templatenum) {
				show_json(1, array('status' => 0, 'messages' => '开启' . $templatetype['name'] . '失败！！您的可用微信模板消息数量达到上限，请删除部分后重试！！', 'tag' => $tag));
			}

			$bb = '{"template_id_short":"' . $templatetype['templatecode'] . '"}';
			$account = m('common')->getAccount();
			$token = $account->fetch_token();
			$url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=' . $token;
			$ch1 = curl_init();
			curl_setopt($ch1, CURLOPT_URL, $url);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch1, CURLOPT_POSTFIELDS, $bb);
			$c = curl_exec($ch1);
			$result = @json_decode($c, true);

			if (!is_array($result)) {
				show_json(1, array('status' => 0, 'messages' => '微信接口错误.', 'tag' => $tag));
			}

			if (!empty($result['errcode'])) {
				if (strstr($result['errmsg'], 'template conflict with industry hint')) {
					show_json(1, array('status' => 0, 'messages' => '默认模板与公众号所属行业冲突,请将公众平台模板消息所在行业选择为： IT科技/互联网|电子商务， 其他/其他', 'tag' => $tag));
				}
				else if (strstr($result['errmsg'], 'system error hint')) {
					show_json(1, array('status' => 0, 'messages' => '微信接口系统繁忙,请稍后再试!', 'tag' => $tag));
				}
				else if (strstr($result['errmsg'], 'invalid industry id hint')) {
					show_json(1, array('status' => 0, 'messages' => '微信接口系统繁忙,请稍后再试!', 'tag' => $tag));
				}
				else if (strstr($result['errmsg'], 'access_token is invalid or not latest hint')) {
					show_json(1, array('status' => 0, 'messages' => '微信证书无效，请检查平台access_token设置', 'tag' => $tag));
				}
				else {
					show_json(1, array('status' => 0, 'messages' => $result['errmsg'], 'tag' => $tag));
				}
			}
			else {
				$defaulttemp = pdo_fetch('select * from ' . tablename('ewei_shop_member_message_template_default') . ' where typecode=:typecode and uniacid=:uniacid  limit 1', array(':typecode' => $tag, ':uniacid' => $_W['uniacid']));

				if (empty($defaulttemp)) {
					pdo_insert('ewei_shop_member_message_template_default', array('typecode' => $tag, 'uniacid' => $_W['uniacid'], 'templateid' => $result['template_id']));
				}
				else {
					pdo_update('ewei_shop_member_message_template_default', array('templateid' => $result['template_id']), array('typecode' => $tag, 'uniacid' => $_W['uniacid']));
				}
			}
		}

		show_json(1, array('status' => 1, 'tag' => $tag));
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

		$salers2 = array();

		if (isset($data['openid2'])) {
			if (!empty($data['openid2'])) {
				$openids2 = array();
				$strsopenids2 = explode(',', $data['openid2']);

				foreach ($strsopenids2 as $openid2) {
					$openids2[] = '\'' . $openid2 . '\'';
				}

				$salers2 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids2) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		$salers3 = array();

		if (isset($data['openid3'])) {
			if (!empty($data['openid3'])) {
				$openids3 = array();
				$strsopenids3 = explode(',', $data['openid3']);

				foreach ($strsopenids3 as $openid3) {
					$openids3[] = '\'' . $openid3 . '\'';
				}

				$salers3 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids3) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		$salers4 = array();

		if (isset($data['openid4'])) {
			if (!empty($data['openid4'])) {
				$openids4 = array();
				$strsopenids4 = explode(',', $data['openid4']);

				foreach ($strsopenids4 as $openid4) {
					$openids4[] = '\'' . $openid4 . '\'';
				}

				$salers4 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids4) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		$opensms = com('sms');

		if ($_W['ispost']) {
			ca('sysset.notice.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (is_array($_GPC['openids'])) {
				$data['openid'] = implode(',', $_GPC['openids']);
			}
			else {
				$data['openid'] = '';
			}

			if (is_array($_GPC['openids2'])) {
				$data['openid2'] = implode(',', $_GPC['openids2']);
			}
			else {
				$data['openid2'] = '';
			}

			if (is_array($_GPC['openids3'])) {
				$data['openid3'] = implode(',', $_GPC['openids3']);
			}
			else {
				$data['openid3'] = '';
			}

			if (is_array($_GPC['openids4'])) {
				$data['openid4'] = implode(',', $_GPC['openids4']);
			}
			else {
				$data['openid4'] = '';
			}

			if (empty($data['willcancel_close_advanced'])) {
				$uniacids = m('cache')->get('willcloseuniacid', 'global');

				if (!is_array($uniacids)) {
					$uniacids = array();
				}

				if (!in_array($_W['uniacid'], $uniacids)) {
					$uniacids[] = $_W['uniacid'];
					m('cache')->set('willcloseuniacid', $uniacids, 'global');
				}
			}
			else {
				$uniacids = m('cache')->get('willcloseuniacid', 'global');

				if (is_array($uniacids)) {
					if (in_array($_W['uniacid'], $uniacids)) {
						$datas = array();

						foreach ($uniacids as $uniacid) {
							if ($uniacid != $_W['uniacid']) {
								$datas[] = $uniacid;
							}
						}

						m('cache')->set('willcloseuniacid', $datas, 'global');
					}
				}
			}

			m('common')->updateSysset(array('notice' => $data));
			plog('sysset.notice.edit', '修改系统设置-模板消息通知设置');
			show_json(1);
		}

		$template_list = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_list as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		if ($opensms) {
			$smsset = com('sms')->sms_set();
			if (empty($smsset['juhe']) && empty($smsset['dayu']) && empty($smsset['emay']) && empty($smsset['aliyun']) && empty($smsset['aliyun_new'])) {
				$opensms = false;
			}

			$template_sms = com('sms')->sms_temp();
		}

		include $this->template();
	}

	public function trade()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('sysset.trade.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if ($data['maxcredit'] < 0) {
				$data['maxcredit'] = 0;
			}

			if (!empty($data['withdrawcharge'])) {
				$data['withdrawcharge'] = trim($data['withdrawcharge']);
				$data['withdrawcharge'] = floatval(trim($data['withdrawcharge'], '%'));
			}

			$data['minimumcharge'] = floatval(trim($data['minimumcharge']));
			$data['withdrawbegin'] = floatval(trim($data['withdrawbegin']));
			$data['withdrawend'] = floatval(trim($data['withdrawend']));
			$data['nodispatchareas'] = serialize($data['nodispatchareas']);
			$data['nodispatchareas_code'] = serialize($data['nodispatchareas_code']);

			if (5 < mb_strlen($data['pickuptext'], 'utf-8')) {
				show_json(0, '自提文案不允许超过五个字');
			}

			$data['pickuptext'] = !empty($data['pickuptext']) ? $data['pickuptext'] : '上门自提';
			$data['withdrawcashweixin'] = intval($data['withdrawcashweixin']);
			$data['withdrawcashalipay'] = intval($data['withdrawcashalipay']);
			$data['withdrawcashcard'] = intval($data['withdrawcashcard']);

			if (!empty($data['closeorder'])) {
				$data['closeorder'] = intval($data['closeorder']);
			}

			if (!empty($data['willcloseorder'])) {
				$data['willcloseorder'] = intval($data['willcloseorder']);
			}

			if (is_null($data['invoice_entity'])) {
				show_json(0, '请至少选择一种发票类型');
			}

			rsort($data['invoice_entity']);
			$data['invoice_entity'] = implode('', $data['invoice_entity']);

			switch ($data['invoice_entity']) {
			case '10':
				$data['invoice_entity'] = 2;
				break;

			case '1':
				$data['invoice_entity'] = 1;
				break;

			default:
				$data['invoice_entity'] = 0;
			}

			m('common')->updateSysset(array('trade' => $data));
			plog('sysset.trade.edit', '修改系统设置-交易设置');
			show_json(1);
		}

		$areas = m('common')->getAreas();
		$data = m('common')->getSysset('trade');

		if (!array_key_exists('set_realname', $data)) {
			$data['set_realname'] = 1;
		}

		if (!array_key_exists('set_mobile', $data)) {
			$data['set_mobile'] = 1;
		}

		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$data['nodispatchareas'] = unserialize($data['nodispatchareas']);
		$data['nodispatchareas_code'] = unserialize($data['nodispatchareas_code']);
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

	public function payset()
	{
		global $_W;
		global $_GPC;
		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);

		if ($_W['ispost']) {
			ca('sysset.payset.edit');

			if ($_FILES['app_wechat_cert_file']['name']) {
				$sec['app_wechat']['cert'] = $this->upload_cert('app_wechat_cert_file');
			}

			if ($_FILES['app_wechat_key_file']['name']) {
				$sec['app_wechat']['key'] = $this->upload_cert('app_wechat_key_file');
			}

			if ($_FILES['app_wechat_root_file']['name']) {
				$sec['app_wechat']['root'] = $this->upload_cert('app_wechat_root_file');
			}

			$sec['app_wechat']['appid'] = trim($_GPC['data']['app_wechat_appid']);
			$sec['app_wechat']['appsecret'] = trim($_GPC['data']['app_wechat_appsecret']);
			$sec['app_wechat']['merchname'] = trim($_GPC['data']['app_wechat_merchname']);
			$sec['app_wechat']['merchid'] = trim($_GPC['data']['app_wechat_merchid']);
			$sec['app_wechat']['apikey'] = trim($_GPC['data']['app_wechat_apikey']);
			$sec['alipay_pay'] = is_array($_GPC['data']['alipay_pay']) ? $_GPC['data']['alipay_pay'] : array();
			$sec['app_alipay']['public_key'] = trim($_GPC['data']['app_alipay_public_key']);
			$sec['app_alipay']['private_key'] = trim($_GPC['data']['app_alipay_private_key']);
			$sec['app_alipay']['public_key_rsa2'] = trim($_GPC['data']['app_alipay_public_key_rsa2']);
			$sec['app_alipay']['private_key_rsa2'] = trim($_GPC['data']['app_alipay_private_key_rsa2']);
			$sec['app_alipay']['appid'] = trim($_GPC['data']['app_alipay_appid']);
			pdo_update('ewei_shop_sysset', array('sec' => iserializer($sec)), array('uniacid' => $_W['uniacid']));
			$inputdata = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data = array();
			$data['weixin_id'] = intval($inputdata['weixin_id']);
			$data['weixin'] = intval($inputdata['weixin']);
			$data['weixin_sub'] = intval($inputdata['weixin_sub']);
			$data['weixin_jie'] = intval($inputdata['weixin_jie']);
			$data['weixin_jie_sub'] = intval($inputdata['weixin_jie_sub']);
			$data['alipay'] = intval($inputdata['alipay']);
			$data['alipay_id'] = intval($inputdata['alipay_id']);
			$data['credit'] = intval($inputdata['credit']);
			$data['cash'] = intval($inputdata['cash']);
			$data['app_wechat'] = intval($inputdata['app_wechat']);
			$data['app_alipay'] = intval($inputdata['app_alipay']);
			$data['paytype'] = isset($inputdata['paytype']) ? $inputdata['paytype'] : array();
			m('common')->updateSysset(array('pay' => $data));
			plog('sysset.payset.edit', '修改系统设置-支付设置');
			show_json(1);
		}

		$data = m('common')->getSysset('pay');
		$payments = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_payment') . ' WHERE uniacid=:uniacid and paytype = 0 ', array(':uniacid' => $_W['uniacid']));
		$paymentalis = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_payment') . ' WHERE uniacid=:uniacid and paytype = 1 ', array(':uniacid' => $_W['uniacid']));

		if (empty($payments)) {
			$payments = array();
			$setting = uni_setting($_W['uniacid'], array('payment'));
			$payment = $setting['payment'];

			if (!empty($payment['wechat']['mchid'])) {
				if (IMS_VERSION <= 0.80000000000000004) {
					$payment['wechat']['apikey'] = $payment['wechat']['signkey'];
				}

				$default = array('uniacid' => $_W['uniacid'], 'title' => '微信支付', 'type' => 0, 'sub_appid' => $_W['account']['key'], 'sub_appsecret' => $_W['account']['secret'], 'sub_mch_id' => $payment['wechat']['mchid'], 'apikey' => $payment['wechat']['apikey'], 'cert_file' => $sec['cert'], 'key_file' => $sec['key'], 'root_file' => $sec['root'], 'createtime' => TIMESTAMP);
				$payments[] = $default;
				pdo_insert('ewei_shop_payment', $default);
				$default_0 = pdo_insertid();
			}

			if ($data['weixin_sub'] == 1 || !empty($sec['appid_sub'])) {
				$default = array('uniacid' => $_W['uniacid'], 'title' => '微信支付子商户', 'type' => 1, 'appid' => $sec['appid_sub'], 'mch_id' => $sec['mchid_sub'], 'sub_appid' => $sec['sub_appid_sub'], 'sub_appsecret' => $_W['account']['secret'], 'sub_mch_id' => $sec['sub_mchid_sub'], 'apikey' => $sec['apikey_sub'], 'cert_file' => $sec['sub']['cert'], 'key_file' => $sec['sub']['key'], 'root_file' => $sec['sub']['root'], 'createtime' => TIMESTAMP);
				$payments[] = $default;
				pdo_insert('ewei_shop_payment', $default);
				$default_1 = pdo_insertid();
			}

			if ($data['weixin_jie_sub'] == 1 || !empty($sec['appid'])) {
				$default = array('uniacid' => $_W['uniacid'], 'title' => '借用微信支付', 'type' => 2, 'sub_appid' => $sec['appid'], 'sub_appsecret' => $sec['secret'], 'sub_mch_id' => $sec['mchid'], 'apikey' => $sec['apikey'], 'cert_file' => $sec['jie']['cert'], 'key_file' => $sec['jie']['key'], 'root_file' => $sec['jie']['root'], 'createtime' => TIMESTAMP);
				$payments[] = $default;
				pdo_insert('ewei_shop_payment', $default);
				$default_2 = pdo_insertid();
			}

			if ($data['weixin_jie_sub'] == 1 || !empty($sec['appid_jie_sub'])) {
				$default = array('uniacid' => $_W['uniacid'], 'title' => '借用微信支付子商户', 'type' => 3, 'appid' => $sec['appid_jie_sub'], 'mch_id' => $sec['mchid_jie_sub'], 'sub_appid' => $sec['sub_appid_jie_sub'], 'sub_appsecret' => $sec['sub_secret_jie_sub'], 'sub_mch_id' => $sec['sub_mchid_jie_sub'], 'apikey' => $sec['apikey_jie_sub'], 'cert_file' => $sec['jie_sub']['cert'], 'key_file' => $sec['jie_sub']['key'], 'root_file' => $sec['jie_sub']['root'], 'createtime' => TIMESTAMP);
				$payments[] = $default;
				pdo_insert('ewei_shop_payment', $default);
				$default_3 = pdo_insertid();
			}

			if ($data['weixin'] == 1) {
				$data['weixin_id'] = $default_0;
			}
			else if ($data['weixin_sub'] == 1) {
				$data['weixin_id'] = $default_1;
			}
			else if ($data['weixin_jie'] == 1) {
				$data['weixin_id'] = $default_2;
			}
			else {
				if ($data['weixin_jie_sub'] == 1) {
					$data['weixin_id'] = $default_3;
				}
			}

			m('common')->updateSysset(array('pay' => $data));
		}

		$url = $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php';
		load()->func('communication');
		$resp = ihttp_get($url);
		include $this->template();
		exit();
	}

	public function member()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('sysset.member.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['upgrade_condition'] = intval($data['upgrade_condition']);
			$data['levelname'] = trim($data['levelname']);
			$data['levelurl'] = trim($data['levelurl']);
			$data['leveltype'] = intval($data['leveltype']);
			m('common')->updateSysset(array('member' => $data));
			$shop = m('common')->getSysset('shop');
			$shop['levelname'] = $data['levelname'];
			$shop['levelurl'] = $data['levelurl'];
			$shop['leveltype'] = $data['leveltype'];
			m('common')->updateSysset(array('shop' => $shop));
			plog('sysset.member.edit', '修改系统设置-会员设置');
			show_json(1);
		}

		$data = m('common')->getSysset('member');

		if (!isset($data['levelname'])) {
			$shop = m('common')->getSysset('shop');
			$data['levelname'] = $shop['levelname'];
			$data['levelurl'] = $shop['levelurl'];
			$data['leveltype'] = $shop['leveltype'];
		}

		include $this->template();
	}

	public function category()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('sysset.category.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$shop = m('common')->getSysset('shop');
			$shop['level'] = intval($data['level']);
			$shop['show'] = intval($data['show']);
			$shop['advimg'] = save_media($data['advimg']);
			$shop['advurl'] = trim($data['advurl']);
			m('common')->updateSysset(array('category' => $data));
			$shop = m('common')->getSysset('shop');
			$shop['catlevel'] = $data['level'];
			$shop['catshow'] = $data['show'];
			$shop['catadvimg'] = save_media($data['advimg']);
			$shop['catadvurl'] = $data['advurl'];
			m('common')->updateSysset(array('shop' => $shop));
			plog('sysset.category.edit', '修改系统设置-分类层级设置');
			m('shop')->getCategory(true);
			show_json(1);
		}

		$data = m('common')->getSysset('category');

		if (empty($data)) {
			$shop = m('common')->getSysset('shop');
			$data['level'] = $shop['catlevel'];
			$data['show'] = $shop['catshow'];
			$data['advimg'] = $shop['catadvimg'];
			$data['advurl'] = $shop['catadvurl'];
		}

		include $this->template();
	}

	public function contact()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('sysset.contact.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['qq'] = trim($data['qq']);
			$data['address'] = trim($data['address']);
			$data['phone'] = trim($data['phone']);
			m('common')->updateSysset(array('contact' => $data));
			$shop = m('common')->getSysset('shop');
			$shop['qq'] = $data['qq'];
			$shop['address'] = $data['address'];
			$shop['phone'] = $data['phone'];
			m('common')->updateSysset(array('shop' => $shop));
			plog('sysset.contact.edit', '修改系统设置-联系方式设置');
			show_json(1);
		}

		$data = m('common')->getSysset('contact');

		if (empty($data)) {
			$shop = m('common')->getSysset('shop');
			$data['qq'] = $shop['qq'];
			$data['address'] = $shop['address'];
			$data['phone'] = $shop['phone'];
		}

		include $this->template();
	}

	public function close()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('sysset.close.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['flag'] = intval($data['flag']);
			$data['detail'] = m('common')->html_images($data['detail']);
			$data['url'] = trim($data['url']);
			m('common')->updateSysset(array('close' => $data));
			$shop = m('common')->getSysset('shop');
			$shop['close'] = $data['flag'];
			$shop['closedetail'] = $data['detail'];
			$shop['closeurl'] = $data['url'];
			m('common')->updateSysset(array('shop' => $shop));
			plog('sysset.close.edit', '修改系统设置-商城关闭设置');
			show_json(1);
		}

		$data = m('common')->getSysset('close');
		$data['detail'] = m('common')->html_to_images($data['detail']);

		if (empty($data)) {
			$shop = m('common')->getSysset('shop');
			$data['flag'] = $shop['close'];
			$data['detail'] = m('common')->html_to_images($shop['closedetail']);
			$data['url'] = $shop['closeurl'];
		}

		include $this->template();
	}

	public function templat()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('sysset.templat.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			m('common')->updateSysset(array('template' => $data));
			$shop = m('common')->getSysset('shop');
			$shop['style'] = $data['style'];
			m('common')->updateSysset(array('shop' => $shop));
			m('cache')->set('template_shop', $data['style']);
			plog('sysset.templat.edit', '修改系统设置-模板设置');
			show_json(1);
		}

		$styles = array();
		$dir = IA_ROOT . '/addons/ewei_shopv2/template/mobile/';

		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . '/' . $file)) {
						$styles[] = $file;
					}
				}
			}

			closedir($handle);
		}

		$data = m('common')->getSysset('template', false);
		include $this->template();
	}

	public function goodsprice()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}

	public function wap()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('wap');
		$wap = com('wap');

		if (!$wap) {
			$this->message('您没权限访问!');
			exit();
		}

		$sms = com('sms');

		if (!$sms) {
			$this->message('开启全网通请先开通短信通知');
			exit();
		}

		$template_sms = com('sms')->sms_temp();

		if ($_W['ispost']) {
			ca('sysset.wap.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['open'] = intval($data['open']);
			$data['loginbg'] = save_media($data['loginbg']);
			$data['regbg'] = save_media($data['regbg']);
			$data['sns']['wx'] = intval($data['sns']['wx']);
			$data['sns']['qq'] = intval($data['sns']['qq']);
			m('common')->updateSysset(array('wap' => $data));
			plog('sysset.wap.edit', '修改WAP设置');
			show_json(1);
		}

		$styles = array();
		$dir = IA_ROOT . '/addons/ewei_shopv2/template/account/';

		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . '/' . $file)) {
						$styles[] = $file;
					}
				}
			}

			closedir($handle);
		}

		include $this->template('sysset/wap');
	}

	public function funbar()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = pdo_fetch('select * from ' . tablename('ewei_shop_funbar') . ' where uid=:uid and uniacid=:uniacid limit 1', array(':uid' => $_W['uid'], ':uniacid' => $_W['uniacid']));
			$funbardata = is_array($_GPC['funbardata']) ? $_GPC['funbardata'] : array();
			$funbardata = serialize($funbardata);

			if (empty($data)) {
				pdo_insert('ewei_shop_funbar', array('uid' => $_W['uid'], 'datas' => $funbardata, 'uniacid' => $_W['uniacid']));
			}
			else {
				pdo_update('ewei_shop_funbar', array('datas' => $funbardata), array('uid' => $data['uid'], 'uniacid' => $_W['uniacid']));
			}

			show_json(1);
		}
	}

	public function area()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$data = m('util')->get_area_config_data();

		if ($_W['ispost']) {
			ca('sysset.area.edit');
			$submit_data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$array = array();
			if (empty($data) || empty($data['new_area'])) {
				$array['new_area'] = intval($submit_data['new_area']);

				if (!empty($array['new_area'])) {
					$array['address_street'] = intval($submit_data['address_street']);
					$change_data = array();
					$change_data['province'] = '';
					$change_data['city'] = '';
					$change_data['area'] = '';
					pdo_update('ewei_shop_member', $change_data, array('uniacid' => $uniacid));
					pdo_update('ewei_shop_member_address', $change_data, array('uniacid' => $uniacid));
				}
				else {
					$array['address_street'] = 0;
				}
			}
			else {
				if (!empty($data['new_area'])) {
					$array['address_street'] = intval($submit_data['address_street']);
				}
			}

			if (empty($data)) {
				$array['uniacid'] = $uniacid;
				$array['createtime'] = time();
				pdo_insert('ewei_shop_area_config', $array);
			}
			else {
				if (!empty($array)) {
					pdo_update('ewei_shop_area_config', $array, array('id' => $data['id'], 'uniacid' => $uniacid));
				}
			}

			$data = m('util')->get_area_config_data();
			m('common')->updateSysset(array('area_config' => $data));
			plog('sysset.area.edit', '修改系统设置-地址库设置');
			show_json(1);
		}

		include $this->template();
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('express');

		if ($_W['ispost']) {
			ca('sysset.express.edit');
			$data = array();

			if (empty($_GPC['express_type'])) {
				$data['express_bird'] = array('express_bird_userid' => trim($_GPC['express_bird_userid']), 'express_bird_apikey' => trim($_GPC['express_bird_apikey']), 'express_bird_cache' => intval($_GPC['express_bird_cache']), "express_bird_customer_name" => intval($_GPC["express_bird_customer_name"]));
			}
			else {
				$data['express_one_hundred'] = array('apikey' => trim($_GPC['apikey']), 'customer' => trim($_GPC['customer']), 'isopen' => intval($_GPC['isopen']), 'cache' => intval($_GPC['cache']));
			}

			$data['express_type'] = $_GPC['express_type'];
			m('common')->updateSysset(array('express' => $data));
			plog('sysset.express.edit', '修改系统设置-物流信息接口');
			show_json(1);
		}

		include $this->template('sysset/express');
	}

	public function notice_redis()
	{
		global $_W;
		global $_GPC;
		m('common')->updateSysset(array(
			'notice_redis' => array('notice_redis_click' => 1)
		));

		if ($_W['ispost']) {
			ca('sysset.note_redis.edit');

			if ($_GPC['notice_redis'] == '1') {
				$open_redis = function_exists('redis') && !is_error(redis());

				if (!$open_redis) {
					show_json(0, '请先打开redis');
				}
			}

			$data['notice_redis'] = $_GPC['notice_redis'];
			m('common')->updateSysset(array('notice_redis' => $data));
			plog('sysset.note_redis.edit', '修改系统设置-redis消息通知开关');
			show_json(1);
		}

		$data = m('common')->getSysset('notice_redis');
		include $this->template('sysset/notice_redis');
	}

	public function wxpaycert()
	{
		global $_W;
		global $_GPC;
		m('common')->updateSysset(array(
			'wxpaycert_view' => array('wxpaycert_view_click' => 1)
		));

		if ($_W['ispost']) {
			$mch_id = trim($_GPC['mch_id']);
			$api_key = trim($_GPC['api_key']);

			if (empty($mch_id)) {
				show_json(0, '请填写微信支付商户号');
			}

			if (empty($api_key)) {
				show_json(0, '请填写微信支付密钥');
			}

			$url = 'https://apitest.mch.weixin.qq.com/sandboxnew/pay/getsignkey';
			$post_data = array('mch_id' => $mch_id, 'nonce_str' => random(32));
			$post_data['sign'] = get_wxpay_sign($post_data, $api_key);
			$xmldata = array2xml($post_data);
			$result = ihttp_post($url, $xmldata);

			if (is_error($result)) {
				show_json(0, '请求失败');
			}

			if (empty($result['content'])) {
				show_json(0, '数据返回失败');
			}

			$content = xml2array($result['content']);

			if (strval($content['return_code']) == 'FAIL') {
				$return_msg = empty($content['return_msg']) ? $content['retmsg'] : $content['return_msg'];
				show_json(0, strval($return_msg));
			}

			show_json(1, '验证成功');
		}

		include $this->template('sysset/wxpaycert');
	}
}

?>
