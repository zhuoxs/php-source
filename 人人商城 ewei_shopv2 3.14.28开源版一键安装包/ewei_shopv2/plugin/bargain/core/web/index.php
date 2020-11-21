<?php
//QQ63779278
class Index_EweiShopV2Page extends PluginWebPage
{
	public function __construct()
	{
		global $_W;
		parent::__construct();
		$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_account') . ' WHERE id = :id', array(':id' => $_W['uniacid']));

		if (empty($res)) {
			pdo_insert('ewei_shop_bargain_account', array('id' => $_W['uniacid'], 'mall_name' => '砍价商城'));
		}
	}

	public function main()
	{
		global $_GPC;
		global $_W;
		$page = max(1, intval($_GPC['page']));
		$psize = 20;

		if (empty($_GPC['search'])) {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE g.total > 0 AND unix_timestamp(goods.end_time )>' . time() . ' AND unix_timestamp(goods.start_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.end_time )>' . time() . ' AND g.total > 0 AND unix_timestamp(goods.start_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid']));
		}
		else {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE g.total > 0 AND unix_timestamp(goods.end_time )>' . time() . ' AND unix_timestamp(goods.start_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid AND g.title LIKE :keyword ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.end_time )>' . time() . ' AND g.total > 0 AND unix_timestamp(goods.start_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND g.title LIKE :keyword AND goods.account_id = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
		}

		$pager = pagination2($all, $page, $psize);
		include $this->template();
	}

	public function soldout()
	{
		global $_W;
		global $_GPC;
		$page = max(1, intval($_GPC['page']));
		$psize = 20;

		if (empty($_GPC['search'])) {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE g.total <= 0 AND unix_timestamp(goods.end_time )>' . time() . ' AND unix_timestamp(goods.start_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.end_time )>' . time() . ' AND g.total <= 0 AND unix_timestamp(goods.start_time )>' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid']));
		}
		else {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE g.total <= 0 AND unix_timestamp(goods.end_time )>' . time() . ' AND unix_timestamp(goods.start_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid AND g.title LIKE :keyword ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.end_time )>' . time() . ' AND g.total <= 0 AND unix_timestamp(goods.start_time )>' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND g.title LIKE :keyword AND goods.account_id = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
		}

