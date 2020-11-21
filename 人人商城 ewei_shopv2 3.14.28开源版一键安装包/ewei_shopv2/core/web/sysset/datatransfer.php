<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Datatransfer_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$item = pdo_fetch('select dt.*,w.name from ' . tablename('ewei_shop_datatransfer') . ' dt left join ' . tablename('account_wechats') . ' w on w.uniacid = dt.touniacid where dt.fromuniacid =:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		$senduniacid = $_GPC['acid'];
		$isopen = $_GPC['isopen'];

		if ($_W['ispost']) {
			if (!empty($isopen)) {
				pdo_delete('ewei_shop_datatransfer', array('fromuniacid' => $_W['uniacid']));
				show_json(1, array('url' => referer()));
			}

			$data = array('fromuniacid' => $_W['uniacid'], 'touniacid' => $senduniacid, 'status' => 1);
			pdo_insert('ewei_shop_datatransfer', $data);
			$tables = array('ewei_shop_category', 'ewei_shop_carrier', 'ewei_shop_adv', 'ewei_shop_feedback', 'ewei_shop_form', 'ewei_shop_form_category', 'ewei_shop_gift', 'ewei_shop_goods', 'ewei_shop_goods_comment', 'ewei_shop_goods_group', 'ewei_shop_goods_label', 'ewei_shop_goods_labelstyle', 'ewei_shop_goods_option', 'ewei_shop_goods_param', 'ewei_shop_goods_spec', 'ewei_shop_goods_spec_item', 'ewei_shop_member_address', 'ewei_shop_member_printer', 'ewei_shop_member_printer_template', 'ewei_shop_member_group', 'ewei_shop_member_level', 'ewei_shop_member_log', 'mc_credits_record', 'ewei_shop_commission_apply', 'ewei_shop_commission_bank', 'ewei_shop_commission_level', 'ewei_shop_commission_log', 'ewei_shop_commission_rank', 'ewei_shop_commission_repurchase', 'ewei_shop_commission_shop', 'ewei_shop_order', 'ewei_shop_order_comment', 'ewei_shop_order_goods', 'ewei_shop_order_peerpay', 'ewei_shop_order_peerpay_payinfo', 'ewei_shop_order_refund');

			foreach ($tables as $table) {
				pdo_update($table, array('uniacid' => $senduniacid), array('uniacid' => $_W['uniacid']));
			}

			show_json(1, array('url' => referer()));
		}

		include $this->template();
	}
}

?>
