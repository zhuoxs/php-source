<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Cover_EweiShopV2Page extends WebPage
{
	protected function _cover($key, $name, $url)
	{
		global $_W;
		global $_GPC;
		$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2' . $name . '入口设置'));
		$keyword = false;
		$cover = false;

		if (!empty($rule)) {
			$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
			$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
		}

		if ($_W['ispost']) {
			ca('sysset.cover.' . $key . '.edit');
			$data = is_array($_GPC['cover']) ? $_GPC['cover'] : array();

			if (empty($data['keyword'])) {
				show_json(0, '请输入关键词!');
			}

			$keyword1 = m('common')->keyExist($data['keyword']);

			if (!empty($keyword1)) {
				if ($keyword1['name'] != 'ewei_shopv2' . $name . '入口设置') {
					show_json(0, '关键字已存在!');
				}
			}

			if (!empty($rule)) {
				pdo_delete('rule', array('id' => $rule['id'], 'uniacid' => $_W['uniacid']));
				pdo_delete('rule_keyword', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
				pdo_delete('cover_reply', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
			}

			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2' . $name . '入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => intval($data['status']));
			pdo_insert('rule', $rule_data);
			$rid = pdo_insertid();
			$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => intval($data['status']));
			pdo_insert('rule_keyword', $keyword_data);
			$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'title' => trim($data['title']), 'description' => trim($data['desc']), 'thumb' => save_media($data['thumb']), 'url' => $url);
			pdo_insert('cover_reply', $cover_data);
			plog('sysset.cover.' . $key . '.edit', '修改' . $name . '入口设置');
			show_json(1);
		}

		return array('rule' => $rule, 'cover' => $cover, 'keyword' => $keyword, 'url' => $_W['siteroot'] . 'app/' . substr($url, 2), 'name' => $name, 'key' => $key);
	}

	public function shop()
	{
		global $_W;
		global $_GPC;
		$cover = $this->_cover('shop', '商城', mobileUrl('', array(), false));
		include $this->template('sysset/cover');
	}

	public function member()
	{
		global $_W;
		global $_GPC;
		$cover = $this->_cover('member', '会员中心', mobileUrl('member', array(), false));
		include $this->template('sysset/cover');
	}

	public function favorite()
	{
		global $_W;
		global $_GPC;
		$cover = $this->_cover('favorite', '收藏', mobileUrl('member/favorite', array(), false));
		include $this->template('sysset/cover');
	}

	public function cart()
	{
		global $_W;
		global $_GPC;
		$cover = $this->_cover('favorite', '购物车', mobileUrl('member/cart', array(), false));
		include $this->template('sysset/cover');
	}

	public function order()
	{
		global $_W;
		global $_GPC;
		$cover = $this->_cover('order', '订单', mobileUrl('order', array(), false));
		include $this->template('sysset/cover');
	}

	public function coupon()
	{
		global $_W;
		global $_GPC;
		$cover = $this->_cover('coupon', '优惠券', mobileUrl('sale/coupon', array(), false));
		include $this->template('sysset/cover');
	}
}

?>
