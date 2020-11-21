<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Picker_EweiShopV2Page extends PluginMobilePage
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
			$isliving = p('live')->isLiving($liveid);

			if (!$isliving) {
				$liveid = 0;
			}
		}

		$goods = pdo_fetch('select id,thumb,title,marketprice,total,maxbuy,minbuy,unit,hasoption,showtotal,diyformid,diyformtype,diyfields,isdiscount,presellprice,
                isdiscount_time,isdiscount_discounts,hascommission,nocommission,commission,commission1_rate,marketprice,commission1_pay,needfollow, followtip, followurl, `type`, isverify, maxprice, minprice, merchsale,ispresell,preselltimeend,unite_total,
                threen,preselltimestart,presellovertime,presellover,islive,liveprice,minliveprice,maxliveprice
                from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			show_json(0);
		}

		$threenprice = json_decode($goods['threen'], 1);
		$goods['thistime'] = time();
		$goods = set_medias($goods, 'thumb');

		if (!empty($liveid)) {
			$islive = p('live')->getLivePrice($goods, $liveid);

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

		$minprice = $goods['minprice'];
		$maxprice = $goods['maxprice'];

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
					$cycelData = explode(',', $v['cycelbuy_periodic']);
					$v['cycelbuy_day'] = $cycelData[0];
					$v['cycelbuy_num'] = $cycelData[1];
					$v['cycelbuy_nums'] = $cycelData[2];
				}

				unset($v);
			}
		}

		$goods['canAddCart'] = true;
		if ($goods['isverify'] == 2 || $goods['type'] == 2 || $goods['type'] == 3 || $goods['type'] == 20 || !empty($goods['cannotrefund'])) {
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

		$cycelbuy_sys = m('common')->getSysset('cycelbuy');
		$ahead_goods = intval($cycelbuy_sys['ahead_goods']);

		if (empty($ahead_goods)) {
			$ahead_goods = 3;
		}

		$clevel = $this->getLevel($_W['openid']);
		$set = m('common')->getPluginset('commission');

		if ($clevel == 'false') {
			$seecommission = 0;
			$goods['cansee'] = 0;
		}
		else {
			if ($goods['nocommission'] == 1) {
				$seecommission = 0;
			}
			else if ($goods['hascommission'] == 1) {
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
					}
					else {
						foreach ($goods_commission[$levelid] as $key => $value) {
							foreach ($options as $k => $v) {
								if ('option' . $v['id'] == $key) {
									if (strexists($value[0], '%')) {
										$options[$k]['seecommission'] = floatval(str_replace('%', '', $value[0]) / 100) * $price;
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
			else {
				if ($goods['hasoption'] == 1 && $goods['hascommission'] == 0 && $goods['nocommission'] == 0) {
					foreach ($options as $ke => $vl) {
						if ($level != 'false') {
							$options[$ke]['seecommission'] = 1 <= $set['level'] ? round($clevel['commission1'] * $vl['marketprice'] / 100, 2) : 0;
						}
						else {
							$options[$ke]['seecommission'] = 1 <= $set['level'] ? round($set['commission1'] * $vl['marketprice'] / 100, 2) : 0;
						}
					}
				}
				else {
					if ($clevel != 'false' && !empty($clevel)) {
						$seecommission = 1 <= $set['level'] ? round($clevel['commission1'] * $goods['marketprice'] / 100, 2) : 0;
					}
					else {
						$seecommission = 1 <= $set['level'] ? round($set['commission1'] * $goods['marketprice'] / 100, 2) : 0;
					}
				}
			}

			if (p('commission')) {
				$goods['cansee'] = 0;
				$goods['cansee'] = '';
			}
			else {
				$goods['cansee'] = $set['seetitle'];
				$goods['seetitle'] = $set['seetitle'];
			}
		}

		show_json(1, array('goods' => $goods, 'seckillinfo' => $seckillinfo, 'specs' => $specs, 'options' => $options, 'diyformhtml' => $diyformhtml, 'cremind' => $cremind, 'cremindformhtml' => $cremindformhtml, 'ahead_goods' => $ahead_goods));
	}

	public function getLevel($openid)
	{
		global $_W;
		$clevel = 'false';

		if (empty($openid)) {
			return $clevel;
		}

		$member = m('member')->getMember($openid);
		if (empty($member['isagent']) || $member['status'] == 0 || $member['agentblack'] == 1) {
			return $clevel;
		}

		$clevel = pdo_fetch('select * from ' . tablename('ewei_shop_commission_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $member['agentlevel']));
		return $clevel;
	}
}

?>
