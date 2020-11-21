<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Temp_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		header('location: ' . webUrl('exhelper/index'));
	}

	protected function tempData($type)
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid = :uniacid and type=:type and merchid=0';
		$params = array(':uniacid' => $_W['uniacid'], ':type' => $type);

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND expressname LIKE :expressname';
			$params[':expressname'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$sql = 'SELECT id,expressname,expresscom,isdefault FROM ' . tablename('ewei_shop_exhelper_express') . (' where  1 and ' . $condition . ' ORDER BY isdefault desc, id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exhelper_express') . (' where 1 and ' . $condition), $params);
		$pager = pagination($total, $pindex, $psize);
		return array('list' => $list, 'total' => $total, 'pager' => $pager, 'type' => $type);
	}

	public function invoice()
	{
		global $_W;
		global $_GPC;
		$data = $this->tempData(1);
		extract($data);
		include $this->template('exhelper/temp/index');
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		$data = $this->tempData(2);
		extract($data);
		include $this->template('exhelper/temp/index');
	}

	public function add1()
	{
		$this->post();
	}

	public function add2()
	{
		$this->post();
	}

	public function edit1()
	{
		$this->post();
	}

	public function edit2()
	{
		$this->post();
	}

	public function post()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = trim($_GPC['type']);

		if ($type == 'temp.invoice') {
			$type = 1;
		}
		else {
			if ($type == 'temp.express') {
				$type = 2;
			}
		}

		if (!empty($id)) {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_exhelper_express') . ' where id=:id and type=:type and uniacid=:uniacid and merchid=0 limit 1', array(':id' => $id, ':type' => $type, ':uniacid' => $_W['uniacid']));
		}

		include $this->template('exhelper/temp/post');
	}

	public function delete()
	{
	}

	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		$id = intval($_GPC['id']);
		if (!empty($type) && !empty($id)) {
			$item = pdo_fetch('SELECT id,expressname,type FROM ' . tablename('ewei_shop_exhelper_express') . ' WHERE id=:id and type=:type AND uniacid=:uniacid and merchid=0', array(':id' => $id, ':type' => $type, ':uniacid' => $_W['uniacid']));

			if (!empty($item)) {
				pdo_update('ewei_shop_exhelper_express', array('isdefault' => 0), array('type' => $type, 'uniacid' => $_W['uniacid'], 'merchid' => 0));
				pdo_update('ewei_shop_exhelper_express', array('isdefault' => 1), array('id' => $id, 'merchid' => 0));
			}
		}

		show_json(1);
	}
}

?>
