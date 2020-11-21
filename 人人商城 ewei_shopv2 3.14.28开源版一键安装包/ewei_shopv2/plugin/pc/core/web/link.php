<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
class Link_EweiShopV2Page extends PluginWebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		if ($_GPC['status'] != '') 
		{
			$condition .= ' and status=' . intval($_GPC['status']);
		}
		if (!(empty($_GPC['keyword']))) 
		{
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and linkname  like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}
		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_pc_link') . ' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC limit ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_pc_link') . ' WHERE 1 ' . $condition, $params);
		$pager = pagination($total, $pindex, $psize);
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
		if ($_W['ispost']) 
		{
			$data = array('uniacid' => $_W['uniacid'], 'linkname' => trim($_GPC['linkname']), 'url' => trim($_GPC['url']), 'status' => intval($_GPC['status']), 'displayorder' => intval($_GPC['displayorder']));
			if (!(empty($id))) 
			{
				pdo_update('ewei_shop_pc_link', $data, array('id' => $id));
				plog("pc.linkedit", '修改友情链接 ID: ' . $id);
			}
			else 
			{
				pdo_insert("ewei_shop_pc_link", $data);
				$id = pdo_insertid();
				plog("pc.linkadd", '添加友情链接 ID: ' . $id);
			}
			show_json(1, array("url" => webUrl("shop/nav")));
		}
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_pc_link') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		include $this->template();
	}
	public function delete() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		if (empty($id)) 
		{
			$id = ((is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0));
		}
		$items = pdo_fetchall('SELECT id,linkname FROM ' . tablename('ewei_shop_pc_link') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);
		foreach ($items as $item ) 
		{
			pdo_delete('ewei_shop_pc_link', array('id' => $item['id']));
			plog("pc.linkdelete", '删除友情链接 ID: ' . $item['id'] . ' 标题: ' . $item['linkname'] . ' ');
		}
		show_json(1, array("url" => referer()));
	}
	public function displayorder() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$displayorder = intval($_GPC['value']);
		$item = pdo_fetchall('SELECT id,linkname FROM ' . tablename('ewei_shop_pc_link') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);
		if (!(empty($item))) 
		{
			pdo_update('ewei_shop_pc_link', array('displayorder' => $displayorder), array('id' => $id));
			plog("pc.linkedit", '修改友情链接排序 ID: ' . $item['id'] . ' 标题: ' . $item['linkname'] . ' 排序: ' . $displayorder . ' ');
		}
		show_json(1);
	}
	public function status() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		if (empty($id)) 
		{
			$id = ((is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0));
		}
		$items = pdo_fetchall('SELECT id,linkname FROM ' . tablename('ewei_shop_pc_link') . ' WHERE id in( ' . $id . ' ) AND uniacid=' . $_W['uniacid']);
		foreach ($items as $item ) 
		{
			pdo_update('ewei_shop_pc_link', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog("pc.linkedit", (('修改友情链接状态<br/>ID: ' . $item['id'] . '<br/>标题: ' . $item['linkname'] . '<br/>状态: ' . $_GPC['status']) == 1 ? '显示' : '隐藏'));
		}
		show_json(1, array("url" => referer()));
	}
}
?>