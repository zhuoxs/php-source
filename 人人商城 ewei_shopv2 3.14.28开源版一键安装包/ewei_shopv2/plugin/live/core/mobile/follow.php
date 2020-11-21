<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Follow_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$openid = trim($_W['openid']);
		$shop = m('common')->getSysset('shop');
		$setting = pdo_fetch('select * from ' . tablename('ewei_shop_live_setting') . ' where uniacid = :uniacid  ', array(':uniacid' => $uniacid));
		$_W['shopshare'] = array('title' => !empty($setting['share_title']) ? $setting['share_title'] : $shop['name'], 'imgUrl' => !empty($setting['share_icon']) ? tomedia($setting['share_icon']) : tomedia($shop['logo']), 'link' => !empty($setting['share_url']) ? $setting['share_url'] : mobileUrl('live', array(), true), 'desc' => !empty($setting['share_desc']) ? $setting['share_desc'] : $shop['description']);
		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$type = trim($_GPC['type']);
		$openid = trim($_W['openid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and lf.uniacid = :uniacid and lf.openid = \'' . $openid . '\' and lf.deleted = 0 ';
		$params = array(':uniacid' => $_W['uniacid']);
		$living = 1;
		if ($type == 'living' || $type == '') {
			$living = 1;
		}
		else {
			if ($type == 'noliving') {
				$living = 0;
			}
		}

		$sql = 'SELECT COUNT(1) FROM ' . tablename('ewei_shop_live_favorite') . ' as lf
                    right join ' . tablename('ewei_shop_live') . (' as l on l.id = lf.roomid and l.living = ' . $living . '
            		where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT lf.id,lf.roomid,l.title,l.thumb,l.livetime,l.subscribe,l.living,l.covertype,l.cover FROM ' . tablename('ewei_shop_live_favorite') . ' as lf
                    right join ' . tablename('ewei_shop_live') . (' as l on l.id = lf.roomid and l.living = ' . $living . '
            		where 1 ') . $condition . ' ORDER BY lf.id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb,cover');

			foreach ($list as $key => &$row) {
				if ($row['covertype'] == 1) {
					$row['thumb'] = $row['cover'];
				}

				$row['livetime'] = date('Y-m-d H:i:s', $row['livetime']);
			}

			unset($row);
		}

		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}
}

?>
