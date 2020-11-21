<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$ishidden = m('common')->getSysset('fullback');
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $uniacid);
		$type = trim($_GPC['status']);

		if ($type == '-1') {
			$condition .= ' AND status = 0 ';
		}
		else {
			if ($type == '1') {
				$condition .= ' AND status = 1 ';
			}
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND titles LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$gifts = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_fullback_goods') . '
                    WHERE 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);
		$gifts = $this->deal_fullback_goods($gifts);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	/**
     * 全返文字设置
     */
	public function set()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			$text = '全返';
			$set = m('common')->getSysset('fullback');

			if (!empty($set['text'])) {
				$text = $set['text'];
			}

			include $this->template();
			return NULL;
		}

		if (empty($_GPC['text'])) {
			return NULL;
		}

		m('common')->updateSysset(array(
			'fullback' => array('text' => $_GPC['text'])
		));
		show_json(1);
	}

	public function show()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$ishidden = m('common')->getSysset('fullback');

		if (empty($ishidden['ishidden'])) {
			$ishidden['ishidden'] = false;
		}

		m('common')->updateSysset(array(
			'fullback' => array('ishidden' => !$ishidden['ishidden'])
		));
		show_json(1, array('url' => referer()));
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
		$uniacid = intval($_W['uniacid']);
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			$data = array('uniacid' => $uniacid, 'displayorder' => intval($_GPC['displayorder']), 'type' => intval($_GPC['type']), 'titles' => trim($_GPC['titles']), 'thumb' => save_media($_GPC['thumb']), 'marketprice' => floatval($_GPC['marketprice']), 'startday' => intval($_GPC['startday']), 'refund' => intval($_GPC['refund']), 'status' => intval($_GPC['status']));

			if (empty($id)) {
				$data['goodsid'] = intval($_GPC['goodsid']);
			}
			else {
				$item = pdo_fetch('SELECT goodsid FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE uniacid = ' . $uniacid . ' and id = ' . $id . ' ');
				$data['goodsid'] = $item['goodsid'];
			}

			if (empty($data['goodsid'])) {
				show_json(0, '指定商品不能为空！');
			}

			$fullbackgoodsnum = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_fullback_goods') . ' where goodsid = :goodsid and uniacid = :uniacid ', array(':goodsid' => $data['goodsid'], ':uniacid' => $uniacid));
			if (empty($id) && 0 < $fullbackgoodsnum) {
				show_json(0, '全返商品不能重复添加');
			}

			if ($data['startday'] < 0) {
				show_json(0, '全返时间不可以小于0！');
			}

			$option = $_GPC['fullbackgoods'];
			$good_data = pdo_fetch('select title,thumb,marketprice,goodssn,productsn,hasoption
                            from ' . tablename('ewei_shop_goods') . ' where id = ' . $data['goodsid'] . ' and uniacid = ' . $uniacid . ' ');

			if (empty($data['thumb'])) {
				$data['thumb'] = save_media($good_data['thumb']);
				$data['marketprice'] = $good_data['marketprice'];
			}

			if (empty($good_data['option']) && !$good_data['hasoption']) {
				$fullbackgoodsStr = $_GPC['goods' . $data['goodsid'] . ''];
				$fullbackgoodsArray = explode(',', $fullbackgoodsStr);
				$data['minallfullbackallprice'] = $fullbackgoodsArray[0];
				$data['fullbackprice'] = $fullbackgoodsArray[1];
				$data['minallfullbackallratio'] = $fullbackgoodsArray[2];
				$data['fullbackratio'] = $fullbackgoodsArray[3];
				$data['day'] = $fullbackgoodsArray[4];
			}

			$good_data['option'] = $option[$data['goodsid']] ? $option[$data['goodsid']] : '';
			if ($good_data['hasoption'] && empty($good_data['option'])) {
				show_json(0, '请选择商品规格！');
			}

			if (!empty($good_data['option'])) {
				$data['hasoption'] = 1;
				$data['optionid'] = $option[$data['goodsid']];
				$fullbackOption = array_filter(explode(',', $good_data['option']));
				pdo_update('ewei_shop_goods_option', array('isfullback' => 0), array('uniacid' => $uniacid, 'goodsid' => $data['goodsid']));

				foreach ($fullbackOption as $val) {
					$fullbackgoodsoption = explode(',', $_GPC['fullbackgoodsoption' . $val . '']);
					$optionData = array('allfullbackprice' => floatval($fullbackgoodsoption[0]), 'fullbackprice' => floatval($fullbackgoodsoption[1]), 'allfullbackratio' => floatval($fullbackgoodsoption[2]), 'fullbackratio' => floatval($fullbackgoodsoption[3]), 'day' => intval($fullbackgoodsoption[4]), 'isfullback' => 1);
					pdo_update('ewei_shop_goods_option', $optionData, array('uniacid' => $uniacid, 'id' => intval($val)));
				}
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_fullback_goods', $data, array('id' => $id));
				plog('sale.fullback.edit', '编辑全返 ID: ' . $id . ' <br/>全返名称: ' . $data['titles']);
			}
			else {
				pdo_insert('ewei_shop_fullback_goods', $data);
				$id = pdo_insertid();
				plog('sale.fullback.add', '添加全返 ID: ' . $id . '  <br/>全返名称: ' . $data['titles']);
			}

			$sql = 'update ' . tablename('ewei_shop_fullback_goods') . ' g set
                g.minallfullbackallprice = (select min(allfullbackprice) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $data['goodsid'] . '),
                g.maxallfullbackallprice = (select max(allfullbackprice) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $data['goodsid'] . '),
                g.minallfullbackallratio = (select min(allfullbackratio) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $data['goodsid'] . '),
                g.maxallfullbackallratio = (select max(allfullbackratio) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $data['goodsid'] . ')
                where g.goodsid = ' . $data['goodsid'] . ' and g.hasoption=1 and g.uniacid = ' . $uniacid . ' and g.id = ' . $id . ' ';
			pdo_query($sql);

			if (0 < $data['status']) {
				pdo_update('ewei_shop_goods', array('isfullback' => $id), array('id' => $data['goodsid']));
			}
			else {
				pdo_update('ewei_shop_goods', array('isfullback' => 0), array('id' => $data['goodsid']));
			}

			show_json(1, array('url' => webUrl('sale/fullback/edit', array('id' => $id))));
		}

		if (!empty($id)) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_fullback_goods') . ' WHERE uniacid = ' . $uniacid . ' and id = ' . $id . ' ');
			$good_data = pdo_fetch('select title,thumb,hasoption
                            from ' . tablename('ewei_shop_goods') . ' where id = ' . $item['goodsid'] . ' and uniacid = ' . $uniacid . ' ');

			if (empty($good_data)) {
				$this->message('抱歉，商品不存在或是已经删除！', '', 'error');
			}

			$item['title'] = $good_data['title'];
			$optionid = '';

			if (0 < $item['hasoption']) {
				$item['option'] = pdo_fetchall('SELECT id,title,marketprice,specs,allfullbackprice,fullbackprice,allfullbackratio,fullbackratio,isfullback,day 
                FROM ' . tablename('ewei_shop_goods_option') . '
                WHERE uniacid = :uniacid and goodsid = :goodsid  ORDER BY displayorder DESC,id DESC ', array(':uniacid' => $uniacid, 'goodsid' => $item['goodsid']));

				foreach ($item['option'] as $value) {
					$optionid .= $value['id'] . ',';
				}

				$optionid = rtrim($optionid, ',');
			}

			if (!empty($item['thumb'])) {
				$item = set_medias($item, array('thumb'));
			}
		}

		include $this->template();
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,titles FROM ' . tablename('ewei_shop_fullback_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_fullback_goods', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			pdo_update('ewei_shop_goods', array('isfullback' => intval($item['id'])), array('id' => $items['goodsid']));
			plog('sale.fullback.edit', '修改全返商品状态<br/>ID: ' . $item['id'] . '<br/>商品名称: ' . $item['titles'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '开启' : '关闭');
		}

		show_json(1, array('url' => referer()));
	}

	public function delete1()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,titles,goodsid FROM ' . tablename('ewei_shop_fullback_goods') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_fullback_goods', array('id' => $item['id']));
			pdo_update('ewei_shop_goods', array('isfullback' => 0), array('id' => $item['goodsid']));
			plog('sale.fullback.edit', '彻底删除全返商品<br/>ID: ' . $item['id'] . '<br/>全返商品名称: ' . $item['titles']);
		}

		show_json(1, array('url' => referer()));
	}

	public function change()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			show_json(0, array('message' => '参数错误'));
		}

		$type = trim($_GPC['typechange']);
		$value = trim($_GPC['value']);

		if (!in_array($type, array('titles', 'displayorder'))) {
			show_json(0, array('message' => '参数错误'));
		}

		$gift = pdo_fetch('select id from ' . tablename('ewei_shop_fullback_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($gift)) {
			show_json(0, array('message' => '参数错误'));
		}

		pdo_update('ewei_shop_fullback_goods', array($type => $value), array('id' => $id));
		show_json(1);
	}

	public function query()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$kwd = trim($_GPC['keyword']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 8;
		$params = array();
		$params[':uniacid'] = $uniacid;
		$condition = ' and deleted=0 and uniacid=:uniacid and status = 1 and merchid = 0 and type != 30 ';

		if (!empty($kwd)) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $kwd . '%';
		}

		$goods = pdo_fetchall('SELECT id,title,thumb,marketprice,total
            FROM ' . tablename('ewei_shop_goods') . ('
            WHERE 1 ' . $condition . ' ORDER BY displayorder DESC,id DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_goods') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		$goods = set_medias($goods, array('thumb'));
		include $this->template();
	}

	public function hasoption()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$goodsid = intval($_GPC['goodsid']);
		$id = intval($_GPC['id']);
		$hasoption = 0;
		$params = array(':uniacid' => $uniacid, ':goodsid' => $goodsid);
		$goods = pdo_fetch('select id,title,marketprice,hasoption,isfullback from ' . tablename('ewei_shop_goods') . ' where uniacid = :uniacid and id = :goodsid ', $params);

		if (!empty($id)) {
			$fullback = pdo_fetch('select * from ' . tablename('ewei_shop_fullback_goods') . '
                        where id = ' . $id . ' and uniacid = :uniacid and goodsid = :goodsid ', $params);
			$fullback['isfullback'] = $goods['isfullback'];
		}
		else {
			$fullback = array('titles' => $goods['title'], 'marketprice' => $goods['marketprice'], 'allfullbackprice' => 0, 'fullbackprice' => 0, 'allfullbackratio' => 0, 'fullbackratio' => 0, 'isfullback' => 0);
		}

		if ($goods['hasoption']) {
			$hasoption = 1;
			$option = array();
			$option = pdo_fetchall('SELECT id,title,marketprice,specs,allfullbackprice,fullbackprice,allfullbackratio,fullbackratio,isfullback 
                FROM ' . tablename('ewei_shop_goods_option') . '
                WHERE uniacid = :uniacid and goodsid = :goodsid  ORDER BY displayorder DESC,id DESC ', $params);
		}
		else {
			$packgoods['marketprice'] = $goods['marketprice'];
		}

		include $this->template();
	}

	public function option()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$options = is_array($_GPC['option']) ? implode(',', array_filter($_GPC['option'])) : 0;
		$options = intval($options);
		$option = pdo_fetch('SELECT id,title FROM ' . tablename('ewei_shop_goods_option') . '
            WHERE uniacid = ' . $uniacid . ' and id = ' . $options . '  ORDER BY displayorder DESC,id DESC LIMIT 1');
		show_json(1, $option);
	}

	/**
     * 处理全返商品
     * @param array $goods
     * author 洋葱
     * @return array
     */
	private function deal_fullback_goods($goods = array())
	{
		global $_W;
		$return_arr = array();

		if (empty($goods)) {
			return $return_arr;
		}

		foreach ($goods as &$item) {
			if ($item['hasoption']) {
				if (empty($item['optionid'])) {
					continue;
				}

				$options = pdo_fetchall('SELECT id,title,marketprice,`day`,allfullbackprice,fullbackprice FROM ' . tablename('ewei_shop_goods_option') . '
            WHERE uniacid = ' . $_W['uniacid'] . ' and id IN ( ' . $item['optionid'] . ' ) ');
				$marketprices = array_column($options, 'marketprice');
				$days = array_column($options, 'day');
				$allfullbackprices = array_column($options, 'allfullbackprice');
				$fullbackprices = array_column($options, 'fullbackprice');
				$marketprice_max = max($marketprices);
				$marketprice_min = min($marketprices);
				$marketprice = $marketprice_min . '-' . $marketprice_max;

				if ($marketprice_max == $marketprice_min) {
					$marketprice = $marketprice_min;
				}

				$item['marketprice'] = $marketprice;
				$day_min = min($days);
				$day_max = max($days);
				$day = $day_min . '-' . $day_max;

				if ($day_min == $day_max) {
					$day = $day_min;
				}

				$item['day'] = $day;
				$allfullbackprice_min = min($allfullbackprices);
				$allfullbackprice_max = max($allfullbackprices);
				$allfullbackprice = $allfullbackprice_min . '-' . $allfullbackprice_max;

				if ($allfullbackprice_min == $allfullbackprice_max) {
					$allfullbackprice = $allfullbackprice_min;
				}

				$item['minallfullbackallprice'] = $allfullbackprice;
				$fullbackprice_min = min($fullbackprices);
				$fullbackprice_max = max($fullbackprices);
				$fullbackprice = $fullbackprice_min . '-' . $fullbackprice_max;

				if ($fullbackprice_min == $fullbackprice_max) {
					$fullbackprice = $fullbackprice_min;
				}

				$item['fullbackprice'] = $fullbackprice;
			}

			$item['order_count'] = pdo_fetchcolumn('SELECT COUNT(DISTINCT(orderid)) FROM ' . tablename('ewei_shop_order_goods') . ' WHERE uniacid = ' . $_W['uniacid'] . ' and fullbackid = ' . $item['id'] . ' and  goodsid = ' . $item['goodsid']);
		}

		unset($item);
		return $goods;
	}

	/**
     * 全返信息展示
     * @return mixed|string
     * @author: Vencenty
     * @time: 2019/4/18 17:59
     */
	public function info()
	{
		global $_W;
		global $_GPC;
		$orderId = $_GPC['order_id'];
		$optionId = isset($_GPC['option_id']) ? $_GPC['option_id'] : 0;
		$goodsId = $_GPC['goods_id'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$sql = 'select * from ' . tablename('ewei_shop_fullback_log') . ' where orderid = :orderid and optionid = :optionid and goodsid = :goodsid ';
		$fullbackInfo = pdo_fetch($sql, array(':orderid' => $orderId, ':goodsid' => $goodsId, 'optionid' => $optionId));
		$sql = 'select * from ' . tablename('ewei_shop_fullback_log_map') . ' where logid = :logid order by fullback_time desc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$fullbackLogs = pdo_fetchall($sql, array(':logid' => $fullbackInfo['id']));
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_fullback_log_map') . ' where logid = :logid', array(':logid' => $fullbackInfo['id']));
		$pager = pagination2($total, $pindex, $psize, '', array('before' => 5, 'after' => 4, 'ajaxcallback' => 'select_page', 'callbackfuncname' => 'select_page'));
		array_walk($fullbackLogs, function(&$value) {
			if ($value['price'] == 0 || $value['day'] == 0) {
				$value['desc'] = '<span style=\'color: red;\'>异常</span>';
			}
			else {
				$value['desc'] = '已返';
			}
		});
		include $this->template();
	}
}

?>
