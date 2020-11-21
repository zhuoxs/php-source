<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class BargainModel extends PluginModel
{
	public function checkFollowed()
	{
		global $_W;
		$res = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_bargain_account') . ' WHERE id = :id', array(':id' => $_W['uniacid']));

		if (empty($res['follow_swi'])) {
			return true;
		}

		$openid = $_W['openid'];
		$sql = 'SELECT `follow` FROM ' . tablename('mc_mapping_fans') . ' WHERE openid = :openid AND uniacid = :uniacid';
		$isFollowed = pdo_fetchcolumn($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid']));

		if (!empty($isFollowed)) {
			return true;
		}

		$sets = pdo_fetchcolumn('SELECT `sets` FROM ' . tablename('ewei_shop_sysset') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
		$qr = unserialize($sets);
		return array(0, tomedia($qr['share']['followqrcode']));
	}

	public function refuseJoin($goods_id)
	{
		global $_W;
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_bargain_actor') . ' WHERE openid = :openid AND account_id = :uniacid AND goods_id = :goods_id';
		return pdo_fetchcolumn($sql, array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid'], ':goods_id' => $goods_id));
	}
}

?>
