<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

// sys
if(!defined('IN_IA')) { exit('Access Denied'); }

// 测试
function sl_store_test()
{
	global $_GPC, $_W;

	dump($_W);
	echo "<hr>";
	dump($_GPC);
}

// 商城-添加分销关系
/**
 * 商城-添加分销关系
 * @param  string $id_me     我的ID
 * @param  string $id_invite 邀请人ID
 * @return json             返回结果，成功code=0，失败code=1，msg=信息
 */
function sl_store_commission_post($id_me, $id_invite)
{
	global $_GPC, $_W;

	if (empty($id_me)) {
		$data_bak = [
			'code' => 1,
			'data' => '我的ID不存在',
		];
		return $data_bak;
	}
	if (empty($id_invite)) {
		$data_bak = [
			'code' => 1,
			'data' => '邀请人ID不存在',
		];
		return $data_bak;
	}

	// 是否已存在分销上级
	$where_1 = ['uniacid'=>$_W['uniacid'], 'id_user'=>$id_me, 'id_com_1'=>$id_invite];
	$com_1 = pdo_get(sl_table_name('commission'), $where_1);

	if ($com_1) {
		@putlog('添加分销关系', 'ID-'.$id_me.'-已存在分销上级');
		$data_bak = [
			'code' => 0,
			'data' => '',
		];
		return $data_bak;
	} else {
		// 获取分销设置
		if ($_W['slwl']['set']['set_commission']) {
			$set_commission = $_W['slwl']['set']['set_commission'];

			if ($set_commission['level'] <= 0) {
				@putlog('添加分销关系', '分销分销没有开启');
				$data_bak = [
					'code' => 0,
					'data' => '分销分销没有开启',
				];
				return $data_bak;
			}
		} else {
			@putlog('添加分销关系', '分销功能配置不存在');
			$data_bak = [
				'code' => 0,
				'data' => '分销功能配置不存在',
			];
			return $data_bak;
		}

		try {
			pdo_begin();
			$data = [];

			// 分销层级---1
			if ($set_commission['level'] >= 1) {
				$data = [
					'uniacid'=>$_W['uniacid'],
					'id_user'=>$id_me,
					'id_com_1'=>$id_invite,
				];
				// 是否需要审核
				// if ($set_commission['become_check'] == 0) {
				// 	$data['status'] = 0;
				// } else {
					$data['status'] = 1;
				// }
			}

			// 分销层级---2
			$com_2_ok = 0;
			if ($set_commission['level'] >= 2) {
				$where_2 = [
					'uniacid'=>$_W['uniacid'],
					'id_user'=>$id_invite,
				];
				$com_2 = pdo_get(sl_table_name('commission'), $where_2);

				if ($com_2) {
					$data['id_com_2'] = $com_2['id_com_1'];
					$com_2_ok = 1;
				}
			}

			// 分销层级---3
			if ($set_commission['level'] >= 3 && $com_2_ok) {
				$where_3 = [
					'uniacid'=>$_W['uniacid'],
					'id_user'=>$com_2['id_com_1'],
				];
				$com_3 = pdo_get(sl_table_name('commission'), $where_3);

				if ($com_2) {
					$data['id_com_3'] = $com_3['id_com_1'];
				}
			}

			$data['create_time'] = $_W['slwl']['datetime']['now'];
			$rst = pdo_insert(sl_table_name('commission') ,$data);

			if ($rst !== false) {
				pdo_commit();
				$data_bak = [
					'code' => 0,
					'data' => '成功',
				];
				return $data_bak;
			} else {
				pdo_rollback();
				$data_bak = [
					'code' => 1,
					'msg' => '失败',
				];
				return $data_bak;
			}
		} catch (Exception $e) {
			pdo_rollback();
			$data_bak = [
				'code' => 1,
				'msg' => '失败-'.$e->getMessage(),
			];
			return $data_bak;
		}
	}
}

