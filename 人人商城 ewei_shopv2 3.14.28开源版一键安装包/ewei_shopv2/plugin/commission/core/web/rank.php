<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Rank_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$content = array();

			if (!empty($_GPC['id'])) {
				foreach ($_GPC['id'] as $k => $v) {
					$temp = array('nickname' => trim($_GPC['nickname'][$k]), 'commission_total' => floatval($_GPC['commission_total'][$k]), 'avatar' => trim($_GPC['avatar'][$k]));
					array_push($content, $temp);
				}
			}

			$data = array(
				'rank' => array('type' => intval($_GPC['type']), 'num' => intval($_GPC['num']), 'title' => trim($_GPC['title']), 'status' => intval($_GPC['status']), 'content' => $content)
				);
			m('common')->updatePluginset(array('commission' => $data));
			plog('commission.rank.edit', '修改积分排名设置');
			show_json(1);
		}

		$url = mobileUrl('commission/rank', array(), true);
		$qrcode = m('qrcode')->createQrcode($url);
		$item = $_W['shopset']['commission']['rank'];

		if (!is_array($item['content'])) {
			$list = @json_decode($item['content'], true);
		}
		else {
			$list = $item['content'];
		}

		if (!empty($list)) {
			usort($list, function($a, $b) {
				$al = (int) $a['commission_total'];
				$bl = (int) $b['commission_total'];

				if ($al == $bl) {
					return 0;
				}

				return $bl < $al ? -1 : 1;
			});
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = $_W['shopset']['commission']['rank'];
		$list = @json_decode($item['content'], true);

		if (!empty($list)) {
			usort($list, function($a, $b) {
				$al = (int) $a['commission_total'];
				$bl = (int) $b['commission_total'];

				if ($al == $bl) {
					return 0;
				}

				return $bl < $al ? -1 : 1;
			});
		}

		unset($list[$id]);
		$data = array(
			'rank' => array('content' => $list)
			);
		m('common')->updatePluginset(array('commission' => $data));
		plog('commission.rank.edit', '修改积分排名设置-删除虚拟用户');
		show_json(1);
	}

	public function ajaxgetcommissionopenid()
	{
		global $_W;
		$result = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = :uniacid AND status=1 AND agentblack=0', array(':uniacid' => $_W['uniacid']));

		if (!empty($result)) {
			$result_tmp = array();

			foreach ($result as $val) {
				$result_tmp[] = $val['openid'];
			}

			show_json(1, array('openid' => $result_tmp));
		}

		show_json(0, '没有分销用户');
	}

	public function ajaxgetcommission()
	{
		global $_W;
		global $_GPC;
		$openid = $_GPC['openid'];

		if (!empty($openid)) {
			if (is_array($openid)) {
				foreach ($openid as $val) {
					$member = $this->model->getInfo($val, array('total'));
					$data = array('commission_total' => $member['commission_total']);
					pdo_update('ewei_shop_member', $data, array('openid' => $val, 'uniacid' => $_W['uniacid']));
				}

				show_json(1, $data);
			}

			$member = $this->model->getInfo($openid, array('total'));
			$data = array('commission_total' => $member['commission_total']);
			pdo_update('ewei_shop_member', $data, array('openid' => $openid, 'uniacid' => $_W['uniacid']));
			show_json(1, $data);
		}

		show_json(0);
	}
}

?>
