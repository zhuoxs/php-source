<?php
class MenuController extends PluginWebPage
{
	const TOP_MENU = 0;
	const BOTTOM_MENU = 1;

	/**
     * @var PcModel
     */
	public $model;

	public function main()
	{
		include $this->template();
	}

	/**
     * 顶部导航列表页
     * @author: Vencenty
     * @time: 2019/5/23 15:55
     */
	public function top()
	{
		global $_GPC;
		global $_W;
		$ret = $this->getList(static::TOP_MENU);
		extract($ret);
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	/**
     * 编辑方法
     * @author: Vencenty
     * @time: 2019/5/23 16:56
     */
	public function post()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$isEdit = !empty($id);
		$map = array('top' => '顶部', 'bottom' => '底部');
		$r = parse_url(referer());
		$r = explode('&', $r['query']);
		$r = explode('.', $r[count($r) - 1]);
		$lastElement = end($r);
		$desc = $map[$lastElement];

		if ($isEdit) {
			$item = pdo_get('ewei_shop_pc_menu', array('id' => $id));
		}

		if ($_W['ispost']) {
			$data = array('displayorder' => (int) $_GPC['displayorder'], 'title' => (string) $_GPC['title'], 'link' => (string) $_GPC['link'], 'status' => (int) $_GPC['status'], 'type' => (int) $_GPC['type'], 'create_time' => time(), 'uniacid' => $_W['uniacid']);

			if ($isEdit) {
				$execResult = pdo_update('ewei_shop_pc_menu', $data, array('id' => $id));
			}
			else {
				$execResult = pdo_insert('ewei_shop_pc_menu', $data);
			}

			$url = (int) $_GPC['type'] === 0 ? 'pc.menu.top' : 'pc.menu.bottom';

			if ($execResult) {
				show_json(1, array('url' => webUrl($url)));
			}
			else {
				show_json(0, '操作失败');
			}
		}

		include $this->template();
	}

	/**
     * 底部导航列表页
     * @author: Vencenty
     * @time: 2019/5/23 15:55
     */
	public function bottom()
	{
		global $_GPC;
		global $_W;
		$ret = $this->getList(static::BOTTOM_MENU);
		extract($ret);
		include $this->template();
	}

	/**
     * 改变导航启用状态
     * @author: Vencenty
     * @time: 2019/5/23 16:23
     */
	public function switchChange()
	{
		global $_W;
		global $_GPC;
		$status = $_GPC['status'];
		$id = $_GPC['id'];
		pdo_update('ewei_shop_pc_menu', array('status' => $status), array('id' => $id));
		show_json(1);
	}

	/**
     * 删除
     * @author: Vencenty
     * @time: 2019/6/12 10:31
     */
	public function delete()
	{
		global $_GPC;
		$ids = $_GPC['ids'];
		$id = $_GPC['id'];

		if (empty($id)) {
			$ids = implode(',', $ids);
		}
		else {
			$ids = $id;
		}

		$r = pdo_query('delete from ' . tablename('ewei_shop_pc_menu') . (' where id in (' . $ids . ')'));

		if ($r) {
			show_json(1);
		}

		show_json(0, '删除失败');
	}

	public function getList($type)
	{
		global $_GPC;
		global $_W;
		$searchCondition = '';
		if (isset($_GPC['status']) && $_GPC['status'] != '') {
			$searchCondition .= ' and status = ' . $_GPC['status'];
		}

		if (isset($_GPC['keyword'])) {
			$searchCondition .= ' and title like \'%' . $_GPC['keyword'] . '%\'';
		}

		$pindex = isset($_GPC['page']) ? max(1, intval($_GPC['page'])) : 1;
		$psize = 20;
		$condition = ' and type = ' . $type . ' and uniacid = ' . $_W['uniacid'];
		$list = pdo_fetchall('select *  from ' . tablename('ewei_shop_pc_menu') . (' where 1 ' . $condition . ' ' . $searchCondition . ' order by create_time desc '));
		$total = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_pc_menu') . (' where 1 ' . $condition . ' ' . $searchCondition));
		$pager = pagination2($total, $pindex, $psize);
		return compact('pager', 'list');
	}
}

?>
