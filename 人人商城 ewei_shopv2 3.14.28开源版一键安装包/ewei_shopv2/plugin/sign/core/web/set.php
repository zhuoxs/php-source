<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Set_EweiShopV2Page extends PluginWebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$set = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sign_set') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));
		if ($_W['ispost']) 
		{
			ca('sign.set.edit');
			$sign_iscenter = trim($_GPC['iscenter']);
			$sign_iscreditshop = trim($_GPC['iscreditshop']);
			$sign_share = trim($_GPC['share']);
			$sign_keyword = $_GPC['keyword'];
			$sign_title = $_GPC['title'];		
			$sign_thumb = save_media($_GPC['thumb']);		
			$sign_desc = $_GPC['desc'];
			
			
			$arr = array(
			'iscenter' => $sign_iscenter, 
			'iscreditshop' => $sign_iscreditshop, 
			'share' => $sign_share,
			'keyword' => $sign_keyword, 
			'title' => $sign_title,
			'thumb' => $sign_thumb,	
			'desc' => $sign_desc,
			);
			
			if (empty($sign_keyword)) 
			{
				show_json(0, '关键词不能为空!');
			}
			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2签到入口设置'));
			if (!empty($rule)) 
			{
				$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
				$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
			}
			$kw = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and content=:content and id<>:id limit 1', array(':uniacid' => $_W['uniacid'], ':content' => trim($sign_keyword), ':id' => $keyword['id']));
			if (!empty($kw)) 
			{
				show_json(0, '关键词 ' . $sign_keyword . ' 已经使用!');
			}
			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2签到入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => 1);
			if (empty($rule)) 
			{
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
			}
			else 
			{
				pdo_update('rule', $rule_data, array('id' => $rule['id']));
				$rid = $rule['id'];
			}
			$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($sign_keyword), 'type' => 1, 'displayorder' => 0, 'status' => 1);
			if (empty($keyword)) 
			{
				pdo_insert('rule_keyword', $keyword_data);
			}
			else 
			{
				pdo_update('rule_keyword', $keyword_data, array('id' => $keyword['id']));
			}
			$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => $this->modulename, 'title' => trim($sign_title), 'description' => $sign_desc, 'thumb' => $sign_thumb, 'url' => mobileUrl('sign'));
			if (empty($cover)) 
			{
				pdo_insert('cover_reply', $cover_data);
			}
			else 
			{
				pdo_update('cover_reply', $cover_data, array('id' => $cover['id']));
			}
			$sys = pdo_fetch('select * from ' . tablename('ewei_shop_sign_set') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
			if (empty($sys)) 
			{
				$arr['uniacid'] = $_W['uniacid'];
				pdo_insert('ewei_shop_sign_set', $arr);
			}
			else 
			{
				pdo_update('ewei_shop_sign_set', $arr, array('uniacid' => $_W['uniacid']));
			}
			plog('sign.set.edit', '编辑其他设置');
			show_json(1);
		}
		include $this->template();
	}
}