<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Category_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_sns_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY displayorder DESC'));
		include $this->template();
	}

	public function displayorder()
	{
		global $_GPC;
		global $_W;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_sns_category') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($item)) {
			pdo_update('ewei_shop_sns_category', array('displayorder' => $displayorder), array('id' => $id));
			plog('sns.category.edit', '修改分类排序 ID: ' . $item['id'] . ' 标题: ' . $item['name'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
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

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'name' => trim($_GPC['catename']), 'enabled' => intval($_GPC['enabled']), 'isrecommand' => intval($_GPC['isrecommand']), 'displayorder' => intval($_GPC['displayorder']), 'thumb' => save_media($_GPC['thumb']));

			if (!empty($id)) {
				pdo_update('ewei_shop_sns_category', $data, array('id' => $id));
				plog('sns.category.edit', '修改版块分类 ID: ' . $id);
			}
			else {
				pdo_insert('ewei_shop_sns_category', $data);
				$id = pdo_insertid();
				plog('sns.category.add', '添加版块分类 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('sns/category', array('op' => 'display'))));
		}

		$item = pdo_fetch('select * from ' . tablename('ewei_shop_sns_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$url = mobileUrl('sns/board/lists', array('cid' => $item['id']), true);
			$qrcode = m('qrcode')->createQrcode($url);
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_sns_category') . (' WHERE id = \'' . $id . '\' AND uniacid=') . $_W['uniacid'] . '');

		if (empty($item)) {
			message('抱歉，分类不存在或是已经被删除！', webUrl('sns/category', array('op' => 'display')), 'error');
		}

		pdo_delete('ewei_shop_sns_category', array('id' => $id));
		plog('sns.category.delete', '删除版块分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		show_json(1);
	}

	public function enabled()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,name FROM ' . tablename('ewei_shop_sns_category') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_sns_category', array('enabled' => intval($_GPC['enabled'])), array('id' => $item['id']));
			plog('sns.category.edit', '修改商品分类<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['name'] . '<br/>状态: ' . $_GPC['enabled'] == 1 ? '显示' : '隐藏');
		}

		show_json(1, array('url' => referer()));
	}
}

?>
