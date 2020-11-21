<?php


/**
 * 砍价宝模块小程序接口定义
 *
 * @author ypuk
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
define("YPUK_FFYD", "ypuk_ffyd");
define("YPUK_FFYD_RES", "../addons/" . YPUK_FFYD . "/");
require_once IA_ROOT . "/addons/" . YPUK_FFYD . "/dbconfig.class.php";
class Ypuk_ffydModuleWxapp extends WeModuleWxapp
{
	public $Setting;
	public $attachment_root;
	public static $SERVER_VERSION = '4.8.0';
	public function doPageRecommendList()
	{
		global $_GPC, $_W;
		$message = '成功';
		$close_ios_pay = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid='{$_W['acid']}' AND recommend='1' AND status=1 ORDER BY sort ASC, id DESC ");
		foreach ($list as $key => $val) {
			if ($close_ios_pay == 1) {
				$list[$key]['price'] = 0;
			}
			$list[$key]['thumb'] = tomedia($val['thumb']);
			$list[$key]['createtime'] = date('Y-m-d H:i', $val['createtime']);
		}
		return $this->result(0, $message, $list);
	}
	public function doPageRecommendPackage()
	{
		global $_GPC, $_W;
		$message = '成功';
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . " WHERE weid='{$_W['acid']}' AND recommend='1' AND status=1 ORDER BY createtime DESC, id DESC ");
		foreach ($list as $key => $val) {
			$list[$key]['thumb'] = tomedia($val['thumb']);
			$list[$key]['createtime'] = date('Y-m-d H:i', $val['createtime']);
			$list[$key]['updatenum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND pid = {$val['id']}");
			$intro = str_replace('&nbsp;', '', $val['intro']);
			if (mb_strlen($intro, 'utf-8') > 10) {
				$list[$key]['intro'] = mb_substr($intro, 0, 10, 'utf-8') . '...';
			} else {
				$list[$key]['intro'] = $intro;
			}
		}
		return $this->result(0, $message, $list);
	}
	public function doPageList()
	{
		global $_GPC, $_W;
		$message = '成功';
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$order = $_GPC['order'];
		$close_ios_pay = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		if ($order == 'new') {
			$orderby = 'ORDER BY sort ASC, createtime DESC';
		} else {
			$orderby = 'ORDER BY sort ASC, viewnum DESC';
		}
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid='{$_W['acid']}' AND status=1 " . $orderby . " LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		foreach ($list as $key => $val) {
			if ($close_ios_pay == 1) {
				$list[$key]['price'] = 0;
			}
			$list[$key]['thumb'] = tomedia($val['thumb']);
			$list[$key]['createtime'] = date('Y-m-d H:i', $val['createtime']);
			if ($val['type'] == 'pic') {
				$articlecontent = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PIC_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$val['id']}'");
				$articlecontent['pic'] = unserialize($articlecontent['piclist']);
				$list[$key]['picnum'] = count($articlecontent['pic']);
			}
		}
		return $this->result(0, $message, $list);
	}
	public function doPagePackageList()
	{
		global $_GPC, $_W;
		$message = '成功';
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$close_ios_pay = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$order = $_GPC['order'];
		if ($order == 'new' || empty($order)) {
			$orderby = 'ORDER BY sort DESC, id DESC';
		} else {
			$orderby = 'ORDER BY buynum DESC';
		}
		$where = ' AND status=1 ';
		if (!empty($_GPC['recommend']) && $_GPC['recommend'] == 1) {
			$where .= ' AND recommend=1 ';
			$psize = 3;
		}
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . " WHERE weid='{$_W['acid']}' " . $where . " " . $orderby . " LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		foreach ($list as $key => $val) {
			if ($close_ios_pay == 1) {
				$list[$key]['price'] = 0;
			}
			$list[$key]['thumb'] = tomedia($val['thumb']);
			$list[$key]['createtime'] = date('Y-m-d H:i', $val['createtime']);
			$list[$key]['updatenum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND pid = {$val['id']}");
			$intro = str_replace('&nbsp;', '', $val['intro']);
			if (mb_strlen($intro, 'utf-8') > 10) {
				$list[$key]['intro'] = mb_substr($intro, 0, 10, 'utf-8') . '...';
			} else {
				$list[$key]['intro'] = $intro;
			}
			$list[$key]['updatenum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND pid = {$val['id']}");
			if (!empty($list[$key]['buynum_min']) && $list[$key]['buynum_min'] != 0) {
				$list[$key]['buynum'] = $list[$key]['buynum_min'] + $list[$key]['buynum'];
			}
			if ($list[$key]['buynum'] > 999) {
				$list[$key]['buynum'] = '999+';
			}
		}
		return $this->result(0, $message, $list);
	}
	public function doPageGetIndexMoreSetting()
	{
		global $_GPC, $_W;
		$setting = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . " WHERE weid='{$_W['acid']}'");
		$catnum = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid='{$_W['acid']}' AND parentid = 0");
		$result['navtype'] = $setting['navtype'];
		if ($catnum < 5) {
			$result['scstyle'] = 'padding-left:18px;';
		} else {
			$result['scstyle'] = '';
		}
		/*--Swiper---*/
		if (!empty($setting['swiper'])) {
			$swiper = unserialize($setting['swiper']);
			foreach ($swiper as $key => $val) {
				$swiper[$key]['swiper_image'] = tomedia($val['swiper_image']);
				$sorts[$key] = $val['swiper_sort'];
			}
			array_multisort($sorts, SORT_ASC, $swiper);
		} else {
			$swiper = '';
		}
		$topBarItems = array(0 => array('id' => 'new', 'name' => '新鲜的', 'selected' => true), 1 => array('id' => 'view', 'name' => '热门的', 'selected' => false));
		if (!empty($setting['index_new_text'])) {
			$topBarItems[0]['name'] = $setting['index_new_text'];
		}
		if (!empty($setting['index_view_text'])) {
			$topBarItems[1]['name'] = $setting['index_view_text'];
		}
		$result['topBarItems'] = $topBarItems;
		$result['swiper'] = $swiper;
		return $this->result(0, '成功', $result);
	}
	public function doPageNavSetting()
	{
		global $_GPC, $_W;
		$message = '成功';
		$setting = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . " WHERE weid='{$_W['acid']}'");
		$catnum = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid='{$_W['acid']}' AND parentid = 0");
		$result['navtype'] = $setting['navtype'];
		if ($catnum < 5) {
			$result['scstyle'] = 'padding-left:18px;';
		} else {
			$result['scstyle'] = '';
		}
		return $this->result(0, $message, $result);
	}
	public function doPageCategoryList()
	{
		global $_GPC, $_W;
		$message = '成功';
		$data = array();
		$topcat = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid='{$_W['acid']}' AND parentid = 0 AND enabled='1'");
		foreach ($topcat as $tkey => $tval) {
			$scat = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid='{$_W['acid']}' AND parentid='{$tval['id']}' AND enabled='1'");
			$topcat[$tkey]['subcat'] = $scat;
		}
		return $this->result(0, $message, $topcat);
	}
	public function doPageNavCategory()
	{
		global $_GPC, $_W;
		$message = '成功';
		$parentcat = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid = :weid AND enabled=1 AND parentid = 0", array(':weid' => $_W['acid']));
		$catnum = count($parentcat);
		foreach ($parentcat as $key => $val) {
			if ($catnum == 1) {
				$parentcat[$key]['style'] = 'width:680rpx;margin:0 30rpx;';
			}
			if ($catnum == 2) {
				$parentcat[$key]['style'] = 'width:300rpx;margin:0 30rpx;';
			}
			if ($catnum == 3) {
				$parentcat[$key]['style'] = 'width:186rpx;margin:0 30rpx;';
			}
			if ($catnum == 4) {
				$parentcat[$key]['style'] = 'width:109rpx;margin:0 40rpx;';
			}
			$parentcat[$key]['icon'] = tomedia($val['icon']);
		}
		return $this->result(0, $message, $parentcat);
	}
	public function doPageCatArticleList()
	{
		global $_GPC, $_W;
		$message = '成功';
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$pcatid = $_GPC['pcatid'];
		$scatid = $_GPC['scatid'];
		$close_ios_pay = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$where = '';
		if ($scatid == 0) {
			$scategorys = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid='{$_W['acid']}' AND parentid = '{$pcatid}' AND enabled='1'");
			$scatidtmp = array();
			foreach ($scategorys as $c) {
				array_push($scatidtmp, $c['id']);
			}
			$scatids = implode(",", $scatidtmp);
			$where .= "AND catid in ({$scatids})";
		} else {
			$where .= "AND catid='{$scatid}'";
		}
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid='{$_W['acid']}' AND status=1 " . $where . " ORDER BY sort ASC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		foreach ($list as $key => $val) {
			if ($close_ios_pay == 1) {
				$list[$key]['price'] = 0;
			}
			if ($val['type'] == 'pic') {
				$piccontent = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_PIC_CONTENT) . " WHERE weid='{$_W['acid']}' AND articleid='{$val['id']}'");
				$list[$key]['piccount'] = count(unserialize($piccontent['piclist']));
			}
			$list[$key]['thumb'] = tomedia($val['thumb']);
			$list[$key]['createtime'] = date('Y-m-d H:i', $val['createtime']);
		}
		return $this->result(0, $message, $list);
	}
	public function doPageTypeList()
	{
		global $_GPC, $_W;
		$message = '成功';
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$mod = $_GPC['tab'];
		$keyword = $_GPC['keyword'];
		$close_ios_pay = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$where = '';
		if ($mod == 'audio') {
			$where .= "AND type='audio'";
		} elseif ($mod == 'video') {
			$where .= "AND type='video'";
		} elseif ($mod == 'pic') {
			$where .= "AND type='pic'";
		} elseif ($mod == 'pdf') {
			$where .= "AND type='pdf'";
		} else {
			$where .= "AND type='text'";
		}
		$keyword = $_GPC['keyword'];
		if (!empty($keyword) && $keyword != '') {
			$where .= "AND ((title like '%{$keyword}%') or (intro like '%{$keyword}%'))";
		}
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid='{$_W['acid']}' AND status=1 " . $where . " ORDER BY sort ASC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		foreach ($list as $key => $val) {
			if ($val['type'] == 'pic') {
				$piccontent = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_PIC_CONTENT) . " WHERE weid='{$_W['acid']}' AND articleid='{$val['id']}'");
				$list[$key]['piccount'] = count(unserialize($piccontent['piclist']));
			}
			if ($close_ios_pay == 1) {
				$list[$key]['price'] = 0;
			}
			$list[$key]['thumb'] = tomedia($val['thumb']);
			$list[$key]['createtime'] = date('Y-m-d H:i', $val['createtime']);
		}
		return $this->result(0, $message, $list);
	}
	public function doPageGetPackageDetail()
	{
		global $_GPC, $_W;
		$message = '成功';
		$pid = $_GPC['pid'];
		$uid = $_GPC['uid'];
		$package = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$pid}'");
		if (empty($package)) {
			return $this->result(1, '专栏不存在或已被删除', '');
		}
		$package['close_ios_pay'] = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$UserRecord = $this->findUserPackageRecord($pid, $uid);
		if (!empty($UserRecord)) {
			$package['isbuy'] = 1;
		} else {
			$package['isbuy'] = 0;
		}
		$setting = pdo_fetch("SELECT openposter,open_package_activation FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		$package['openposter'] = $setting['openposter'];
		$package['open_package_activation'] = $setting['open_package_activation'];
		$package['updatenum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND pid = {$pid}");
		$package['content'] = htmlspecialchars_decode($package['content']);
		$package['thumb'] = tomedia($package['thumb']);
		$package['createtime'] = date('Y-m-d H:i:s', $package['createtime']);
		return $this->result(0, $message, $package);
	}
	public function doPageGetPackageBind()
	{
		global $_GPC, $_W;
		$message = '成功';
		$pid = $_GPC['pid'];
		$uid = $_GPC['uid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$close_ios_pay = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . " WHERE weid='{$_W['acid']}' AND pid='{$pid}' ORDER BY sort ASC,id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		foreach ($list as $key => $val) {
			$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$val['articleid']}'");
			$list[$key]['id'] = $article['id'];
			$list[$key]['thumb'] = tomedia($article['thumb']);
			$list[$key]['price'] = floatval($article['price']);
			$list[$key]['title'] = $article['title'];
			$list[$key]['intro'] = $article['intro'];
			$list[$key]['type'] = $article['type'];
			$list[$key]['createtime'] = date('Y-m-d H:i', $article['createtime']);
			if ($close_ios_pay == 1) {
				$list[$key]['price'] = 0;
			}
		}
		return $this->result(0, $message, $list);
	}
	public function doPageGetTextDetail()
	{
		global $_GPC, $_W;
		$message = '成功';
		$articleid = $_GPC['articleid'];
		$uid = $_GPC['uid'];
		$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$articleid}'");
		$articlecontent = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_TEXT_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (empty($article)) {
			return $this->result(1, '文章不存在或已被删除', '');
		}
		$article['showmod'] = 'preview';
		$UserVip = $this->findUserVip($uid);
		if (!empty($UserVip) && $UserVip['type'] == 0) {
			$article['showmod'] = 'all';
		}
		$article['close_ios_pay'] = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$UserRecord = $this->findUserRecord($articleid, $uid);
		$packagebind = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (!empty($packagebind)) {
			$PackageRecord = $this->findUserPackageRecord($packagebind['pid'], $uid);
			if (!empty($PackageRecord)) {
				$article['showmod'] = 'all';
			}
		}
		if (!empty($UserRecord)) {
			$article['showmod'] = 'all';
		}
		if ($article['price'] == 0 || $article['price'] == 0.0) {
			$article['showmod'] = 'all';
		}
		$setting = pdo_fetch("SELECT openposter FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		$article['openposter'] = $setting['openposter'];
		$article['commentnum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		$article['text'] = htmlspecialchars_decode($articlecontent['text']);
		$article['preview_text'] = htmlspecialchars_decode($articlecontent['preview_text']);
		$article['thumb'] = tomedia($article['thumb']);
		$article['createtime'] = date('Y-m-d H:i:s', $article['createtime']);
		$favlog = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_FAVLOG) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}' AND uid='{$uid}'");
		if (!empty($favlog)) {
			$article['favstatus'] = 1;
		} else {
			$article['favstatus'] = 0;
		}
		//更新阅读量
		$updata['viewnum'] = $article['viewnum'] + 1;
		pdo_update(DBCONFIG::$TABLE_FFYD_ARTICLE, $updata, array('id' => $articleid));
		return $this->result(0, $message, $article);
	}
	public function doPageGetPdfDetail()
	{
		global $_GPC, $_W;
		$message = '成功';
		$articleid = $_GPC['articleid'];
		$uid = $_GPC['uid'];
		$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$articleid}'");
		$articlecontent = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PDF_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (empty($article)) {
			return $this->result(1, '文章不存在或已被删除', '');
		}
		$article['showmod'] = 'preview';
		$UserVip = $this->findUserVip($uid);
		if (!empty($UserVip) && $UserVip['type'] == 0) {
			$article['showmod'] = 'all';
		}
		$article['close_ios_pay'] = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$UserRecord = $this->findUserRecord($articleid, $uid);
		$setting = pdo_fetch("SELECT openposter FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		$article['openposter'] = $setting['openposter'];
		$packagebind = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (!empty($packagebind)) {
			$PackageRecord = $this->findUserPackageRecord($packagebind['pid'], $uid);
			if (!empty($PackageRecord)) {
				$article['showmod'] = 'all';
			}
		}
		if (!empty($UserRecord)) {
			$article['showmod'] = 'all';
		}
		if ($article['price'] == 0 || $article['price'] == 0.0) {
			$article['showmod'] = 'all';
		}
		$article['commentnum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		$article['pdffile'] = $articlecontent['pdffile'];
		$article['thumb'] = tomedia($article['thumb']);
		$article['createtime'] = date('Y-m-d H:i:s', $article['createtime']);
		$favlog = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_FAVLOG) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}' AND uid='{$uid}'");
		if (!empty($favlog)) {
			$article['favstatus'] = 1;
		} else {
			$article['favstatus'] = 0;
		}
		//更新阅读量
		$updata['viewnum'] = $article['viewnum'] + 1;
		pdo_update(DBCONFIG::$TABLE_FFYD_ARTICLE, $updata, array('id' => $articleid));
		return $this->result(0, $message, $article);
	}
	public function doPageGetVideoDetail()
	{
		global $_GPC, $_W;
		$message = '成功';
		$articleid = $_GPC['articleid'];
		$uid = $_GPC['uid'];
		$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$articleid}'");
		$articlecontent = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIDEO_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (empty($article)) {
			return $this->result(1, '文章不存在或已被删除', '');
		}
		$article['showmod'] = 'preview';
		$UserVip = $this->findUserVip($uid);
		if (!empty($UserVip) && $UserVip['type'] == 0) {
			$article['showmod'] = 'all';
		}
		$packagebind = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (!empty($packagebind)) {
			$PackageRecord = $this->findUserPackageRecord($packagebind['pid'], $uid);
			if (!empty($PackageRecord)) {
				$article['showmod'] = 'all';
			}
		}
		$setting = pdo_fetch("SELECT openposter FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		$article['openposter'] = $setting['openposter'];
		$article['close_ios_pay'] = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$UserRecord = $this->findUserRecord($articleid, $uid);
		if (!empty($UserRecord)) {
			$article['showmod'] = 'all';
		}
		if ($article['price'] == 0 || $article['price'] == 0.0) {
			$article['showmod'] = 'all';
		}
		$article['text'] = htmlspecialchars_decode($articlecontent['text']);
		$article['commentnum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if ($articlecontent['videotype'] == 0) {
			$article['video'] = tomedia($articlecontent['video']);
		} else {
			$article['video'] = $articlecontent['video'];
		}
		if (!empty($articlecontent['videopic'])) {
			$article['videopic'] = tomedia($articlecontent['videopic']);
		} else {
			$article['videopic'] = 'nopic';
		}
		$article['preview_time'] = $articlecontent['preview_time'];
		$article['videotype'] = $articlecontent['videotype'];
		$article['thumb'] = tomedia($article['thumb']);
		$article['createtime'] = date('Y-m-d H:i:s', $article['createtime']);
		$favlog = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_FAVLOG) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}' AND uid='{$uid}'");
		if (!empty($favlog)) {
			$article['favstatus'] = 1;
		} else {
			$article['favstatus'] = 0;
		}
		//更新阅读量
		$updata['viewnum'] = $article['viewnum'] + 1;
		pdo_update(DBCONFIG::$TABLE_FFYD_ARTICLE, $updata, array('id' => $articleid));
		return $this->result(0, $message, $article);
	}
	public function doPageGetPicDetail()
	{
		global $_GPC, $_W;
		$message = '成功';
		$articleid = $_GPC['articleid'];
		$uid = $_GPC['uid'];
		$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$articleid}'");
		$articlecontent = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PIC_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (empty($article)) {
			return $this->result(1, '文章不存在或已被删除', '');
		}
		$article['showmod'] = 'preview';
		$UserVip = $this->findUserVip($uid);
		if (!empty($UserVip) && $UserVip['type'] == 0) {
			$article['showmod'] = 'all';
		}
		$packagebind = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (!empty($packagebind)) {
			$PackageRecord = $this->findUserPackageRecord($packagebind['pid'], $uid);
			if (!empty($PackageRecord)) {
				$article['showmod'] = 'all';
			}
		}
		$article['close_ios_pay'] = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$UserRecord = $this->findUserRecord($articleid, $uid);
		if (!empty($UserRecord)) {
			$article['showmod'] = 'all';
		}
		if ($article['price'] == 0 || $article['price'] == 0.0) {
			$article['showmod'] = 'all';
		}
		$article['pic'] = unserialize($articlecontent['piclist']);
		foreach ($article['pic'] as $key => $val) {
			$article['pic'][$key] = tomedia($val);
		}
		$setting = pdo_fetch("SELECT openposter FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		$article['openposter'] = $setting['openposter'];
		$article['commentnum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		$article['preview_pic'] = array_slice($article['pic'], 0, $articlecontent['preview_number']);
		$article['preview_number'] = $articlecontent['preview_number'];
		$article['picnum'] = count($article['pic']);
		$article['other_picnum'] = $article['picnum'] - $articlecontent['preview_number'];
		$article['thumb'] = tomedia($article['thumb']);
		$article['createtime'] = date('Y-m-d H:i:s', $article['createtime']);
		$favlog = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_FAVLOG) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}' AND uid='{$uid}'");
		if (!empty($favlog)) {
			$article['favstatus'] = 1;
		} else {
			$article['favstatus'] = 0;
		}
		//更新阅读量
		$updata['viewnum'] = $article['viewnum'] + 1;
		pdo_update(DBCONFIG::$TABLE_FFYD_ARTICLE, $updata, array('id' => $articleid));
		return $this->result(0, $message, $article);
	}
	public function doPageGetAudioDetail()
	{
		global $_GPC, $_W;
		$message = '成功';
		$articleid = $_GPC['articleid'];
		$uid = $_GPC['uid'];
		$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$articleid}'");
		$articlecontent = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_AUDIO_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (empty($article)) {
			return $this->result(1, '文章不存在或已被删除', '');
		}
		$article['showmod'] = 'preview';
		$UserVip = $this->findUserVip($uid);
		if (!empty($UserVip) && $UserVip['type'] == 0) {
			$article['showmod'] = 'all';
		}
		$packagebind = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		if (!empty($packagebind)) {
			$PackageRecord = $this->findUserPackageRecord($packagebind['pid'], $uid);
			if (!empty($PackageRecord)) {
				$article['showmod'] = 'all';
			}
		}
		$article['close_ios_pay'] = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$setting = pdo_fetch("SELECT openposter FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		$article['openposter'] = $setting['openposter'];
		$UserRecord = $this->findUserRecord($articleid, $uid);
		if (!empty($UserRecord)) {
			$article['showmod'] = 'all';
		}
		if ($article['price'] == 0 || $article['price'] == 0.0) {
			$article['showmod'] = 'all';
		}
		$article['text'] = htmlspecialchars_decode($articlecontent['text']);
		$article['commentnum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}'");
		$article['audio'] = tomedia($articlecontent['audio']);
		$article['preview_audio'] = tomedia($articlecontent['preview_audio']);
		$article['thumb'] = tomedia($article['thumb']);
		$article['createtime'] = date('Y-m-d H:i:s', $article['createtime']);
		$article['audiotime'] = $articlecontent['audiotime'];
		$favlog = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_FAVLOG) . "WHERE weid='{$_W['acid']}' AND articleid='{$articleid}' AND uid='{$uid}'");
		if (!empty($favlog)) {
			$article['favstatus'] = 1;
		} else {
			$article['favstatus'] = 0;
		}
		//更新阅读量
		$updata['viewnum'] = $article['viewnum'] + 1;
		pdo_update(DBCONFIG::$TABLE_FFYD_ARTICLE, $updata, array('id' => $articleid));
		return $this->result(0, $message, $article);
	}
	public function doPageAddComment()
	{
		global $_W, $_GPC;
		$message = '成功';
		$data = array('weid' => $_W['acid'], 'uid' => $_GPC['uid'], 'articleid' => $_GPC['articleid'], 'content' => $_GPC['content'], 'createtime' => TIMESTAMP, 'status' => 0);
		if (empty($_GPC['id'])) {
			pdo_insert(DBCONFIG::$TABLE_FFYD_COMMENT, $data);
			$result = pdo_insertid();
		}
		return $this->result(0, $message, $result);
	}
	public function doPageGetComment()
	{
		global $_W, $_GPC;
		$message = '成功';
		load()->model('mc');
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$comment = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . "WHERE weid='{$_W['acid']}' AND status = 1 AND articleid='{$_GPC['articleid']}' ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
		foreach ($comment as $k => $c) {
			$comment[$k]['createtime'] = date('Y-m-d H:i:s', $c['createtime']);
			$comment[$k]['author'] = mc_fansinfo($c['uid'], $_W['acid']);
		}
		return $this->result(0, $message, $comment);
	}
	public function doPageGetVipGroup()
	{
		global $_GPC, $_W;
		$message = '成功';
		$uid = $_GPC['uid'];
		$UserVip = $this->findUserVip($uid);
		if (!empty($UserVip)) {
			$where = " AND type='" . $UserVip['type'] . "' ";
		}
		$vipgourp = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . " WHERE weid='{$_W['acid']}'" . $where);
		foreach ($vipgourp as $key => $val) {
			if ($val['type'] == 1) {
				$vipgourp[$key]['discount'] = $val['discount'] * 10;
			}
		}
		return $this->result(0, $message, $vipgourp);
	}
	public function doPageGetUserVip()
	{
		global $_GPC, $_W;
		$message = '成功';
		$uid = $_GPC['uid'];
		$UserVipInfo = $this->findUserVip($uid);
		$uservip = '';
		if (!empty($UserVipInfo)) {
			$uservip = $UserVipInfo;
			if ($uservip['endtime'] > 0) {
				$uservip['endtime'] = date('Y-m-d H:i:s', $uservip['endtime']);
			}
		}
		return $this->result(0, $message, $uservip);
	}
	public function doPageSaveFormid()
	{
		global $_GPC, $_W;
		//FORM ID 此处存储的formid用于砍价成功后发送模板消息
		$this->add_formid($_GPC['activityid'], $_GPC['uid'], $_GPC['form_id']);
	}
	public function doPageGetSetting()
	{
		global $_GPC, $_W;
		$message = '成功';
		$setting = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . " WHERE weid='{$_W['acid']}'");
		if (!empty($setting['kefuqr'])) {
			$setting['kefuqr'] = array(tomedia($setting['kefuqr']));
		}
		if (!empty($_GPC['version']) && $_GPC['appos']) {
			$close_ios_pay = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
			$setting['close_ios_pay'] = $close_ios_pay;
		}
		return $this->result(0, $message, $setting);
	}
	public function doPageGetHelpExamineSetting()
	{
		global $_GPC, $_W;
		$version = $_GPC['version'];
		if ($version != $this::$SERVER_VERSION) {
			$result['help_examine_open'] = 0;
		} else {
			$setting = pdo_fetch("SELECT help_examine_open,help_examine_index,help_examine_my,help_examine_package FROM " . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . " WHERE weid='{$_W['acid']}'");
			if ($setting['help_examine_open'] == 0 || empty($setting['help_examine_open'])) {
				$result['help_examine_open'] = 0;
			} else {
				$result['help_examine_open'] = $setting['help_examine_open'];
				if ($result['help_examine_open'] == 1) {
					$result['help_examine_index'] = htmlspecialchars_decode($setting['help_examine_index']);
					$result['help_examine_my'] = htmlspecialchars_decode($setting['help_examine_my']);
					$result['help_examine_package'] = htmlspecialchars_decode($setting['help_examine_package']);
				}
			}
		}
		return $this->result(0, '成功', $result);
	}
	public function doPageGetPoster()
	{
		global $_W, $_GPC;
		$message = '成功';
		load()->model('mc');
		$bid = $_GPC['bargainid'];
		$bargain = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_KJB_BARGAIN) . "WHERE weid='{$_W['acid']}' AND id='{$bid}'");
		if (!function_exists('gd_info')) {
			$qrfile = $this->GetBargainQr($bid);
			$image = imagecreatefromjpeg($qrfile);
		} else {
			$activity = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_KJB_ACTIVITY) . "WHERE weid='{$_W['acid']}' AND id='{$bargain['aid']}'");
			$userInfo = mc_fansinfo($bargain['uid'], $_W['acid']);
			mb_internal_encoding("UTF-8");
			$img_name = IA_ROOT . "/addons/" . YPUK_KJB . "/images/poster_bg.jpg";
			$image = imagecreatefromjpeg($img_name);
			$qrfile = $this->GetBargainQr($bid);
			$qr = imagecreatefromjpeg($qrfile);
			$text = '我正在' . $_W['account']['name'] . '参加' . $activity['title'] . '砍价活动，原价' . $activity['oldprice'] . '元，最低' . $activity['lowprice'] . '元即可获得，快来帮我砍一刀吧';
			$temp = array("color" => array(255, 255, 255), "fontsize" => 17, "width" => 376, "left" => 160, "top" => 520, "hang_size" => 40);
			$str_h = $this->draw_txt_to($image, $temp, $text, true);
			//头像处理部分
			if (!empty($userInfo['avatar'])) {
				$per = 0.1;
				list($width, $height) = getimagesize($userInfo['avatar']);
				$n_w = 100;
				$n_h = 100;
				$newavatar = imagecreatetruecolor($n_w, $n_h);
				$avatar = imagecreatefromjpeg($userInfo['avatar']);
				//copy部分图像并调整
				imagecopyresized($newavatar, $avatar, 0, 0, 0, 0, $n_w, $n_h, $width, $height);
				$radius = 45;
				$x = 40;
				$y = 590;
				$lt_corner = $this->get_lt_rounder_corner($radius, 174, 50, 40);
				imagecopy($image, $newavatar, $x, $y, 0, 0, 90, 90);
				$this->myradus($image, $x, $y, $lt_corner, $radius, 90, 90);
			}
			imagecopyresized($image, $qr, 150, 150, 0, 0, 260, 260, 630, 630);
			imagedestroy($qr);
		}
		header('Content-type: image/jpeg;');
		ImageJPEG($image);
		imagedestroy($image);
	}
	public function doPageGetUserInfo()
	{
		global $_W, $_GPC;
		$message = '成功';
		load()->model('mc');
		$result = mc_fansinfo($_GPC['uid'], $_W['acid']);
		$UserVip = $this->findUserVip($_GPC['uid']);
		if (!empty($UserVip)) {
			if ($UserVip['endtime'] > 0) {
				$UserVip['endtime'] = date('Y-m-d H:i', $UserVip['endtime']);
			}
			$result['vip'] = $UserVip;
		}
		return $this->result(0, $message, $result);
	}
	public function doPageUserRecord()
	{
		global $_GPC, $_W;
		$message = '成功';
		$uid = $_GPC['uid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_RECORD) . " WHERE weid='{$_W['acid']}' AND uid='{$uid}' ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
		foreach ($list as $key => $value) {
			$list[$key]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
			$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$value['articleid']}'");
			$article['thumb'] = tomedia($article['thumb']);
			$list[$key]['article'] = $article;
		}
		return $this->result(0, $message, $list);
	}
	public function doPageUserPackageRecord()
	{
		global $_GPC, $_W;
		$message = '成功';
		$uid = $_GPC['uid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_RECORD) . " WHERE weid='{$_W['acid']}' AND uid='{$uid}' ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
		foreach ($list as $key => $value) {
			$list[$key]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
			$package = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$value['pid']}'");
			$package['thumb'] = tomedia($package['thumb']);
			$package['updatenum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND pid = {$value['pid']}");
			if (!empty($package['buynum_min']) && $package['buynum_min'] != 0) {
				$package['buynum'] = $package['buynum_min'] + $package['buynum'];
			}
			if ($package['buynum'] > 999) {
				$package['buynum'] = '999+';
			}
			$intro = str_replace('&nbsp;', '', $package['intro']);
			if (mb_strlen($intro, 'utf-8') > 10) {
				$package['intro'] = mb_substr($intro, 0, 10, 'utf-8') . '...';
			} else {
				$package['intro'] = $intro;
			}
			$list[$key]['package'] = $package;
		}
		return $this->result(0, $message, $list);
	}
	public function doPageUserComment()
	{
		global $_GPC, $_W;
		$message = '成功';
		load()->model('mc');
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$comment = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . "WHERE weid='{$_W['acid']}' AND uid='{$_GPC['uid']}' ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
		foreach ($comment as $k => $c) {
			$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE id='{$c['articleid']}'");
			$article['createtime'] = date('Y-m-d H:i:s', $article['createtime']);
			$article['thumb'] = tomedia($article['thumb']);
			$comment[$k]['article'] = $article;
			$comment[$k]['createtime'] = date('Y-m-d H:i:s', $c['createtime']);
		}
		return $this->result(0, $message, $comment);
	}
	public function doPageDelComment()
	{
		global $_GPC, $_W;
		$message = '成功';
		$id = intval($_GPC['id']);
		$uid = intval($_GPC['uid']);
		$result = pdo_delete(DBCONFIG::$TABLE_FFYD_COMMENT, array('id' => $id, 'uid' => $uid));
		if (!empty($result)) {
			return $this->result(0, $message, '');
		}
	}
	public function doPageUserFav()
	{
		global $_GPC, $_W;
		$message = '成功';
		$uid = $_GPC['uid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$close_ios_pay = $this->checkCloseIosPay($_GPC['version'], $_GPC['appos']);
		$favlist = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_FAVLOG) . " WHERE weid='{$_W['acid']}' AND uid='{$_GPC['uid']}' ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
		if ($favlist) {
			$tmp = array();
			foreach ($favlist as $v) {
				array_push($tmp, $v['articleid']);
			}
			$articleids = implode(",", $tmp);
			$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid='{$_W['acid']}' AND id in ({$articleids}) ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
			foreach ($list as $key => $value) {
				$list[$key]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
				$list[$key]['thumb'] = tomedia($value['thumb']);
				if ($close_ios_pay == 1) {
					$list[$key]['price'] = 0;
				}
			}
		} else {
			$list = '';
		}
		return $this->result(0, $message, $list);
	}
	public function doPageAddFav()
	{
		global $_W, $_GPC;
		$message = '成功';
		$favlog = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_FAVLOG) . "WHERE weid='{$_W['acid']}' AND articleid='{$_GPC['articleid']}' AND uid='{$_GPC['uid']}'");
		$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$_GPC['articleid']}'");
		if (!empty($favlog)) {
			pdo_delete(DBCONFIG::$TABLE_FFYD_FAVLOG, array('id' => $favlog['id']));
			$status = 0;
			$updata['favnum'] = $article['favnum'] - 1;
		} else {
			pdo_insert(DBCONFIG::$TABLE_FFYD_FAVLOG, array('weid' => $_W['acid'], 'articleid' => $_GPC['articleid'], 'uid' => $_GPC['uid']));
			$status = 1;
			$updata['favnum'] = $article['favnum'] + 1;
		}
		//更新收藏量
		pdo_update(DBCONFIG::$TABLE_FFYD_ARTICLE, $updata, array('id' => $_GPC['articleid']));
		return $this->result(0, $message, $status);
	}
	public function doPageActivationPackage()
	{
		global $_W, $_GPC;
		$message = '成功';
		$codeaccount = $_GPC['codeaccount'];
		$codepwd = $_GPC['codepwd'];
		$pid = $_GPC['pid'];
		$uid = $_GPC['uid'];
		$codeinfo = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_CODE) . "WHERE weid='{$_W['acid']}' AND codeaccount='{$codeaccount}'");
		if (empty($codeinfo)) {
			return $this->result(-1, '卡密不存在', '');
		} else {
			if ($codeinfo['codepwd'] != $codepwd) {
				return $this->result(-1, '密码错误', '');
			}
			if ($codeinfo['status'] == 1) {
				return $this->result(-1, '卡密已被使用', '');
			}
			if ($codeinfo['pid'] != $pid) {
				return $this->result(-1, '此卡密不属于当前所选专栏', '');
			}
		}
		$packageinfo = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$codeinfo['pid']}'");
		$recorddata = array('pid' => $pid, 'uid' => $uid, 'weid' => $_W['acid'], 'price' => $packageinfo['price'], 'createtime' => TIMESTAMP);
		pdo_insert(DBCONFIG::$TABLE_FFYD_PACKAGE_RECORD, $recorddata);
		$updata['buynum'] = $packageinfo['buynum'] + 1;
		pdo_update(DBCONFIG::$TABLE_FFYD_PACKAGE, $updata, array('id' => $pid));
		pdo_update(DBCONFIG::$TABLE_FFYD_PACKAGE_CODE, array('status' => 1), array('id' => $codeinfo['id']));
		return $this->result(0, $message, '');
	}
	public function doPageBuyFreePackage()
	{
		global $_W, $_GPC;
		$message = '成功';
		$pid = $_GPC['pid'];
		$uid = $_GPC['uid'];
		$packageinfo = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$pid}'");
		if ($packageinfo['price'] > 0) {
			return $this->result(-1, '系统错误，请稍后再试', '');
		}
		$recorddata = array('pid' => $pid, 'uid' => $uid, 'weid' => $_W['acid'], 'price' => $packageinfo['price'], 'createtime' => TIMESTAMP);
		pdo_insert(DBCONFIG::$TABLE_FFYD_PACKAGE_RECORD, $recorddata);
		$updata['buynum'] = $packageinfo['buynum'] + 1;
		pdo_update(DBCONFIG::$TABLE_FFYD_PACKAGE, $updata, array('id' => $pid));
		return $this->result(0, $message, '');
	}
	public function doPagePay()
	{
		global $_GPC, $_W;
		//构造订单信息，此处订单随机生成，业务中应该把此订单入库，支付成功后，根据此订单号更新用户是否支付成功
		$mod = $_GPC['mod'];
		$setting = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . " WHERE weid='{$_W['acid']}'");
		if ($mod == 'vip') {
			$vipgroup = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . "WHERE weid='{$_W['acid']}' AND id='{$_GPC['vipgid']}'");
			$orderno = date('YmdHis', time()) . "s01ti" . $vipgroup['id'] . "ui" . $_GPC['uid'] . "e";
			$userbindinfo = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION_USERBIND) . "WHERE weid='{$_W['acid']}' AND uid='{$_GPC['uid']}'");
			if ($setting['opendistribution'] == 1 && !empty($userbindinfo) && !empty($vipgroup['distribution_commission']) && $vipgroup['distribution_commission'] != '0') {
				$distribution_array = array('weid' => $_W['acid'], 'price' => $vipgroup['distribution_commission'], 'uid' => $userbindinfo['topuid'], 'createtime' => TIMESTAMP, 'type' => 1, 'status' => 0, 'orderno' => $orderno, 'goodid' => $_GPC['vipgid'], 'seconduid' => $_GPC['uid']);
				pdo_insert(DBCONFIG::$TABLE_FFYD_DISTRIBUTION, $distribution_array);
			}
			$params = array('ordersn' => $orderno, 'tid' => $orderno, 'user' => $_GPC['uid'], 'fee' => floatval($vipgroup['price']), 'title' => $_W['account']['name'] . "VIP订单{$orderno}");
		} elseif ($mod == 'package') {
			$package = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$_GPC['pid']}'");
			$uservip = $this->findUserVip($_GPC['uid']);
			if (!empty($uservip) && $uservip['type'] == 1) {
				$price = $package['price'] * $uservip['discount'];
			} else {
				$price = $package['price'];
			}
			$orderno = date('YmdHis', time()) . "s03ti" . $package['id'] . "ui" . $_GPC['uid'] . "e";
			$userbindinfo = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION_USERBIND) . "WHERE weid='{$_W['acid']}' AND uid='{$_GPC['uid']}'");
			if ($setting['opendistribution'] == 1 && !empty($userbindinfo) && !empty($package['distribution_commission']) && $package['distribution_commission'] != '0') {
				$distribution_array = array('weid' => $_W['acid'], 'price' => $package['distribution_commission'], 'uid' => $userbindinfo['topuid'], 'createtime' => TIMESTAMP, 'type' => 3, 'status' => 0, 'orderno' => $orderno, 'goodid' => $_GPC['pid'], 'seconduid' => $_GPC['uid']);
				pdo_insert(DBCONFIG::$TABLE_FFYD_DISTRIBUTION, $distribution_array);
			}
			$params = array('ordersn' => $orderno, 'tid' => $orderno, 'user' => $_GPC['uid'], 'fee' => floatval($price), 'title' => $_W['account']['name'] . "专栏购买订单{$orderno}");
		} else {
			$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$_GPC['articleid']}'");
			$uservip = $this->findUserVip($_GPC['uid']);
			if (!empty($uservip) && $uservip['type'] == 1) {
				$price = $article['price'] * $uservip['discount'];
			} else {
				$price = $article['price'];
			}
			$orderno = date('YmdHis', time()) . "s02ti" . $article['id'] . "ui" . $_GPC['uid'] . "e";
			$userbindinfo = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION_USERBIND) . "WHERE weid='{$_W['acid']}' AND uid='{$_GPC['uid']}'");
			if ($setting['opendistribution'] == 1 && !empty($userbindinfo) && !empty($article['distribution_commission']) && $article['distribution_commission'] != '0') {
				$distribution_array = array('weid' => $_W['acid'], 'price' => $article['distribution_commission'], 'uid' => $userbindinfo['topuid'], 'createtime' => TIMESTAMP, 'type' => 2, 'status' => 0, 'orderno' => $orderno, 'goodid' => $_GPC['articleid'], 'seconduid' => $_GPC['uid']);
				pdo_insert(DBCONFIG::$TABLE_FFYD_DISTRIBUTION, $distribution_array);
			}
			$params = array('ordersn' => $orderno, 'tid' => $orderno, 'user' => $_GPC['uid'], 'fee' => floatval($price), 'title' => $_W['account']['name'] . "文章购买订单{$orderno}");
		}
		$pay_params = $this->pay($params);
		if (is_error($pay_params)) {
			return $this->result(1, '支付失败，请重试', $pay_params);
		}
		return $this->result(0, '', $pay_params);
	}
	public function payResult($pay_result)
	{
		global $_GPC, $_W;
		if ($pay_result['result'] == 'success') {
			//此处会处理一些支付成功的业务代码
			$orderno = $pay_result['tid'];
			$type = $this->GetStrBetween($orderno, 's', 'ti');
			$typeid = $this->GetStrBetween($orderno, 'ti', 'ui');
			$uid = $this->GetStrBetween($orderno, 'ui', 'e');
			if ($type == '01') {
				$vipgroup = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . "WHERE weid='{$_W['acid']}' AND id='{$typeid}'");
				$uservip = $this->findUserVip($uid);
				if (!empty($uservip)) {
					if ($vipgroup['validity'] == 0 || $uservip['validity'] == 0) {
						$endtime = 0;
					} else {
						$endtime = $uservip['endtime'] + 86400 * $vipgroup['validity'];
					}
					pdo_update(DBCONFIG::$TABLE_FFYD_VIP, array('vipid' => $typeid, 'uid' => $uid, 'endtime' => $endtime), array('id' => $uservip['user_vipid']));
				} else {
					if ($vipgroup['validity'] == 0) {
						$endtime = 0;
					} else {
						$endtime = TIMESTAMP + 86400 * $vipgroup['validity'];
					}
					$this->DelOldUserVip($uid);
					//增加记录前先清理之前失效的VIP记录
					$vipdata = array('weid' => $_W['acid'], 'vipid' => $typeid, 'price' => $pay_result['fee'], 'uid' => $uid, 'endtime' => $endtime);
					pdo_insert(DBCONFIG::$TABLE_FFYD_VIP, $vipdata);
				}
				$distribution = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION) . "WHERE weid='{$_W['acid']}' AND goodid='{$typeid}' AND orderno='{$pay_result['tid']}' AND type=1 AND status=0");
				if (!empty($distribution)) {
					pdo_update(DBCONFIG::$TABLE_FFYD_DISTRIBUTION, array('status' => 1), array('weid' => $_W['acid'], 'goodid' => $typeid, 'type' => 1, 'orderno' => $pay_result['tid'], 'status' => 0));
				}
			} elseif ($type == '03') {
				$recorddata = array('pid' => $typeid, 'uid' => $uid, 'weid' => $_W['acid'], 'price' => $pay_result['fee'], 'createtime' => TIMESTAMP);
				pdo_insert(DBCONFIG::$TABLE_FFYD_PACKAGE_RECORD, $recorddata);
				$package = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$typeid}'");
				$updata['buynum'] = $package['buynum'] + 1;
				pdo_update(DBCONFIG::$TABLE_FFYD_PACKAGE, $updata, array('id' => $typeid));
				$distribution = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION) . "WHERE weid='{$_W['acid']}' AND goodid='{$typeid}' AND orderno='{$pay_result['tid']}' AND type=3 AND status=0");
				if (!empty($distribution)) {
					pdo_update(DBCONFIG::$TABLE_FFYD_DISTRIBUTION, array('status' => 1), array('weid' => $_W['acid'], 'goodid' => $typeid, 'type' => 3, 'orderno' => $pay_result['tid'], 'status' => 0));
				}
			} else {
				$recorddata = array('articleid' => $typeid, 'uid' => $uid, 'weid' => $_W['acid'], 'price' => $pay_result['fee'], 'createtime' => TIMESTAMP);
				pdo_insert(DBCONFIG::$TABLE_FFYD_RECORD, $recorddata);
				$distribution = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION) . "WHERE weid='{$_W['acid']}' AND goodid='{$typeid}' AND orderno='{$pay_result['tid']}' AND type=2 AND status=0");
				if (!empty($distribution)) {
					pdo_update(DBCONFIG::$TABLE_FFYD_DISTRIBUTION, array('status' => 1), array('weid' => $_W['acid'], 'goodid' => $typeid, 'type' => 2, 'orderno' => $pay_result['tid'], 'status' => 0));
				}
			}
		}
		return $this->result(0, '支付成功', '');
	}
	public function doPagePayResult()
	{
		global $_GPC, $_W;
		$mod = $_GPC['mod'];
		if ($mod == 'vip') {
			$vipgroup = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . "WHERE weid='{$_W['acid']}' AND id='{$_GPC['id']}'");
			$pay_result = array('tid' => date('YmdHis', time()) . "s01ti" . $_GPC['id'] . "ui" . $_GPC['uid'] . "e", 'result' => 'success', 'fee' => $vipgroup['price']);
		} elseif ($mod == 'package') {
			$package = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$_GPC['pid']}'");
			$uservip = $this->findUserVip($_GPC['uid']);
			if (!empty($uservip) && $uservip['type'] == 1) {
				$price = $package['price'] * $uservip['discount'];
			} else {
				$price = $package['price'];
			}
			$orderno = date('YmdHis', time()) . "s03ti" . $package['id'] . "ui" . $_GPC['uid'] . "e";
			$params = array('ordersn' => $orderno, 'tid' => $orderno, 'user' => $_GPC['uid'], 'fee' => floatval($price), 'title' => $_W['account']['name'] . "专栏购买订单{$orderno}");
			$pay_result = array('tid' => date('YmdHis', time()) . "s03ti" . $package['id'] . "ui" . $_GPC['uid'] . "e", 'result' => 'success', 'fee' => $price);
		} else {
			$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$_GPC['articleid']}'");
			$uservip = $this->findUserVip($_GPC['uid']);
			if (!empty($uservip) && $uservip['type'] == 1) {
				$price = $article['price'] * $uservip['discount'];
			} else {
				$price = $article['price'];
			}
			$pay_result = array('tid' => date('YmdHis', time()) . "s02ti" . $_GPC['articleid'] . "ui" . $_GPC['uid'] . "e", 'result' => 'success', 'fee' => $price);
		}
		$message = '成功';
		if ($pay_result['result'] == 'success') {
			//此处会处理一些支付成功的业务代码
			$orderno = $pay_result['tid'];
			$type = $this->GetStrBetween($orderno, 's', 'ti');
			$typeid = $this->GetStrBetween($orderno, 'ti', 'ui');
			$uid = $this->GetStrBetween($orderno, 'ui', 'e');
			if ($type == '01') {
				$vipgroup = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . "WHERE weid='{$_W['acid']}' AND id='{$typeid}'");
				$uservip = $this->findUserVip($uid);
				if (!empty($uservip)) {
					if ($vipgroup['validity'] == 0 || $uservip['validity'] == 0) {
						$endtime = 0;
					} else {
						$endtime = $uservip['endtime'] + 86400 * $vipgroup['validity'];
					}
					pdo_update(DBCONFIG::$TABLE_FFYD_VIP, array('vipid' => $typeid, 'uid' => $uid, 'endtime' => $endtime), array('id' => $uservip['user_vipid']));
				} else {
					if ($vipgroup['validity'] == 0) {
						$endtime = 0;
					} else {
						$endtime = TIMESTAMP + 86400 * $vipgroup['validity'];
					}
					$this->DelOldUserVip($uid);
					//增加记录前先清理之前失效的VIP记录
					$vipdata = array('weid' => $_W['acid'], 'vipid' => $typeid, 'price' => $pay_result['fee'], 'uid' => $uid, 'endtime' => $endtime);
					pdo_insert(DBCONFIG::$TABLE_FFYD_VIP, $vipdata);
				}
			} elseif ($type == '03') {
				$recorddata = array('pid' => $typeid, 'uid' => $uid, 'weid' => $_W['acid'], 'price' => $pay_result['fee'], 'createtime' => TIMESTAMP);
				pdo_insert(DBCONFIG::$TABLE_FFYD_PACKAGE_RECORD, $recorddata);
				$package = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$typeid}'");
				$updata['buynum'] = $package['buynum'] + 1;
				pdo_update(DBCONFIG::$TABLE_FFYD_PACKAGE, $updata, array('id' => $typeid));
			} else {
				$recorddata = array('articleid' => $typeid, 'uid' => $uid, 'weid' => $_W['acid'], 'price' => $pay_result['fee'], 'createtime' => TIMESTAMP);
				pdo_insert(DBCONFIG::$TABLE_FFYD_RECORD, $recorddata);
			}
		}
		return $this->result(0, $message, '');
	}
	public function doPageBindDistributionUser()
	{
		global $_W, $_GPC;
		$message = '成功';
		$uid = $_GPC['uid'];
		$shareuid = $_GPC['shareuid'];
		$bindinfo = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION_USERBIND) . "WHERE weid='{$_W['acid']}' AND uid='{$uid}'");
		if (empty($bindinfo) && $shareuid != $uid) {
			$distribution_bind_data = array('weid' => $_W['acid'], 'topuid' => $shareuid, 'uid' => $uid, 'createtime' => TIMESTAMP);
			pdo_insert(DBCONFIG::$TABLE_FFYD_DISTRIBUTION_USERBIND, $distribution_bind_data);
		}
		return $this->result(0, $message, '');
	}
	public function doPageGetDistributionInfo()
	{
		global $_W, $_GPC;
		$message = '成功';
		$uid = $_GPC['uid'];
		$setting = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . " WHERE weid='{$_W['acid']}'");
		if ($setting['opendistribution'] == 0 && empty($setting['opendistribution'])) {
			return $this->result(-1, '未开启分享赚功能', '');
		}
		$result['setting'] = $setting;
		$distribution_num = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION_USERBIND) . " WHERE weid='{$_W['acid']}' AND topuid='{$uid}'");
		if (empty($distribution_num)) {
			$distribution_num = 0;
		}
		$result['distribution_num'] = $distribution_num;
		$distribution_price = pdo_fetchcolumn('SELECT SUM(price) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION) . " WHERE weid='{$_W['acid']}' AND uid='{$uid}' AND status=1");
		if (empty($distribution_price)) {
			$distribution_price = 0;
		}
		$withdrawprice = pdo_fetchcolumn('SELECT SUM(withdraw_price) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . " WHERE weid='{$_W['acid']}' AND uid='{$uid}' AND status=1 ");
		if (empty($withdrawprice)) {
			$withdrawprice = 0;
		}
		$result['withdraw_price'] = $withdrawprice;
		$result['distribution_price'] = $distribution_price;
		$result['allow_price'] = $distribution_price - $withdrawprice;
		return $this->result(0, $message, $result);
	}
	public function doPageGetDistributionLogList()
	{
		global $_GPC, $_W;
		$message = '成功';
		$uid = $_GPC['uid'];
		$type = $_GPC['type'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		load()->model('mc');
		$loglist = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION) . " WHERE weid='{$_W['acid']}' AND uid='{$uid}' AND status=1 ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
		foreach ($loglist as $key => $val) {
			$userinfo = mc_fansinfo($val['seconduid'], $_W['acid'], $_W['uniacid']);
			$loglist[$key]['username'] = $userinfo['nickname'];
			$loglist[$key]['useravatar'] = $userinfo['avatar'];
			$loglist[$key]['createtime'] = date('Y-m-d H:i:s', $val['createtime']);
		}
		return $this->result(0, $message, $loglist);
	}
	public function doPageGetDistributionUserList()
	{
		global $_GPC, $_W;
		$message = '成功';
		$uid = $_GPC['uid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		load()->model('mc');
		$userlist = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION_USERBIND) . " WHERE weid='{$_W['acid']}' AND topuid='{$uid}' ORDER BY id desc LIMIT " . ($pindex - 1) * $psize . "," . $psize);
		foreach ($userlist as $key => $val) {
			$userinfo = mc_fansinfo($val['uid'], $_W['acid'], $_W['uniacid']);
			$userlist[$key]['username'] = $userinfo['nickname'];
			$userlist[$key]['useravatar'] = $userinfo['avatar'];
			$userlist[$key]['createtime'] = date('Y-m-d H:i:s', $val['createtime']);
			$user_distributionprice = pdo_fetchcolumn('SELECT SUM(price) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION) . " WHERE weid='{$_W['acid']}' AND seconduid='{$val['uid']}' AND status=1");
			if (empty($user_distributionprice)) {
				$user_distributionprice = 0;
			}
			$userlist[$key]['distributionprice'] = $user_distributionprice;
		}
		return $this->result(0, $message, $userlist);
	}
	public function doPageUserWithdrawLog()
	{
		global $_W, $_GPC;
		$message = '成功';
		$uid = $_GPC['uid'];
		$endtime = TIMESTAMP;
		$last_success_withdraw = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . "WHERE weid='{$_W['acid']}' AND uid='{$uid}' AND status=1  ORDER BY id desc");
		$setting = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		if (!empty($last_success_withdraw)) {
			$price = pdo_fetchcolumn('SELECT SUM(price) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION) . " WHERE weid='{$_W['acid']}' AND uid='{$uid}' AND status=1");
			if (empty($price)) {
				$price = 0;
			}
			$withdraw_price = pdo_fetchcolumn('SELECT SUM(withdraw_price) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . " WHERE weid='{$_W['acid']}' AND uid='{$uid}' AND status=1 ");
			if (empty($withdraw_price)) {
				$withdraw_price = 0;
			}
			$result['all_price'] = $price;
			$result['already_price'] = $withdraw_price;
			$result['allow_price'] = $price - $withdraw_price;
			$last_success_withdraw['createtime'] = date('Y-m-d H:i', $last_success_withdraw['createtime']);
			$result['last_success_withdraw'] = $last_success_withdraw;
		} else {
			$price = pdo_fetchcolumn('SELECT SUM(price) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_DISTRIBUTION) . " WHERE weid='{$_W['acid']}' AND uid='{$uid}' AND status=1");
			if (empty($price)) {
				$price = 0;
			}
			$result['all_price'] = $price;
			$result['already_price'] = 0;
			$result['allow_price'] = $price;
			$last_success_withdraw['createtime'] = date('Y-m-d H:i', $last_success_withdraw['createtime']);
			$result['last_success_withdraw'] = '';
		}
		$last_withdraw = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . "WHERE weid='{$_W['acid']}' AND uid='{$uid}' ORDER BY id desc");
		if (!empty($last_withdraw)) {
			$last_withdraw['createtime'] = date('Y-m-d H:i', $last_withdraw['createtime']);
			$result['last_withdraw'] = $last_withdraw;
		} else {
			$result['last_withdraw'] = '';
		}
		if ($setting['user_withdraw_charge'] != '' && $setting['user_withdraw_charge'] != 0) {
			$charged_price = round($result['allow_price'] - $result['allow_price'] * $setting['user_withdraw_charge'], 2);
			$result['withdraw_charge'] = $setting['user_withdraw_charge'] * 100 . '%';
		} else {
			$charged_price = $result['allow_price'];
			$result['withdraw_charge'] = 0;
		}
		$result['charged_price'] = $charged_price;
		return $this->result(0, $message, $result);
	}
	public function doPagePostUserWithdraw()
	{
		global $_W, $_GPC;
		$message = '成功';
		$uid = $_GPC['uid'];
		$lastwithdraw = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . "WHERE weid='{$_W['acid']}' AND uid='{$uid}' AND status=0");
		if (!empty($lastwithdraw)) {
			return $this->result(-2, '您还有正在审核中的提现申请，请等待审核完成后再提交', '');
		}
		$setting = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		if ($setting['user_withdraw_charge'] != '' && $setting['user_withdraw_charge'] != 0) {
			$charged_price = round($_GPC['withdrawprice'] - $_GPC['withdrawprice'] * $setting['user_withdraw_charge'], 2);
		} else {
			$charged_price = $_GPC['withdrawprice'];
		}
		$result['charged_price'] = $charged_price;
		$data = array('uid' => $uid, 'weid' => $_W['acid'], 'status' => 0, 'charged_price' => $charged_price, 'withdraw_price' => $_GPC['withdrawprice'], 'allprice' => $_GPC['allprice'], 'createtime' => TIMESTAMP);
		pdo_insert(DBCONFIG::$TABLE_FFYD_USERWITHDRAW, $data);
		return $this->result(0, '成功', '');
	}
	public function doPageGetPosterBg()
	{
		global $_GPC, $_W;
		$default_bg = $_W['siteroot'] . '/addons/ypuk_ffyd/images/poster_bg.jpg';
		$setting = pdo_fetch("SELECT poster_bg FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}'");
		if (!empty($setting['poster_bg'])) {
			$result = unserialize($setting['poster_bg']);
			foreach ($result as $key => $val) {
				$result[$key] = tomedia($val);
			}
		} else {
			$result[0] = $default_bg;
		}
		return $this->result(0, '成功', $result);
	}
	public function doPageGetPosterObjectDetail()
	{
		global $_GPC, $_W;
		$objecttype = $_GPC['objecttype'];
		$objectid = $_GPC['objectid'];
		if ($objecttype == 'article') {
			$result = pdo_fetch("SELECT intro,thumb,title FROM " . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid='{$_W['acid']}' AND id='{$objectid}'");
			$result['thumb'] = tomedia($result['thumb']);
		}
		if ($objecttype == 'package') {
			$result = pdo_fetch("SELECT intro,thumb,title FROM " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . " WHERE weid='{$_W['acid']}' AND id='{$objectid}'");
			$result['thumb'] = tomedia($result['thumb']);
		}
		return $this->result(0, '成功', $result);
	}
	public function doPageGetPosterQr()
	{
		global $_GPC, $_W;
		$objecttype = $_GPC['objecttype'];
		$shareuid = $_GPC['shareuid'];
		$objectid = $_GPC['objectid'];
		//判断文件夹是否存在
		load()->func('file');
		if ($objecttype == 'article') {
			$filename = ATTACHMENT_ROOT . '/ypuk_ffyd/qr/article_' . $objectid . '_' . $_W['acid'] . '_' . $shareuid . '_qr.jpg';
			$medianame = '/ypuk_ffyd/qr/article_' . $objectid . '_' . $_W['acid'] . '_' . $shareuid . '_qr.jpg';
			$article = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid='{$_W['acid']}' AND id='{$objectid}'");
			$page = 'ypuk_ffyd/pages/' . $article['type'] . '_detail/' . $article['type'] . '_detail';
		}
		if ($objecttype == 'package') {
			$filename = ATTACHMENT_ROOT . '/ypuk_ffyd/qr/package_' . $objectid . '_' . $_W['acid'] . '_' . $shareuid . '_qr.jpg';
			$medianame = '/ypuk_ffyd/qr/package_' . $objectid . '_' . $_W['acid'] . '_' . $shareuid . '_qr.jpg';
			$page = 'ypuk_ffyd/pages/package_detail/package_detail';
		}
		if (file_exists($filename)) {
			return $this->result(0, '成功', tomedia($medianame));
		} else {
			if (!file_exists(ATTACHMENT_ROOT . '/ypuk_ffyd/qr')) {
				mkdirs(ATTACHMENT_ROOT . '/ypuk_ffyd/qr');
			}
			$appinfo = WxappAccount::create($_W['acid']);
			$accesstoken = $appinfo->getAccessToken();
			load()->func('communication');
			$url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $accesstoken;
			$data = array('scene' => 'id' . $objectid . 'shareuid' . $shareuid, 'page' => $page, 'width' => 630);
			$response = ihttp_post($url, json_encode($data));
			if (empty($response['content'])) {
				echo 'nostream';
				exit;
			}
			$file = fopen($filename, "w");
			//打开文件准备写入
			fwrite($file, $response['content']);
			//写入
			fclose($file);
			//关闭
			return $this->result(0, '成功', tomedia($medianame));
		}
	}
	/**
	 * 获取砍价页面二维码
	 */
	public function GetBargainQr($bargainid)
	{
		global $_GPC, $_W;
		//判断文件夹是否存在
		load()->func('file');
		$filename = ATTACHMENT_ROOT . '/ypuk_kjb/bargain_' . $bargainid . '_' . $_W['acid'] . '.jpg';
		if (file_exists($filename)) {
			return $filename;
		} else {
			if (!file_exists(ATTACHMENT_ROOT . '/ypuk_kjb')) {
				mkdirs(ATTACHMENT_ROOT . '/ypuk_kjb');
			}
			$appinfo = WxappAccount::create($_W['acid']);
			$accesstoken = $appinfo->getAccessToken();
			load()->func('communication');
			$url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $accesstoken;
			$data = array('scene' => $bargainid, 'page' => 'ypuk_kjb/pages/bargain/bargain', 'width' => 630);
			$response = ihttp_post($url, json_encode($data));
			if (empty($response['content'])) {
				echo 'nostream';
				exit;
			}
			$file = fopen($filename, "w");
			//打开文件准备写入
			fwrite($file, $response['content']);
			//写入
			fclose($file);
			//关闭
			return $filename;
		}
	}
	/**
	 * 查找用户购买记录
	 */
	public function findUserRecord($articleid, $uid)
	{
		global $_W;
		return pdo_fetch("select * from " . tablename(DBCONFIG::$TABLE_FFYD_RECORD) . "WHERE articleid='{$articleid}' AND uid='{$uid}' AND weid='{$_W['acid']}'");
	}
	/**
	 * 查找用户购买专栏记录
	 */
	public function findUserPackageRecord($pid, $uid)
	{
		global $_W;
		return pdo_fetch("select * from " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_RECORD) . "WHERE pid='{$pid}' AND uid='{$uid}' AND weid='{$_W['acid']}'");
	}
	/**
	 * 查找用户是否VIP
	 */
	public function findUserVip($uid)
	{
		global $_W;
		//$uid = '763';
		$vip = pdo_fetch("select * from " . tablename(DBCONFIG::$TABLE_FFYD_VIP) . "WHERE uid='{$uid}' AND weid='{$_W['acid']}'");
		if (!empty($vip)) {
			$vipinfo = pdo_fetch("select * from " . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . "WHERE id='{$vip['vipid']}' AND weid='{$_W['acid']}'");
			if ($vip['endtime'] != 0 && $vip['endtime'] < TIMESTAMP) {
				return false;
			} else {
				$vipinfo['endtime'] = $vip['endtime'];
				$vipinfo['user_vipid'] = $vip['id'];
				return $vipinfo;
			}
		} else {
			return false;
		}
	}
	/**
	 *  清理用户之前的VIP记录，使数据库中始终只保存一条用户VIP记录
	 */
	public function DelOldUserVip($uid)
	{
		global $_W;
		$vip = pdo_fetch("select * from " . tablename(DBCONFIG::$TABLE_FFYD_VIP) . "WHERE uid='{$uid}' AND weid='{$_W['acid']}'");
		if (!empty($vip)) {
			if ($vip['endtime'] != 0 && $vip['endtime'] < TIMESTAMP) {
				pdo_delete(DBCONFIG::$TABLE_FFYD_VIP, array("id" => $vip['id']));
			}
		} else {
			return false;
		}
	}
	/**
	 *  读取orderno中的信息
	 */
	public function GetStrBetween($content, $start, $end)
	{
		$r = explode($start, $content);
		if (isset($r[1])) {
			$r = explode($end, $r[1]);
			return $r[0];
		}
		return '';
	}
	/**
	 *  增加formid
	 */
	public function add_formid($aid, $uid, $formid)
	{
		global $_W;
		load()->model('mc');
		$user = mc_fansinfo($uid, $_W['acid']);
		$formid_data = array('weid' => $_W['acid'], 'openid' => $user['openid'], 'formid' => $formid, 'aid' => $aid, 'createtime' => TIMESTAMP);
		pdo_insert(DBCONFIG::$TABLE_KJB_FORMID, $formid_data);
	}
	/**
	 *  删除单条formid记录
	 */
	public function del_one_formid($formid)
	{
		global $_W;
		pdo_delete(DBCONFIG::$TABLE_KJB_FORMID, array("id" => $formid));
	}
	/**
	 *  删除用户在活动下的所有formid
	 */
	public function del_all_formid($aid, $uid)
	{
		global $_W;
		load()->model('mc');
		$user = mc_fansinfo($uid, $_W['acid']);
		pdo_delete(DBCONFIG::$TABLE_KJB_FORMID, array("aid" => $aid, "openid" => $user['openid']));
	}
	/**
	 *  发送砍价成功的模板消息
	 */
	public function send_success_template_message($bargainid)
	{
		global $_W;
		load()->model('mc');
		$setting = pdo_fetch("select * from " . tablename(DBCONFIG::$TABLE_KJB_SETTING) . "WHERE weid='{$_W['acid']}'");
		$template_id = $setting['success_template_id'];
		$bargain = pdo_fetch("select * from " . tablename(DBCONFIG::$TABLE_KJB_BARGAIN) . "WHERE id='{$bargainid}' AND weid='{$_W['acid']}'");
		$activity = pdo_fetch("select * from " . tablename(DBCONFIG::$TABLE_KJB_ACTIVITY) . "WHERE id='{$bargain['aid']}' AND weid='{$_W['acid']}'");
		$user = mc_fansinfo($bargain['uid'], $_W['acid']);
		$formid = pdo_fetch("SELECT * FROM " . tablename(DBCONFIG::$TABLE_KJB_FORMID) . " WHERE weid='{$_W['acid']}' AND openid='{$user['openid']}' AND aid='{$activity['id']}' ORDER BY createtime desc");
		$opendId = $user['openid'];
		// template_id  是   所需下发的模板消息的id
		// page 否   点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
		$page = "ypuk_kjb/pages/bargain/bargain?bargainid=" . $bargainid;
		// data 是   模板内容，不填则下发空模板
		$data = array("keyword1" => array("value" => $activity['title'], "color" => "#4a4a4a"), "keyword2" => array("value" => "你发起的砍价已砍价成功，点击提交订单", "color" => "#9b9b9b"), "keyword3" => array("value" => date('Y-m-d H:i:s', time()), "color" => "#9b9b9b"));
		// color    否   模板内容字体的颜色，不填默认黑色
		$color = "#3f3f3f";
		// emphasis_keyword 否   模板需要放大的关键词，不填则默认无放大
		$content = json_encode(array('touser' => $opendId, 'template_id' => $template_id, 'page' => $page, 'form_id' => $formid['formid'], 'data' => $data, 'color' => $color));
		$appinfo = WxappAccount::create($_W['acid']);
		$accesstoken = $appinfo->getAccessToken();
		load()->func('communication');
		$url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token={$accesstoken}";
		$response = ihttp_post($url, $content);
		if (empty($response['content'])) {
			echo 'nostream';
			exit;
		}
		$this->del_one_formid($formid['id']);
		return $response;
	}
	public function checkCloseIosPay($version, $appos)
	{
		global $_W;
		$setting = pdo_fetch("SELECT help_examine_open FROM " . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . " WHERE weid='{$_W['acid']}'");
		if ($version == $this::$SERVER_VERSION && $setting['help_examine_open'] == 2 && $appos == 'iOS') {
			return 1;
		} else {
			return 0;
		}
	}
}