// 商城-分销回扣记录
/**
 * 商城-分销回扣记录
 * @param string $id_order_user  提交订单用户ID
 * @param int    $id_order       订单ID
 * @param int    $money          订单金额，单位分
 * @param string $type           订单类型，score=课程，coach=私教，video=视频
 * @return json                  返回结果，成功code=0，失败code=1，msg=信息
 */
function sl_store_commission_rebate($id_order_user,$id_order,$money,$type)
{
	global $_GPC, $_W;

	$where_order_user = [
		'uniacid' => $_W['uniacid'],
		'id'      => $id_order_user,
	];
	$one_user = pdo_get(sl_table_name('users'),$where_order_user);

	if (empty($one_user)) {
		$data_putlog = [
			'id_order_user' => $id_order_user,
			'id_order'      => $id_order,
			'money'         => $money,
			'msg'           => '分销用户不存在',
		];
		@putlog('商城-分销回扣记录', $data_putlog);
		$data_bak = [
			'code' => 0,
			'data' => '用户不存在',
		];
		return $data_bak;
	}

	// 获取上级用户
	$where_com_user = [
		'uniacid' => $_W['uniacid'],
		'id_user' => $id_order_user,
	];
	$com_user = pdo_get(sl_table_name('commission'), $where_com_user);

	if (empty($com_user)) {
		$data_putlog = [
			'id_order_user' => $id_order_user,
			'id_order'      => $id_order,
			'money'         => $money,
			'msg'           => '获取分销用户不存在',
		];
		@putlog('商城-分销回扣记录', $data_putlog);
		$data_bak = [
			'code' => 0,
			'data' => '获取分销用户不存在',
		];
		return $data_bak;
	}

	if ($com_user['id_com_1'] == 0) {
		$data_putlog = [
			'id_order_user' => $id_order_user,
			'id_order'      => $id_order,
			'money'         => $money,
			'msg'           => '分销用户不存在上级',
		];
		@putlog('商城-分销回扣记录', $data_putlog);
		$data_bak = [
			'code' => 0,
			'data' => '分销用户不存在上级',
		];
		return $data_bak;
	}

	$id_me = $com_user['id_com_1']; // 分销上级用户ID

	// 获取分销设置
	if ($_W['slwl']['set']['set_commission']) {
		$set_commission = $_W['slwl']['set']['set_commission'];
	} else {
		@putlog('商城-分销回扣记录', '分销功能配置不存在');
		$data_bak = [
			'code' => 0,
			'data' => '',
		];
		return $data_bak;
	}
	$rebate = [];
	$rebate['set'] = $set_commission;
	$rebate['commission'] = $com_user;

	// 一个订单只添加一次分销记录
	$where_com_order = [
		'uniacid'=>$_W['uniacid'],
		'id_user'=>$com_user['id_com_1'],
		'id_order'=>$id_order,
	];
	$com_order = pdo_get(sl_table_name('commission_order'), $where_com_order);

	if ($com_order) {
		$data_bak = [
			'code' => 0,
			'data' => '',
		];
		return $data_bak;
	} else {
		if (empty($type)) {
			@putlog('商城-分销回扣记录', '订单类型为空');
		}
		$data = [
			'uniacid'       => $_W['uniacid'],
			'id_user'       => $id_me,
			'id_order'      => $id_order,
			'id_order_user' => $id_order_user,
			'money'         => $money,
			'type'          => $type,
			'rebate'        => json_encode($rebate,JSON_UNESCAPED_UNICODE),
			'create_time'   => $_W['slwl']['datetime']['now'],
		];
		$rst = pdo_insert(sl_table_name('commission_order'), $data);

		if ($rst !== false) {
			$data_bak = [
				'code' => 0,
				'data' => '',
			];
			return $data_bak;
		} else {
			$data_bak = [
				'code' => 1,
				'msg' => '记录失败',
			];
			return $data_bak;
		}
	}
}

