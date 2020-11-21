<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class StoreTable extends We7Table {

	
	public function searchGoodsList($type = '', $pageindex, $pagesize) {
		$this->query->from('site_store_goods');
		if (!empty($type)) {
			$this->query->where('type', $type);
		}
		$goods_list = array(
			'goods_list' => $this->searchWithPage($pageindex, $pagesize)->query->where('status !=', STORE_GOODS_STATUS_DELETE)->getall('id'),
			'total' => $this->getLastQueryTotal()
		);
		return $goods_list;
	}

	
	public function searchAccountBuyGoods($uniacid, $type) {
		$type_name = array(
			STORE_TYPE_MODULE => 'module',
			STORE_TYPE_WXAPP_MODULE => 'module',
			STORE_TYPE_PACKAGE => 'module_group',
			STORE_TYPE_API => '(g.api_num * r.duration) as number',
		);
		if ($type == STORE_TYPE_API) {
			$number_list = $this->query->from('site_store_goods', 'g')->leftjoin('site_store_order', 'r')->on(array('g.id' => 'r.goodsid'))->where('r.uniacid', $uniacid)->where('g.type', $type)->where('r.type', STORE_ORDER_FINISH)->select($type_name[$type])->getall('number');
			return array_sum(array_keys($number_list));
		} else{
			$this->query->from('site_store_goods', 'g')->leftjoin('site_store_order', 'r')->on(array('g.id' => 'r.goodsid'))->where('r.uniacid', $uniacid)->where('g.type', $type)->where('r.type', STORE_ORDER_FINISH)->where('r.type <>', STORE_ORDER_DEACTIVATE);
			return  $this->query->getall($type_name[$type]);
		}
	}

	public function searchWithEndtime() {
		$this->query->where('r.endtime >=', time());
		return $this;
	}

	public function searchWithKeyword($title) {
		if (!empty($title)) {
			$this->query->where('title LIKE', "%{$title}%");
			return $this;
		}
	}


	public function searchWithStatus($status) {
		$status = intval($status) > 0 ? 1 : 0;
		$this->query->where('status', $status);
		return $this;
	}

	public function searchWithLetter($letter) {
		if (!empty($letter)) {
			$this->query->where('title_initial LIKE', "%{$letter}%");
			return $this;
		}
	}

	public function searchWithOrderid($orderid) {
		if (!empty($orderid)) {
			$this->query->where('orderid', $orderid);
			return $this;
		}
		return true;
	}

	public function goodsInfo($id) {
		$id = intval($id);
		$this->query->from('site_store_goods')->where('id', $id);
		return $this->query->get();
	}

	public function searchOrderList($pageindex = 0, $pagesize = 0) {
		$this->query->from('site_store_order')->where('type <>', STORE_GOODS_STATUS_DELETE);

		if (!empty($pageindex) && !empty($pagesize)) {
			$this->searchWithPage($pageindex, $pagesize);
		}
		$lists = $this->query->orderby('id', 'desc')->getall();
		return $lists;
	}

	public function searchOrderType($type, $ortype = 0) {
		$type = intval($type);
		if (!empty($ortype)) {
			$ortype = intval($ortype);
		}
		if (!empty($ortype)) {
			$this->query->where('type in', array($type, $ortype));
		} else {
			$this->query->where('type', $type);
		}
		return $this;
	}

	public function searchOrderInfo($id) {
		$id = intval($id);
		$result = $this->query->from('site_store_order')->where('id', $id)->get();
		return $result;
	}

	public function searchOrderWithUid($uid) {
		$uid = intval($uid);
		$this->query->where('buyerid', $uid);
		return $this;
	}

	public function searchHaveModule($type = STORE_TYPE_MODULE) {
		$this->query->from('site_store_goods');
		$result = $this->query->where('type', $type)->where('status !=', STORE_GOODS_STATUS_DELETE)->getall('module');
		return $result;
	}

	public function apiOrderWithUniacid($uniacid)
	{
		$this->query->from ('site_store_order', 'r')->leftjoin ('site_store_goods', 'g')->select ('r.duration, g.api_num, g.price')
			->on (array ('r.goodsid' => 'g.id'))->where ('g.type', STORE_TYPE_API)->where ('uniacid', $uniacid)->where ('type', STORE_ORDER_FINISH);
		$list = $this->query->getall ();
		return $list;
	}

	public function StoreCreateAccountInfo($uniacid) {
		return $this->query->from('site_store_create_account')->where('uniacid', $uniacid)->get();
	}

	public function searchUserBuyAccount($uid) {
		$sql = "SELECT SUM(b.account_num) FROM " . tablename('site_store_order') . " as a left join " . tablename('site_store_goods') . " as b on a.goodsid = b.id WHERE a.buyerid = :buyerid AND a.type = 3 AND b.type = 2" ;
		$count = pdo_fetchcolumn($sql, array(':buyerid' => $uid));
		$isdeleted_account_sql = "SELECT COUNT(*) FROM " . tablename('site_store_create_account') . " as a LEFT JOIN " . tablename('account') . " as b ON a.uniacid = b.uniacid WHERE a.uid = :uid AND a.type = 1 AND (b.isdeleted = 1 OR b.uniacid is NULL)";
		$deleted_account = pdo_fetchcolumn($isdeleted_account_sql, array(':uid' => $uid));
		return $count - $deleted_account;
	}

	public function searchUserBuyWxapp($uid) {
		$sql = "SELECT SUM(b.wxapp_num) FROM " . tablename('site_store_order') . " as a left join " . tablename('site_store_goods') . " as b on a.goodsid = b.id WHERE a.buyerid = :buyerid AND a.type = 3 AND b.type = 3" ;
		$count = pdo_fetchcolumn($sql, array(':buyerid' => $uid));
		$isdeleted_account_sql = "SELECT COUNT(*) FROM " . tablename('site_store_create_account') . " as a LEFT JOIN " . tablename('account') . " as b ON a.uniacid = b.uniacid WHERE a.uid = :uid AND a.type = 4 AND (b.isdeleted = 1 OR b.uniacid is NULL)";
		$deleted_account = pdo_fetchcolumn($isdeleted_account_sql, array(':uid' => $uid));
		return $count - $deleted_account;
	}

	public function searchUserBuyPackage($uniacid) {
		$sql = "SELECT * FROM " . tablename('site_store_order') . " as a left join " . tablename('site_store_goods') . " as b on a.goodsid = b.id WHERE a.uniacid = :uniacid AND a.type = 3 AND b.type = 5" ;
		return pdo_fetchall($sql, array(':uniacid' => $uniacid), 'module_group');
	}

	public function searchUserCreateAccountNum($uid) {
		$count = $this->query->from('site_store_create_account', 'a')->leftjoin('account', 'b')->on('a.uniacid', 'b.uniacid')->where('a.uid', $uid)->where('b.type', 1)->where('b.isdeleted', 0)->select('count(*) as count')->get('count');
		return $count['count'];
	}

	public function searchUserCreateWxappNum($uid) {
		$count = $this->query->from('site_store_create_account', 'a')->leftjoin('account', 'b')->on('a.uniacid', 'b.uniacid')->where('a.uid', $uid)->where('b.type', 4)->where('b.isdeleted', 0)->select('count(*) as count')->get('count');
		return $count['count'];
	}

	public function searchPaymentsOrder() {
		return  $this->query->from('site_store_order', 'a')->leftjoin('site_store_goods', 'b')->on('a.goodsid', 'b.id')->where('a.type', 3)->orderby('a.createtime', 'desc')->select(array('a.id', 'a.createtime', 'b.title', 'a.orderid', 'b.type', 'a.amount'))->getall();
	}
}
