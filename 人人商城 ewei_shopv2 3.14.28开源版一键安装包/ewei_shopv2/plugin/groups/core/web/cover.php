<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Cover_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2拼团入口设置'));

		if (!empty($rule)) {
			$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
			$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
		}

		if ($_W['ispost']) {
			$data = is_array($_GPC['cover']) ? $_GPC['cover'] : array();

			if (empty($data['keyword'])) {
				show_json(0, '请输入关键词!');
			}

			$keyword = m('common')->keyExist($data['keyword']);

			if (!empty($keyword)) {
				if ($keyword['name'] != 'ewei_shopv2拼团入口设置') {
					show_json(0, '关键字已存在!');
				}
			}

			if (!empty($rule)) {
				pdo_delete('rule', array('id' => $rule['id'], 'uniacid' => $_W['uniacid']));
				pdo_delete('rule_keyword', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
				pdo_delete('cover_reply', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
			}

			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2拼团入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => intval($data['status']));
			pdo_insert('rule', $rule_data);
			$rid = pdo_insertid();
			$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => intval($data['status']));
			pdo_insert('rule_keyword', $keyword_data);
			$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => $this->modulename, 'title' => trim($data['title']), 'description' => trim($data['desc']), 'thumb' => save_media($data['thumb']), 'url' => mobileUrl('groups'));
			pdo_insert('cover_reply', $cover_data);
			plog('groups.cover.edit', '修改拼团入口设置');
			show_json(1);
		}

		$url = mobileUrl('groups', NULL, true);
		$qrcode = m('qrcode')->createQrcode($url);
		include $this->template();
	}
}

?>
