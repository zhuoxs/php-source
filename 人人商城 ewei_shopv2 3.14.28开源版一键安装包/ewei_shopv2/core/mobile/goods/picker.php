<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Picker_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$action = trim($_GPC['action']);
		$rank = intval($_SESSION[$id . '_rank']);
		$log_id = intval($_SESSION[$id . '_log_id']);
		$join_id = intval($_SESSION[$id . '_join_id']);
		$cremind = false;
		$seckillinfo = false;
		$seckill = p('seckill');

		if ($seckill) {
			$time = time();
			$seckillinfo = $seckill->getSeckill($id);

			if (!empty($seckillinfo)) {
				if ($seckillinfo['starttime'] <= $time && $time < $seckillinfo['endtime']) {
					$seckillinfo['status'] = 0;
				}
				else if ($time < $seckillinfo['starttime']) {
					$seckillinfo['status'] = 1;
				}
				else {
					$seckillinfo['status'] = -1;
				}
			}
		}

		$liveid = intval($_GPC['liveid']);

		if (!empty($liveid)) {
			$isliving = false;

			if (p('live')) {
				$isliving = p('live')->isLiving($liveid);
			}

			if (!$isliving) {
				$liveid = 0;
			}
		}

		$goods = pdo_fetch('select id,thumb,title,marketprice,total,maxbuy,minbuy,unit,hasoption,showtotal,diyformid,diyformtype,diyfields,isdiscount,presellprice,isdiscount_time,isdiscount_discounts,discounts,hascommission,nocommission,commission,commission1_rate,marketprice,commission1_pay,needfollow, followtip, followurl, `type`, isverify, maxprice, minprice, merchsale,ispresell,preselltimeend,unite_total,
                threen,preselltimestart,presellovertime,presellover,islive,liveprice,minliveprice,maxliveprice,isnodiscount
                from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			show_json(0);
		}

		$threenprice = json_decode($goods['threen'], 1);
		$goods['thistime'] = time();
		$goods = set_medias($goods, 'thumb');

		if (!empty($liveid)) {
			$islive = false;

			if (p('live')) {
				$islive = p('live')->getLivePrice($goods, $liveid);
			}

			if ($islive) {
				$goods['minprice'] = $islive['minprice'];
				$goods['maxprice'] = $islive['maxprice'];
			}
		}

		$openid = $_W['openid'];

		if (is_weixin()) {
			$follow = m('user')->followed($openid);
			if (!empty($goods['needfollow']) && !$follow) {
				$followtip = empty($goods['followtip']) ? '如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~' : $goods['followtip'];
				$followurl = empty($goods['followurl']) ? $_W['shopset']['share']['followurl'] : $goods['followurl'];
				show_json(2, array('followtip' => $followtip, 'followurl' => $followurl));
			}
		}

		$openid = $_W['openid'];
		$member = m('member')->getMember($openid);

		if (empty($openid)) {
			$sendtime = $_SESSION['verifycodesendtime'];
			if (empty($sendtime) || $sendtime + 60 < time()) {
				$endtime = 0;
			}
			else {
				$endtime = 60 - (time() - $sendtime);
			}

			show_json(4, array('endtime' => $endtime, 'imgcode' => $_W['shopset']['wap']['smsimgcode']));
		}

		if (!empty($_W['shopset']['wap']['open']) && !empty($_W['shopset']['wap']['mustbind']) && empty($member['mobileverify'])) {
			$sendtime = $_SESSION['verifycodesendtime'];
			if (empty($sendtime) || $sendtime + 60 < time()) {
				$endtime = 0;
			}
			else {
				$endtime = 60 - (time() - $sendtime);
			}

			show_json(3, array('endtime' => $endtime, 'imgcode' => $_W['shopset']['wap']['smsimgcode']));
		}

		if (0 < $goods['ispresell']) {
			$times = $goods['presellovertime'] * 60 * 60 * 24 + $goods['preselltimeend'];
			if (!(0 < $goods['presellover'] && $times <= time())) {
				if (0 < $goods['preselltimestart'] && time() < $goods['preselltimestart']) {
					show_json(5, '预售未开始');
				}

				if (0 < $goods['preselltimeend'] && $goods['preselltimeend'] < time()) {
					show_json(5, '预售已结束');
				}
			}
		}

		if ($goods['isdiscount'] && time() <= $goods['isdiscount_time']) {
			$isdiscount = true;
			$isdiscount_discounts = json_decode($goods['isdiscount_discounts'], true);
			$levelid = $member['level'];
			$key = empty($levelid) ? 'default' : 'level' . $levelid;
		}
		else {
			$isdiscount = false;
		}

		$task_goods_data = m('goods')->getTaskGoods($openid, $id, $rank, $log_id, $join_id);

		if (empty($task_goods_data['is_task_goods'])) {
			$is_task_goods = 0;
		}
		else {
			$is_task_goods = $task_goods_data['is_task_goods'];
			$is_task_goods_option = $task_goods_data['is_task_goods_option'];
			$task_goods = $task_goods_data['task_goods'];
		}

		$specs = false;
		$options = false;
		if (!empty($goods) && $goods['hasoption']) {
			$specs = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));

			foreach ($specs as &$spec) {
				$spec['items'] = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_spec_item') . ' where specid=:specid and `show`=1 order by displayorder asc', array(':specid' => $spec['id']));
			}

			unset($spec);
			$options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));
		}

		if (!empty($options) && !empty($goods['unite_total'])) {
			foreach ($options as &$option) {
				$option['stock'] = $goods['total'];
			}

			unset($option);
		}

		if (!empty($liveid) && !empty($options)) {
			if (p('live')) {
				$options = p('live')->getLiveOptions($goods['id'], $liveid, $options);
			}

			$prices = array();

			foreach ($options as $option) {
				$prices[] = price_format($option['marketprice']);
			}

			unset($option);
			$goods['minprice'] = min($prices);
			$goods['maxprice'] = max($prices);
		}

		if ($seckillinfo && $seckillinfo['status'] == 0) {
			$minprice = $maxprice = $goods['marketprice'] = $seckillinfo['price'];
			if (0 < count($seckillinfo['options']) && !empty($options)) {
				foreach ($options as &$option) {
					foreach ($seckillinfo['options'] as $so) {
						if ($option['id'] == $so['optionid']) {
							$option['marketprice'] = $so['price'];
						}
					}
				}

				unset($option);
			}
		}
		else {
			$minprice = $goods['minprice'];
			$maxprice = $goods['maxprice'];
		}

		if (!empty($is_task_goods)) {
			if (isset($options) && 0 < count($options) && $goods['hasoption']) {
				$prices = array();

				foreach ($task_goods['spec'] as $k => $v) {
					$prices[] = $v['marketprice'];
				}

				$minprice = min($prices);
				$maxprice = max($prices);

				foreach ($options as $k => $v) {
					$option_id = $v['id'];

					if (array_key_exists($option_id, $task_goods['spec'])) {
						if (0 < $goods['ispresell'] && ($goods['preselltimeend'] == 0 || time() < $goods['preselltimeend'])) {
							$options[$k]['marketprice'] = $task_goods['spec'][$option_id]['presellprice'];
						}
						else {
							$options[$k]['marketprice'] = $task_goods['spec'][$option_id]['marketprice'];
						}

						$options[$k]['stock'] = $task_goods['spec'][$option_id]['total'];
					}

					$prices[] = $v['marketprice'];
				}
			}
			else {
				$minprice = $task_goods['marketprice'];
				$maxprice = $task_goods['marketprice'];
			}
		}
		else {
			if ($goods['isdiscount'] && time() <= $goods['isdiscount_time']) {
				$goods['oldmaxprice'] = $maxprice;
				$isdiscount_discounts = json_decode($goods['isdiscount_discounts'], true);
				$prices = array();
				if (!isset($isdiscount_discounts['type']) || empty($isdiscount_discounts['type'])) {
					$level = m('member')->getLevel($openid);
					$prices_array = m('order')->getGoodsDiscountPrice($goods, $level, 1);
					$prices[] = $prices_array['price'];
				}
				else {
					$goods_discounts = m('order')->getGoodsDiscounts($goods, $isdiscount_discounts, $levelid, $options);
					$prices = $goods_discounts['prices'];
					$options = $goods_discounts['options'];
				}

				$minprice = min($prices);
				$maxprice = max($prices);
			}
		}

		if ($goods['isnodiscount'] == 0) {
			$member_levelid = intval($member['level']);

			if (!empty($member_levelid)) {
				$member_level = pdo_fetch('select * from ' . tablename('ewei_shop_member_level') . ' where id=:id and uniacid=:uniacid and enabled=1 limit 1', array(':id' => $member_levelid, ':uniacid' => $_W['uniacid']));
				$member_level = empty($member_level) ? array() : $member_level;
			}

			$discounts = json_decode($goods['discounts'], true);

			if (is_array($discounts)) {
				$key = !empty($member_level['id']) ? 'level' . $member_level['id'] : 'default';
				if (!isset($discounts['type']) || empty($discounts['type'])) {
					$memberprice_dis = 0;

					if (!empty($discounts[$key])) {
						$dd = floatval($discounts[$key]);
						if (0 < $dd && $dd < 10) {
							$memberprice_dis = round($dd / 10 * $goods['minprice'], 2);
						}
					}
					else {
						$dd = floatval($discounts[$key . '_pay']);
						$md = floatval($member_level['discount']);

						if (!empty($dd)) {
							$memberprice_dis = round($dd, 2);
						}
						else {
							if (0 < $md && $md < 10) {
								$memberprice_dis = round($md / 10 * $goods['minprice'], 2);
							}
						}
					}

					$goods['show'] = 0;
					$goods['member_discount'] = number_format($memberprice_dis, 2, '.', '');
				}

				if ($goods['hasoption'] == 1 & $discounts['type'] == 1) {
					$options = m('goods')->getOptions($goods);

					foreach ($options as &$option) {
						$discount = trim($discounts[$key]['option' . $option['id']]);

						if ($discount == '') {
							$discount = round(floatval($member_level['discount']) * 10, 2) . '%';
						}

						if (!empty($discount)) {
							if (strexists($discount, '%')) {
								$dd = floatval(str_replace('%', '', $discount));
								if (0 < $dd && $dd < 100) {
									$price = round($dd / 100 * $option['marketprice'], 2);
								}
							}
							else {
								if (0 < floatval($discount)) {
									$price = round(floatval($discount), 2);
								}
							}
						}

						if (0 < $price) {
							$option['member_discount'] = number_format($price, 2, '.', '');
						}
						else {
							$option['member_discount'] = 0;
						}
					}

					unset($goods['member_discount']);
					$goods['show'] = 1;
					unset($option);
				}
				else {
					if ($goods['hasoption'] == 1 & $discounts['type'] == 0) {
						$options = m('goods')->getOptions($goods);

						foreach ($options as &$option) {
							if (!empty($discounts[$key])) {
								$dd = floatval($discounts[$key]);
								if (0 < $dd && $dd < 10) {
									$memberprice = round($dd / 10 * $option['marketprice'], 2);
								}
							}
							else {
								$dd = floatval($discounts[$key . '_pay']);
								$md = floatval($member_level['discount']);

								if (!empty($dd)) {
									$memberprice = round($dd, 2);
								}
								else {
									if (0 < $md && $md < 10) {
										$memberprice = round($md / 10 * $option['marketprice'], 2);
									}
								}
							}

							if (0 < $memberprice) {
								$option['member_discount'] = number_format($memberprice, 2, '.', '');
							}
							else {
								$option['member_discount'] = 0;
							}
						}

						unset($option);
						unset($goods['member_discount']);
						$goods['show'] = 1;
					}
				}
			}
		}

		$clevel = $this->getcLevel($_W['openid']);
		$set = array();

		if (p('commission')) {
			$set = $this->getSet();
			$goods['cansee'] = $set['cansee'];
			$goods['seetitle'] = $set['seetitle'];
		}
		else {
			$goods['cansee'] = 0;
			$goods['seetitle'] = '';
		}

		if (p('seckill')) {
			if (!p('seckill')->getSeckill($goods['id'])) {
				if ($goods['nocommission'] == 1) {
					$seecommission = 0;
				}
				else {
					if ($goods['hascommission'] == 1 && $goods['nocommission'] == 0) {
						$price = $goods['maxprice'];
						$levelid = 'default';

						if ($clevel == 'false') {
							$seecommission = 0;
						}
						else {
							if ($clevel) {
								$levelid = 'level' . $clevel['id'];
							}

							$goods_commission = !empty($goods['commission']) ? json_decode($goods['commission'], true) : array();

							if ($goods_commission['type'] == 0) {
								$seecommission = 1 <= $set['level'] ? (0 < $goods['commission1_rate'] ? $goods['commission1_rate'] * $goods['marketprice'] / 100 : $goods['commission1_pay']) : 0;
								if (is_array($options) && !empty($options)) {
									foreach ($options as $k => $v) {
										$seecommission = 1 <= $set['level'] ? (0 < $goods['commission1_rate'] ? $goods['commission1_rate'] * $v['marketprice'] / 100 : $v['commission1_pay']) : 0;
										$options[$k]['seecommission'] = $seecommission;
									}
								}
							}
							else {
								if (is_array($options)) {
									foreach ($goods_commission[$levelid] as $key => $value) {
										foreach ($options as $k => $v) {
											if ('option' . $v['id'] == $key) {
												if (strexists($value[0], '%')) {
													$options[$k]['seecommission'] = floatval(str_replace('%', '', $value[0]) / 100) * $v['marketprice'];
													continue;
												}

												$options[$k]['seecommission'] = $value[0];
												continue;
											}
										}
									}
								}
							}
						}
					}
					else {
						if ($goods['hasoption'] == 1 && $goods['hascommission'] == 0 && $goods['nocommission'] == 0) {
							foreach ($options as $ke => $vl) {
								if ($clevel != 'false' && $clevel) {
									$options[$ke]['seecommission'] = 1 <= $set['level'] ? round($clevel['commission1'] * $vl['marketprice'] / 100, 2) : 0;
								}
								else {
									$options[$ke]['seecommission'] = 1 <= $set['level'] ? round($set['commission1'] * $vl['marketprice'] / 100, 2) : 0;
								}
							}
						}
						else {
							if ($clevel != 'false' && $clevel) {
								$seecommission = 1 <= $set['level'] ? round($clevel['commission1'] * $goods['marketprice'] / 100, 2) : 0;
							}
							else {
								$seecommission = 1 <= $set['level'] ? round($set['commission1'] * $goods['marketprice'] / 100, 2) : 0;
							}
						}
					}
				}
			}
		}

		if (0 < $goods['ispresell'] && ($goods['preselltimeend'] == 0 || time() < $goods['preselltimeend'])) {
			$presell = pdo_fetch('select min(presellprice) as minprice,max(presellprice) as maxprice from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $id);
			$minprice = $presell['minprice'];
			$maxprice = $presell['maxprice'];
		}

		$goods['minprice'] = number_format($minprice, 2);
		$goods['maxprice'] = number_format($maxprice, 2);
		$diyformhtml = '';

		if ($action == 'cremind') {
			$cremind_plugin = p('cremind');
			$cremind_data = m('common')->getPluginset('cremind');
			if ($cremind_plugin && $cremind_data['remindopen']) {
				$cremind = true;
			}

			ob_start();
			include $this->template('cremind/formfields');
			$cremindformhtml = ob_get_contents();
			ob_clean();
		}
		else {
			$diyform_plugin = p('diyform');

			if ($diyform_plugin) {
				$fields = false;

				if ($goods['diyformtype'] == 1) {
					if (!empty($goods['diyformid'])) {
						$diyformid = $goods['diyformid'];
						$formInfo = $diyform_plugin->getDiyformInfo($diyformid);
						$fields = $formInfo['fields'];
					}
				}
				else {
					if ($goods['diyformtype'] == 2) {
						$diyformid = 0;
						$fields = iunserializer($goods['diyfields']);

						if (empty($fields)) {
							$fields = false;
						}
					}
				}

				if (!empty($fields)) {
					ob_start();
					$inPicker = true;
					$openid = $_W['openid'];
					$member = m('member')->getMember($openid, true);
					$f_data = $diyform_plugin->getLastData(3, 0, $diyformid, $id, $fields, $member);
					$flag = 0;

					if (!empty($f_data)) {
						foreach ($f_data as $k => $v) {
							if (!empty($v)) {
								$flag = 1;
								break;
							}
						}
					}

					if (empty($flag)) {
						$f_data = $diyform_plugin->getLastCartData($id);
					}

					$area_set = m('util')->get_area_config_set();
					$new_area = intval($area_set['new_area']);
					$address_street = intval($area_set['address_street']);
					include $this->template('diyform/formfields');
					$diyformhtml = ob_get_contents();
					ob_clean();
				}
			}
		}

		if (!empty($specs)) {
			foreach ($specs as $key => $value) {
				foreach ($specs[$key]['items'] as $k => &$v) {
					$v['thumb'] = tomedia($v['thumb']);
				}
			}
		}

		$goods['canAddCart'] = true;
		if ($goods['isverify'] == 2 || $goods['type'] == 2 || $goods['type'] == 3 || $goods['type'] == 20 || !empty($goods['cannotrefund'])) {
			$goods['canAddCart'] = false;
		}

		if (!empty($seckillinfo)) {
			$goods['canAddCart'] = false;
		}

		if (p('task')) {
			$task_id = intval($_SESSION[$id . '_task_id']);

			if (!empty($task_id)) {
				$rewarded = pdo_fetchcolumn('SELECT `rewarded` FROM ' . tablename('ewei_shop_task_extension_join') . ' WHERE id = :id AND uniacid = :uniacid', array(':id' => $task_id, ':uniacid' => $_W['uniacid']));
				$taskGoodsInfo = unserialize($rewarded);
				$taskGoodsInfo = $taskGoodsInfo['goods'][$id];

				if (empty($taskGoodsInfo['option'])) {
					$goods['marketprice'] = $taskGoodsInfo['price'];
				}
				else {
					foreach ($options as $gk => $gv) {
						if ($options[$gk]['id'] == $taskGoodsInfo) {
							$options[$gk]['marketprice'] = $taskGoodsInfo['price'];
						}
					}
				}
			}
		}

		$sale_plugin = com('sale');
		$giftid = 0;
		$goods['cangift'] = false;
		$gifttitle = '';

		if ($sale_plugin) {
			$giftinfo = array();
			$isgift = 0;
			$gifts = array();
			$giftgoods = array();
			$gifts = pdo_fetchall('select id,goodsid,giftgoodsid,thumb,title from ' . tablename('ewei_shop_gift') . ' where uniacid = ' . $_W['uniacid'] . ' and activity = 2 and status = 1 and starttime <= ' . time() . ' and endtime >= ' . time() . '  ');

			foreach ($gifts as $key => &$value) {
				$gid = explode(',', $value['goodsid']);

				foreach ($gid as $ke => $val) {
					if ($val == $id) {
						$giftgoods = explode(',', $value['giftgoodsid']);

						foreach ($giftgoods as $k => $val) {
							$giftdata = pdo_fetch('select id,title,thumb,marketprice,total from ' . tablename('ewei_shop_goods') . ' where uniacid = ' . $_W['uniacid'] . ' and deleted = 0 and total > 0 and status = 2 and id = ' . $val . ' ');

							if (!empty($giftdata)) {
								$isgift = 1;
								$gifts[$key]['gift'][$k] = $giftdata;
								$gifts[$key]['gift'][$k]['thumb'] = tomedia($gifts[$key]['gift'][$k]['thumb']);
								$gifttitle = !empty($value['gift'][$k]['title']) ? $value['gift'][$k]['title'] : '赠品';
							}
						}
					}
				}

				if (empty($value['gift'])) {
					unset($gifts[$key]);
				}
			}

			if ($isgift) {
				if ($_GPC['cangift']) {
					$goods['cangift'] = true;
				}

				$gifts = array_values($gifts);
				$giftid = $gifts[0]['id'];
				$giftinfo = $gifts;
			}
		}

		$goods['giftid'] = $giftid;
		$goods['giftinfo'] = $giftinfo;
		$goods['gifttitle'] = $gifttitle;
		$goods['gifttotal'] = count($goods['giftinfo']);
		show_json(1, array('goods' => $goods, 'seckillinfo' => $seckillinfo, 'specs' => $specs, 'options' => $options, 'diyformhtml' => $diyformhtml, 'cremind' => $cremind, 'cremindformhtml' => $cremindformhtml));
	}

	public function getcLevel($openid)
	{
		global $_W;
		$level = 'false';

		if (empty($openid)) {
			return $level;
		}

		$member = m('member')->getMember($openid);
		if (empty($member['isagent']) || $member['status'] == 0 || $member['agentblack'] == 1) {
			return $level;
		}

		$level = pdo_fetch('select * from ' . tablename('ewei_shop_commission_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $member['agentlevel']));
		return $level;
	}

	public function getSet()
	{
		$set = m('common')->getPluginset('commission');
		$set['texts'] = array('agent' => empty($set['texts']['agent']) ? '分销商' : $set['texts']['agent'], 'shop' => empty($set['texts']['shop']) ? '小店' : $set['texts']['shop'], 'myshop' => empty($set['texts']['myshop']) ? '我的小店' : $set['texts']['myshop'], 'center' => empty($set['texts']['center']) ? '分销中心' : $set['texts']['center'], 'become' => empty($set['texts']['become']) ? '成为分销商' : $set['texts']['become'], 'withdraw' => empty($set['texts']['withdraw']) ? '提现' : $set['texts']['withdraw'], 'commission' => empty($set['texts']['commission']) ? '佣金' : $set['texts']['commission'], 'commission1' => empty($set['texts']['commission1']) ? '分销佣金' : $set['texts']['commission1'], 'commission_total' => empty($set['texts']['commission_total']) ? '累计佣金' : $set['texts']['commission_total'], 'commission_ok' => empty($set['texts']['commission_ok']) ? '可提现佣金' : $set['texts']['commission_ok'], 'commission_apply' => empty($set['texts']['commission_apply']) ? '已申请佣金' : $set['texts']['commission_apply'], 'commission_check' => empty($set['texts']['commission_check']) ? '待打款佣金' : $set['texts']['commission_check'], 'commission_lock' => empty($set['texts']['commission_lock']) ? '未结算佣金' : $set['texts']['commission_lock'], 'commission_detail' => empty($set['texts']['commission_detail']) ? '提现明细' : ($set['texts']['commission_detail'] == '佣金明细' ? '提现明细' : $set['texts']['commission_detail']), 'commission_pay' => empty($set['texts']['commission_pay']) ? '成功提现佣金' : $set['texts']['commission_pay'], 'commission_wait' => empty($set['texts']['commission_wait']) ? '待收货佣金' : $set['texts']['commission_wait'], 'commission_fail' => empty($set['texts']['commission_fail']) ? '无效佣金' : $set['texts']['commission_fail'], 'commission_charge' => empty($set['texts']['commission_charge']) ? '扣除提现手续费' : $set['texts']['commission_charge'], 'order' => empty($set['texts']['order']) ? '分销订单' : $set['texts']['order'], 'c1' => empty($set['texts']['c1']) ? '一级' : $set['texts']['c1'], 'c2' => empty($set['texts']['c2']) ? '二级' : $set['texts']['c2'], 'c3' => empty($set['texts']['c3']) ? '三级' : $set['texts']['c3'], 'mydown' => empty($set['texts']['mydown']) ? '我的下线' : $set['texts']['mydown'], 'down' => empty($set['texts']['down']) ? '下线' : $set['texts']['down'], 'up' => empty($set['texts']['up']) ? '推荐人' : $set['texts']['up'], 'yuan' => empty($set['texts']['yuan']) ? '元' : $set['texts']['yuan'], 'icode' => empty($set['texts']['icode']) ? '邀请码' : $set['texts']['icode']);
		return $set;
	}
}

?>
