<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Share_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and uniacid=:uniacid';
		$params = array(':uniacid' => $uniacid);
		$type = trim($_GPC['type']);

		if ($type == 'ing') {
			$condition .= ' and (starttime <= ' . time() . ' and endtime >= ' . time() . ' and status = 1) or expiration = 0';
		}
		else if ($type == 'none') {
			$condition .= ' and starttime > ' . time() . ' and status = 1 ';
		}
		else {
			if ($type == 'end') {
				$condition .= ' and (endtime < ' . time() . ' or status = 0) ';
			}
		}

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND sharetitle LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$gifts = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_sendticket_share') . '
                    WHERE 1 ' . $condition . ' ORDER BY `order` DESC,id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $params);

		foreach ($gifts as $gk => $gv) {
			if ($gv['expiration'] == 0) {
				if ($gv['status'] == 0) {
					$gifts[$gk]['state'] = '已结束';
				}
				else {
					$gifts[$gk]['state'] = '进行中';
				}
			}
			else {
				if ($gv['expiration'] == 1) {
					if ($gv['starttime'] <= time() && time() <= $gv['endtime'] && $gv['status'] == 1) {
						$gifts[$gk]['state'] = '进行中';
					}
					else {
						if (time() < $gv['starttime'] && $gv['status'] == 1) {
							$gifts[$gk]['state'] = '未开始';
						}
						else {
							if ($gv['endtime'] < time() || $gv['status'] == 0) {
								$gifts[$gk]['state'] = '已结束';
							}
						}
					}
				}
			}
		}

		$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('ewei_shop_sendticket_share') . ' WHERE 1 ' . $condition . ' ', $params);
		$pager = pagination2($total, $pindex, $psize);
		include $this->template();
	}

	public function add()
	{
		$this->post();
	}

	public function edit()
	{
		$this->post();
	}

	protected function post()
	{
		global $_W;
		global $_GPC;
		$uniacid = intval($_W['uniacid']);
		$type = trim($_GPC['type']);
		$id = intval($_GPC['id']);

		if ($_W['ispost']) {
			if (empty($id)) {
				$rathersql = 'SELECT * FROM ' . tablename('ewei_shop_sendticket_share') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND enough = "' . $_GPC['enough'] . '"';
				$ratherlist = pdo_fetchall($rathersql);

				if (!empty($ratherlist)) {
					show_json(0, '满额发放的金额已存在，请填写其他金额！');
				}

				$activity = intval($_GPC['activity']);
			}
			else {
				$rathersql = 'SELECT * FROM ' . tablename('ewei_shop_sendticket_share') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND enough = "' . $_GPC['enough'] . '" AND id <> ' . intval($id);
				$ratherlist = pdo_fetchall($rathersql);

				if (!empty($ratherlist)) {
					show_json(0, '满额发放的金额已存在，请填写其他金额！');
				}

				$activity = intval($_GPC['activitytype']);
			}

			$data = array('uniacid' => $uniacid, 'order' => intval($_GPC['order']), 'enough' => floatval($_GPC['enough']), 'expiration' => intval($_GPC['expiration']), 'status' => intval($_GPC['status']), 'sharetitle' => trim($_GPC['share_title']), 'shareicon' => trim($_GPC['share_icon']), 'sharedesc' => trim($_GPC['share_desc']), 'createtime' => TIMESTAMP, 'issync' => intval($_GPC['issync']));

			if ($_GPC['issync'] == 0) {
				if (!empty($_GPC['couponid']) && is_array($_GPC['couponid'])) {
					if (3 < count($_GPC['couponid'])) {
						show_json(0, '分享人优惠券最多选择三种！');
					}

					$expcoupon = array();
					$newcpids = array();

					foreach ($_GPC['couponid'] as $ck => $cv) {
						if (intval($_GPC['couponnum' . $cv]) < 1 || 3 < intval($_GPC['couponnum' . $cv])) {
							show_json(0, '每种优惠券数量不能小于1或者大于3！');
						}
						else {
							$data['paycpnum' . ($ck + 1)] = $_GPC['couponnum' . $cv];
						}

						$csql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND id = ' . $cv;
						$clist = pdo_fetch($csql);

						if ($clist['timelimit'] == 1) {
							if ($clist['timeend'] < TIMESTAMP) {
								$expcoupon[$ck] = $clist['couponname'];
							}
							else {
								$newcpids[$ck] = $clist['id'];
							}
						}
						else {
							$newcpids[$ck] = $clist['id'];
						}
					}

					if (!empty($expcoupon) && is_array($expcoupon)) {
						foreach ($expcoupon as $exk => $exv) {
							show_json(0, '优惠券' . $expcoupon[$exk] . '已过期,请选择其他优惠券！');
						}
					}

					if (is_array($newcpids)) {
						if (count($newcpids) == 1) {
							foreach ($newcpids as $nk => $nv) {
								$data['paycpid' . ($nk + 1)] = $nv;
								$data['sharecpid' . ($nk + 1)] = $nv;
							}

							$data['paycpid2'] = NULL;
							$data['paycpid3'] = NULL;
							$data['sharecpid2'] = NULL;
							$data['sharecpid3'] = NULL;
						}
						else if (count($newcpids) == 2) {
							foreach ($newcpids as $nk => $nv) {
								$data['paycpid' . ($nk + 1)] = $nv;
								$data['sharecpid' . ($nk + 1)] = $nv;
							}

							$data['paycpid3'] = NULL;
							$data['sharecpid3'] = NULL;
						}
						else {
							if (count($newcpids) == 3) {
								foreach ($newcpids as $nk => $nv) {
									$data['paycpid' . ($nk + 1)] = $nv;
									$data['sharecpid' . ($nk + 1)] = $nv;
								}
							}
						}
					}
				}
				else {
					show_json(0, '请选择最少一张分享人优惠券！');
				}
			}
			else {
				if ($_GPC['issync'] == 1) {
					if (!empty($_GPC['couponid']) && is_array($_GPC['couponid'])) {
						if (3 < count($_GPC['couponid'])) {
							show_json(0, '分享人优惠券最多选择三种！');
						}

						$expcoupon = array();
						$newcpids = array();

						foreach ($_GPC['couponid'] as $ck => $cv) {
							if (intval($_GPC['couponnum' . $cv]) < 1 || 3 < intval($_GPC['couponnum' . $cv])) {
								show_json(0, '每种优惠券数量不能小于1或者大于3！');
							}
							else {
								$data['paycpnum' . ($ck + 1)] = $_GPC['couponnum' . $cv];
							}

							$csql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND id = ' . $cv;
							$clist = pdo_fetch($csql);

							if ($clist['timelimit'] == 1) {
								if ($clist['timeend'] < TIMESTAMP) {
									$expcoupon[$ck] = $clist['couponname'];
								}
								else {
									$newcpids[$ck] = $clist['id'];
								}
							}
							else {
								$newcpids[$ck] = $clist['id'];
							}
						}

						if (!empty($expcoupon) && is_array($expcoupon)) {
							foreach ($expcoupon as $exk => $exv) {
								show_json(0, '优惠券' . $expcoupon[$exk] . '已过期,请选择其他优惠券！');
							}
						}

						if (is_array($newcpids)) {
							if (count($newcpids) == 1) {
								foreach ($newcpids as $nk => $nv) {
									$data['paycpid' . ($nk + 1)] = $nv;
								}

								$data['paycpid2'] = NULL;
								$data['paycpid3'] = NULL;
							}
							else if (count($newcpids) == 2) {
								foreach ($newcpids as $nk => $nv) {
									$data['paycpid' . ($nk + 1)] = $nv;
								}

								$data['paycpid3'] = NULL;
							}
							else {
								if (count($newcpids) == 3) {
									foreach ($newcpids as $nk => $nv) {
										$data['paycpid' . ($nk + 1)] = $nv;
									}
								}
							}
						}
					}
					else {
						show_json(0, '请选择最少一张分享人优惠券！');
					}

					if (!empty($_GPC['couponids']) && is_array($_GPC['couponids'])) {
						if (3 < count($_GPC['couponids'])) {
							show_json(0, '被分享人优惠券最多选择三种！');
						}

						$expcoupon = array();
						$newcpids_p = array();

						foreach ($_GPC['couponids'] as $ck => $cv) {
							if (intval($_GPC['couponsnum' . $cv]) < 1 || 3 < intval($_GPC['couponsnum' . $cv])) {
								show_json(0, '每种优惠券数量不能小于1或者大于3！');
							}
							else {
								$data['sharecpnum' . ($ck + 1)] = $_GPC['couponsnum' . $cv];
							}

							$csql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . ' WHERE uniacid = ' . intval($_W['uniacid']) . ' AND id = ' . $cv;
							$clist = pdo_fetch($csql);

							if ($clist['timelimit'] == 1) {
								if ($clist['timeend'] < TIMESTAMP) {
									$expcoupon[$ck] = $clist['couponname'];
								}
								else {
									$newcpids_p[$ck] = $clist['id'];
								}
							}
							else {
								$newcpids_p[$ck] = $clist['id'];
							}
						}

						if (!empty($expcoupon) && is_array($expcoupon)) {
							foreach ($expcoupon as $exk => $exv) {
								show_json(0, '优惠券' . $expcoupon[$exk] . '已过期,请选择其他优惠券！');
							}
						}

						if (is_array($newcpids_p)) {
							if (count($newcpids_p) == 1) {
								foreach ($newcpids_p as $nk => $nv) {
									$data['sharecpid' . ($nk + 1)] = $nv;
								}

								$data['sharecpid2'] = NULL;
								$data['sharecpid3'] = NULL;
							}
							else if (count($newcpids_p) == 2) {
								foreach ($newcpids_p as $nk => $nv) {
									$data['sharecpid' . ($nk + 1)] = $nv;
								}

								$data['sharecpid3'] = NULL;
							}
							else {
								if (count($newcpids_p) == 3) {
									foreach ($newcpids_p as $nk => $nv) {
										$data['sharecpid' . ($nk + 1)] = $nv;
									}
								}
							}
						}
					}
					else {
						show_json(0, '请选择最少一张被分享人优惠券！');
					}
				}
			}

			if (intval($_GPC['expiration']) == 1) {
				$data['starttime'] = strtotime($_GPC['time']['start']);
				$data['endtime'] = strtotime($_GPC['time']['end']);
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_sendticket_share', $data, array('id' => $id));
				plog('sale.sendticket.share.edit', '编辑分享活动 ID: ' . $id . ' <br/>分享名称: ' . $data['sharetitle']);
			}
			else {
				pdo_insert('ewei_shop_sendticket_share', $data);
				$id = pdo_insertid();
				plog('sale.sendticket.share.add', '添加分享活动 ID: ' . $id . '  <br/>分享名称: ' . $data['sharetitle']);
			}

			show_json(1, array('url' => webUrl('sale/sendticket/share/edit', array('type' => $type, 'id' => $id))));
		}

		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sendticket_share') . ' WHERE uniacid = ' . $uniacid . ' and id = ' . $id . ' ');

		if (!empty($item['thumb'])) {
			$item = set_medias($item, array('thumb'));
		}

		if (!empty($item['starttime'])) {
			$starttime = $item['starttime'];
		}
		else {
			$starttime = TIMESTAMP;
		}

		if (!empty($item['endtime'])) {
			$endtime = $item['endtime'];
		}
		else {
			$endtime = TIMESTAMP + 60 * 60 * 24 * 30;
		}

		if ($item['issync'] == 1) {
			$paycpids = array();
			$paycpids = array();
			if (!empty($item['paycpid1']) && $item['paycpid1'] != 0) {
				$paycpids[] = $item['paycpid1'];
			}

			if (!empty($item['paycpid2']) && $item['paycpid2'] != 0) {
				$paycpids[] = $item['paycpid2'];
			}

			if (!empty($item['paycpid3']) && $item['paycpid3'] != 0) {
				$paycpids[] = $item['paycpid3'];
			}

			$coupons_pay = $this->querycoupon($paycpids);

			foreach ($coupons_pay as $cpk => $cpv) {
				$coupons_pay[$cpk]['couponnum' . $cpv['id']] = $item['paycpnum' . ($cpk + 1)];
			}

			$sharecpid = array();
			if (!empty($item['sharecpid1']) && $item['sharecpid1'] != 0) {
				$sharecpid[] = $item['sharecpid1'];
			}

			if (!empty($item['sharecpid2']) && $item['sharecpid2'] != 0) {
				$sharecpid[] = $item['sharecpid2'];
			}

			if (!empty($item['sharecpid3']) && $item['sharecpid3'] != 0) {
				$sharecpid[] = $item['sharecpid3'];
			}

			$coupons_share = $this->querycoupon($sharecpid);

			foreach ($coupons_share as $csk => $csv) {
				$coupons_share[$csk]['couponsnum' . $csv['id']] = $item['sharecpnum' . ($csk + 1)];
			}
		}
		else {
			if ($item['issync'] == 0) {
				$paycpids = array();
				if (!empty($item['paycpid1']) && $item['paycpid1'] != 0) {
					$paycpids[] = $item['paycpid1'];
				}

				if (!empty($item['paycpid2']) && $item['paycpid2'] != 0) {
					$paycpids[] = $item['paycpid2'];
				}

				if (!empty($item['paycpid3']) && $item['paycpid3'] != 0) {
					$paycpids[] = $item['paycpid3'];
				}

				$coupons_pay = $this->querycoupon($paycpids);

				foreach ($coupons_pay as $cpk => $cpv) {
					$coupons_pay[$cpk]['couponnum' . $cpv['id']] = $item['paycpnum' . ($cpk + 1)];
				}
			}
		}

		include $this->template();
	}

	public function status()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,sharetitle FROM ' . tablename('ewei_shop_sendticket_share') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_update('ewei_shop_sendticket_share', array('status' => intval($_GPC['status'])), array('id' => $item['id']));
			plog('sale.sendticket.share.edit', '修改分享状态<br/>ID: ' . $item['id'] . '<br/>分享名称: ' . $item['sharetitle'] . '<br/>状态: ' . $_GPC['status'] == 1 ? '开启' : '关闭');
		}

		show_json(1, array('url' => referer()));
	}

	public function delete1()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$items = pdo_fetchall('SELECT id,sharetitle FROM ' . tablename('ewei_shop_sendticket_share') . (' WHERE id in( ' . $id . ' ) AND uniacid=') . $_W['uniacid']);

		foreach ($items as $item) {
			pdo_delete('ewei_shop_sendticket_share', array('id' => $item['id']));
			plog('sale.sendticket.share.edit', '彻底删除活动<br/>ID: ' . $item['id'] . '<br/>活动名称: ' . $item['sharetitle']);
		}

		show_json(1, array('url' => referer()));
	}

	public function change()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			show_json(0, array('message' => '参数错误'));
		}

		$type = trim($_GPC['typechange']);
		$value = trim($_GPC['value']);

		if (!in_array($type, array('sharetitle', 'order', 'enough'))) {
			show_json(0, array('message' => '参数错误'));
		}

		$gift = pdo_fetch('select id from ' . tablename('ewei_shop_sendticket_share') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($gift)) {
			show_json(0, array('message' => '参数错误'));
		}

		pdo_update('ewei_shop_sendticket_share', array($type => $value), array('id' => $id));
		show_json(1);
	}

	public function querycoupon($couponid)
	{
		global $_W;
		global $_GPC;
		$cpinfo = array();

		foreach ($couponid as $ck => $cv) {
			$where = ' WHERE uniacid = :uniacid AND id = :id';
			$params = array(':uniacid' => intval($_W['uniacid']), ':id' => intval($cv));
			$cpsql = 'SELECT * FROM ' . tablename('ewei_shop_coupon') . $where;
			$cpinfo[$ck] = pdo_fetch($cpsql, $params);
		}

		return $cpinfo;
	}
}

?>
