
<?php
global $_W;
global $_GPC;
$shopset_level = intval($_W['shopset']['commission']['level']);
$id = intval($_GPC['id']);

if (!(empty($id))) {
	pdo_update('ewei_shop_goods', array('newgoods' => 0), array('id' => $id));
}


$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods') . ' WHERE id = :id and uniacid = :uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

if (!(empty($item)) && ($item['type'] == 5) && !(empty($item['opencard'])) && !(empty($item['cardid']))) {
	$card = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_cards') . ' WHERE id = :id and uniacid = :uniacid', array(':id' => $item['cardid'], ':uniacid' => $_W['uniacid']));
}


$status = $item['status'];

if (json_decode($item['labelname'], true)) {
	$labelname = json_decode($item['labelname'], true);
}
 else {
	$labelname = unserialize($item['labelname']);
}

$endtime = ((empty($item['endtime']) ? date('Y-m-d H:i', time()) : date('Y-m-d H:i', $item['endtime'])));
$item['statustimestart'] = ((0 < $item['statustimestart'] ? $item['statustimestart'] : time()));
$item['statustimeend'] = ((0 < $item['statustimeend'] ? $item['statustimeend'] : strtotime('+1 month')));
$intervalprices = iunserializer($item['intervalprice']);

if (empty($labelname)) {
	$labelname = array();
}


foreach ($labelname as $key => $value ) {
	$label[$key]['id'] = $value;
	$label[$key]['labelname'] = $value;
}

$merchid = 0;
$merch_plugin = p('merch');

if (!(empty($item))) {
	if (0 < $item['merchid']) {
		$merchid = intval($item['merchid']);

		if ($merch_plugin) {
			$merch_user = $merch_plugin->getListUserOne($merchid);
		}

	}

}


$area_set = m('util')->get_area_config_set();
$new_area = intval($area_set['new_area']);
$address_street = intval($area_set['address_street']);

if (p('diyform')) {
	$diyform = p('diyform');
	$globalData = $diyform->globalData();
	extract($globalData);

	if (!(empty($item['diysaveid']))) {
		$diyforminfo = $diyform->getDiyformInfo($item['diysaveid'], 0);
	}

}


$ccard_plugin = p('ccard');
$ccard = 0;

if ($ccard_plugin) {
	$ccard = 1;
}


$category = m('shop')->getFullCategory(true, true);
$levels = m('member')->getLevels();

foreach ($levels as &$l ) {
	$l['key'] = 'level' . $l['id'];
}

unset($l);
$levels = array_merge(array(
	array('id' => 0, 'key' => 'default', 'levelname' => (empty($_W['shopset']['shop']['levelname']) ? '默认会员' : $_W['shopset']['shop']['levelname']))
	), $levels);
$groups = m('member')->getGroups();
$commission_level = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_level') . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY commission1 asc');

foreach ($commission_level as &$l ) {
	$l['key'] = 'level' . $l['id'];
}

unset($l);
$commission_level = array_merge(array(
	array('key' => 'default', 'levelname' => (empty($_W['shopset']['commission']['levelname']) ? '默认等级' : $_W['shopset']['commission']['levelname']))
	), $commission_level);
$com_virtual = com('virtual');

