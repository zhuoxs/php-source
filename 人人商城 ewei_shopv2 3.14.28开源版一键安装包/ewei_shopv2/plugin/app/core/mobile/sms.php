<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Sms_EweiShopV2Page extends AppMobilePage
{
	public function register()
	{
		$this->loginSMS('reg');
	}

	public function forget()
	{
		$this->loginSMS('forget');
	}

	public function changepwd()
	{
		$this->loginSMS('changepwd');
	}

	public function changemobile()
	{
		$this->loginSMS('bind');
	}

	public function changemobie()
	{
		$this->loginSMS('bind');
	}

	protected function loginSMS($temp)
	{
		global $_W;
		global $_GPC;
		$mobile = trim($_GPC['mobile']);
		$verifyImgCode = trim($_GPC['verifyImgCode']);

		if (empty($mobile)) {
			return app_error(AppError::$ParamsError, '手机号不能为空');
		}

		$wapset = m('common')->getSysset('wap');

		if (!empty($wapset['smsimgcode'])) {
			if (empty($verifyImgCode)) {
				return app_error('请输入图形验证码');
			}

			$verifyCodeKey = 'sms_captcha_code_uniaicid_' . $_W['uniacid'] . '_openid_' . $_W['openid'];
			$verifyCode = m('cache')->get($verifyCodeKey);
			$imgcodehash = md5(strtolower($verifyImgCode) . $_W['config']['setting']['authkey']);

			if ($imgcodehash != trim($verifyCode)) {
				return app_error(AppError::$ParamsError, '图形验证码错误');
			}
		}

		$appset = m('common')->getSysset('app');
		if ($temp == 'bind' && $this->iswxapp && empty($appset['isclose']) && !empty($appset['openbind'])) {
			$data = $appset;
		}
		else {
			$data = m('common')->getSysset('wap');
		}

		$sms_id = $data['sms_' . $temp];

		if (empty($sms_id)) {
			return app_error(AppError::$SMSTplidNull);
		}

		$key = '__ewei_shopv2_member_verifycodesession_' . $_W['uniacid'] . '_' . $mobile;
		$key_time = '__ewei_shopv2_member_verifycodesendtime_' . $_W['uniacid'];
		$sendtime = m('cache')->get($key_time);

		if (!is_numeric($sendtime)) {
			$sendtime = 0;
		}

		$time = time() - $sendtime;

		if ($time < 60) {
			return app_error(AppError::$SMSRateError);
		}

		$code = random(5, true);
		$ret = com('sms')->send($mobile, $sms_id, array('验证码' => $code, '商城名称' => $_W['shopset']['shop']['name']));

		if ($ret['status']) {
			m('cache')->set($key, $code);
			m('cache')->set($key_time, time());
			return app_json();
		}

		return app_error(AppError::$SystemError, $ret['message']);
	}

	public function captcha()
	{
		global $_W;
		global $_GPC;
		error_reporting(0);
		load()->classs('captcha');
		session_start();
		$captcha = new Captcha();
		$captcha->build(150, 40);
		$hash = md5(strtolower($captcha->phrase) . $_W['config']['setting']['authkey']);
		m('cache')->set('sms_captcha_code_uniaicid_' . $_W['uniacid'] . '_openid_' . $_GPC['openid'], $hash);
		$captcha->output();
	}
}

?>
