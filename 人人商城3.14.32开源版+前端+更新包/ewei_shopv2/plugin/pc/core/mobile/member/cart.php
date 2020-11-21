<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_login_mobile.php";
class Cart_EweiShopV2Page extends PcMobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$condition = ' and f.uniacid= :uniacid and f.openid=:openid and f.deleted=0';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);
		$list = array();
		$total = 0;
		$totalprice = 0;
		$ischeckall = true;
		$level = m('member')->getLevel($openid);
		$sql = 'SELECT f.id,f.total,f.goodsid,g.total as stock, o.stock as optionstock, g.maxbuy,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,' . ' g.productprice,o.title as optiontitle,f.optionid,o.specs,g.minbuy,g.maxbuy,g.unit,f.merchid,g.checked,g.isdiscount_discounts,g.isdiscount,g.isdiscount_time,g.isnodiscount,g.discounts,g.merchsale' . ' ,f.selected FROM ' . tablename('ewei_shop_member_cart') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on f.optionid = o.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC ';
		$list = pdo_fetchall($sql, $params);
		foreach ($list as &$g ) 
		{
			$g['thumb'] = tomedia($g['thumb']);
			$seckillinfo = plugin_run('seckill::getSeckill', $g['goodsid'], $g['optionid'], true, $_W['openid']);
			if (!(empty($g['optionid']))) 
			{
				$g['stock'] = $g['optionstock'];
				if (!(empty($g['specs']))) 
				{
					$thumb = m('goods')->getSpecThumb($g['specs']);
					if (!(empty($thumb))) 
					{
						$g['thumb'] = tomedia($thumb);
					}
				}
			}
			if ($g['selected']) 
			{
				$prices = m('order')->getGoodsDiscountPrice($g, $level, 1);
				$total += $g['total'];
				$g['marketprice'] = $g['ggprice'] = $prices['price'];
				if ($seckillinfo && ($seckillinfo['status'] == 0)) 
				{
					$seckilllast = 0;
					if (0 < $seckillinfo['maxbuy']) 
					{
						$seckilllast = $seckillinfo['maxbuy'] - $seckillinfo['selfcount'];
					}
					$normal = $g['total'] - $seckilllast;
					if ($normal <= 0) 
					{
						$normal = 0;
					}
					$totalprice += ($seckillinfo['price'] * $seckilllast) + ($g['marketprice'] * $normal);
					$g['seckillmaxbuy'] = $seckillinfo['maxbuy'];
					$g['seckillselfcount'] = $seckillinfo['selfcount'];
					$g['seckillprice'] = $seckillinfo['price'];
					$g['seckilltag'] = $seckillinfo['tag'];
					$g['seckilllast'] = $seckilllast;
				}
				else 
				{
					$totalprice += $g['marketprice'] * $g['total'];
				}
			}
			$totalmaxbuy = $g['stock'];
			if ($seckillinfo && ($seckillinfo['status'] == 0)) 
			{
				if ($g['seckilllast'] < $totalmaxbuy) 
				{
					$totalmaxbuy = $g['seckilllast'];
				}
				if ($totalmaxbuy < $g['total']) 
				{
					$g['total'] = $totalmaxbuy;
				}
				$g['minbuy'] = 0;
			}
			else 
			{
				if (0 < $g['maxbuy']) 
				{
					if ($totalmaxbuy != -1) 
					{
						if ($g['maxbuy'] < $totalmaxbuy) 
						{
							$totalmaxbuy = $g['maxbuy'];
						}
					}
					else 
					{
						$totalmaxbuy = $g['maxbuy'];
					}
				}
				if (0 < $g['usermaxbuy']) 
				{
					$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));
					$last = $g['usermaxbuy'] - $order_goodscount;
					if ($last <= 0) 
					{
						$last = 0;
					}
					if ($totalmaxbuy != -1) 
					{
						if ($last < $totalmaxbuy) 
						{
							$totalmaxbuy = $last;
						}
					}
					else 
					{
						$totalmaxbuy = $last;
					}
				}
				if (0 < $g['minbuy']) 
				{
					if ($totalmaxbuy < $g['minbuy']) 
					{
						$g['minbuy'] = $totalmaxbuy;
					}
				}
			}
			$g['totalmaxbuy'] = $totalmaxbuy;
			$g['unit'] = ((empty($data['unit']) ? '件' : $data['unit']));
			if (empty($g['selected'])) 
			{
				$ischeckall = false;
			}
		}
		unset($g);
		$list = set_medias($list, 'thumb');
		$merch_user = array();
		$merch = array();
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) 
		{
			$getListUser = $merch_plugin->getListUser($list);
			$merch_user = $getListUser['merch_user'];
			$merch = $getListUser['merch'];
		}
		if (empty($list)) 
		{
			$list = array();
		}
		$args = array('page' => $_GPC['page'], 'pagesize' => 6, 'isrecommand' => 1, 'order' => 'displayorder desc,createtime desc', 'by' => '');
		$recommand = m('goods')->getList($args);
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '我的购物车') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '我的购物车', 'menu_url' => mobileUrl('pc.member.cart')) );
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		include $this->template();
	}
	public function select() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$select = intval($_GPC['select']);
		if (!(empty($id))) 
		{
			$data = pdo_fetch('select id,goodsid,optionid, total from ' . tablename('ewei_shop_member_cart') . ' ' . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
			if (!(empty($data))) 
			{
				pdo_update('ewei_shop_member_cart', array('selected' => $select), array('id' => $id, 'uniacid' => $_W['uniacid']));
			}
		}
		else 
		{
			pdo_update("ewei_shop_member_cart", array("selected" => $select), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		}
		show_json(1);
	}
	public function update() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$goodstotal = intval($_GPC['total']);
		$optionid = intval($_GPC['optionid']);
		empty($goodstotal) && ($goodstotal = 1);
		$data = pdo_fetch('select id,goodsid,optionid, total from ' . tablename('ewei_shop_member_cart') . ' ' . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		if (empty($data)) 
		{
			show_json(0, '无购物车记录');
		}
		$goods = pdo_fetch('select id,maxbuy,minbuy,total,unit from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid and status=1 and deleted=0', array(':id' => $data['goodsid'], ':uniacid' => $_W['uniacid']));
		if (empty($goods)) 
		{
			show_json(0, '商品未找到');
		}
		pdo_update("ewei_shop_member_cart", array("total" => $goodstotal, 'optionid' => $optionid), array('id' => $id, 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		show_json(1);
	}
	public function add() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$total = intval($_GPC['total']);
		($total <= 0) && ($total = 1);
		$optionid = intval($_GPC['optionid']);
		$goods = pdo_fetch('select id,marketprice,diyformid,diyformtype,diyfields, isverify, type,merchid from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (empty($goods)) 
		{
			show_json(0, '商品未找到');
		}
		$member = m('member')->getMember($_W['openid']);
		if (!(empty($_W['shopset']['wap']['open'])) && !(empty($_W['shopset']['wap']['mustbind'])) && empty($member['mobileverify'])) 
		{
			show_json(0, array('message' => '请先绑定手机', 'url' => mobileUrl('member/bind', NULL, true)));
		}
		if (($goods['isverify'] == 2) || ($goods['type'] == 2) || ($goods['type'] == 3)) 
		{
			show_json(0, '此商品不可加入购物车<br>请直接点击立刻购买');
		}
		$diyform_plugin = p('diyform');
		$diyformid = 0;
		$diyformfields = iserializer(array());
		$diyformdata = iserializer(array());
		if ($diyform_plugin) 
		{
			$diyformdata = $_GPC['diyformdata'];
			if (!(empty($diyformdata)) && is_array($diyformdata)) 
			{
				$diyformfields = false;
				if ($goods['diyformtype'] == 1) 
				{
					$diyformid = intval($goods['diyformid']);
					$formInfo = $diyform_plugin->getDiyformInfo($diyformid);
					if (!(empty($formInfo))) 
					{
						$diyformfields = $formInfo['fields'];
					}
				}
				else if ($goods['diyformtype'] == 2) 
				{
					$diyformfields = iunserializer($goods['diyfields']);
				}
				if (!(empty($diyformfields))) 
				{
					$insert_data = $diyform_plugin->getInsertData($diyformfields, $diyformdata);
					$diyformdata = $insert_data['data'];
					$diyformfields = iserializer($diyformfields);
				}
			}
		}
		$data = pdo_fetch('select id,total,diyformid from ' . tablename('ewei_shop_member_cart') . ' where goodsid=:id and openid=:openid and   optionid=:optionid  and deleted=0 and  uniacid=:uniacid   limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':optionid' => $optionid, ':id' => $id));
		if (empty($data)) 
		{
			$data = array('uniacid' => $_W['uniacid'], 'merchid' => $goods['merchid'], 'openid' => $_W['openid'], 'goodsid' => $id, 'optionid' => $optionid, 'marketprice' => $goods['marketprice'], 'total' => $total, 'selected' => 1, 'diyformid' => $diyformid, 'diyformdata' => $diyformdata, 'diyformfields' => $diyformfields, 'createtime' => time());
			pdo_insert("ewei_shop_member_cart", $data);
		}
		else 
		{
			$data['diyformid'] = $diyformid;
			$data['diyformdata'] = $diyformdata;
			$data['diyformfields'] = $diyformfields;
			$data['total'] += $total;
			pdo_update("ewei_shop_member_cart", $data, array('id' => $data['id']));
		}
		$cartcount = pdo_fetchcolumn('select sum(total) from ' . tablename('ewei_shop_member_cart') . ' where openid=:openid and deleted=0 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		show_json(1, array("isnew" => false, "cartcount" => $cartcount));
	}
	public function remove() 
	{
		global $_W;
		global $_GPC;
		$ids = $_GPC['ids'];
		if (empty($ids) || !(is_array($ids))) 
		{
			show_json(0, '参数错误');
		}
		$sql = 'update ' . tablename('ewei_shop_member_cart') . ' set deleted=1 where uniacid=:uniacid and openid=:openid and id in (' . implode(',', $ids) . ')';
		pdo_query($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));
		show_json(1);
	}
	public function tofavorite() 
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$ids = $_GPC['ids'];
		if (empty($ids) || !(is_array($ids))) 
		{
			show_json(0, '参数错误');
		}
		foreach ($ids as $id ) 
		{
			$goodsid = pdo_fetchcolumn('select goodsid from ' . tablename('ewei_shop_member_cart') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1 ', array(':id' => $id, ':uniacid' => $uniacid, ':openid' => $openid));
			if (!(empty($goodsid))) 
			{
				$fav = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_favorite') . ' where goodsid=:goodsid and uniacid=:uniacid and openid=:openid and deleted=0 limit 1 ', array(':goodsid' => $goodsid, ':uniacid' => $uniacid, ':openid' => $openid));
				if ($fav <= 0) 
				{
					$fav = array('uniacid' => $uniacid, 'goodsid' => $goodsid, 'openid' => $openid, 'deleted' => 0, 'createtime' => time());
					pdo_insert("ewei_shop_member_favorite", $fav);
				}
			}
		}
		$sql = 'update ' . tablename('ewei_shop_member_cart') . ' set deleted=1 where uniacid=:uniacid and openid=:openid and id in (' . implode(',', $ids) . ')';
		pdo_query($sql, array(':uniacid' => $uniacid, ':openid' => $openid));
		show_json(1);
	}
}
?>