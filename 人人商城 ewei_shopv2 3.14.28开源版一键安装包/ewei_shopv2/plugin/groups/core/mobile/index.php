<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		try {
			$uniacid = $_W['uniacid'];
			$openid = $_W['openid'];
			$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_groups_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
			$advs = set_medias($advs, 'thumb');
			$category = pdo_fetchall('select id,name,thumb from ' . tablename('ewei_shop_groups_category') . ' where uniacid=:uniacid and  enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
			$category = set_medias($category, 'thumb');
			$recgoods = pdo_fetchall('select id,title,is_ladder,thumb,thumb_url,price,groupnum,groupsprice,isindex,goodsnum,units,sales,description from ' . tablename('ewei_shop_groups_goods') . 'where uniacid=:uniacid and isindex = 1 and status=1 and deleted=0 order by displayorder desc,id DESC limit 20', array(':uniacid' => $uniacid));
			$recgoods = set_medias($recgoods, 'thumb');
			$groupsset = pdo_fetch('SELECT followbar FROM ' . tablename('ewei_shop_groups_set') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $uniacid));
			$this->model->groupsShare();
			include $this->template();
		}
		catch (Exception $e) {
			$content = $e->getMessage();
			include $this->template('groups/error');
		}
	}
}

?>
