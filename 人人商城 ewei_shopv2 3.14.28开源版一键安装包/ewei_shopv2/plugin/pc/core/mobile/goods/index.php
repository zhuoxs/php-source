<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_mobile.php";
class Index_EweiShopV2Page extends PcMobilePage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$allcategory = m('shop')->getCategory();
		$catlevel = intval($_W['shopset']['category']['level']);
		$opencategory = true;
		$plugin_commission = p('commission');
		if ($plugin_commission && (0 < intval($_W['shopset']['commission']['level']))) 
		{
			$mid = intval($_GPC['mid']);
			if (!(empty($mid))) 
			{
				$shop = p('commission')->getShop($mid);
				if (empty($shop['selectcategory'])) 
				{
					$opencategory = false;
				}
			}
		}
		$hlist = $this->get_history();
		$keywords = ((!(empty($_GPC['keywords'])) ? $_GPC['keywords'] : ''));
		$args = array('pagesize' => 12, 'page' => intval($_GPC['page']), 'isnew' => trim($_GPC['isnew']), 'ishot' => trim($_GPC['ishot']), 'isrecommand' => trim($_GPC['isrecommand']), 'isdiscount' => trim($_GPC['isdiscount']), 'istime' => trim($_GPC['istime']), 'issendfree' => trim($_GPC['issendfree']), 'keywords' => trim($_GPC['keywords']), 'cate' => trim($_GPC['cate']), 'order' => trim($_GPC['order']), 'by' => trim($_GPC['by']), 'priceMin' => trim($_GPC['priceMin']), 'priceMax' => trim($_GPC['priceMax']));
		$plugin_commission = p('commission');
		if ($plugin_commission && (0 < intval($_W['shopset']['commission']['level']))) 
		{
			$mid = intval($_GPC['mid']);
			if (!(empty($mid))) 
			{
				$shop = p('commission')->getShop($mid);
				if (!(empty($shop['selectgoods']))) 
				{
					$args['ids'] = $shop['goodsids'];
				}
			}
		}
		$goods = $this->getList($args);
		$glist = $goods['list'];
		$pindex = max(1, intval($_GPC['page']));
		$pager = fenye($goods['total'], $pindex, $args['pagesize']);
		include $this->template();
	}
	public function get_history() 
	{
		global $_W;
		global $_GPC;
		$psize = 8;
		if (empty($_W['openid'])) 
		{
			$condition = ' and f.uniacid = :uniacid and f.deleted=0';
			$params = array(':uniacid' => $_W['uniacid']);
		}
		else 
		{
			$condition = ' and f.uniacid = :uniacid and f.openid=:openid and f.deleted=0';
			$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		}
		$sql = 'SELECT f.id,f.goodsid,g.title,g.thumb,g.marketprice,g.productprice,f.createtime,g.merchid FROM ' . tablename('ewei_shop_member_history') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' where 1 ' . $condition . ' ORDER BY f.`id` DESC LIMIT ' . $psize;
		$list = pdo_fetchall($sql, $params);
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if (!(empty($list)) && $merch_plugin && $merch_data['is_openmerch']) 
		{
			$merch_user = $merch_plugin->getListUser($list, 'merch_user');
		}
		foreach ($list as &$row ) 
		{
			$row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
			$row['thumb'] = tomedia($row['thumb']);
			$row['merchname'] = (($merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name']));
		}
		unset($row);
		return $list;
	}
	public function get_list() 
	{
	}
	public function query() 
	{
		global $_GPC;
		global $_W;
		$args = array('pagesize' => 10, 'page' => intval($_GPC['page']), 'isnew' => trim($_GPC['isnew']), 'ishot' => trim($_GPC['ishot']), 'isrecommand' => trim($_GPC['isrecommand']), 'isdiscount' => trim($_GPC['isdiscount']), 'istime' => trim($_GPC['istime']), 'keywords' => trim($_GPC['keywords']), 'cate' => trim($_GPC['cate']), 'order' => trim($_GPC['order']), 'by' => trim($_GPC['by']));
		$this->_condition($args);
	}
	private function _condition($args) 
	{
		global $_GPC;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) 
		{
			$args['merchid'] = intval($_GPC['merchid']);
		}
		if (isset($_GPC['nocommission'])) 
		{
			$args['nocommission'] = intval($_GPC['nocommission']);
		}
		$goods = m('goods')->getList($args);
		show_json(1, array("list" => $goods['list'], 'total' => $goods['total'], 'pagesize' => $args['pagesize']));
	}
	private function getList($args = array()) 
	{
		global $_W;
		$openid = $_W['openid'];
		$page = ((!(empty($args['page'])) ? intval($args['page']) : 1));
		$pagesize = ((!(empty($args['pagesize'])) ? intval($args['pagesize']) : 10));
		$random = ((!(empty($args['random'])) ? $args['random'] : false));
		$order = ((!(empty($args['order'])) ? $args['order'] : ' displayorder desc,createtime desc'));
		$orderby = ((empty($args['order']) ? '' : ((!(empty($args['by'])) ? $args['by'] : ''))));
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) 
		{
			$is_openmerch = 1;
		}
		else 
		{
			$is_openmerch = 0;
		}
		$condition = ' and `uniacid` = :uniacid AND `deleted` = 0 and status=1';
		$params = array(':uniacid' => $_W['uniacid']);
		$merchid = ((!(empty($args['merchid'])) ? trim($args['merchid']) : ''));
		if (!(empty($merchid))) 
		{
			$condition .= ' and merchid=:merchid and checked=0';
			$params[':merchid'] = $merchid;
		}
		else if ($is_openmerch == 0) 
		{
			$condition .= ' and `merchid` = 0';
		}
		else 
		{
			$condition .= ' and `checked` = 0';
		}
		$priceMin = ((!(empty($args['priceMin'])) ? trim($args['priceMin']) : ''));
		$priceMax = ((!(empty($args['priceMax'])) ? trim($args['priceMax']) : ''));
		if (!(empty($priceMin))) 
		{
			$condition .= ' and minprice > \'' . $priceMin . '\'';
		}
		if (!(empty($priceMax))) 
		{
			$condition .= ' and maxprice < \'' . $priceMax . '\'';
		}
		if (empty($args['type'])) 
		{
			$condition .= ' and type !=10 ';
		}
		$ids = ((!(empty($args['ids'])) ? trim($args['ids']) : ''));
		if (!(empty($ids))) 
		{
			$condition .= ' and id in ( ' . $ids . ')';
		}
		$isnew = ((!(empty($args['isnew'])) ? 1 : 0));
		if (!(empty($isnew))) 
		{
			$condition .= ' and isnew=1';
		}
		$ishot = ((!(empty($args['ishot'])) ? 1 : 0));
		if (!(empty($ishot))) 
		{
			$condition .= ' and ishot=1';
		}
		$isrecommand = ((!(empty($args['isrecommand'])) ? 1 : 0));
		if (!(empty($isrecommand))) 
		{
			$condition .= ' and isrecommand=1';
		}
		$isdiscount = ((!(empty($args['isdiscount'])) ? 1 : 0));
		if (!(empty($isdiscount))) 
		{
			$condition .= ' and isdiscount=1';
		}
		$issendfree = ((!(empty($args['issendfree'])) ? 1 : 0));
		if (!(empty($issendfree))) 
		{
			$condition .= ' and issendfree=1';
		}
		$istime = ((!(empty($args['istime'])) ? 1 : 0));
		if (!(empty($istime))) 
		{
			$condition .= ' and istime=1 ';
		}
		if (isset($args['nocommission'])) 
		{
			$condition .= ' AND `nocommission`=' . intval($args['nocommission']);
		}
		$keywords = ((!(empty($args['keywords'])) ? $args['keywords'] : ''));
		if (!(empty($keywords))) 
		{
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . trim($keywords) . '%';
		}
		if (!(empty($args['cate']))) 
		{
			$category = m('shop')->getAllCategory();
			$catearr = array($args['cate']);
			foreach ($category as $index => $row ) 
			{
				if ($row['parentid'] == $args['cate']) 
				{
					$catearr[] = $row['id'];
					foreach ($category as $ind => $ro ) 
					{
						if ($ro['parentid'] == $row['id']) 
						{
							$catearr[] = $ro['id'];
						}
					}
				}
			}
			$catearr = array_unique($catearr);
			$condition .= ' AND ( ';
			foreach ($catearr as $key => $value ) 
			{
				if ($key == 0) 
				{
					$condition .= 'FIND_IN_SET(' . $value . ',cates)';
				}
				else 
				{
					$condition .= ' || FIND_IN_SET(' . $value . ',cates)';
				}
			}
			$condition .= ' <>0 )';
		}
		$member = m('member')->getMember($openid);
		if (!(empty($member))) 
		{
			$levelid = intval($member['level']);
			$groupid = intval($member['groupid']);
			$condition .= ' and ( ifnull(showlevels,\'\')=\'\' or FIND_IN_SET( ' . $levelid . ',showlevels)<>0 ) ';
			$condition .= ' and ( ifnull(showgroups,\'\')=\'\' or FIND_IN_SET( ' . $groupid . ',showgroups)<>0 ) ';
		}
		else 
		{
			$condition .= ' and ifnull(showlevels,\'\')=\'\' ';
			$condition .= ' and ifnull(showgroups,\'\')=\'\' ';
		}
		$total = '';
		if (!($random)) 
		{
			$sql = 'SELECT id,title,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,total,description,bargain FROM ' . tablename('ewei_shop_goods') . ' where 1 ' . $condition . ' ORDER BY ' . $order . ' ' . $orderby . ' LIMIT ' . (($page - 1) * $pagesize) . ',' . $pagesize;
			$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where 1 ' . $condition . ' ', $params);
		}
		else 
		{
			$sql = 'SELECT id,title,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,total,description,bargain FROM ' . tablename('ewei_shop_goods') . ' where 1 ' . $condition . ' ORDER BY rand() LIMIT ' . $pagesize;
			$total = $pagesize;
		}
		$list = pdo_fetchall($sql, $params);
		$list = set_medias($list, 'thumb');
		return array("list" => $list, 'total' => $total);
	}
}
?>