<?php
//QQ63779278
class Shop_EweiShopV2Model
{
	/**
	 * 获取商品分类
	 * @global type $_W
	 * @return type
	 */
	public function getCategory($refresh = false)
	{
		global $_W;
		$allcategory = m('cache')->getArray('allcategory');
		if (empty($allcategory) || $refresh) {
			$parents = array();
			$children = array();
			$category = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_category') . ' WHERE uniacid =:uniacid AND enabled=1 ORDER BY parentid ASC, displayorder DESC', array(':uniacid' => $_W['uniacid']));

			foreach ($category as $index => $row) {
				if (!empty($row['parentid'])) {
					if ($row[$row['parentid']]['parentid'] == 0) {
						$row[$row['parentid']]['level'] = 2;
					}
					else {
						$row[$row['parentid']]['level'] = 3;
					}

					$children[$row['parentid']][] = $row;
					unset($category[$index]);
				}
				else {
					$row['level'] = 1;
					$parents[] = $row;
				}
			}

			$allcategory = array('parent' => $parents, 'children' => $children);
			m('cache')->set('allcategory', $allcategory);
		}

		return $allcategory;
	}

	public function getFullCategory($fullname = false, $enabled = false)
	{
		global $_W;
		$allcategorynames = m('cache')->getArray('allcategorynames');
		$shopset = m('common')->getSysset('shop');
		$allcategory = array();
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_category') . ' WHERE uniacid=:uniacid ';

		if ($enabled) {
			$sql .= ' AND enabled=1';
		}

		$sql .= ' ORDER BY parentid ASC, displayorder DESC';
		$category = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
		$category = set_medias($category, array('thumb', 'advimg'));

		if (empty($category)) {
			return array();
		}

		foreach ($category as &$c) {
			if (empty($c['parentid'])) {
				$allcategory[] = $c;

				foreach ($category as &$c1) {
					if ($c1['parentid'] != $c['id']) {
						continue;
					}

					if ($fullname) {
						$c1['name'] = $c['name'] . '-' . $c1['name'];
					}

					$allcategory[] = $c1;

					foreach ($category as &$c2) {
						if ($c2['parentid'] != $c1['id']) {
							continue;
						}

						if ($fullname) {
							$c2['name'] = $c1['name'] . '-' . $c2['name'];
						}

						$allcategory[] = $c2;

						foreach ($category as &$c3) {
							if ($c3['parentid'] != $c2['id']) {
								continue;
							}

							if ($fullname) {
								$c3['name'] = $c2['name'] . '-' . $c3['name'];
							}

							$allcategory[] = $c3;
						}

						unset($c3);
					}

					unset($c2);
				}

				unset($c1);
			}

			unset($c);
		}

		return $allcategory;
	}

	public function checkClose()
	{
		if (strexists($_SERVER['REQUEST_URI'], '/web/')) {
			return NULL;
		}

		global $_S;
		global $_W;

		if ($_W['plugin'] == 'mmanage') {
			return NULL;
		}

		$close = $_S['close'];

		if (!empty($close['flag'])) {
			if (!empty($close['url'])) {
				header('location: ' . $close['url']);
				exit();
			}

			exit('<!DOCTYPE html>
					<html>
						<head>
							<meta name=\'viewport\' content=\'width=device-width, initial-scale=1, user-scalable=0\'>
							<title>抱歉，商城暂时关闭</title><meta charset=\'utf-8\'><meta name=\'viewport\' content=\'width=device-width, initial-scale=1, user-scalable=0\'><link rel=\'stylesheet\' type=\'text/css\' href=\'https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css\'>
						</head>
						<body>
						<style type=\'text/css\'>
						body { background:#fbfbf2; color:#333;}
						img { display:block; width:100%;}
						.header {
						width:100%; padding:10px 0;text-align:center;font-weight:bold;}
						</style>
						<div class=\'page_msg\'>
						
						<div class=\'inner\'><span class=\'msg_icon_wrp\'><i class=\'icon80_smile\'></i></span>' . $close['detail'] . '</div></div>
						</body>
					</html>');
		}
	}

	public function getAllCategory($refresh = false)
	{
		global $_W;
		$allcategory = m('cache')->getArray('allcategoryarr');
		if (empty($allcategory) || $refresh) {
			$allcategory = pdo_fetchall('SELECT id,parentid,uniacid,name,thumb FROM ' . tablename('ewei_shop_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\''), array(), 'id');
			m('cache')->set('allcategoryarr', $allcategory);
		}

		return $allcategory;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