		$pager = pagination2($all, $page, $psize);
		include $this->template();
	}

	public function notstart()
	{
		global $_W;
		global $_GPC;
		$page = max(1, intval($_GPC['page']));
		$psize = 20;

		if (empty($_GPC['search'])) {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.start_time )>' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.start_time )>' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid']));
		}
		else {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.start_time )>' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND g.title LIKE :keyword AND goods.account_id = :uniacid ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.start_time )>' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND g.title LIKE :keyword AND goods.account_id = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
		}

		$pager = pagination2($all, $page, $psize);
		include $this->template();
	}

	public function complete()
	{
		global $_W;
		global $_GPC;
		$page = max(1, intval($_GPC['page']));
		$psize = 20;

		if (empty($_GPC['search'])) {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.end_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND unix_timestamp(goods.start_time )<' . time() . ' AND g.deleted = \'0\' AND goods.account_id = :uniacid ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.end_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND goods.account_id = :uniacid AND unix_timestamp(goods.start_time )<' . time();
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid']));
		}
		else {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.end_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND unix_timestamp(goods.start_time )<' . time() . ' AND g.deleted = \'0\' AND g.title LIKE :keyword AND goods.account_id = :uniacid ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE unix_timestamp(goods.end_time )<' . time() . ' AND goods.status = \'0\' AND g.status = \'1\' AND g.deleted = \'0\' AND g.title LIKE :keyword AND goods.account_id = :uniacid AND unix_timestamp(goods.start_time )<' . time();
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
		}

		$pager = pagination2($all, $page, $psize);
		include $this->template();
	}

	public function out()
	{
		global $_W;
		global $_GPC;
		$page = max(1, intval($_GPC['page']));
		$psize = 20;

		if (empty($_GPC['search'])) {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE (g.status = \'0\' or g.deleted=\'1\') AND goods.status = \'0\' AND goods.account_id = :uniacid ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE (g.status = \'0\' or g.deleted=\'1\') AND goods.status = \'0\' AND goods.account_id = :uniacid  AND g.uniacid = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid']));
		}
		else {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE (g.status = \'0\' or g.deleted=\'1\') AND goods.status = \'0\' AND goods.account_id = :uniacid  AND g.title LIKE :keyword ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE (g.status = \'0\' or g.deleted=\'1\') AND goods.status = \'0\' AND goods.account_id = :uniacid AND g.title LIKE :keyword';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
		}

		$pager = pagination2($all, $page, $psize);
		include $this->template();
	}

	public function recycle()
	{
		global $_W;
		global $_GPC;
		$page = max(1, intval($_GPC['page']));
		$psize = 20;

		if (empty($_GPC['search'])) {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE goods.status = \'1\' AND g.uniacid = :uniacid ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE goods.status = \'1\' AND g.uniacid = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid']));
		}
		else {
			$sql = 'SELECT goods.*,g.total,thumb,marketprice,sales,title FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE goods.status = \'1\' AND g.uniacid = :uniacid AND g.title LIKE :keyword ORDER BY goods.id DESC LIMIT ' . ($page * $psize - $psize) . (',' . $psize);
			$onSell = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
			$all_sql = 'SELECT COUNT(*) FROM' . tablename('ewei_shop_bargain_goods') . ' goods JOIN' . tablename('ewei_shop_goods') . ' g ON goods.goods_id = g.id WHERE goods.status = \'1\' AND g.title LIKE :keyword AND g.uniacid = :uniacid';
			$all = pdo_fetchcolumn($all_sql, array(':uniacid' => $_W['uniacid'], ':keyword' => '%' . $_GPC['search'] . '%'));
		}

		$pager = pagination2($all, $page, $psize);
		include $this->template();
	}

	public function recover()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$goods = intval($_GPC['goods']);

		if (!empty($id)) {
			$goods_id = pdo_fetch('SELECT goods_id FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id = :id', array(':id' => $id));
			$if_up = pdo_fetch('SELECT bargain FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id', array(':id' => $goods_id['goods_id']));

			if (empty($if_up['bargain'])) {
				pdo_update('ewei_shop_bargain_goods', array('status' => 0), array('status' => 1, 'id' => $id, 'account_id' => $_W['uniacid']));
				pdo_update('ewei_shop_goods', array('bargain' => $id), array('id' => $goods_id['goods_id']));
			}
			else {
				show_json(0, '恢复失败,另一个此商品的砍价活动已存在!');
				return NULL;
			}
		}
		else {
			if (!empty($goods)) {
				pdo_query('UPDATE' . tablename('ewei_shop_goods') . 'SET status = \'1\' ,deleted = \'0\' WHERE (status = \'0\' OR deleted=\'1\') AND uniacid = :uniacid and id=:goods', array(':uniacid' => $_W['uniacid'], 'goods' => $goods));
			}
		}

		show_json(1, '恢复成功');
	}

	public function warehouse()
	{
		global $_W;
		global $_GPC;
		$page = max(1, intval($_GPC['page']));
		$psize = 20;

		if (p('seckill')) {
			$goodsids = array();
			$seckill_goods = pdo_fetchall('select goodsid from ' . tablename('ewei_shop_seckill_task_goods') . ' where uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));

			if (!empty($seckill_goods)) {
				foreach ($seckill_goods as $v) {
					$goodsids[] = $v['goodsid'];
				}
			}
		}

		if (empty($_GPC['search'])) {
			$get_all_goods_sql = 'SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid = :uniacid AND status = \'1\' AND deleted = 0 ORDER BY id ASC LIMIT ' . ($page * $psize - $psize) . ',' . $psize;
			$allGoods = pdo_fetchall($get_all_goods_sql, array(':uniacid' => $_W['uniacid']));
			$count = pdo_fetch('SELECT COUNT(*) FROM ' . tablename('ewei_shop_goods') . 'WHERE uniacid = :uniacid AND status = \'1\' AND deleted = 0', array(':uniacid' => $_W['uniacid']));
		}
		else {
			$get_all_goods_sql = 'SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE uniacid = :uniacid AND status = \'1\' AND deleted = 0 AND title LIKE \'%' . $_GPC['search'] . '%\' ORDER BY id ASC LIMIT ' . ($page * $psize - $psize) . ',' . $psize;
			$allGoods = pdo_fetchall($get_all_goods_sql, array(':uniacid' => $_W['uniacid']));
			$count = pdo_fetch('SELECT COUNT(*) FROM ' . tablename('ewei_shop_goods') . 'WHERE uniacid = :uniacid AND status = \'1\' AND deleted = 0 AND title LIKE \'%' . $_GPC['search'] . '%\'', array(':uniacid' => $_W['uniacid']));
		}

		$pager = pagination2($count['COUNT(*)'], $page, $psize);
		include $this->template();
	}

	public function act()
	{
		global $_W;
		global $_GPC;
		$if_act_swi = true;
		$id = (int) $_GPC['id'];

		if (isset($_GPC['end_price'])) {
			$end_price = (double) $_GPC['end_price'];
		}

		$myself = intval($_GPC['myself']);
		$get_this_goods_sql = 'SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id';
		$this_goods = pdo_fetch($get_this_goods_sql, array(':id' => $id));
		$temp = pdo_get('ewei_shop_goods', array('id' => $this_goods['id']), array('bargain'));

		if (!empty($_W['ispost'])) {
			$if_act_swi = false;
		}

		if (!empty($end_price) || $end_price === 0) {
			$market_price = (double) $_GPC['marketprice'];

			if ($market_price < $end_price) {
				show_json(0, '底价不得高于标价!');
			}

			$dispaly = (int) $_GPC['display'];
			$order_set = (int) $_GPC['order_set'];
			$initiate = (int) $_GPC['initiate'];
			$act_time = $_GPC['act_time'];
			$time_limit = (int) $_GPC['time_limit'];
			$total_time = (int) $_GPC['total_time'];
			$each_time = (int) $_GPC['each_time'];
			$rand_left = $_GPC['rand_left'];
			$rand_right = $_GPC['rand_right'];
			$rand = $_GPC['rand'];
			$rand_sum = 0;
			$i = 0;

			while ($i < count($rand)) {
				$rand_sum += $rand[$i];
				++$i;
			}

			if ($rand_sum != 100) {
				show_json(0, '概率相加必须为100%');
			}

			$goods_share_title = $_GPC['goods_share_title'];
			$goods_share_describe = $_GPC['goods_share_describe'];
			$bargain_share_title = $_GPC['bargain_share_title'];
			$bargain_share_describe = $_GPC['bargain_share_describe'];
			$bargain_share_logo = $_GPC['bargain_share_logo'];
			$user_set_arr = array('bargain_title' => $bargain_share_title, 'bargain_content' => $bargain_share_describe, 'bargain_logo' => $bargain_share_logo, 'goods_title' => $goods_share_title, 'goods_content' => $goods_share_describe, 'goods_logo' => $goods_share_logo);
			$user_set_json = json_encode($user_set_arr);
			$user_set_json = urlencode($user_set_json);

			if (!empty($_GPC)) {
				$rule = NULL;
			}
			else {
				$rule = $_GPC['rule'];
			}

			$countdown = $_GPC['countdown'];
			$countdown_color = $_GPC['countdown_color'];
			$cutmore = $_GPC['cutmore'];
			$cutmore_color = $_GPC['cutmore_color'];
			$btn_color = $_GPC['btn_color'];
			$maximum = $_GPC['total_act'];
			$custom = json_encode(array('countdown' => $countdown, 'countdown_color' => $countdown_color, 'cutmore' => $cutmore, 'cutmore_color' => $cutmore_color, 'btn_color' => $btn_color));
			$custom = urlencode($custom);
			$rand_arr['min'] = $rand_left;
			$rand_arr['max'] = $rand_right;
			$rand_arr['rand'] = $rand;
			$rand_json = json_encode($rand_arr);
			$data = array('myself' => $myself, 'account_id' => $_W['uniacid'], 'goods_id' => $this_goods['id'], 'end_price' => $end_price, 'start_time' => $act_time['start'], 'end_time' => $act_time['end'], 'status' => 0, 'type' => $dispaly, 'user_set' => $user_set_json, 'rule' => $rule, 'act_times' => '0', 'mode' => $order_set, 'total_time' => $total_time, 'each_time' => $each_time, 'time_limit' => $time_limit, 'probability' => $rand_json, 'custom' => $custom, 'maximum' => $maximum, 'initiate' => $initiate);
			$res = pdo_insert('ewei_shop_bargain_goods', $data);
			$redirect_id = pdo_insertid();

			if ($res) {
				$bargain_goods_id = pdo_insertid();
				$save_res = pdo_update('ewei_shop_goods', array('bargain' => $bargain_goods_id), array('id' => $this_goods['id']));

				if (empty($save_res)) {
					show_json(0, '保存失败');
				}
				else {
					show_json(1, '保存成功');
				}
			}

			unset($_GPC['end_price']);
		}
		else {
			include $this->template();
		}
	}

	public function react()
	{
		global $_W;
		global $_GPC;
		$actid = (int) $_GPC['actid'];
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_bargain_goods') . ' WHERE id = :id';
		$this_act = pdo_fetch($sql, array(':id' => $actid));
		$id = $this_act['goods_id'];

		if ($_W['ispost']) {
			$end_price = (double) $_GPC['end_price'];
		}

		$myself = intval($_GPC['myself']);
		$this_act['user_set'] = urldecode($this_act['user_set']);
		$user_set = json_decode($this_act['user_set'], ture);
		$tt = json_decode($this_act['probability'], true);
		$get_this_goods_sql = 'SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id';
		$this_goods = pdo_fetch($get_this_goods_sql, array(':id' => $id));
		if (!empty($end_price) || $end_price === 0) {
			$market_price = (double) $_GPC['marketprice'];

			if ($market_price < $end_price) {
				show_json(0, '底价不得高于标价!');
			}

			$dispaly = (int) $_GPC['display'];
			$order_set = (int) $_GPC['order_set'];
			$act_time = $_GPC['act_time'];
			$time_limit = (int) $_GPC['time_limit'];
			$total_time = (int) $_GPC['total_time'];
			$each_time = (int) $_GPC['each_time'];
			$rand_left = $_GPC['rand_left'];
			$rand_right = $_GPC['rand_right'];
			$rand = $_GPC['rand'];
			$rand_sum = 0;
			$i = 0;

			while ($i < count($rand)) {
				$rand_sum += $rand[$i];
				++$i;
			}

			if ($rand_sum != 100) {
				show_json(0, '概率相加必须为100%');
			}

			$goods_share_title = $_GPC['goods_share_title'];
			$goods_share_describe = $_GPC['goods_share_describe'];
			$goods_share_logo = $_GPC['goods_share_logo'];
			$bargain_share_title = $_GPC['bargain_share_title'];
			$bargain_share_describe = $_GPC['bargain_share_describe'];
			$bargain_share_logo = $_GPC['bargain_share_logo'];
			$user_set_arr = array('bargain_title' => $bargain_share_title, 'bargain_content' => $bargain_share_describe, 'bargain_logo' => $bargain_share_logo, 'goods_title' => $goods_share_title, 'goods_content' => $goods_share_describe, 'goods_logo' => $goods_share_logo);
			$user_set_json = json_encode($user_set_arr);
			$user_set_json = urlencode($user_set_json);

			if (!empty($_GPC['bang_swi'])) {
				$rule = NULL;
			}
			else {
				$rule = $_GPC['rule'];
			}

			$countdown = $_GPC['countdown'];
			$countdown_color = $_GPC['countdown_color'];
			$cutmore = $_GPC['cutmore'];
			$cutmore_color = $_GPC['cutmore_color'];
			$btn_color = $_GPC['btn_color'];
			$maximum = $_GPC['total_act'];
			$custom = json_encode(array('countdown' => $countdown, 'countdown_color' => $countdown_color, 'cutmore' => $cutmore, 'cutmore_color' => $cutmore_color, 'btn_color' => $btn_color));
			$custom = urlencode($custom);
			$rand_arr['min'] = $rand_left;
			$rand_arr['max'] = $rand_right;
			$rand_arr['rand'] = $rand;
			$rand_json = json_encode($rand_arr);
			$data = array('myself' => $myself, 'account_id' => $_W['uniacid'], 'goods_id' => $this_goods['id'], 'end_price' => $end_price, 'start_time' => $act_time['start'], 'end_time' => $act_time['end'], 'status' => 0, 'type' => $dispaly, 'user_set' => $user_set_json, 'rule' => $rule, 'mode' => $order_set, 'total_time' => $total_time, 'each_time' => $each_time, 'time_limit' => $time_limit, 'probability' => $rand_json, 'custom' => $custom, 'maximum' => $maximum);
			$res = pdo_update('ewei_shop_bargain_goods', $data, array('id' => $actid));
			show_json(1, '保存成功');
			unset($_GPC['end_price']);
		}
		else {
			$this_act['custom'] = urldecode($this_act['custom']);
			$this_act['custom'] = json_decode($this_act['custom'], true);
			include $this->template();
		}
	}

	public function huishou()
	{
		global $_GPC;
		global $_W;
		$id = (int) $_GPC['id'];
		pdo_update('ewei_shop_bargain_goods', array('status' => 1), array('account_id' => $_W['uniacid'], 'id' => $id, 'status' => 0));
		$goods_id = pdo_get('ewei_shop_bargain_goods', array('id' => $id), array('goods_id'));
		pdo_query('UPDATE ' . tablename('ewei_shop_goods') . ' SET bargain=0 WHERE id =:id', array(':id' => $goods_id['goods_id']));
		show_json(1, '已经放到回收站');
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];

		if (empty($id)) {
			show_json(0);
		}

		$bargain_goods = pdo_get('ewei_shop_bargain_goods', array('id' => $id, 'account_id' => $_W['uniacid']));

		if (empty($bargain_goods)) {
			show_json(0);
		}

		$res = pdo_delete('ewei_shop_bargain_goods', array('id' => $id, 'account_id' => $_W['uniacid']));

		if (!$res) {
			show_json(0);
		}

		pdo_update('ewei_shop_goods', array('bargain' => 0), array('id' => $bargain_goods['goods_id'], 'uniacid' => $_W['uniacid']));
		show_json('1', '删除成功');
	}

	public function set()
	{
		global $_W;
		global $_GPC;
		load()->func('tpl');
		$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_account') . ' WHERE id = :id', array(':id' => $_W['uniacid']));
		$template_list = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$mall_name = $_GPC['shop'];
			$banner = $_GPC['banner'];
			$mall_title = $_GPC['mall_title'];
			$mall_content = $_GPC['mall_content'];
			$mall_logo = $_GPC['mall_logo'];
			pdo_update('ewei_shop_bargain_account', array('mall_name' => $mall_name, 'banner' => $banner, 'mall_title' => $mall_title, 'mall_content' => $mall_content, 'mall_logo' => $mall_logo), array('id' => $_W['uniacid']));
			show_json(1, '保存成功');
			return NULL;
		}

		include $this->template();
	}

	public function messageset()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('notice', false);
		$salers = array();

		if (isset($data['openid'])) {
			if (!empty($data['openid'])) {
				$openids = array();
				$strsopenids = explode(',', $data['openid']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		if ($_W['ispost']) {
			ca('sysset.notice.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (is_array($_GPC['openids'])) {
				$data['openid'] = implode(',', $_GPC['openids']);
			}
			else {
				$data['openid'] = '';
			}

			if (empty($data['willcancel_close_advanced'])) {
				$uniacids = m('cache')->get('willcloseuniacid', 'global');

				if (!is_array($uniacids)) {
					$uniacids = array();
				}

				if (!in_array($_W['uniacid'], $uniacids)) {
					$uniacids[] = $_W['uniacid'];
					m('cache')->set('willcloseuniacid', $uniacids, 'global');
				}
			}
			else {
				$uniacids = m('cache')->get('willcloseuniacid', 'global');

				if (is_array($uniacids)) {
					if (in_array($_W['uniacid'], $uniacids)) {
						$datas = array();

						foreach ($uniacids as $uniacid) {
							if ($uniacid != $_W['uniacid']) {
								$datas[] = $uniacid;
							}
						}

						m('cache')->set('willcloseuniacid', $datas, 'global');
					}
				}
			}

			m('common')->updateSysset(array('notice' => $data));
			show_json(1);
		}

		$template_list = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_list as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		include $this->template();
	}

	public function otherset()
	{
		global $_W;
		global $_GPC;
		$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_account') . ' WHERE id = :id', array(':id' => $_W['uniacid']));
		$template_list = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$rule = $_GPC['rule'];
			$swi = $_GPC['bang_swi'];
			$partin = intval($_GPC['money_limit']);
			$follow_swi = intval($_GPC['follow_swi']);

			if (empty($swi)) {
				$partin = -10000;
			}

			pdo_update('ewei_shop_bargain_account', array('partin' => $partin, 'rule' => $rule, 'follow_swi' => $follow_swi, 'sharestyle' => intval($_GPC['sharestyle'])), array('id' => $_W['uniacid']));
			show_json(1, '保存成功');
			return NULL;
		}

		if ($res['partin'] == -10000) {
			$res['partin'] = NULL;
		}

		include $this->template();
	}

	public function startnow()
	{
		global $_GPC;
		global $_W;
		$id = (int) $_GPC['id'];
		pdo_update('ewei_shop_bargain_goods', array('start_time' => date('Y-m-d H:i:s', time())), array('account_id' => $_W['uniacid'], 'id' => $id));
		show_json(1, '已开始');
	}
}

?>
