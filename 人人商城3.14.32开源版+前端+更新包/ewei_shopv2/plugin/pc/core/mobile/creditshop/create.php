<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_login_mobile.php";
class Create_EweiShopV2Page extends PcMobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$optionid = intval($_GPC['optionid']);
		$shop = m('common')->getSysset('shop');
		$member = m('member')->getMember($openid);
		$goods = $this->model->getGoods($id, $member, $optionid);
		if (empty($goods)) 
		{
			$this->message('商品已下架或被删除!', mobileUrl('creditshop'), 'error');
		}
		$pay = m('common')->getSysset('pay');
		$set = m('common')->getPluginset('creditshop');
		$goods['followed'] = m('user')->followed($openid);
		if ($goods['goodstype'] == 0) 
		{
			$stores = array();
			if (!(empty($goods['isverify']))) 
			{
				$storeids = array();
				if (!(empty($goods['storeids']))) 
				{
					$storeids = array_merge(explode(',', $goods['storeids']), $storeids);
				}
				if (empty($storeids)) 
				{
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid']));
				}
				else 
				{
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid']));
				}
			}
		}
		$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid));
		include $this->template();
	}
	public function dispatch() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$goodsid = intval($_GPC['goodsid']);
		$addressid = intval($_GPC['addressid']);
		$optionid = intval($_GPC['optionid']);
		$member = m('member')->getMember($openid);
		$goods = $this->model->getGoods($goodsid, $member, $optionid);
		$dispatch = 0;
		$dispatch_array = array();
		if ($goods['dispatchtype'] == 0) 
		{
			$dispatch = $goods['dispatch'];
		}
		else 
		{
			$merchid = $goods['merchid'];
			if (empty($goods['dispatchid'])) 
			{
				$dispatch_data = m('dispatch')->getDefaultDispatch($merchid);
			}
			else 
			{
				$dispatch_data = m('dispatch')->getOneDispatch($goods['dispatchid']);
			}
			if (empty($dispatch_data)) 
			{
				$dispatch_data = m('dispatch')->getNewDispatch($merchid);
			}
			if (!(empty($dispatch_data))) 
			{
				$dkey = $dispatch_data['id'];
				if (!(empty($user_city))) 
				{
					$citys = m('dispatch')->getAllNoDispatchAreas($dispatch_data['nodispatchareas']);
					if (!(empty($citys))) 
					{
						if (in_array($user_city, $citys) && !(empty($citys))) 
						{
							$isnodispatch = 1;
							$has_goodsid = 0;
							if (!(empty($nodispatch_array['goodid']))) 
							{
								if (in_array($goods['goodsid'], $nodispatch_array['goodid'])) 
								{
									$has_goodsid = 1;
								}
							}
							if ($has_goodsid == 0) 
							{
								$nodispatch_array['goodid'][] = $goods['id'];
								$nodispatch_array['title'][] = $goods['title'];
								$nodispatch_array['city'] = $user_city;
							}
						}
					}
				}
				if (($goods['isverify'] == 0) && ($goods['goodstype'] == 0)) 
				{
					$areas = unserialize($dispatch_data['areas']);
					if ($dispatch_data['calculatetype'] == 1) 
					{
						$param = 1;
					}
					else 
					{
						$param = $goods['weight'] * 1;
					}
					if (array_key_exists($dkey, $dispatch_array)) 
					{
						$dispatch_array[$dkey]['param'] += $param;
					}
					else 
					{
						$dispatch_array[$dkey]['data'] = $dispatch_data;
						$dispatch_array[$dkey]['param'] = $param;
					}
				}
			}
			$dispatch_merch = array();
			if (!(empty($dispatch_array))) 
			{
				foreach ($dispatch_array as $k => $v ) 
				{
					$dispatch_data = $dispatch_array[$k]['data'];
					$param = $dispatch_array[$k]['param'];
					$areas = unserialize($dispatch_data['areas']);
					if (!(empty($address))) 
					{
						$dprice = m('dispatch')->getCityDispatchPrice($areas, $address['city'], $param, $dispatch_data);
					}
					else if (!(empty($member['city']))) 
					{
						$dprice = m('dispatch')->getCityDispatchPrice($areas, $member['city'], $param, $dispatch_data);
					}
					else 
					{
						$dprice = m('dispatch')->getDispatchPrice($param, $dispatch_data);
					}
					$dispatch = $dprice;
				}
			}
		}
		show_json(1, array("dispatch" => $dispatch));
	}
}
?>