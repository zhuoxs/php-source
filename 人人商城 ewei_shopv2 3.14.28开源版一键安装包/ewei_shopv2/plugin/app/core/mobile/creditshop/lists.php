<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Lists_EweiShopV2Page extends AppMobilePage
{
	public function getlist()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$shop = m('common')->getSysset('shop');
		$uniacid = $_W['uniacid'];
		$cateid = intval($_GPC['cate']);
		$merchid = intval($_GPC['merchid']);
		$cate = pdo_fetch('select id,name from ' . tablename('ewei_shop_creditshop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cateid, ':uniacid' => $uniacid));
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and uniacid = :uniacid and status=1 and deleted=0 and type!=3 ';

		if (0 < $merchid) {
			$condition .= ' and merchid = ' . $merchid . ' ';
		}

		$params = array(':uniacid' => $_W['uniacid']);

		if (!empty($cate)) {
			$condition .= ' and cate=' . $cateid;
		}

		$keywords = trim($_GPC['keywords']);

		if (!empty($keywords)) {
			$condition .= ' AND title like \'%' . $keywords . '%\' ';
		}

		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_creditshop_goods') . (' where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT id,title,thumb,subtitle,`type`,price,credit,money,goodstype FROM ' . tablename('ewei_shop_creditshop_goods') . '
            		where 1 ' . $condition . ' ORDER BY displayorder desc,id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb');

			foreach ($list as &$row) {
				if (0 < $row['credit'] & 0 < $row['money']) {
					$row['acttype'] = 0;
				}
				else if (0 < $row['credit']) {
					$row['acttype'] = 1;
				}
				else {
					if (0 < $row['money']) {
						$row['acttype'] = 2;
					}
				}

				if (intval($row['money']) - $row['money'] == 0) {
					$row['money'] = intval($row['money']);
				}
			}

			unset($row);
		}

		return app_json(array('list' => $list, 'pagesize' => $psize, 'total' => $total, 'next_page' => ceil($total / $psize)));
	}
}

?>