// 商城-结算
function sl_store_commission_settle()
{
	global $_GPC, $_W;

	// 获取分销设置
	if ($_W['slwl']['set']['set_commission']) {
		$set_commission = $_W['slwl']['set']['set_commission'];
	} else {
		@putlog('添加分销关系', '分销功能配置不存在');
		$data_bak = [
			'code' => 0,
			'data' => '',
		];
		return $data_bak;
	}

	$day_settle = 0; // 结算天数
	$day_settle = $set_commission['settledays']; // 系统配置的天数

	$day = new DateTime();
	$timestamp = strtotime('-'.$day_settle.' day');
	$day->setTimestamp($timestamp);
	$datetime = $day->format('Y-m-d H:i:s');

	// 查询100条记录
	$where_order = [
		'uniacid'       => $_W['uniacid'],
		'create_time <' => $datetime,
		'status'        => 0,
	];
	$limit = [100];
	$list_commission_order = pdo_getall(sl_table_name('commission_order'),$where_order,'','','',$limit);

	if ($list_commission_order) {
		foreach ($list_commission_order as $key => $value) {
			$value['rebate'] = json_decode($value['rebate'], TRUE);

			if ($value['rebate']) {
				$money_order = $value['money']; // 订单金额

				// 已开启分销
				if ($value['rebate']['set']['level'] > 0) {
					// 计算返佣金额.start
					$brokerage_com_1 = 0;
					if ($value['rebate']['set']['commission1_rate']) {
						$brokerage_com_1 = $value['money'] * $value['rebate']['set']['commission1_rate'] / 100;
					} else if ($value['rebate']['set']['commission1_fixed']) {
						$brokerage_com_1 = $value['rebate']['set']['commission1_fixed'];
					}

					// 更新用户余额.end
					if ($brokerage_com_1 == 0) {
						@putlog('结算一级分销金额', '返佣金额配置为 0');
					} else {
						// 更新用户余额
						$rst_1 = pdo_update(sl_table_name('users'),
							['balance +='=>$brokerage_com_1],
							['id'=>$value['rebate']['commission']['id_com_1']]
						);

						// 如果为真用户存在
						if ($rst_1) {
							// 添加返佣日志.start
							$data_com_1_settle_log = [
								'uniacid'         => $_W['uniacid'],
								'id_user'         => $value['rebate']['commission']['id_com_1'],
								'money_order'     => $money_order,
								'money_brokerage' => $brokerage_com_1,
								'id_order'        => $value['id_order'],
								'create_time'     => $_W['slwl']['datetime']['now'],
							];
							pdo_insert(sl_table_name('commission_settle_log'), $data_com_1_settle_log);
							// 添加返佣日志.end

							// 更新返佣金额
							$rst = pdo_update(sl_table_name('commission_brokerage'),
								['money +='=>$brokerage_com_1,'money_total +='=>$brokerage_com_1],
								['uniacid'=>$_W['uniacid'],'id_user'=>$value['rebate']['commission']['id_com_1']]
							);
						}
					}
				}

				// 二级分销
				if ($value['rebate']['set']['level'] > 1) {
					// 计算返佣金额.start
					$brokerage_com_2 = 0;
					if ($value['rebate']['set']['commission2_rate']) {
						$brokerage_com_2 = $value['money'] * $value['rebate']['set']['commission2_rate'] / 100;
					} else if ($value['rebate']['set']['commission2_fixed']) {
						$brokerage_com_2 = $value['rebate']['set']['commission2_fixed'];
					}
					// 计算返佣金额.end

					if ($brokerage_com_2 == 0) {
						@putlog('结算二级分销金额', '返佣金额配置为 0');
					} else {
						// 更新用户余额
						$rst_2 = pdo_update(sl_table_name('users'),
							['balance +='=>$brokerage_com_2],
							['id'=>$value['rebate']['commission']['id_com_2']]
						);

						// 如果为真用户存在
						if ($rst_2) {
							// 添加返佣日志.start
							$data_com_2_settle_log = [
								'uniacid'         => $_W['uniacid'],
								'id_user'         => $value['rebate']['commission']['id_com_2'],
								'money_order'     => $money_order,
								'money_brokerage' => $brokerage_com_2,
								'id_order'        => $value['id_order'],
								'create_time'     => $_W['slwl']['datetime']['now'],
							];
							pdo_insert(sl_table_name('commission_settle_log'), $data_com_2_settle_log);
							// 添加返佣日志.end

							// 更新返佣金额
							pdo_update(sl_table_name('commission_brokerage'),
								['money +='=>$brokerage_com_2,'money_total +='=>$brokerage_com_2],
								['uniacid'=>$_W['uniacid'],'id_user'=>$value['rebate']['commission']['id_com_2']]
							);
						}
					}
				}
				// 三级分销
				if ($value['rebate']['set']['level'] > 2) {
					// 计算返佣金额.start
					$brokerage_com_3 = 0;
					if ($value['rebate']['set']['commission3_rate']) {
						$brokerage_com_3 = $value['money'] * $value['rebate']['set']['commission3_rate'] / 100;
					} else if ($value['rebate']['set']['commission3_fixed']) {
						$brokerage_com_3 = $value['rebate']['set']['commission3_fixed'];
					}
					// 计算返佣金额.end

					if ($brokerage_com_1 == 0) {
						@putlog('结算三级分销金额', '返佣金额配置为 0');
					} else {
						// 更新用户余额
						$rst_3 = pdo_update(sl_table_name('users'),
							['balance +='=>$brokerage_com_3],
							['id'=>$value['rebate']['commission']['id_com_3']]
						);

						// 如果为真用户存在
						if ($rst_3) {
							// 添加返佣日志.start
							$data_com_3_settle_log = [
								'uniacid'         => $_W['uniacid'],
								'id_user'         => $value['rebate']['commission']['id_com_3'],
								'money_order'     => $money_order,
								'money_brokerage' => $brokerage_com_3,
								'id_order'        => $value['id_order'],
								'create_time'     => $_W['slwl']['datetime']['now'],
							];
							pdo_insert(sl_table_name('commission_settle_log'), $data_com_3_settle_log);
							// 添加返佣日志.end

							// 更新返佣金额
							pdo_update(sl_table_name('commission_brokerage'),
								['money +='=>$brokerage_com_3,'money_total +='=>$brokerage_com_3],
								['uniacid'=>$_W['uniacid'],'id_user'=>$value['rebate']['commission']['id_com_3']]
							);
						}
					}
				}

				$rst = pdo_update(sl_table_name('commission_order'),
					['status'=>1],
					['uniacid'=>$_W['uniacid'],'id_order_user'=>$value['id_order_user'],'id_order'=>$value['id_order']]
				);
			}
		}

		$data_bak = [
			'code' => 0,
			'data' => 'ok',
		];
		return $data_bak;
	} else {
		$data_bak = [
			'code' => 0,
			'data' => '没有找到订单',
		];
		return $data_bak;
	}
}



