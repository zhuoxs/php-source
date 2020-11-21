<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class GoodscircleModel extends PluginModel
{
	public $errmsg;
	public $errno = 0;
	private $set_items = array('goods_share' => '商品详情推荐', 'order' => '订单推荐', 'cart' => '购物车分享', 'goods_sync' => '物品信息同步');

	/**
     * 获取公众号或者小程序token
     * @param bool $wxapp
     * @return mixed
     */
	public function getToken($wxapp = false)
	{
		if ($wxapp) {
			return p('app')->getAccessToken();
		}

		return m('common')->getAccount()->fetch_token();
	}

	/**
     * 导入订单数据
     * @param string $openid
     * @param int $order_id
     * @param bool $is_history
     * author 洋葱
     * @return mixed
     */
	public function importOrder($openid = '', $order_id = 0, $is_history = false)
	{
		$goodscircle_set = m('common')->getPluginset('goodscircle');
		$set_items = $this->set_items;
		$item = 'order';

		if (!$goodscircle_set[$item]) {
			return error(-1, '未开启' . $set_items[$item]);
		}

		if (empty($openid)) {
			return error(-1, '缺少openid');
		}

		$history = 0;

		if ($is_history) {
			$history = 1;
			$order = $this->getHistoryOrders($openid);
		}
		else {
			if (empty($order_id)) {
				return error(-1, '缺少参数');
			}

			$order = $this->getOrder($openid, $order_id);
		}

		if (empty($order)) {
			return error(-1, '未找到符合条件的订单');
		}

		$token = $this->getToken(true);

		if (is_error($token)) {
			return $token;
		}

		$url = 'https://api.weixin.qq.com/mall/importorder?action=add-order&is_history=%d&access_token=%s';
		$url = sprintf($url, $history, $token);
		$result = ihttp_request($url, $order);
		$data = @json_decode($result['content'], true);

		if (!$is_history) {
			$this->wlog($data, $openid, $item, $order_id);
		}

		return $data;
	}

	/**
     * 更新订单
     * @param string $openid
     * @param int $order_id
     * author 洋葱
     * @return mixed
     */
	public function updateOrder($openid = '', $order_id = 0)
	{
		$goodscircle_set = m('common')->getPluginset('goodscircle');
		$set_items = $this->set_items;
		$item = 'order';

		if (!$goodscircle_set[$item]) {
			return error(-1, '未开启' . $set_items[$item]);
		}

		if (empty($openid) || empty($order_id)) {
			return error(-1, '缺少openid');
		}

		if (!$this->rlog($openid, $item, $order_id)) {
			return error(-1, '该订单未导入');
		}

		$order = $this->getOrder($openid, $order_id, true);
		if (empty($order) || empty($order['order_goods'])) {
			return error(-1, '订单或商品信息不存在');
		}

		$goods_info_list = array();
		$express_package_info_list = array();
		$has_express = false;
		$single_express = false;

		foreach ($order['order_goods'] as $goods) {
			if (!empty($goods['expresssn'])) {
				$has_express = true;
				$single_express = true;
				$goods_info_list = array('item_code' => $goods['goodsid'], 'sku_id' => $goods['optionid']);
				$express_company = $this->get_express_company($goods['express'], $goods['expresscom']);
				$express_package_info_list[] = array(
					'express_company_id'      => $express_company['express_company_id'],
					'express_company_name'    => $express_company['express_company_name'],
					'express_code'            => $goods['expresssn'],
					'ship_time'               => $goods['sendtime'],
					'express_page'            => array('path' => '/pages/order/detail/index?id=' . $order['id']),
					'express_goods_info_list' => array($goods_info_list)
				);
			}
			else {
				$goods_info_list[] = array('item_code' => $goods['goodsid'], 'sku_id' => $goods['optionid']);
			}
		}

		if (!$single_express) {
			if (!empty($order['expresssn'])) {
				$has_express = true;
			}

			$express_company = $this->get_express_company($order['express'], $order['expresscom']);
			$express_package_info_list[] = array(
				'express_company_id'      => $express_company['express_company_id'],
				'express_company_name'    => $express_company['express_company_name'],
				'express_code'            => $order['expresssn'],
				'ship_time'               => $order['sendtime'],
				'express_page'            => array('path' => '/pages/order/detail/index?id=' . $order['id']),
				'express_goods_info_list' => $goods_info_list
			);
		}

		$ext_info = array('user_open_id' => ltrim($order['openid'], 'sns_wa_'));

		if ($has_express) {
			$ext_info['express_info'] = array('price' => $order['dispatchprice'] * 100, 'express_package_info_list' => $express_package_info_list);
		}

		$status = 4;

		if ($order['status'] == -1) {
			$status = 12;
		}
		else if ($order['status'] == 1) {
			$status = 3;
		}
		else if ($order['status'] == 2) {
			$status = 4;
		}
		else {
			if ($order['status'] == 3) {
				$status = 100;
			}
		}

		if ($order['status'] == -1 && $order['refundtime']) {
			$status = 5;
		}

		$data['order_list'][] = array('order_id' => $order['ordersn'], 'trans_id' => $order['transid'], 'status' => $status, 'ext_info' => $ext_info);
		$update_data = json_encode($data, JSON_UNESCAPED_UNICODE);
		$token = $this->getToken(true);

		if (is_error($token)) {
			return $token;
		}

		$url = 'https://api.weixin.qq.com/mall/importorder?action=update-order&is_history=0&access_token=' . $token;
		$result = ihttp_request($url, $update_data);
		$data = @json_decode($result['content'], true);
		return $data;
	}

	/**
     * 删除订单
     * @param string $openid
     * @param string $order_sn
     * author 洋葱
     * @return array|mixed
     */
	public function deleteOrder($openid = '', $order_sn = '')
	{
		global $_W;
		$data = array('user_open_id' => ltrim($openid, 'sns_wa_'), 'order_id' => $order_sn);
		$del_data = json_encode($data, JSON_UNESCAPED_UNICODE);
		$token = $this->getToken(true);

		if (is_error($token)) {
			return $token;
		}

		$url = 'https://api.weixin.qq.com/mall/deleteorder?access_token=' . $token;
		$result = ihttp_request($url, $del_data);
		$data = @json_decode($result['content'], true);
		return $data;
	}

	/**
     * 获取一条订单数据
     * @param string $openid
     * @param int $order_id
     * @param bool $update
     * author 洋葱
     * @return array|string
     */
	private function getOrder($openid = '', $order_id = 0, $update = false)
	{
		global $_W;
		$condition = 'uniacid=:uniacid AND id=:id AND openid=:openid AND status<>0';
		$params = array(':uniacid' => $_W['uniacid'], ':id' => $order_id, ':openid' => $openid);
		$field = 'id,ordersn,openid,price,goodsprice,status,transid,addressid,dispatchprice,dispatchtype,carrier,address,createtime,paytime,finishtime,deductprice,deductcredit2,deductenough,merchdeductenough,couponprice,isdiscountprice,seckilldiscountprice,discountprice,paytype,expresscom,expresssn,express,sendtype,sendtime,refundtime';
		$sql = 'select ' . $field . ' from ' . tablename('ewei_shop_order') . (' where ' . $condition . ' limit 1');
		$order = pdo_fetch($sql, $params);

		if (empty($order)) {
			return array();
		}

		$og_condition = 'og.uniacid=:uniacid AND orderid=:orderid';
		$og_params = array(':uniacid' => $_W['uniacid'], ':orderid' => $order_id);
		$ordergoods_sql = 'select og.orderid,og.optionname,og.goodsid,og.total,og.realprice,og.price,og.oldprice,og.optionid,og.expresscom,og.expresssn,og.express,og.sendtime,g.thumb,g.title,g.description,g.subtitle,g.marketprice,g.productprice,g.cates from ' . tablename('ewei_shop_order_goods') . ' as og 
            left join ' . tablename('ewei_shop_goods') . (' as g on g.id=og.goodsid and g.uniacid=og.uniacid
            where ' . $og_condition);
		$order_goods = pdo_fetchall($ordergoods_sql, $og_params);

		if ($update) {
			$order['order_goods'] = $order_goods;
			return $order;
		}

		$data = $this->formatOrderData(array($order), $order_goods);
		return $data;
	}

	/**
     * 获取历史订单
     * @param string $openid
     * author 洋葱
     * @return array|string
     */
	private function getHistoryOrders($openid = '')
	{
		global $_W;
		$log_condition = 'op_type=:op_type AND openid=:openid AND uniacid=:uniacid';
		$log_params = array(':op_type' => 'order', ':openid' => $openid, ':uniacid' => $_W['uniacid']);
		$log_sql = 'select * from ' . tablename('ewei_shop_goodscircle_log') . (' where ' . $log_condition . ' limit 1');
		$log_data = pdo_fetch($log_sql, $log_params);

		if ($log_data) {
			return array();
		}

		$condition = 'uniacid=:uniacid AND openid=:openid AND status>0';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		$field = 'id,ordersn,openid,price,goodsprice,status,transid,addressid,dispatchprice,dispatchtype,carrier,address,createtime,paytime,finishtime,deductprice,deductcredit2,deductenough,merchdeductenough,couponprice,isdiscountprice,seckilldiscountprice,discountprice,paytype';
		$sql = 'select ' . $field . ' from ' . tablename('ewei_shop_order') . (' where ' . $condition . ' order by createtime desc limit 0,10');
		$history_order = pdo_fetchall($sql, $params);

		if (empty($history_order)) {
			return array();
		}

		foreach ($history_order as $order) {
			$this->wlog(array(), $openid, 'order', $order['id']);
		}

		$order_ids = array_column($history_order, 'id');
		$order_idstr = implode(',', $order_ids);
		$og_condition = 'og.uniacid=:uniacid AND orderid IN (' . $order_idstr . ')';
		$og_params = array(':uniacid' => $_W['uniacid']);
		$ordergoods_sql = 'select og.orderid,og.optionname,og.goodsid,og.total,og.realprice,og.price,og.oldprice,og.optionid,g.thumb,g.title,g.description,g.subtitle,g.marketprice,g.productprice,g.cates from ' . tablename('ewei_shop_order_goods') . ' as og 
            left join ' . tablename('ewei_shop_goods') . (' as g on g.id=og.goodsid and g.uniacid=og.uniacid
            where ' . $og_condition);
		$order_goods = pdo_fetchall($ordergoods_sql, $og_params, 'id');
		$data = $this->formatOrderData($history_order, $order_goods);
		return $data;
	}

	/**
     * 将订单数据格式化
     * @param $all_order
     * @param $order_goods
     * author 洋葱
     * @return array|string
     */
	private function formatOrderData($all_order, $order_goods)
	{
		if (empty($all_order) || empty($order_goods)) {
			return array();
		}

		$order_list = array();

		foreach ($all_order as $order) {
			$order['carrier'] = iunserializer($order['carrier']);
			$order['address'] = iunserializer($order['address']);
			$item_list = array();

			foreach ($order_goods as $goods) {
				if ($order['id'] == $goods['orderid']) {
					$goods_item = array(
						'item_code'        => $goods['goodsid'],
						'sku_id'           => $goods['optionid'],
						'amount'           => $goods['total'],
						'total_fee'        => $goods['price'] * 100,
						'thumb_url'        => tomedia($goods['thumb']),
						'title'            => $goods['title'],
						'desc'             => empty($goods['description']) ? $goods['subtitle'] : $goods['description'],
						'unit_price'       => $goods['price'] * 100,
						'original_price'   => $goods['productprice'] * 100,
						'category_list'    => $this->getGoodsCate($goods['cates']),
						'item_detail_page' => array('path' => '/pages/goods/detail/index?id=' . $goods['goodsid'])
					);

					if ($goods['optionid']) {
						$goods_item['stock_attr_info'][] = array(
							'attr_name'  => array('name' => '规格'),
							'attr_value' => array('name' => $goods['optionname'])
						);
					}

					$item_list[] = $goods_item;
				}
			}

			if (empty($item_list)) {
				continue;
			}

			$product_info = array('item_list' => $item_list);
			$name = '';
			$phone = '';

			if (!empty($order['carrier'])) {
				$name = $order['carrier']['carrier_realname'];
				$phone = $order['carrier']['carrier_mobile'];
			}

			$express_info = array('name' => $name, 'phone' => $phone, 'price' => $order['dispatchprice'] * 100);

			if (!empty($order['address'])) {
				$address_info = $order['address'];
				$express_info['name'] = $address_info['realname'];
				$express_info['phone'] = $address_info['mobile'];
				$express_info['address'] = $address_info['province'] . $address_info['city'] . $address_info['area'] . $address_info['address'];
				$express_info['price'] = $order['dispatchprice'] * 100;
				$express_info['country'] = '中国';
				$express_info['province'] = $address_info['province'];
				$express_info['city'] = $address_info['city'];
				$express_info['district'] = $address_info['area'];
			}

			$order_discount = $order['deductprice'] + $order['deductcredit2'] + $order['deductenough'] + $order['merchdeductenough'] + $order['couponprice'] + $order['isdiscountprice'] + $order['seckilldiscountprice'] + $order['discountprice'];

			if (p('membercard')) {
				$ifuse = p('membercard')->if_order_use_membercard($order['id']);

				if ($ifuse) {
					$order_discount += $ifuse['dec_price'];
				}
			}

			$promotion_info = array('discount_fee' => $order_discount * 100);
			$brand_info = array(
				'phone'               => empty($wxapp_set['phone']) ? '10086' : $wxapp_set['phone'],
				'contact_detail_page' => array('path' => '/pages/index/index')
			);
			$payment_method = 1;

			if ($order['paytype'] != 21) {
				$payment_method = 2;
			}

			$order_detail_page = array('path' => '/pages/order/detail/index?id=' . $order['id']);
			$ext_info = array('product_info' => $product_info, 'express_info' => $express_info, 'promotion_info' => $promotion_info, 'brand_info' => $brand_info, 'payment_method' => $payment_method, 'user_open_id' => ltrim($order['openid'], 'sns_wa_'), 'order_detail_page' => $order_detail_page);
			$status_map = array(1 => 3, 2 => 4, 3 => 100);
			$return_order = array('order_id' => $order['ordersn'], 'create_time' => $order['createtime'], 'pay_finish_time' => $order['paytime'], 'fee' => $order['price'] * 100, 'trans_id' => $order['transid'], 'status' => $status_map[$order['status']], 'ext_info' => $ext_info);
			$order_list['order_list'][] = $return_order;
		}

		if (empty($order_list['order_list'])) {
			return array();
		}

		return json_encode($order_list, JSON_UNESCAPED_UNICODE);
	}

	/**
     * 导入或更新商品信息
     * @param int $goods_id
     * author 洋葱
     * @return mixed
     */
	public function importGoods($goods_id = 0)
	{
		$goodscircle_set = m('common')->getPluginset('goodscircle');
		$set_items = $this->set_items;
		$item = 'goods_sync';

		if (!$goodscircle_set[$item]) {
			return error(-1, '未开启' . $set_items[$item]);
		}

		if (empty($goods_id)) {
			return error(-1, '缺少参数');
		}

		if ($this->rlog('', $item, $goods_id)) {
			return error(-1, '该商品已经导入');
		}

		$goods = $this->getShopGoods($goods_id);

		if (empty($goods)) {
			return error(-1, '未找到符合条件的商品');
		}

		$token = $this->getToken(true);

		if (is_error($token)) {
			return $token;
		}

		$url = 'https://api.weixin.qq.com/mall/importproduct?access_token=' . $token;
		$result = ihttp_request($url, $goods);
		$data = @json_decode($result['content'], true);
		$this->wlog($data, '', $item, $goods_id);
		return $data;
	}

	/**
     * 获取加入购物车的商品
     * @param $openid
     * @param $cart_id
     * @param $goods_id
     * author 洋葱
     * @return array|string
     */
	private function getCartGoods($openid, $cart_id, $goods_id)
	{
		global $_W;
		$condition = 'cart.id=:id AND cart.uniacid=:uniacid AND openid=:openid AND cart.goodsid=:goodsid';
		$params = array(':id' => $cart_id, ':uniacid' => $_W['uniacid'], ':openid' => $openid, ':goodsid' => $goods_id);
		$field = 'cart.goodsid,cart.optionid,cart.marketprice,op.title as optiontitle,op.marketprice as op_marketprice,op.stock as op_tock,op.productprice as op_productprice,g.title,g.total,g.hasoption,g.cates,g.thumb,g.thumb_url,g.description,g.subtitle,g.productprice,g.status';
		$sql = 'select ' . $field . ' from ' . tablename('ewei_shop_member_cart') . ' as cart
            left join ' . tablename('ewei_shop_goods') . ' as g on cart.goodsid=g.id
            left join ' . tablename('ewei_shop_goods_option') . (' as op on cart.optionid=op.id
            where ' . $condition . ' limit 1');
		$goods = pdo_fetch($sql, $params);

		if (empty($goods)) {
			return array();
		}

		$thumb_url = iunserializer($goods['thumb_url']);

		if (!empty($thumb_url)) {
			$thumb_url = array_map(function($v) {
				return tomedia($v);
			}, $thumb_url);
		}

		$thumbs = array_merge(array(tomedia($goods['thumb'])), $thumb_url);
		$goods['thumbs'] = $thumbs;
		$data = array('item_code' => $goods['goodsid'], 'title' => $goods['title'], 'desc' => empty($goods['description']) ? $goods['subtitle'] : $goods['description'], 'category_list' => $this->getGoodsCate($goods['cates']), 'image_list' => $thumbs, 'src_wxapp_path' => '/pages/goods/detail/index?id=' . $goods['goodsid'], 'can_be_search' => true);

		if ($goods['hasoption']) {
			$data['attr_list'][] = array('name' => '规格', 'value' => $goods['optiontitle']);
		}

		$status = 1;

		if ($goods['status'] == 0) {
			$status = 2;
		}

		$sku_info = array('sku_id' => $goods['goodsid'] . '_' . $goods['optionid'], 'price' => empty($goods['hasoption']) ? $goods['marketprice'] : $goods['op_marketprice'], 'original_price' => empty($goods['hasoption']) ? $goods['productprice'] : $goods['op_productprice'], 'status' => $status);
		$data['sku_info'] = $sku_info;
		$product = array(
			'user_open_id'     => ltrim($openid, 'sns_wa_'),
			'sku_product_list' => array($data)
		);
		return json_encode($product, JSON_UNESCAPED_UNICODE);
	}

	/**
     * 商品加入收藏
     * @param string $openid
     * @param int $cart_id
     * @param int $goods_id
     * author 洋葱
     * @return array|mixed
     */
	public function addShoppingList($openid = '', $cart_id = 0, $goods_id = 0)
	{
		$goodscircle_set = m('common')->getPluginset('goodscircle');
		$set_items = $this->set_items;
		$item = 'cart';

		if (!$goodscircle_set[$item]) {
			return error(-1, '未开启' . $set_items[$item]);
		}

		if (empty($openid) || empty($goods_id) || empty($cart_id)) {
			return error(-1, '缺少参数');
		}

		if ($this->rlog($openid, $item, $goods_id)) {
			return error(-1, '该商品已经收藏');
		}

		$goods = $this->getCartGoods($openid, $cart_id, $goods_id);

		if (empty($goods)) {
			return error(-1, '未找到符合条件的商品');
		}

		$token = $this->getToken(true);

		if (is_error($token)) {
			return $token;
		}

		$url = 'https://api.weixin.qq.com/mall/addshoppinglist?access_token=' . $token;
		$result = ihttp_request($url, $goods);
		$data = @json_decode($result['content'], true);
		$this->wlog($data, $openid, $item, $goods_id);
		return $data;
	}

	/**
     * 获取要导入的商城商品
     * @param $goods_id
     * author 洋葱
     * @return array|string
     */
	public function getShopGoods($goods_id, $detail = false)
	{
		global $_W;
		$condition = 'uniacid=:uniacid AND id=:id AND status<2';
		$params = array(':uniacid' => $_W['uniacid'], ':id' => $goods_id);
		$field = 'id,title,total,hasoption,cates,thumb,thumb_url,description,subtitle,productprice,status,minprice,marketprice';
		$sql = 'select ' . $field . ' from ' . tablename('ewei_shop_goods') . (' where ' . $condition . ' limit 1');
		$goods = pdo_fetch($sql, $params);

		if (empty($goods)) {
			return array();
		}

		$thumb_url = iunserializer($goods['thumb_url']);

		if (!empty($thumb_url)) {
			$thumb_url = array_map(function($v) {
				return tomedia($v);
			}, $thumb_url);
		}

		$thumbs = array_merge(array(tomedia($goods['thumb'])), $thumb_url);
		$goods['thumbs'] = $thumbs;
		$data = array('item_code' => $goods['id'], 'title' => $goods['title'], 'desc' => empty($goods['description']) ? $goods['subtitle'] : $goods['description'], 'category_list' => $this->getGoodsCate($goods['cates']), 'image_list' => $thumbs, 'src_wxapp_path' => '/pages/goods/detail/index?id=' . $goods['id'], 'can_be_search' => true);
		$status = 1;

		if ($goods['status'] == 0) {
			$status = 2;
		}

		if ($goods['total'] <= 0) {
			$status = 3;
		}

		$price = empty($goods['minprice']) ? $goods['marketprice'] : $goods['minprice'];
		$sku_list = array('sku_id' => $goods['id'], 'price' => $price * 100, 'original_price' => $goods['productprice'] * 100, 'status' => $status);
		$data['sku_list'] = array($sku_list);
		$product_list['product_list'][] = $data;

		if ($detail) {
			return $data;
		}

		return json_encode($product_list, JSON_UNESCAPED_UNICODE);
	}

	/**
     * 获取商品的分类
     * @param string $cate_ids 商品分类的ID(逗号隔开的字符串)
     * author 洋葱
     * @return array
     */
	private function getGoodsCate($cate_ids = '')
	{
		global $_W;
		$cate_ids = trim($cate_ids);
		$cate_ids = explode(',', $cate_ids);
		$return_cates = array();

		if (empty($cate_ids)) {
			$return_cates[] = '其他';
			return $return_cates;
		}

		foreach ($cate_ids as $key => $cid) {
			$cate_name = pdo_fetchcolumn('select `name` from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));

			if ($cate_name) {
				$return_cates[] = $cate_name;
			}
		}

		if (empty($return_cates)) {
			$return_cates[] = '其他';
		}

		return $return_cates;
	}

	/**
     * 记录好物圈导入操作日志
     * @param $response 接口响应
     * @param string $openid    用户openid
     * @param $op_type  操作类型(导入订单order 加购收藏cart 导入商品goods_sync)
     * @param int $op_id
     * author 洋葱
     * @return mixed
     */
	private function wlog($response, $openid = '', $op_type, $op_id = 0)
	{
		global $_W;
		$is_success = 1;
		$response_msg = 'success';

		if ($response['errcode']) {
			$is_success = 0;
			$response_msg = $response['errcode'] . '|' . $response['errmsg'];
		}

		$data = array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'op_type' => $op_type, 'op_id' => $op_id, 'is_success' => $is_success, 'response_msg' => $response_msg, 'createtime' => time());
		return pdo_insert('ewei_shop_goodscircle_log', $data);
	}

	/**
     * 获取导入记录
     * @param string $openid
     * @param $op_type
     * @param int $op_id
     * author 洋葱
     * @return bool
     */
	private function rlog($openid = '', $op_type, $op_id = 0)
	{
		global $_W;
		$condition = 'op_type=:op_type AND op_id=:op_id AND uniacid=:uniacid AND is_success=1';
		$params = array(':op_type' => $op_type, ':op_id' => $op_id, ':uniacid' => $_W['uniacid']);

		if (!empty($openid)) {
			$condition .= ' AND openid=:openid';
			$params[':openid'] = $openid;
		}

		$sql = 'select * from ' . tablename('ewei_shop_goodscircle_log') . (' where ' . $condition . ' limit 1');
		$data = pdo_fetch($sql, $params);

		if (empty($data)) {
			return false;
		}

		return true;
	}

	/**
     * 根据商城快递方式获取好物圈支持的物流
     * @param string $express_key
     * @param string $express_name
     * author 洋葱
     * @return array|mixed
     */
	private function get_express_company($express_key = '', $express_name = '')
	{
		$goods_circle_express = array(
			'ems'           => array('express_company_id' => '2000', 'express_company_name' => 'EMS'),
			'yuantong'      => array('express_company_id' => '2001', 'express_company_name' => '圆通'),
			'dhl'           => array('express_company_id' => '2002', 'express_company_name' => 'DHL'),
			'zhongtong'     => array('express_company_id' => '2004', 'express_company_name' => '中通'),
			'yunda'         => array('express_company_id' => '2005', 'express_company_name' => '韵达'),
			'shl'           => array('express_company_id' => '2006', 'express_company_name' => '畅灵'),
			'huitongkuaidi' => array('express_company_id' => '2008', 'express_company_name' => '百世汇通'),
			'debangwuliu'   => array('express_company_id' => '2009', 'express_company_name' => '德邦'),
			'shentong'      => array('express_company_id' => '2010', 'express_company_name' => '申通'),
			'shunfeng'      => array('express_company_id' => '2011', 'express_company_name' => '顺丰速运'),
			'shunxing'      => array('express_company_id' => '2012', 'express_company_name' => '顺兴'),
			'rufengda'      => array('express_company_id' => '2014', 'express_company_name' => '如风达'),
			'youshuwuliu'   => array('express_company_id' => '2015', 'express_company_name' => '优速')
		);

		if (in_array($express_key, array_keys($goods_circle_express))) {
			return $goods_circle_express[$express_key];
		}

		$express_company_name = trim($express_name);
		return array('express_company_id' => '9999', 'express_company_name' => empty($express_company_name) ? '其他快递' : $express_company_name);
	}
}

?>
