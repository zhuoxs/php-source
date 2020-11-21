<?php


defined('IN_IA') or exit('Access Denied');
define("YPUK_FFYD", "ypuk_ffyd");
define("YPUK_FFYD_RES", "../addons/" . YPUK_FFYD . "/");
require_once IA_ROOT . "/addons/" . YPUK_FFYD . "/dbconfig.class.php";
/**
 * Class Ypuk_KjbModuleSite
 */
class Ypuk_ffydModuleSite extends WeModuleSite
{
	public $Setting;
	/************************************************管理*********************************/
	/**
	 * 文章管理
	 */
	public function doWebArticle()
	{
		global $_W, $_GPC;
		$this->checkWQOrder();
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$id = $_GPC['id'];
		if ($operation == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$type = $_GPC['type'];
			if (!empty($type)) {
				$where = " AND type='" . $type . "'";
			}
			$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid =:weid" . $where . " ORDER BY createtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $_W['acid']));
			foreach ($list as $key => $val) {
				if ($val['thumb']) {
					$list[$key]['thumb'] = tomedia($list[$key]['thumb']);
				}
			}
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . " WHERE weid =:weid" . $where, array(':weid' => $_W['acid']));
			$pager = pagination($total, $pindex, $psize);
			include $this->template("article_list");
		} else {
			if ($operation == 'post') {
				$packages = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid = :weid", array(':weid' => $_W['acid']));
				$article['subcat_select'] = 0;
				$article['parent_select'] = 0;
				//读取栏目
				$parentcat = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid = :weid AND parentid = 0", array(':weid' => $_W['acid']));
				if (!empty($id)) {
					$article = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_ARTICLE) . "WHERE weid='{$_W['acid']}' AND id='{$id}'");
					$article_type = $article['type'];
					$packages_bind = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid = :weid AND articleid = :articleid", array(':weid' => $_W['acid'], ':articleid' => $id));
					if (!empty($packages_bind)) {
						$packages_info = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid = :weid AND id = :pid", array(':weid' => $_W['acid'], ':pid' => $packages_bind['pid']));
						$packages_bind['title'] = $packages_info['title'];
					}
					if (!empty($article['catid'])) {
						$catinfo = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE id='{$article['catid']}' AND weid='{$_W['acid']}'");
						$subcat = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid = :weid AND parentid = :parentid", array(':weid' => $_W['acid'], ':parentid' => $catinfo['parentid']));
						$article['parent_select'] = $catinfo['parentid'];
						$article['subcat_select'] = $article['catid'];
					}
					switch ($article_type) {
						case 'audio':
							$article_content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_AUDIO_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
							$article['audio'] = $article_content['audio'];
							$article['audiotime'] = $article_content['audiotime'];
							$article['text'] = htmlspecialchars_decode($article_content['text']);
							$article['preview_audio'] = $article_content['preview_audio'];
							break;
						case 'video':
							$article_content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIDEO_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
							$article['video'] = $article_content['video'];
							$article['videopic'] = $article_content['videopic'];
							$article['videotype'] = $article_content['videotype'];
							$article['text'] = htmlspecialchars_decode($article_content['text']);
							$article['preview_time'] = $article_content['preview_time'];
							break;
						case 'text':
							$article_content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_TEXT_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
							$article['text'] = htmlspecialchars_decode($article_content['text']);
							$article['preview_text'] = htmlspecialchars_decode($article_content['preview_text']);
							break;
						case 'pic':
							$article_content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PIC_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
							$article['piclist'] = unserialize($article_content['piclist']);
							$article['preview_number'] = $article_content['preview_number'];
							break;
						case 'pdf':
							$article_content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PDF_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
							$article['pdffile'] = $article_content['pdffile'];
							break;
					}
				} else {
					$article_type = $_GPC['type'];
				}
				if ($_W['ispost']) {
					if (empty($_GPC['subcat'])) {
						message('请选择二级分类', referer(), 'warning');
					}
					$data = array('weid' => $_W['acid'], 'title' => $_GPC['title'], 'type' => $_GPC['type'], 'price' => $_GPC['price'], 'thumb' => $_GPC['thumb'], 'intro' => $_GPC['intro'], 'catid' => $_GPC['subcat'], 'recommend' => $_GPC['recommend'], 'status' => $_GPC['status'], 'copytext' => $_GPC['copytext'], 'sort' => $_GPC['sort'] ? $_GPC['sort'] : 999, 'distribution_commission' => $_GPC['distribution_commission']);
					if (empty($id)) {
						$data['createtime'] = TIMESTAMP;
						pdo_insert(DBCONFIG::$TABLE_FFYD_ARTICLE, $data);
						$articleid = pdo_insertid();
						if (!empty($_GPC['package']) && $_GPC['package'] != 'no') {
							$packages_bind_data = array('weid' => $_W['acid'], 'articleid' => $articleid, 'pid' => $_GPC['package'], 'createtime' => TIMESTAMP, 'sort' => $_GPC['package_sort'] ? $_GPC['package_sort'] : 999);
							pdo_insert(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND, $packages_bind_data);
						}
						$contentdata = array('weid' => $_W['acid'], 'articleid' => $articleid);
						switch ($_GPC['type']) {
							case 'audio':
								$contentdata['text'] = htmlspecialchars($_GPC['text']);
								$contentdata['audio'] = $_GPC['audio'];
								$contentdata['audiotime'] = $_GPC['audiotime'];
								$contentdata['preview_audio'] = $_GPC['preview_audio'];
								pdo_insert(DBCONFIG::$TABLE_FFYD_AUDIO_CONTENT, $contentdata);
								message('添加成功', referer(), 'success');
								break;
							case 'video':
								$contentdata['text'] = htmlspecialchars($_GPC['text']);
								$contentdata['videotype'] = $_GPC['videotype'];
								if ($contentdata['videotype'] == 0) {
									$contentdata['video'] = $_GPC['video'];
								}
								if ($contentdata['videotype'] == 1) {
									$contentdata['video'] = $_GPC['qqvideo_url'];
								}
								$contentdata['videopic'] = $_GPC['videopic'];
								$contentdata['preview_time'] = $_GPC['preview_time'];
								pdo_insert(DBCONFIG::$TABLE_FFYD_VIDEO_CONTENT, $contentdata);
								message('添加成功', referer(), 'success');
								break;
							case 'text':
								$contentdata['text'] = htmlspecialchars($_GPC['text']);
								$contentdata['preview_text'] = htmlspecialchars($_GPC['preview_text']);
								pdo_insert(DBCONFIG::$TABLE_FFYD_TEXT_CONTENT, $contentdata);
								message('添加成功', referer(), 'success');
								break;
							case 'pic':
								$contentdata['piclist'] = serialize($_GPC['piclist']);
								$contentdata['preview_number'] = $_GPC['preview_number'];
								pdo_insert(DBCONFIG::$TABLE_FFYD_PIC_CONTENT, $contentdata);
								message('添加成功', referer(), 'success');
								break;
							case 'pdf':
								$contentdata['pdffile'] = $_GPC['pdffile'];
								pdo_insert(DBCONFIG::$TABLE_FFYD_PDF_CONTENT, $contentdata);
								message('添加成功', referer(), 'success');
								break;
						}
					} else {
						if (!empty($_GPC['package'])) {
							$nowpackage = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
							if (!empty($nowpackage)) {
								if ($_GPC['package'] == 'no') {
									//清理掉关联记录
									pdo_delete(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND, array('articleid' => $id));
								} else {
									$package_sort = $_GPC['package_sort'] ? $_GPC['package_sort'] : 999;
									pdo_update(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND, array('pid' => $_GPC['package'], 'createtime' => TIMESTAMP, 'sort' => $package_sort), array('articleid' => $id));
								}
							} else {
								$packages_bind_data = array('weid' => $_W['acid'], 'articleid' => $id, 'pid' => $_GPC['package'], 'createtime' => TIMESTAMP, 'sort' => $_GPC['package_sort'] ? $_GPC['package_sort'] : 999);
								pdo_insert(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND, $packages_bind_data);
							}
						}
						pdo_update(DBCONFIG::$TABLE_FFYD_ARTICLE, $data, array('id' => $id));
						switch ($_GPC['type']) {
							case 'audio':
								$content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_AUDIO_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
								$contentdata['text'] = htmlspecialchars($_GPC['text']);
								$contentdata['audio'] = $_GPC['audio'];
								$contentdata['audiotime'] = $_GPC['audiotime'];
								$contentdata['preview_audio'] = $_GPC['preview_audio'];
								if (!empty($content)) {
									pdo_update(DBCONFIG::$TABLE_FFYD_AUDIO_CONTENT, $contentdata, array('articleid' => $id));
								} else {
									$contentdata['weid'] = $_W['acid'];
									$contentdata['articleid'] = $id;
									pdo_insert(DBCONFIG::$TABLE_FFYD_AUDIO_CONTENT, $contentdata);
								}
								break;
							case 'video':
								$content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIDEO_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
								$contentdata['text'] = htmlspecialchars($_GPC['text']);
								$contentdata['videotype'] = $_GPC['videotype'];
								if ($contentdata['videotype'] == 0) {
									$contentdata['video'] = $_GPC['video'];
								}
								if ($contentdata['videotype'] == 1) {
									$contentdata['video'] = $_GPC['qqvideo_url'];
								}
								$contentdata['videopic'] = $_GPC['videopic'];
								$contentdata['preview_time'] = $_GPC['preview_time'];
								if (!empty($content)) {
									pdo_update(DBCONFIG::$TABLE_FFYD_VIDEO_CONTENT, $contentdata, array('articleid' => $id));
								} else {
									$contentdata['weid'] = $_W['acid'];
									$contentdata['articleid'] = $id;
									pdo_insert(DBCONFIG::$TABLE_FFYD_VIDEO_CONTENT, $contentdata);
								}
								break;
							case 'text':
								$content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_TEXT_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
								$contentdata['text'] = htmlspecialchars($_GPC['text']);
								$contentdata['preview_text'] = htmlspecialchars($_GPC['preview_text']);
								if (!empty($content)) {
									pdo_update(DBCONFIG::$TABLE_FFYD_TEXT_CONTENT, $contentdata, array('articleid' => $id));
								} else {
									$contentdata['weid'] = $_W['acid'];
									$contentdata['articleid'] = $id;
									pdo_insert(DBCONFIG::$TABLE_FFYD_TEXT_CONTENT, $contentdata);
								}
								break;
							case 'pic':
								$content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PIC_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
								$contentdata['piclist'] = serialize($_GPC['piclist']);
								$contentdata['preview_number'] = $_GPC['preview_number'];
								if (!empty($content)) {
									pdo_update(DBCONFIG::$TABLE_FFYD_PIC_CONTENT, $contentdata, array('articleid' => $id));
								} else {
									$contentdata['weid'] = $_W['acid'];
									$contentdata['articleid'] = $id;
									pdo_insert(DBCONFIG::$TABLE_FFYD_PIC_CONTENT, $contentdata);
								}
								break;
							case 'pdf':
								$content = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PDF_CONTENT) . "WHERE weid='{$_W['acid']}' AND articleid='{$id}'");
								$contentdata['pdffile'] = $_GPC['pdffile'];
								if (!empty($content)) {
									pdo_update(DBCONFIG::$TABLE_FFYD_PDF_CONTENT, $contentdata, array('articleid' => $id));
								} else {
									$contentdata['weid'] = $_W['acid'];
									$contentdata['articleid'] = $id;
									pdo_insert(DBCONFIG::$TABLE_FFYD_PDF_CONTENT, $contentdata);
								}
								break;
						}
						message('更新成功', referer(), 'success');
					}
				}
				include $this->template("article_" . $article_type . "_edit");
			} else {
				if ($operation == 'delete') {
					$id = $_GPC['id'];
					pdo_delete(DBCONFIG::$TABLE_FFYD_ARTICLE, array("id" => $id));
					pdo_delete(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND, array('articleid' => $id));
					pdo_delete(DBCONFIG::$TABLE_FFYD_RECORD, array("articleid" => $id));
					pdo_delete(DBCONFIG::$TABLE_FFYD_AUDIO_CONTENT, array("articleid" => $id));
					pdo_delete(DBCONFIG::$TABLE_FFYD_VIDEO_CONTENT, array("articleid" => $id));
					pdo_delete(DBCONFIG::$TABLE_FFYD_TEXT_CONTENT, array("articleid" => $id));
					pdo_delete(DBCONFIG::$TABLE_FFYD_PIC_CONTENT, array('articleid' => $id));
					pdo_delete(DBCONFIG::$TABLE_FFYD_PDF_CONTENT, array('articleid' => $id));
					message('删除成功！', referer(), 'success');
				}
			}
		}
	}
	public function doWebDeleteAllPackageBind()
	{
		global $_GPC, $_W;
		pdo_query("TRUNCATE TABLE " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND));
		message('清空成功', referer(), 'success');
	}
	public function doWebPackage()
	{
		global $_GPC, $_W;
		$this->checkWQOrder();
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$id = intval($_GPC['id']);
		if ($op == 'post') {
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . "WHERE weid='{$_W['acid']}' AND id='{$id}'");
			}
			if ($_W['ispost']) {
				$data = array('weid' => $_W['acid'], 'title' => $_GPC['title'], 'intro' => $_GPC['intro'], 'sort' => $_GPC['sort'], 'status' => $_GPC['status'], 'recommend' => $_GPC['recommend'], 'buynum_min' => $_GPC['buynum_min'], 'thumb' => $_GPC['thumb'], 'content' => $_GPC['content'], 'price' => $_GPC['price'], 'createtime' => TIMESTAMP, 'distribution_commission' => $_GPC['distribution_commission']);
				if (empty($id)) {
					pdo_insert(DBCONFIG::$TABLE_FFYD_PACKAGE, $data);
					message('添加成功', $this->createWebUrl('Package'), 'success');
				} else {
					pdo_update(DBCONFIG::$TABLE_FFYD_PACKAGE, $data, array('id' => $id));
					message('更新成功', $this->createWebUrl('Package'), 'success');
				}
			}
		} elseif ($op == 'display') {
			$list = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE) . " WHERE weid = '{$_W['acid']}'");
			foreach ($list as $key => $value) {
				$list[$key]['updatenum'] = pdo_fetchcolumn("SELECT COUNT(*) FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_BIND) . "WHERE weid='{$_W['acid']}' AND pid = {$value['id']}");
			}
		} else {
			if ($op == 'delete') {
				$id = $_GPC['id'];
				pdo_delete(DBCONFIG::$TABLE_FFYD_PACKAGE, array("id" => $id));
				message('删除成功', $this->createWebUrl('Package'), 'success');
			}
		}
		include $this->template('package');
	}
	public function doWebPackageCode()
	{
		global $_GPC, $_W;
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$pid = intval($_GPC['pid']);
		if ($op == 'add') {
			$data = array('weid' => $_W['acid'], 'pid' => $pid, 'status' => 0, 'createtime' => TIMESTAMP);
			for ($i = 0; $i < 10; $i++) {
				$data['codeaccount'] = $this->makecode(TIMESTAMP . rand(99, 9999));
				$data['codepwd'] = rand(100000, 999999);
				pdo_insert(DBCONFIG::$TABLE_FFYD_PACKAGE_CODE, $data);
				if ($i == 9) {
					message('生成成功', $this->createWebUrl('PackageCode', array('pid' => $pid)), 'success');
				}
			}
		} elseif ($op == 'display') {
			$list = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_CODE) . " WHERE weid = '{$_W['acid']}' AND pid='{$pid}'");
		} elseif ($op == 'repeat') {
			pdo_query("DELETE FROM " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_CODE) . " WHERE status=0 AND weid='{$_W['acid']}' AND id NOT IN (SELECT id FROM (SELECT MAX(id) as id FROM " . tablename(DBCONFIG::$TABLE_FFYD_PACKAGE_CODE) . " as b GROUP BY b.codeaccount) AS a)");
			message('去重成功', referer(), 'success');
		}
		if (checksubmit('delete')) {
			pdo_delete(DBCONFIG::$TABLE_FFYD_PACKAGE_CODE, " id  IN  (" . implode(",", $_GPC['select']) . ")");
			message('删除成功', referer(), 'success');
		}
		include $this->template('packagecode');
	}
	//分类
	public function doWebCategory()
	{
		global $_GPC, $_W;
		$this->checkWQOrder();
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$id = intval($_GPC['id']);
		if ($op == 'post') {
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid='{$_W['acid']}' AND id='{$id}'");
			}
			if ($_W['ispost']) {
				$data = array('weid' => $_W['acid'], 'name' => $_GPC['cname'], 'parentid' => $_GPC['parentid'], 'enabled' => $_GPC['enabled'] ? 1 : 0, 'icon' => $_GPC['icon']);
				if (empty($id)) {
					pdo_insert(DBCONFIG::$TABLE_FFYD_CATEGORY, $data);
					message('添加成功', $this->createWebUrl('Category'), 'success');
				} else {
					pdo_update(DBCONFIG::$TABLE_FFYD_CATEGORY, $data, array('id' => $id));
					message('更新成功', $this->createWebUrl('Category'), 'success');
				}
			}
		} elseif ($op == 'display') {
			$o = '';
			$parents = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . " WHERE weid = '{$_W['acid']}' AND parentid = 0");
			foreach ($parents as $parent) {
				$enable = intval($parent['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
				$o .= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$parent['id']}\" /></td>";
				$o .= "<td>" . $parent['name'] . "</td>";
				$o .= "<td> —— </td>";
				$o .= "<td>" . $enable . "</td>";
				$o .= "<td><a href=" . $this->createWebUrl('category', array('op' => 'post', 'id' => $parent['id'])) . " >编辑</a></td></tr>";
				$subcates = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . " WHERE parentid = {$parent['id']}");
				foreach ($subcates as $subcate) {
					$enable = intval($subcate['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
					$o .= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$subcate['id']}\" /></td>";
					$o .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|——" . $subcate['name'] . "</td>";
					$o .= "<td>" . $parent['name'] . "</td>";
					$o .= "<td>" . $enable . "</td>";
					$o .= "<td><a href=" . $this->createWebUrl('category', array('op' => 'post', 'id' => $subcate['id'])) . ">编辑</a></td></tr>";
				}
			}
		}
		if (checksubmit('delete')) {
			pdo_delete(DBCONFIG::$TABLE_FFYD_CATEGORY, " id  IN  ('" . implode(",", $_GPC['select']) . "')");
			message('删除成功', referer(), 'success');
		}
		//增加父栏目
		$categorys = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid = :weid AND parentid = 0", array(':weid' => $_W['acid']));
		include $this->template('category');
	}
	public function doWebAjaxCat()
	{
		global $_W, $_GPC;
		$returns = array();
		$data = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_CATEGORY) . "WHERE weid='{$_W['acid']}' AND parentid='{$_GPC['id']}'");
		$div = '<option value="0">选择分类</option>';
		if ($data && $_GPC['id'] != 0) {
			foreach ($data as $ke => $va) {
				$div .= '<option value="' . $va['id'] . '">';
				$div .= $va['name'];
				$div .= '</option>';
			}
			$returns = array('status' => 1, 'data' => $div);
		} else {
			$returns = array('status' => 2, 'data' => $div);
		}
		echo json_encode($returns, true);
	}
	/**
	 * 设置
	 */
	public function doWebSetting()
	{
		global $_GPC, $_W;
		$this->checkWQOrder();
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'common';
		$cert_pem = ATTACHMENT_ROOT . '/ypuk_ffyd/cert_' . $_W['acid'] . '/apiclient_cert.pem';
		if (file_exists($cert_pem)) {
			$has_cert = 1;
		} else {
			$has_cert = 0;
		}
		$key_pem = ATTACHMENT_ROOT . '/ypuk_ffyd/cert_' . $_W['acid'] . '/apiclient_key.pem';
		if (file_exists($key_pem)) {
			$has_key = 1;
		} else {
			$has_key = 0;
		}
		$setting = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}' ");
		$swiper = unserialize($setting['swiper']);
		if (!empty($setting['poster_bg'])) {
			$setting['poster_bg'] = unserialize($setting['poster_bg']);
		}
		if (checksubmit('submit')) {
			if ($_GPC['mod'] == 'common') {
				$data = array('weid' => $_W['acid'], 'rooturl' => trim($_GPC['rooturl']), 'openkefu' => $_GPC['openkefu'], 'navtype' => $_GPC['navtype'], 'kefutype' => $_GPC['kefutype'], 'kefuqr' => $_GPC['kefuqr'], 'index_view_text' => $_GPC['index_view_text'], 'index_new_text' => $_GPC['index_new_text'], 'opendistribution' => $_GPC['opendistribution'], 'poster_bg' => serialize($_GPC['poster_bg']), 'openposter' => $_GPC['openposter'], 'open_package_activation' => $_GPC['open_package_activation']);
				if (!empty($setting)) {
					pdo_update(DBCONFIG::$TABLE_FFYD_SETTING, $data, array('id' => $setting['id']));
				} else {
					pdo_insert(DBCONFIG::$TABLE_FFYD_SETTING, $data);
				}
				message('参数设置成功！', $this->createWebUrl('Setting', array('op' => 'common')), 'success');
			} elseif ($_GPC['mod'] == 'swiper') {
				$swiper_arr = array();
				$swiper_image = $_GPC['swiper_image'];
				$swiper_page = $_GPC['swiper_page'];
				$swiper_pageid = $_GPC['swiper_pageid'];
				$swiper_sort = $_GPC['swiper_sort'];
				if (!empty($swiper_image) && $swiper_image[0] != '') {
					foreach ($swiper_image as $key => $value) {
						$d = array('swiper_image' => $swiper_image[$key], 'swiper_page' => $swiper_page[$key], 'swiper_pageid' => $swiper_pageid[$key], 'swiper_sort' => $swiper_sort[$key]);
						$swiper_arr[] = $d;
					}
					$data = array('weid' => $_W['acid'], 'swiper' => serialize($swiper_arr));
				} else {
					$data = array('weid' => $_W['acid'], 'swiper' => '');
				}
				if (!empty($setting)) {
					pdo_update(DBCONFIG::$TABLE_FFYD_SETTING, $data, array('id' => $setting['id']));
				} else {
					pdo_insert(DBCONFIG::$TABLE_FFYD_SETTING, $data);
				}
				message('参数设置成功！', $this->createWebUrl('Setting', array('op' => 'swiper')), 'success');
			} elseif ($_GPC['mod'] == 'withdraw') {
				$data = array('weid' => $_W['acid'], 'user_withdraw_open' => $_GPC['user_withdraw_open'], 'user_withdraw_charge' => $_GPC['user_withdraw_charge'], 'user_withdraw_type' => $_GPC['user_withdraw_type']);
				if ($data['withdraw_open'] == 1) {
					if (empty($_FILES['cert_pem'])) {
						itoast('请上传apiclient_cert.pem证书', '', 'info');
					}
					if (empty($_FILES['key_pem'])) {
						itoast('请上传apiclient_key.pem证书', '', 'info');
					}
					$cert_pem_tmp = $_FILES['cert_pem']['tmp_name'];
					$key_pem_tmp = $_FILES['key_pem']['tmp_name'];
					load()->func('file');
					if (!file_exists(ATTACHMENT_ROOT . '/ypuk_ffyd/cert_' . $_W['acid'])) {
						mkdirs(ATTACHMENT_ROOT . '/ypuk_ffyd/cert_' . $_W['acid']);
					}
					move_uploaded_file($cert_pem_tmp, ATTACHMENT_ROOT . '/ypuk_ffyd/cert_' . $_W['acid'] . '/apiclient_cert.pem');
					move_uploaded_file($key_pem_tmp, ATTACHMENT_ROOT . '/ypuk_ffyd/cert_' . $_W['acid'] . '/apiclient_key.pem');
				}
				if (!empty($setting)) {
					pdo_update(DBCONFIG::$TABLE_FFYD_SETTING, $data, array('id' => $setting['id']));
				} else {
					pdo_insert(DBCONFIG::$TABLE_FFYD_SETTING, $data);
				}
				message('参数设置成功！', $this->createWebUrl('Setting', array('op' => 'withdraw')), 'success');
			} elseif ($_GPC['mod'] == 'help_examine') {
				$data = array('weid' => $_W['acid'], 'help_examine_open' => $_GPC['help_examine_open'], 'help_examine_index' => htmlspecialchars($_GPC['help_examine_index']), 'help_examine_package' => htmlspecialchars($_GPC['help_examine_package']), 'help_examine_my' => htmlspecialchars($_GPC['help_examine_my']));
				if (!empty($setting)) {
					pdo_update(DBCONFIG::$TABLE_FFYD_SETTING, $data, array('id' => $setting['id']));
				} else {
					pdo_insert(DBCONFIG::$TABLE_FFYD_SETTING, $data);
				}
				message('参数设置成功！', $this->createWebUrl('Setting', array('op' => 'help_examine')), 'success');
			} else {
				$data = array('weid' => $_W['acid'], 'success_template_id' => $_GPC['success_template_id']);
				if (!empty($setting)) {
					pdo_update(DBCONFIG::$TABLE_FFYD_SETTING, $data, array('id' => $setting['id']));
				} else {
					pdo_insert(DBCONFIG::$TABLE_FFYD_SETTING, $data);
				}
				message('参数设置成功！', $this->createWebUrl('Setting', array('op' => 'templatemsg')), 'success');
			}
		}
		include $this->template("setting");
	}
	public function doWebResetSwiper()
	{
		global $_GPC, $_W;
		pdo_update(DBCONFIG::$TABLE_FFYD_SETTING, array('swiper' => ''), array('weid' => $_W['acid']));
		message('重置轮播图参数成功！', $this->createWebUrl('Setting', array('op' => 'swiper')), 'success');
	}
	//公告
	public function doWebVipGroup()
	{
		global $_GPC, $_W;
		$this->checkWQOrder();
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$id = intval($_GPC['id']);
		if ($op == 'post') {
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . "WHERE id='{$id}'");
			}
			if ($_W['ispost']) {
				$data = array('weid' => $_W['acid'], 'name' => $_GPC['name'], 'price' => $_GPC['price'], 'type' => $_GPC['type'], 'discount' => $_GPC['discount'], 'validity' => $_GPC['validity'], 'distribution_commission' => $_GPC['distribution_commission']);
				if (empty($id)) {
					pdo_insert(DBCONFIG::$TABLE_FFYD_VIPGROUP, $data);
					message('添加成功', $this->createWebUrl('Vipgroup'), 'success');
				} else {
					pdo_update(DBCONFIG::$TABLE_FFYD_VIPGROUP, $data, array('id' => $id));
					message('更新成功', $this->createWebUrl('Vipgroup'), 'success');
				}
			}
		} elseif ($op == 'display') {
			$list = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . " WHERE weid = '{$_W['acid']}' ");
		}
		if (checksubmit('delete')) {
			pdo_delete(DBCONFIG::$TABLE_FFYD_VIPGROUP, " id  IN  ('" . implode(",", $_GPC['select']) . "')");
			message('删除成功', referer(), 'success');
		}
		include $this->template('vipgroup');
	}
	/**
	 * 购买记录
	 */
	public function doWebRecord()
	{
		global $_W, $_GPC;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$articleid = $_GPC['articleid'];
		if ($operation == 'display') {
			$uid = $_GPC['uid'];
			$where = '';
			if (!empty($uid)) {
				$where .= ' and uid = :uid';
				$params[':uid'] = $uid;
			}
			$order_time_get = $_GPC['order_time'];
			// 结构为: array('start'=>?, 'end'=>?)
			$starttime = empty($order_time_get['start']) ? strtotime('-1 month') : strtotime($order_time_get['start']);
			$endtime = empty($order_time_get['end']) ? TIMESTAMP : strtotime($order_time_get['end']);
			$where .= ' and createtime >=:starttime and createtime <=:endtime';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
			$params[':articleid'] = $articleid;
			$order_time = array('start' => date("Y-m-d H:i", $starttime), 'end' => date("Y-m-d H:i", $endtime));
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_RECORD) . " WHERE articleid =:articleid " . $where . "  ORDER BY createtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_RECORD) . " WHERE articleid =:articleid  " . $where, $params);
			$pager = pagination($total, $pindex, $psize);
		} else {
			if ($operation == 'delete') {
				$id = $_GPC['id'];
				pdo_delete(DBCONFIG::$TABLE_FFYD_RECORD, array("id" => $id));
				message('删除成功！', $this->createWebUrl('Record', array('articleid' => $articleid)), 'success');
			}
		}
		include $this->template("record");
	}
	/**
	 * 购买记录
	 */
	public function doWebComment()
	{
		global $_W, $_GPC;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$articleid = $_GPC['articleid'];
		if ($operation == 'display') {
			$uid = $_GPC['uid'];
			$where = '';
			if (!empty($uid)) {
				$where .= ' and uid = :uid';
				$params[':uid'] = $uid;
			}
			$order_time_get = $_GPC['order_time'];
			// 结构为: array('start'=>?, 'end'=>?)
			$starttime = empty($order_time_get['start']) ? strtotime('-1 month') : strtotime($order_time_get['start']);
			$endtime = empty($order_time_get['end']) ? TIMESTAMP : strtotime($order_time_get['end']);
			$where .= ' and createtime >=:starttime and createtime <=:endtime';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
			$params[':articleid'] = $articleid;
			$order_time = array('start' => date("Y-m-d H:i", $starttime), 'end' => date("Y-m-d H:i", $endtime));
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . " WHERE articleid =:articleid " . $where . "  ORDER BY createtime DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_COMMENT) . " WHERE articleid =:articleid  " . $where, $params);
			$pager = pagination($total, $pindex, $psize);
		} else {
			if ($operation == 'delete') {
				$id = $_GPC['id'];
				pdo_delete(DBCONFIG::$TABLE_FFYD_COMMENT, array("id" => $id));
				message('删除成功！', $this->createWebUrl('Comment', array('articleid' => $articleid)), 'success');
			} else {
				if ($operation == 'setstatus') {
					$id = $_GPC['id'];
					pdo_update(DBCONFIG::$TABLE_FFYD_COMMENT, array('status' => 1), array('id' => $id));
					message('审核成功！', $this->createWebUrl('Comment', array('articleid' => $articleid)), 'success');
				}
			}
		}
		include $this->template("comment");
	}
	//黑名单管理
	public function doWebVip()
	{
		global $_GPC, $_W;
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$id = intval($_GPC['id']);
		if ($op == 'post') {
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIP) . "WHERE id='{$id}'");
			}
			if ($_W['ispost']) {
				$data = array('weid' => $_W['acid'], 'vipid' => $_GPC['vipid'], 'price' => $_GPC['price'], 'uid' => $_GPC['uid'], 'endtime' => strtotime($_GPC['endtime']));
				if (empty($id)) {
					pdo_insert(DBCONFIG::$TABLE_FFYD_VIP, $data);
					message('添加成功', $this->createWebUrl('Vip'), 'success');
				} else {
					pdo_update(DBCONFIG::$TABLE_FFYD_VIP, $data, array('id' => $id));
					message('更新成功', $this->createWebUrl('Vip'), 'success');
				}
			}
		} elseif ($op == 'display') {
			$o = '';
			load()->model('mc');
			$list = pdo_fetchall("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIP) . " WHERE weid = '{$_W['acid']}' ");
			foreach ($list as $key => $val) {
				$vipgroup = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_VIPGROUP) . "WHERE id='{$val['vipid']}'");
				$userinfo = mc_fansinfo($val['uid'], $_W['acid']);
				$list[$key]['nickname'] = $userinfo['nickname'];
				$list[$key]['vipgorupname'] = $vipgroup['name'];
				$list[$key]['avatar'] = $userinfo['avatar'];
			}
		} else {
			if ($op == 'delete') {
				$id = $_GPC['id'];
				pdo_delete(DBCONFIG::$TABLE_FFYD_VIP, array("id" => $id));
				message('删除成功！', referer(), 'success');
			}
		}
		include $this->template('vip');
	}
	public function doWebWithdraw()
	{
		global $_W, $_GPC;
		$this->checkWQOrder();
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'userlist';
		$setting = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_SETTING) . "WHERE weid='{$_W['acid']}' ");
		if ($operation == 'userlist') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$list = pdo_fetchall("SELECT * FROM " . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . " WHERE weid='{$_W['acid']}'  ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			foreach ($list as $key => $val) {
				$userinfo = mc_fansinfo($val['uid'], $_W['acid'], $_W['uniacid']);
				$list[$key]['username'] = $userinfo['nickname'];
			}
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . "WHERE weid='{$_W['acid']}'  ORDER BY id DESC");
			$pager = pagination($total, $pindex, $psize);
		} else {
			if ($operation == 'delete') {
				$id = $_GPC['id'];
				pdo_delete(DBCONFIG::$TABLE_FFYD_USERWITHDRAW, array("id" => $id));
				message('删除成功！', referer(), 'success');
			} else {
				if ($operation == 'setstatus') {
					$id = $_GPC['id'];
					$status = $_GPC['status'];
					$uid = $_GPC['uid'];
					$withdraw = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . "WHERE weid='{$_W['acid']}' AND id='{$id}'");
					if ($setting['user_withdraw_type'] == 1) {
						if ($status == 1) {
							$userinfo = mc_fansinfo($uid, $_W['acid'], $_W['acid']);
							require_once IA_ROOT . "/addons/" . YPUK_FFYD . "/withdraw_func.php";
							$param = array('orderno' => TIMESTAMP . '' . $uid . '' . $id, 'openid' => $userinfo['openid'], 'amount' => $withdraw['charged_price'], 'desc' => '用户提现', 'withdrawlog_id' => $withdraw['id'], 'type' => 'user');
							create_withdraw($param);
						} else {
							pdo_update(DBCONFIG::$TABLE_FFYD_USERWITHDRAW, array("status" => $status), array("id" => $id));
							message('更新成功！', referer(), 'success');
						}
					} else {
						pdo_update(DBCONFIG::$TABLE_FFYD_USERWITHDRAW, array("status" => $status), array("id" => $id));
						message('更新成功！', referer(), 'success');
					}
				}
			}
		}
		include $this->template("withdraw_list");
	}
	public function doWebWithdrawDetail()
	{
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$withdraw = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_FFYD_USERWITHDRAW) . "WHERE weid='{$_W['acid']}' AND id='{$id}'");
		$userinfo = mc_fansinfo($withdraw['uid'], $_W['acid'], $_W['acid']);
		$withdraw['username'] = $userinfo['nickname'];
		$withdraw['charge'] = $withdraw['withdraw_price'] - $withdraw['charged_price'];
		include $this->template("withdraw_detail");
	}
	/**
	 * 创建并写入砍价成功时的模板消息ID
	 */
	public function doWebGetTemplateId()
	{
		global $_W, $_GPC;
		load()->func('communication');
		load()->classs('wxapp.account');
		$appinfo = WxappAccount::create($_W['acid']);
		$accesstoken = $appinfo->getAccessToken();
		if ($_GPC['type'] == 'success_template_id') {
			$templateInfo_content = json_encode(array('id' => 'AT1173', 'access_token' => $accesstoken));
			$templateInfo_url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token={$accesstoken}";
			$templateInfo = ihttp_post($templateInfo_url, $templateInfo_content);
			$templateInfo = json_decode($templateInfo['content'], true);
			$keyword_arr = array();
			$keyword_len = 3;
			for ($i = 0; $i < $keyword_len; $i++) {
				foreach ($templateInfo['keyword_list'] as $key => $val) {
					if (count($keyword_arr) == 0 && $val['name'] == '商品名称') {
						array_push($keyword_arr, $val['keyword_id']);
					}
					if (count($keyword_arr) == 1 && $val['name'] == '温馨提示') {
						array_push($keyword_arr, $val['keyword_id']);
					}
					if (count($keyword_arr) == 2 && $val['name'] == '砍价时间') {
						array_push($keyword_arr, $val['keyword_id']);
					}
				}
			}
			$createTemplate_content = json_encode(array('id' => 'AT1173', 'access_token' => $accesstoken, 'keyword_id_list' => $keyword_arr));
			$createTemplate_url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token={$accesstoken}";
			$createTemplate = ihttp_post($createTemplate_url, $createTemplate_content);
			$createTemplate = json_decode($createTemplate['content'], true);
			if ($createTemplate['errcode'] == 0) {
				$setting = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_KJB_SETTING) . "WHERE weid='{$_W['acid']}' ");
				$data = array('weid' => $_W['acid'], 'success_template_id' => $createTemplate['template_id']);
				if (!empty($setting)) {
					pdo_update(DBCONFIG::$TABLE_KJB_SETTING, $data, array('id' => $setting['id']));
				} else {
					pdo_insert(DBCONFIG::$TABLE_KJB_SETTING, $data);
				}
			}
		} else {
			if ($_GPC['type'] == 'create_template_id') {
				$templateInfo_content = json_encode(array('id' => 'AT0197', 'access_token' => $accesstoken));
				$templateInfo_url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token={$accesstoken}";
				$templateInfo = ihttp_post($templateInfo_url, $templateInfo_content);
				$templateInfo = json_decode($templateInfo['content'], true);
				$keyword_arr = array();
				$keyword_len = 4;
				for ($i = 0; $i < $keyword_len; $i++) {
					foreach ($templateInfo['keyword_list'] as $key => $val) {
						if (count($keyword_arr) == 0 && $val['name'] == '发起人') {
							array_push($keyword_arr, $val['keyword_id']);
						}
						if (count($keyword_arr) == 1 && $val['name'] == '温馨提示') {
							array_push($keyword_arr, $val['keyword_id']);
						}
						if (count($keyword_arr) == 2 && $val['name'] == '说明') {
							array_push($keyword_arr, $val['keyword_id']);
						}
						if (count($keyword_arr) == 3 && $val['name'] == '申请时间') {
							array_push($keyword_arr, $val['keyword_id']);
						}
					}
				}
				$createTemplate_content = json_encode(array('id' => 'AT0197', 'access_token' => $accesstoken, 'keyword_id_list' => $keyword_arr));
				$createTemplate_url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token={$accesstoken}";
				$createTemplate = ihttp_post($createTemplate_url, $createTemplate_content);
				$createTemplate = json_decode($createTemplate['content'], true);
				if ($createTemplate['errcode'] == 0) {
					$setting = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_KJB_SETTING) . "WHERE weid='{$_W['acid']}' ");
					$data = array('weid' => $_W['acid'], 'create_template_id' => $createTemplate['template_id']);
					if (!empty($setting)) {
						pdo_update(DBCONFIG::$TABLE_KJB_SETTING, $data, array('id' => $setting['id']));
					} else {
						pdo_insert(DBCONFIG::$TABLE_KJB_SETTING, $data);
					}
				}
			} else {
				$templateInfo_content = json_encode(array('id' => 'AT0210', 'access_token' => $accesstoken));
				$templateInfo_url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token={$accesstoken}";
				$templateInfo = ihttp_post($templateInfo_url, $templateInfo_content);
				$templateInfo = json_decode($templateInfo['content'], true);
				$keyword_arr = array();
				$keyword_len = 5;
				for ($i = 0; $i < $keyword_len; $i++) {
					foreach ($templateInfo['keyword_list'] as $key => $val) {
						if (count($keyword_arr) == 0 && $val['name'] == '订单号') {
							array_push($keyword_arr, $val['keyword_id']);
						}
						if (count($keyword_arr) == 1 && $val['name'] == '商品名称') {
							array_push($keyword_arr, $val['keyword_id']);
						}
						if (count($keyword_arr) == 2 && $val['name'] == '支付方式') {
							array_push($keyword_arr, $val['keyword_id']);
						}
						if (count($keyword_arr) == 3 && $val['name'] == '备注') {
							array_push($keyword_arr, $val['keyword_id']);
						}
						if (count($keyword_arr) == 4 && $val['name'] == '下单时间') {
							array_push($keyword_arr, $val['keyword_id']);
						}
					}
				}
				$createTemplate_content = json_encode(array('id' => 'AT0210', 'access_token' => $accesstoken, 'keyword_id_list' => $keyword_arr));
				$createTemplate_url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token={$accesstoken}";
				$createTemplate = ihttp_post($createTemplate_url, $createTemplate_content);
				$createTemplate = json_decode($createTemplate['content'], true);
				if ($createTemplate['errcode'] == 0) {
					$setting = pdo_fetch("SELECT * FROM" . tablename(DBCONFIG::$TABLE_KJB_SETTING) . "WHERE weid='{$_W['acid']}' ");
					$data = array('weid' => $_W['acid'], 'order_template_id' => $createTemplate['template_id']);
					if (!empty($setting)) {
						pdo_update(DBCONFIG::$TABLE_KJB_SETTING, $data, array('id' => $setting['id']));
					} else {
						pdo_insert(DBCONFIG::$TABLE_KJB_SETTING, $data);
					}
				}
			}
		}
		return json_encode($createTemplate);
	}
	function makecode($input)
	{
		$base32 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5');
		$hex = md5($input);
		$hexLen = strlen($hex);
		$subHexLen = $hexLen / 8;
		$output = array();
		for ($i = 0; $i < $subHexLen; $i++) {
			//把加密字符按照8位一组16进制与0x3FFFFFFF(30位1)进行位与运算
			$subHex = substr($hex, $i * 8, 8);
			$int = 0x3fffffff & 1 * ('0x' . $subHex);
			//echo $int;
			$out = '';
			for ($j = 0; $j < 6; $j++) {
				//把得到的值与0x0000001F进行位与运算，取得字符数组chars索引
				$val = 0x1f & $int;
				$out .= $base32[$val];
				$int = $int >> 5;
			}
			$output[] = $out;
		}
		$nr = rand(0, 3);
		return $output[$nr];
		//return $output;
	}

}