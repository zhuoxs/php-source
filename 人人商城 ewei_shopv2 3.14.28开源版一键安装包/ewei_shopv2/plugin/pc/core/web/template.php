<?php
class TemplateController extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = 'uniacid=:uniacid ';
		$params['uniacid'] = $_W['uniacid'];

		if (!empty($_GPC['keyword'])) {
			$condition .= ' and  title like :keyword  ';
			$params[':title'] = '%' . $_GPC['keyword'] . '%';
		}

		$condition .= ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall('SELECT * from' . tablename('ewei_shop_pc_template') . (' where ' . $condition), $params);
		include $this->template();
	}

	public function add()
	{
		global $_W;
		global $_GPC;
		$this->post();
	}

	public function edit()
	{
		global $_W;
		global $_GPC;
		$this->post();
	}

	public function post()
	{
		global $_W;
		global $_GPC;
		session_start();

		if ($_W['ispost']) {
			if (empty($_GPC['id'])) {
				$data['title'] = $_GPC['title'];
				$data['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_pc_template', $data);
				$id = pdo_insertid();

				if ($id) {
					show_json(1, array('url' => webUrl('pc')));
				}
			}
			else {
				pdo_update('ewei_shop_pc_template', array('title' => $_GPC['title']), array('id' => $_GPC['id'], 'uniacid' => $_W['uniacid']));
				show_json(1, array('url' => webUrl('pc')));
			}
		}

		if (!empty($_GPC['id'])) {
			$id = $_GPC['id'];
		}

		$data = pdo_get('ewei_shop_pc_template', array('id' => $id, 'uniacid' => $_W['uniacid']));
		include $this->template();
	}
}

?>
