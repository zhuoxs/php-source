<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

define('PAGE_MEMBER', 0);
class DiypageModel extends PluginModel
{
	private $plugin = array();
	private $ordernum = array();
	private $member = array();
	private $commission = array();

	/**
     * 获取页面列表
     * @param string $type
     * @param null $condition
     * @param int $page
     * @return array
     */
	public function getPageList($type = 'allpage', $condition = NULL, $page = 0)
	{
		global $_W;

		if ($type == 'diy') {
			$c = ' and type=1 ';
		}
		else if ($type == 'sys') {
			$c = ' and ((type>1 and type<4) or type=5 or type=9) ';
		}
		else if ($type == 'plu') {
			$c = ' and type>3 and type<99 and type!=5 and type!=9';
		}
		else if ($type == 'mod') {
			$c = ' and type=99 ';
		}
		else {
			if ($type == 'allpage') {
				$c = ' and type>0 and type<99 ';
			}
		}

		if (!empty($condition)) {
			$c .= $condition;
		}

		$pindex = max(1, $page);
		$psize = 20;

		if (0 < $page) {
			$limit = ' limit ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$list = pdo_fetchall('select id, `name`, `type`, createtime, lastedittime, keyword,`data` from ' . tablename('ewei_shop_diypage') . ' where merch=:merch ' . $c . ' and uniacid=:uniacid order by `type` desc, id desc ' . $limit, array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage') . ' where merch=:merch and uniacid=:uniacid ' . $c, array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$pager = pagination2($total, $pindex, $psize);

		if (!empty($list)) {
			$allpagetype = $this->getPageType();

			foreach ($list as $index => $item) {
				$type = $item['type'];
				$list[$index]['typename'] = $allpagetype[$type]['name'];
				$list[$index]['typeclass'] = $allpagetype[$type]['class'];
			}
		}

		return array('list' => $list, 'total' => $total, 'pager' => $pager);
	}

