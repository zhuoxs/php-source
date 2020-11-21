<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Goods_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$sqlcondition = '';
		$condition = ' WHERE g.`uniacid` = :uniacid';
		$params = array(':uniacid' => $_W['uniacid']);
		$keyword = trim($_GPC['keyword']);

		if (!empty($keyword)) {
			$sqlcondition = ' left join ' . tablename('ewei_shop_goods_option') . ' op on g.id = op.goodsid';
			$condition .= ' AND (g.`id` = :id or g.`title` LIKE :keyword or g.`keywords` LIKE :keyword or g.`goodssn` LIKE :keyword or g.`productsn` LIKE :keyword or op.`title` LIKE :keyword or op.`goodssn` LIKE :keyword or op.`productsn` LIKE :keyword)';
			$params[':keyword'] = '%' . $keyword . '%';
			$params[':id'] = $keyword;
		}

		$cate = intval($_GPC['cate']);

		if (!empty($cate)) {
			$condition .= ' AND FIND_IN_SET(' . $cate . ', cates)<>0 ';
		}

		$condition .= ' AND g.`status` = 1 and g.`checked`=0 and g.`total`>0 and g.`deleted`=0 AND `type` !=20 AND `type` !=4';
		$sql = 'SELECT g.id FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . ' group by g.id';
		$total_all = pdo_fetchall($sql, $params);
		$total = count($total_all);
		unset($total_all);

		if (!empty($total)) {
			$sql = 'SELECT g.id, g.title, g.createtime, g.marketprice, g.thumb FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . ' group by g.id ORDER BY g.`status` DESC, g.`displayorder` DESC,
                g.`id` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb');
			$pager = pagination2($total, $pindex, $psize);
		}

		$categorys = m('shop')->getFullCategory(true);
		$category = array();

		foreach ($categorys as $cate) {
			$category[$cate['id']] = $cate;
		}

		$auth = $this->model->getAuth();
		$is_auth = !is_error($auth) && is_array($auth) ? $auth['is_auth'] : false;
		$showcode = false;

		if ($is_auth) {
			$release = $this->model->getRelease($auth['id']);
			$showcode = is_array($release) && !is_error($release) && $release['audit_status'] == 5;
		}

		if (!is_error($auth) && empty($is_auth)) {
			$showcode = true;
		}

		include $this->template();
	}

	public function get_code()
	{
		global $_GPC;
		$img = intval($_GPC['img']);
		$id = intval($_GPC['id']);
		$ret = $this->model->getCodeUnlimit(array('scene' => 'id=' . $id, 'page' => empty($id) ? 'pages/goods/index/index' : 'pages/goods/detail/index'));

		if ($img) {
			header('content-type: image/png');
			exit($ret);
		}
		else {
			show_json(is_error($ret) ? 0 : 1);
		}
	}
}

?>
