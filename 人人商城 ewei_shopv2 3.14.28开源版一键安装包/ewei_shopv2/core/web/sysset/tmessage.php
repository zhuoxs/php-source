<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Tmessage_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and title  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_message_template') . (' WHERE 1 ' . $condition . '  ORDER BY id asc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member_message_template') . (' WHERE 1 ' . $condition), $params);
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
		$typegroup = pdo_fetchall('SELECT `typegroup`,groupname   FROM ' . tablename('ewei_shop_member_message_template_type') . ' group by `typegroup` order by id ');
		$templatetypes = pdo_fetchall('SELECT id,`name`,`typegroup`,typecode   FROM ' . tablename('ewei_shop_member_message_template_type'));
		$type_json = @json_encode($templatetypes);

		if (!empty($_GPC['id'])) {
			$list = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $_GPC['id'], ':uniacid' => $_W['uniacid']));
			$types = pdo_fetch('SELECT *  FROM ' . tablename('ewei_shop_member_message_template_type') . ' WHERE typecode=:typecode ', array(':typecode' => $list['typecode']));
			$data = iunserializer($list['data']);
		}

		$templatetypes2 = array();

		foreach ($templatetypes as $temp) {
			if (!empty($types) && $types['typegroup'] == $temp['typegroup']) {
				$templatetypes2[] = $temp;
			}
			else {
				if (empty($types) && $temp['typegroup'] == 'sys') {
					$templatetypes2[] = $temp;
				}
			}
		}

		$templatetypes = $templatetypes2;

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

			$insert = array('title' => $_GPC['title'], 'typecode' => trim($_GPC['typecode']), 'messagetype' => $_GPC['messagetype'], 'template_id' => trim($_GPC['tp_template_id']), 'first' => trim($_GPC['tp_first']), 'firstcolor' => trim($_GPC['firstcolor']), 'data' => iserializer($data), 'remark' => trim($_GPC['tp_remark']), 'remarkcolor' => trim($_GPC['remarkcolor']), 'send_desc' => $_GPC['send_desc'], 'uniacid' => $_W['uniacid']);

			if (empty($id)) {
				pdo_insert('ewei_shop_member_message_template', $insert);
				$id = pdo_insertid();
				plog('sysset.tmessage.delete', '添加群发模板 ID: ' . $id . ' 标题: ' . $insert['title'] . ' ');
			}
			else {
				pdo_update('ewei_shop_member_message_template', $insert, array('id' => $id));
				plog('sysset.tmessage.delete', '编辑群发模板 ID: ' . $id . ' 标题: ' . $insert['title'] . ' ');
			}

			show_json(1, array('url' => webUrl('sysset/tmessage')));
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

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_message_template') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_member_message_template', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
			plog('sysset.tmessage.delete', '删除群发模板 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' ');
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

		$ds = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_message_template') . (' WHERE 1 ' . $condition . ' order by id asc'), $params);

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
}

?>
