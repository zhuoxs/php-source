<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Info_EweiShopV2Page extends MobileLoginPage
{
	protected $member;

	public function __construct()
	{
		global $_W;
		global $_GPC;
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

		return array('template_flag' => $template_flag, 'set_config' => $set_config, 'diyform_plugin' => $diyform_plugin, 'formInfo' => $formInfo, 'diyform_id' => $diyform_id, 'diyform_data' => $diyform_data, 'fields' => $fields, 'f_data' => $f_data);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$diyform_data = $this->diyformData();
		extract($diyform_data);
		$returnurl = urldecode(trim($_GPC['returnurl']));
		$member = $this->member;
		$wapset = m('common')->getSysset('wap');
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$show_data = 1;
		if (!empty($new_area) && empty($member['datavalue']) || empty($new_area) && !empty($member['datavalue'])) {
			$show_data = 0;
		}

		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$diyform_data = $this->diyformData();
		extract($diyform_data);
		$memberdata = $_GPC['memberdata'];

		if ($template_flag == 1) {
			$data = array();
			$m_data = array();
			$mc_data = array();
			$insert_data = $diyform_plugin->getInsertData($fields, $memberdata);
			$data = $insert_data['data'];
			$m_data = $insert_data['m_data'];
			$mc_data = $insert_data['mc_data'];
			$m_data['diymemberid'] = $diyform_id;
			$m_data['diymemberfields'] = iserializer($fields);
			$m_data['diymemberdata'] = $data;
			unset($mc_data['credit1']);
			unset($m_data['credit2']);

			if (!empty($memberdata['edit_avatar'])) {
				$m_data['avatar'] = $memberdata['edit_avatar'];
			}

			$m_data['nickname'] = $memberdata['nickname'];
			pdo_update('ewei_shop_member', $m_data, array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));

			if (!empty($this->member['uid'])) {
				if (!empty($mc_data)) {
					unset($mc_data['credit1']);
					unset($mc_data['credit2']);
					m('member')->mc_update($this->member['uid'], $mc_data);
				}
			}
		}
		else {
			$arr = array('realname' => trim($memberdata['realname']), 'weixin' => trim($memberdata['weixin']), 'birthyear' => intval($memberdata['birthyear']), 'birthmonth' => intval($memberdata['birthmonth']), 'birthday' => intval($memberdata['birthday']), 'province' => trim($memberdata['province']), 'city' => trim($memberdata['city']), 'datavalue' => trim($memberdata['datavalue']), 'mobile' => trim($memberdata['mobile']), 'nickname' => trim($memberdata['nickname']), 'avatar' => trim($memberdata['avatar']));
			if (empty($_W['shopset']['app']['isclose']) && !empty($_W['shopset']['app']['openbind']) || !empty($_W['shopset']['wap']['open'])) {
				unset($arr['mobile']);
			}

			pdo_update('ewei_shop_member', $arr, array('openid' => $_W['openid'], 'uniacid' => $_W['uniacid']));

			if (!empty($this->member['uid'])) {
				$mcdata = $_GPC['mcdata'];
				unset($mcdata['credit1']);
				unset($mcdata['credit2']);
				m('member')->mc_update($this->member['uid'], $mcdata);
			}
		}

		show_json(1);
	}

	public function face()
	{
		global $_W;
		global $_GPC;
		$member = $this->member;

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
			show_json(1);
		}

		include $this->template();
	}
}

?>
