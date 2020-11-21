<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Set_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $this->model->getSet();

		if ($_W['ispost']) {
			$data = array('showmember' => intval($_GPC['showmember']), 'showtype' => intval($_GPC['showtype']), 'keyword' => trim($_GPC['keyword']), 'enter_title' => trim($_GPC['enter_title']), 'enter_img' => trim($_GPC['enter_img']), 'enter_desc' => trim($_GPC['enter_desc']), 'share' => intval($_GPC['share']));
			$keyword = m('common')->keyExist($data['keyword']);

			if (!empty($keyword)) {
				if ($keyword['name'] != 'ewei_shopv2:qa') {
					show_json(0, '关键字已存在！');
				}
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2:qa'));

			if (!empty($rule)) {
				$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
				$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
			}

			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:qa', 'module' => 'cover', 'displayorder' => 0, 'status' => 1);

			if (empty($rule)) {
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
			}
			else {
				pdo_update('rule', $rule_data, array('id' => $rule['id']));
				$rid = $rule['id'];
			}

			$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => $data['keyword'], 'type' => 1, 'displayorder' => 0, 'status' => 1);

			if (empty($keyword)) {
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				pdo_update('rule_keyword', $keyword_data, array('id' => $keyword['id']));
			}

			$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => $this->modulename, 'title' => $data['enter_title'], 'description' => $data['enter_desc'], 'thumb' => $data['enter_img'], 'url' => mobileUrl('qa'));

			if (empty($cover)) {
				pdo_insert('cover_reply', $cover_data);
			}
			else {
				pdo_update('cover_reply', $cover_data, array('id' => $cover['id']));
			}

			if (!empty($set)) {
				pdo_update('ewei_shop_qa_set', $data, array('id' => $set['id']));
			}
			else {
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_qa_set', $data);
				$id = pdo_insertid();
			}

			plog('qa.set.save', '修改基础设置');
			show_json(1);
		}

		$url = mobileUrl('qa', NULL, true);
		$qrcode = m('qrcode')->createQrcode($url);
		include $this->template();
	}
}

?>