/** 接口部分 ====================================================================== */

// 分销中心
function sl_store_commission_center()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']); // uid
	$user = pdo_get(sl_table_name('users'), ['id'=>$uid]);
	if (empty($user)) {
		$data_bak = [
			'distributor' => 0,
		];
		return result(0, 'ok', $data_bak);
	}

	$one = [];
	$nicename = sl_nickname($user['nicename']);
	$one['name'] = $user['real_name']?$user['real_name']:$nicename;
	$one['id'] = $uid;

	// 邀请人
	$where_com = [
		'uniacid' => $_W['uniacid'],
		'id_user' => $one['id'],
	];
	$one_com = pdo_get(sl_table_name('commission'), $where_com);

	// dump($one_com);
	// exit;

	if ($one_com && $one_com['id_com_1'] > 0) {
		// 获取上级
		$where_user = [
			'uniacid' => $_W['uniacid'],
			'id'      => $one_com['id_com_1'],
		];
		$one_user = pdo_get(sl_table_name('users'), $where_user);

		$nicename_superior = json_decode($one_user['nicename']);
		$name_superior = $one_user['real_name']?$one_user['real_name']:$nicename_superior;
		$one['superior'] = [
			'name'   => $name_superior,
			'mobile' => $one_user['mobile'],
			'avatar' => $one_user['avatar'],
		];
	} else {
		$one['superior'] = '';
	}


	// 获取提现佣金
	$where_com_brokerage = [
		'uniacid'=> $_W['uniacid'],
		'id_user'=> $one['id'],
	];
	$one_com_brokerage = pdo_get(sl_table_name('commission_brokerage'), $where_com_brokerage);
	if ($one_com_brokerage) {
		// 佣金-余额
		$one['money'] = number_format($one_com_brokerage['money'] / 100, 2);
		// 佣金-全部佣金
		$one['money_total'] = number_format($one_com_brokerage['money_total'] / 100, 2);
		// 佣金-成功提现
		$one['money_withdraw'] = number_format($one_com_brokerage['money_withdraw'] / 100, 2);
	}

	// 佣金明细-总笔数
	$where_commission_order = [
		'uniacid'=>$_W['uniacid'],
		'id_user'=>$uid,
	];
	$count_commission_order = pdo_count(sl_table_name('commission_order'), $where_commission_order);
	$one['brokerage_count'] = $count_commission_order;

	// 佣金提现-总笔数
	$where_com_withdraw_log = [
		'uniacid'=>$_W['uniacid'],
		'id_user'=>$uid,
	];
	$count_brokerage_withdraw = pdo_count(sl_table_name('commission_brokerage_log'), $where_com_withdraw_log);
	$one['withdraw_count'] = $count_brokerage_withdraw;

	// 我的下线
	$condition_my_downline = " AND uniacid=:uniacid AND (id_com_1=:id_com OR id_com_2=:id_com OR id_com_3=:id_com) ";
	$params_my_downline = array(':uniacid' => $_W['uniacid'], ':id_com'=>$uid);
	$sql_my_downline = "SELECT COUNT(*) FROM " . sl_table_name('commission', TRUE). ' WHERE 1 ' . $condition_my_downline;
	$count_my_downline = pdo_fetchcolumn($sql_my_downline, $params_my_downline);
	$one['my_downline_count'] = $count_my_downline;

	$one['distributor'] = 1;

	return result(0, 'ok', $one);
}

