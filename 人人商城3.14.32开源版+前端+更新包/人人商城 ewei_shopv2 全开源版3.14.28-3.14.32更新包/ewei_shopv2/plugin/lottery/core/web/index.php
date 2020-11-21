<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and uniacid=:uniacid and `is_delete`=0 ';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND `lottery_title` LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_lottery') . (' WHERE 1 ' . $condition . ' ORDER BY addtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery') . (' where 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);

		foreach ($list as $key => $value) {
			$member_total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_lottery_join') . ' where lottery_id=:lottery_id ', array(':lottery_id' => $value['lottery_id']));
			$list[$key]['viewcount'] = $member_total;
		}

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
		$id = intval($_GPC['id']);
		$type = intval($_GPC['lottery_type']);

		if (p('task')) {
			$condition = ' AND `status`=1 AND is_delete = 0 AND uniacid= ' . $_W['uniacid'];
			$tasklist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_task_poster') . (' WHERE 1 ' . $condition . ' ORDER BY createtime desc LIMIT 15'));
		}

		if ($id) {
			$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_lottery') . ' WHERE lottery_id =:lottery_id and uniacid=:uniacid limit 1', array(':lottery_id' => $id, ':uniacid' => $_W['uniacid']));
			$type = intval($item['lottery_type']);
			$reward = unserialize($item['lottery_data']);
		}

		if (empty($item['start_time']) || empty($item['end_time'])) {
			$starttime = time();
			$endtime = strtotime(date('Y-m-d H:i', $starttime) . '+30 days');
		}
		else {
			$starttime = $item['start_time'];
			$endtime = $item['end_time'];
		}

		if (empty($item['award_start']) || empty($item['award_end'])) {
			$award_starttime = time();
			$award_endtime = strtotime(date('Y-m-d H:i', $award_starttime) . '+30 days');
		}
		else {
			$award_starttime = $item['award_start'];
			$award_endtime = $item['award_end'];
		}

		if ($_W['ispost']) {
			$itemCount = count(json_decode(htmlspecialchars_decode(trim($_GPC['reward_data']))));
			if (intval($_GPC['lottery_type']) == 3 && $itemCount != 8 && !empty($itemCount)) {
				show_json(0, '九宫格奖项必须为8个');
			}
			else {
				if (intval($_GPC['lottery_type']) == 1 && $itemCount < 5 && !empty($itemCount)) {
					show_json(0, '大转盘奖项不得少于5个');
				}
			}

			$data = array();
			$data['uniacid'] = $_W['uniacid'];
			$data['lottery_title'] = $_GPC['lottery_title'];
			$data['lottery_icon'] = trim($_GPC['lottery_icon']);
			$data['lottery_banner'] = trim($_GPC['lottery_banner']);
			$data['lottery_days'] = intval($_GPC['lottery_days']) * 24 * 3600;
			$data['lottery_cannot'] = trim(str_replace(array('
', '
', '
'), '', $_GPC['lottery_cannot']));
			$data['start_time'] = strtotime($_GPC['time']['start']);
			$data['end_time'] = strtotime($_GPC['time']['end']);
			$data['is_goods'] = $_GPC['is_goods'];
			$data['lottery_type'] = intval($_GPC['lottery_type']);
			$data['addtime'] = time();
			$data['award_start'] = strtotime($_GPC['award_time']['start']);
			$data['award_end'] = strtotime($_GPC['award_time']['end']);
			$taskTypeIsExist = intval($this->taskTypeIsExist(intval($_GPC['task_type']), $id));

			if (!empty($taskTypeIsExist)) {
				show_json(0, '该场景已经存在，不能给一个场景添加两个游戏');
			}

			if ($_GPC['task_type'] == 1) {
				$pay_money = $_GPC['pay_money'];
				$pay_num = $_GPC['pay_num'];
				$pay_type = $_GPC['pay_type'];
				if (empty($pay_type)) {
                    show_json(0, "请选择消费场景");
                } else {
                    if (count($pay_type) == 2) {
                        $pay_type = 0;
                    } else {
                        if ($pay_type[0] == "1") {
                            $pay_type = 1;
                        } else {
                            $pay_type = 2;
                        }
                    }
                }
				$data['task_type'] = 1;
				$data['task_data'] = array('pay_money' => floatval($pay_money), 'pay_num' => intval($pay_num), 'pay_type' => $pay_type);
			}
			else if ($_GPC['task_type'] == 2) {
				$sign_day = intval($_GPC['sign_day']);
				$sign_num = intval($_GPC['sign_num']);
				$data['task_type'] = 2;
				$data['task_data'] = array('sign_day' => $sign_day, 'sign_num' => $sign_num);
			}
			else if ($_GPC['task_type'] == 3) {
				$poster_num = intval($_GPC['poster_num']);
				$poster_id = intval($_GPC['poster_id']);
				$data['task_type'] = 3;
				$data['task_data'] = array('poster_num' => $poster_num, 'poster_id' => $poster_id);
			}
			else {
				if ($_GPC['task_type'] == 4) {
					$other_content = $_GPC['other_content'];
					$other_num = intval($_GPC['other_num']);
					$data['task_type'] = 4;
					$data['task_data'] = array('other_content' => $other_content, 'other_num' => $other_num);
				}
			}

			$data['task_data'] = serialize($data['task_data']);
			$reward = array();
			$rec_reward = htmlspecialchars_decode($_GPC['reward_data']);
			$rec_reward = json_decode($rec_reward, 1);
			$rec_data = array();

			if (!empty($rec_reward)) {
				foreach ($rec_reward as $val) {
					$rank = intval($val['rank']);

					if ($val['type'] == 1) {
						$rec_data[$rank]['credit'] = intval($val['num']);
					}
					else if ($val['type'] == 2) {
						$rec_data[$rank]['money']['num'] = intval($val['num']);
						$rec_data[$rank]['money']['total'] = intval($val['total']);
						$rec_data[$rank]['money']['type'] = intval($val['moneytype']);
					}
					else if ($val['type'] == 3) {
						$rec_data[$rank]['bribery']['total'] = intval($val['total']);
						$rec_data[$rank]['bribery']['num'] = intval($val['num']);
					}
					else if ($val['type'] == 4) {
						$goods_id = intval($val['goods_id']);
						$goods_name = trim($val['goods_name']);
						$goods_img = trim($val['img']);
						$goods_price = floatval($val['goods_price']);
						$goods_total = intval($val['goods_total']);
						$goods_totalcount = intval($val['goods_totalcount']);
						$goods_spec = intval($val['goods_spec']);
						$goods_specname = trim($val['goods_specname']);

						if (isset($rec_data[$rank]['goods'][$goods_id]['spec'])) {
							$oldspec = $rec_data[$rank]['goods'][$goods_id]['spec'];
						}
						else {
							$oldspec = array();
						}

						$rec_data[$rank]['goods'][$goods_id] = array('id' => $goods_id, 'img' => $goods_img, 'title' => $goods_name, 'marketprice' => $goods_price, 'total' => $goods_total, 'count' => $goods_totalcount, 'spec' => $oldspec);

						if (0 < $goods_spec) {
							$rec_data[$rank]['goods'][$goods_id]['spec'][$goods_spec] = array('goods_spec' => $goods_spec, 'goods_specname' => $goods_specname, 'marketprice' => $goods_price, 'total' => $goods_total);
						}
						else {
							$rec_data[$rank]['goods'][$goods_id]['spec'] = '';
						}
					}
					else {
						if ($val['type'] == 5) {
							$coupon_id = intval($val['coupon_id']);
							$coupon_name = trim($val['coupon_name']);
							$coupon_img = trim($val['img']);
							$coupon_num = intval($val['coupon_num']);
							$coupon_total = intval($val['coupon_total']);
							$rec_data[$rank]['coupon'][$coupon_id] = array('id' => $coupon_id, 'img' => $coupon_img, 'couponname' => $coupon_name, 'couponnum' => $coupon_num, 'count' => $coupon_total);

							if (isset($rec_data[$rank]['coupon']['total'])) {
								$rec_data[$rank]['coupon']['total'] += $coupon_num;
							}
							else {
								$rec_data[$rank]['coupon']['total'] = 0;
								$rec_data[$rank]['coupon']['total'] += $coupon_num;
							}
						}
					}
				}
			}

			$reward_rank = htmlspecialchars_decode($_GPC['reward_rank']);
			$reward_rank = json_decode($reward_rank, 1);
			$rec_rank = array();

			foreach ($reward_rank as $key => $value) {
				$rec_rank['title'] = $value['title'];
				$rec_rank['icon'] = $value['icon'];
				$rec_rank['probability'] = $value['probability'];
				$rec_rank['reward'] = $rec_data[$value['rank']];
				array_push($reward, $rec_rank);
			}

			$data['lottery_data'] = serialize($reward);

			if ($id) {
				$res = pdo_update('ewei_shop_lottery', $data, array('lottery_id' => $id, 'uniacid' => $_W['uniacid']));

				if ($res) {
					plog('lottery.edit', '修改抽奖活动 ID: ' . $id . '<br>');
				}
				else {
					show_json(0, '更新操作失败');
				}

				show_json(1, array('url' => webUrl('lottery')));
			}
			else {
				$res = pdo_insert('ewei_shop_lottery', $data);
				$id = pdo_insertid();

				if ($res) {
					plog('lottery.edit', '添加抽奖活动 ID: ' . $id . '<br>');
				}
				else {
					show_json(0, '添加操作失败');
				}

				show_json(1, array('url' => webUrl('lottery/edit', array('id' => $id, 'lottery_type' => $data['lottery_type']))));
			}
		}

		include $this->template();
	}

	public function delete()
	{
		global $_GPC;
		global $_W;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$posters = pdo_fetchall('SELECT lottery_id,lottery_title FROM ' . tablename('ewei_shop_lottery') . (' WHERE lottery_id in ( ' . $id . ' ) and uniacid=') . $_W['uniacid']);

		foreach ($posters as $poster) {
			pdo_update('ewei_shop_lottery', array('is_delete' => 1), array('lottery_id' => $poster['lottery_id'], 'uniacid' => $_W['uniacid']));
			plog('lottery.delete', '删除抽奖 ID: ' . $id . ' 海报名称: ' . $poster['lottery_title']);
		}

		show_json(1, array('url' => webUrl('lottery')));
	}

	public function testlottery()
	{
		global $_GPC;
		$reward = array();
		$inforeward = array();
		$temreward = array();
		$teminforeward = array();

		foreach ($_GPC['testreward'] as $key => $value) {
			$temreward[$value['rank']] = $value['probability'];
			$teminforeward[$value['rank']] = $value;
		}

		ksort($temreward, 1);

		foreach ($temreward as $key => $value) {
			array_push($reward, $value);
			array_push($inforeward, $teminforeward[$key]);
		}

		$num = $this->getRand($reward);
		$info = array('status' => 1, 'num' => $num, 'info' => $inforeward[$num]);
		echo json_encode($info);
		exit();
	}

	private function getRand($proArr)
	{
		$result = '';
		$proSum = array_sum($proArr);

		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);

			if ($randNum <= $proCur) {
				$result = $key;
				break;
			}

			$proSum -= $proCur;
		}

		unset($proArr);
		return intval($result);
	}

	public function taskTypeIsExist($task_type, $id)
	{
		global $_W;
		$sql = 'SELECT COUNT(1) FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid = :uniacid AND task_type = :task_type AND is_delete = 0';
		$res = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':task_type' => $task_type));
		$res = intval($res);

		if ($res === 1) {
			$sql = 'SELECT COUNT(1) FROM ' . tablename('ewei_shop_lottery') . ' WHERE uniacid = :uniacid AND task_type = :task_type AND lottery_id = :id AND is_delete = 0';
			$res2 = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':task_type' => $task_type, ':id' => $id));

			if (!empty($res2)) {
				return 0;
			}

			return 1;
		}

		return $res;
	}
}

?>
