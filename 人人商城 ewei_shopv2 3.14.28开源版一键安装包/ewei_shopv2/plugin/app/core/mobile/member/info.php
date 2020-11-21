<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Info_EweiShopV2Page extends AppMobilePage
{
	protected $member;

	public function __construct()
	{
		global $_W;
		parent::__construct();
		$this->member = m('member')->getInfo($_W['openid']);
	}

	protected function diyformData()
	{
		$template_flag = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			$set_config = $diyform_plugin->getSet();
			$user_diyform_open = $set_config['user_diyform_open'];

			if ($user_diyform_open == 1) {
				$template_flag = 1;
				$diyform_id = $set_config['user_diyform'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);
					$fields = $formInfo['fields'];
					$diyform_data = iunserializer($this->member['diymemberdata']);
					$f_data = $diyform_plugin->getDiyformData($diyform_data, $fields, $this->member);
				}
			}
		}

		$appDatas = array();

		if ($diyform_plugin) {
			$appDatas = $diyform_plugin->wxApp($fields, $f_data, $this->member);
		}

		return array('template_flag' => $template_flag, 'f_data' => $appDatas['f_data'], 'fields' => $appDatas['fields'], 'set_config' => $set_config, 'diyform_plugin' => $diyform_plugin, 'formInfo' => $formInfo, 'diyform_id' => $diyform_id, 'diyform_data' => $diyform_data);
	}

	public function main()
	{
		global $_GPC;
		global $_W;
		$diyform_data = $this->diyformData();
		$returnurl = urldecode(trim($_GPC['returnurl']));
		$member = $this->member;
		if (!empty($member['birthyear']) && !empty($member['birthmonth']) && !empty($member['birthday'])) {
			$member['birthdays'] = $member['birthyear'] . '-' . $member['birthmonth'] . '-' . $member['birthday'];
		}

		$memberArr = array('nickname' => $member['nickname'], 'realname' => $member['realname'], 'mobile' => $member['mobile'], 'weixin' => $member['weixin'], 'birthday' => $member['birthday'], 'city' => $member['city'], 'mobileverify' => $member['mobileverify'], 'avatar' => tomedia($member['avatar']));
		$result = array(
			'member'  => $memberArr,
			'diyform' => array('template_flag' => $diyform_data['template_flag'], 'f_data' => $diyform_data['f_data'], 'fields' => $diyform_data['fields'])
		);
		if (!empty($_W['shopset']['app']['openbind']) || !empty($_W['shopset']['wap']['open'])) {
			$result['openbind'] = 1;
		}

		return app_json($result);
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$diyform_data = $this->diyformData();
		extract($diyform_data);
		$memberdata = $_GPC['memberdata'];

		if (is_string($memberdata)) {
			$memberdatastring = htmlspecialchars_decode(str_replace('\\', '', $memberdata));
			$memberdata = @json_decode($memberdatastring, true);
		}

		if ($template_flag == 1) {
			$data = array();
			$m_data = array();
			$mc_data = array();
			$insert_data = $diyform_plugin->getInsertData($fields, $memberdata, true);
			$data = $insert_data['data'];
			$m_data = $insert_data['m_data'];
			$mc_data = $insert_data['mc_data'];
			$m_data['diymemberid'] = $diyform_id;
			$m_data['diymemberfields'] = $diyform_plugin->getInsertFields($fields);
			$m_data['diymemberdata'] = $data;
			$a = $m_data['diymemberdata'];
			$a = iunserializer($a);
			unset($m_data['credit1']);
			unset($m_data['credit2']);
			pdo_update('ewei_shop_member', $m_data, array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));

			if (!empty($this->member['uid'])) {
				load()->model('mc');

				if (!empty($mc_data)) {
					unset($mc_data['credit1']);
					unset($mc_data['credit2']);
					mc_update($this->member['uid'], $mc_data);
				}
			}
		}
		else {
			if (!empty($memberdata['birthday']) && strexists($memberdata['birthday'], '-')) {
				$birthday = explode('-', $memberdata['birthday']);
				$memberdata['birthyear'] = $birthday[0];
				$memberdata['birthmonth'] = $birthday[1];
				$memberdata['birthday'] = $birthday[2];
			}

			$arr = array('realname' => trim($memberdata['realname']), 'weixin' => trim($memberdata['weixin']), 'birthyear' => intval($memberdata['birthyear']), 'birthmonth' => intval($memberdata['birthmonth']), 'birthday' => intval($memberdata['birthday']), 'province' => trim($memberdata['province']), 'city' => trim($memberdata['city']), 'datavalue' => trim($memberdata['datavalue']));

			if (is_numeric($memberdata['mobile'])) {
				$arr['mobile'] = trim($memberdata['mobile']);
			}

			pdo_update('ewei_shop_member', $arr, array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));

			if (!empty($this->member['uid'])) {
				$mcdata = $_GPC['mcdata'];
				load()->model('mc');
				unset($mcdata['credit1']);
				unset($mcdata['credit2']);
				mc_update($this->member['uid'], $mcdata);
			}
		}

		return app_json();
	}

	public function face()
	{
		global $_W;
		global $_GPC;
		$member = array('id' => $this->member['id'], 'avatar' => tomedia($this->member['avatar']), 'nickname' => $this->member['nickname']);

		if ($_W['ispost']) {
			$nickname = trim($_GPC['nickname']);
			$avatar = trim($_GPC['avatar']);

			if (empty($nickname)) {
				show_json(0, '请填写昵称');
			}

			if (empty($avatar)) {
				show_json(0, '请上传头像');
			}

			pdo_update('ewei_shop_member', array('avatar' => $avatar, 'nickname' => $nickname), array('id' => $member['id'], 'uniacid' => $_W['uniacid']));
			return app_json();
		}

		return app_json($member);
	}
}

?>