// 分销佣金-汇总
function sl_store_commission_brokerage()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']); // uid
	$user = pdo_get(sl_table_name('users'), ['id'=>$uid]);
	if (empty($user)) {
		return result(1, '用户不存在');
	}

	$one = [];
	$nicename = sl_nickname($user['nicename']);
	$one['name'] = $user['real_name']?$user['real_name']:$nicename;
	$one['id'] = $uid;

	// 获取提现佣金
	$where_com_brokerage = [
		'uniacid' => $_W['uniacid'],
		'id_user' => $uid,
	];
	$one_com_brokerage = pdo_get(sl_table_name('commission_brokerage'), $where_com_brokerage);

	if ($one_com_brokerage) {
		// 佣金-余额
		$one['money'] = number_format($one_com_brokerage['money'] / 100, 2);
		// 佣金-全部佣金
		$one['money_total'] = number_format($one_com_brokerage['money_total'] / 100, 2);
		// 佣金-成功提现
		$one['money_withdraw'] = number_format($one_com_brokerage['money_withdraw'] / 100, 2);
	}

	// 佣金-申请未处理的佣金-已申请-申请中
	$where_brokerage_app = [
		'uniacid' => $_W['uniacid'],
		'id_user' => $uid,
		'status'  => 0,
	];
	$count_brokerage_app = pdo_getcolumn(sl_table_name('commission_brokerage_log'), $where_brokerage_app, 'SUM(money)');
	$one['application_ing'] = number_format($count_brokerage_app / 100, 2);

	// 佣金-待打款
	$where_wait_for_money = [
		'uniacid' => $_W['uniacid'],
		'id_user' => $uid,
		'status'  => 1,
	];
	$count_wait_for_money = pdo_getcolumn(sl_table_name('commission_brokerage_log'), $where_wait_for_money, 'SUM(money)');
	$one['wait_for_money'] = number_format($count_wait_for_money / 100, 2);

	// 佣金-未结算
	$where_com_order = [
		'uniacid' => $_W['uniacid'],
		'id_user' => $uid,
		'status'  => 0,
	];
	$count_com_order = pdo_getcolumn(sl_table_name('commission_order'), $where_com_order, 'SUM(money)');
	$one['brokerage_unsettlement'] = number_format($count_com_order / 100, 2);

	// 最小提现金额
	if ($_W['slwl']['set']['set_commission']) {
		$one_set = $_W['slwl']['set']['set_commission'];
		$one_set['withdraw_min'] = $one_set['withdraw_min'] / 100;
		$one['withdraw_min'] = number_format($one_set['withdraw_min'], 2);
	}

	return result(0, 'OK', $one);
}

