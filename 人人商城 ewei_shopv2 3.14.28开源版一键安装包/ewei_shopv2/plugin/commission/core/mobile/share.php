<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'commission/core/page_mobile.php';
class Share_EweiShopV2Page extends CommissionMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$mid = intval($_GPC['mid']);
		$member = m('member')->getMember($mid);

		if (empty($member)) {
			$this->message('分享出错，请检查JS安全域名设置!');
		}

		$share_set = set_medias(m('common')->getSysset('share'), 'icon');
		$set = $this->set;
		$myshop = $this->model->getShop($member['id']);
		$shop_set = $_W['shopset']['shop'];
		$share_goods = false;
		$share = array();
		$goodsid = intval($_GPC['goodsid']);
		$qrcode = '';
		$path = $_W['siteroot'] . 'addons/ewei_shopv2/data/poster/' . $_W['uniacid'] . '/';

		if (!empty($goodsid)) {
			$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $goodsid));
			$goods = set_medias($goods, 'thumb');

			if (!empty($goods)) {
				$commission = number_format($this->model->getCommission($goods), 2);
				$share_goods = true;
				$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goods['description']) ? $goods['description'] : (empty($set['closemyshop']) ? $myshop['name'] : $shop_set['name']), 'link' => mobileUrl('commission/share', array('goodsid' => $goods['id'], 'mid' => $member['id']), true));
				$img = empty($goods['commission_thumb']) ? $goods['thumb'] : tomedia($goods['commission_thumb']);
				$md5 = md5(json_encode(array('id' => $goods['id'], 'marketprice' => $goods['marketprice'], 'productprice' => $goods['productprice'], 'img' => $img, 'shopset' => $shop_set, 'openid' => $member['openid'], 'version' => 4)));
				$qrcode = $path . $md5 . '.jpg';
				if (p('poster') && !is_file(IA_ROOT . '/addons/ewei_shopv2/data/poster/' . $_W['uniacid'] . '/' . $md5 . '.jpg')) {
					$poster = pdo_fetch('select bg,data from ' . tablename('ewei_shop_poster') . ' where uniacid=:uniacid and type=3 and isdefault=1', array(':uniacid' => $_W['uniacid']));

					if (!empty($poster)) {
						$md5 = md5(json_encode(array('siteroot' => $_W['siteroot'], 'openid' => $member['openid'], 'goodsid' => $goodsid, 'bg' => $poster['bg'], 'data' => $poster['data'], 'version' => 1)));
						$qrcode = $path . $md5 . '.png';
					}
				}
			}
		}

		if (!$share_goods) {
			$_W['shopshare'] = array('imgUrl' => !empty($share_set['icon']) ? $share_set['icon'] : $shop_set['logo'], 'title' => !empty($share_set['title']) ? $share_set['title'] : $shop_set['name'], 'desc' => !empty($share_set['desc']) ? $share_set['desc'] : $shop_set['description'], 'link' => mobileUrl('commission/share', array('mid' => $_GPC['mid']), true));
			$shop_set = set_medias($_W['shopset']['shop'], 'signimg');
			$md5 = md5(json_encode(array('openid' => $member['openid'], 'signimg' => $shop_set['signimg'], 'shopset' => $shop_set, 'version' => 4)));
			$qrcode = $path . $md5 . '.jpg';
			if (p('poster') && !is_file(IA_ROOT . '/addons/ewei_shopv2/data/poster/' . $_W['uniacid'] . '/' . $md5 . '.jpg')) {
				$poster = pdo_fetch('select bg,`data` from ' . tablename('ewei_shop_poster') . ' where uniacid=:uniacid and `type`=:type and isdefault=1 limit 1', array(':uniacid' => $_W['uniacid'], ':type' => empty($set['qrcode']) ? 2 : 4));

				if (!empty($poster)) {
					$md5 = md5(json_encode(array('siteroot' => $_W['siteroot'], 'openid' => $member['openid'], 'goodsid' => '0', 'bg' => $poster['bg'], 'data' => $poster['data'], 'version' => 1)));
					$qrcode = $path . $md5 . '.png';
				}
			}
		}

		include $this->template();
	}
}

?>
