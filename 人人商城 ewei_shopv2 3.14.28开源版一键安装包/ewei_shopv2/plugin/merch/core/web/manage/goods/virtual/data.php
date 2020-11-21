<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Data_EweiShopV2Page extends MerchWebPage
{
	public function __construct($_com = 'virtual')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$typeid = $_GPC['typeid'];

		if (empty($typeid)) {
			$this->message('Url参数错误！请重试！', merchUrl('goods/virtual/temp'), 'error');
			exit();
		}

		$kw = $_GPC['keyword'];
		$page = empty($_GPC['page']) ? '' : $_GPC['page'];
		$pindex = max(1, intval($page));
		$psize = 60;
		$type = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid ', array(':id' => $typeid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		$type['fields'] = iunserializer($type['fields']);
		$condition = ' and d.typeid=:typeid and d.uniacid=:uniacid and d.merchid=:merchid';
		$params = array(':typeid' => $typeid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']);

		if ($_GPC['status'] == '0') {
			$condition .= ' and d.openid=\'\'';
		}
		else {
			if ($_GPC['status'] == '1') {
				$condition .= ' and d.openid<>\'\'';
			}
		}

		if ($_GPC['status'] == '1') {
			$order = ' id DESC ';
		}
		else {
			$order = ' id ASC ';
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and d.pvalue like :pvalue';
			$params[':pvalue'] = '%' . $_GPC['keyword'] . '%';
		}

		if ($_GPC['time']['start'] != '' && $_GPC['time']['start'] != '') {
			$condition .= ' and d.createtime >= ' . strtotime($_GPC['time']['start']) . ' and d.createtime <= ' . strtotime($_GPC['time']['end']);
		}

		$items = pdo_fetchall('SELECT d.*,m.avatar,m.nickname,m.realname,m.mobile,o.status  FROM ' . tablename('ewei_shop_virtual_data') . ' d ' . ' left join ' . tablename('ewei_shop_member') . ' m on d.openid<>\'\' and m.openid = d.openid and m.uniacid= d.uniacid ' . ' left join ' . tablename('ewei_shop_order') . ' o on d.orderid<>0 and  o.id = d.orderid ' . (' where  1 ' . $condition . ' order by ' . $order . ' limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($items as &$row) {
			$carrier = iunserializer($row['carrier']);

			if (is_array($carrier)) {
				$row['realname'] = $carrier['carrier_realname'];
				$row['mobile'] = $carrier['carrier_mobile'];
			}
		}

		unset($row);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_virtual_data') . ' d ' . ' left join ' . tablename('ewei_shop_member') . ' m on d.openid<>\'\' and m.openid = d.openid and m.uniacid= d.uniacid ' . ' left join ' . tablename('ewei_shop_order') . ' o on d.orderid<>0 and  o.id = d.orderid ' . (' where 1 ' . $condition . ' '), $params);
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
		$typeid = $_GPC['typeid'];
		$editid = $_GPC['id'];

		if (empty($typeid)) {
			show_json(0, 'Url参数错误！请重试！');
			exit();
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid ', array(':id' => $_GPC['typeid'], ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

		if (!empty($item)) {
			$item['fields'] = iunserializer($item['fields']);
		}

		if (!empty($editid)) {
			$data = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_data') . ' WHERE id=:id and typeid=:typeid and uniacid=:uniacid and merchid=:merchid ', array(':id' => $editid, ':typeid' => $typeid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
			$data['edit'] = $editid;
		}

		if ($_W['ispost']) {
			$typeid = intval($_GPC['typeid']);

			if (!empty($typeid)) {
				$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid ', array(':id' => $typeid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
				$item['fields'] = iunserializer($item['fields']);

				if (!empty($item['fields'])) {
					$tpids = $_GPC['tp_id'];

					foreach ($tpids as $index => $id) {
						$values = array();

						foreach ($item['fields'] as $key => $name) {
							$values[$key] = $_GPC['tp_value_' . $key][$index];
						}

						$insert = array('typeid' => $_GPC['typeid'], 'pvalue' => $values['key'], 'fields' => iserializer($values), 'uniacid' => $_W['uniacid'], 'merchid' => $_W['merchid']);
						$datas = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_data') . ' WHERE id=:id and typeid=:typeid and uniacid=:uniacid and merchid=:merchid ', array(':id' => $id, ':typeid' => $typeid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

						if (empty($datas)) {
							$keydata = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_data') . ' WHERE pvalue=:pvalue  and typeid=:typeid and uniacid=:uniacid and merchid=:merchid', array(':pvalue' => $insert['pvalue'], ':typeid' => $typeid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

							if (empty($keydata)) {
								pdo_insert('ewei_shop_virtual_data', $insert);
								pdo_update('ewei_shop_virtual_type', 'alldata=alldata+1', array('id' => $item['id']));
							}
							else {
								pdo_update('ewei_shop_virtual_data', $insert, array('id' => $keydata['id']));
							}
						}
						else {
							$keydata = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_data') . ' WHERE pvalue=:pvalue and id<>:id and typeid=:typeid and uniacid=:uniacid and merchid=:merchid', array(':pvalue' => $insert['pvalue'], ':id' => $id, ':typeid' => $typeid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

							if (empty($keydata)) {
								pdo_update('ewei_shop_virtual_data', $insert, array('id' => $datas['id']));
							}
							else {
								$noinsert .= $insert['pvalue'] . ',';
							}
						}
					}

					com('virtual')->updateStock($typeid);
					mplog('goods.virtual.data.edit', '修改数据 模板ID: ' . $typeid);

					if (!empty($noinsert)) {
						$tip = '<br>未保存成功的数据：主键=' . $noinsert . '<br>失败原因：已经使用无法更改';
						show_json(1, array('message' => '部分数据保存成功！' . $tip, 'url' => merchUrl('virtual/data', array('typeid' => $typeid))));
					}
					else {
						show_json(1, array('url' => merchUrl('goods/virtual/data', array('typeid' => $typeid))));
					}
				}
			}
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$typeid = intval($_GPC['typeid']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$types = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_virtual_data') . (' WHERE id in( ' . $id . ' ) AND typeid=' . $typeid . ' and  uniacid=') . $_W['uniacid'] . ' and  merchid=' . $_W['merchid']);

		foreach ($types as $type) {
			if (!empty($type['openid'])) {
				continue;
			}

			pdo_delete('ewei_shop_virtual_data', array('id' => $type['id']));
			pdo_update('ewei_shop_virtual_type', 'alldata=alldata-1', array('id' => $type['typeid']));
			com('virtual')->updateStock($type['id']);
			mplog('goods.virtual.data.delete', '删除数据 模板ID: ' . $typeid . ' 数据ID: ' . $id);
		}

		show_json(1, array('url' => merchUrl('goods/virtual/data', array('typeid' => $typeid))));
	}

	public function export()
	{
		global $_W;
		global $_GPC;
		$typeid = intval($_GPC['typeid']);
		$type = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid limit 1 ', array(':id' => $typeid, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

		if (empty($type)) {
			$this->message('未找到虚拟物品模板!', '', 'error');
		}

		$type['fields'] = iunserializer($type['fields']);
		$condition = ' and d.typeid=:typeid and d.uniacid=:uniacid';
		$params = array(':typeid' => $typeid, ':uniacid' => $_W['uniacid']);
		if ($_GPC['time'] != '导入时间' && !empty($_GPC['time'])) {
			$time = explode('至', $_GPC['time']);
			$condition .= ' and d.createtime >= :start and d.createtime <= :end';
			$params[':start'] = strtotime($time[0]);
			$params[':end'] = strtotime($time[1]);
		}

		if ($_GPC['status'] == '0') {
			$condition .= ' and d.openid = \'\' ';
		}
		else {
			if ($_GPC['status'] == '1') {
				$condition .= ' and d.openid<>\'\' ';
			}
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and d.pvalue like :keyword ';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		$list = pdo_fetchall('SELECT d.*,o.carrier,m.avatar,m.nickname FROM ' . tablename('ewei_shop_virtual_data') . ' d ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = d.openid and m.uniacid = d.uniacid and d.merchid=0' . ' left join ' . tablename('ewei_shop_order') . ' o on o.id = d.orderid ' . (' where  1 ' . $condition . ' order by usetime desc'), $params);

		if (empty($list)) {
			$this->message('没有可导出的数据!', '', 'info');
		}

		foreach ($list as &$row) {
			$datas = iunserializer($row['fields']);
			$valuestr = '';

			foreach ($type['fields'] as $k => $v) {
				$row[$k] = $datas[$k] . ' ';
			}

			$carrier = iunserializer($row['carrier']);

			if (is_array($carrier)) {
				$row['realname'] = $carrier['carrier_realname'];
				$row['mobile'] = $carrier['carrier_mobile'];
			}

			if (empty($row['usetime']) || $row['usetime'] == 0) {
				$row['usetime'] = '';
			}
			else {
				$row['usetime'] = date('Y-m-d H:i', $row['usetime']);
			}
		}

		unset($row);
		$columns = array();

		foreach ($type['fields'] as $key => $name) {
			$columns[] = array('title' => $name . '(' . $key . ')', 'field' => $key, 'width' => 24);
		}

		$columns[] = array('title' => '粉丝昵称', 'field' => 'nickname', 'width' => 12);
		$columns[] = array('title' => '姓名', 'field' => 'realname', 'width' => 12);
		$columns[] = array('title' => '手机号', 'field' => 'mobile', 'width' => 12);
		$columns[] = array('title' => '使用时间', 'field' => 'usetime', 'width' => 12);
		$columns[] = array('title' => '订单号', 'field' => 'ordersn', 'width' => 24);
		$columns[] = array('title' => '购买价格', 'field' => 'price', 'width' => 12);
		$columns[] = array('title' => '状态:此列值为del时表示删除(status)', 'field' => 'status', 'width' => 34);
		m('excel')->export($list, array('title' => $type['title'] . '数据', 'columns' => $columns));
		exit();
	}

	public function temp()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

		if (empty($item)) {
			$this->message('虚拟物品模板不存在', referer(), 'error');
		}

		$item['fields'] = iunserializer($item['fields']);
		$columns = array();

		foreach ($item['fields'] as $key => $name) {
			$columns[] = array('title' => $name . '(' . $key . ')', 'field' => '', 'width' => 24);
		}

		$columns[] = array('title' => '状态:此列值为del时表示删除' . '(status)', 'field' => '', 'width' => 34);
		m('excel')->export(array(), array('title' => '数据模板', 'columns' => $columns));
	}

	public function import()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['typeid']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

		if (empty($item)) {
			$this->message('虚拟物品模板不存在', referer(), 'error');
		}

		$rows = m('excel')->import('excelfile');
		$item['fields'] = iunserializer($item['fields']);

		if (empty($rows)) {
			$this->message('导入数据为空', referer(), 'error');
		}

		$new_name = array();

		foreach ($rows[0] as $key => $value) {
			$new_name[$key] = $this->getNeedBetween($value, '(', ')');
		}

		$new_names = array_slice($new_name, 0, count($item['fields']));
		$new_names[count($new_names)] = $new_name[count($new_name) - 1];
		$newRow = array();

		foreach ($rows as $rk => $rv) {
			$rvs = array_slice($rv, 0, count($item['fields']));
			$rvs[count($rvs)] = $rv[count($rv) - 1];
			$newRow[$rk] = array_combine($new_names, $rvs);
		}

		unset($new_names[count($new_names) - 1]);
		$newkey = implode('.', $new_names);
		$authkey = implode('.', array_keys($item['fields']));

		if ($newkey != $authkey) {
			$this->message('键名key不对应', referer(), 'error');
		}

		unset($newRow[0]);

		foreach ($newRow as $rownum => $col) {
			$nkeys = array_keys($col);

			if (2 < count($nkeys)) {
				if ($col[$nkeys[1]] == '') {
					continue;
				}
			}

			$data = array(
				'typeid'  => $id,
				'pvalue'  => $col['key'],
				'fields'  => array(),
				'uniacid' => $_W['uniacid'],
				'merchid' => $_W['merchid'],
				'status'  => $col['status']
				);
			unset($col['status']);
			$data['fields'] = iserializer($col);
			$datas[] = $data;
		}

		$noinsert = '';
		$status = array();
		$null = '';

		foreach ($datas as $d) {
			if ($d['pvalue'] != '') {
				if (!empty($d['status']) && $d['status'] == 'del') {
					$olddata = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_data') . ' WHERE pvalue=:pvalue and typeid=:typeid and uniacid=:uniacid and merchid=' . $_W['merchid'], array(':pvalue' => $d['pvalue'], ':typeid' => $_GPC['typeid'], ':uniacid' => $_W['uniacid']));
					$d['createtime'] = TIMESTAMP;

					if (!empty($olddata)) {
						if (empty($olddata['openid'])) {
							pdo_delete('ewei_shop_virtual_data', array('id' => $olddata['id']));
							pdo_update('ewei_shop_virtual_type', 'alldata=alldata-1', array('id' => $item['id']));
						}
						else {
							$noinsert .= $d['pvalue'] . ',';
						}
					}
					else {
						$null .= 1;
					}

					$status[] = 1;
				}
				else {
					unset($d['status']);
					$olddata = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_data') . ' WHERE pvalue=:pvalue and typeid=:typeid and uniacid=:uniacid and merchid=' . $_W['merchid'], array(':pvalue' => $d['pvalue'], ':typeid' => $_GPC['typeid'], ':uniacid' => $_W['uniacid']));
					$d['createtime'] = TIMESTAMP;

					if (empty($olddata)) {
						pdo_insert('ewei_shop_virtual_data', $d);
						pdo_update('ewei_shop_virtual_type', 'alldata=alldata+1', array('id' => $item['id']));
					}
					else if (empty($olddata['openid'])) {
						pdo_update('ewei_shop_virtual_data', $d, array('id' => $olddata['id']));
					}
					else {
						$noinsert .= $d['pvalue'] . ',';
					}

					$status[] = 2;
				}
			}
		}

		if ($status[0] == 1) {
			com('virtual')->updateStock($id);

			if (!empty($noinsert)) {
				$tip = '<br>未删除成功的数据：主键=' . $noinsert . '<br>失败原因：已经使用无法删除';
				$this->message('部分数据删除成功！' . $tip, '', 'warning');
			}
			else {
				$this->message('删除成功！', merchUrl('goods/virtual/data', array('typeid' => $_GPC['typeid'])));
			}
		}
		else {
			if ($status[0] == 2) {
				com('virtual')->updateStock($id);

				if (!empty($noinsert)) {
					$tip = '<br>未保存成功的数据：主键=' . $noinsert . '<br>失败原因：已经使用无法更改';
					$this->message('部分数据保存成功！' . $tip, '', 'warning');
				}
				else {
					$this->message('导入成功！', merchUrl('goods/virtual/data', array('typeid' => $_GPC['typeid'])));
				}
			}
		}
	}

	public function tpl()
	{
		global $_W;
		global $_GPC;
		$kw = $_GPC['kw'];
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid and merchid=:merchid', array(':id' => $_GPC['typeid'], ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
		$item['fields'] = iunserializer($item['fields']);
		$num = $_GPC['numlist'];
		include $this->template('goods/virtual/data/tpl');
	}

	public function getNeedBetween($kw1, $mark1, $mark2)
	{
		$kw = $kw1;
		$kw = '123' . $kw . '123';
		$st = stripos($kw, $mark1);
		$ed = stripos($kw, $mark2);
		if ($st == false || $ed == false || $ed <= $st) {
			return 0;
		}

		$kw = substr($kw, $st + 1, $ed - $st - 1);
		return $kw;
	}
}

?>