// 分销佣金-明细
function sl_store_commission_brokerage_log()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']); // uid
	$type = $_GPC['type']; // 类型

	$user = pdo_get(sl_table_name('users'), ['id'=>$uid]);
	if (empty($user)) {
		return result(1, '用户不存在');
	}

	$tb_com_order = sl_table_name('commission_order', TRUE);
	$tb_order = sl_table_name('store_order', TRUE);

	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$condition = " AND co.uniacid=:uniacid AND co.id_user=:id_user ";
	if ($type == '1') {
		$condition .= " AND o.status = '1' ";
	}
	if ($type == '2') {
		$condition .= " AND o.status = '2' ";
	}
	if ($type == '3') {
		$condition .= " AND o.status = '4' ";
	}
	$params = [':uniacid' => $_W['uniacid'], ':id_user'=>$uid];
	$field = " co.id,co.money,co.create_time,co.type, ";
	$field .= " o.id AS id_order,o.ordersn,o.price,o.goods,o.status,o.from_user ";
	$sql = "SELECT {$field} FROM {$tb_com_order} AS co ";
	$sql .= " INNER JOIN {$tb_order} AS o ON co.id_order = o.id ";
	$sql .= " WHERE 1 {$condition} ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$list = pdo_fetchall($sql, $params);

	if ($list) {
		$ids = sl_array_column($list, 'from_user');

		if ($ids) {
			$where_users = [
				'uniacid' => $_W['uniacid'],
				'id IN' => $ids,
			];
			$field_users = ['id', 'nicename', 'real_name', 'mobile', 'avatar'];
			$list_users = pdo_getall(sl_table_name('users'), $where_users, $field_users);

			if ($list_users) {
				foreach ($list as $key => $value) {
					foreach ($list_users as $k => $v) {
						if ($value['from_user'] == $v['id']) {
							$v['nicename'] = sl_nickname($v['nicename']);
							$list[$key]['user'] = $v;
							break;
						}
					}
				}
			}
		}

		// 获取结算金额
		$ids_settle_log = sl_array_column($list, 'id_order');
		$where_settle_log = [
			'uniacid'=>$_W['uniacid'],
			'id_order IN'=>$ids_settle_log,
		];
		$list_settle_log = pdo_getall(sl_table_name('commission_settle_log'), $where_settle_log);

		foreach ($list as $key => $value) {
			$list[$key]['goods'] = json_decode($value['goods'],TRUE);
			$list[$key]['money_format'] = number_format($value['money'] / 100, 2);
			$list[$key]['price_format'] = number_format($value['price'] / 100, 2);

			if ($list_settle_log) {
				foreach ($list_settle_log as $k => $v) {
					if ($value['id_order'] == $v['id_order']) {
						$list[$key]['money_order'] = number_format($v['money_order'] / 100, 2);
						$list[$key]['money_brokerage'] = number_format($v['money_brokerage'] / 100, 2);
						break;
					}
				}
			} else {
				$list[$key]['money_order'] = '0.00';
				$list[$key]['money_brokerage'] = '0.00';
			}
		}
	}

	return result(0, 'OK', $list);
}

