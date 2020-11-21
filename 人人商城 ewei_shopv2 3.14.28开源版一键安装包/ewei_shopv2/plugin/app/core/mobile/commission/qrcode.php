<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require __DIR__ . '/base.php';
class Qrcode_EweiShopV2Page extends Base_EweiShopV2Page
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$mid = intval($_GPC['mid']);
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);
		$share_set = set_medias(m('common')->getSysset('share'), 'icon');
		$can = false;
		if (empty($member['isagent']) || empty($member['status'])) {
			header('location: ' . mobileUrl('commission/register'));
			exit();
		}

		$returnurl = urlencode(mobileUrl('commission/qrcode', array('goodsid' => $_GPC['goodsid'])));
		$infourl = '';
		$set = $this->set;
		if (!empty($set['closed_qrcode']) && !intval($_GPC['goodsid'])) {
			return app_error(AppError::$CommissionQrcodeNoOpen);
		}

		if (empty($set['become_reg'])) {
			if (empty($member['realname'])) {
				return app_error(AppError::$CommissionNoUserInfo);
			}
		}

		$myshop = $this->model->getShop($member['id']);
		$share_goods = false;
		$share = array();
		$goodsid = intval($_GPC['goodsid']);

		if (!empty($goodsid)) {
			$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $goodsid));
			$goods = set_medias($goods, 'thumb');

			if (!empty($goods)) {
				$commission = number_format($this->model->getCommission($goods), 2);
				$share_goods = true;
				$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goods['description']) ? $goods['description'] : (empty($set['closemyshop']) ? $myshop['name'] : $_W['shopset']['shop']['name']), 'link' => mobileUrl('commission/share', array('goodsid' => $goods['id'], 'mid' => $member['id']), true));
			}
		}

		if (!$share_goods) {
			if (empty($set['closemyshop'])) {
				$_W['shopshare'] = array('imgUrl' => $myshop['logo'], 'title' => $myshop['name'], 'desc' => $myshop['desc'], 'link' => mobileUrl('commission/share', array('mid' => $member['id']), true));
			}
			else {
				$_W['shopshare'] = array('imgUrl' => !empty($share_set['icon']) ? $share_set['icon'] : $_W['shopset']['shop']['logo'], 'title' => !empty($share_set['title']) ? $share_set['title'] : $_W['shopset']['shop']['name'], 'desc' => !empty($share_set['desc']) ? $share_set['desc'] : $_W['shopset']['shop']['description'], 'link' => mobileUrl('commission/share', array('mid' => $member['id']), true));
			}
		}

		if ($_W['ispost']) {
			$p = p('poster');
			$img = '';

			if ($share_goods) {
				if ($p) {
					$img = $p->createCommissionPoster($openid, $goods['id']);
				}

				if (empty($img)) {
					$img = $this->model->createGoodsImage($goods);
				}
			}
			else if (!empty($set['qrcode'])) {
				if ($p) {
					$img = $p->createCommissionPoster($openid, 0, 4);
				}
			}
			else {
				if ($p) {
					$img = $p->createCommissionPoster($openid);
				}

				if (empty($img)) {
					$img = $this->model->createShopImage();
				}
			}

			return app_json(array('img' => $img));
		}

		$set['qrcode_content'] = htmlspecialchars_decode($set['qrcode_content'], ENT_QUOTES);
		$set_res = array('texts' => $set['texts'], 'qrcode' => $set['qrcode'], 'qrcode_title' => $set['qrcode_title'], 'become_child' => $set['become_child'], 'qrcode_content' => $set['qrcode_content'], 'qrcode_remark' => $set['qrcode_remark']);
		return app_json(array('qrcode_title' => empty($set['qrcode']) || !empty($set['qrcode']) && empty($set['qrcode_title']) ? '如何赚钱' : $set['qrcode_title'], 'qrcode_remark' => empty($set['qrcode']) || !empty($set['qrcode']) && empty($set['qrcode_remark']), 'set' => $set_res));
	}
}

?>
