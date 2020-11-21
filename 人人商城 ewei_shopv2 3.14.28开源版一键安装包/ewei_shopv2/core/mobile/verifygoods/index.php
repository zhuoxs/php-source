<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$cate = trim($_GPC['cate']);

		if (!empty($cate)) {
			if ($cate == 'used') {
				$used = 1;
			}
			else {
				$past = 1;
			}
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$time = time();
		$sql = 'select vg.*,g.title,g.subtitle,g.thumb,c.card_id  from ' . tablename('ewei_shop_verifygoods') . '   vg
		 inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 left  join ' . tablename('ewei_shop_order') . ' o on vg.orderid = o.id
		 left  join ' . tablename('ewei_shop_order_refund') . ' orf on o.refundid = orf.id
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 left  join ' . tablename('ewei_shop_goods_cards') . ' c on c.id = g.cardid
		 where   vg.uniacid=:uniacid and vg.openid=:openid and vg.invalid =0 and (o.refundid=0 or orf.status<0) and o.status>0';

		if (!empty($past)) {
			$sql .= ' and  ((vg.limittype=0   and vg.limitdays * 86400 + vg.starttime <' . $time . ' )or ( vg.limittype=1   and vg.limitdate <' . $time . ' )) and vg.used < 1';
		}
		else if (!empty($used)) {
			$sql .= ' and vg.used =1';
		}
		else {
			if (empty($used)) {
				$sql .= ' and   ((vg.limittype=0   and vg.limitdays * 86400 + vg.starttime >=' . $time . ' )or ( vg.limittype=1   and vg.limitdate >=' . $time . ' ))  and  vg.used =0  ';
			}
		}

		$total = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
		$sql .= ' order by vg.starttime desc  LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$verifygoods = set_medias(pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $openid)), 'thumb');

		if (empty($verifygoods)) {
			$verifygoods = array();
		}

		foreach ($verifygoods as $i => &$row) {
			$verifygoodlogs = pdo_fetchall('select *  from ' . tablename('ewei_shop_verifygoods_log') . '    where verifygoodsid =:id  ', array(':id' => $row['id']));
			$verifynum = 0;

			foreach ($verifygoodlogs as $verifygoodlog) {
				$verifynum += intval($verifygoodlog['verifynum']);
			}

			$row['numlimit'] = 0;

			if (empty($row['limitnum'])) {
				if (empty($row['limittype'])) {
					$surplusdays = (intval($row['starttime']) + $row['limitdays'] * 86400 - time()) / 86400;
				}
				else {
					$surplusdays = (intval($row['limitdate']) - time()) / 86400;
				}

				if (0 < $surplusdays) {
					$row['surplusnum'] = intval($surplusdays);
				}
				else {
					$row['surplusnum'] = '<span style=\'font-size: 1rem\'>已过期</span>';
					$row['expired'] = 1;
				}
			}
			else {
				$row['numlimit'] = 1;
				$num = intval($row['limitnum']) - $verifynum;

				if (0 < $num) {
					$row['surplusnum'] = $num;
				}
				else {
					$row['surplusnum'] = '<span style=\'font-size: 1rem\'>已使用</span>';
				}
			}

			if (empty($row['limittype'])) {
				$row['termofvalidity'] = date('Y-m-d H:i', intval($row['starttime']) + $row['limitdays'] * 86400);
			}
			else {
				$row['termofvalidity'] = date('Y-m-d H:i', $row['limitdate']);
			}

			if (empty($cate)) {
				$row['canuse'] = 1;
			}

			if (is_weixin()) {
				if (!empty($row['card_id']) && empty($row['activecard'])) {
					$row['cangetcard'] = 1;
				}
			}

			if (!empty($past)) {
				$row['expired'] = 1;
			}
		}

		unset($row);
		show_json(1, array('list' => $verifygoods, 'pagesize' => $psize, 'total' => $total));
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$cansee = 1;
		if (!empty($_GPC['card_id']) && !empty($_GPC['encrypt_code']) && !empty($_GPC['openid'])) {
			if ($openid != $_GPC['openid']) {
				header('location: ' . mobileUrl('verifygoods'));
			}

			$card_id = $_GPC['card_id'];
			$encrypt_code = $_GPC['encrypt_code'];
			$data = com_run('wxcard::wxCardCodeDecrypt', $encrypt_code);
			if (empty($data) || is_wxerror($data)) {
				header('location: ' . mobileUrl('verifygoods'));
			}

			$code = $data['code'];
			$item = pdo_fetch('select vg.*,g.title,g.subtitle,g.thumb  from ' . tablename('ewei_shop_verifygoods') . '   vg
		 inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 left  join ' . tablename('ewei_shop_order') . ' o on vg.orderid = o.id
		 left  join ' . tablename('ewei_shop_order_refund') . ' orf on o.refundid = orf.id
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 inner  join ' . tablename('ewei_shop_goods_cards') . ' c on c.id = g.cardid
		 where   vg.uniacid=:uniacid and vg.openid=:openid and vg.invalid =0  and c.card_id =:card_id and vg.cardcode=:cardcode and (o.refundid=0 or orf.status<0) and o.status>0  limit 1', array(':uniacid' => $uniacid, ':openid' => $openid, ':card_id' => $card_id, ':cardcode' => $code));

			if (empty($item)) {
				header('location: ' . mobileUrl('verifygoods'));
			}

			$id = $item['id'];
		}
		else {
			$id = $_GPC['id'];
			$item = pdo_fetch('select vg.*,g.title,g.subtitle,g.thumb  from ' . tablename('ewei_shop_verifygoods') . '   vg
		 inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 left  join ' . tablename('ewei_shop_order') . ' o on vg.orderid = o.id
		 left  join ' . tablename('ewei_shop_order_refund') . ' orf on o.refundid = orf.id
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 where  vg.id =:id and vg.uniacid=:uniacid and vg.openid=:openid and vg.invalid =0 and (o.refundid=0 or orf.status<0) and o.status>0 limit 1', array(':id' => $id, ':uniacid' => $uniacid, ':openid' => $openid));
		}

		if (empty($item)) {
			header('location: ' . mobileUrl('verifygoods'));
		}

		if (empty($item['limittype'])) {
			$limitdate = intval($item['starttime']) + intval($item['limitdays']) * 86400;
		}
		else {
			$limitdate = intval($item['limitdate']);
		}

		if ($limitdate < time()) {
			$cansee = 2;
		}

		$limitdatestr = date('Y-m-d H:i', $limitdate);
		$verifygoodlogs = pdo_fetchall('select vgl.*,s.storename,sa.salername  from ' . tablename('ewei_shop_verifygoods_log') . '   vgl
		left  join ' . tablename('ewei_shop_store') . ' s on s.id = vgl.storeid
		left  join ' . tablename('ewei_shop_saler') . ' sa on sa.id = vgl.salerid
          where  vgl.verifygoodsid =:id order by vgl.verifydate desc ', array(':id' => $id));
		$verifynum = 0;

		foreach ($verifygoodlogs as &$verifygoodlog) {
			if (empty($verifygoodlog['storename'])) {
				$verifygoodlog['storename'] = $_W['shopset']['shop']['name'];
			}

			$verifynum += intval($verifygoodlog['verifynum']);
		}

		unset($verifygoodlog);

		if (!empty($item['limitnum'])) {
			if (intval($item['limitnum']) <= $verifynum) {
				$cansee = 3;
			}
		}

		if ($item['used'] == 1) {
			$cansee = 3;
		}

		$verifycode = $item['verifycode'];
		if (empty($verifycode) || $item['codeinvalidtime'] < time()) {
			$verifycode = '8' . random(8, true);

			while (1) {
				$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_verifygoods') . ' where verifycode=:verifycode and uniacid=:uniacid limit 1', array(':verifycode' => $verifycode, ':uniacid' => $_W['uniacid']));

				if ($count <= 0) {
					break;
				}

				$verifycode = random(8, true);
			}

			$data = array('verifycode' => $verifycode, 'codeinvalidtime' => time() + 1800);
			pdo_update('ewei_shop_verifygoods', $data, array('id' => $item['id']));
		}

		$query = array('id' => $item['id'], 'verifycode' => $verifycode);
		$url = mobileUrl('verify/verifygoods/detail', $query, true);
		$qrurl = m('qrcode')->createQrcode($url);

		if (strlen($verifycode) == 8) {
			$verifycode = substr($verifycode, 0, 4) . ' ' . substr($verifycode, 4, 4);
		}
		else {
			if (strlen($verifycode) == 9) {
				$verifycode = substr($verifycode, 0, 3) . ' ' . substr($verifycode, 3, 3) . ' ' . substr($verifycode, 6, 3);
			}
		}

		$goodsstore = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['storeid'], ':uniacid' => $_W['uniacid']));
		include $this->template();
	}

	public function activecard()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$card_id = $_GPC['card_id'];
		$encrypt_code = $_GPC['encrypt_code'];
		$code = '';
		if (empty($card_id) || empty($encrypt_code)) {
		}

		$data = com_run('wxcard::wxCardCodeDecrypt', $encrypt_code);
		if (empty($data) || is_wxerror($data)) {
			$this->message(array('message' => '激活链接错误!', 'title' => '激活链接错误!', 'buttondisplay' => true), mobileUrl('verifygoods'), 'error');
		}

		$code = $data['code'];
		$sql = 'select vg.*,g.title,g.subtitle,g.thumb,c.card_id  from ' . tablename('ewei_shop_verifygoods') . '   vg
		 inner join ' . tablename('ewei_shop_order_goods') . ' og on vg.ordergoodsid = og.id
		 inner join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id
		 left  join ' . tablename('ewei_shop_goods_cards') . ' c on c.id = g.cardid
		 where   vg.uniacid=:uniacid and vg.openid=:openid and vg.invalid =0
		 and ((vg.limittype=0   and vg.limitdays * 86400 + vg.starttime >=unix_timestamp() )or ( vg.limittype=1   and vg.limitdate >=unix_timestamp() ))  and  vg.used =0  and (vg.activecard=0 or vg.activecard is null) and g.cardid>0  and c.card_id=:card_id';
		$verifygoods = set_medias(pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':card_id' => $card_id)), 'thumb');

		if (empty($verifygoods)) {
			$good = com_run('wxcard::getgoodidbycardid', $card_id);

			if (empty($good)) {
				$this->message(array('message' => '激活链接错误!', 'title' => '激活链接错误!', 'buttondisplay' => true), mobileUrl('verifygoods'), 'error');
			}
			else {
				$this->message(array('message' => '请先购买此商品!', 'title' => '请先购买此商品!', 'buttondisplay' => true), mobileUrl('goods/detail', array('id' => $good['id'])), '');
			}
		}

		foreach ($verifygoods as $i => &$row) {
			$verifygoodlogs = pdo_fetchall('select *  from ' . tablename('ewei_shop_verifygoods_log') . '    where verifygoodsid =:id  ', array(':id' => $row['id']));
			$verifynum = 0;

			foreach ($verifygoodlogs as $verifygoodlog) {
				$verifynum += intval($verifygoodlog['verifynum']);
			}

			if (empty($row['limitnum'])) {
				$row['surplusnum'] = '不限';
			}
			else {
				$num = intval($row['limitnum']) - $verifynum;
				$row['surplusnum'] = $num . '次';
			}

			if (empty($row['limittype'])) {
				$row['termofvalidity'] = date('Y-m-d H:i', intval($row['starttime']) + $row['limitdays'] * 86400);
			}
			else {
				$row['termofvalidity'] = date('Y-m-d H:i', $row['limitdate']);
			}

			if (!empty($row['card_id']) && empty($row['getcard'])) {
				$row['cangetcard'] = 1;
			}
		}

		unset($row);
		include $this->template();
	}

	public function active()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$card_id = $_GPC['card_id'];
		$encrypt_code = $_GPC['encrypt_code'];
		$code = '';
		$id = $_GPC['id'];
		if (empty($card_id) || empty($encrypt_code) || empty($id)) {
			$this->message(array('message' => '激活链接错误!', 'title' => '激活链接错误!', 'buttondisplay' => true), mobileUrl('verifygoods'), 'error');
		}

		$data = com_run('wxcard::wxCardCodeDecrypt', $encrypt_code);
		if (empty($data) || is_wxerror($data)) {
			$this->message(array('message' => '激活链接错误!', 'title' => '激活链接错误!', 'buttondisplay' => true), mobileUrl('verifygoods'), 'error');
		}

		$code = $data['code'];
		$result = com_run('wxcard::ActivateVerifygoodCard', $id, $card_id, $code, $openid);

		if ($result) {
			$redirect = mobileUrl('verifygoods/detail', array('id' => $id));
			$this->message(array('message' => '您的核销卡已成功激活!', 'title' => '激活成功!', 'buttondisplay' => true), $redirect, 'success');
		}
		else {
			$this->message(array('message' => '激活链接错误!', 'title' => '激活链接错误!', 'buttondisplay' => true), mobileUrl('verifygoods'), 'error');
		}
	}
}

?>