// 提现-明细
function sl_store_commission_withdraw_log()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']); // uid
	$type = $_GPC['type']; // 类型

	$user = pdo_get(sl_table_name('users'), ['id'=>$uid]);
	if (empty($user)) {
		return result(1, '用户不存在');
	}

	$pindex = max(1, intval($_GPC['page']));
	$where = [
		'uniacid'=>$_W['uniacid'],
		'id_user' =>$uid,
	];
	if ($type == '0') {
		$where['status'] = 0;
	}
	if ($type == '1') {
		$where['status'] = 1;
	}
	if ($type == '3') {
		$where['status'] = 3;
	}
	if ($type == '4') {
		$where['status IN'] = [2,4];
	}
	$order_by = ['id DESC'];
	$limit = [$pindex, 10];
	$list = pdo_getall(sl_table_name('commission_brokerage_log'), $where, '', '', $order_by, $limit);

	if ($list) {
		foreach ($list as $key => $value) {
			$list[$key]['money_format'] = number_format($value['money'] / 100, 2);
			$list[$key]['timestamp'] = strtotime($value['create_time']);
		}
	}

	return result(0, 'OK', $list);
}

// 我的下线列表
function sl_store_commission_my_downline()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']); // uid
	$type = $_GPC['id']; // 类型

	$user = pdo_get(sl_table_name('users'), ['id'=>$uid]);
	if (empty($user)) {
		return result(1, '用户不存在');
	}

	// 分销关系
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$condition = " AND uniacid=:uniacid AND (id_com_1=:id_com OR id_com_2=:id_com OR id_com_3=:id_com) ";
	$params = [':uniacid'=>$_W['uniacid'], ':id_com'=>$uid];
	$sql = "SELECT * FROM " . sl_table_name('commission', TRUE). ' WHERE 1 ' . $condition;
	$sql .= " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
	$list_com = pdo_fetchall($sql, $params);

	$list_my_downline = [];
	if ($list_com) {
		$ids_user = sl_array_column($list_com, 'id_user');

		// 分销用户
		$where_user = [
			'uniacid'=>$_W['uniacid'],
			'id IN' =>$ids_user,
		];
		$order_by_user = ['id DESC'];
		$field = ['nicename','avatar','real_name','mobile'];
		$list_user = pdo_getall(sl_table_name('users'), $where_user, $field, '', $order_by_user);

		if ($list_user) {
			foreach ($list_user as $key => $value) {
				$nicename = is_json($value['nicename'])?json_decode($value['nicename']):$value['real_name'];
				$list_user[$key]['nicename'] = $nicename;
			}

			$list_my_downline = $list_user;
		}
	}

	return result(0, 'OK', $list_my_downline);
}

// 提现-post
function sl_store_withdraw_post()
{
	global $_GPC, $_W;

	$uid = intval($_GPC['uid']); // uid
	$money = ''; // 金额

	$param_json = $_GPC['__input']; // 参数
	if ($param_json) {
		$money = isset($param_json['money']) ? trim($param_json['money']) : '';
	}

	$user = pdo_get(sl_table_name('users'), ['id'=>$uid]);
	if (empty($user)) {
		return result(1, '用户不存在');
	}

	$balance = $user['balance'] * 100;
	$fee = $money * 100;
	if ($balance < $money) {
		return result(1, '提现金额不能大于可提现金额');
	}

	if ($_W['slwl']['set']['set_commission']) {
		$set_commission = $_W['slwl']['set']['set_commission'];

		if (!isset($set_commission['withdraw_min'])) {
			return result(1, '提现最小金额没有配置');
		}

		if (!isset($set_commission['withdraw_min']) || $fee < $set_commission['withdraw_min']) {
			return result(1, '提现金额不能小于最小可提现金额');
		}
	}

	pdo_begin();

	$data = [
		'uniacid'     => $_W['uniacid'],
		'id_user'     => $uid,
		'money'       => $fee,
		'status'      => 0,
		'create_time' => $_W['slwl']['datetime']['now'],
	];
	$rst_1 = pdo_insert(sl_table_name('commission_brokerage_log') ,$data);

	$rst_2 = pdo_update(sl_table_name('commission_brokerage'),
		['money -='=>$fee],
		['uniacid'=>$_W['uniacid'],'id_user'=>$uid]
	);

	if ($rst_1 !== false && $rst_2 !== false) {
		pdo_commit();
		return result(0, 'OK');
	} else {
		pdo_rollback();
		return result(1, 'ERR');
	}
}


















