<?php
class IndexController extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$info = pdo_get('ewei_shop_pc_template', array('uniacid' => $_W['uniacid']));

		if (!$info) {
			$data = array();
			$data['title'] = '官方默认';
			$data['uniacid'] = $_W['uniacid'];
			$data['status'] = 1;
			pdo_insert('ewei_shop_pc_template', $data);
		}

		include $this->template('pc/default');
	}

	public function typeSetting()
	{
		global $_W;
		global $_GPC;
		session_start();
		$defaults = array(
			'seckill' => array('text' => '秒杀栏', 'visible' => 1),
			'select'  => array('text' => '为您优选', 'visible' => 1),
			'goods'   => array('text' => '商品组', 'visible' => 1)
		);

		if ($_W['ispost']) {
			$datas = json_decode(html_entity_decode($_GPC['datas']), true);

			if (!is_array($datas)) {
				show_json(0, '数据出错');
			}

			$indexsort = array();

			foreach ($datas as $key => $v) {
				$indexsort[$v['id']] = array('text' => $defaults[$v['id']]['text'], 'visible' => intval($_GPC['visible'][$v['id']]), 'order' => intval($key), 'block' => $v['id'], 'display' => $_GPC['visible'][$v['id']] == 1 ? true : false);
			}

			$indexsort = json_encode($indexsort);
			pdo_update('ewei_shop_pc_template', array('setting' => $indexsort), array('uniacid' => $_W['uniacid']));
			show_json(1);
		}

		$tempinfo = pdo_get('ewei_shop_pc_template', array('uniacid' => $_W['uniacid']), 'setting');

		if (!empty($tempinfo['setting'])) {
			$tempinfo = json_decode($tempinfo['setting'], true);
		}
		else {
			$tempinfo = $defaults;
		}

		$oldsorts = $tempinfo;
		$sorts = array();

		foreach ($oldsorts as $key => $old) {
			$sorts[$key] = $old;
			if ($key == 'notice' && !isset($oldsorts['seckill'])) {
				$sorts['seckill'] = array('text' => '秒杀栏', 'visible' => 0);
			}
		}

		unset($sorts['search']);
		unset($sorts['nav']);
		unset($sorts['adv']);
		unset($sorts['bottom_nav']);
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

		$items = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_pc_template') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		if (empty($items)) {
			$items = array();
		}

		foreach ($items as $item) {
			pdo_delete('ewei_shop_pc_template', array('id' => $item['id']));
		}

		show_json(1, array('url' => referer()));
	}

	public function action()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (!empty($id)) {
			pdo_update('ewei_shop_pc_template', array('status' => 0), array('uniacid' => $_W['uniacid']));
			pdo_update('ewei_shop_pc_template', array('status' => 1), array('uniacid' => $_W['uniacid'], 'id' => $id));
			show_json(1, array('url' => referer()));
		}
	}
}

?>
