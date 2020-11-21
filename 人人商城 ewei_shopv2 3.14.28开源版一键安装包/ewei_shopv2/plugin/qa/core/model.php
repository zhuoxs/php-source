<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

define('PAGE_MEMBER', 0);
class QaModel extends PluginModel
{
	public function getSet()
	{
		global $_W;
		$set = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_qa_set') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));

		if (!empty($set)) {
			return $set;
		}
	}
}

?>
