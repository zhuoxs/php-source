<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$wechatid = intval($_GPC['wechatid']);
		if (!empty($wechatid) && $wechatid != -1) {
			$copyrights = pdo_fetch('select * from ' . tablename('ewei_shop_system_copyright') . (' where uniacid=' . $wechatid . ' and ismanage=0 limit 1'));
		}

		if (empty($copyrights)) {
			$copyrights = pdo_fetch('select * from ' . tablename('ewei_shop_system_copyright') . ' where uniacid=-1  and ismanage=0  limit 1');
		}

		if (empty($copyrights['bgcolor'])) {
			$copyrights['bgcolor'] = '#fff';
		}

		if ($_W['ispost']) {
			$condition = '';
			$acid = 0;
			$where = array();
			$sets = pdo_fetchall('select uniacid from ' . tablename('ewei_shop_sysset'));
			$post = htmlspecialchars_decode($_GPC['copyright']);

			foreach ($sets as $set) {
				$uniacid = $set['uniacid'];
				if ($wechatid == $uniacid || $wechatid == -1) {
					$cs = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_system_copyright') . ' where uniacid=:uniacid and ismanage=0 limit 1', array(':uniacid' => $uniacid));

					if (empty($cs)) {
						pdo_insert('ewei_shop_system_copyright', array('uniacid' => $uniacid, 'copyright' => $post, 'bgcolor' => $_GPC['bgcolor'], 'ismanage' => 0));
					}
					else {
						pdo_update('ewei_shop_system_copyright', array('copyright' => $post, 'bgcolor' => $_GPC['bgcolor']), array('uniacid' => $uniacid, 'ismanage' => 0));
					}
				}
			}

			if ($wechatid == -1) {
				$global_copyrights = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_system_copyright') . ' where uniacid=-1 and ismanage=0 limit 1');

				if (empty($global_copyrights)) {
					pdo_insert('ewei_shop_system_copyright', array('uniacid' => -1, 'copyright' => $post, 'bgcolor' => $_GPC['bgcolor'], 'ismanage' => 0));
				}
				else {
					pdo_update('ewei_shop_system_copyright', array('copyright' => $post, 'bgcolor' => $_GPC['bgcolor'], 'ismanage' => 0), array('uniacid' => -1, 'ismanage' => 0));
				}
			}

			$copyrights = pdo_fetchall('select *  from ' . tablename('ewei_shop_system_copyright'));
			m('cache')->set('systemcopyright', $copyrights, 'global');
			show_json(1);
		}

		$wechats = m('common')->getWechats();
		$wechats = array_filter($wechats);
		include $this->template();
	}
}

?>
