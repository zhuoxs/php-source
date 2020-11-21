<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class OrderController extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		p('pc')->checkLogin();
		$data['title'] = '订单列表';

		if (!isset($_GPC['status'])) {
			$_GPC['status'] = 6;
		}

		$list = p('pc')->invoke('order.index::get_list');
		$count = p('pc')->getOrderCount();
		$data['count'] = $count;
		$data['status'] = $_GPC['status'];

		if ($list['error'] == 0) {
			$data['list'] = $list['list'];

			if (!empty($data['list'])) {
				foreach ($data['list'] as $key => &$value) {
					foreach ($value['goods'] as $val) {
						$value['goods'] = $val['goods'];
					}
				}
			}

			$data['pagesize'] = $list['pagesize'];
			$data['total'] = $list['total'];
			$data['page'] = $list['page'];
			$_W['shopversion'] = 'v2';
			$data['pagers'] = pagination2($data['total'], $data['page'], $data['pagesize']);
		}
		else {
			$data['list'] = array();
			$data['total'] = 0;
			$data['pagers'] = '';
		}

		return $this->view('order', $data);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$info = p('pc')->invoke('order.op::delete');

		if ($info['error'] == 0) {
			return json_encode(array('status' => 1));
		}

		return json_encode(array('status' => 0, 'message' => $info['message']));
	}
}

?>
