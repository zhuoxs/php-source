<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'abonus/core/page_login_mobile.php';
class Register_EweiShopV2Page extends AbonusMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$set = set_medias($this->set, 'regbg');
		$member = m('member')->getMember($openid);
		if ($member['isaagent'] == 1 && $member['aagentstatus'] == 1) {
			header('location: ' . mobileUrl('abonus'));
			exit();
		}

		if ($member['agentblack'] || $member['aagentblack']) {
			include $this->template();
			exit();
		}

		$apply_set = array();
		$apply_set['open_protocol'] = $set['open_protocol'];

		if (empty($set['applytitle'])) {
			$apply_set['applytitle'] = '区域代理申请协议';
		}
		else {
			$apply_set['applytitle'] = $set['applytitle'];
		}

		$template_flag = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			$set_config = $diyform_plugin->getSet();
			$abonus_diyform_open = $set_config['abonus_diyform_open'];

			if ($abonus_diyform_open == 1) {
				$template_flag = 1;
				$diyform_id = $set_config['abonus_diyform'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);
					$fields = $formInfo['fields'];
					$diyform_data = iunserializer($member['diyaagentdata']);
					$f_data = $diyform_plugin->getDiyformData($diyform_data, $fields, $member);
				}
			}
		}

		if ($_W['ispost']) {
			if ($set['become'] != '1') {
				show_json(0, '未开启' . $set['texts']['agent'] . '注册!');
			}

			if ($template_flag == 1) {
				$memberdata = $_GPC['memberdata'];
				$insert_data = $diyform_plugin->getInsertData($fields, $memberdata);
				$data = $insert_data['data'];
				$m_data = $insert_data['m_data'];
				$mc_data = $insert_data['mc_data'];
				$m_data['diyaagentid'] = $diyform_id;
				$m_data['diyaagentfields'] = iserializer($fields);
				$m_data['diyaagentdata'] = $data;
				$m_data['isaagent'] = 1;
				$m_data['aagentstatus'] = 0;
				$m_data['aagenttime'] = 0;
				unset($m_data['credit1']);
				unset($m_data['credit2']);
				pdo_update('ewei_shop_member', $m_data, array('id' => $member['id']));

				if (!empty($member['uid'])) {
					if (!empty($mc_data)) {
						unset($mc_data['credit1']);
						unset($mc_data['credit2']);
						m('member')->mc_update($member['uid'], $mc_data);
					}
				}
			}
			else {
				$province = trim(str_replace(' ', '', $_GPC['province']));
				$provinces = !empty($province) ? iserializer(array($province)) : iserializer(array());
				$city = trim(str_replace(' ', '', $_GPC['city']));
				$citys = !empty($city) ? iserializer(array(str_replace(' ', '', $city))) : iserializer(array());
				$area = trim(str_replace(' ', '', $_GPC['area']));
				$areas = !empty($area) ? iserializer(array($area)) : iserializer(array());
				$data = array('isaagent' => 1, 'aagentstatus' => 0, 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']), 'weixin' => trim($_GPC['weixin']), 'aagenttime' => 0, 'aagenttype' => intval($_GPC['aagenttype']), 'aagentprovinces' => $provinces, 'aagentcitys' => $citys, 'aagentareas' => $areas);
				pdo_update('ewei_shop_member', $data, array('id' => $member['id']));

				if (!empty($member['uid'])) {
					m('member')->mc_update($member['uid'], array('realname' => $data['realname'], 'mobile' => $data['mobile']));
				}
			}

			show_json(1);
		}

		include $this->template();
	}
}

?>
