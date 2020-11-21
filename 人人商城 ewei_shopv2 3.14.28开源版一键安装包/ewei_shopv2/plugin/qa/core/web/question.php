<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Question_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' q.uniacid = :uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND q.title LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		if ($_GPC['status'] != '') {
			$condition .= ' AND q.status=:status';
			$params[':status'] = intval($_GPC['status']);
		}

		if ($_GPC['isrecommand'] != '') {
			$condition .= ' AND q.isrecommand=:isrecommand';
			$params[':isrecommand'] = intval($_GPC['isrecommand']);
		}

		if ($_GPC['cate'] != '') {
			$condition .= ' AND q.cate=:cate';
			$params[':cate'] = intval($_GPC['cate']);
		}

		$sql = 'SELECT q.*, c.name as catename FROM ' . tablename('ewei_shop_qa_question') . ' q left join' . tablename('ewei_shop_qa_category') . (' c on c.id=q.cate where  1 and ' . $condition . ' ORDER BY q.displayorder DESC,q.id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_qa_question') . ' q left join' . tablename('ewei_shop_qa_category') . (' c on c.id=q.cate where  1 and ' . $condition), $params);
		$pager = pagination2($total, $pindex, $psize);
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_qa_category') . ' where uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));

		if (!empty($list)) {
			foreach ($list as $key => &$value) {
				$url = mobileUrl('qa/detail', array('id' => $value['id']), true);
				$value['qrcode'] = m('qrcode')->createQrcode($url);
			}
		}

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

		if (!empty($id)) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_qa_question') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$item['content'] = iunserializer($item['content']);
			$item['content'] = m('common')->html_to_images($item['content']);
		}

		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_qa_category') . ' where uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$data = array('uniacid' => $_W['uniacid'], 'title' => trim($_GPC['title']), 'cate' => intval($_GPC['cate']), 'status' => intval($_GPC['status']), 'isrecommand' => intval($_GPC['isrecommand']), 'displayorder' => intval($_GPC['displayorder']), 'content' => iserializer($_GPC['content']), 'lastedittime' => time(), 'keywords' => $_GPC['keywords']);
			$data['content'] = m('common')->html_images($_GPC['content']);

			if (!empty($id)) {
				pdo_update('ewei_shop_qa_question', $data, array('id' => $id));
				plog('qa.category.edit', '修改积分商城分类 ID: ' . $id);
			}
			else {
				$data['createtime'] = time();
				pdo_insert('ewei_shop_qa_question', $data);
				$id = pdo_insertid();
				plog('qa.category.add', '添加积分商城分类 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('qa/question/edit', array('id' => $id))));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,title FROM ' . tablename('ewei_shop_qa_question') . (' WHERE id = \'' . $id . '\' AND uniacid=') . $_W['uniacid'] . '');

		if (empty($item)) {
			show_json(0, '抱歉，问题不存在或是已经被删除！', array('url' => webUrl('qa/question')));
		}

		pdo_delete('ewei_shop_qa_question', array('id' => $id));
		plog('qa.question.delete', '删除问题 ID: ' . $id . ' 标题: ' . $item['title'] . ' ');
		show_json(1);
	}

	public function displayorder()
	{
		global $_GPC;
		global $_W;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_qa_question') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($item)) {
			pdo_update('ewei_shop_qa_question', array('displayorder' => $displayorder), array('id' => $id));
			plog('qa.question.edit', '修改分类排序 ID: ' . $item['id'] . ' 标题: ' . $item['title'] . ' 排序: ' . $displayorder . ' ');
		}

		show_json(1);
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_qa_question') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_qa_question', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('qa.question.edit', '修改问题显示状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['title'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '显示' : '隐藏');
		}

		show_json(1);
	}

	public function isrecommand()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_qa_question') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_qa_question', array('isrecommand' => intval($_GPC['isrecommand'])), array('id' => $item['id']));
			plog('qa.question.edit', '修改问题显示状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['title'] . '<br/>状态: ' . $_GPC['isrecommand'] == 1 ? '推荐' : '取消推荐');
		}

		show_json(1);
	}
}

?>
