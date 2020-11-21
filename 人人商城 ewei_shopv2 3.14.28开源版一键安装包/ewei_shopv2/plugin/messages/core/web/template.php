<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Template_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		if ($_GPC['op'] == 'delete' && !empty($_GPC['ids'])) {
			$this->delete($_GPC['ids']);
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and title  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_message_mass_template') . (' WHERE 1 ' . $condition . '  ORDER BY id asc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_message_mass_template') . (' WHERE 1 ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
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

		if (!empty($_GPC['id'])) {
			$list = pdo_fetch('SELECT * FROM ' . tablename('ewei_message_mass_template') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $_GPC['id'], ':uniacid' => $_W['uniacid']));
			$data = iunserializer($list['data']);
		}

		if ($_W['ispost']) {
			$id = $_GPC['id'];
			$keywords = $_GPC['tp_kw'];
			$value = $_GPC['tp_value'];
			$color = $_GPC['tp_color'];

			if (!empty($keywords)) {
				$data = array();

				foreach ($keywords as $key => $val) {
					$data[] = array('keywords' => $keywords[$key], 'value' => $value[$key], 'color' => $color[$key]);
				}
			}

			$insert = array('title' => $_GPC['tp_title'], 'template_id' => trim($_GPC['tp_template_id']), 'first' => trim($_GPC['tp_first']), 'firstcolor' => trim($_GPC['firstcolor']), 'data' => iserializer($data), 'remark' => trim($_GPC['tp_remark']), 'remarkcolor' => trim($_GPC['remarkcolor']), 'url' => trim($_GPC['tp_url']), 'uniacid' => $_W['uniacid']);

			if (!empty($_GPC['miniprogram'])) {
				$insert['miniprogram'] = $_GPC['miniprogram'];
				$insert['appid'] = $_GPC['appid'];
				$insert['pagepath'] = $_GPC['pagepath'];
			}
			else {
				$insert['miniprogram'] = '';
				$insert['appid'] = '';
				$insert['pagepath'] = '';
			}

			if (empty($id)) {
				pdo_insert('ewei_message_mass_template', $insert);
				$id = pdo_insertid();
				plog('sysset.tmessage.delete', '添加群发模板 ID: ' . $id . ' 标题: ' . $insert['title'] . ' ');
			}
			else {
				pdo_update('ewei_message_mass_template', $insert, array('id' => $id));
				plog('sysset.tmessage.delete', '编辑群发模板 ID: ' . $id . ' 标题: ' . $insert['title'] . ' ');
			}

			show_json(1, array('url' => webUrl('messages/template')));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_message_mass_template') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_message_mass_template', array('id' => $id, 'uniacid' => $_W['uniacid']));
			plog('messages.template.delete', '删除群发模板 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_message_mass_template') . (' WHERE 1 ' . $condition . ' order by id asc'), $params);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}

	public function tpl()
	{
		global $_W;
		global $_GPC;
		$kw = $_GPC['kw'];
		$tpkw = $_GPC['tpkw'];
		include $this->template();
	}

	public function check()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			$check_openid = $_GPC['check_openid'];

			if (empty($check_openid)) {
				show_json(0, array('message' => '请选择发送校验信息用户!'));
			}

			$member = pdo_fetch('select *  from ' . tablename('ewei_shop_member') . ' where openid=:openid and uniacid = :uniacid ', array(':openid' => $check_openid, ':uniacid' => $_W['uniacid']));
			$ref = $this->sendTplNotice($check_openid, $id, $member['nickname']);

			if (is_error($ref)) {
				show_json(0, '发送失败,请检查模板信息是否正确!');
			}
			else {
				show_json(1, '发送成功!');
			}
		}

		include $this->template();
	}

	public function gettemplateid()
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$bb = '{"template_id_short":"' . $_GPC['templateidshort'] . '"}';
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=' . $token;
		$c = ihttp_request($url, $bb);
		$result = @json_decode($c['content'], true);

		if (!is_array($result)) {
			show_json(0);
		}

		if (!empty($result['errcode'])) {
			show_json(0, $result['errmsg']);
		}

		show_json(1, $result);
	}

	public function gettemplatelist()
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=' . $token;
		$c = ihttp_request($url);
		$result = @json_decode($c['content'], true);

		if (!is_array($result)) {
			show_json(0);
		}

		if (!empty($result['errcode'])) {
			show_json(0, $result['errmsg']);
		}

		foreach ($result['template_list'] as $key => &$value) {
			preg_match_all('{{(.)*?}}', $value['content'], $matches);

			foreach ($matches[0] as &$v) {
				$v = str_replace(array('{', '}', '.DATA'), '', $v);
			}

			unset($v);
			$value['contents'] = $matches[0];
			$result['template_list'][$key]['content'] = str_replace(array('

', '
'), '<br />', $value['content']);
		}

		unset($value);
		show_json(1, $result);
	}

	public function deltemplatebyid()
	{
		global $_W;
		global $_GPC;
		load()->func('communication');
		$bb = '{"template_id":"' . $_GPC['template_id'] . '"}';
		$account = m('common')->getAccount();
		$token = $account->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=' . $token;
		$c = ihttp_request($url, $bb);
		$result = @json_decode($c['content'], true);

		if (!is_array($result)) {
			show_json(0);
		}

		if (!empty($result['errcode'])) {
			show_json(0, $result['errmsg']);
		}

		show_json(1, $result);
	}

	public function sendTplNotice($openid, $templateid, $nickname)
	{
		global $_W;
		$member = m('member')->getMember($openid);
		$result = false;

		if (!empty($templateid)) {
			$template = pdo_fetch('SELECT * FROM ' . tablename('ewei_message_mass_template') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $templateid, ':uniacid' => $_W['uniacid']));
			$data = iunserializer($template['data']);
			$msg = array(
				'first'  => array('value' => $template['first'], 'color' => $template['firstcolor']),
				'remark' => array('value' => $template['remark'], 'color' => $template['remarkcolor'])
			);
			$i = 0;

			while ($i < count($data)) {
				if (stripos($data[$i]['value'], '[商城名称]') !== false) {
					$data[$i]['value'] = str_replace('[商城名称]', $_W['shopset']['shop']['name'], $data[$i]['value']);
				}

				if (stripos($data[$i]['value'], '[粉丝昵称]') !== false) {
					$data[$i]['value'] = str_replace('[粉丝昵称]', $nickname, $data[$i]['value']);
				}

				$msg[$data[$i]['keywords']] = array('value' => $data[$i]['value'], 'color' => $data[$i]['color']);
				++$i;
			}

			$result = m('message')->sendTplNotice($openid, $template['template_id'], $msg, $template['url']);
		}

		return $result;
	}
}

?>
