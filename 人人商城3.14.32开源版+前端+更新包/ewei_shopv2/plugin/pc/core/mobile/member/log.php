<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_login_mobile.php";
class Log_EweiShopV2Page extends PcMobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$_GPC['type'] = intval($_GPC['type']);
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '充值记录') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '充值记录', 'menu_url' => mobileUrl('pc.member.history')) );
		$all_list = $this->get_list();
		$list = $all_list['list'];
		$pindex = max(1, intval($_GPC['page']));
		$pager = fenye($all_list['total'], $pindex, $all_list['psize']);
		include $this->template();
	}
	public function get_list() 
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and openid=:openid and uniacid=:uniacid and type=:type';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':type' => intval($_GPC['type']));
		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_member_log') . ' where 1 ' . $condition . ' order by createtime desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_log') . ' where 1 ' . $condition, $params);
		foreach ($list as &$row ) 
		{
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
		}
		unset($row);
		return array("list" => $list, 'total' => $total, 'psize' => $psize);
	}
}
?>