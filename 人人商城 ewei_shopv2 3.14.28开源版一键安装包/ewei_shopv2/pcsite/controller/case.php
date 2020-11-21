<?php

if (!defined('ES_PATH')) {
	exit('Access Denied');
}

class CaseController extends Controller
{
	public function index()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_GPC['__uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 12;
		$condition = ' and a.status = 1 ';
		$params = array();

		if (!empty($_GPC['cate'])) {
			$cateid = intval($_GPC['cate']);
			$condition .= ' and a.cate = :cate';
			$params[':cate'] = $cateid;
		}

		$articles = pdo_fetchall('SELECT a.* ,c.id as cid,c.name FROM ' . tablename('ewei_shop_system_case') . ' AS a
                    LEFT JOIN ' . tablename('ewei_shop_system_casecategory') . (' AS c ON a.cate = c.id and c.status = 1
                    WHERE 1 ' . $condition . '  ORDER BY a.displayorder DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_system_case') . ' WHERE status = 1 ', $params);
		$category = pdo_fetchall('select id,name from ' . tablename('ewei_shop_system_casecategory') . ' where status = 1 order by displayorder asc ');
		$pager = $this->pagination($total, $pindex, $psize);
		$casebanner = pdo_fetch('select casebanner,background from ' . tablename('ewei_shop_system_setting') . ' where uniacid = :uniacid ', array(':uniacid' => $uniacid));

		if (empty($casebanner)) {
			$casebanners = pdo_fetchall('select casebanner,background from ' . tablename('ewei_shop_system_setting') . ' where 1 ');

			foreach ($casebanners as $value) {
				if (!empty($value['casebanner'])) {
					$casebanner['casebanner'] = $value['casebanner'];
				}
			}
		}

		$basicset = $this->basicset();
		$title = '案例展示';
		include $this->template('case/index');
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$article = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_case') . ' AS a
                    LEFT JOIN ' . tablename('ewei_shop_system_casecategory') . ' AS c ON a.cate = c.id
                    WHERE a.id = ' . $id);
		$basicset = $this->basicset();
		$title = $article['title'];
		include $this->template('news/detail');
	}
}

?>
