<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_mobile.php";
class Notice_EweiShopV2Page extends PcMobilePage 
{
	public function __construct() 
	{
		parent::__construct();
	}
	public function main() 
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and `uniacid` = :uniacid and status=1';
		$params = array(':uniacid' => $_W['uniacid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_notice') . ' where 1 ' . $condition;
		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_notice') . ' where 1 ' . $condition . ' ORDER BY displayorder desc,createtime DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		foreach ($list as $key => &$row ) 
		{
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
		}
		unset($row);
		$list = set_medias($list, 'thumb');
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '公告列表') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '公告列表', 'menu_url' => mobileUrl('pc.shop.notice')) );
		$pager = fenye($total, $pindex, $psize);
		include $this->template();
	}
	public function detail() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$notice = pdo_fetch('select * from ' . tablename('ewei_shop_notice') . ' where id=:id and uniacid=:uniacid and status=1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$next = pdo_fetch('SELECT id,title,createtime FROM ' . tablename('ewei_shop_notice') . ' WHERE uniacid=' . $_W['uniacid'] . ' AND status=1 AND id>' . $id);
		$pre = pdo_fetch('SELECT id,title,createtime FROM ' . tablename('ewei_shop_notice') . ' WHERE uniacid=' . $_W['uniacid'] . ' AND status=1 AND id<' . $id);
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '公告详情') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '公告列表', 'menu_url' => mobileUrl('pc.shop.notice')), array('menu_key' => 'detail', 'menu_name' => '公告详情', 'menu_url' => mobileUrl('pc.shop.notice.detail', array('id' => $id, 'mk' => 'detail'))) );
		include $this->template();
	}
}
?>