if ($_W['ispost']) {
	if (empty($id)) {
		$goodstype = intval($_GPC['type']);
	}
	 else {
		$goodstype = intval($_GPC['goodstype']);
	}

	if (($goodstype != 1) && (intval($_GPC['status']) == 2)) {
		show_json(0, '囎品只能是实体商品');
	}


	$data = array('uniacid' => intval($_W['uniacid']), 'displayorder' => intval($_GPC['displayorder']), 'title' => trim($_GPC['goodsname']), 'subtitle' => trim($_GPC['subtitle']), 'shorttitle' => trim($_GPC['shorttitle']), 'keywords' => trim($_GPC['keywords']), 'thumb_first' => intval($_GPC['thumb_first']), 'showsales' => intval($_GPC['showsales']), 'type' => $goodstype, 'ispresell' => intval($_GPC['ispresell']), 'presellover' => intval($_GPC['presellover']), 'presellovertime' => (0 < intval($_GPC['presellovertime']) ? intval($_GPC['presellovertime']) : 0), 'presellprice' => floatval($_GPC['presellprice']), 'presellstart' => intval($_GPC['presellstart']), 'presellend' => intval($_GPC['presellend']), 'preselltimestart' => (0 < intval($_GPC['presellstart']) ? strtotime($_GPC['preselltimestart']) : 0), 'preselltimeend' => (0 < intval($_GPC['presellend']) ? strtotime($_GPC['preselltimeend']) : 0), 'presellsendtype' => intval($_GPC['presellsendtype']), 'presellsendstatrttime' => strtotime($_GPC['presellsendstatrttime']), 'presellsendtime' => intval($_GPC['presellsendtime']), 'labelname' => serialize($_GPC['labelname']), 'isrecommand' => intval($_GPC['isrecommand']), 'ishot' => intval($_GPC['ishot']), 'isnew' => intval($_GPC['isnew']), 'isdiscount' => intval($_GPC['isdiscount']), 'isdiscount_title' => trim(mb_substr($_GPC['isdiscount_title'], 0, 5, 'UTF-8')), 'isdiscount_time' => strtotime($_GPC['isdiscount_time']), 'issendfree' => intval($_GPC['issendfree']), 'isnodiscount' => intval($_GPC['isnodiscount']), 'istime' => intval($_GPC['istime']), 'timestart' => strtotime($_GPC['saletime']['start']), 'timeend' => strtotime($_GPC['saletime']['end']), 'description' => trim($_GPC['description']), 'goodssn' => trim($_GPC['goodssn']), 'unit' => trim($_GPC['unit']), 'createtime' => TIMESTAMP, 'total' => intval($_GPC['total']), 'showtotal' => intval($_GPC['showtotal']), 'totalcnf' => intval($_GPC['totalcnf']), 'unite_total' => intval($_GPC['unite_total']), 'marketprice' => $_GPC['marketprice'], 'weight' => $_GPC['weight'], 'costprice' => $_GPC['costprice'], 'productprice' => trim($_GPC['productprice']), 'productsn' => trim($_GPC['productsn']), 'credit' => trim($_GPC['credit']), 'maxbuy' => intval($_GPC['maxbuy']), 'minbuy' => intval($_GPC['minbuy']), 'usermaxbuy' => intval($_GPC['usermaxbuy']), 'hasoption' => intval($_GPC['hasoption']), 'sales' => intval($_GPC['sales']), 'share_icon' => trim($_GPC['share_icon']), 'share_title' => trim($_GPC['share_title']), 'status' => ($status != 2 ? intval($_GPC['status']) : $status), 'groupstype' => intval($_GPC['groupstype']), 'virtualsend' => intval($_GPC['virtualsend']), 'virtualsendcontent' => trim($_GPC['virtualsendcontent']), 'buyshow' => intval($_GPC['buyshow']), 'showlevels' => (is_array($_GPC['showlevels']) ? implode(',', $_GPC['showlevels']) : ''), 'buylevels' => (is_array($_GPC['buylevels']) ? implode(',', $_GPC['buylevels']) : ''), 'showgroups' => (is_array($_GPC['showgroups']) ? implode(',', $_GPC['showgroups']) : ''), 'buygroups' => (is_array($_GPC['buygroups']) ? implode(',', $_GPC['buygroups']) : ''), 'noticeopenid' => (is_array($_GPC['noticeopenid']) ? implode(',', $_GPC['noticeopenid']) : ''), 'noticetype' => (is_array($_GPC['noticetype']) ? implode(',', $_GPC['noticetype']) : ''), 'needfollow' => intval($_GPC['needfollow']), 'followurl' => trim($_GPC['followurl']), 'followtip' => trim($_GPC['followtip']), 'deduct' => $_GPC['deduct'], 'manydeduct' => $_GPC['manydeduct'], 'deduct2' => $_GPC['deduct2'], 'virtual' => ($goodstype == 3 ? intval($_GPC['virtual']) : 0), 'ednum' => intval($_GPC['ednum']), 'edareas' => trim($_GPC['edareas']), 'edareas_code' => trim($_GPC['edareas_code']), 'edmoney' => trim($_GPC['edmoney']), 'invoice' => intval($_GPC['invoice']), 'repair' => intval($_GPC['repair']), 'seven' => intval($_GPC['seven']), 'money' => trim($_GPC['money']), 'province' => trim($_GPC['province']), 'city' => trim($_GPC['city']), 'quality' => intval($_GPC['quality']), 'sharebtn' => intval($_GPC['sharebtn']), 'autoreceive' => intval($_GPC['autoreceive']), 'cannotrefund' => intval($_GPC['cannotrefund']), 'buyagain' => floatval($_GPC['buyagain']), 'buyagain_islong' => intval($_GPC['buyagain_islong']), 'buyagain_condition' => intval($_GPC['buyagain_condition']), 'buyagain_sale' => intval($_GPC['buyagain_sale']), 'diypage' => intval($_GPC['diypage']), 'cashier' => intval($_GPC['cashier']), 'video' => trim($_GPC['video']));
	$data['nosearch'] = intval($_GPC['nosearch']);
	$data['isstatustime'] = intval($_GPC['isstatustime']);
	$statustimestart = strtotime($_GPC['statustime']['start']);
	$statustimeend = strtotime($_GPC['statustime']['end']);
	$data['statustimestart'] = $statustimestart;
	$data['statustimeend'] = $statustimeend;

	if (($data['status'] == 1) && (0 < $data['isstatustime'])) {
		if (!(($statustimestart < time()) && (time() < $statustimeend))) {
			show_json(0, '上架时间不符合要求！');
		}

	}


	$intervalfloor = 0;
	$intervalprice = '';

	if ($goodstype == 4) {
		$intervalfloor = intval($_GPC['intervalfloor']);
		if ((3 < $intervalfloor) || ($intervalfloor < 1)) {
			show_json(0, '请至少添加一个区间价格！');
		}


		$intervalprices = array();

		if (0 < $intervalfloor) {
			if (intval($_GPC['intervalnum1']) <= 0) {
				show_json(0, '请设置起批发量！');
			}


			if (floatval($_GPC['intervalprice1']) <= 0) {
				show_json(0, '批发价必须大于0！');
			}


			$intervalprices[] = array('intervalnum' => intval($_GPC['intervalnum1']), 'intervalprice' => floatval($_GPC['intervalprice1']));
		}


		if (1 < $intervalfloor) {
			if (intval($_GPC['intervalnum2']) <= 0) {
				show_json(0, '请设置起批发量！');
			}


			if (intval($_GPC['intervalnum2']) <= intval($_GPC['intervalnum1'])) {
				show_json(0, '批发量需大于上级批发量！');
			}


			if (floatval($_GPC['intervalprice1']) <= floatval($_GPC['intervalprice2'])) {
				show_json(0, '批发价需小于上级批发价！');
			}


			$intervalprices[] = array('intervalnum' => intval($_GPC['intervalnum2']), 'intervalprice' => floatval($_GPC['intervalprice2']));
		}


		if (2 < $intervalfloor) {
			if (intval($_GPC['intervalnum3']) <= 0) {
				show_json(0, '请设置起批发量！');
			}


			if (intval($_GPC['intervalnum3']) <= intval($_GPC['intervalnum2'])) {
				show_json(0, '批发量需大于上级批发量！');
			}


			if (floatval($_GPC['intervalprice2']) <= floatval($_GPC['intervalprice3'])) {
				show_json(0, '批发价需小于上级批发价！');
			}


			$intervalprices[] = array('intervalnum' => intval($_GPC['intervalnum3']), 'intervalprice' => floatval($_GPC['intervalprice3']));
		}


		$intervalprice = iserializer($intervalprices);
		$data['intervalfloor'] = $intervalfloor;
		$data['intervalprice'] = $intervalprice;
		$data['minbuy'] = $_GPC['intervalnum1'];
		$data['marketprice'] = $_GPC['intervalprice1'];
		$data['productprice'] = 0;
		$data['costprice'] = 0;
	}


	if (intval($_GPC['ispresell']) == 1) {
		if (floatval($_GPC['presellprice'] <= 0)) {
			show_json(0, '请填写预售价格！');
		}


		$data['isdiscount'] = 0;
		$data['istime'] = 0;
	}


	$buyagain_commission = ((is_array($_GPC['buyagain_commission']) ? $_GPC['buyagain_commission'] : array()));

	if (!(empty($buyagain_commission))) {
		$buyagain_commission['type'] = 0;
		$data['buyagain_commission'] = json_encode($buyagain_commission);
	}


	if ($merchid == 0) {
		$data['isverify'] = $_GPC['isverify'];
		$data['verifytype'] = intval($_GPC['verifytype']);
		$data['storeids'] = ((is_array($_GPC['storeids']) ? implode(',', $_GPC['storeids']) : ''));
		if ((intval($_GPC['isverify']) == 2) || ($goodstype == 2) || ($goodstype == 3)) {
			$data['cash'] = 0;
		}
		 else {
			$data['cash'] = intval($_GPC['cash']);
		}

		$data['detail_logo'] = save_media($_GPC['detail_logo']);
		$data['detail_shopname'] = trim($_GPC['detail_shopname']);
		$data['detail_totaltitle'] = trim($_GPC['detail_totaltitle']);
		$data['detail_btntext1'] = trim($_GPC['detail_btntext1']);
		$data['detail_btnurl1'] = trim($_GPC['detail_btnurl1']);
		$data['detail_btntext2'] = trim($_GPC['detail_btntext2']);
		$data['detail_btnurl2'] = trim($_GPC['detail_btnurl2']);
	}
	 else {
		if ((intval($item['isverify']) == 2) || ($goodstype == 2) || ($goodstype == 3)) {
			$data['cash'] = 0;
		}
		 else {
			$data['cash'] = intval($_GPC['cash']);
		}

		$data['merchsale'] = intval($_GPC['merchsale']);
	}

	$data['isendtime'] = intval($_GPC['isendtime']);
	$data['usetime'] = intval($_GPC['usetime']);
	$data['endtime'] = strtotime($_GPC['endtime']);
	$cateset = m('common')->getSysset('shop');
	$pcates = array();
	$ccates = array();
	$tcates = array();
	$fcates = array();
	$cates = array();
	$pcateid = 0;
	$ccateid = 0;
	$tcateid = 0;

	if (is_array($_GPC['cates'])) {
		$cates = $_GPC['cates'];

		foreach ($cates as $key => $cid ) {
			$c = pdo_fetch('select level from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));

			if ($c['level'] == 1) {
				$pcates[] = $cid;
			}
			 else if ($c['level'] == 2) {
				$ccates[] = $cid;
			}
			 else if ($c['level'] == 3) {
				$tcates[] = $cid;
			}


			if ($key == 0) {
				if ($c['level'] == 1) {
					$pcateid = $cid;
				}
				 else if ($c['level'] == 2) {
					$crow = pdo_fetch('select parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
					$pcateid = $crow['parentid'];
					$ccateid = $cid;
				}
				 else if ($c['level'] == 3) {
					$tcateid = $cid;
					$tcate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $cid, ':uniacid' => $_W['uniacid']));
					$ccateid = $tcate['parentid'];
					$ccate = pdo_fetch('select id,parentid from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $ccateid, ':uniacid' => $_W['uniacid']));
					$pcateid = $ccate['parentid'];
				}

			}

		}
	}


	$data['pcate'] = $pcateid;
	$data['ccate'] = $ccateid;
	$data['tcate'] = $tcateid;
	$data['cates'] = implode(',', $cates);
	$data['pcates'] = implode(',', $pcates);
	$data['ccates'] = implode(',', $ccates);
	$data['tcates'] = implode(',', $tcates);
	$data['content'] = m('common')->html_images($_GPC['content']);
	$data['buycontent'] = m('common')->html_images($_GPC['buycontent']);

	if (p('commission')) {
		$cset = p('commission')->getSet();

		if (!(empty($cset['level']))) {
			$data['nocommission'] = intval($_GPC['nocommission']);
			$data['hascommission'] = intval($_GPC['hascommission']);
			$data['hidecommission'] = intval($_GPC['hidecommission']);
			$data['commission1_rate'] = $_GPC['commission1_rate'];
			$data['commission2_rate'] = $_GPC['commission2_rate'];
			$data['commission3_rate'] = $_GPC['commission3_rate'];
			$data['commission1_pay'] = $_GPC['commission1_pay'];
			$data['commission2_pay'] = $_GPC['commission2_pay'];
			$data['commission3_pay'] = $_GPC['commission3_pay'];
			$data['commission_thumb'] = save_media($_GPC['commission_thumb']);
		}
	}
	if ($ccard_plugin) {
		if ($goodstype == 20) {
			$data['rdays'] = intval($_GPC['rdays']);
			$data['ccardexplain'] = trim($_GPC['ccardexplain']);
			$data['ccardtimeexplain'] = trim($_GPC['ccardtimeexplain']);
			$data['nocommission'] = 1;
		}
	}
	if ($diyform) {
		if ($_GPC['diyformtype'] == 2) {
			$diydata = $diyform->getInsertDataByAdmin();
			$diydata = iserializer($diydata);
			$_GPC['diysave'] = intval($_GPC['diysave']);

			if ($_GPC['diysave'] == 1) {
				$diysaveid = $item['diysaveid'];
				$insert = array();
				$insert['title'] = '商品ID' . $item['id'] . '的自定义表单';
				$insert['fields'] = $diydata;
				$is_save = $diyform->isHasDiyform($diysaveid);

				if (empty($is_save)) {
					$insert['uniacid'] = $_W['uniacid'];
					pdo_insert('ewei_shop_diyform_type', $insert);
					$data['diysaveid'] = pdo_insertid();
				}
				 else {
					pdo_update('ewei_shop_diyform_type', $insert, array('id' => $diysaveid));
				}
			}


			$data['diyfields'] = $diydata;
			$data['diysave'] = $_GPC['diysave'];
		}


		$data['diyformtype'] = $_GPC['diyformtype'];

		if ($_GPC['diyformtype'] == 1) {
			$data['diyformid'] = $_GPC['diyformid'];
		}


		$data['diymode'] = intval($_GPC['diymode']);
	}


	$data['dispatchtype'] = intval($_GPC['dispatchtype']);
	$data['dispatchprice'] = trim($_GPC['dispatchprice']);
	$data['dispatchid'] = intval($_GPC['dispatchid']);

	if ($data['total'] === -1) {
		$data['total'] = 0;
		$data['totalcnf'] = 2;
	}


	if (is_array($_GPC['thumbs'])) {
		$thumbs = $_GPC['thumbs'];
		$thumb_url = array();

		foreach ($thumbs as $th ) {
			$thumb_url[] = trim($th);
		}

		$data['thumb'] = save_media($thumb_url[0]);
		unset($thumb_url[0]);
		$data['thumb_url'] = serialize(m('common')->array_images($thumb_url));
	}


	if (p('threen')) {
		$threen = $_GPC['threen'];

		if (!(empty($threen['discount'])) && !(empty($threen['price']))) {
			show_json(0, '3N营销优惠只能设置一个');
		}


		$threen['price'] = floatval(round($threen['price'], 2));
		$threen['discount'] = floatval(round($threen['discount'], 2));

		if (!(empty($threen['price'])) && (0 < !($threen['price']))) {
			show_json(0, '3N营销会员价必须大于0');
		}


		if (!(empty($threen['discount'])) && ((10 < $threen['discount']) || ($threen < 0.10000000000000001))) {
			show_json(0, '3N营销优惠需在0.1-10之间');
		}


		$data['threen'] = json_encode($threen);
	}


	if ($goodstype == 5) {
		$verifygoodsnum = intval($_GPC['verifygoodsnum']);
		$verifygoodslimittype = intval($_GPC['verifygoodslimittype']);

		if (!(empty($_GPC['verifygoodslimitdate']))) {
			$verifygoodslimitdate = strtotime($_GPC['verifygoodslimitdate']);
		}
		 else {
			$verifygoodslimitdate = 0;
		}

		$verifygoodsdays = intval($_GPC['verifygoodsdays']);

		if (empty($verifygoodslimittype)) {
			if (empty($verifygoodsdays)) {
				$verifygoodsdays = 365;
			}

		}


		if (com('wxcard')) {
			$opencard = intval($_GPC['opencard']);

			if (!(empty($opencard))) {
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


				$carddata = array('uniacid' => $_W['uniacid'], 'card_backgroundtype' => $_GPC['card_backgroundtype'], 'color' => $_GPC['color'], 'color2' => $_GPC['color2'], 'prerogative' => $_GPC['prerogative'], 'card_description' => $_GPC['card_description'], 'custom_cell1' => $_GPC['custom_cell1'], 'custom_cell1_name' => $_GPC['custom_cell1_name'], 'custom_cell1_tips' => $_GPC['custom_cell1_tips'], 'custom_cell1_url' => $_GPC['custom_cell1_url']);
				if (empty($card) || ($card['card_logoimg'] != $_GPC['card_logoimg'])) {
					if (empty($card)) {
						if (empty($_GPC['card_logoimg'])) {
							show_json(0, 'logo图片不能为空');
						}

					}


					$imgurl = ATTACHMENT_ROOT . $_GPC['card_logolocalpath'];

					if (!(is_file($imgurl))) {
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
						show_json(0, '上传的logo图片限制文件大小限制1MB，像素为300*300，仅支持JPG、PNG格式。');
					}


					$carddata['card_logoimg'] = $_GPC['card_logoimg'];
					$carddata['card_logowxurl'] = $result['url'];
				}


				if (!(empty($_GPC['card_backgroundtype']))) {
					if (empty($card) || ($card['card_backgroundimg'] != $_GPC['card_backgroundimg'])) {
						if (empty($card)) {
							if (empty($_GPC['card_logoimg'])) {
								show_json(0, '设置使用背景图片时图片不能为空');
							}

						}


						$imgurl = ATTACHMENT_ROOT . $_GPC['card_backgroundimg_localpath'];

						if (!(is_file($imgurl))) {
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
					 else if (!(empty($card)) && ($card['card_backgroundimg'] == $_GPC['card_backgroundimg'])) {
						$carddata['card_backgroundimg'] = $card['card_backgroundimg'];
						$carddata['card_backgroundwxurl'] = $card['card_backgroundwxurl'];
					}

				}


				if (!(empty($card))) {
					$change = com('wxcard')->checkchange($card, $carddata);

					if ($change) {
						$result = com('wxcard')->verifygoodcard($carddata, $card['card_id']);

						if ($result['errcode'] == 48001) {
							show_json(0, '您尚未开通微信会员卡。');
						}


						if (is_wxerror($result)) {
							show_json(0, '卡券信息填写有误。');
						}


						pdo_update('ewei_shop_goods_cards', $carddata, array('id' => $card['id']));
					}


					$cardid = $card['id'];
				}
				 else {
					if (25 < strlen($_GPC['title'])) {
						show_json(0, '会员卡标题不能超过25个字符');
					}


					if (30 < strlen($_GPC['card_brand_name'])) {
						show_json(0, '商户名字不能超过30个字符');
					}


					if ((9999999 < intval($_GPC['card_totalquantity'])) || (intval($_GPC['card_totalquantity']) < 1)) {
						show_json(0, '会员卡库存需设置再1与9999999之间');
					}


					$carddata['card_title'] = $_GPC['card_title'];
					$carddata['card_brand_name'] = $_GPC['card_brand_name'];
					$carddata['card_totalquantity'] = $_GPC['card_totalquantity'];
					$carddata['card_quantity'] = $_GPC['card_totalquantity'];
					$carddata['freewifi'] = (($_GPC['freewifi'] == 'on' ? 1 : 0));
					$carddata['withpet'] = (($_GPC['withpet'] == 'on' ? 1 : 0));
					$carddata['freepark'] = (($_GPC['freepark'] == 'on' ? 1 : 0));
					$carddata['deliver'] = (($_GPC['deliver'] == 'on' ? 1 : 0));
					$result = com('wxcard')->verifygoodcard($carddata);

					if ($result['errcode'] == 48001) {
						show_json(0, '您尚未开通微信会员卡。');
					}


					if (is_wxerror($result)) {
						show_json(0, '卡券信息填写有误。');
					}
					 else {
						$carddata['card_id'] = $result['card_id'];
					}

					pdo_insert('ewei_shop_goods_cards', $carddata);
					$cardid = pdo_insertid();
				}

				$data['cardid'] = $cardid;
			}


			$data['opencard'] = $opencard;
		}


		$data['verifygoodsnum'] = intval($verifygoodsnum);
		$data['verifygoodslimittype'] = intval($verifygoodslimittype);
		$data['verifygoodsdays'] = intval($verifygoodsdays);
		$data['verifygoodslimitdate'] = intval($verifygoodslimitdate);
	}


	if (empty($id)) {
		$data['merchid'] = 0;
		pdo_insert('ewei_shop_goods', $data);
		$id = pdo_insertid();
		plog('goods.add', '添加商品 ID: ' . $id . '<br>' . ((!(empty($data['nocommission'])) ? '是否参与分销 -- 否' : '是否参与分销 -- 是')));
	}
	 else {
		unset($data['createtime']);
		pdo_update('ewei_shop_goods', $data, array('id' => $id));
		plog('goods.edit', '编辑商品 ID: ' . $id . '<br>' . ((!(empty($data['nocommission'])) ? '是否参与分销 -- 否' : '是否参与分销 -- 是')));
	}

	$param_ids = $_POST['param_id'];
	$param_titles = $_POST['param_title'];
	$param_values = $_POST['param_value'];
	$param_displayorders = $_POST['param_displayorder'];
	$len = count($param_ids);
	$paramids = array();
	$k = 0;

	while ($k < $len) {
		$param_id = '';
		$get_param_id = $param_ids[$k];
		$a = array('uniacid' => $_W['uniacid'], 'title' => $param_titles[$k], 'value' => $param_values[$k], 'displayorder' => $k, 'goodsid' => $id);

		if (!(is_numeric($get_param_id))) {
			pdo_insert('ewei_shop_goods_param', $a);
			$param_id = pdo_insertid();
		}
		 else {
			pdo_update('ewei_shop_goods_param', $a, array('id' => $get_param_id));
			$param_id = $get_param_id;
		}

		$paramids[] = $param_id;
		++$k;
	}

	if (0 < count($paramids)) {
		pdo_query('delete from ' . tablename('ewei_shop_goods_param') . ' where goodsid=' . $id . ' and id not in ( ' . implode(',', $paramids) . ')');
	}
	 else {
		pdo_query('delete from ' . tablename('ewei_shop_goods_param') . ' where goodsid=' . $id);
	}

	$totalstocks = 0;
	$files = $_FILES;
	$spec_ids = $_POST['spec_id'];
	$spec_titles = $_POST['spec_title'];
	$specids = array();
	$len = count($spec_ids);
	$specids = array();
	$spec_items = array();
	$k = 0;

	while ($k < $len) {
		$spec_id = '';
		$get_spec_id = $spec_ids[$k];
		$a = array('uniacid' => $_W['uniacid'], 'goodsid' => $id, 'displayorder' => $k, 'title' => $spec_titles[$get_spec_id]);

		if (is_numeric($get_spec_id)) {
			pdo_update('ewei_shop_goods_spec', $a, array('id' => $get_spec_id));
			$spec_id = $get_spec_id;
		}
		 else {
			pdo_insert('ewei_shop_goods_spec', $a);
			$spec_id = pdo_insertid();
		}

		$spec_item_ids = $_POST['spec_item_id_' . $get_spec_id];
		$spec_item_titles = $_POST['spec_item_title_' . $get_spec_id];
		$spec_item_shows = $_POST['spec_item_show_' . $get_spec_id];
		$spec_item_thumbs = $_POST['spec_item_thumb_' . $get_spec_id];
		$spec_item_oldthumbs = $_POST['spec_item_oldthumb_' . $get_spec_id];
		$spec_item_virtuals = $_POST['spec_item_virtual_' . $get_spec_id];
		$itemlen = count($spec_item_ids);
		$itemids = array();
		$n = 0;

		while ($n < $itemlen) {
			$item_id = '';
			$get_item_id = $spec_item_ids[$n];
			$d = array('uniacid' => $_W['uniacid'], 'specid' => $spec_id, 'displayorder' => $n, 'title' => $spec_item_titles[$n], 'show' => $spec_item_shows[$n], 'thumb' => save_media($spec_item_thumbs[$n]), 'virtual' => ($data['type'] == 3 ? $spec_item_virtuals[$n] : 0));
			$f = 'spec_item_thumb_' . $get_item_id;

			if (is_numeric($get_item_id)) {
				pdo_update('ewei_shop_goods_spec_item', $d, array('id' => $get_item_id));
				$item_id = $get_item_id;
			}
			 else {
				pdo_insert('ewei_shop_goods_spec_item', $d);
				$item_id = pdo_insertid();
			}

			$itemids[] = $item_id;
			$d['get_id'] = $get_item_id;
			$d['id'] = $item_id;
			$spec_items[] = $d;
			++$n;
		}

		if (0 < count($itemids)) {
			pdo_query('delete from ' . tablename('ewei_shop_goods_spec_item') . ' where uniacid=' . $_W['uniacid'] . ' and specid=' . $spec_id . ' and id not in (' . implode(',', $itemids) . ')');
		}
		 else {
			pdo_query('delete from ' . tablename('ewei_shop_goods_spec_item') . ' where uniacid=' . $_W['uniacid'] . ' and specid=' . $spec_id);
		}

		pdo_update('ewei_shop_goods_spec', array('content' => serialize($itemids)), array('id' => $spec_id));
		$specids[] = $spec_id;
		++$k;
	}

	if (0 < count($specids)) {
		pdo_query('delete from ' . tablename('ewei_shop_goods_spec') . ' where uniacid=' . $_W['uniacid'] . ' and goodsid=' . $id . ' and id not in (' . implode(',', $specids) . ')');
	}
	 else {
		pdo_query('delete from ' . tablename('ewei_shop_goods_spec') . ' where uniacid=' . $_W['uniacid'] . ' and goodsid=' . $id);
	}

	$optionArray = json_decode($_POST['optionArray'], true);
	$isdiscountDiscountsArray = json_decode($_POST['isdiscountDiscountsArray'], true);
	$discountArray = json_decode($_POST['discountArray'], true);
	$commissionArrayPost = json_decode($_POST['commissionArray'], true);
	$option_idss = $optionArray['option_ids'];
	$len = count($option_idss);
	$optionids = array();
	$levelArray = array();
	$isDiscountsArray = array();
	$commissionArray = array();
	$commissionDefaultArray = array();
	$k = 0;

	while ($k < $len) {
		$option_id = '';
		$ids = $option_idss[$k];
		$get_option_id = $optionArray['option_id'][$k];
		$idsarr = explode('_', $ids);
		$newids = array();

		foreach ($idsarr as $key => $ida ) {
			foreach ($spec_items as $it ) {
				while ($it['get_id'] == $ida) {
					$newids[] = $it['id'];
					break;
				}
			}
		}

		$newids = implode('_', $newids);
		$a = array('uniacid' => $_W['uniacid'], 'title' => $optionArray['option_title'][$k], 'productprice' => $optionArray['option_productprice'][$k], 'costprice' => $optionArray['option_costprice'][$k], 'marketprice' => $optionArray['option_marketprice'][$k], 'presellprice' => $optionArray['option_presellprice'][$k], 'stock' => $optionArray['option_stock'][$k], 'weight' => $optionArray['option_weight'][$k], 'goodssn' => $optionArray['option_goodssn'][$k], 'productsn' => $optionArray['option_productsn'][$k], 'goodsid' => $id, 'specs' => $newids, 'virtual' => ($data['type'] == 3 ? $optionArray['option_virtual'][$k] : 0));

		if ($goodstype == 4) {
			$a['presellprice'] = 0;
			$a['productprice'] = 0;
			$a['costprice'] = 0;
			$a['marketprice'] = floatval($_GPC['intervalprice1']);
		}


		$totalstocks += $a['stock'];

		if (empty($get_option_id)) {
			pdo_insert('ewei_shop_goods_option', $a);
			$option_id = pdo_insertid();
		}
		 else {
			pdo_update('ewei_shop_goods_option', $a, array('id' => $get_option_id));
			$option_id = $get_option_id;
		}

		$optionids[] = $option_id;

		foreach ($levels as $level ) {
			$levelArray[$level['key']]['option' . $option_id] = $discountArray['discount_' . $level['key']][$k];
			$isDiscountsArray[$level['key']]['option' . $option_id] = $isdiscountDiscountsArray['isdiscount_discounts_' . $level['key']][$k];
		}

		foreach ($commission_level as $level ) {
			if ($level['key'] == 'default') {
				$commissionArray[$level['key']]['option' . $option_id] = $commissionArrayPost['commission']['commission_level_' . $level['key'] . '_' . $ids];
			}
			 else {
				$commissionArray[$level['key']]['option' . $option_id] = $commissionArrayPost['commission']['commission_level_' . $level['id'] . '_' . $ids];
			}
		}

		++$k;
	}

	if (((int) $_GPC['discounts']['type'] == 1) && $data['hasoption']) {
		$discounts_arr = array('type' => (int) $_GPC['discounts']['type']);
		$discounts_arr = array_merge($discounts_arr, $levelArray);
		$discounts_json = json_encode($discounts_arr);
	}
	 else {
		$discounts_json = ((is_array($_GPC['discounts']) ? json_encode($_GPC['discounts']) : json_encode(array())));
	}

	pdo_update('ewei_shop_goods', array('discounts' => $discounts_json), array('id' => $id));
	$has_merch = 0;
	$old_isdiscount_discounts = json_decode($item['isdiscount_discounts'], true);

	if (!(empty($old_isdiscount_discounts['merch']))) {
		$has_merch = 1;
	}


	if (!(empty($isDiscountsArray)) && $data['hasoption']) {
		$is_discounts_arr = array_merge(array('type' => 1), $isDiscountsArray);

		if ($has_merch == 1) {
			$is_discounts_arr['merch'] = $old_isdiscount_discounts['merch'];
		}


		$is_discounts_json = json_encode($is_discounts_arr);
	}
	 else {
		foreach ($levels as $level ) {
			if ($level['key'] == 'default') {
				$isDiscountsDefaultArray[$level['key']]['option0'] = $_GPC['isdiscount_discounts_level_' . $level['key'] . '_default'];
			}
			 else {
				$isDiscountsDefaultArray[$level['key']]['option0'] = $_GPC['isdiscount_discounts_level_' . $level['id'] . '_default'];
			}
		}

		$is_discounts_arr = array_merge(array('type' => 0), $isDiscountsDefaultArray);

		if ($has_merch == 1) {
			$is_discounts_arr['merch'] = $old_isdiscount_discounts['merch'];
		}


		$is_discounts_json = ((is_array($is_discounts_arr) ? json_encode($is_discounts_arr) : json_encode(array())));
	}

	pdo_update('ewei_shop_goods', array('isdiscount_discounts' => $is_discounts_json), array('id' => $id));

	if (!(empty($commissionArray)) && $data['hasoption']) {
		$commissionArray = array_merge(array('type' => (int) $_GPC['commission_type']), $commissionArray);
		$commission_arr = array('commission' => (is_array($commissionArray) ? json_encode($commissionArray) : json_encode(array())));
	}
	 else {
		foreach ($commission_level as $level ) {
			if ($level['key'] == 'default') {
				if (!(empty($_GPC['commission_level_' . $level['key'] . '_default']))) {
					foreach ($_GPC['commission_level_' . $level['key'] . '_default'] as $key => $value ) {
						$commissionDefaultArray[$level['key']]['option0'][] = $value;
					}
				}

			}
			 else if (!(empty($_GPC['commission_level_' . $level['id'] . '_default']))) {
				foreach ($_GPC['commission_level_' . $level['id'] . '_default'] as $key => $value ) {
					$commissionDefaultArray[$level['key']]['option0'][] = $value;
				}
			}

		}

		$commissionDefaultArray = array_merge(array('type' => (int) $_GPC['commission_type']), $commissionDefaultArray);
		$commission_arr = array('commission' => (is_array($commissionDefaultArray) ? json_encode($commissionDefaultArray) : json_encode(array())));
	}

	pdo_update('ewei_shop_goods', $commission_arr, array('id' => $id));

	if ((0 < count($optionids)) && ($data['hasoption'] !== 0)) {
		pdo_query('delete from ' . tablename('ewei_shop_goods_option') . ' where goodsid=' . $id . ' and id not in ( ' . implode(',', $optionids) . ')');
		$sql = 'update ' . tablename('ewei_shop_goods') . ' g set' . "\r\n" . '            g.minprice = (select min(marketprice) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $id . '),' . "\r\n" . '            g.maxprice = (select max(marketprice) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $id . ')' . "\r\n" . '            where g.id = ' . $id . ' and g.hasoption=1';
		pdo_query($sql);
	}
	 else {
		pdo_query('delete from ' . tablename('ewei_shop_goods_option') . ' where goodsid=' . $id);
		$sql = 'update ' . tablename('ewei_shop_goods') . ' set minprice = marketprice,maxprice = marketprice where id = ' . $id . ' and hasoption=0;';
		pdo_query($sql);
	}

	$sqlgoods = 'SELECT id,title,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,total,description,merchsale FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1';
	$goodsinfo = pdo_fetch($sqlgoods, array(':id' => $id, ':uniacid' => $_W['uniacid']));
	$goodsinfo = m('goods')->getOneMinPrice($goodsinfo);
	pdo_update('ewei_shop_goods', array('minprice' => $goodsinfo['minprice'], 'maxprice' => $goodsinfo['maxprice']), array('id' => $id, 'uniacid' => $_W['uniacid']));

	if (($data['type'] == 3) && $com_virtual) {
		$com_virtual->updateGoodsStock($id);
	}
	 else if (($data['hasoption'] !== 0) && ($data['totalcnf'] != 2) && empty($data['unite_total'])) {
		pdo_update('ewei_shop_goods', array('total' => $totalstocks), array('id' => $id));
	}


	show_json(1, array('url' => webUrl('goods/edit', array('id' => $id, 'tab' => str_replace('#tab_', '', $_GPC['tab'])))));
}


if (!(empty($id))) {
	if (empty($item)) {
		$this->message('抱歉，商品不存在或是已经删除！', '', 'error');
	}


	$noticetype = explode(',', $item['noticetype']);
	$cates = explode(',', $item['cates']);
	$commission = json_decode($item['commission'], true);

	if (isset($commission['type'])) {
		$commission_type = $commission['type'];
		unset($commission['type']);
	}


	$buyagain_commission = array();

	if (!(empty($item['buyagain_commission']))) {
		$buyagain_commission = json_decode($item['buyagain_commission'], true);
	}


	$discounts = json_decode($item['discounts'], true);
	$isdiscount_discounts = json_decode($item['isdiscount_discounts'], true);
	$allspecs = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:id order by displayorder asc', array(':id' => $id));

	foreach ($allspecs as &$s ) {
		$s['items'] = pdo_fetchall('select a.id,a.specid,a.title,a.thumb,a.show,a.displayorder,a.valueId,a.virtual,b.title as title2 from ' . tablename('ewei_shop_goods_spec_item') . ' a left join ' . tablename('ewei_shop_virtual_type') . ' b on b.id=a.virtual  where a.specid=:specid order by a.displayorder asc', array(':specid' => $s['id']));
	}

	unset($s);
	$params = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_param') . ' where goodsid=:id order by displayorder asc', array(':id' => $id));

	if (!(empty($item['thumb']))) {
		$piclist = array_merge(array($item['thumb']), iunserializer($item['thumb_url']));
	}


	$item['content'] = m('common')->html_to_images($item['content']);
	$html = '';
	$discounts_html = '';
	$commission_html = '';
	$isdiscount_discounts_html = '';
	$options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:id order by id asc', array(':id' => $id));
	$specs = array();

	if (0 < count($options)) {
		$specitemids = explode('_', $options[0]['specs']);

		foreach ($specitemids as $itemid ) {
			foreach ($allspecs as $ss ) {
				$items = $ss['items'];

				foreach ($items as $it ) {
					while ($it['id'] == $itemid) {
						$specs[] = $ss;
						break;
					}
				}
			}
		}

		$html = '';
		$html .= '<table class="table table-bordered table-condensed">';
		$html .= '<thead>';
		$html .= '<tr class="active">';
		$discounts_html .= '<table class="table table-bordered table-condensed">';
		$discounts_html .= '<thead>';
		$discounts_html .= '<tr class="active">';
		$commission_html .= '<table class="table table-bordered table-condensed">';
		$commission_html .= '<thead>';
		$commission_html .= '<tr class="active">';
		$isdiscount_discounts_html .= '<table class="table table-bordered table-condensed">';
		$isdiscount_discounts_html .= '<thead>';
		$isdiscount_discounts_html .= '<tr class="active">';
		$len = count($specs);
		$newlen = 1;
		$h = array();
		$rowspans = array();
		$i = 0;

		while ($i < $len) {
			$html .= '<th>' . $specs[$i]['title'] . '</th>';
			$discounts_html .= '<th>' . $specs[$i]['title'] . '</th>';
			$commission_html .= '<th>' . $specs[$i]['title'] . '</th>';
			$isdiscount_discounts_html .= '<th>' . $specs[$i]['title'] . '</th>';
			$itemlen = count($specs[$i]['items']);

			if ($itemlen <= 0) {
				$itemlen = 1;
			}


			$newlen *= $itemlen;
			$h = array();
			$j = 0;

			while ($j < $newlen) {
				$h[$i][$j] = array();
				++$j;
			}

			$l = count($specs[$i]['items']);
			$rowspans[$i] = 1;
			$j = $i + 1;

			while ($j < $len) {
				$rowspans[$i] *= count($specs[$j]['items']);
				++$j;
			}

			++$i;
		}

		$canedit = ce('goods', $item);

		if ($canedit) {
			foreach ($levels as $level ) {
				$discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div><div class="input-group"><input type="text" class="form-control  input-sm discount_' . $level['key'] . '_all" VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'discount_' . $level['key'] . '\');"></a></span></div></div></th>';
				$isdiscount_discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div><div class="input-group"><input type="text" class="form-control  input-sm isdiscount_discounts_' . $level['key'] . '_all" VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'isdiscount_discounts_' . $level['key'] . '\');"></a></span></div></div></th>';
			}

			foreach ($commission_level as $level ) {
				$commission_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
			}

			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">库存</div><div class="input-group"><input type="text" class="form-control input-sm option_stock_all"  VALUE=""/><span class="input-group-addon" ><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">预售价</div><div class="input-group"><input type="text" class="form-control  input-sm option_presell_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_presell\');"></a></span></div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">现价</div><div class="input-group"><input type="text" class="form-control  input-sm option_marketprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">原价</div><div class="input-group"><input type="text" class="form-control input-sm option_productprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">成本价</div><div class="input-group"><input type="text" class="form-control input-sm option_costprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">编码</div><div class="input-group"><input type="text" class="form-control input-sm option_goodssn_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_goodssn\');"></a></span></div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">条码</div><div class="input-group"><input type="text" class="form-control input-sm option_productsn_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_productsn\');"></a></span></div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">重量（克）</div><div class="input-group"><input type="text" class="form-control input-sm option_weight_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_weight\');"></a></span></div></div></th>';
		}
		 else {
			foreach ($levels as $level ) {
				$discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
				$isdiscount_discounts_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
			}

			foreach ($commission_level as $level ) {
				$commission_html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">' . $level['levelname'] . '</div></div></th>';
			}

			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">库存</div></div></th>';
			$html .= '<th"><div class=""><div style="padding-bottom:10px;text-align:center;">预售价格</div></div></th>';
			$html .= '<th"><div class=""><div style="padding-bottom:10px;text-align:center;">销售价格</div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">市场价格</div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">成本价格</div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">商品编码</div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">商品条码</div></div></th>';
			$html .= '<th><div class=""><div style="padding-bottom:10px;text-align:center;">重量（克）</div></th>';
		}

		$html .= '</tr></thead>';
		$discounts_html .= '</tr></thead>';
		$isdiscount_discounts_html .= '</tr></thead>';
		$commission_html .= '</tr></thead>';
		$m = 0;

		while ($m < $len) {
			$k = 0;
			$kid = 0;
			$n = 0;
			$j = 0;

			while ($j < $newlen) {
				$rowspan = $rowspans[$m];

				if (($j % $rowspan) == 0) {
					$h[$m][$j] = array('html' => '<td class=\'full\' rowspan=\'' . $rowspan . '\'>' . $specs[$m]['items'][$kid]['title'] . '</td>', 'id' => $specs[$m]['items'][$kid]['id']);
				}
				 else {
					$h[$m][$j] = array('html' => '', 'id' => $specs[$m]['items'][$kid]['id']);
				}

				++$n;

				if ($n == $rowspan) {
					++$kid;

					if ((count($specs[$m]['items']) - 1) < $kid) {
						$kid = 0;
					}


					$n = 0;
				}


				++$j;
			}

			++$m;
		}

		$hh = '';
		$dd = '';
		$isdd = '';
		$cc = '';
		$i = 0;

		while ($i < $newlen) {
			$hh .= '<tr>';
			$dd .= '<tr>';
			$isdd .= '<tr>';
			$cc .= '<tr>';
			$ids = array();
			$j = 0;

			while ($j < $len) {
				$hh .= $h[$j][$i]['html'];
				$dd .= $h[$j][$i]['html'];
				$isdd .= $h[$j][$i]['html'];
				$cc .= $h[$j][$i]['html'];
				$ids[] = $h[$j][$i]['id'];
				++$j;
			}

			$ids = implode('_', $ids);
			$val = array('id' => '', 'title' => '', 'stock' => '', 'presell' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');
			$discounts_val = array('id' => '', 'title' => '', 'level' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');
			$isdiscounts_val = array('id' => '', 'title' => '', 'level' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');
			$commission_val = array('id' => '', 'title' => '', 'level' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => '', 'virtual' => '');

			foreach ($levels as $level ) {
				$discounts_val[$level['key']] = '';
				$isdiscounts_val[$level['key']] = '';
			}

			foreach ($commission_level as $level ) {
				$commission_val[$level['key']] = '';
			}

			foreach ($options as $o ) {
				while ($ids === $o['specs']) {
					$val = array('id' => $o['id'], 'title' => $o['title'], 'stock' => $o['stock'], 'costprice' => $o['costprice'], 'productprice' => $o['productprice'], 'presell' => $o['presellprice'], 'marketprice' => $o['marketprice'], 'goodssn' => $o['goodssn'], 'productsn' => $o['productsn'], 'weight' => $o['weight'], 'virtual' => $o['virtual']);
					$discount_val = array('id' => $o['id']);

					foreach ($levels as $level ) {
						$discounts_val[$level['key']] = ((is_string($discounts[$level['key']]) ? '' : $discounts[$level['key']]['option' . $o['id']]));
						$isdiscounts_val[$level['key']] = ((is_string($isdiscount_discounts[$level['key']]) ? '' : $isdiscount_discounts[$level['key']]['option' . $o['id']]));
					}

					$commission_val = array();

					foreach ($commission_level as $level ) {
						$temp = ((is_string($commission[$level['key']]) ? '' : $commission[$level['key']]['option' . $o['id']]));

						if (is_array($temp)) {
							foreach ($temp as $t_val ) {
								$commission_val[$level['key']][] = $t_val;
							}
						}

					}

					unset($temp);
					break;
				}
			}

			if ($canedit) {
				foreach ($levels as $level ) {
					$dd .= '<td>';
					$isdd .= '<td>';

					if ($level['key'] == 'default') {
						$dd .= '<input data-name="discount_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control discount_' . $level['key'] . ' discount_' . $level['key'] . '_' . $ids . '" value="' . $discounts_val[$level['key']] . '"/> ';
						$isdd .= '<input data-name="isdiscount_discounts_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control isdiscount_discounts_' . $level['key'] . ' isdiscount_discounts_' . $level['key'] . '_' . $ids . '" value="' . $isdiscounts_val[$level['key']] . '"/> ';
					}
					 else {
						$dd .= '<input data-name="discount_level_' . $level['id'] . '_' . $ids . '"  type="text" class="form-control discount_level' . $level['id'] . ' discount_level' . $level['id'] . '_' . $ids . '" value="' . $discounts_val['level' . $level['id']] . '"/> ';
						$isdd .= '<input data-name="isdiscount_discounts_level_' . $level['id'] . '_' . $ids . '"  type="text" class="form-control isdiscount_discounts_level' . $level['id'] . ' isdiscount_discounts_level' . $level['id'] . '_' . $ids . '" value="' . $isdiscounts_val['level' . $level['id']] . '"/> ';
					}

					$dd .= '</td>';
					$isdd .= '</td>';
				}

				$dd .= '<input data-name="discount_id_' . $ids . '"  type="hidden" class="form-control discount_id discount_id_' . $ids . '" value="' . $discounts_val['id'] . '"/>';
				$dd .= '<input data-name="discount_ids"  type="hidden" class="form-control discount_ids discount_ids_' . $ids . '" value="' . $ids . '"/>';
				$dd .= '<input data-name="discount_title_' . $ids . '"  type="hidden" class="form-control discount_title discount_title_' . $ids . '" value="' . $discounts_val['title'] . '"/>';
				$dd .= '<input data-name="discount_virtual_' . $ids . '"  type="hidden" class="form-control discount_title discount_virtual_' . $ids . '" value="' . $discounts_val['virtual'] . '"/>';
				$dd .= '</tr>';
				$isdd .= '<input data-name="isdiscount_discounts_id_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_id isdiscount_discounts_id_' . $ids . '" value="' . $isdiscounts_val['id'] . '"/>';
				$isdd .= '<input data-name="isdiscount_discounts_ids"  type="hidden" class="form-control isdiscount_discounts_ids isdiscount_discounts_ids_' . $ids . '" value="' . $ids . '"/>';
				$isdd .= '<input data-name="isdiscount_discounts_title_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_title isdiscount_discounts_title_' . $ids . '" value="' . $isdiscounts_val['title'] . '"/>';
				$isdd .= '<input data-name="isdiscount_discounts_virtual_' . $ids . '"  type="hidden" class="form-control isdiscount_discounts_title isdiscount_discounts_virtual_' . $ids . '" value="' . $isdiscounts_val['virtual'] . '"/>';
				$isdd .= '</tr>';

				foreach ($commission_level as $level ) {
					$cc .= '<td>';

					if (!(empty($commission_val)) && isset($commission_val[$level['key']])) {
						foreach ($commission_val as $c_key => $c_val ) {
							if ($c_key == $level['key']) {
								if ($level['key'] == 'default') {
									$c_i = 0;

									while ($c_i < $shopset_level) {
										$cc .= '<input data-name="commission_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control commission_' . $level['key'] . ' commission_' . $level['key'] . '_' . $ids . '" value="' . $c_val[$c_i] . '" style="display:inline;width: ' . (96 / $shopset_level) . '%;"/> ';
										++$c_i;
									}
								}
								 else {
									$c_i = 0;

									while ($c_i < $shopset_level) {
										$cc .= '<input data-name="commission_level_' . $level['id'] . '_' . $ids . '"  type="text" class="form-control commission_level' . $level['id'] . ' commission_level' . $level['id'] . '_' . $ids . '" value="' . $c_val[$c_i] . '" style="display:inline;width: ' . (96 / $shopset_level) . '%;"/> ';
										++$c_i;
									}
								}
							}

						}
					}
					 else if ($level['key'] == 'default') {
						$c_i = 0;

						while ($c_i < $shopset_level) {
							$cc .= '<input data-name="commission_level_' . $level['key'] . '_' . $ids . '"  type="text" class="form-control commission_' . $level['key'] . ' commission_' . $level['key'] . '_' . $ids . '" value="" style="display:inline;width: ' . (96 / $shopset_level) . '%;"/> ';
							++$c_i;
						}
					}
					 else {
						$c_i = 0;

						while ($c_i < $shopset_level) {
							$cc .= '<input data-name="commission_level_' . $level['id'] . '_' . $ids . '"  type="text" class="form-control commission_level' . $level['id'] . ' commission_level' . $level['id'] . '_' . $ids . '" value="" style="display:inline;width: ' . (96 / $shopset_level) . '%;"/> ';
							++$c_i;
						}
					}

					$cc .= '</td>';
				}

				$cc .= '<input data-name="commission_id_' . $ids . '"  type="hidden" class="form-control commission_id commission_id_' . $ids . '" value="' . $commissions_val['id'] . '"/>';
				$cc .= '<input data-name="commission_ids"  type="hidden" class="form-control commission_ids commission_ids_' . $ids . '" value="' . $ids . '"/>';
				$cc .= '<input data-name="commission_title_' . $ids . '"  type="hidden" class="form-control commission_title commission_title_' . $ids . '" value="' . $commissions_val['title'] . '"/>';
				$cc .= '<input data-name="commission_virtual_' . $ids . '"  type="hidden" class="form-control commission_title commission_virtual_' . $ids . '" value="' . $commissions_val['virtual'] . '"/>';
				$cc .= '</tr>';
				$hh .= '<td>';
				$hh .= '<input data-name="option_stock_' . $ids . '"  type="text" class="form-control option_stock option_stock_' . $ids . '" value="' . $val['stock'] . '"/>';
				$hh .= '</td>';
				$hh .= '<input data-name="option_id_' . $ids . '"  type="hidden" class="form-control option_id option_id_' . $ids . '" value="' . $val['id'] . '"/>';
				$hh .= '<input data-name="option_ids"  type="hidden" class="form-control option_ids option_ids_' . $ids . '" value="' . $ids . '"/>';
				$hh .= '<input data-name="option_title_' . $ids . '"  type="hidden" class="form-control option_title option_title_' . $ids . '" value="' . $val['title'] . '"/>';
				$hh .= '<input data-name="option_virtual_' . $ids . '"  type="hidden" class="form-control option_virtual option_virtual_' . $ids . '" value="' . $val['virtual'] . '"/>';
				$hh .= '<td><input data-name="option_presell_' . $ids . '" type="text" class="form-control option_presell option_presell_' . $ids . '" value="' . $val['presell'] . '"/></td>';
				$hh .= '<td><input data-name="option_marketprice_' . $ids . '" type="text" class="form-control option_marketprice option_marketprice_' . $ids . '" value="' . $val['marketprice'] . '"/></td>';
				$hh .= '<td><input data-name="option_productprice_' . $ids . '" type="text" class="form-control option_productprice option_productprice_' . $ids . '" " value="' . $val['productprice'] . '"/></td>';
				$hh .= '<td><input data-name="option_costprice_' . $ids . '" type="text" class="form-control option_costprice option_costprice_' . $ids . '" " value="' . $val['costprice'] . '"/></td>';
				$hh .= '<td><input data-name="option_goodssn_' . $ids . '" type="text" class="form-control option_goodssn option_goodssn_' . $ids . '" " value="' . $val['goodssn'] . '"/></td>';
				$hh .= '<td><input data-name="option_productsn_' . $ids . '" type="text" class="form-control option_productsn option_productsn_' . $ids . '" " value="' . $val['productsn'] . '"/></td>';
				$hh .= '<td><input data-name="option_weight_' . $ids . '" type="text" class="form-control option_weight option_weight_' . $ids . '" " value="' . $val['weight'] . '"/></td>';
				$hh .= '</tr>';
			}
			 else {
				$hh .= '<td>' . $val['stock'] . '</td>';
				$hh .= '<td>' . $val['presell'] . '</td>';
				$hh .= '<td>' . $val['marketprice'] . '</td>';
				$hh .= '<td>' . $val['productprice'] . '</td>';
				$hh .= '<td>' . $val['costprice'] . '</td>';
				$hh .= '<td>' . $val['goodssn'] . '</td>';
				$hh .= '<td>' . $val['productsn'] . '</td>';
				$hh .= '<td>' . $val['weight'] . '</td>';
				$hh .= '</tr>';
			}

			++$i;
		}

		$discounts_html .= $dd;
		$discounts_html .= '</table>';
		$isdiscount_discounts_html .= $isdd;
		$isdiscount_discounts_html .= '</table>';
		$html .= $hh;
		$html .= '</table>';
		$commission_html .= $cc;
		$commission_html .= '</table>';
	}


	if ($item['showlevels'] != '') {
		$item['showlevels'] = explode(',', $item['showlevels']);
	}


	if ($item['buylevels'] != '') {
		$item['buylevels'] = explode(',', $item['buylevels']);
	}


	if ($item['showgroups'] != '') {
		$item['showgroups'] = explode(',', $item['showgroups']);
	}


	if ($item['buygroups'] != '') {
		$item['buygroups'] = explode(',', $item['buygroups']);
	}


	if ($merchid == 0) {
		$stores = array();

		if (!(empty($item['storeids']))) {
			$stores = pdo_fetchall('select id,storename from ' . tablename('ewei_shop_store') . ' where id in (' . $item['storeids'] . ' ) and uniacid=' . $_W['uniacid']);
		}

	}


	if (!(empty($item['noticeopenid']))) {
		$salers = array();

		if (isset($item['noticeopenid'])) {
			if (!(empty($item['noticeopenid']))) {
				$openids = array();
				$strsopenids = explode(',', $item['noticeopenid']);

				foreach ($strsopenids as $openid ) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . ') and uniacid=' . $_W['uniacid']);
			}

		}

	}

}


$dispatch_data = pdo_fetchall('select * from ' . tablename('ewei_shop_dispatch') . ' where uniacid=:uniacid and merchid=:merchid and enabled=1 order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));

if (p('commission')) {
	$com_set = p('commission')->getSet();
}
if ($com_virtual) {
	$virtual_types = pdo_fetchall('select * from ' . tablename('ewei_shop_virtual_type') . ' where uniacid=:uniacid and merchid=:merchid and recycled = 0 order by id asc', array(':uniacid' => $_W['uniacid'], ':merchid' => $merchid));
}


if ($merchid == 0) {
	$details = pdo_fetchall('select detail_logo,detail_shopname,detail_btntext1, detail_btnurl1 ,detail_btntext2,detail_btnurl2,detail_totaltitle from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and detail_shopname<>\'\' group by detail_shopname', array(':uniacid' => $_W['uniacid']));

	foreach ($details as &$d ) {
		$d['detail_logo_url'] = tomedia($d['detail_logo']);
	}

	unset($d);
}


$areas = m('common')->getAreas();

if ($diyform) {
	$form_list = $diyform->getDiyformList();
	$dfields = iunserializer($item['diyfields']);
}


if (p('diypage')) {
	$detailPages = p('diypage')->getPageList('allpage', ' and type=5 ');
	$detailPages = $detailPages['list'];
}


include $this->template('goods/post');
exit();

?>