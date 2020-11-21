<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Card_EweiShopV2Page extends WebPage
{
	public function __construct($_com = 'wxcard')
	{
		parent::__construct($_com);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$card = m('common')->getSysset('membercard');

		if (!empty($card)) {
			$result = com('wxcard')->wxCardGetQrcodeUrl($card['card_id']);

			if (!is_wxerror($result)) {
				$codeimg = $result['show_qrcode_url'];
			}

			$result2 = com('wxcard')->wxCardGetQuantity($card['card_id']);

			if (!is_wxerror($result2)) {
				$card['card_quantity'] = $result2['quantity'];
				$card['card_totalquantity'] = $result2['total_quantity'];
				m('common')->updateSysset(array('membercard' => $card));
			}
		}

		include $this->template();
	}

	public function activationset()
	{
		global $_W;
		global $_GPC;
		$item = m('common')->getSysset('memberCardActivation');

		if (com('sms')) {
			$template_sms = com_run('sms::sms_temp');
		}

		if (!empty($item['couponid'])) {
			$coupon = pdo_fetch('SELECT id,couponname as title , thumb  FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . $_W['uniacid'] . ' and id =' . $item['couponid']);
		}

		$levels = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_member_level') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY level asc'));

		if ($_W['ispost']) {
			$data = array('centerget' => intval($_GPC['centerget']), 'openactive' => intval($_GPC['openactive']), 'realname' => intval($_GPC['realname']), 'mobile' => intval($_GPC['mobile']), 'birthday' => intval($_GPC['birthday']), 'idnumber' => intval($_GPC['idnumber']), 'sms_active' => intval($_GPC['sms_active']), 'sms_id' => intval($_GPC['sms_id']), 'credit1' => intval($_GPC['credit1']), 'credit2' => floatval($_GPC['credit2']), 'couponid' => intval($_GPC['couponid']), 'levelid' => intval($_GPC['levelid']));
			m('common')->updateSysset(array('memberCardActivation' => $data));
			show_json(1, array('url' => webUrl('member/card/activationset')));
		}

		include $this->template();
	}

	public function post()
	{
		global $_W;
		global $_GPC;
		$card = m('common')->getSysset('membercard');

		if ($_W['ispost']) {
			if (128 < strlen($_GPC['custom_cell1_url'])) {
				show_json(0, '入口跳转链接不能超过128个字符');
			}

			$prerogative = htmlspecialchars($_GPC['prerogative'], ENT_QUOTES);
			$prerogative = istripslashes($prerogative);
			$card_description = htmlspecialchars($_GPC['card_description'], ENT_QUOTES);
			$card_description = istripslashes($card_description);

			if (empty($prerogative)) {
				show_json(0, '会员卡特权说明不能为空');
			}

			if (300 < mb_strlen($prerogative, 'UTF-8')) {
				show_json(0, '会员卡特权不能超过300个字符');
			}

			if (empty($card_description)) {
				show_json(0, '使用须知说明不能为空');
			}

			if (300 < mb_strlen($card_description, 'UTF-8')) {
				show_json(0, '使用须知不能超过300个字符');
			}

			$carddata = array('card_backgroundtype' => $_GPC['card_backgroundtype'], 'color' => $_GPC['color'], 'color2' => $_GPC['color2'], 'prerogative' => $prerogative, 'card_description' => $card_description, 'custom_cell1' => $_GPC['custom_cell1'], 'custom_cell1_name' => $_GPC['custom_cell1_name'], 'custom_cell1_tips' => $_GPC['custom_cell1_tips'], 'custom_cell1_url' => $_GPC['custom_cell1_url']);
			if (empty($card) || $card['card_logoimg'] != $_GPC['card_logoimg']) {
				if (empty($card)) {
					if (empty($_GPC['card_logoimg'])) {
						show_json(0, 'logo图片不能为空');
					}
				}

				$imgurl = ATTACHMENT_ROOT . $_GPC['card_logolocalpath'];

				if (!is_file($imgurl)) {
					$img = tomedia($_GPC['card_logolocalpath']);
					$img = ihttp_get($img);

					if (is_error($img)) {
						show_json(0, '上传的logo图片限制文件大小限制1MB，像素为300*300，仅支持JPG、PNG格式。');
					}

					$img = $img['content'];

					if (strlen($img) != 0) {
						file_put_contents($imgurl, $img);
					}
					else {
						show_json(0, '上传的logo图片限制文件大小限制1MB，像素为300*300，仅支持JPG、PNG格式。');
					}
				}

				$result = com('wxcard')->wxCardUpdateImg($imgurl);

				if (is_wxerror($result)) {
					$error_msg = empty($result['errmsg']) ? '上传的logo图片失败。' : $result['errmsg'];
					show_json(0, $error_msg);
				}

				$carddata['card_logoimg'] = $_GPC['card_logoimg'];
				$carddata['card_logowxurl'] = $result['url'];
			}

			if (!empty($_GPC['card_backgroundtype'])) {
				if (empty($card) || $card['card_backgroundimg'] != $_GPC['card_backgroundimg']) {
					if (empty($card)) {
						if (empty($_GPC['card_backgroundimg'])) {
							show_json(0, '设置使用背景图片时图片不能为空');
						}
					}

					$imgurl = ATTACHMENT_ROOT . $_GPC['card_backgroundimg_localpath'];

					if (!is_file($imgurl)) {
						$img = tomedia($_GPC['card_backgroundimg_localpath']);
						$img = ihttp_get($img);

						if (is_error($img)) {
							show_json(0, '上传的背景图片限制文件大小限制1MB，像素为1000*600，仅支持JPG、PNG格式');
						}

						$img = $img['content'];

						if (strlen($img) != 0) {
							file_put_contents($imgurl, $img);
						}
						else {
							show_json(0, '上传的背景图片限制文件大小限制1MB，像素为1000*600，仅支持JPG、PNG格式');
						}
					}

					$result = com('wxcard')->wxCardUpdateImg($imgurl);

					if (is_wxerror($result)) {
						show_json(0, '上传的背景图片限制文件大小限制1MB，像素为1000*600，仅支持JPG、PNG格式');
					}

					$carddata['card_backgroundimg'] = $_GPC['card_backgroundimg'];
					$carddata['card_backgroundwxurl'] = $result['url'];
				}
				else {
					if (!empty($card) && $card['card_backgroundimg'] == $_GPC['card_backgroundimg']) {
						$carddata['card_backgroundimg'] = $card['card_backgroundimg'];
						$carddata['card_backgroundwxurl'] = $card['card_backgroundwxurl'];
					}
				}
			}

			if (!empty($card)) {
				$result = com('wxcard')->membercardmanager($carddata, $card['card_id']);

				if ($result['errcode'] == 48001) {
					show_json(0, '您尚未开通微信会员卡。');
				}

				if ($result['errcode'] == 43010) {
					show_json(0, '不能使用余额，需要申请授权。');
				}

				if (is_wxerror($result)) {
					show_json(0, '卡券信息填写有误');
				}

				$this->savecard($carddata);
			}
			else {
				$card_title = htmlspecialchars($_GPC['card_title'], ENT_QUOTES);
				$card_title = istripslashes($card_title);
				$card_brand_name = htmlspecialchars($_GPC['card_brand_name'], ENT_QUOTES);
				$card_brand_name = istripslashes($card_brand_name);
				$card_supply_balance = $_GPC['card_supply_balance'];

				if (empty($card_title)) {
					show_json(0, '会员卡标题不能为空');
				}

				if (25 < strlen($card_title)) {
					show_json(0, '会员卡标题不能超过25个字符');
				}

				if (empty($card_brand_name)) {
					show_json(0, '商户名称不能为空');
				}

				if (30 < strlen($card_brand_name)) {
					show_json(0, '商户名称不能超过30个字符');
				}

				if (9999999 < intval($_GPC['card_totalquantity']) || intval($_GPC['card_totalquantity']) < 1) {
					show_json(0, '会员卡库存需设置再1与9999999之间');
				}

				$carddata['card_title'] = $card_title;
				$carddata['card_brand_name'] = $card_brand_name;
				$carddata['card_supply_balance'] = $card_supply_balance;
				$carddata['card_totalquantity'] = $_GPC['card_totalquantity'];
				$carddata['card_quantity'] = $_GPC['card_totalquantity'];
				$carddata['freewifi'] = $_GPC['freewifi'] == 'on' ? 1 : 0;
				$carddata['withpet'] = $_GPC['withpet'] == 'on' ? 1 : 0;
				$carddata['freepark'] = $_GPC['freepark'] == 'on' ? 1 : 0;
				$carddata['deliver'] = $_GPC['deliver'] == 'on' ? 1 : 0;
				$result = com('wxcard')->membercardmanager($carddata);

				if ($result['errcode'] == 48001) {
					show_json(0, '您尚未开通微信会员卡。');
				}

				if ($result['errcode'] == 43010) {
					show_json(0, '不能使用余额，需要申请授权。');
				}

				if (is_wxerror($result)) {
					show_json(0, '卡券信息填写有误。');
				}
				else {
					$carddata['card_id'] = $result['card_id'];
				}

				$this->savecard($carddata);
			}

			show_json(1, array('url' => webUrl('member/card/post')));
		}

		include $this->template();
	}

	public function savecard($carddata)
	{
		global $_W;
		$card = m('common')->getSysset('membercard');

		if (empty($card)) {
			m('common')->updateSysset(array('membercard' => $carddata));
		}
		else {
			if ($carddata['card_backgroundtype'] != $card['card_backgroundtype']) {
				$card['card_backgroundtype'] = $carddata['card_backgroundtype'];
			}

			if (!empty($carddata['color']) && $carddata['color'] != $card['color']) {
				$card['color'] = $carddata['color'];
			}

			if (!empty($carddata['color2']) && $carddata['color2'] != $card['color']) {
				$card['color2'] = $carddata['color2'];
			}

			if (!empty($carddata['prerogative']) && $carddata['prerogative'] != $card['prerogative']) {
				$card['prerogative'] = $carddata['prerogative'];
			}

			if (!empty($carddata['card_description']) && $carddata['card_description'] != $card['card_description']) {
				$card['card_description'] = $carddata['card_description'];
			}

			if ($carddata['custom_cell1'] != $card['custom_cell1']) {
				if (empty($carddata['custom_cell1'])) {
					$carddata['custom_cell1'] = 0;
				}

				$card['custom_cell1'] = $carddata['custom_cell1'];
			}

			if (!empty($carddata['custom_cell1_name']) && $carddata['custom_cell1_name'] != $card['custom_cell1_name']) {
				$card['custom_cell1_name'] = $carddata['custom_cell1_name'];
			}

			if (!empty($carddata['custom_cell1_tips']) && $carddata['custom_cell1_tips'] != $card['custom_cell1_tips']) {
				$card['custom_cell1_tips'] = $carddata['custom_cell1_tips'];
			}

			if (!empty($carddata['custom_cell1_url']) && $carddata['custom_cell1_url'] != $card['custom_cell1_url']) {
				$card['custom_cell1_url'] = $carddata['custom_cell1_url'];
			}

			if (!empty($carddata['card_logoimg']) && $carddata['card_logoimg'] != $card['card_logoimg']) {
				$card['card_logoimg'] = $carddata['card_logoimg'];
			}

			if (!empty($carddata['card_logowxurl']) && $carddata['card_logowxurl'] != $card['card_logowxurl']) {
				$card['card_logowxurl'] = $carddata['card_logowxurl'];
			}

			$card['card_backgroundimg'] = $carddata['card_backgroundimg'];
			if (!empty($carddata['card_backgroundwxurl']) && $carddata['card_backgroundwxurl'] != $card['card_backgroundwxurl']) {
				$card['card_backgroundwxurl'] = $carddata['card_backgroundwxurl'];
			}

			m('common')->updateSysset(array('membercard' => $card));
		}
	}

	public function stock()
	{
		global $_W;
		global $_GPC;

		if (!cv('member.card')) {
			$this->message('你没有相应的权限查看');
		}

		$card = m('common')->getSysset('membercard');

		if (!empty($card)) {
			com('wxcard')->wxmemberCardUpdateQuantity();
		}

		$card = m('common')->getSysset('membercard');

		if ($_W['ispost']) {
			$changetype = intval($_GPC['changetype']);
			$num = intval($_GPC['num']);

			if ($num <= 0) {
				show_json(0, array('message' => '请填写大于0的数字!'));
			}

			$quantity = $card['card_quantity'];
			$total_quantity = $card['card_totalquantity'];

			if (empty($changetype)) {
				$quantity += $num;
				$total_quantity += $num;
			}
			else {
				$quantity -= $num;
				$total_quantity -= $num;

				if ($quantity < 0) {
					show_json(0, array('message' => '减少数量不能大于当前库存!'));
				}
			}

			com('wxcard')->wxCardModifyStock($card['card_id'], $num, $changetype);
			$card['card_quantity'] = $quantity;
			$card['card_totalquantity'] = $total_quantity;
			m('common')->updateSysset(array('membercard' => $card));
			show_json(1, array('url' => referer()));
		}

		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;

		if (!cv('member.card')) {
			$this->message('你没有相应的权限查看');
		}

		$card = m('common')->getSysset('membercard');

		if (!empty($card)) {
			$res = com('wxcard')->wxCardDelete($card['card_id']);
			m('common')->deleteSysset('membercard');

			if (is_wxerror($res)) {
				show_json(0, '删除失败!错误信息:' . $res['errmsg']);
			}
		}

		show_json(1, array('url' => referer()));
	}

	public function qrcode()
	{
		global $_W;
		global $_GPC;

		if (!cv('sale.wxcard.qrcode')) {
			$this->message('你没有相应的权限查看');
		}

		$id = intval($_GPC['id']);
		$card_id = $_GPC['card_id'];
		$result = com('wxcard')->wxCardGetQrcodeUrl($card_id);

		if (!is_wxerror($result)) {
			$codeimg = $result['show_qrcode_url'];
		}
		else {
			$iserror = true;
		}

		include $this->template();
	}
}

?>
