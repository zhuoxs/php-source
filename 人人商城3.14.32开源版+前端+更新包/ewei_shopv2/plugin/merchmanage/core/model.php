<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

class MerchmanageModel extends PluginModel
{
	public function merch_user_single($arr = array())
	{
		global $_W;
		global $_GPC;
		$username = $arr['username'];
		if (empty($username)) {
			return;
		}
		$account = pdo_fetch('select * from '.tablename('ewei_shop_merch_account').' where username = "'.$username.'" and uniacid ="'.$_W['uniacid'].'" and isfounder = 1');
		return $account;
	}
	public function merch_user_check($arr = array())
	{
		global $_W;
		global $_GPC;
		$username = $arr['username'];
		$pwd = $arr['pwd'];
		if (empty($username) AND empty($pwd)) {
			return false;
		}
		$account = pdo_fetch('select * from '.tablename('ewei_shop_merch_account').' where username = "'.$username.'" and uniacid ="'.$_W['uniacid'].'" and isfounder = 1');
		if (empty($pwd)) {
			return true;
		}else{
			if (md5($pwd.$account['salt']) != $account['pwd']) {
				return false;
			}
		}
		
		
		return true;
	}
	public function getTotals($merch = 0) 
	{
		global $_W;
		$paras = array(':uniacid' => $_W['uniacid']);
		$merch = intval($merch);
		$condition = ' and isparent=0';
		if ($merch < 0) 
		{
			$condition .= ' and merchid=0';
		}else{
			$condition .= ' and merchid= "'.$merch.'"';
		}
		$totals['all'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . ' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0 and deleted=0', $paras);
		$totals['status_1'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . ' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0 and status=-1 and refundtime=0 and deleted=0', $paras);
		$totals['status0'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . ' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and status=0 and paytype<>3 and deleted=0', $paras);
		$totals['status1'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . ' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and ( status=1 or ( status=0 and paytype=3) ) and deleted=0', $paras);
		$totals['status2'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . ' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and ( status=2 or (status = 1 and sendtype > 0) ) and deleted=0', $paras);
		$totals['status3'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . ' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and status=3 and deleted=0', $paras);
		$totals['status4'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . ' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0  and refundstate>0 and refundid<>0 and deleted=0', $paras);
		$totals['status5'] = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_order') . '' . ' WHERE uniacid = :uniacid ' . $condition . ' and ismr=0 and refundtime<>0 and deleted=0', $paras);
		return $totals;
	}
	public function getMerchTotals($merchid) 
	{
		global $_W;
		return array(
			'sale' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . ' where status > 0 and checked=0 and deleted=0 and total>0 and uniacid=:uniacid and merchid =:merchid', array(':uniacid' => $_W['uniacid'],':merchid'=>$merchid)),
			'out' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . ' where status > 0 and deleted=0 and total=0 and uniacid=:uniacid and merchid =:merchid', array(':uniacid' => $_W['uniacid'],':merchid'=>$merchid)), 

			'stock' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . ' where (status=0 or checked=1) and deleted=0 and uniacid=:uniacid and merchid =:merchid', array(':uniacid' => $_W['uniacid'],':merchid'=>$merchid)), 

			'cycle' => pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_goods') . ' where deleted=1 and uniacid=:uniacid and merchid =:merchid', array(':uniacid' => $_W['uniacid'],':merchid'=>$merchid))
		);
	}
}


?>