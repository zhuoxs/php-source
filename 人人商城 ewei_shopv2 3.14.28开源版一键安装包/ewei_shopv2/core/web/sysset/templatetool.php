<?php
//QQ63779278
echo '  ';

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Templatetool_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}

	public function gettypecodes()
	{
		$items = pdo_fetchall('select typecode from ' . tablename('ewei_shop_member_message_template_type') . ' where templatecode is not null');
		$typecode = array();

		foreach ($items as $item) {
			$typecode[] = $item['typecode'];
		}

		$typecode = json_encode($typecode);
		$this->setoldtemplateid();
		show_json(1, array('length' => count($items), 'typecodes' => $typecode));
	}

	public function setoldtemplateid()
	{
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

		$content = '{{first.DATA}}业务类型：{{keyword1.DATA}}处理状态：{{keyword2.DATA}}处理内容：{{keyword3.DATA}}{{remark.DATA}}';
		$content = str_replace(array('
', '
', '
', ' '), '', $content);
		$content = str_replace(array('：'), ':', $content);
		$templatenum = count($result['template_list']);
		$issnoet = true;
		$template_id = '';

		foreach ($result['template_list'] as $key => $value) {
			$valuecontent = str_replace(array('
', '
', '
', ' '), '', $value['content']);
			$valuecontent = str_replace(array('：'), ':', $valuecontent);

			if ($valuecontent == $content) {
				$issnoet = false;
				$template_id = $value['template_id'];
			}
		}

		if (p('commission')) {
			$data1 = m('common')->getPluginset('commission', false);
			$data1 = $data1['tm'];

			if (!empty($data1['templateid'])) {
				$data1['templateid'] = $template_id;
				m('common')->updatePluginset(array(
					'commission' => array('tm' => $data1)
				));
			}
		}

		if (p('globonus')) {
			$data2 = m('common')->getPluginset('globonus');
			$data2 = $data2['tm'];

			if (!empty($data2['templateid'])) {
				$data2['templateid'] = $template_id;
				m('common')->updatePluginset(array(
					'globonus' => array('tm' => $data2)
				));
			}
		}

		if (p('abonus')) {
			$data3 = m('common')->getPluginset('abonus');
			$data3 = $data3['tm'];

			if (!empty($data3['templateid'])) {
				$data3['templateid'] = $template_id;
				m('common')->updatePluginset(array(
					'abonus' => array('tm' => $data3)
				));
			}
		}

		if (p('merch')) {
			$data4 = m('common')->getPluginset('merch');
			$data4 = $data4['tm'];

			if (!empty($data4['templateid'])) {
				$data4['templateid'] = $template_id;
				m('common')->updatePluginset(array(
					'merch' => array('tm' => $data4)
				));
			}
		}

		$data5 = m('common')->getPluginset('coupon');

		if (!empty($data5['sendtemplateid'])) {
			$data5['sendtemplateid'] = $template_id;
		}

		if (!empty($data5['templateid'])) {
			$data5['templateid'] = $template_id;
		}

		m('common')->updatePluginset(array('coupon' => $data5));
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

		foreach ($result['template_list'] as $key => $value) {
			$valuecontent = str_replace(array('
', '
', '
', ' '), '', $value['content']);
			$valuecontent = str_replace(array('：'), ':', $valuecontent);

			if ($valuecontent == $content) {
				$issnoet = false;
				$defaulttemp = pdo_fetch('select 1  from ' . tablename('ewei_shop_member_message_template_default') . ' where typecode=:typecode and uniacid=:uniacid  limit 1', array(':typecode' => $tag, ':uniacid' => $_W['uniacid']));

				if (empty($defaulttemp)) {
					pdo_insert('ewei_shop_member_message_template_default', array('typecode' => $tag, 'uniacid' => $_W['uniacid'], 'templateid' => $value['template_id']));
				}
				else {
					pdo_update('ewei_shop_member_message_template_default', array('templateid' => $value['template_id']), array('typecode' => $tag, 'uniacid' => $_W['uniacid']));
				}

				show_json(1, array('status' => 1, 'tag' => $tag));
			}
		}

		show_json(1, array('status' => 1, 'tag' => $tag));
	}
}

?>
