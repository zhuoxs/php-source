<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Index_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		if (mcv('sysset.shop')) {
			header('location: ' . merchUrl('sysset/shop'));
		}
	}

	public function shop()
	{
		global $_W;
		global $_GPC;
		$item = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $_W['uniaccount']['merchid'], ':uniacid' => $_W['uniacid']));
		if (empty($item) || empty($item['accoutntime'])) {
			$accounttime = strtotime('+365 day');
		}
		else {
			$accounttime = $item['accounttime'];
		}

		if (!empty($item['accountid'])) {
			$account = pdo_fetch('select * from ' . tablename('ewei_shop_merch_account') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['accountid'], ':uniacid' => $_W['uniacid']));
		}

		$diyform_flag = 0;
		$diyform_plugin = p('diyform');
		$f_data = array();

		if ($diyform_plugin) {
			if (!empty($item['diyformdata'])) {
				$diyform_flag = 1;
				$fields = iunserializer($item['diyformfields']);
				$f_data = iunserializer($item['diyformdata']);
			}
			else {
				$diyform_id = $_W['shopset']['merch']['apply_diyformid'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);

					if (!empty($formInfo)) {
						$diyform_flag = 1;
						$fields = $formInfo['fields'];
					}
				}
			}
		}

		if ($_W['ispost']) {
			$fdata = array();

			if ($diyform_flag) {
				$fdata = p('diyform')->getPostDatas($fields);

				if (is_error($fdata)) {
					show_json(0, $fdata['message']);
				}
			}

			$data = array('uniacid' => $_W['uniacid'], 'merchname' => trim($_GPC['merchname']), 'salecate' => trim($_GPC['salecate']), 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']), 'desc' => trim($_GPC['desc1']), 'address' => trim($_GPC['address']), 'tel' => trim($_GPC['tel']), 'lng' => $_GPC['map']['lng'], 'lat' => $_GPC['map']['lat'], 'logo' => save_media($_GPC['logo']));

			if ($diyform_flag) {
				$data['diyformdata'] = iserializer($fdata);
				$data['diyformfields'] = iserializer($fields);
			}

			pdo_update('ewei_shop_merch_user', $data, array('id' => $_W['uniaccount']['merchid']));
			show_json(1);
		}

		include $this->template('sysset/index');
	}

	public function notice()
	{
		global $_W;
		global $_GPC;
		$data = $this->getSet('notice');

		if (empty($data)) {
			$merchid = $_W['merchid'];

			if ($merchid) {
				$merch_user_set = pdo_get('ewei_shop_merch_user', array('id' => $merchid));
				$set = iunserializer($merch_user_set['sets']);
				$data = $set['notice'];
			}
		}

		$salers = array();

		if (isset($data['openid'])) {
			if (!empty($data['openid'])) {
				$openids = array();
				$strsopenids = explode(',', $data['openid']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
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

				$salers2 = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids2) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		if ($_W['ispost']) {
			mca('sysset.notice.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (is_array($_GPC['openids'])) {
				$data['openid'] = implode(',', $_GPC['openids']);
			}
			else {
				$data['openid'] = '';
			}

			if (is_array($_GPC['openids2'])) {
				$data['openid2'] = implode(',', $_GPC['openids2']);
			}
			else {
				$data['openid2'] = '';
			}

			$this->updateSet(array('notice' => $data));
			mplog('sysset.notice.edit', '修改系统设置-模板消息通知设置');
			show_json(1);
		}

		include $this->template();
	}
}

?>
