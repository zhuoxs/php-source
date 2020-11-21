<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Report_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$categorys = array('全部分类', '欺诈', '色情', '政治谣言', '常识性谣言', '诱导分享', '恶意营销', '隐私信息收集', '其他侵权类');
		$kw = trim($_GPC['keyword']);
		$cid = trim($_GPC['cid']);
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and a.uniacid=:uniacid';

		if (!empty($cid)) {
			$condition .= ' and r.cate=\'' . $categorys[$cid] . '\'';
		}


		if (!empty($kw)) {
			$condition .= ' and ( r.cons like :keyword or a.article_title like :keyword)';
			$params[':keyword'] = '%' . $kw . '%';
		}


		$page = ((empty($_GPC['page']) ? '' : $_GPC['page']));
		$pindex = max(1, intval($page));
		$psize = 15;
		$datas = pdo_fetchall('SELECT r.id,r.mid,r.openid,r.aid,r.cate,r.cons,u.nickname,a.article_title, a.id as aid ' . ' FROM ' . tablename('ewei_shop_article_report') . ' r ' . ' left join ' . tablename('ewei_shop_member') . ' u on u.id=r.mid ' . ' left join ' . tablename('ewei_shop_article') . ' a on a.id=r.aid ' . ' where 1 ' . $condition . ' order by id desc limit ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_report') . ' where uniacid=:uniacid ' . $where, array(':uniacid' => $_W['uniacid']));
		$pager = pagination($total, $pindex, $psize);
		$reportnum = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_article_report') . ' WHERE uniacid= :uniacid ', array(':uniacid' => $_W['uniacid']));
		include $this->template();
	}
}


?>