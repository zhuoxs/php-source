<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
require EWEI_SHOPV2_PLUGIN . 'merchmanage/core/inc/page_merchmanage.php';
class Index_EweiShopV2Page extends MerchmanageMobilePage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$merchid = $_W['merchmanage']['merchid'];
		$item = p('merch')->getMerchPrice($merchid, 1);
		$list = p('merch')->getMerchPriceList($merchid);
		$order_num = count($list);
		$cansettle = true;
		if ($item['realpricerate'] <= 0) {
			$cansettle = false;
		}
		#提现方式
		$set = m('common')->getPluginset('merch');
		if (empty($set)) 
		{
			$set = p('merch')->getPluginsetByMerch('merch');
		}
		$last_data = $this->getLastApply($merchid);
		$type_array = array();
		if ($set['applycashweixin'] == 1) 
		{
			$type_array[0]['title'] = '提现到微信钱包';
		}
		if ($set['applycashalipay'] == 1) 
		{
			$type_array[2]['title'] = '提现到支付宝';
			if (!(empty($last_data))) 
			{
				if ($last_data['applytype'] != 2) 
				{
					$type_last = $this->getLastApply($merchid, 2);
					if (!(empty($type_last))) 
					{
						$last_data['alipay'] = $type_last['alipay'];
					}
				}
			}
		}
		if ($set['applycashcard'] == 1) 
		{
			$type_array[3]['title'] = '提现到银行卡';
			if (!(empty($last_data))) 
			{
				if ($last_data['applytype'] != 3) 
				{
					$type_last = $this->getLastApply($merchid, 3);
					if (!(empty($type_last))) 
					{
						$last_data['bankname'] = $type_last['bankname'];
						$last_data['bankcard'] = $type_last['bankcard'];
					}
				}
			}
			$condition = ' and uniacid=:uniacid';
			$params = array(':uniacid' => $_W['uniacid']);
			$banklist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_bank') . ' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC', $params);
		}
		if (!(empty($last_data))) 
		{
			if (array_key_exists($last_data['applytype'], $type_array)) 
			{
				$type_array[$last_data['applytype']]['checked'] = 1;
			}
		}
		#提交结算
		if ($_W['ispost']) 
		{
			if (($item['realprice'] <= 0) || empty($list)) 
			{
				show_json(0, '您没有可提现的金额');
			}
			$applytype = intval($_GPC['applytype']);
			if (!(array_key_exists($applytype, $type_array))) 
			{
				show_json(0, '未选择提现方式，请您选择提现方式后重试!');
			}
			$insert = array();
			if ($applytype == 2) 
			{
				$realname = trim($_GPC['realname']);
				$alipay = trim($_GPC['alipay']);
				$alipay1 = trim($_GPC['alipay1']);
				if (empty($realname)) 
				{
					show_json(0, '请填写姓名!');
				}
				if (empty($alipay)) 
				{
					show_json(0, '请填写支付宝帐号!');
				}
				if (empty($alipay1)) 
				{
					show_json(0, '请填写确认帐号!');
				}
				if ($alipay != $alipay1) 
				{
					show_json(0, '支付宝帐号与确认帐号不一致!');
				}
				$insert['applyrealname'] = $realname;
				$insert['alipay'] = $alipay;
			}
			else if ($applytype == 3) 
			{
				$realname = trim($_GPC['realname']);
				$bankname = trim($_GPC['bankname']);
				$bankcard = trim($_GPC['bankcard']);
				$bankcard1 = trim($_GPC['bankcard1']);
				if (empty($realname)) 
				{
					show_json(0, '请填写姓名!');
				}
				if (empty($bankname)) 
				{
					show_json(0, '请选择银行!');
				}
				if (empty($bankcard)) 
				{
					show_json(0, '请填写银行卡号!');
				}
				if (empty($bankcard1)) 
				{
					show_json(0, '请填写确认卡号!');
				}
				if ($bankcard != $bankcard1) 
				{
					show_json(0, '银行卡号与确认卡号不一致!');
				}
				$insert['applyrealname'] = $realname;
				$insert['bankname'] = $bankname;
				$insert['bankcard'] = $bankcard;
			}
			$insert['uniacid'] = $_W['uniacid'];
			$insert['merchid'] = $merchid;
			$insert['applyno'] = m('common')->createNO('merch_bill', 'applyno', 'MO');
			$insert['orderids'] = iserializer($item['orderids']);
			$insert['ordernum'] = $order_num;
			$insert['price'] = $item['price'];
			$insert['realprice'] = $item['realprice'];
			$insert['realpricerate'] = $item['realpricerate'];
			$insert['finalprice'] = $item['finalprice'];
			$insert['orderprice'] = $item['orderprice'];
			$insert['payrateprice'] = round(($item['realpricerate'] * $item['payrate']) / 100, 2);
			$insert['payrate'] = $item['payrate'];
			$insert['applytime'] = time();
			$insert['status'] = 1;
			$insert['applytype'] = $applytype;
			
			pdo_insert('ewei_shop_merch_bill', $insert);
			$billid = pdo_insertid();
			foreach ($list as $k => $v ) 
			{
				$orderid = $v['id'];
				$insert_data = array();
				$insert_data['uniacid'] = $_W['uniacid'];
				$insert_data['billid'] = $billid;
				$insert_data['orderid'] = $orderid;
				$insert_data['ordermoney'] = $v['realprice'];
				pdo_insert('ewei_shop_merch_billo', $insert_data);
				$change_order_data = array();
				$change_order_data['merchapply'] = 1;
				pdo_update('ewei_shop_order', $change_order_data, array('id' => $orderid));
			}
			$merch_user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where uniacid=:uniacid and id=' . $merchid, array(':uniacid' => $_W['uniacid']));
			p('merch')->sendMessage(array('merchname' => $merch_user['merchname'], 'money' => $insert['realprice'], 'realname' => $merch_user['realname'], 'mobile' => $merch_user['mobile'], 'applytime' => time()), 'merch_apply_money');
			show_json(1, array('url' => referer()));
		}
		include $this->template();
	}
	public function getLastApply($merchid, $applytype = -1) 
	{
		global $_W;
		$params = array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid);
		$sql = 'select applytype,alipay,bankname,bankcard,applyrealname from ' . tablename('ewei_shop_merch_bill') . ' where merchid=:merchid and uniacid=:uniacid';
		if (-1 < $applytype) 
		{
			$sql .= ' and applytype=:applytype';
			$params[':applytype'] = $applytype;
		}
		$sql .= ' order by id desc Limit 1';
		$data = pdo_fetch($sql, $params);
		return $data;
	}
	#申请列表
	public function manage()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}
	public function get_list()
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid']);
		$merchid = $_W['merchmanage']['merchid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$status = trim($_GPC['status']);
		empty($status) && ($status = 1);

		$condition = ' and b.uniacid=:uniacid and b.status=:status and b.merchid=:merchid';
		$params = array(':uniacid' => $_W['uniacid'], ':status' => $status, ':merchid' => $merchid);
		
		
		
		$apply_type = array(0 => '微信钱包', 2 => '支付宝', 3 => '银行卡');

		
		$sql = 'select b.* from ' . tablename('ewei_shop_merch_bill') . ' b ' . ' left join ' . tablename('ewei_shop_merch_user') . ' u on b.merchid = u.id' . ' where 1 ' . $condition . ' ORDER BY applytime desc ';
		
		$sql .= '  limit ' . (($pindex - 1) * $psize) . ',' . $psize;
		
		$list = pdo_fetchall($sql, $params);

		$total = pdo_fetchcolumn('select count(b.id) from' . tablename('ewei_shop_merch_bill') . ' b ' . ' left join ' . tablename('ewei_shop_merch_user') . ' u on b.merchid = u.id' . ' where 1 ' . $condition, $params);

		foreach ($list as &$row ) {
			if ($row['status'] == 1) {
				$row['statusstr'] = '待审核';
				$row['applytime'] = date('Y-m-d H:i', $row['applytime']);
			}else if ($row['status'] == 2) {
				$row['statusstr'] = '待结算';
				$row['checktime'] = date('Y-m-d H:i', $row['checktime']);
			}else if ($row['status'] == 3) {
				$row['statusstr'] = '已结算';
				$row['paytime'] = date('Y-m-d H:i', $row['paytime']);
			}else if ($row['status'] == -1) {
				$row['dealtime'] = date('Y-m-d H:i', $row['invalidtime']);
				$row['invalidtime'] = '无效';
			}

		}
		unset($row);
		show_json(1, array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}
}
?>