<?php

if (!defined('ES_PATH')) {
	exit('Access Denied');
}

class ContactController extends Controller
{
	public function index()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_GPC['__uniacid']);
		$articles = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_article') . ' AS a
                    WHERE a.status = 1  ORDER BY RAND() DESC LIMIT 4 ');
		$relevant_top = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_article') . ' AS a
                    WHERE a.status = 1  ORDER BY RAND()');
		$relevant = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_system_article') . ' AS a
                    WHERE a.status = 1 ORDER BY RAND() DESC LIMIT 6 ');
		$casebanner = pdo_fetch('select contact from ' . tablename('ewei_shop_system_setting') . ' where uniacid = :uniacid ', array(':uniacid' => $uniacid));

		if (empty($casebanner)) {
			$casebanners = pdo_fetchall('select contact from ' . tablename('ewei_shop_system_setting') . ' where 1 ');

			foreach ($casebanners as $value) {
				if (!empty($value['contact'])) {
					$casebanner['contact'] = $value['contact'];
				}
			}
		}

		$basicset = $this->basicset();
		$title = '联系我们';
		include $this->template('contact/index');
	}
}

?>