	/**
     * 获取页面
     * @param $id
     * @param bool $mobile
     * @return bool|void
     */
	public function getPage($id, $mobile = false)
	{
		global $_W;

		if (empty($id)) {
			return NULL;
		}

		$wapset = m('common')->getSysset('wap');
		$where = ' where id=:id and uniacid=:uniacid';
		$params = array(':id' => $id, ':uniacid' => $_W['uniacid']);

		if (!$mobile) {
			$where .= ' and merch=:merchid';
			$params[':merchid'] = intval($_W['merchid']);
		}

		$page = pdo_fetch('select * from ' . tablename('ewei_shop_diypage') . $where . ' limit 1 ', $params);

		if (!empty($page)) {
			$page['data'] = base64_decode($page['data']);

			if ($mobile) {
				$memberpage = $page['type'] == 3 ? true : false;
				$this->calculate($page['data'], $page['type']);
				$this->verifymobile($page['id'], $page['type']);
			}

			$page['data'] = json_decode($page['data'], true);

			if (empty($page['data']['page']['visitlevel'])) {
				$page['data']['page']['visitlevel'] = array(
					'member'     => array(),
					'commission' => array()
				);
			}

			if (empty($page['data']['page']['novisit'])) {
				$page['data']['page']['novisit'] = array(
					'title' => array(),
					'link'  => array()
				);
			}

			if (!empty($page['data']['items']) && is_array($page['data']['items'])) {
				foreach ($page['data']['items'] as $itemid => &$item) {
					if ($item['id'] == 'goods') {
						$creditshop = !empty($item['params']['goodstype']) ? true : false;

						if ($item['params']['goodsdata'] == '0') {
							if (!empty($item['data']) && is_array($item['data'])) {
								$goodsids = array();

								foreach ($item['data'] as $index => $data) {
									if (!empty($data['gid'])) {
										$goodsids[] = $data['gid'];
									}
								}

								if (!empty($goodsids) && is_array($goodsids)) {
									$commdata = $item['data'];
									$item['data'] = array();
									$newgoodsids = implode(',', $goodsids);

									if ($creditshop) {
										$goods = pdo_fetchall('select id, title, thumb, price as productprice, money as minprice, credit, total, showgroups, `type`, goodstype from ' . tablename('ewei_shop_creditshop_goods') . (' where id in( ' . $newgoodsids . ' ) and status=1 and deleted=0 and uniacid=:uniacid order by displayorder desc '), array(':uniacid' => $_W['uniacid']));
									}
									else {
										$goods = pdo_fetchall('select id,`presellend`,`preselltimeend`,isdiscount, isdiscount_time, title, subtitle, thumb, productprice, minprice, total,`type`,showlevels, showgroups,hascommission,nocommission,commission,commission1_rate,marketprice,commission1_pay,maxprice, bargain, merchid, sales, salesreal,ispresell,presellprice from ' . tablename('ewei_shop_goods') . (' where id in( ' . $newgoodsids . ' ) and status=1 and deleted=0 and checked=0 and uniacid=:uniacid order by displayorder desc '), array(':uniacid' => $_W['uniacid']));
										if (!empty($goods) && is_array($goods)) {
											foreach ($goods as $key => $value) {
												if ($value['ispresell'] == 1 && time() < $value['preselltimeend']) {
													$goods[$key]['minprice'] = $value['presellprice'];
												}
											}
										}
									}

									if (!empty($goods) && is_array($goods)) {
										$level = $this->getLevel($_W['openid']);
										$set = m('common')->getPluginset('commission');

										foreach ($goods as $key => $value) {
											if ($value['nocommission'] == 0) {
												if (p('seckill')) {
													if (p('seckill')->getSeckill($value['id'])) {
														continue;
													}
												}

												if (0 < $value['bargain']) {
													continue;
												}

												$goods[$key]['seecommission'] = $this->getCommission($value, $level, $set);

												if (0 < $goods[$key]['seecommission']) {
													$goods[$key]['seecommission'] = round($goods[$key]['seecommission'], 2);
												}

												$goods[$key]['cansee'] = $set['cansee'];
												$goods[$key]['seetitle'] = $set['seetitle'];
											}
											else {
												$goods[$key]['seecommission'] = 0;
												$goods[$key]['cansee'] = $set['cansee'];
												$goods[$key]['seetitle'] = $set['seetitle'];
											}
										}

										foreach ($goodsids as $goodsid) {
											foreach ($goods as $index => $good) {
												if ($good['id'] == $goodsid) {
													if ((empty($good['isdiscount']) || $good['isdiscount_time'] < time()) && !$creditshop) {
														if (isset($options) && 0 < count($options) && $good['hasoption']) {
															$optionids = array();

															foreach ($options as $val) {
																$optionids[] = $val['id'];
															}

															$sql = 'update ' . tablename('ewei_shop_goods') . ' g set
        g.minprice = (select min(marketprice) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $good['id'] . '),
        g.maxprice = (select max(marketprice) from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $good['id'] . ')
        where g.id = ' . $good['id'] . ' and g.hasoption=1';
															pdo_query($sql);
														}
														else {
															$sql = 'update ' . tablename('ewei_shop_goods') . ' set minprice = marketprice,maxprice = marketprice where id = ' . $good['id'] . ' and hasoption=0';
															pdo_query($sql);
														}

														$goods_price = pdo_fetch('select title,minprice,maxprice,ispresell,presellend,preselltimeend,presellprice from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $good['id'], ':uniacid' => $_W['uniacid']));

														if ($good['productprice'] < $goods_price['maxprice']) {
															$good['productprice'] = (double) $goods_price['maxprice'];
														}

														if ($goods_price['ispresell'] == 1 && time() < $goods_price['preselltimeend'] && $goods_price['presellend'] == 1 && $goods_price['presellprice'] < $goods_price['minprice']) {
															$good['minprice'] = (double) $goods_price['presellprice'];
														}
														else {
															$good['minprice'] = (double) $goods_price['minprice'];
														}
													}

													$childid = rand(1000000000, 9999999999);
													$childid = 'C' . $childid;
													$item['data'][$childid] = array('thumb' => $good['thumb'], 'title' => $good['title'], 'subtitle' => $good['subtitle'], 'price' => $good['minprice'], 'gid' => $good['id'], 'total' => $good['total'], 'bargain' => $good['bargain'], 'productprice' => $good['productprice'], 'credit' => $good['credit'], 'ctype' => $good['type'], 'gtype' => $good['goodstype'], 'seecommission' => $good['seecommission'], 'cansee' => $good['cansee'], 'seetitle' => $good['seetitle'], 'sales' => $good['sales'] + intval($good['salesreal']));
												}
											}
										}
									}
								}
							}
						}
						else if ($item['params']['goodsdata'] == '1') {
							if (!empty($item['params']['cateid'])) {
								if (empty($item['params']['goodstype'])) {
									$category = pdo_fetch('select id,`name`, enabled from ' . tablename('ewei_shop_category') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $item['params']['cateid'], ':uniacid' => $_W['uniacid']));
								}
								else {
									$category = pdo_fetch('select id,`name`, enabled from ' . tablename('ewei_shop_creditshop_category') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $item['params']['cateid'], ':uniacid' => $_W['uniacid']));
								}

								if (!empty($category)) {
									$item['params']['catename'] = $category['name'];
								}
								else {
									$item['params']['catename'] = '';
									$item['params']['cateid'] = '';
								}

								if (empty($category['enabled'])) {
									$item['data'] = array();
								}
							}
						}
						else {
							if ($item['params']['goodsdata'] == '2' && empty($item['params']['goodstype'])) {
								if (!empty($item['params']['groupid'])) {
									$group = pdo_fetch('select id, `name` from ' . tablename('ewei_shop_goods_group') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $item['params']['groupid'], ':uniacid' => $_W['uniacid']));

									if (!empty($group)) {
										$item['params']['groupname'] = $group['name'];
									}
									else {
										$item['params']['groupname'] = '';
										$item['params']['groupid'] = '';
									}
								}
							}
						}

						if (empty($item['data'])) {
							unset($page['data']['items'][$itemid]);
						}
					}
					else {
						if ($item['id'] == 'merchgroup' && p('merch')) {
							if ($item['params']['merchdata'] == '0') {
								if (!empty($item['data']) && is_array($item['data'])) {
									$merchids = array();

									foreach ($item['data'] as $index => $data) {
										if (!empty($data['merchid'])) {
											$merchids[] = $data['merchid'];
										}
									}
								}

								if (!empty($merchids) && is_array($merchids)) {
									$item['data'] = array();
									$newmerchids = implode(',', $merchids);
									$merchs = pdo_fetchall('select id, merchname, logo, status, `desc` from ' . tablename('ewei_shop_merch_user') . (' where id in( ' . $newmerchids . ' ) and status=1 and uniacid=:uniacid order by  field (id,') . $newmerchids . ')', array(':uniacid' => $_W['uniacid']));
									if (!empty($merchs) && is_array($merchs)) {
										foreach ($merchids as $merchid) {
											foreach ($merchs as $index => $merch) {
												if ($merch['id'] == $merchid) {
													$childid = rand(1000000000, 9999999999);
													$childid = 'C' . $childid;
													$item['data'][$childid] = array('name' => $this->replace_quotes($merch['merchname']), 'desc' => $this->replace_quotes($merch['desc']), 'thumb' => $merch['logo'], 'merchid' => $merch['id']);
												}
											}
										}
									}
								}
							}
							else if ($item['params']['merchdata'] == '1') {
								if (!empty($item['params']['cateid'])) {
									$category = pdo_fetch('select id, `catename`, status from ' . tablename('ewei_shop_merch_category') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $item['params']['cateid'], ':uniacid' => $_W['uniacid']));
								}

								if (!empty($category)) {
									$item['params']['catename'] = $category['catename'];
								}
								else {
									$item['params']['catename'] = '';
									$item['params']['cateid'] = '';
								}

								if (empty($category['status'])) {
									$item['data'] = array();
								}

								if (!empty($category) && !empty($category['status'])) {
									$merchs = pdo_fetchall('select id, merchname, logo, status, `desc` from ' . tablename('ewei_shop_merch_user') . ' where cateid=:cateid and status=1 and uniacid=:uniacid order by isrecommand desc ', array(':uniacid' => $_W['uniacid'], ':cateid' => $item['params']['cateid']));
									if (!empty($merchs) && is_array($merchs)) {
										$item['data'] = array();

										foreach ($merchs as $index => $merch) {
											$childid = rand(1000000000, 9999999999);
											$childid = 'C' . $childid;
											$item['data'][$childid] = array('name' => $this->replace_quotes($merch['merchname']), 'desc' => $this->replace_quotes($merch['desc']), 'thumb' => $merch['logo'], 'merchid' => $merch['id']);
										}
									}
								}
							}
							else if ($item['params']['merchdata'] == '2') {
								if (!empty($item['params']['groupid'])) {
									$group = pdo_fetch('select id, groupname, status from ' . tablename('ewei_shop_merch_group') . ' where id=:id and uniacid=:uniacid limit 1 ', array(':id' => $item['params']['groupid'], ':uniacid' => $_W['uniacid']));

									if (!empty($group)) {
										$item['params']['groupname'] = $group['groupname'];
									}
									else {
										$item['params']['groupname'] = '';
										$item['params']['groupid'] = '';
									}
								}

								if (empty($group['status'])) {
									$item['data'] = array();
								}

								if (!empty($group) && !empty($group['status'])) {
									$merchs = pdo_fetchall('select id, merchname, logo, status, `desc` from ' . tablename('ewei_shop_merch_user') . ' where groupid=:groupid and status=1 and uniacid=:uniacid order by isrecommand desc ', array(':uniacid' => $_W['uniacid'], ':groupid' => $item['params']['groupid']));
									if (!empty($merchs) && is_array($merchs)) {
										$item['data'] = array();

										foreach ($merchs as $index => $merch) {
											$childid = rand(1000000000, 9999999999);
											$childid = 'C' . $childid;
											$item['data'][$childid] = array('name' => $this->replace_quotes($merch['merchname']), 'desc' => $this->replace_quotes($merch['desc']), 'thumb' => $merch['logo'], 'merchid' => $merch['id']);
										}
									}
								}
							}
							else {
								if ($item['params']['merchdata'] == '3') {
									$merchs = pdo_fetchall('select id, merchname, logo, status, `desc` from ' . tablename('ewei_shop_merch_user') . ' where isrecommand=1 and status=1 and uniacid=:uniacid order by isrecommand desc ', array(':uniacid' => $_W['uniacid']));
									if (!empty($merchs) && is_array($merchs)) {
										$item['data'] = array();
										$merchnum = (int) $item['params']['merchnum'];

										foreach ($merchs as $index => $merch) {
											if ($merchnum <= $index) {
												break;
											}

											$childid = rand(1000000000, 9999999999);
											$childid = 'C' . $childid;
											$item['data'][$childid] = array('name' => $this->replace_quotes($merch['merchname']), 'desc' => $this->replace_quotes($merch['desc']), 'thumb' => $merch['logo'], 'merchid' => $merch['id']);
										}
									}
								}
							}
						}
						else if ($item['id'] == 'diymod') {
							if (!empty($item['params']['modid'])) {
								$diymod = $this->getPage($item['params']['modid']);

								if (!empty($diymod)) {
									$item['params']['modname'] = $diymod['name'];
								}
								else {
									$item['params']['modname'] = '模块不存在，请重新插入';
								}
							}
						}
						else if ($item['id'] == 'richtext') {
							$item['params']['content'] = base64_decode($item['params']['content']);
							$item['params']['content'] = htmlspecialchars_decode(m('common')->html_to_images($item['params']['content']));
							$item['params']['content'] = base64_encode($item['params']['content']);
						}
						else {
							if ($item['id'] == 'picture' || $item['id'] == 'picturew') {
								if (empty($item['style'])) {
									$item['style'] = array('background' => '#ffffff', 'paddingtop' => '0', 'paddingleft' => '0');
								}
							}
							else if ($item['id'] == 'detail_tab') {
								if (empty($item['params']['goodstext'])) {
									$item['params']['goodstext'] = '商品';
								}

								if (empty($item['params']['detailtext'])) {
									$item['params']['detailtext'] = '详情';
								}
							}
							else if ($item['id'] == 'detail_sale') {
								if (!empty($item['data']) && is_array($item['data'])) {
									$hasyushou = false;
									$hascoupon = false;
									$haszengpin = false;
									$hasfullback = false;

									foreach ($item['data'] as $childid => $child) {
										if ($child['type'] == 'yushou') {
											$hasyushou = true;
										}
										else if ($child['type'] == 'coupon') {
											$hascoupon = true;
										}
										else if ($child['type'] == 'zengpin') {
											$haszengpin = true;
										}
										else {
											if ($child['type'] == 'fullback') {
												$hasfullback = true;
											}
										}
									}

									if (!$hasyushou) {
										$childid = 'C' . time() . rand(100, 999);
										$item['data'][$childid] = array('name' => '商品预售', 'type' => 'yushou');
										unset($childid);
									}

									if (!$hascoupon) {
										$childid = 'C' . time() . rand(100, 999);
										$item['data'][$childid] = array('name' => '可用优惠券', 'type' => 'coupon');
										unset($childid);
									}

									if (!$haszengpin) {
										$childid = 'C' . time() . rand(100, 999);
										$item['data'][$childid] = array('name' => '赠品', 'type' => 'zengpin');
										unset($childid);
									}

									if (!$hasfullback) {
										$childid = 'C' . time() . rand(100, 999);
										$item['data'][$childid] = array('name' => '全返', 'type' => 'fullback');
										unset($childid);
									}
								}
							}
							else if ($item['id'] == 'coupon') {
								if (!empty($item['data']) && is_array($item['data'])) {
									$couponids = array();

									foreach ($item['data'] as $index => $data) {
										if (!empty($data['couponid'])) {
											$couponids[] = $data['couponid'];
										}
									}

									if (!empty($couponids) && is_array($couponids)) {
										$newcouponids = implode(',', $couponids);
										$coupons = pdo_fetchall('select * from ' . tablename('ewei_shop_coupon') . (' where id in( ' . $newcouponids . ' ) and uniacid=:uniacid'), array(':uniacid' => $_W['uniacid']), 'id');

										foreach ($item['data'] as $childid => &$child) {
											$couponid = $child['couponid'];
											$coupon = $coupons[$couponid];
											if (empty($coupon) || empty($coupon['gettype'])) {
												unset($item['data'][$childid]);
											}
											else {
												$child['name'] = $coupon['couponname'];

												if ($coupon['coupontype'] == 0) {
													if (0 < $coupon['enough']) {
														$child['desc'] = '满' . (double) $coupon['enough'] . '元可用';
													}
													else {
														$child['desc'] = '无门槛使用';
													}
												}
												else {
													if ($coupon['coupontype'] == 1) {
														if (0 < $coupon['enough']) {
															$child['desc'] = '充值满' . (double) $coupon['enough'] . '元可用';
														}
														else {
															$child['desc'] = '充值任意金额';
														}
													}
												}

												if ($coupon['backtype'] == 0) {
													$child['price'] = '￥' . (double) $coupon['deduct'];
												}
												else if ($coupon['backtype'] == 1) {
													$d['price'] = (double) $coupon['discount'] . '折 ';
												}
												else {
													if ($coupon['backtype'] == 2) {
														$values = 0;
														if (!empty($coupon['backmoney']) && 0 < $coupon['backmoney']) {
															$values = $values + $coupon['backmoney'];
														}

														if (!empty($coupon['backcredit']) && 0 < $coupon['backcredit']) {
															$values = $values + $coupon['backcredit'];
														}

														if (!empty($coupon['backredpack']) && 0 < $coupon['backredpack']) {
															$values = $values + $coupon['backredpack'];
														}

														$child['price'] = '￥' . $values;
													}
												}
											}
										}

										unset($child);
										unset($coupon);
										unset($couponid);
									}
								}
							}
							else {
								if (empty($item['id'])) {
									unset($page['data']['items'][$itemid]);
								}
							}
						}
					}
				}

				unset($item);
				$this->savePage($page['id'], $page['data'], false);
			}

			if ($mobile && !empty($page['data']['items']) && is_array($page['data']['items'])) {
				$tempmod = array();

				foreach ($page['data']['items'] as $itemid => $item) {
					if ($item['id'] == 'diymod') {
						$modid = $item['params']['modid'];
						$diymod = $this->getPage($modid, true);
						if (!empty($diymod) && !empty($diymod['data'])) {
							$tempmod[$itemid] = $diymod['data']['items'];
						}
						else {
							unset($page['data']['items'][$itemid]);
						}
					}
				}

				if (!empty($tempmod)) {
					$newmod = array();

					foreach ($page['data']['items'] as $itemid => $item) {
						if ($item['id'] == 'diymod') {
							$analysisMod = $this->analysisMod($tempmod[$itemid]);
							$newmod = array_merge($newmod, $analysisMod);
						}
						else {
							$newmod[$itemid] = $item;
						}
					}
				}

				if (!empty($newmod) && is_array($newmod)) {
					$page['data']['items'] = $newmod;
				}
			}

			if ($mobile && !empty($page['data']['items']) && is_array($page['data']['items'])) {
				foreach ($page['data']['items'] as $itemid => &$item) {
					if ($item['id'] == 'goods') {
						if ($item['params']['goodsdata'] == '0') {
							if (!empty($item['data']) && is_array($item['data'])) {
								$goodsids = array();

								foreach ($item['data'] as $index => $data) {
									if (!empty($data['gid'])) {
										$goodsids[] = $data['gid'];
									}
								}

								if (!empty($goodsids) && is_array($goodsids)) {
									$newgoodsids = implode(',', $goodsids);

									if ($creditshop) {
										$goods = pdo_fetchall('select id, showlevels, showgroups from ' . tablename('ewei_shop_creditshop_goods') . (' where id in( ' . $newgoodsids . ' ) and status=1 and deleted=0 and uniacid=:uniacid order by displayorder desc '), array(':uniacid' => $_W['uniacid']));
									}
									else {
										$goods = pdo_fetchall('select id, showlevels,hascommission,nocommission,commission,commission1_rate,marketprice,commission1_pay,maxprice,showgroups from ' . tablename('ewei_shop_goods') . (' where id in( ' . $newgoodsids . ' ) and status=1 and deleted=0 and checked=0 and uniacid=:uniacid order by displayorder desc '), array(':uniacid' => $_W['uniacid']));
									}

									if (!empty($goods) && is_array($goods)) {
										foreach ($item['data'] as $childid => $childgoods) {
											foreach ($goods as $index => $good) {
												if ($good['id'] == $childgoods['gid']) {
													$showgoods = m('goods')->visit($good, $this->member);

													if (empty($showgoods)) {
														unset($item['data'][$childid]);
													}
												}
											}
										}
									}
								}
							}
						}
						else if ($item['params']['goodsdata'] == '1') {
							$limit = $item['params']['goodsnum'];
							$cateid = $item['params']['cateid'];

							if (!empty($cateid)) {
								$orderby = ' displayorder desc, createtime desc';
								$goodssort = $item['params']['goodssort'];

								if (!empty($goodssort)) {
									if ($goodssort == 1) {
										$orderby = empty($item['params']['goodstype']) ? ' sales+salesreal desc, displayorder desc' : ' joins desc, displayorder desc';
									}
									else if ($goodssort == 2) {
										$orderby = empty($item['params']['goodstype']) ? ' minprice desc, displayorder desc' : ' minmoney desc, displayorder desc';
									}
									else {
										if ($goodssort == 3) {
											$orderby = empty($item['params']['goodstype']) ? ' minprice asc, displayorder desc' : ' minmoney asc, displayorder desc';
										}
									}
								}

								if (empty($item['params']['goodstype'])) {
									$goodslist = m('goods')->getList(array('cate' => $cateid, 'pagesize' => $limit, 'page' => 1, 'order' => $orderby, 'merchid' => intval($page['merch'])));
									$goods = $goodslist['list'];
								}
								else {
									$goods = pdo_fetchall('select id, title, thumb, price as productprice, money as minprice, credit, total, showlevels, showgroups, `type`, goodstype from ' . tablename('ewei_shop_creditshop_goods') . (' where cate=:cate and status=1 and deleted=0 and uniacid=:uniacid order by ' . $orderby . ' limit ') . $limit, array(':cate' => $cateid, ':uniacid' => $_W['uniacid']));
								}

								$item['data'] = array();
								if (!empty($goods) && is_array($goods)) {
									$level = $this->getLevel($_W['openid']);
									$set = m('common')->getPluginset('commission');

									foreach ($goods as $key => $value) {
										if ($value['nocommission'] == 0) {
											if (p('seckill')) {
												if (p('seckill')->getSeckill($value['id'])) {
													continue;
												}
											}

											if (0 < $value['bargain']) {
												continue;
											}

											$goods[$key]['seecommission'] = $this->getCommission($value, $level, $set);

											if (0 < $goods[$key]['seecommission']) {
												$goods[$key]['seecommission'] = round($goods[$key]['seecommission'], 2);
											}

											$goods[$key]['cansee'] = $set['cansee'];
											$goods[$key]['seetitle'] = $set['seetitle'];
										}
										else {
											$goods[$key]['seecommission'] = 0;
											$goods[$key]['cansee'] = $set['cansee'];
											$goods[$key]['seetitle'] = $set['seetitle'];
										}
									}

									foreach ($goods as $index => $good) {
										$showgoods = m('goods')->visit($good, $this->member);

										if (!empty($showgoods)) {
											$childid = rand(1000000000, 9999999999);
											$childid = 'C' . $childid;
											$item['data'][$childid] = array('thumb' => $good['thumb'], 'title' => $good['title'], 'subtitle' => $good['subtitle'], 'price' => $good['minprice'], 'gid' => $good['id'], 'total' => $good['total'], 'bargain' => $good['bargain'], 'productprice' => $good['productprice'], 'credit' => $good['credit'], 'ctype' => $good['type'], 'gtype' => $good['goodstype'], 'seecommission' => $good['seecommission'], 'cansee' => $good['cansee'], 'seetitle' => $good['seetitle'], 'sales' => $good['sales'] + intval($good['salesreal']));
										}
									}
								}
							}
							else {
								$item['data'] = array();
							}
						}
						else {
							if ($item['params']['goodsdata'] == '2' && empty($item['params']['goodstype'])) {
								$limit = $item['params']['goodsnum'];
								$groupid = intval($item['params']['groupid']);

								if (!empty($groupid)) {
									$group = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_goods_group') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $groupid, ':uniacid' => $_W['uniacid']));
								}

								$item['data'] = array();
								if (!empty($group) && !empty($group['goodsids'])) {
									$orderby = ' order by displayorder desc';
									$goodssort = $item['params']['goodssort'];

									if (!empty($goodssort)) {
										if ($goodssort == 1) {
											$orderby = empty($item['params']['goodstype']) ? ' order by sales+salesreal desc, displayorder desc' : ' order by joins desc, displayorder desc';
										}
										else if ($goodssort == 2) {
											$orderby = empty($item['params']['goodstype']) ? ' order by  minprice desc, displayorder desc' : ' order by  minmoney desc, displayorder desc';
										}
										else {
											if ($goodssort == 3) {
												$orderby = empty($item['params']['goodstype']) ? ' order by  minprice asc, displayorder desc' : ' order by  minmoney asc, displayorder desc';
											}
										}
									}

									$goodsids = $group['goodsids'];
									$goods = pdo_fetchall('select id, title, subtitle, thumb, `type`, minprice, sales, salesreal, total, showlevels, showgroups,hascommission,nocommission,commission,commission1_rate,marketprice,commission1_pay,maxprice,bargain,productprice,ispresell,presellprice from ' . tablename('ewei_shop_goods') . (' where id in( ' . $goodsids . ' ) and status=1 and `deleted`=0 and `status`=1 and uniacid=:uniacid ') . $orderby . (' limit ' . $limit), array(':uniacid' => $_W['uniacid']));
									if (!empty($goods) && is_array($goods)) {
										if ($value['ispresell'] == 1) {
											$goods[$key]['minprice'] = $value['presellprice'];
										}

										$level = $this->getLevel($_W['openid']);
										$set = m('common')->getPluginset('commission');

										foreach ($goods as $key => $value) {
											if ($value['nocommission'] == 0) {
												if (p('seckill')) {
													if (p('seckill')->getSeckill($value['id'])) {
														continue;
													}
												}

												if (0 < $value['bargain']) {
													continue;
												}

												$goods[$key]['seecommission'] = $this->getCommission($value, $level, $set);

												if (0 < $goods[$key]['seecommission']) {
													$goods[$key]['seecommission'] = round($goods[$key]['seecommission'], 2);
												}

												$goods[$key]['cansee'] = $set['cansee'];
												$goods[$key]['seetitle'] = $set['seetitle'];
											}
											else {
												$goods[$key]['seecommission'] = 0;
												$goods[$key]['cansee'] = $set['cansee'];
												$goods[$key]['seetitle'] = $set['seetitle'];
											}
										}

										foreach ($goods as $index => $good) {
											$showgoods = m('goods')->visit($good, $this->member);

											if (!empty($showgoods)) {
												$childid = rand(1000000000, 9999999999);
												$childid = 'C' . $childid;
												$item['data'][$childid] = array('thumb' => $good['thumb'], 'title' => $good['title'], 'subtitle' => $good['subtitle'], 'price' => $good['minprice'], 'gid' => $good['id'], 'total' => $good['total'], 'ctype' => $good['type'], 'bargain' => $good['bargain'], 'seecommission' => $good['seecommission'], 'cansee' => $good['cansee'], 'seetitle' => $good['seetitle'], 'productprice' => $good['productprice'], 'sales' => $good['sales'] + $good['salesreal']);
											}
										}
									}
								}
							}
							else {
								if (2 < $item['params']['goodsdata']) {
									$args = array('pagesize' => $item['params']['goodsnum'], 'page' => 1, 'order' => ' displayorder desc, createtime desc');
									$goodssort = $item['params']['goodssort'];

									if (!empty($goodssort)) {
										if ($goodssort == 1) {
											$args['order'] = empty($item['params']['goodstype']) ? ' sales desc, displayorder desc' : ' joins desc, displayorder desc';
										}
										else if ($goodssort == 2) {
											$args['order'] = empty($item['params']['goodstype']) ? ' minprice desc, displayorder desc' : 'minmoney desc, mincredit desc, displayorder desc';
										}
										else {
											if ($goodssort == 3) {
												$args['order'] = empty($item['params']['goodstype']) ? ' minprice asc, displayorder desc' : 'minmoney asc, mincredit asc, displayorder desc';
											}
										}
									}

									if (empty($item['params']['goodstype'])) {
										if ($item['params']['goodsdata'] == 3) {
											$args['isnew'] = 1;
										}
										else if ($item['params']['goodsdata'] == 4) {
											$args['ishot'] = 1;
										}
										else if ($item['params']['goodsdata'] == 5) {
											$args['isrecommand'] = 1;
										}
										else if ($item['params']['goodsdata'] == 6) {
											$args['isdiscount'] = 1;
										}
										else if ($item['params']['goodsdata'] == 7) {
											$args['issendfree'] = 1;
										}
										else {
											if ($item['params']['goodsdata'] == 8) {
												$args['istime'] = 1;
											}
										}

										$args['merchid'] = $page['merch'];
										$goodslist = m('goods')->getList($args);
										$goods = $goodslist['list'];
									}
									else {
										$condition = ' and status=1 and deleted=0 and uniacid=:uniacid ';
										$params = array(':uniacid' => $_W['uniacid']);

										if ($item['params']['goodsdata'] == 5) {
											$condition .= ' and isrecommand=1 and showlevels = \'\'';
										}
										else if ($item['params']['goodsdata'] == 9) {
											$condition .= ' and type=0 ';
										}
										else {
											if ($item['params']['goodsdata'] == 10) {
												$condition .= ' and type=1 ';
											}
										}

										$goods = pdo_fetchall('select id, title, thumb, price as productprice, money as minprice, credit, total, showlevels,showgroups, `type`, goodstype from ' . tablename('ewei_shop_creditshop_goods') . (' where 1 ' . $condition . ' order by ' . $args['order'] . ' limit ') . $args['pagesize'], $params);
									}

									$item['data'] = array();
									if (!empty($goods) && is_array($goods)) {
										unset($index);
										$level = $this->getLevel($_W['openid']);
										$set = m('common')->getPluginset('commission');

										foreach ($goods as $key => $value) {
											if ($value['nocommission'] == 0) {
												if (p('seckill')) {
													if (p('seckill')->getSeckill($value['id'])) {
														continue;
													}
												}

												if (0 < $value['bargain']) {
													continue;
												}

												$goods[$key]['seecommission'] = $this->getCommission($value, $level, $set);

												if (0 < $goods[$key]['seecommission']) {
													$goods[$key]['seecommission'] = round($goods[$key]['seecommission'], 2);
												}

												$goods[$key]['cansee'] = $set['cansee'];
												$goods[$key]['seetitle'] = $set['seetitle'];
											}
											else {
												$goods[$key]['seecommission'] = 0;
												$goods[$key]['cansee'] = $set['cansee'];
												$goods[$key]['seetitle'] = $set['seetitle'];
											}
										}

										foreach ($goods as $index => $good) {
											$showgoods = m('goods')->visit($good, $this->member);

											if (!empty($showgoods)) {
												$childid = rand(1000000000, 9999999999);
												$childid = 'C' . $childid;
												$item['data'][$childid] = array('thumb' => $good['thumb'], 'title' => $good['title'], 'subtitle' => $good['subtitle'], 'price' => $good['minprice'], 'gid' => $good['id'], 'total' => $good['total'], 'bargain' => $good['bargain'], 'productprice' => $good['productprice'], 'credit' => $good['credit'], 'seecommission' => $good['seecommission'], 'cansee' => $good['cansee'], 'seetitle' => $good['seetitle'], 'ctype' => $good['type'], 'gtype' => $good['goodstype'], 'sales' => $good['sales'] + intval($good['salesreal']));
											}
										}
									}
								}
							}
						}
					}
					else if ($item['id'] == 'notice') {
						if ($item['params']['noticedata'] == '0') {
							$limit = !empty($item['params']['noticenum']) ? $item['params']['noticenum'] : 5;

							if (!empty($page['merch'])) {
								$notices = pdo_fetchall('select id, title, link, thumb from ' . tablename('ewei_shop_merch_notice') . (' where uniacid=:uniacid and merchid=:merchid and status=1 order by displayorder desc limit ' . $limit), array(':uniacid' => $_W['uniacid'], ':merchid' => intval($page['merch'])));
							}
							else {
								$notices = pdo_fetchall('select id, title, link, thumb from ' . tablename('ewei_shop_notice') . (' where uniacid=:uniacid and iswxapp=0 and status=1 order by displayorder desc limit ' . $limit), array(':uniacid' => $_W['uniacid']));
							}

							$item['data'] = array();
							if (!empty($notices) && is_array($notices)) {
								foreach ($notices as $index => $notice) {
									$childid = rand(1000000000, 9999999999);
									$childid = 'C' . $childid;
									$item['data'][$childid] = array('id' => $notice['id'], 'title' => $notice['title'], 'linkurl' => $notice['link']);
								}
							}
						}
					}
					else if ($item['id'] == 'richtext') {
						$content = $item['params']['content'];

						if (!empty($content)) {
							$content = base64_decode($content);
							$content = m('common')->html_to_images($content);

							if ($page['type'] != 2) {
								$content = m('ui')->lazy($content);
							}

							$item['params']['content'] = base64_encode($content);
						}
					}
					else if ($item['id'] == 'listmenu') {
						if (empty($item['data']) || !is_array($item['data'])) {
							unset($page['data']['items'][$itemid]);
						}

						foreach ($item['data'] as $childid => &$child) {
							if (empty($child['text'])) {
								unset($item['data'][$childid]);
							}

							if (!empty($child['linkurl'])) {
								$linkurl = $this->judge('url', $child['linkurl']);

								if (!$linkurl) {
									unset($item['data'][$childid]);
								}

								$child['dotnum'] = $this->judge('dot', $child['linkurl']);
							}
						}

						unset($child);
					}
					else if ($item['id'] == 'member') {
						$member = $this->member;

						if (p('membercard')) {
							$list_membercard = p('membercard')->get_Mycard('', 0, 100);
						}

						$level = m('member')->getLevel($_W['openid']);
						$item['info'] = array('avatar' => $member['avatar'], 'nickname' => $member['nickname'], 'levelname' => $level['levelname'], 'textmoney' => $_W['shopset']['trade']['moneytext'], 'textcredit' => $_W['shopset']['trade']['credittext'], 'money' => $member['credit2'], 'credit' => intval($member['credit1']), 'membercard' => count($list_membercard['list']));
					}
					else if ($item['id'] == 'verify') {
						$item['data'] = m('verifygoods')->getCanUseVerifygoods($_W['openid']);
					}
					else if ($item['id'] == 'icongroup') {
						if (empty($item['data']) || !is_array($item['data'])) {
							unset($page['data']['items'][$itemid]);
						}

						foreach ($item['data'] as $childid => &$child) {
							if (empty($child['iconclass'])) {
								unset($item['data'][$childid]);
							}

							if (!empty($child['linkurl'])) {
								$linkurl = $this->judge('url', $child['linkurl']);

								if (!$linkurl) {
									unset($item['data'][$childid]);
								}
								else {
									$child['dotnum'] = $this->judge('dot', $child['linkurl']);
								}
							}
						}

						unset($child);
					}
					else if ($item['id'] == 'bindmobile') {
						$member = $this->member;
						if (empty($member) || (empty($wapset['open']) || !empty($member['mobileverify']))) {
							unset($page['data']['items'][$itemid]);
						}
						else {
							$item['params']['linkurl'] = mobileUrl('member/bind');
						}
					}
					else if ($item['id'] == 'logout') {
						if (is_weixin()) {
							unset($page['data']['items'][$itemid]);
						}
						else {
							$member = $this->member;

							if (empty($member)) {
								unset($page['data']['items'][$itemid]);
							}
							else {
								$item['params']['bindurl'] = !empty($member['mobileverify']) ? mobileUrl('member/changepwd') : mobileUrl('member/bind');
								$item['params']['logouturl'] = mobileUrl('account/logout');
							}
						}
					}
					else if ($item['id'] == 'memberc') {
						$member = $this->member;
						$commission = $this->commission;
						$item['params']['mid'] = $member['id'];
						$item['params']['mobile'] = $member['mobile'];
						$item['params']['avatar'] = $member['avatar'];
						$item['params']['nickname'] = $member['nickname'];
						$item['params']['levelname'] = $member['commissionlevelname'];
						$item['params']['textyaun'] = $commission['set']['texts']['yuan'];
						$item['params']['textsuccesswithdraw'] = $commission['set']['texts']['commission_pay'];
						$item['params']['textcanwithdraw'] = $commission['set']['texts']['commission_ok'];
						$item['params']['successwithdraw'] = number_format($member['commission_pay'], 2);
						$item['params']['canwithdraw'] = number_format($member['commission_ok'], 2);
						$item['params']['upname'] = $commission['set']['texts']['up'];
						$item['params']['upmember'] = empty($member['up']) ? '总店' : $member['up']['nickname'];
						$item['params']['texticode'] = $commission['set']['texts']['icode'];
						$item['params']['hideicode'] = $commission['set']['hideicode'];
					}
					else if ($item['id'] == 'commission_sharecode') {
						$item['params']['icode'] = p('offic') ? $member['mobile'] : $member['id'];
						$item['params']['texticode'] = $commission['set']['texts']['icode'];
						$item['params']['hideicode'] = $commission['set']['hideicode'];
					}
					else if ($item['id'] == 'commission_block') {
						$item['params']['textcommission'] = $commission['set']['texts']['commission'];
						$item['params']['textwithdraw'] = $commission['set']['texts']['withdraw'];
						$item['params']['textyaun'] = $commission['set']['texts']['yuan'];
						$item['params']['textsuccesswithdraw'] = $commission['set']['texts']['commission_pay'];
						$item['params']['textcanwithdraw'] = $commission['set']['texts']['commission_ok'];
						$item['params']['successwithdraw'] = number_format($member['commission_pay'], 2);
						$item['params']['canwithdraw'] = number_format($member['commission_ok'], 2);
						$item['params']['withdraw'] = $commission['set']['withdraw'];
						$item['params']['cansettle'] = 1 <= $member['commission_ok'] && floatval($commission['set']['withdraw']) <= $member['commission_ok'];
					}
					else if ($item['id'] == 'blockgroup') {
						if (empty($item['data']) || !is_array($item['data'])) {
							unset($item);
						}

						foreach ($item['data'] as $childid => &$child) {
							if (empty($child['iconclass'])) {
								unset($item['data'][$childid]);
							}

							$child['tipnum'] = '';
							$child['tiptext'] = '';

							if (!empty($child['linkurl'])) {
								$linkurl = $this->judge('url', $child['linkurl']);

								if (!$linkurl) {
									unset($item['data'][$childid]);
								}
								else {
									$child['tipnum'] = $this->judge('tipnum', $child['linkurl']);
									$child['tiptext'] = $this->judge('tiptext', $child['linkurl']);
								}
							}
						}

						unset($child);
					}
					else {
						if ($item['id'] == 'menu' && !empty($item['style']['showtype'])) {
							if (!empty($item['data'])) {
								$swiperpage = empty($item['style']['pagenum']) ? 8 : $item['style']['pagenum'];
								$data_temp = array();
								$k = 0;
								$i = 1;

								foreach ($item['data'] as $childid => $child) {
									$data_temp[$k][$childid] = $child;

									if ($i < $swiperpage) {
										++$i;
									}
									else {
										$i = 1;
										++$k;
									}
								}

								$item['data_temp'] = $data_temp;
								unset($swiperpage);
								unset($data_temp);
								unset($k);
								unset($i);
							}
							else {
								unset($page['data']['items'][$itemid]);
							}
						}
						else {
							if ($item['id'] == 'picturew' && !empty($item['params']['showtype'])) {
								if (!empty($item['data'])) {
									$swiperpage = empty($item['style']['pagenum']) ? 2 : $item['style']['pagenum'];
									$data_temp = array();
									$k = 0;
									$i = 1;

									foreach ($item['data'] as $childid => $child) {
										$data_temp[$k][$childid] = $child;

										if ($i < $swiperpage) {
											++$i;
										}
										else {
											$i = 1;
											++$k;
										}
									}

									$item['data_temp'] = $data_temp;
									unset($swiperpage);
									unset($data_temp);
									unset($k);
									unset($i);
								}
								else {
									unset($page['data']['items'][$itemid]);
								}
							}
							else if ($item['id'] == 'seckillgroup') {
								$item['data'] = plugin_run('seckill::getTaskSeckillInfo');
							}
							else if ($item['id'] == 'tabbar') {
								if (!empty($item['data'])) {
									$itemstyle = 'background:' . $item['style']['background'] . '; color:' . $item['style']['color'] . ';';
									$itemstyleactive = 'background:' . $item['style']['activebackground'] . '; color:' . $item['style']['activecolor'] . '; border-color:' . $item['style']['activecolor'] . ';';
									$activeIndex = 0;

									foreach ($item['data'] as $childid => $child) {
										$active = false;

										if (!empty($child['linkurl'])) {
											if (strexists($_W['siteurl'], ltrim($child['linkurl'], './'))) {
												$item['data'][$childid]['active'] = 1;
												$item['params']['slideto'] = $activeIndex;
												$active = true;
											}
										}

										$item['data'][$childid]['style'] = $active ? $itemstyleactive : $itemstyle;
										++$activeIndex;
									}

									unset($active);
									unset($childid);
									unset($child);
									unset($activeIndex);
								}
								else {
									unset($page['data']['items'][$itemid]);
								}

								unset($itemstyle);
								unset($itemstyleactive);
							}
							else if ($item['id'] == 'wxcard') {
								$wxcard = m('common')->getSysset('membercard');

								if (empty($wxcard)) {
									unset($page['data']['items'][$itemid]);
								}
								else {
									$membercardid = $this->member['membercardid'];
									if (!empty($membercardid) && $wxcard['card_id'] == $membercardid) {
										$item['params']['text'] = '查看会员卡信息';
									}
									else {
										$item['params']['text'] = '领取会员卡';
									}

									$item['params']['cardid'] = $wxcard['card_id'];
								}
							}
							else if ($item['id'] == 'topmenu') {
								if (!empty($item['data'])) {
									$data_temp = array();
									$k = 0;
									$i = 1;

									foreach ($item['data'] as $childid => $child) {
										$data_temp[$k][$childid] = $child;
									}

									$item['data_temp'] = $data_temp;
									unset($data_temp);
									unset($k);
									unset($i);
								}
								else {
									unset($page['data']['items'][$itemid]);
								}
							}
							else {
								if ($item['id'] == 'tabbar') {
									if (!empty($item['data'])) {
										$data_temp = array();
										$k = 0;
										$i = 1;

										foreach ($item['data'] as $childid => $child) {
											$data_temp[$k][$childid] = $child;
										}

										$item['data_temp'] = $data_temp;
										unset($data_temp);
										unset($k);
										unset($i);
									}
									else {
										unset($page['data']['items'][$itemid]);
									}
								}
							}
						}
					}
				}

				unset($item);
			}

			if ($mobile && !empty($page['data'])) {
				$page['data'] = json_encode($page['data']);
				$page['data'] = $this->url($page['data']);
				$page['data'] = json_decode($page['data'], true);
			}
		}

