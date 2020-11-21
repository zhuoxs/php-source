<?php
defined('IN_IA') or exit('Access Denied');
//问题管理控制器

class Helperquestion_WeliamController {

	public function lists() {
		global $_W, $_GPC;

		$uniacid = $_W['uniacid'];
		$psize = 25;
		$pindex = max(1, $_GPC['page']);
		$listData = Util::getNumData("*", PDO_NAME . 'helper_question', array('uniacid' => $uniacid), 'sort desc', $pindex, $psize);

		$category = Util::getNumData("*", PDO_NAME . 'helper_type', array('uniacid' => $_W['uniacid']));
		$category = $category[0];

		$list = $listData[0];
		$pager = $listData[1];

		include  wl_template('helper/questionlist');
	}

	public function add() {
		global $_W, $_GPC;

		$category = Util::getNumData("*", PDO_NAME . 'helper_type', array('uniacid' => $_W['uniacid']));
		$category = $category[0];
		$id = $_GPC['id'];
		if ($id) {
			$data = Util::getSingelData("*", PDO_NAME . 'helper_question', array('id' => $id));
		}

		if ($_GPC['data']) {
			$temp = $_GPC['data'];
			$cate = $_GPC['category'];
			$temp['type'] = $cate;
			$temp['uniacid'] = $_W['uniacid'];
			$temp['content'] = htmlspecialchars_decode($temp['content']);
			if ($temp['id']) {
				pdo_update(PDO_NAME . 'helper_question', $temp, array('id' => $temp['id']));
			} else {
				pdo_insert(PDO_NAME . 'helper_question', $temp);
			}
			wl_message('操作成功', web_url('helper/helperquestion/lists'), 'success');
		}
		include  wl_template('helper/questionadd');
	}

	public function del() {
		global $_W, $_GPC;

		$id = $_GPC['id'];
		$ids = $_GPC['ids'];

		if($id){
			pdo_delete(PDO_NAME.'helper_question',array('id'=>$id));
			wl_message('操作成功',web_url('helper/helperquestion/lists'),'success');
		}

		if ($ids) {
			foreach ($ids as $key => $id) {
				pdo_delete(PDO_NAME . 'helper_question', array('id' => $id));
			}
			die(json_encode(array('errno'=>0,'message'=>'','id'=>'')));
		}

	}

}
?>