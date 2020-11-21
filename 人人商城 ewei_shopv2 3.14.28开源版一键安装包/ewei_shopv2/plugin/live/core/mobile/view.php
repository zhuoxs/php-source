<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class View_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$openid = trim($_W['openid']);
		$follows = pdo_fetchall('select * from ' . tablename('ewei_shop_live_view') . ' where uniacid = ' . $uniacid . ' and openid = \'' . $openid . '\' ');
		$shop = m('common')->getSysset('shop');
		$setting = pdo_fetch('select * from ' . tablename('ewei_shop_live_setting') . ' where uniacid = :uniacid  ', array(':uniacid' => $uniacid));
		$_W['shopshare'] = array('title' => !empty($setting['share_title']) ? $setting['share_title'] : $shop['name'], 'imgUrl' => !empty($setting['share_icon']) ? tomedia($setting['share_icon']) : tomedia($shop['logo']), 'link' => !empty($setting['share_url']) ? $setting['share_url'] : mobileUrl('live', array(), true), 'desc' => !empty($setting['share_desc']) ? $setting['share_desc'] : $shop['description']);
		include $this->template();
	}

	public function get_view()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$openid = trim($_W['openid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and lv.uniacid = :uniacid and lv.openid = \'' . $openid . '\' ';
		$params = array(':uniacid' => $_W['uniacid']);
		$sql = 'SELECT COUNT(1) FROM ' . tablename('ewei_shop_live_view') . ' as lv
                    right join ' . tablename('ewei_shop_live') . (' as l on l.id = lv.roomid and l.uniacid = lv.uniacid
            		where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT l.id,l.title,l.thumb,l.livetime,l.subscribe,l.living FROM ' . tablename('ewei_shop_live_view') . ' as lv
                    right join ' . tablename('ewei_shop_live') . ' as l on l.id = lv.roomid
            		where 1 ' . $condition . ' ORDER BY lv.viewing DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb');

			foreach ($list as $key => $value) {
				$list[$key]['livetime'] = date('Y-m-d H:i:s', $value['livetime']);
			}

			unset($row);
		}

		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}
}

?>
