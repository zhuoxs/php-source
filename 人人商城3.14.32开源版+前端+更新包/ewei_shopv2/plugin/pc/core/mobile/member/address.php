<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_login_mobile.php";
class Address_EweiShopV2Page extends PcMobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		global $_S;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and openid=:openid and deleted=0 and  `uniacid` = :uniacid  ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_address') . ' where 1 ' . $condition;
		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_member_address') . ' where 1 ' . $condition . ' ORDER BY `isdefault` DESC,`id` DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '收货地址') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '收货地址', 'menu_url' => mobileUrl('pc.member.address')) );
		include $this->template();
	}
	public function setdefault() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = pdo_fetch('select id from ' . tablename('ewei_shop_member_address') . ' where id=:id and deleted=0 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		if (empty($data)) 
		{
			show_json(0, '地址未找到');
		}
		pdo_update("ewei_shop_member_address", array("isdefault" => 0), array("uniacid" => $_W['uniacid'], 'openid' => $_W['openid']));
		pdo_update("ewei_shop_member_address", array("isdefault" => 1), array("id" => $id, 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		show_json(1);
	}
	public function delete() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = pdo_fetch('select id,isdefault from ' . tablename('ewei_shop_member_address') . ' where  id=:id and openid=:openid and deleted=0 and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':id' => $id));
		if (empty($data)) 
		{
			show_json(0, '地址未找到');
		}
		pdo_update("ewei_shop_member_address", array("deleted" => 1), array("id" => $id));
		if ($data['isdefault'] == 1) 
		{
			pdo_update('ewei_shop_member_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'id' => $id));
			$data2 = pdo_fetch('select id from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and uniacid=:uniacid order by id desc limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			if (!(empty($data2))) 
			{
				pdo_update('ewei_shop_member_address', array('isdefault' => 1), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'id' => $data2['id']));
				show_json(1, array("defaultid" => $data2['id']));
			}
		}
		show_json(1);
	}
	public function post() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$address = pdo_fetch('select * from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		$nav_link_list = array( array('link' => SHOP_SITE_URL, 'title' => '首页'), array('link' => SHOP_SITE_URL . '&act=member&op=home', 'title' => '我的商城'), array('title' => '我的收藏') );
		if (!(empty($address))) 
		{
			$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '收货地址', 'menu_url' => mobileUrl('pc.member.address')), array('menu_key' => 'post', 'menu_name' => '编辑地址', 'menu_url' => mobileUrl('pc.member.address.post', array('mk' => 'post', 'id' => $id))) );
		}
		else 
		{
			$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '收货地址', 'menu_url' => mobileUrl('pc.member.address')), array('menu_key' => 'post', 'menu_name' => '新增地址', 'menu_url' => mobileUrl('pc.member.address.post', array('mk' => 'post'))) );
		}
		include $this->template();
	}
	public function submit() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = $_GPC['addressdata'];
		$data['mobile'] = trim($data['mobile']);
		$areas = explode(' ', $data['areas']);
		$data['province'] = $areas[0];
		$data['city'] = $areas[1];
		$data['area'] = $areas[2];
		unset($data['areas']);
		$data['openid'] = $_W['openid'];
		$data['uniacid'] = $_W['uniacid'];
		if (empty($id)) 
		{
			$addresscount = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and `uniacid` = :uniacid ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			if ($addresscount <= 0) 
			{
				$data['isdefault'] = 1;
			}
			pdo_insert("ewei_shop_member_address", $data);
			$id = pdo_insertid();
		}
		else 
		{
			pdo_update("ewei_shop_member_address", $data, array('id' => $id, 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		}
		show_json(1, array("addressid" => $id));
	}
	public function selector() 
	{
		global $_W;
		global $_GPC;
		$condition = ' and openid=:openid and deleted=0 and  `uniacid` = :uniacid  ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_member_address') . ' where 1 ' . $condition . ' ORDER BY isdefault desc, id DESC ';
		$list = pdo_fetchall($sql, $params);
		include $this->template();
		exit();
	}
}
?>