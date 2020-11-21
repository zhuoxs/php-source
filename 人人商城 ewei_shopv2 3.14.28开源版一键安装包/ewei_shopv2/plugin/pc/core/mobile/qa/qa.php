<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_mobile.php";
class Qa_EweiShopV2Page extends PcMobilePage 
{
	public function __construct() 
	{
		parent::__construct();
	}
	public function main() 
	{
		global $_W;
		global $_GPC;
		$cate = intval($_GPC['cate']);
		$keyword = trim($_GPC['keyword']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' q.uniacid=:uniacid and c.uniacid=:uniacid and q.status=1 and c.enabled=1 ';
		if (!(empty($cate))) 
		{
			$condition .= ' and q.cate=' . $cate . ' ';
		}
		if (!(empty($keyword))) 
		{
			$condition .= ' AND (q.title like \'%' . $keyword . '%\') or (q.keywords like \'%' . $keyword . '%\') ';
		}
		$params = array(':uniacid' => $_W['uniacid']);
		$sql = 'SELECT q.*, c.name as catename FROM ' . tablename('ewei_shop_qa_question') . ' q left join' . tablename('ewei_shop_qa_category') . ' c on c.id=q.cate where  1 and ' . $condition . ' ORDER BY q.displayorder DESC,q.id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_qa_question') . ' q left join' . tablename('ewei_shop_qa_category') . ' c on c.id=q.cate where  1 and ' . $condition . ' ', $params);
		if (!(empty($total))) 
		{
			foreach ($list as &$item ) 
			{
				$item['content'] = iunserializer($item['content']);
				$item['content'] = htmlspecialchars_decode($item['content']);
			}
			unset($item);
		}
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '帮助中心') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '帮助中心', 'menu_url' => mobileUrl('pc.qa.qa')) );
		$pager = fenye($total, $pindex, $psize);
		include $this->template();
	}
	public function detail() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		if (!(empty($id))) 
		{
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_qa_question') . ' where id=:id and status=1 and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			if (empty($item)) 
			{
				$this->message('问题不存在!');
			}
			$item['content'] = iunserializer($item['content']);
			$item['content'] = htmlspecialchars_decode($item['content']);
		}
		$next = pdo_fetch('SELECT id,title,createtime FROM ' . tablename('ewei_shop_qa_question') . ' WHERE uniacid=' . $_W['uniacid'] . ' AND status=1 AND id>' . $id);
		$pre = pdo_fetch('SELECT id,title,createtime FROM ' . tablename('ewei_shop_qa_question') . ' WHERE uniacid=' . $_W['uniacid'] . ' AND status=1 AND id<' . $id);
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '帮助中心') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '帮助中心', 'menu_url' => mobileUrl('pc.qa.qa')), array('menu_key' => 'detail', 'menu_name' => '帮助详情', 'menu_url' => mobileUrl('pc.qa.qa.detail', array('id' => $id, 'mk' => 'detail'))) );
		include $this->template();
	}
}
?>