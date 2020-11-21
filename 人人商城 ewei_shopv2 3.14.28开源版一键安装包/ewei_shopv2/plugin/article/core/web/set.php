<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Set_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$article_sys = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_article_sys') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));
		$set = m('common')->getPluginset('article');

		if ($_W['ispost']) {
			ca('article.set.edit');
			$article_message = trim($_GPC['article_advanced']);
			$article_title = trim($_GPC['article_title']);
			$article_image = save_media($_GPC['article_image']);
			$article_shownum = $_GPC['article_shownum'];
			$article_keyword = trim($_GPC['article_keyword']);
			$article_temp = intval($_GPC['article_temp']);
			$article_source = trim($_GPC['article_source']);
			$article_close_advanced = intval($_GPC['article_close_advanced']);
			$arr = array('article_message' => $article_message, 'article_title' => $article_title, 'article_image' => $article_image, 'article_shownum' => $article_shownum, 'article_keyword' => $article_keyword, 'article_temp' => $article_temp, 'article_source' => $article_source, 'article_close_advanced' => $article_close_advanced);
			$data = array('article_advanced' => $article_message, 'article_close_advanced' => $article_close_advanced);
			m('common')->updatePluginset(array(
	'article' => array('tm' => $data)
	));

			if (empty($article_keyword)) {
				show_json(0, '关键词不能为空!');
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2文章营销入口设置'));

			if (!empty($rule)) {
				$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
				$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
			}

			$kw = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and content=:content and id<>:id limit 1', array(':uniacid' => $_W['uniacid'], ':content' => trim($article_keyword), ':id' => $keyword['id']));

			if (!empty($kw)) {
				show_json(0, '关键词 ' . $article_keyword . ' 已经使用!');
			}

			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2文章营销入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => 1);

			if (empty($rule)) {
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
			}
			else {
				pdo_update('rule', $rule_data, array('id' => $rule['id']));
				$rid = $rule['id'];
			}

			$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($article_keyword), 'type' => 1, 'displayorder' => 0, 'status' => 1);

			if (empty($keyword)) {
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				pdo_update('rule_keyword', $keyword_data, array('id' => $keyword['id']));
			}

			$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => $this->modulename, 'title' => trim($article_title), 'description' => '', 'thumb' => $article_image, 'url' => mobileUrl('article/list'));

			if (empty($cover)) {
				pdo_insert('cover_reply', $cover_data);
			}
			else {
				pdo_update('cover_reply', $cover_data, array('id' => $cover['id']));
			}

			$sys = pdo_fetch('select * from ' . tablename('ewei_shop_article_sys') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

			if (empty($sys)) {
				$arr['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_article_sys', $arr);
			}
			else {
				pdo_update('ewei_shop_article_sys', $arr, array('uniacid' => $_W['uniacid']));
			}

			plog('article.set.edit', '编辑其他设置');
			show_json(1);
		}

		$template_lists = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_lists as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		$template_list = $template_group;
		$url = mobileUrl('article/list', NULL, true);
		$qrcode = m('qrcode')->createQrcode($url);
		include $this->template();
	}
}

?>