		return $page;
	}

	public function getCommission($goods, $level, $set)
	{
		global $_W;
		$commission = 0;

		if ($level == 'false') {
			return $commission;
		}

		if ($goods['hascommission'] == 1) {
			$price = $goods['maxprice'];
			$levelid = 'default';

			if ($level) {
				$levelid = 'level' . $level['id'];
			}

			$goods_commission = !empty($goods['commission']) ? json_decode($goods['commission'], true) : array();

			if ($goods_commission['type'] == 0) {
				$commission = 1 <= $set['level'] ? (0 < $goods['commission1_rate'] ? $goods['commission1_rate'] * $goods['marketprice'] / 100 : $goods['commission1_pay']) : 0;
			}
			else {
				$price_all = array();
				unset($goods_commission['type']);
				if ($goods_commission[$levelid] && is_array($goods_commission[$levelid])) {
					foreach ($goods_commission[$levelid] as $key => $value) {
						foreach ($value as $vl) {
							if (strexists($vl, '%')) {
								array_push($price_all, floatval(str_replace('%', '', $vl) / 100) * $price);
								continue;
							}

							array_push($price_all, $vl);
						}
					}

					$commission = max($price_all);
				}
				else {
					$commission = 0;
				}
			}
		}
		else {
			if ($level != 'false' && !empty($level)) {
				$commission = 1 <= $set['level'] ? round($level['commission1'] * $goods['marketprice'] / 100, 2) : 0;
			}
			else {
				$commission = 1 <= $set['level'] ? round($set['commission1'] * $goods['marketprice'] / 100, 2) : 0;
			}
		}

		return $commission;
	}

	public function getLevel($openid)
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

	/**
     * 根据type获取id
     * @param null $type
     * @return int
     */
	public function type2Pageid($type = NULL)
	{
		if (empty($type)) {
			return 0;
		}

		$set = m('common')->getPluginset('diypage');
		$pageset = $set['page'];
		$pageid = intval($pageset[$type . '_wxapp']);
		return $pageid;
	}

	/**
     * 保存页面
     * @param $id
     * @param $data
     * @param bool $update
     */
	public function savePage($id, $data, $update = true)
	{
		global $_W;
		$keyword = $data['page']['keyword'];
		if (!empty($keyword) && $update) {
			$result = m('common')->keyExist($keyword);

			if (!empty($result)) {
				if ($result['name'] != 'ewei_shopv2:diypage:' . $id) {
					show_json(0, '关键字已存在！');
				}
			}
			else {
				if (!empty($result)) {
					show_json(0, '关键字已存在！');
				}
			}
		}

		$pagedata = json_encode($data);

		if ($update) {
			$pagedata = $this->saveImg($pagedata);
		}

		$diypage = array('data' => base64_encode($pagedata), 'name' => $data['page']['name'], 'keyword' => $data['page']['keyword'], 'type' => $data['page']['type'], 'diymenu' => intval($data['page']['diymenu']), 'diyadv' => intval($data['page']['diyadv']));

		if (!empty($id)) {
			if ($update) {
				$diypage['lastedittime'] = time();
			}

			pdo_update('ewei_shop_diypage', $diypage, array('id' => $id, 'uniacid' => $_W['uniacid']));
			$savetype = 'update';
		}
		else {
			$diypage['uniacid'] = $_W['uniacid'];
			$diypage['createtime'] = time();
			$diypage['lastedittime'] = time();
			$diypage['merch'] = intval($_W['merchid']);
			pdo_insert('ewei_shop_diypage', $diypage);
			$id = pdo_insertid();
			$savetype = 'insert';
		}

		if (!empty($keyword) && $update) {
			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:diypage:' . $id));

			if (!empty($rule)) {
				pdo_update('rule_keyword', array('content' => $keyword), array('rid' => $rule['id']));
			}
			else {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:diypage:' . $id, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => $keyword, 'type' => 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}
		}

		if ($update) {
			$item = pdo_fetch('select id, type, name, keyword from ' . tablename('ewei_shop_diypage') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

			if ($savetype == 'update') {
				if ($item['type'] == 1) {
					plog('diypage.page.diy.edit', '更新自定义页面 id: ' . $item['id'] . '  名称:' . $item['name'] . '  关键字: ' . $item['keyword']);
				}
				else {
					if (1 < $item['type'] && $item['type'] < 99) {
						plog('diypage.page.sys.edit', '更新系统页面 id: ' . $item['id'] . '  名称:' . $item['name'] . '  关键字: ' . $item['keyword']);
					}
					else {
						if ($item['type'] == 99) {
							plog('diypage.page.mod.edit', '更新公用模块 id: ' . $item['id'] . '  名称:' . $item['name'] . '  关键字: ' . $item['keyword']);
						}
					}
				}
			}
			else {
				if ($savetype == 'insert') {
					if ($item['type'] == 1) {
						plog('diypage.page.diy.add', '添加自定义页面 id: ' . $item['id'] . '  名称:' . $item['name'] . '  关键字: ' . $item['keyword']);
					}
					else {
						if (1 < $item['type'] && $item['type'] < 99) {
							plog('diypage.page.sys.add', '添加系统页面 id: ' . $item['id'] . '  名称:' . $item['name'] . '  关键字: ' . $item['keyword']);
						}
						else {
							if ($item['type'] == 99) {
								plog('diypage.page.mod.add', '添加公用模块 id: ' . $item['id'] . '  名称:' . $item['name'] . '  关键字: ' . $item['keyword']);
							}
						}
					}
				}
			}

			$result = array('id' => $id);

			if ($savetype == 'insert') {
				if ($diypage['type'] == 1) {
					$pagetype = 'diy';
				}
				else {
					if (1 < $diypage['type'] && $diypage['type'] < 99) {
						$pagetype = 'sys';
					}
					else {
						if ($diypage['type'] == 99) {
							$pagetype = 'mod';
						}
					}
				}

				$result['jump'] = webUrl('diypage/page') . '.' . $pagetype . '.edit&id=' . $id;
			}

			show_json(1, $result);
		}
	}

	/**
     * 删除页面
     * @param $id
     */
	public function delPage($id)
	{
		global $_W;

		if (empty($id)) {
			show_json(1);
		}

		$items = pdo_fetchall('SELECT id,`name`,`type`,keyword FROM ' . tablename('ewei_shop_diypage') . (' WHERE id in( ' . $id . ' ) and uniacid=:uniacid '), array(':uniacid' => $_W['uniacid']));

		foreach ($items as $item) {
			pdo_delete('ewei_shop_diypage', array('id' => $item['id'], 'uniacid' => $_W['uniacid']));

			if ($item['type'] == 1) {
				plog('diypage.page.diy.delete', '删除自定义页面 id: ' . $item['id'] . '  名称:' . $item['name']);
			}
			else {
				if (1 < $item['type'] && $item['type'] < 99) {
					plog('diypage.page.sys.delete', '删除系统页面 id: ' . $item['id'] . '  名称:' . $item['name']);
				}
			}

			if ($item['type'] == 99) {
				plog('diypage.page.mod.delete', '删除公用模块 id: ' . $item['id'] . '  名称:' . $item['name']);
			}

			$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and module=:module and uniacid=:uniacid limit 1 ', array(':content' => $item['keyword'], ':module' => 'ewei_shopv2', ':uniacid' => $_W['uniacid']));

			if (!empty($keyword)) {
				pdo_delete('rule_keyword', array('id' => $keyword['id']));
				pdo_delete('rule', array('id' => $keyword['rid']));
			}
		}

		show_json(1);
	}

	/**
     * 保存图片
     * @param $str
     * @return mixed|void
     */
	public function saveImg($str)
	{
		if (empty($str) || is_array($str)) {
			return NULL;
		}

		$str = preg_replace_callback('/"imgurl"\\:"([^\\\'" ]+)"/', function($matches) {
			$preg = !empty($matches[1]) ? istripslashes($matches[1]) : '';

			if (empty($preg)) {
				return '"imgurl":""';
			}

			if (!strexists($preg, '../addons/ewei_shopv2')) {
				$newUrl = save_media($preg);
			}
			else {
				$newUrl = $preg;
			}

			return '"imgurl":"' . $newUrl . '"';
		}, $str);
		$str = preg_replace_callback('/"content"\\:"([^\\\'" ]+)"/', function($matches) {
			$preg = !empty($matches[1]) ? istripslashes($matches[1]) : '';
			$preg = base64_decode($preg);

			if (empty($preg)) {
				return '"content":""';
			}

			$preg = m('common')->html_images($preg);
			$newcontent = base64_encode($preg);
			return '"content":"' . $newcontent . '"';
		}, $str);
		return $str;
	}

	/**
     * 保存模板
     * @param $temp
     */
	public function saveTemp($temp)
	{
		global $_W;
		global $_GPC;
		if (empty($temp) || empty($temp['data'])) {
			show_json(0, '保存失败，数据为空。');
		}

		$temp['uniacid'] = $_W['uniacid'];
		$temp['data']['page']['keyword'] = '';
		$temp['data'] = base64_encode(json_encode($temp['data']));
		pdo_insert('ewei_shop_diypage_template', $temp);

		if ($temp['type'] == 1) {
			plog('diypage.page.diy.savetemp', '另存为模板 名称:' . $temp['name']);
		}
		else {
			if (1 < $temp['type'] && $temp['type'] < 99) {
				plog('diypage.page.sys.savetemp', '另存为模板 名称:' . $temp['name']);
			}
		}

		show_json(1);
	}

	/**
     * 后他验证
     * @param $do
     * @param $pagetype
     * @return array
     */
	public function verify($do, $pagetype)
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$tid = intval($_GPC['tid']);
		$type = intval($_GPC['type']);
		$result = array('do' => $do, 'id' => $id, 'tid' => $tid, 'type' => $type, 'pagetype' => $pagetype);

		if ($do == 'add') {
			if (!empty($type)) {
				$getpagetype = $this->getPageType($type);
				$getpagetype = $getpagetype['pagetype'];

				if ($getpagetype != $pagetype) {
					$url = webUrl('diypage/page') . '.' . $pagetype . '.add';
					header('location: ' . $url);
					exit();
				}
			}
			else if ($pagetype == 'diy') {
				$result['type'] = 1;
			}
			else if ($pagetype == 'sys') {
				$result['type'] = empty($_GPC['type']) ? 2 : intval($_GPC['type']);
			}
			else {
				if ($pagetype == 'mod') {
					$result['type'] = 99;
				}
			}

			if (!empty($tid)) {
				$template = pdo_fetch('select * from ' . tablename('ewei_shop_diypage_template') . ' where id=:id and (uniacid=:uniacid or uniacid=0) limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $tid));
				if (!empty($template) && $template['type'] == $result['type']) {
					$result['type'] = $template['type'];
					$result['template'] = $template;
					return $result;
				}
			}
		}
		else {
			if ($do == 'edit') {
				if (empty($id)) {
					$url = webUrl('diypage/page') . '.' . $pagetype . '.add';
					header('location: ' . $url);
					exit();
				}

				$page = $this->getPage($id);

				if (empty($page)) {
					$url = webUrl('diypage/page') . '.' . $pagetype . '.add';
					header('location: ' . $url);
					exit();
				}

				if ($pagetype == 'diy' && $page['type'] != 1) {
					$type = $this->getPageType($page['type']);
					$url = webUrl('diypage/page') . '.' . $type['pagetype'] . '.edit&id=' . $id;
					header('location: ' . $url);
					exit();
				}
				else {
					if ($pagetype == 'sys' && ($page['type'] != 2 && $page['type'] != 3 && $page['type'] != 5 && $page['type'] != 9)) {
						$type = $this->getPageType($page['type']);
						$url = webUrl('diypage/page') . '.' . $type['pagetype'] . '.edit&id=' . $id;
						header('location: ' . $url);
						exit();
					}
					else {
						if ($pagetype == 'plu' && ($page['type'] != 4 && $page['type'] < 6 || $page['type'] == 99)) {
							$type = $this->getPageType($page['type']);
							$url = webUrl('diypage/page') . '.' . $type['pagetype'] . '.edit&id=' . $id;
							header('location: ' . $url);
							exit();
						}
						else {
							if ($pagetype == 'mod' && $page['type'] != 99) {
								$type = $this->getPageType($page['type']);
								$url = webUrl('diypage/page') . '.' . $type['pagetype'] . '.edit&id=' . $id;
								header('location: ' . $url);
								exit();
							}
						}
					}
				}

				$result['page'] = $page;
				$result['type'] = $page['type'];
			}
		}

		return $result;
	}

	/**
     * 获取页面类型
     * @param null $type
     * @return array|mixed
     */
	public function getPageType($type = NULL)
	{
		$pagetype = array(
			1  => array('name' => '自定义', 'pagetype' => 'diy', 'class' => ''),
			2  => array('name' => '商城首页', 'pagetype' => 'sys', 'class' => 'success'),
			3  => array('name' => '会员中心', 'pagetype' => 'sys', 'class' => 'primary'),
			4  => array('name' => '分销中心', 'pagetype' => 'plu', 'class' => 'warning'),
			5  => array('name' => '商品详情页', 'pagetype' => 'sys', 'class' => 'danger'),
			6  => array('name' => '积分商城', 'pagetype' => 'plu', 'class' => 'info'),
			7  => array('name' => '整点秒杀', 'pagetype' => 'plu', 'class' => 'danger'),
			8  => array('name' => '兑换中心', 'pagetype' => 'plu', 'class' => 'success'),
			9  => array('name' => '快速购买', 'pagetype' => 'sys', 'class' => 'warning'),
			99 => array('name' => '公用模块', 'pagetype' => 'mod', 'class' => '')
		);

		if (!empty($type)) {
			return $pagetype[$type];
		}

		return $pagetype;
	}

	/**
     * 设置分享信息
     * @param $page
     */
	public function setShare($page, $goods = array())
	{
		global $_W;
		global $_GPC;

		if (empty($page)) {
			return NULL;
		}

		$urlpage = 'diypage';
		$urlparm = array('id' => $page['id']);
		$_W['shopshare'] = array('title' => $_W['shopset']['shop']['name'], 'imgUrl' => tomedia($_W['shopset']['shop']['logo']), 'desc' => $_W['shopset']['shop']['description']);
		if ($page['type'] == 1 || $page['type'] == 2 || $page['type'] == 6 || $page['type'] == 7) {
			$_W['shopshare']['title'] = $page['data']['page']['title'];
			$_W['shopshare']['imgUrl'] = tomedia($page['data']['page']['icon']);
			$_W['shopshare']['desc'] = $page['data']['page']['desc'];
		}
		else if ($page['type'] == 5) {
			$urlpage = 'goods/detail';
			$urlparm = array('id' => $_GPC['id']);
			$_W['shopshare']['title'] = empty($goods['share_title']) ? $goods['title'] : $goods['share_title'];
			$_W['shopshare']['imgUrl'] = empty($goods['share_icon']) ? tomedia($goods['thumb']) : tomedia($goods['share_icon']);
			$_W['shopshare']['desc'] = empty($goods['description']) ? $goods['subtitle'] : $goods['description'];
		}
		else {
			if ($page['type'] == 3) {
				$_W['shopshare']['title'] = empty($page['data']['page']['title']) ? $_W['shopset']['shop']['name'] : $page['data']['page']['title'];
				$_W['shopshare']['imgUrl'] = empty($page['data']['page']['icon']) ? tomedia($_W['shopset']['shop']['logo']) : tomedia($page['data']['page']['icon']);
				$_W['shopshare']['desc'] = empty($page['data']['page']['desc']) ? $_W['shopset']['shop']['description'] : $page['data']['page']['desc'];
			}
		}

		if (p('commission')) {
			$set = p('commission')->getSet();

			if (!empty($set['level'])) {
				$member = m('member')->getMember($_W['openid']);
				if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
					$urlparm['mid'] = intval($member['id']);
				}
				else {
					if (!empty($_GPC['mid'])) {
						$urlparm['mid'] = intval($_GPC['mid']);
					}
				}
			}
		}

		$_W['shopshare']['link'] = mobileUrl($urlpage, $urlparm, true);
	}

	/**
     * 计算手机端订单数等
     * @param null $str
     * @param bool $pagetype
     */
	public function calculate($str = NULL, $pagetype = false)
	{
		global $_W;

		if (empty($str)) {
			return NULL;
		}

		$plugins = array();

		if (strexists($str, 'r=commission')) {
			$plugins['commission'] = false;
			$plugin_commissiom = p('commission');

			if ($plugin_commissiom) {
				$plugin_commissiom_set = $plugin_commissiom->getSet();

				if (!empty($plugin_commissiom_set['level'])) {
					$plugins['commission'] = true;
				}

				$member = p('commission')->getInfo($_W['openid'], array('total', 'ordercount0', 'ok', 'ordercount', 'wait', 'pay'));

				if (strexists($str, 'r=commission.withdraw')) {
					$this->commission['commission_total'] = $member['commission_total'];
				}

				if (strexists($str, 'r=commission.order')) {
					$this->commission['ordercount0'] = $member['ordercount0'];
				}

				if (strexists($str, 'r=commission.log')) {
					$this->commission['applycount'] = pdo_fetchcolumn('select count(id) from ' . tablename('ewei_shop_commission_apply') . ' where mid=:mid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));
				}

				if (strexists($str, 'r=commission.down')) {
					$level1 = $level2 = $level3 = 0;
					$level1 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $member['id'], ':uniacid' => $_W['uniacid']));
					if (2 <= $plugin_commissiom_set['level'] && 0 < count($member['level1_agentids'])) {
						$level2 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
					}

					if (3 <= $plugin_commissiom_set['level'] && 0 < count($member['level2_agentids'])) {
						$level3 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
					}

					$this->commission['downcount'] = $level1 + $level2 + $level3;
				}

				if (strexists($str, 'r=commission.qrcode')) {
					$plugins['commission_qrcode'] = false;

					if (!$plugin_commissiom_set['closed_qrcode']) {
						$plugins['commission_qrcode'] = true;
					}
				}

				if (strexists($str, 'r=commission.myshop.set')) {
					$plugins['commission_myshop_set'] = false;

					if (empty($plugin_commissiom_set['closemyshop'])) {
						$plugins['commission_myshop_set'] = true;
					}
				}

				if (strexists($str, 'r=commission.rank')) {
					$plugins['commission_rank_status'] = false;

					if (!empty($plugin_commissiom_set['rank']['status'])) {
						$plugins['commission_rank_status'] = true;
					}
				}
			}
		}

		if (strexists($str, 'r=creditshop')) {
			$plugins['creditshop'] = true;
			if ($pagetype == 3 || $pagetype == 4) {
				$plugin_creditshop = p('creditshop');

				if ($plugin_creditshop) {
					$plugin_creditshop_set = $plugin_creditshop->getSet();
					if ($pagetype == 3 && empty($plugin_creditshop_set['centeropen'])) {
						$plugins['creditshop'] = false;
					}
				}
			}
		}

		if (strexists($str, 'r=groups')) {
			$plugins['groups'] = true;
		}

		if (strexists($str, 'r=globonus')) {
			$plugins['globonus'] = false;
			$plugin_globonus = p('globonus');

			if ($plugin_globonus) {
				$plugin_globonus_set = $plugin_globonus->getSet();

				if (!empty($plugin_globonus_set['open'])) {
					$plugins['globonus'] = true;
				}

				if ($pagetype == 3) {
					if (empty($plugin_globonus_set['openmembercenter'])) {
						$plugins['globonus'] = false;
					}
				}
				else {
					if ($pagetype == 4) {
						if (!empty($plugin_globonus_set['closecommissioncenter'])) {
							$plugins['globonus'] = false;
						}
					}
				}
			}
		}

		if (strexists($str, 'r=abonus')) {
			$plugins['abonus'] = false;
			$plugin_abonus = p('abonus');

			if ($plugin_abonus) {
				$plugin_abonus_set = $plugin_abonus->getSet();

				if (!empty($plugin_abonus_set['open'])) {
					$plugins['abonus'] = true;
				}

				if ($pagetype == 3) {
					if (empty($plugin_abonus_set['openmembercenter'])) {
						$plugins['abonus'] = false;
					}
				}
				else {
					if ($pagetype == 4) {
						if (!empty($plugin_abonus_set['closecommissioncenter'])) {
							$plugins['abonus'] = false;
						}
					}
				}
			}
		}

		if (strexists($str, 'r=author')) {
			$plugins['author'] = false;
			$plugin_author = p('author');

			if ($plugin_author) {
				$plugin_author_set = $plugin_author->getSet();

				if (!empty($plugin_author_set['open'])) {
					$plugins['author'] = true;
				}

				if ($pagetype == 3) {
					if (empty($plugin_author_set['openmembercenter'])) {
						$plugins['author'] = false;
					}
				}
				else {
					if ($pagetype == 4) {
						if (!empty($plugin_author_set['closecommissioncenter'])) {
							$plugins['author'] = false;
						}
					}
				}
			}
		}

		if (strexists($str, 'r=sns')) {
			$plugins['sns'] = true;
		}

		if (strexists($str, 'r=sign')) {
			$plugins['sign'] = false;
			$plugin_sign = p('sign');

			if ($plugin_sign) {
				$plugin_sign_set = $plugin_sign->getSet();

				if (!empty($plugin_sign_set['isopen'])) {
					$plugins['sign'] = true;
				}

				if ($pagetype == 3 && empty($plugin_sign_set['iscenter'])) {
					$plugins['sign'] = false;
				}
			}
		}

		if (strexists($str, 'r=qa')) {
			$plugins['qa'] = true;

			if ($pagetype == 3) {
				$plugin_qa = p('qa');

				if ($plugin_qa) {
					$plugin_qa_set = $plugin_qa->getSet();

					if (empty($plugin_qa_set['showmember'])) {
						$plugins['qa'] = false;
					}
				}
			}
		}

		if (strexists($str, 'r=coupon')) {
			$plugins['coupon'] = false;
			$plugin_coupon_set = $_W['shopset']['coupon'];

			if (empty($plugin_coupon_set['closemember'])) {
				$plugins['coupon'] = true;
			}

			if ($pagetype == 3 && empty($plugin_coupon_set['closecenter'])) {
				$plugins['coupon'] = false;
			}
		}

		$this->plugin = $plugins;
		if (strexists($str, 'memberc') && p('commission')) {
			$member = p('commission')->getInfo($_W['openid'], array('total', 'ordercount0', 'ok', 'ordercount', 'wait', 'pay'));

			if (!empty($member)) {
				$member['commissionlevel'] = p('commission')->getLevel($_W['openid']);
				$member['up'] = false;

				if (!empty($member['agentid'])) {
					$member['up'] = m('member')->getMember($member['agentid']);
				}

				$this->commission['set'] = $commissionset = p('commission')->getSet();
				$member['commissionlevelname'] = empty($member['commissionlevel']) ? (empty($commissionset['levelname']) ? '普通等级' : $commissionset['levelname']) : $member['commissionlevel']['levelname'];
			}
		}
		else {
			$member = m('member')->getMember($_W['openid']);
			$level = m('member')->getLevel($_W['openid']);
			$member['levelname'] = $level['levelname'];
		}

		$this->member = $member;
		$ordernum = array();
		if (strexists($str, 'r=order') || strexists($str, 'r=member.cart') || strexists($str, 'r=coupon.my')) {
			$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
			$merch_plugin = p('merch');
			$merch_data = m('common')->getPluginset('merch');

			if (strexists($str, 'status=0')) {
				$condition = ' status=0 and paytype<>3 ';
				if (!$merch_plugin && !$merch_data['is_openmerch']) {
					$condition .= ' and isparent=0 ';
				}

				$ordernum['status0'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where ' . $condition . ' and openid=:openid and status=0 and (isparent=1 or (isparent=0 and parentid=0)) and uniacid=:uniacid and istrade=0 and userdeleted=0 limit 1', $params);
			}

			if (strexists($str, 'status=1')) {
				$condition = ' (status=1 or (status=0 and paytype=3)) and isparent=0 and istrade=0 and userdeleted=0 and refundid=0';
				if (!$merch_plugin && !$merch_data['is_openmerch']) {
					$condition .= ' and isparent=0 ';
				}

				$ordernum['status1'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where ' . $condition . ' and openid=:openid and uniacid=:uniacid limit 1', $params);
			}

			if (strexists($str, 'status=2')) {
				$condition = ' (status=2 or (status=1 and sendtype>0)) and refundid=0 and istrade=0';
				if (!$merch_plugin && !$merch_data['is_openmerch']) {
					$condition .= ' and isparent=0 ';
				}

				$ordernum['status2'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where ' . $condition . ' and openid=:openid and uniacid=:uniacid limit 1', $params);
			}

			if (strexists($str, 'status=4')) {
				$condition = ' refundstate=1 and istrade=0';
				if (!$merch_plugin && !$merch_data['is_openmerch']) {
					$condition .= ' and isparent=0 ';
				}

				$ordernum['status4'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where ' . $condition . ' and openid=:openid and uniacid=:uniacid limit 1', $params);
			}

			if (strexists($str, 'r=member.cart')) {
				$condition = ' deleted=0 ';
				if (!$merch_plugin && !$merch_data['is_openmerch']) {
					$condition .= ' and selected=1 ';
				}

				$ordernum['cartnum'] = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('ewei_shop_member_cart') . ' where ' . $condition . ' and uniacid=:uniacid and openid=:openid ', $params);
			}

			if (strexists($str, 'r=member.favorite')) {
				$condition = ' deleted=0 ';
				if (!$merch_plugin && !$merch_data['is_openmerch']) {
					$condition .= ' and `type`=1 ';
				}

				$ordernum['favorite'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member_favorite') . ' where ' . $condition . ' and uniacid=:uniacid and openid=:openid ', $params);
			}

			if (strexists($str, 'r=sale.coupon.my')) {
				$time = time();
				$sql = 'select count(*) from ' . tablename('ewei_shop_coupon_data') . ' d';
				$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
				$sql .= ' where d.openid=:openid and d.uniacid=:uniacid and  d.used=0 ';
				$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=' . $time . ' ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . ')) order by d.gettime desc';
				$ordernum['coupon'] = pdo_fetchcolumn($sql, array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
			}
		}

		$this->ordernum = $ordernum;
	}

	/**
     * 处理手机端订单数和入口链接等
     * @param null $type
     * @param null $str
     * @return bool|int|string|void
     */
	public function judge($type = NULL, $str = NULL)
	{
		if (empty($type) || empty($str)) {
			return NULL;
		}

		if ($type == 'url') {
			$plugin = $this->plugin;
			if (empty($plugin) || !is_array($plugin)) {
				return true;
			}

			if (strexists($str, '.')) {
				$str = str_replace('.', '_', $str);
			}

			foreach ($plugin as $key => $val) {
				if (strexists($str, $key) && !$val) {
					return false;
				}
			}

			return true;
		}

		if ($type == 'dot') {
			$order = $this->ordernum;

			if (strexists($str, 'r=order')) {
				if (strexists($str, 'status=0')) {
					return $order['status0'];
				}

				if (strexists($str, 'status=1')) {
					return $order['status1'];
				}

				if (strexists($str, 'status=2')) {
					return $order['status2'];
				}

				if (strexists($str, 'status=4')) {
					return $order['status4'];
				}
			}
			else {
				if (strexists($str, 'r=member.cart')) {
					return $order['cartnum'];
				}

				if (strexists($str, 'r=member.favorite')) {
					return $order['favorite'];
				}

				if (strexists($str, 'r=sale.coupon.my')) {
					return $order['coupon'];
				}
			}

			return 0;
		}

		if ($type == 'tipnum') {
			if (strexists($str, 'r=commission.withdraw')) {
				return $this->commission['commission_total'];
			}

			if (strexists($str, 'r=commission.order')) {
				return $this->commission['ordercount0'];
			}

			if (strexists($str, 'r=commission.log')) {
				return $this->commission['applycount'];
			}

			if (strexists($str, 'r=commission.down')) {
				return $this->commission['downcount'];
			}

			return '';
		}

		if ($type == 'tiptext') {
			if (strexists($str, 'r=commission.withdraw')) {
				return $this->commission['set']['texts']['yuan'];
			}

			if (strexists($str, 'r=commission.order') || strexists($str, 'r=commission.log')) {
				return '笔';
			}

			if (strexists($str, 'r=commission.down')) {
				return '人';
			}
		}
	}

	public function replace_quotes($str)
	{
		if (!empty($str)) {
			$str = str_replace('"', '', htmlspecialchars_decode($str, ENT_QUOTES));
			$str = str_replace('\'', '', htmlspecialchars_decode($str, ENT_QUOTES));
		}

		return $str;
	}

	/**
     * 处理手机端url
     * @param $str
     * @return mixed|void
     */
	public function url($str)
	{
		global $_W;
		global $_GPC;

		if (empty($str)) {
			return NULL;
		}

		$mid = intval($_GPC['mid']);

		if (!empty($_W['openid'])) {
			$myid = m('member')->getMid();

			if (!empty($myid)) {
				$member = pdo_fetch('select id,isagent,status from' . tablename('ewei_shop_member') . 'where id=' . $myid);
				if (!empty($member['isagent']) && !empty($member['status'])) {
					$mid = $myid;
				}
			}
		}

		if (empty($mid)) {
			return $str;
		}

		$str = preg_replace_callback('/"linkurl"\\:"([^\\\'" ]+)"/', function($matches) use($mid, $_W) {
			$preg = $matches[1];
			if (strexists($preg, 'mid=') || strexists($preg, 'tel:')) {
				return '"linkurl":"' . $preg . '"';
			}

			if (!strexists($preg, 'javascript')) {
				$preg2 = stripslashes($preg);
				$siteroot = stripslashes($_W['siteroot']);
				if ((strexists($preg2, 'http://') || strexists($preg2, 'https://')) && !strexists($preg2, $siteroot)) {
					return '"linkurl":"' . $preg . '"';
				}

				$preg = preg_replace('/(&|\\?)mid=[\\d+]/', '', $preg);

				if (strexists($preg, '?')) {
					$newpreg = $preg . ('&mid=' . $mid);
				}
				else {
					$newpreg = $preg . ('?mid=' . $mid);
				}

				return '"linkurl":"' . $newpreg . '"';
			}
		}, $str);
		return $str;
	}

	/**
     * 验证手机
     * @param int $id
     * @param int $type
     */
	protected function verifymobile($id = 0, $type = 0)
	{
		global $_GPC;
		if (empty($id) || empty($type)) {
			return NULL;
		}

		$diypagedata = m('common')->getPluginset('diypage');
		$page = $diypagedata['page'];

		if (empty($page)) {
			return NULL;
		}

		if (!empty($_GPC['preview'])) {
			return NULL;
		}

		if ($_GPC['r'] == 'diypage') {
			if ($type == 2 && $page['home'] == $id) {
				header('location: ' . mobileUrl(NULL, array('mid' => $_GPC['mid'])));
			}
			else {
				if ($type == 3 && $page['member'] == $id) {
					header('location: ' . mobileUrl('member', array('mid' => $_GPC['mid'])));
				}
				else {
					if ($type == 4 && $page['commission'] == $id) {
						header('location: ' . mobileUrl('commission', array('mid' => $_GPC['mid'])));
					}
				}
			}
		}
	}

	public function toArray($data)
	{
		if (empty($data) || !is_array($data)) {
			return array();
		}

		$newData = array();

		foreach ($data as $index => $item) {
			if (!empty($item) && is_array($item)) {
				$newData[] = $item;
			}
		}

		return $newData;
	}

	public function analysisMod($mod)
	{
		$newMod = array();

		if (is_array($mod)) {
			foreach ($mod as $itemid => $item) {
				$newid = explode('M', $itemid);
				$newid = $newid[1] + rand(1111, 9999);
				$newid = 'M' . $newid;
				$newMod[$newid] = $item;
			}
		}

		return $newMod;
	}

	public function getStartAdvList($id)
	{
		global $_W;
		$adv = pdo_fetch('SELECT * FROM' . tablename('ewei_shop_diypage_plu') . 'WHERE id=:id AND status=1 AND `type`=1 AND uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($adv)) {
			return NULL;
		}

		$adv['data'] = base64_decode($adv['data']);
		$adv['data'] = json_decode($adv['data'], true);
		return $adv['data'];
	}

	public function getStartAdv($id)
	{
		global $_W;
		global $_GPC;

		if (empty($id)) {
			return NULL;
		}

		$startadv = p('diypage')->getStartAdvList($id);

		if (empty($startadv)) {
			return NULL;
		}

		if (0 < $startadv['params']['showtype'] && 0 < $startadv['params']['showtime']) {
			$second = $startadv['params']['showtime'] * 60;
			$key = 'diyadv-' . $_W['uniacid'] . '-' . $id;
			$cookie = $_GPC[$key];
			$cookie = $cookie == NULL ? 0 : $cookie;
			if (time() < $cookie + $second && $cookie + 3 < time()) {
				return NULL;
			}

			isetcookie($key, time(), $second);
		}

		return $startadv;
	}

	public function getDanmuTime($item)
	{
		if (empty($item) || $item <= 0) {
			return '刚刚';
		}

		if (is_numeric($item)) {
			if ($item < 60) {
				return $item . '秒前';
			}

			$item = round($item / 60);

			if ($item < 60) {
				return $item . '分钟前';
			}

			$item = round($item / 60);

			if ($item < 24) {
				return $item . '小时前';
			}

			$item = round($item / 24);
			return $item . '天前';
		}

		if (strexists($item, '秒前') || strexists($item, '分钟') || strexists($item, '小时')) {
			return $item;
		}

		$item = intval($item);

		if ($item < 60) {
			return $item . '秒前';
		}

		return round($item / 60) . '分钟前';
	}

	/**
     * *商品详情页
     * @param int $pageid
     * @return array|bool
     */
	public function detailPage($pageid = 0)
	{
		global $_W;
		$set = $this->getSet();

		if (!empty($pageid)) {
			$page = $this->getPage($pageid, true);
		}

		if (empty($pageid) || !empty($pageid) && empty($page)) {
			if (!empty($set['page']['detail'])) {
				$page = $this->getPage($set['page']['detail'], true);
			}
		}

		if (empty($page) || !is_array($page) || !is_array($page['data']['items'])) {
			return false;
		}

		$pageitems = $page['data']['items'];
		$background = $page['data']['page']['background'];
		$followbar = $page['data']['page']['followbar'];
		$detail_tab = array();
		$detail_navbar = array();
		$detail_seckill = array();

		foreach ($pageitems as $itemid => $pageitem) {
			if ($pageitem['id'] == 'detail_tab') {
				$detail_tab = array('style' => $pageitem['style'], 'params' => $pageitem['params']);
				unset($pageitems[$itemid]);
			}
			else if ($pageitem['id'] == 'detail_navbar') {
				$detail_navbar = array('style' => $pageitem['style'], 'params' => $pageitem['params']);
				unset($pageitems[$itemid]);
			}
			else if ($pageitem['id'] == 'detail_comment') {
				$detail_comment = array('style' => $pageitem['style'], 'params' => $pageitem['params']);
			}
			else {
				if ($pageitem['id'] == 'detail_seckill') {
					$detail_seckill = array('style' => $pageitem['style'], 'params' => $pageitem['params']);
				}
			}
		}

		$navbar = array();

		if (!empty($detail_navbar)) {
			$btnlike = array('iconclass' => 'icon-like', 'icontext' => '关注', 'type' => 'like');
			$btnshop = array('iconclass' => 'icon-shop', 'icontext' => '店铺', 'type' => 'shop');
			$btncart = array('iconclass' => 'icon-cart', 'icontext' => '购物车', 'linkurl' => mobileUrl('member/cart'), 'type' => 'cart');

			if (intval($detail_navbar['params']['hidelike']) < 1) {
				if ($detail_navbar['params']['hidelike'] == 0) {
					$navbar[] = $btnlike;
				}
				else if ($detail_navbar['params']['hidelike'] == -1) {
					$navbar[] = $btnshop;
				}
				else if ($detail_navbar['params']['hidelike'] == -2) {
					$navbar[] = $btncart;
				}
				else {
					if ($detail_navbar['params']['hidelike'] == -3) {
						$navbar[] = array('iconclass' => empty($detail_navbar['params']['likeiconclass']) ? 'icon-like' : $detail_navbar['params']['likeiconclass'], 'icontext' => empty($detail_navbar['params']['liketext']) ? '关注' : $detail_navbar['params']['liketext'], 'linkurl' => $detail_navbar['params']['likelink']);
					}
				}
			}

			if (intval($detail_navbar['params']['hideshop']) < 1) {
				if ($detail_navbar['params']['hideshop'] == 0) {
					$navbar[] = $btnshop;
				}
				else if ($detail_navbar['params']['hideshop'] == -1) {
					$navbar[] = $btnlike;
				}
				else if ($detail_navbar['params']['hideshop'] == -2) {
					$navbar[] = $btncart;
				}
				else {
					if ($detail_navbar['params']['hideshop'] == -3) {
						$navbar[] = array('iconclass' => empty($detail_navbar['params']['shopiconclass']) ? 'icon-shop' : $detail_navbar['params']['shopiconclass'], 'icontext' => empty($detail_navbar['params']['shoptext']) ? '店铺' : $detail_navbar['params']['shoptext'], 'linkurl' => $detail_navbar['params']['shoplink']);
					}
				}
			}

			if (intval($detail_navbar['params']['hidecart']) < 1) {
				if ($detail_navbar['params']['hidecart'] == 0) {
					$navbar[] = $btncart;
				}
				else if ($detail_navbar['params']['hidecart'] == -1) {
					$navbar[] = $btnlike;
				}
				else if ($detail_navbar['params']['hidecart'] == -2) {
					$navbar[] = $btnshop;
				}
				else {
					if ($detail_navbar['params']['hidecart'] == -3) {
						$navbar[] = array('iconclass' => empty($detail_navbar['params']['carticonclass']) ? 'icon-cart' : $detail_navbar['params']['carticonclass'], 'icontext' => empty($detail_navbar['params']['carttext']) ? '购物车' : $detail_navbar['params']['carttext'], 'linkurl' => $detail_navbar['params']['cartlink']);
					}
				}
			}
		}

		return array('background' => $background, 'type' => $page['type'], 'followbar' => $followbar, 'diygotop' => $page['data']['page']['diygotop'], 'merch' => $page['merch'], 'tab' => $detail_tab, 'navbar' => $detail_navbar, 'diynavbar' => $navbar, 'comment' => $detail_comment, 'seckill' => $detail_seckill, 'diylayer' => $page['data']['page']['diylayer'], 'items' => $pageitems, 'diyadv' => $page['data']['page']['diyadv'], 'danmu' => $page['data']['page']['danmu']);
	}

	/**
     * *秒杀页面
     * @param int $pageid
     * @return array|bool
     */
	public function seckillPage($pageid = 0)
	{
		global $_W;
		$set = $this->getSet();

		if (!empty($pageid)) {
			$page = $this->getPage($pageid, true);
		}

		if (empty($pageid) || !empty($pageid) && empty($page)) {
			if (!empty($set['page']['seckill'])) {
				$page = $this->getPage($set['page']['seckill'], true);
			}
		}

		if (empty($page) || !is_array($page) || !is_array($page['data']['items'])) {
			return false;
		}

		$pageitems = $page['data']['items'];
		$seckill_list = array();

		foreach ($pageitems as $itemid => $pageitem) {
			if ($pageitem['id'] == 'seckill_list') {
				$seckill_list = $pageitem;
				break;
			}
		}

		return array('seckill_list' => $seckill_list, 'diylayer' => $page['data']['page']['diylayer'], 'diymenu' => $page['data']['page']['diymenu'], 'diyadv' => $page['data']['page']['diyadv'], 'items' => $pageitems, 'background_color' => $page['data']['page']['background'], 'seckill_style' => empty($page['data']['page']['seckill']['style']) ? 'style2' : $page['data']['page']['seckill']['style'], 'seckill_color' => empty($page['data']['page']['seckill']['color']) ? 'orange' : $page['data']['page']['seckill']['color']);
	}

	/**
     * *兑换中心页面
     * @param int $pageid
     */
	public function exchangePage($pageid = 0)
	{
		global $_W;
		$set = $this->getSet();

		if (!empty($pageid)) {
			$page = $this->getPage($pageid, true);
		}

		if (empty($pageid) || !empty($pageid) && empty($page)) {
			if (!empty($set['page']['exchange'])) {
				$page = $this->getPage($set['page']['exchange'], true);
			}
		}

		if (empty($page) || !is_array($page) || !is_array($page['data']['items'])) {
			return false;
		}

		$exchange_input = array();
		$pageitems = $page['data']['items'];

		if (!empty($pageitems)) {
			foreach ($pageitems as $pageitemid => $pageitem) {
				if ($pageitem['id'] == 'exchange_input') {
					$exchange_input = $pageitem;
				}
			}
		}

		return array('exchange_input' => $exchange_input, 'diyadv' => $page['data']['page']['diyadv'], 'items' => $pageitems);
	}
}

?>
