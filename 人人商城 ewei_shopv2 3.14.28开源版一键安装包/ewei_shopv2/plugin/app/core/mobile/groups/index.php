<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_groups_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$advs = set_medias($advs, 'thumb');
		$category = pdo_fetchall('select id,name,thumb from ' . tablename('ewei_shop_groups_category') . ' where uniacid=:uniacid and  enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$category = set_medias($category, 'thumb');
		$recgoods = pdo_fetchall('select id,title,thumb,thumb_url,price,groupnum,groupsprice,isindex,goodsnum,units,sales,description,is_ladder,more_spec from ' . tablename('ewei_shop_groups_goods') . '
					where uniacid=:uniacid and isindex = 1 and status=1 and deleted=0 order by displayorder desc,id DESC limit 20', array(':uniacid' => $uniacid));
		$recgoods = set_medias($recgoods, 'thumb');
		return app_json(array('advs' => $advs, 'category' => $category, 'recgoods' => $recgoods));
	}
}

?>
