<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Page_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' uniacid=:uniacid ';
		$params = array(':uniacid' => $_W['uniacid']);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$condition .= ' AND name LIKE :keyword ';
			$params[':keyword'] = '%' . $keyword . '%';
		}

		if ($_GPC['type'] != '') {
			$type = intval($_GPC['type']);
			$condition .= ' AND type=:type ';
			$params[':type'] = $type;
		}

		$limit = ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$list = pdo_fetchall('SELECT id, `name`, `type`, createtime, lasttime, status, isdefault FROM ' . tablename('ewei_shop_wxapp_page') . ' WHERE ' . $condition . ' ORDER BY isdefault DESC, id DESC' . $limit, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_wxapp_page') . ' WHERE ' . $condition, $params);
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
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			$page = $this->model->getPage($id);
		}

		if (empty($page)) {
			$page['type'] = intval($_GPC['type']);
		}

		if ($_W['ispost']) {
			$isdefault = intval($_GPC['isdefault']);
			$data = $_GPC['data'];
			$count = count($data);

			if ($count <= 1) {
				show_json(0, '页面数据不能为空');
			}

			if (!empty($data)) {
				foreach ($data['items'] as $k => $v) {
					if ($v['id'] == 'detail_comment') {
						unset($data['items'][$k]);
					}
				}
			}

			if (empty($data)) {
				show_json(0, '数据错误');
			}

			$json = json_encode($data);
			$json = $this->model->saveImg($json);
			$arr = array('name' => trim($data['page']['name']), 'type' => intval($data['page']['type']), 'data' => base64_encode($json), 'lasttime' => time());
			$arr['status'] = 1;

			if (!empty($isdefault)) {
				$arr['isdefault'] = 1;
				if ($data['page']['type'] == 2 || $data['page']['type'] == 20) {
					pdo_update('ewei_shop_wxapp_page', array('isdefault' => 0), array(
						'uniacid' => $_W['uniacid'],
						'type'    => array('in', '2', '20')
					));
				}
				else {
					pdo_update('ewei_shop_wxapp_page', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'type' => $data['page']['type']));
				}
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_wxapp_page', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
			}
			else {
				$arr['uniacid'] = $_W['uniacid'];
				$arr['createtime'] = time();
				pdo_insert('ewei_shop_wxapp_page', $arr);
				$id = pdo_insertid();
			}

			show_json(1, array('id' => $id, 'type' => $page['type']));
		}

		$diyadvs = pdo_fetchall('select id, `name` from ' . tablename('ewei_shop_wxapp_startadv') . ' where status=1 and uniacid=:uniacid  order by id desc', array(':uniacid' => $_W['uniacid']));
		$json = json_encode(array('attachurl' => $_W['attachurl'], 'id' => $id, 'type' => empty($page) ? 2 : $page['type'], 'data' => empty($page) ? NULL : $page['data'], 'diyadvs' => $diyadvs));
		$auth = $this->model->getAuth();
		$is_auth = !is_error($auth) && is_array($auth) ? $auth['is_auth'] : false;

		if ($is_auth) {
			$release = $this->model->getRelease($auth['id']);
		}

		include $this->template();
	}

	/**
     * 单个/批量设置状态
     */
	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$status = intval($_GPC['status']);
		$list = pdo_fetchall('SELECT id, `name`, isdefault FROM ' . tablename('ewei_shop_wxapp_page') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($list)) {
			foreach ($list as $row) {
				if (!empty($row['isdefault'])) {
					continue;
				}

				pdo_update('ewei_shop_wxapp_page', array('status' => $status), array('id' => $row['id'], 'uniacid' => $_W['uniacid']));
				plog('app.page.edit', '修改页面状态 ID: ' . $row['id'] . ' 页面名称: ' . $row['name'] . ' 页面状态: ' . $status == 1 ? '启用' : '禁用');
			}
		}

		show_json(1);
	}

	/**
     * 单个/批量删除
     */
	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$list = pdo_fetchall('SELECT id, `name`, isdefault FROM ' . tablename('ewei_shop_wxapp_page') . (' WHERE id in( ' . $id . ' ) AND uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']));

		if (!empty($list)) {
			foreach ($list as $row) {
				if (!empty($row['isdefault'])) {
					continue;
				}

				pdo_delete('ewei_shop_wxapp_page', array('id' => $row['id'], 'uniacid' => $_W['uniacid']));
				plog('app.page.delete', '删除页面 ID: ' . $row['id'] . ' 页面名称: ' . $row['name'] . ' ');
			}
		}

		show_json(1, array('url' => referer()));
	}

	/**
     * 设为默认首页
     */
	public function setdefault()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = intval($_GPC['type']);

		if (empty($id)) {
			show_json(0, '参数错误');
		}

		$item = pdo_fetch('SELECT id, `name`, `status`, isdefault FROM ' . tablename('ewei_shop_wxapp_page') . ' WHERE id=:id AND uniacid=:uniacid LIMIT 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($item)) {
			show_json(0, '页面不存在');
		}

		if (empty($item['status'])) {
			show_json(0, '页面未启用');
		}

		if (!empty($item['isdefault'])) {
			show_json(1);
		}

		if ($type == 2 || $type == 20) {
			pdo_update('ewei_shop_wxapp_page', array('isdefault' => 0), array(
				'uniacid' => $_W['uniacid'],
				'type'    => array('in', '2', '20')
			));
		}
		else {
			pdo_update('ewei_shop_wxapp_page', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'type' => $type));
		}

		pdo_update('ewei_shop_wxapp_page', array('isdefault' => 1), array('id' => $id, 'uniacid' => $_W['uniacid']));

		if ($type == 3) {
			$name = '会员中心';
		}
		else if ($type == 4) {
			$name = '商品详情';
		}
		else {
			$name = '首页';
		}

		plog('app.page.edit', '设为默认' . $name . (' ID: ' . $item['id'] . ' 页面名称: ' . $item['name'] . ' '));
		show_json(1);
	}

	public function cancel_default()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			show_json(0, '参数错误');
		}

		pdo_update('ewei_shop_wxapp_page', array('isdefault' => 0), array('id' => $id, 'uniacid' => $_W['uniacid']));
		show_json(1);
	}

	public function goods_query()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and status=1 and deleted=0 and uniacid=:uniacid';

		if (!empty($kwd)) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $kwd . '%';
		}

		$condition .= ' AND `type` != 10 AND `type` != 20 AND `type` !=4 ';
		$ds = pdo_fetchall('SELECT id,title,thumb,marketprice,productprice,share_title,share_icon,description,minprice,costprice,total,sales,islive,liveprice FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);
		$ds = set_medias($ds, array('thumb', 'share_icon'));
		include $this->template('goods/query');
	}

	public function selecticon2()
	{
		$list = array('', '首页', '全部分类', '商品列表', '购物车', '个人中心', '促销', '发现', '精选', '优选好货', '关注', '良品', '热卖', '新品', '人气', '砍价', '快速购买', '秒杀', '拼团', '发现2', '分类', '分销', '购物车2', '砍价2', '快速购买', '秒杀2', '拼团2', '首页2', '我的', '消息', '优惠券', '折扣', '折扣');
		unset($list[0]);
		include $this->template('app/page/tpl/_icon');
	}

	public function selecticon3()
	{
		$csspath = __DIR__ . '/../../static/fonts/iconfont.css';
		$list = array();
		$content = file_get_contents($csspath);

		if (!empty($content)) {
			preg_match_all('/.(.*?):before/', $content, $matchs);
			$list = $matchs[1];
		}

		include $this->template('app/page/tpl/_icon3');
	}
}

?>
