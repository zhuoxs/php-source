<?php

if (!defined('ES_PATH')) {
	exit('Access Denied');
}

class NewsController extends Controller
{
	public function index()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and a.status = 1 ';
		$params = array();

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' and a.title like :keyword';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
		}

		if (!empty($_GPC['cate'])) {
			$cateid = intval($_GPC['cate']);
			$condition .= ' and a.cate = :cate';
			$params[':cate'] = $cateid;
		}

		$articles = pdo_fetchall('SELECT a.* ,c.id as cid,c.name FROM ' . tablename('ewei_shop_system_company_article') . ' AS a
                    LEFT JOIN ' . tablename('ewei_shop_system_company_category') . (' AS c ON a.cate = c.id and c.status = 1
                    WHERE 1 ' . $condition . '  ORDER BY a.displayorder DESC LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('ewei_shop_system_company_article') . ' as a WHERE 1 ' . $condition, $params);
		$category = pdo_fetchall('select id,name from ' . tablename('ewei_shop_system_company_category') . ' where status = 1 order by displayorder asc ');
		$pager = $this->pagination($total, $pindex, $psize);
		$basicset = $this->basicset();
		$title = '新闻中心';
		include $this->template('news/index');
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$article = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_company_article') . ' AS a
                    LEFT JOIN ' . tablename('ewei_shop_system_company_category') . ' AS c ON a.cate = c.id
                    WHERE a.id = ' . $id);
		$articles = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_company_article') . ' AS a
                    WHERE a.status = 1  ORDER BY RAND() DESC LIMIT 4 ');
		$relevant_top = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_article') . ' AS a
                    WHERE a.status = 1  ORDER BY RAND()');
		$relevant = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_article') . ' AS a
                    WHERE a.status = 1 ORDER BY RAND() DESC LIMIT 6 ');
		$basicset = $this->basicset();
		$title = $article['title'];
		include $this->template('news/detail');
	}
}

?>
