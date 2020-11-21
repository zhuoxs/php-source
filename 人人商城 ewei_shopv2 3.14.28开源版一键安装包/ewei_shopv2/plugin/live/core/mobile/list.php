<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class List_EweiShopV2Page extends PluginMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$cate = intval($_GPC['cate']);
		$keywords = trim($_GPC['keywords']);
		$categorys = pdo_fetchall('select * from ' . tablename('ewei_shop_live_category') . ' where uniacid = ' . $uniacid . ' and enabled = 1 ');
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
		$openid = trim($_W['openid']);
		$cateid = intval($_GPC['cate']);
		$merchid = intval($_GPC['merchid']);
		$keywords = trim($_GPC['keywords']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and uniacid = :uniacid and status = 1 ';

		if (0 < $merchid) {
			$condition .= ' and merchid = ' . $merchid . ' ';
		}

		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($cateid)) {
			$condition .= ' and category = ' . $cateid;
		}

		if (!empty($keywords)) {
			$condition .= ' and title like \'%' . $keywords . '%\' ';
		}

		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_live') . (' where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT id,title,thumb,livetime,covertype,cover,subscribe,living FROM ' . tablename('ewei_shop_live') . '
            		where 1 ' . $condition . ' ORDER BY displayorder desc,id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb,cover');

			foreach ($list as $key => &$row) {
				if ($row['covertype'] == 1) {
					$row['thumb'] = $row['cover'];
				}

				$row['livetime'] = date('Y-m-d H:i:s', $row['livetime']);
				$favorite = pdo_fetch('select deleted from ' . tablename('ewei_shop_live_favorite') . ' where uniacid = ' . $uniacid . ' and openid = \'' . $openid . '\' and roomid = ' . $row['id'] . ' and deleted = 0  ');
				$row['is_subscribe'] = empty($favorite) ? 0 : 1;
			}

			unset($row);
		}

		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}
}

?>
