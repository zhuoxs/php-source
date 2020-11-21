<?php
//dezend by http://www.efwww.com/
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'commission/core/page_login_mobile.php';
class Qrcode_EweiShopV2Page extends CommissionMobileLoginPage
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
			$this->message('没有开启推广二维码!', mobileUrl('commission'), 'info');
		}

		if (empty($set['become_reg'])) {
			$diyform_flag = 0;
			if (p('diyform') && !empty($member['diymemberdata'])) {
				$diyform_flag = 1;
			}

			if (empty($member['realname']) && empty($diyform_flag)) {
				$this->message('需要您完善资料才能继续操作!', mobileUrl('member/info', array('returnurl' => $returnurl)), 'info');
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

			show_json(1, array('img' => $img . '?t=' . TIMESTAMP));
		}

		$set['qrcode_content'] = htmlspecialchars_decode($set['qrcode_content'], ENT_QUOTES);
		include $this->template();
	}
}

?>
