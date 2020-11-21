<?php
defined('IN_IA') or exit('Access Denied');
//幻灯片管理控制器

class Helperslide_WeliamController {

	public function lists() {
		global $_W, $_GPC;

		$uniacid = $_W['uniacid'];
		$psize = 25;
		$pindex = max(1, $_GPC['page']);
		$listData = Util::getNumData("*", PDO_NAME . 'helper_slide', array('uniacid' => $uniacid), 'sort desc', $pindex, $psize);

		$list = $listData[0];
		$pager = $listData[1];

		include  wl_template('helper/slidelist');
	}

	public function add() {
		global $_W, $_GPC;

		$id = $_GPC['id'];

		if ($id) {
			$data = Util::getSingelData("*", PDO_NAME . 'helper_slide', array('id' => $id));
		}

		if ($_GPC['data']) {
			$temp = $_GPC['data'];
			$temp['uniacid'] = $_W['uniacid'];
			if ($temp['id']) {
				pdo_update(PDO_NAME . 'helper_slide', $temp, array('id' => $temp['id']));
			} else {
				pdo_insert(PDO_NAME . 'helper_slide', $temp);
			}
			wl_message('操作成功', web_url('helper/helperslide/lists'), 'success');
		}
		include  wl_template('helper/slideadd');

	}

	public function del() {
		global $_GPC,$_W;

		pdo_delete(PDO_NAME . 'helper_slide', array('id' => $_GPC['id']));
		wl_message('操作成功', web_url('helper/helperslide/lists'), 'success');
	}

}
?>