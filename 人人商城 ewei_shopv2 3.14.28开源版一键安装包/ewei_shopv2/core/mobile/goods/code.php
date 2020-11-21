<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Code_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$goodsid = intval($_GPC['goodsid']);
		$codegoods = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goodscode_good') . ' WHERE
            uniacid = ' . $uniacid . ' and goodsid = ' . $goodsid . ' and id = ' . $id . ' and status = 1 ');

		if (empty($codegoods)) {
			$this->message(array('message' => '该商品不存在或已删除'), mobileUrl(''), 'error');
		}

		$goods = pdo_fetch('SELECT title,content FROM ' . tablename('ewei_shop_goods') . ' WHERE
            uniacid = ' . $uniacid . ' and id = ' . $goodsid . ' and deleted=0 and status = 1 ');

		if (empty($goods)) {
			$this->message(array('message' => '该商品不存在或已删除'), mobileUrl(''), 'error');
		}

		$goods['content'] = m('ui')->lazy($goods['content']);
		include $this->template();
	}
}

?>
