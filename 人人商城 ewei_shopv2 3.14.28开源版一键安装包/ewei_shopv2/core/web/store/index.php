<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends ComWebPage
{
	public function __construct($_com = 'verify')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$paras = array(':uniacid' => $_W['uniacid']);
		$condition = ' uniacid = :uniacid';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND (storename LIKE \'%' . $_GPC['keyword'] . '%\' OR address LIKE \'%' . $_GPC['keyword'] . '%\' OR tel LIKE \'%' . $_GPC['keyword'] . '%\')';
		}

		if (!empty($_GPC['type'])) {
			$type = intval($_GPC['type']);
			$condition .= ' AND type = :type';
			$paras[':type'] = $type;
		}

		$sql = 'SELECT * FROM ' . tablename('ewei_shop_store') . (' WHERE ' . $condition . ' ORDER BY displayorder desc,id desc');
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$sql_count = 'SELECT count(1) FROM ' . tablename('ewei_shop_store') . (' WHERE ' . $condition);
		$total = pdo_fetchcolumn($sql_count, $paras);
		$pager = pagination2($total, $pindex, $psize);
		$list = pdo_fetchall($sql, $paras);

		foreach ($list as &$row) {
			$row['salercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_saler') . ' where storeid=:storeid limit 1', array(':storeid' => $row['id']));
		}

		unset($row);
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
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$address_street = intval($area_set['address_street']);

		if ($_W['ispost']) {
			if (!empty($_GPC['perms'])) {
				$perms = implode(',', $_GPC['perms']);
			}
			else {
				$perms = '';
			}

			if (empty($_GPC['logo'])) {
				show_json(0, '门店LOGO不能为空');
			}

			if (empty($_GPC['map']['lng']) || empty($_GPC['map']['lat'])) {
				show_json(0, '门店位置不能为空');
			}

			if (empty($_GPC['address'])) {
				show_json(0, '门店地址不能为空');
			}
			else {
				if (30 < mb_strlen($_GPC['address'], 'UTF-8')) {
					show_json(0, '门店地址不能超过30个字符');
				}
			}

			$label = '';

			if (!empty($_GPC['lab'])) {
				if (8 < count($_GPC['lab'])) {
					show_json(0, '标签不能超过8个');
				}

				foreach ($_GPC['lab'] as $lab) {
					if (20 < mb_strlen($lab, 'UTF-8')) {
						show_json(0, '标签长度不能超过20个字符');
					}

					if (strlen(trim($lab)) <= 0) {
						show_json(0, '标签不能为空');
					}
				}

				$label = implode(',', $_GPC['lab']);
			}

			$tag = '';

			if (!empty($_GPC['tag'])) {
				if (3 < count($_GPC['tag'])) {
					show_json(0, '角标不能超过3个');
				}

				foreach ($_GPC['tag'] as $tg) {
					if (3 < mb_strlen($tg, 'UTF-8')) {
						show_json(0, '角标长度不能超过3个字符');
					}

					if (strlen(trim($tg)) <= 0) {
						show_json(0, '角标不能为空');
					}
				}

				$tag = implode(',', $_GPC['tag']);
			}

			$cates = '';

			if (!empty($_GPC['cates'])) {
				if (3 < count($_GPC['cates'])) {
					show_json(0, '门店分类不能超过3个');
				}

				$cates = implode(',', $_GPC['cates']);
			}

			if (empty($_GPC['tel']) || strlen(trim($_GPC['tel'])) <= 0) {
				show_json(0, '门店电话不能为空');
			}
			else {
				if (20 < strlen($_GPC['tel'])) {
					show_json(0, '门店电话不能大于20个字符');
				}
			}

			if (!empty($_GPC['saletime'])) {
				if (20 < strlen($_GPC['saletime'])) {
					show_json(0, '营业时间不能大于20个字符');
				}
			}

			$data = array('uniacid' => $_W['uniacid'], 'storename' => trim($_GPC['storename']), 'address' => trim($_GPC['address']), 'province' => trim($_GPC['province']), 'city' => trim($_GPC['city']), 'area' => trim($_GPC['area']), 'provincecode' => trim($_GPC['chose_province_code']), 'citycode' => trim($_GPC['chose_city_code']), 'areacode' => trim($_GPC['chose_area_code']), 'tel' => trim($_GPC['tel']), 'lng' => $_GPC['map']['lng'], 'lat' => $_GPC['map']['lat'], 'type' => intval($_GPC['type']), 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']), 'label' => $label, 'tag' => $tag, 'fetchtime' => trim($_GPC['fetchtime']), 'saletime' => trim($_GPC['saletime']), 'logo' => save_media($_GPC['logo']), 'desc' => trim($_GPC['desc']), 'opensend' => intval($_GPC['opensend']), 'status' => intval($_GPC['status']), 'cates' => $cates, 'perms' => $perms);

			if (P('newstore')) {
				$data['storegroupid'] = intval($_GPC['storegroupid']);
			}

			$data['order_printer'] = is_array($_GPC['order_printer']) ? implode(',', $_GPC['order_printer']) : '';
			$data['order_template'] = intval($_GPC['order_template']);
			$data['ordertype'] = is_array($_GPC['ordertype']) ? implode(',', $_GPC['ordertype']) : '';

			if (!empty($id)) {
				pdo_update('ewei_shop_store', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				plog('shop.verify.store.edit', '编辑门店 ID: ' . $id);
			}
			else {
				pdo_insert('ewei_shop_store', $data);
				$id = pdo_insertid();
				plog('shop.verify.store.add', '添加门店 ID: ' . $id);
			}

			show_json(1, array('url' => webUrl('store')));
		}

		if (p('newstore')) {
			$storegroup = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_newstore_storegroup') . ' WHERE  uniacid=:uniacid  ', array(':uniacid' => $_W['uniacid']));
			$category = pdo_fetchall('SELECT *FROM ' . tablename('ewei_shop_newstore_category') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_store') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		$perms = explode(',', $item['perms']);

		if ($printer = com('printer')) {
			$item = $printer->getStorePrinterSet($item);
			$order_printer_array = $item['order_printer'];
			$ordertype = $item['ordertype'];
			$order_template = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_printer_template') . ' WHERE uniacid=:uniacid AND merchid=0', array(':uniacid' => $_W['uniacid']));
		}

		$label = explode(',', $item['label']);
		$tag = explode(',', $item['tag']);
		$cates = explode(',', $item['cates']);
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

		$items = pdo_fetchall('SELECT id,storename FROM ' . tablename('ewei_shop_store') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_store', array('id' => $item['id']));
			plog('shop.verify.store.delete', '删除门店 ID: ' . $item['id'] . ' 门店名称: ' . $item['storename'] . ' ');
		}

		show_json(1, array('url' => referer()));
	}

	public function displayorder()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,storename FROM ' . tablename('ewei_shop_store') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (!empty($item)) {
			pdo_update('ewei_shop_store', array('displayorder' => $displayorder), array('id' => $id));
			plog('shop.verify.store.edit', '修改门店排序 ID: ' . $item['id'] . ' 门店名称: ' . $item['storename'] . ' 排序: ' . $displayorder . ' ');
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

		$items = pdo_fetchall('SELECT id,storename FROM ' . tablename('ewei_shop_store') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_store', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('shop.verify.store.edit', '修改门店状态<br/>ID: ' . $item['id'] . '<br/>门店名称: ' . $item['storename'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '启用' : '禁用');
		}

		show_json(1, array('url' => referer()));
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$limittype = empty($_GPC['limittype']) ? 0 : intval($_GPC['limittype']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid  and status=1 ';

		if ($limittype == 0) {
			$condition .= '  and type in (1,2,3) ';
		}

		if (!empty($kwd)) {
			$condition .= ' AND `storename` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,storename FROM ' . tablename('ewei_shop_store') . (' WHERE 1 ' . $condition . ' order by id asc'), $params);

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template('shop/verify/store/query');
		exit();
	}

	public function querygoods()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and uniacid=:uniacid and deleted = 0 and `type` in (1,5,30)  and merchid =0';

		if (!empty($kwd)) {
			$condition .= ' AND `title` LIKE :keyword';
			$params[':keyword'] = '%' . $kwd . '%';
		}

		$ds = pdo_fetchall('SELECT id,title,thumb FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		$ds = set_medias($ds, array('thumb', 'share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}
}

?>
