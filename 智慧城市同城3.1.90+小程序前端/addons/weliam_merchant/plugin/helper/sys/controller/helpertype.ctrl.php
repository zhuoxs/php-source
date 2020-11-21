<?php
defined('IN_IA') or exit('Access Denied');

class Helpertype_WeliamController {
	/**
	 * 查询列表，以分页显示
	 */
	public function lists() {
		global $_W, $_GPC;
		$uniacid = $_W['uniacid'];
		$psize = 25;
		$pindex = max(1, $_GPC['page']);
		$listData = Util::getNumData('*', PDO_NAME . 'helper_type', array('uniacid' => $uniacid), 'sort desc', $pindex, $psize);

		$list = $listData[0];
		$pager = $listData[1];

		include   wl_template('helper/typelist');
	}

	public function add() {
		global $_W, $_GPC;

		$id = $_GPC['id'];

		if ($id) {
			$data = Util::getSingelData("*", PDO_NAME . 'helper_type', array('id' => $id));
		}

		if ($_GPC['data']) {
			$temp = $_GPC['data'];
			$temp['uniacid'] = $_W['uniacid'];
			if ($temp['id']) {
				pdo_update(PDO_NAME . 'helper_type', $temp, array('id' => $temp['id']));
			} else {
				pdo_insert(PDO_NAME . 'helper_type', $temp);
			}
			wl_message('操作成功', web_url('helper/helpertype/lists'), 'success');
		}
		include   wl_template('helper/typeadd');
	}

	public function del() {
		global $_GPC;

		pdo_delete(PDO_NAME . 'helper_type', array('id' => $_GPC['id']));
		wl_message('操作成功',web_url('helper/helpertype/lists'),'success');
	}

}
?>