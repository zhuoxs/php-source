<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND `title` LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if (!empty($_GPC['type'])) {
			$condition .= ' AND `type` = :type';
			$params[':type'] = intval($_GPC['type']);
		}

		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_invitation') . (' where 1 ' . $condition . ' '), $params);
		$list = array();

		if (0 < $total) {
			$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_invitation') . (' WHERE 1 ' . $condition . ' ORDER BY createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		}

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
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_invitation') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$data = $_GPC['data'];

			if (empty($data)) {
				show_json(0, '提交数据错误，请刷新重试');
			}

			$postdata = array('type' => intval($data['type']), 'title' => trim($data['title']), 'status' => intval($data['status']), 'qrcode' => intval($data['qrcode']), 'data' => iserializer($data));
			$len = mb_strlen($_GPC['data']['title'], 'utf-8');

			if (15 < $len) {
				show_json(0, '标题最多15个汉字或字符哦~');
			}

			if (empty($id)) {
				$postdata['createtime'] = time();
				$postdata['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_invitation', $postdata);
				$id = pdo_insertid();
			}
			else {
				pdo_update('ewei_shop_invitation', $postdata, array('id' => $id, 'uniacid' => $_W['uniacid']));
			}

			$ruleauto = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and `module`=:module and `name`=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:invitation:auto'));

			if (empty($ruleauto)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:invitation:auto', 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => 'EWEI_SHOP_INVITATION', 'type' => 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}

			show_json(1, array('id' => $id));
		}

		$data = array('id' => 0, 'data' => '', 'attachurl' => $_W['attachurl']);

		if (!empty($item)) {
			$data['id'] = $item['id'];
			$data['data'] = iunserializer($item['data']);
			$data['data']['status'] = $item['status'];
		}

		$json = json_encode($data);
		include $this->template();
	}

	/**
     * 删除
     */
	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$invitations = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_invitation') . (' WHERE id in ( ' . $id . ' ) and uniacid=') . $_W['uniacid']);

		foreach ($invitations as $invitation) {
			pdo_delete('ewei_shop_invitation', array('id' => $invitation['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_invitation_log', array('invitation_id' => $invitation['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_invitation_qr', array('invitationid' => $invitation['id'], 'acid' => $_W['acid']));
			plog('invitation.delete', '删除邀请卡 ID: ' . $id . ' 名称: ' . $invitation['title']);
		}

		show_json(1, array('url' => webUrl('invitation')));
	}

	/**
     * ajax修改状态，排序
     */
	public function property()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = trim($_GPC['type']);
		$value = intval($_GPC['value']);

		if (in_array($type, array('status'))) {
			$statusstr = '';

			if ($type == 'status') {
				$typestr = '状态';
				$statusstr = $value == 1 ? '显示' : '关闭';
			}

			$property_update = pdo_update('ewei_shop_invitation', array($type => $value), array('id' => $id, 'uniacid' => $_W['uniacid']));

			if (!$property_update) {
				show_json(0, '' . $typestr . '修改失败');
			}

			plog('invitation.edit', '修改邀请卡' . $typestr . '状态   ID: ' . $id . ' ' . $statusstr . ' ');
		}

		show_json(1);
	}
}

?>
