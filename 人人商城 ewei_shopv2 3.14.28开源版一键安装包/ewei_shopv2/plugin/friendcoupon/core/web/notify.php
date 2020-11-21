<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Notify_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$commonModel = m('common');
		$sets = m('common')->getSysset(array('app', 'pay'));
		$tmsg_list = pdo_fetchall('SELECT id, `name` FROM ' . tablename('ewei_shop_wxapp_tmessage') . 'WHERE uniacid=:uniacid AND status=1', array(':uniacid' => $_W['uniacid']));
		$template_list = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_list as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		$data = $commonModel->getSysset('notice');

		if ($_W['ispost']) {
			$notify = isset($_GPC['notify']) ? $_GPC['notify'] : NULL;
			$data = $commonModel->getSysset('notice');
			$notice = array_merge($data, $notify);
			$commonModel->updateSysset(array('notice' => $notice));
			show_json(1);
		}

		include $this->template();
	}

	public function setTemplate()
	{
		global $_W;
		global $_GPC;
		$tag = isset($_GPC['tag']) ? trim($_GPC['tag']) : NULL;
		$isOpen = isset($_GPC['checked']) ? (bool) $_GPC['checked'] : NULL;
		$allowTags = array('wxapp_complete');

		if (!in_array($tag, $allowTags)) {
			show_json(0, '非法模板类型');
		}

		if (strpos($tag, 'wxapp_') !== false) {
			$token = $this->model->getToken(true);
			$typecode = str_replace('wxapp_', 'friendcoupon_', $tag);
			$templateId = pdo_fetchcolumn('select templateid from' . tablename('ewei_shop_member_wxapp_message_template_default') . ' where uniacid = :uniacid and typecode = :typecode', array(':uniacid' => $_W['uniacid'], ':typecode' => $typecode));
			$request_first = ihttp_post('https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token=' . $token, json_encode(array('offset' => 0, 'count' => 20)));
			$request_second = ihttp_post('https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token=' . $token, json_encode(array('offset' => 20, 'count' => 6)));
			$templateList1 = json_decode($request_first['content'], true);
			$templateList2 = json_decode($request_second['content'], true);
			$templateList = array_merge($templateList1['list'], $templateList2['list']);
			$templateIds = array_column($templateList, 'template_id');
			$templatenum = count($templateIds);
			if (!$templateId || !in_array($templateId, $templateIds)) {
				$defaultTemplate = pdo_fetch('select * from ' . tablename('ewei_shop_member_wxapp_message_template_type') . ' where typecode = :typecode', array(':typecode' => $typecode));

				if (25 <= $templatenum) {
					show_json(1, array('status' => 0, 'messages' => '开启' . $defaultTemplate['name'] . '失败！！您的可用微信模板消息数量达到上限，请删除部分后重试！！', 'tag' => $tag));
				}

				if (!$defaultTemplate) {
					show_json(0, '默认模板不存在');
				}

				$_postData = array('id' => $defaultTemplate['templatecode'], 'keyword_id_list' => explode(',', $defaultTemplate['keyword_id_list']));
				$ret = ihttp_post('https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token=' . $token, json_encode($_postData));
				$ret = json_decode($ret['content'], true);

				if ($ret['errcode'] == 45026) {
					show_json(0, array('status' => 0, 'messages' => '模板超过了25个，请到小程序后台删除部分模板后重试'));
				}

				if ($ret['errcode'] == 0) {
					if (!$templateId) {
						pdo_insert('ewei_shop_member_wxapp_message_template_default', array('typecode' => $typecode, 'uniacid' => $_W['uniacid'], 'templateid' => $ret['template_id'], 'datas' => 'a:3:{i:0;a:2:{s:3:"key";s:17:"{{keyword1.DATA}}";s:5:"value";s:27:"瓜分券活动完成通知";}i:1;a:2:{s:3:"key";s:17:"{{keyword2.DATA}}";s:5:"value";s:26:"[活动名称]活动完成";}i:2;a:2:{s:3:"key";s:17:"{{keyword3.DATA}}";s:5:"value";s:52:"您于[瓜分券领取时间]领取[瓜分券名称]";}}'));
					}
					else {
						pdo_update('ewei_shop_member_wxapp_message_template_default', array('templateid' => $ret['template_id']), array('uniacid' => $_W['uniacid'], 'typecode' => $typecode));
					}
				}
			}

			show_json(1, array('status' => 1, 'tag' => $tag));
		}
	}
}

?>
