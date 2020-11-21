<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;

		if (cv('commission.agent')) {
			header('location: ' . webUrl('commission/agent'));
			exit();
		}
		else if (cv('commission.apply.view1')) {
			header('location: ' . webUrl('commission/apply', array('status' => 1)));
			exit();
		}
		else if (cv('commission.apply.view2')) {
			header('location: ' . webUrl('commission/apply', array('status' => 2)));
			exit();
		}
		else if (cv('commission.apply.view3')) {
			header('location: ' . webUrl('commission/apply', array('status' => 3)));
			exit();
		}
		else if (cv('commission.apply.view_1')) {
			header('location: ' . webUrl('commission/apply', array('status' => -1)));
			exit();
		}
		else if (cv('commission.increase')) {
			header('location: ' . webUrl('commission/increase'));
			exit();
		}
		else if (cv('commission.notice')) {
			header('location: ' . webUrl('commission/notice'));
			exit();
		}
		else if (cv('commission.cover')) {
			header('location: ' . webUrl('commission/cover'));
			exit();
		}
		else if (cv('commission.level')) {
			header('location: ' . webUrl('commission/level'));
			exit();
		}
		else {
			if (cv('commission.set')) {
				header('location: ' . webUrl('commission/set'));
				exit();
			}
		}
	}

	public function notice()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getPluginset('commission', false);
		$data = $data['tm'];
		$salers1 = array();

		if (isset($data['openid1'])) {
			if (!empty($data['openid1'])) {
				$openids1 = array();
				$strsopenids = explode(',', $data['openid1']);

				foreach ($strsopenids as $openid) {
					$openids1[] = '\'' . $openid . '\'';
				}

				@$salers1 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids1) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		$salers2 = array();

		if (isset($data['openid2'])) {
			if (!empty($data['openid2'])) {
				$openids2 = array();
				$strsopenids2 = explode(',', $data['openid2']);

				foreach ($strsopenids2 as $openid2) {
					$openids2[] = '\'' . $openid2 . '\'';
				}

				@$salers2 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids2) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		if ($_W['ispost']) {
			$post_data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if ($post_data['is_advanced'] == 0) {
				if (is_array($_GPC['openids2'])) {
					$post_data['openid2'] = implode(',', $_GPC['openids2']);
				}
				else {
					$post_data['openid2'] = '';
				}

				$post_data['openid'] = $post_data['openid2'];

				if (!empty($data['openid1'])) {
					$post_data['openid1'] = $data['openid1'];
				}
			}
			else {
				if ($post_data['is_advanced'] == 1) {
					if (is_array($_GPC['openids1'])) {
						$post_data['openid1'] = implode(',', $_GPC['openids1']);
					}
					else {
						$post_data['openid1'] = '';
					}

					$post_data['openid'] = $post_data['openid1'];

					if (!empty($data['openid2'])) {
						$post_data['openid2'] = $data['openid2'];
					}
				}
			}

			m('common')->updatePluginset(array(
				'commission' => array('tm' => $post_data)
			));
			plog('commission.notice.edit', '修改通知设置');
			show_json(1);
		}

		$data = m('common')->getPluginset('commission');
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
		include $this->template();
	}

	public function set()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			if ($data['cansee'] == 1 && empty($data['seetitle'])) {
				show_json(0, '请选择佣金显示文字');
			}

			$data['cashcredit'] = intval($data['cashcredit']);
			$data['cashweixin'] = intval($data['cashweixin']);
			$data['cashother'] = intval($data['cashother']);
			$data['cashalipay'] = intval($data['cashalipay']);
			$data['cashcard'] = intval($data['cashcard']);

			if (!empty($data['withdrawcharge'])) {
				$data['withdrawcharge'] = trim($data['withdrawcharge']);
				$data['withdrawcharge'] = floatval(trim($data['withdrawcharge'], '%'));
			}

			$data['withdrawbegin'] = floatval(trim($data['withdrawbegin']));
			$data['withdrawend'] = floatval(trim($data['withdrawend']));
			$data['register_bottom_content'] = m('common')->html_images($data['register_bottom_content']);
			$data['applycontent'] = m('common')->html_images($data['applycontent']);
			$data['regbg'] = save_media($data['regbg']);
			$data['become_goodsid'] = intval($_GPC['become_goodsid']);
			$data['texts'] = is_array($_GPC['texts']) ? $_GPC['texts'] : array();
			if ($data['become'] == 4 && empty($data['become_goodsid'])) {
				show_json(0, '请选择商品');
			}

			m('common')->updatePluginset(array('commission' => $data));
			m('cache')->set('template_' . $this->pluginname, $data['style']);
			$selfbuy = $data['selfbuy'] ? '开启' : '关闭';
			$become_child = $data['become_child'] ? ($data['become_child'] == 1 ? '首次下单' : '首次付款') : '首次点击分享连接';

			switch ($data['become']) {
			case '0':
				$become = '无条件';
				break;

			case '1':
				$become = '申请';
				break;

			case '2':
				$become = '消费次数';
				break;

			case '3':
				$become = '消费金额';
				break;

			case '4':
				$become = '购买商品';
				break;
			}

			plog('commission.set.edit', '修改基本设置<br>' . '分销内购 -- ' . $selfbuy . '<br>成为下线条件 -- ' . $become_child . '<br>成为分销商条件 -- ' . $become);
			show_json(1, array('url' => webUrl('commission/set', array('tab' => str_replace('#tab_', '', $_GPC['tab'])))));
		}

		$styles = array();
		$dir = IA_ROOT . '/addons/ewei_shopv2/plugin/' . $this->pluginname . '/template/mobile/';

		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . '/' . $file)) {
						$styles[] = $file;
					}
				}
			}

			closedir($handle);
		}

		$data = m('common')->getPluginset('commission');
		$goods = false;

		if (!empty($data['become_goodsid'])) {
			$goods = pdo_fetch('select id,title,thumb from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $data['become_goodsid'], ':uniacid' => $_W['uniacid']));
		}

		include $this->template();
	}

	public function goodsquery()
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC['keyword']);
		$type = intval($_GPC['type']);
		$live = intval($_GPC['live']);
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$condition = ' and status=1 and deleted=0 and uniacid=:uniacid and type = 1 
                    and isdiscount = 0 and istime = 0 and  ifnull(bargain,0)=0 and ispresell = 0 ';

		if (!empty($kwd)) {
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . $kwd . '%';
		}

		if (empty($type)) {
			$condition .= ' AND `type` != 10 ';
		}
		else {
			$condition .= ' AND `type` = :type ';
			$params[':type'] = $type;
		}

		$goodsids = pdo_fetchall('SELECT goodsids FROM ' . tablename('ewei_shop_commission_level') . ' WHERE uniacid=:uniacid', array('uniacid' => $_W['uniacid']));
		$newarray = array();
		if (!empty($goodsids) && is_array($goodsids)) {
			foreach ($goodsids as $key => $val) {
				$newarray = array_merge($newarray, iunserializer($val['goodsids']));
			}

			if (!empty($newarray) && is_array($newarray)) {
				$condition .= 'AND id NOT IN (' . implode(',', $newarray) . ')';
			}
		}

		$ds = pdo_fetchall('SELECT id,title,thumb,marketprice,productprice,share_title,share_icon,description,minprice,costprice,total,sales,islive,liveprice FROM ' . tablename('ewei_shop_goods') . (' WHERE 1 ' . $condition . ' order by createtime desc'), $params);

		foreach ($ds as &$value) {
			$value['share_title'] = htmlspecialchars_decode($value['share_title']);
			unset($value);
		}

		$ds = set_medias($ds, array('thumb', 'share_icon'));

		if ($_GPC['suggest']) {
			exit(json_encode(array('value' => $ds)));
		}

		include $this->template();
	}
}

?>
