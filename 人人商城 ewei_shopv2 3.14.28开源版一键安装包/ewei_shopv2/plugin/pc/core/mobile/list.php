<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class ListController extends PluginMobilePage
{
	public function main()
	{
		global $_GPC;
		global $_W;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$serch = array();
		$args = array('pagesize' => $psize, 'page' => $pindex, 'cate' => trim($_GPC['cate']), 'by' => trim($_GPC['by']), 'minprice' => $_GPC['minprice'], 'maxprice' => $_GPC['maxprice']);
		$serch['show'] = 1;

		if (!empty($_GPC['sale'])) {
			$args['order'] = 'salesreal';
			$args['by'] = $_GPC['sale'];
			$serch['show'] = 0;
		}

		if (!empty($_GPC['pricesort'])) {
			$args['order'] = 'marketprice';
			$args['by'] = $_GPC['pricesort'];
			$serch['show'] = 0;
		}

		if (!empty($_GPC['keywords'])) {
			$args['keywords'] = $_GPC['keywords'];
			$serch['show'] = 0;
		}

		if (isset($_GPC['group_id'])) {
			$args['ispc'] = 1;
			$goodsGroup = pdo_get('ewei_shop_pc_goods', array('id' => $_GPC['group_id']));

			if ($goodsGroup['goods_type'] == 0) {
				$args['ids'] = $goodsGroup['goods_info'];
			}
			else if ($goodsGroup['goods_type'] == 1) {
				$args['cate'] = $goodsGroup['goods_info'];
			}
			else {
				if ($goodsGroup['goods_type'] == 2) {
					$list = pdo_get('ewei_shop_goods_group', array('id' => $goodsGroup['goods_info']));

					if ($list) {
						$args['ids'] = $list['goodsids'];
					}
				}
			}
		}

		$cateinfo = pdo_get('ewei_shop_category', array('id' => $_GPC['cate'], 'uniacid' => $_W['uniacid'], 'enabled' => 1));
		$shop = m('common')->getSysset('shop');
		$shoplevelcate = $shop['catlevel'];

		if ($cateinfo) {
			$category = $this->getallcate($cateinfo, $shoplevelcate);
		}
		else {
			$category['upcate'] = array();
			$category['downcate'] = pdo_getall('ewei_shop_category', array('level' => 1, 'uniacid' => $_W['uniacid'], 'enabled' => 1));
		}

		$serch['uniacid'] = $_W['uniacid'];
		$serch['action'] = MobileUrl('pc/list', array('cate' => $_GPC['cate']), true);
		$serch['gpc'] = $_GPC;

		if (!empty($_GPC['sale'])) {
			if ($_GPC['sale'] == 'desc') {
				$serch['sort'] = 'asc';
			}
			else {
				$serch['sort'] = 'desc';
			}
		}
		else {
			$serch['sort'] = 'desc';
		}

		if ($_GPC['pricesort'] == 'desc') {
			$serch['pricesort'] = 'asc';
		}
		else {
			$serch['pricesort'] = 'desc';
		}

		$data = $this->_condition($args);
		$maybe = $this->model->getGuessFavorGoods();

		if (!empty($maybe)) {
			foreach ($maybe as &$val) {
				$val['thumb'] = tomedia($val['thumb']);
			}

			unset($val);
		}

		$cateid = $_GPC['cate'];
		$GPC = $_GPC;
		$GPC['title'] = '商品列表';
		$_W['shopversion'] = 'v2';
		$pagers = pagination2($data['total'], $pindex, $psize);
		return $this->view('list', compact(array('data', 'category', 'maybe', 'cateid', 'serch', 'pagers', 'GPC')));
	}

	private function _condition($args)
	{
		global $_GPC;
		$goods = m('goods')->getList($args);
		return array('list' => $goods['list'], 'total' => $goods['total'], 'pagesize' => $args['pagesize']);
	}

	public function getallcate($info, $shoplevel)
	{
		global $_W;
		$cate = array();

		if ($shoplevel == 1) {
			$cate['upcate'][] = $info;
			$cate['downcate'] = pdo_getall('ewei_shop_category', array('level' => $shoplevel, 'uniacid' => $_W['uniacid'], 'enabled' => 1), array('id', 'name', 'parentid'));
		}

		if ($shoplevel == 2) {
			if ($info['level'] == 1) {
				$cate['upcate'][] = $info;
				$cate['downcate'] = pdo_getall('ewei_shop_category', array('parentid' => $info['id']), array('id', 'name', 'parentid'));
			}
			else if ($info['level'] == 2) {
				$cate['upcate'][] = pdo_get('ewei_shop_category', array('id' => $info['parentid']), array('id', 'name', 'parentid'));
				$cate['upcate'][] = $info;
				$cate['downcate'] = pdo_getall('ewei_shop_category', array('parentid' => $info['id'], 'enabled' => 1), array('id', 'name', 'parentid'));
			}
			else {
				$partent = pdo_get('ewei_shop_category', array('id' => $info['parentid']), array('id', 'name', 'parentid'));

				if (0 < $partent['parentid']) {
					$cate['upcate'][] = pdo_get('ewei_shop_category', array('id' => $partent['parentid']), array('id', 'name', 'parentid'));
				}

				$cate['upcate'][] = $partent;
				$cate['upcate'][] = $info;
				$cate['downcate'] = pdo_getall('ewei_shop_category', array('parentid' => $info['id'], 'uniacid' => $_W['uniacid'], 'enabled' => 1), array('id', 'name', 'parentid'));
			}
		}

		if ($shoplevel == 3) {
			if ($info['level'] == 1) {
				$cate['upcate'][] = $info;
				$cate['downcate'] = pdo_getall('ewei_shop_category', array('parentid' => $info['id']), array('id', 'name', 'parentid'));
			}
			else if ($info['level'] == 2) {
				$cate['upcate'][] = pdo_get('ewei_shop_category', array('id' => $info['parentid']), array('id', 'name', 'parentid'));
				$cate['upcate'][] = $info;
				$cate['downcate'] = pdo_getall('ewei_shop_category', array('parentid' => $info['id'], 'enabled' => 1), array('id', 'name', 'parentid'));
			}
			else {
				$partent = pdo_get('ewei_shop_category', array('id' => $info['parentid']), array('id', 'name', 'parentid'));

				if (0 < $partent['parentid']) {
					$cate['upcate'][] = pdo_get('ewei_shop_category', array('id' => $partent['parentid']), array('id', 'name', 'parentid'));
				}

				$cate['upcate'][] = $partent;
				$cate['upcate'][] = $info;
				$cate['downcate'] = pdo_getall('ewei_shop_category', array('parentid' => $info['id'], 'uniacid' => $_W['uniacid'], 'enabled' => 1), array('id', 'name', 'parentid'));
			}
		}

		return $cate;
	}

	public function Groups()
	{
		global $_W;
		global $_GPC;
		$data['title'] = '拼团商品';
		$info = $this->model->invoke('groups.list::main');

		if ($info['error'] == 0) {
			$data['list'] = $info['list'];
			$data['pagesize'] = $info['pagesize'];
			$data['total'] = $info['total'];
			$data['pindex'] = $info['pindex'];
			$_W['shopversion'] = 'v2';
			$data['pagers'] = pagination2($data['total'], $data['pindex'], $data['pagesize']);
		}
		else {
			$data['list'] = $info['list'];
			$data['pagesize'] = $info['pagesize'];
			$data['total'] = $info['total'];
			$data['pindex'] = 0;
			$data['pagers'] = '';
		}

		if (!empty($data['list'])) {
			foreach ($data['list'] as &$val) {
				$val['url'] = m('qrcode')->createQrcode(mobileUrl('groups/goods', array('id' => $val['id']), true));
			}
		}

		return $this->view('list.groups', compact(array('data')));
	}

	public function seckill()
	{
		global $_W;
		global $_GPC;
		$data['title'] = '秒杀列表';
		$info = $this->model->invoke('seckill.index::get_list');
		$data['info'] = $info;

		if (intval(empty($_GPC['taskid']))) {
			$_GPC['taskid'] = $info['taskid'];
		}

		if (intval(empty($_GPC['roomid']))) {
			$_GPC['roomid'] = $info['roomid'];
		}

		if (intval(empty($_GPC['timeid']))) {
			$_GPC['timeid'] = $info['timeid'];
		}

		$data['info']['timeid'] = $_GPC['timeid'];
		$data['info']['roomid'] = $_GPC['roomid'];
		$goods = $this->model->invoke('seckill.index::get_goods');

		if ($goods['error'] == 0) {
			$data['goods'] = $goods['goods'];
		}

		if (!empty($info['times'])) {
			foreach ($info['times'] as $val) {
				if ($val['status'] == 0) {
					$data['endtime'] = $val['endtime'];
				}
			}
		}

		return $this->view('list.seckill', compact('data'));
	}

	public function bargain()
	{
		global $_W;
		global $_GPC;
		$data['title'] = '砍价列表';
		$info = $this->model->invoke('bargain.index::get_list');

		if ($info['error'] == 0) {
			$data['list'] = $info['list'];
			$data['pagesize'] = $info['pagesize'];
			$data['total'] = $info['total'];
			$data['pindex'] = $info['pindex'];
			$_W['shopversion'] = 'v2';
			$data['pagers'] = pagination2($data['total'], $data['pindex'], $data['pagesize']);
		}
		else {
			$data['list'] = $info['list'];
			$data['pagesize'] = $info['pagesize'];
			$data['total'] = $info['total'];
			$data['pindex'] = 0;
			$data['pagers'] = '';
		}

		if (!empty($data['list'])) {
			foreach ($data['list'] as &$val) {
				$val['url'] = m('qrcode')->createQrcode(mobileUrl('bargain/detail', array('id' => $val['id']), true));
			}
		}

		return $this->view('list.bargain', compact(array('data')));
	}
}

?>
