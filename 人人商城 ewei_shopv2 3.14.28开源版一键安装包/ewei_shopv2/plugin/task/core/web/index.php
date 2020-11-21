<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

@session_start();
class Index_EweiShopV2Page extends PluginWebPage
{
	private $new = false;

	public function __construct()
	{
		parent::__construct();
		global $_GPC;
		global $_W;
		$this->new = $this->model->isnew();
	}

	public function set_read()
	{
		$this->model->set_read();
	}

	public function main()
	{
		if ($this->new) {
			$this->main_new();
			exit();
		}

		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$params = array(':uniacid' => $_W['uniacid']);
		$condition = ' and uniacid=:uniacid and `is_delete`=0 ';

		if (!empty($_GPC['keyword'])) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$condition .= ' AND `title` LIKE :title';
			$params[':title'] = '%' . trim($_GPC['keyword']) . '%';
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_task_poster') . (' WHERE 1 ' . $condition . ' ORDER BY createtime desc LIMIT ') . ($pindex - 1) * $psize . ',' . $psize, $params);
		unset($row);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_task_poster') . (' where 1 ' . $condition . ' '), $params);
		$pager = pagination2($total, $pindex, $psize);

		foreach ($list as $key => $val) {
			$viewcount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_task_joiner') . ' where uniacid=:uniacid and task_id=:task_id and task_type=' . $val['poster_type'], array(':uniacid' => $_W['uniacid'], ':task_id' => $val['id']));
			$list[$key]['viewcount'] = $viewcount;
		}

		include $this->template();
	}

	public function add()
	{
		global $_GPC;

		if ($_GPC['task_type'] == 1) {
			$this->post();
		}
		else {
			if ($_GPC['task_type'] == 2) {
				$this->rankpost();
			}
		}
	}

	public function edit()
	{
		global $_GPC;

		if ($_GPC['task_type'] == 1) {
			$this->post();
		}
		else {
			if ($_GPC['task_type'] == 2) {
				$this->rankpost();
			}
		}
	}

	public function post()
	{
		if ($this->new) {
			$this->post_new();
			exit();
		}

		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_task_poster') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$data = json_decode(str_replace('&quot;', '\'', $item['data']), true);
		}

		if ($_W['ispost']) {
			if (!empty($id)) {
				if (intval($_GPC['needcount']) < $item['needcount']) {
					$task_count = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_join') . ' where uniacid=:uniacid and task_id=:task_id and task_type=1 and failtime>' . time(), array(':uniacid' => $_W['uniacid'], ':task_id' => $id));

					if ($task_count) {
						show_json(0, '由于已经有人参加所以推广目标人数不能低于当前人数');
						exit();
					}
				}
			}

			load()->model('account');
			$data = array('uniacid' => $_W['uniacid'], 'days' => intval($_GPC['days']) * 24 * 3600, 'reward_days' => intval($_GPC['reward_days']) * 24 * 3600, 'title' => trim($_GPC['title']), 'titleicon' => trim($_GPC['titleicon']), 'poster_banner' => trim($_GPC['poster_banner']), 'keyword' => trim($_GPC['keyword']), 'bg' => save_media($_GPC['bg']), 'data' => htmlspecialchars_decode($_GPC['data']), 'resptype' => trim($_GPC['resptype']), 'resptext' => trim($_GPC['resptext']), 'resptitle' => trim($_GPC['resptitle']), 'respthumb' => trim($_GPC['respthumb']), 'respdesc' => trim($_GPC['respdesc']), 'respurl' => trim($_GPC['respurl']), 'createtime' => time(), 'oktext' => trim($_GPC['oktext']), 'waittext' => trim($_GPC['waittext']), 'bedown' => intval($_GPC['bedown']), 'beagent' => intval($_GPC['beagent']), 'getposter' => trim($_GPC['getposter']), 'timestart' => strtotime($_GPC['time']['start']), 'timeend' => strtotime($_GPC['time']['end']), 'is_repeat' => intval($_GPC['is_repeat']), 'status' => intval($_GPC['status']), 'is_goods' => intval($_GPC['is_goods']), 'autoposter' => intval($_GPC['autoposter']), 'starttext' => trim($_GPC['starttext']), 'endtext' => trim($_GPC['endtext']), 'needcount' => intval($_GPC['needcount']), 'poster_type' => isset($_GPC['poster_type']) ? intval($_GPC['poster_type']) : 1);
			$reward = array();
			$rec_reward = htmlspecialchars_decode($_GPC['rec_reward_data']);
			$rec_reward = json_decode($rec_reward, 1);
			$rec_data = array();

			if (!empty($rec_reward)) {
				foreach ($rec_reward as $val) {
					if ($val['type'] == 1) {
						$rec_data['credit'] = intval($val['num']);
					}
					else if ($val['type'] == 2) {
						$rec_data['money']['num'] = intval($val['num']);
						$rec_data['money']['type'] = intval($val['moneytype']);
					}
					else if ($val['type'] == 3) {
						$rec_data['bribery'] = intval($val['num']);
					}
					else if ($val['type'] == 4) {
						$goods_id = intval($val['goods_id']);
						$goods_name = trim($val['goods_name']);
						$goods_price = floatval($val['goods_price']);
						$goods_total = intval($val['goods_total']);
						$goods_spec = intval($val['goods_spec']);
						$goods_specname = trim($val['goods_specname']);

						if (isset($rec_data['goods'][$goods_id]['spec'])) {
							$oldspec = $rec_data['goods'][$goods_id]['spec'];
						}
						else {
							$oldspec = array();
						}

						$rec_data['goods'][$goods_id] = array('id' => $goods_id, 'title' => $goods_name, 'marketprice' => $goods_price, 'total' => $goods_total, 'spec' => $oldspec);

						if (0 < $goods_spec) {
							$rec_data['goods'][$goods_id]['spec'][$goods_spec] = array('goods_spec' => $goods_spec, 'goods_specname' => $goods_specname, 'marketprice' => $goods_price, 'total' => $goods_total);
						}
						else {
							$rec_data['goods'][$goods_id]['spec'] = '';
						}
					}
					else {
						if ($val['type'] == 5) {
							$coupon_id = intval($val['coupon_id']);
							$coupon_name = trim($val['coupon_name']);
							$coupon_num = intval($val['coupon_num']);
							$rec_data['coupon'][$coupon_id] = array('id' => $coupon_id, 'couponname' => $coupon_name, 'couponnum' => $coupon_num);

							if (isset($rec_data['coupon']['total'])) {
								$rec_data['coupon']['total'] += $coupon_num;
							}
							else {
								$rec_data['coupon']['total'] = 0;
								$rec_data['coupon']['total'] += $coupon_num;
							}
						}
					}
				}
			}

			$sub_reward = htmlspecialchars_decode($_GPC['sub_reward_data']);
			$sub_reward = json_decode($sub_reward, 1);
			$sub_data = array();

			if (!empty($sub_reward)) {
				foreach ($sub_reward as $val) {
					if ($val['type'] == 1) {
						$sub_data['credit'] = intval($val['num']);
					}
					else if ($val['type'] == 2) {
						$sub_data['money']['num'] = intval($val['num']);
						$sub_data['money']['type'] = intval($val['moneytype']);
					}
					else if ($val['type'] == 3) {
						$sub_data['bribery'] = intval($val['num']);
					}
					else {
						if ($val['type'] == 5) {
							$coupon_id = intval($val['coupon_id']);
							$coupon_name = trim($val['coupon_name']);
							$coupon_num = intval($val['coupon_num']);
							$sub_data['coupon'][$coupon_id] = array('id' => $coupon_id, 'couponname' => $coupon_name, 'couponnum' => $coupon_num);

							if (isset($sub_data['coupon']['total'])) {
								$sub_data['coupon']['total'] += $coupon_num;
							}
							else {
								$sub_data['coupon']['total'] = 0;
								$sub_data['coupon']['total'] += $coupon_num;
							}
						}
					}
				}
			}

			$reward['rec'] = $rec_data;
			$reward['sub'] = $sub_data;
			$data['reward_data'] = serialize($reward);
			$keyword = m('common')->keyExist($data['keyword']);
			if ($item['keyword'] != $data['keyword'] && !empty($keyword)) {
				if ($keyword['name'] != 'ewei_shopv2:task:' . $id) {
					show_json(0, '关键字已存在!');
				}
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_task_poster', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				$updatesql = 'UPDATE ' . tablename('ewei_shop_task_join') . ' SET  failtime = addtime+' . $data['days'] . ',needcount=:needcount WHERE uniacid = :uniacid AND task_id=:task_id AND task_type=1 AND failtime>' . time();
				pdo_query($updatesql, array(':needcount' => $data['needcount'], ':uniacid' => $_W['uniacid'], ':task_id' => $id));
				plog('task.edit', '修改活动海报 ID: ' . $id . '<br>' . ($data['isopen'] ? '允许非分销商生成自己的海报 -- 是<br>' : '允许非分销商生成自己的海报 -- 否<br>') . ($data['bedown'] ? '扫码关注成为下线 -- 是<br>' : '扫码关注成为下线 -- 否<br>') . ($data['beagent'] ? '扫码关注成为分销商 -- 是' : '扫码关注成为分销商 -- 否'));
			}
			else {
				pdo_insert('ewei_shop_task_poster', $data);
				$id = pdo_insertid();
				plog('task.add', '修改活动海报 ID: ' . $id . '<br>' . ($data['isopen'] ? '允许非分销商生成自己的海报<br>' : '不允许非分销商生成自己的海报<br>') . ($data['bedown'] ? '扫码关注成为下线 -- 是<br>' : '扫码关注成为下线 -- 否<br>') . ($data['beagent'] ? '扫码关注成为分销商 -- 是' : '扫码关注成为分销商 -- 否'));
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:task:' . $id));
			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:task:' . $id, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => $data['status']);
			$keyword_data = array('uniacid' => $_W['uniacid'], 'module' => 'ewei_shopv2', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => $data['status']);

			if (empty($rule)) {
				pdo_insert('rule', $rule_data);
				$keyword_data['rid'] = pdo_insertid();
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				pdo_update('rule_keyword', $keyword_data, array('rid' => $rule['id']));
			}

			$ruleauto = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:task:auto'));

			if (empty($ruleauto)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:task:auto', 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => 'EWEI_SHOPV2_TASK', 'type' => 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}

			show_json(1, array('url' => webUrl('task')));
		}

		$imgroot = $_W['attachurl'];

		if (empty($_W['setting']['remote'])) {
			setting_load('remote');
		}

		if (!empty($_W['setting']['remote']['type'])) {
			$imgroot = $_W['attachurl_remote'];
		}

		if (empty($item['timestart'])) {
			$starttime = time();
			$endtime = strtotime(date('Y-m-d H:i', $starttime) . '+30 days');
		}
		else {
			$type = $item['coupontype'];
			$starttime = $item['timestart'];
			$endtime = $item['timeend'];
		}

		if (!empty($item)) {
			$reward = unserialize($item['reward_data']);
			$rec_reward = $reward['rec'];
			$sub_reward = $reward['sub'];
		}
		else {
			$rec_reward = '';
			$sub_reward = '';
		}

		$default_text = pdo_fetchcolumn('SELECT `data` FROM ' . tablename('ewei_shop_task_default') . ' WHERE uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		if (!empty($default_text)) {
			$default_text = unserialize($default_text);

			if (empty($item['starttext'])) {
				$item['starttext'] = $default_text['poster']['starttext'];
			}

			if (empty($item['endtext'])) {
				$item['endtext'] = $default_text['poster']['endtext'];
			}

			if (empty($item['waittext'])) {
				$item['waittext'] = $default_text['poster']['waittext'];
			}

			if (empty($item['opentext'])) {
				$item['opentext'] = $default_text['poster']['opentext'];
			}
		}

		include $this->template();
	}

	protected function rankpost()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_task_poster') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (!empty($item)) {
			$data = json_decode(str_replace('&quot;', '\'', $item['data']), true);
		}

		if ($_W['ispost']) {
			load()->model('account');
			$data = array('uniacid' => $_W['uniacid'], 'days' => intval($_GPC['days']) * 24 * 3600, 'reward_days' => intval($_GPC['reward_days']) * 24 * 3600, 'title' => trim($_GPC['title']), 'titleicon' => trim($_GPC['titleicon']), 'poster_banner' => trim($_GPC['poster_banner']), 'keyword' => trim($_GPC['keyword']), 'bg' => save_media($_GPC['bg']), 'data' => htmlspecialchars_decode($_GPC['data']), 'resptype' => trim($_GPC['resptype']), 'resptext' => trim($_GPC['resptext']), 'resptitle' => trim($_GPC['resptitle']), 'respthumb' => trim($_GPC['respthumb']), 'respdesc' => trim($_GPC['respdesc']), 'respurl' => trim($_GPC['respurl']), 'createtime' => time(), 'oktext' => trim($_GPC['oktext']), 'waittext' => trim($_GPC['waittext']), 'bedown' => intval($_GPC['bedown']), 'beagent' => intval($_GPC['beagent']), 'getposter' => trim($_GPC['getposter']), 'timestart' => strtotime($_GPC['time']['start']), 'timeend' => strtotime($_GPC['time']['end']), 'is_repeat' => intval($_GPC['is_repeat']), 'status' => intval($_GPC['status']), 'is_goods' => intval($_GPC['is_goods']), 'autoposter' => intval($_GPC['autoposter']), 'starttext' => trim($_GPC['starttext']), 'endtext' => trim($_GPC['endtext']), 'needcount' => 0, 'poster_type' => isset($_GPC['poster_type']) ? intval($_GPC['poster_type']) : 1);
			$reward = array();
			$rec_reward = htmlspecialchars_decode($_GPC['rec_reward_data']);
			$rec_reward_rank = htmlspecialchars_decode($_GPC['rec_reward_rank']);
			$rec_reward = json_decode($rec_reward, 1);
			$rec_reward_rank = json_decode($rec_reward_rank, 1);
			$rec_data = array();

			if (!empty($rec_reward)) {
				foreach ($rec_reward as $val) {
					$rank = intval($val['rank']);

					if ($val['type'] == 1) {
						$rec_data[$rank]['credit'] = intval($val['num']);
					}
					else if ($val['type'] == 2) {
						$rec_data[$rank]['money']['num'] = intval($val['num']);
						$rec_data[$rank]['money']['type'] = intval($val['moneytype']);
					}
					else if ($val['type'] == 3) {
						$rec_data[$rank]['bribery'] = intval($val['num']);
					}
					else if ($val['type'] == 4) {
						$goods_id = intval($val['goods_id']);
						$goods_name = trim($val['goods_name']);
						$goods_price = floatval($val['goods_price']);
						$goods_total = intval($val['goods_total']);
						$goods_spec = intval($val['goods_spec']);
						$goods_specname = trim($val['goods_specname']);

						if (isset($rec_data[$rank]['goods'][$goods_id]['spec'])) {
							$oldspec = $rec_data[$rank]['goods'][$goods_id]['spec'];
						}
						else {
							$oldspec = array();
						}

						$rec_data[$rank]['goods'][$goods_id] = array('id' => $goods_id, 'title' => $goods_name, 'marketprice' => $goods_price, 'total' => $goods_total, 'spec' => $oldspec);

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
							$coupon_num = intval($val['coupon_num']);
							$rec_data[$rank]['coupon'][$coupon_id] = array('id' => $coupon_id, 'couponname' => $coupon_name, 'couponnum' => $coupon_num);

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

			if (!empty($rec_reward_rank)) {
				$rank_count = 1;

				foreach ($rec_reward_rank as $key => $value) {
					$rank_state = intval($value['rank_state']);

					if ($rank_state == 0) {
						unset($rec_data[$value['rank']]);
					}
					else {
						if ($rank_count < intval($value['rank'])) {
							$rank_count = intval($value['rank']);
						}

						$needcount = intval($value['needcount']);

						if (0 < $needcount) {
							$rec_data[$value['rank']]['needcount'] = $needcount;
							$rec_data[$value['rank']]['rank'] = intval($value['rank']);
						}
						else {
							unset($rec_data[$value['rank']]);
						}
					}
				}

				$i = 1;

				while ($i <= $rank_count) {
					if (!isset($rec_data[$i])) {
						$rec_data[$i] = array();
					}

					++$i;
				}
			}

			if (!empty($rec_data)) {
				ksort($rec_data);
			}

			$sub_reward = htmlspecialchars_decode($_GPC['sub_reward_data']);
			$sub_reward = json_decode($sub_reward, 1);
			$sub_data = array();

			if (!empty($sub_reward)) {
				foreach ($sub_reward as $val) {
					if ($val['type'] == 1) {
						$sub_data['credit'] = intval($val['num']);
					}
					else if ($val['type'] == 2) {
						$sub_data['money']['num'] = intval($val['num']);
						$sub_data['money']['type'] = intval($val['moneytype']);
					}
					else if ($val['type'] == 3) {
						$sub_data['bribery'] = intval($val['num']);
					}
					else {
						if ($val['type'] == 5) {
							$coupon_id = intval($val['coupon_id']);
							$coupon_name = trim($val['coupon_name']);
							$coupon_num = intval($val['coupon_num']);
							$sub_data['coupon'][$coupon_id] = array('id' => $coupon_id, 'couponname' => $coupon_name, 'couponnum' => $coupon_num);

							if (isset($sub_data['coupon']['total'])) {
								$sub_data['coupon']['total'] += $coupon_num;
							}
							else {
								$sub_data['coupon']['total'] = 0;
								$sub_data['coupon']['total'] += $coupon_num;
							}
						}
					}
				}
			}

			$reward['rec'] = $rec_data;
			$reward['sub'] = $sub_data;
			$data['reward_data'] = serialize($reward);
			$keyword = m('common')->keyExist($data['keyword']);
			if ($item['keyword'] != $data['keyword'] && !empty($keyword)) {
				if ($keyword['name'] != 'ewei_shopv2:task:' . $id) {
					show_json(0, '关键字已存在!');
				}
			}

			if (!empty($id)) {
				pdo_update('ewei_shop_task_poster', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
				$updatesql = 'UPDATE ' . tablename('ewei_shop_task_join') . ' SET  failtime = addtime+' . $data['days'] . ',needcount=:needcount WHERE uniacid = :uniacid AND task_id=:task_id AND task_type=1 AND failtime>' . time();
				pdo_query($updatesql, array(':needcount' => $data['needcount'], ':uniacid' => $_W['uniacid'], ':task_id' => $id));
				plog('task.edit', '修改活动海报 ID: ' . $id . '<br>' . ($data['isopen'] ? '允许非分销商生成自己的海报 -- 是<br>' : '允许非分销商生成自己的海报 -- 否<br>') . ($data['bedown'] ? '扫码关注成为下线 -- 是<br>' : '扫码关注成为下线 -- 否<br>') . ($data['beagent'] ? '扫码关注成为分销商 -- 是' : '扫码关注成为分销商 -- 否'));
			}
			else {
				pdo_insert('ewei_shop_task_poster', $data);
				$id = pdo_insertid();
				plog('task.add', '修改活动海报 ID: ' . $id . '<br>' . ($data['isopen'] ? '允许非分销商生成自己的海报<br>' : '不允许非分销商生成自己的海报<br>') . ($data['bedown'] ? '扫码关注成为下线 -- 是<br>' : '扫码关注成为下线 -- 否<br>') . ($data['beagent'] ? '扫码关注成为分销商 -- 是' : '扫码关注成为分销商 -- 否'));
			}

			$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:task:' . $id));
			$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:task:' . $id, 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => $data['status']);
			$keyword_data = array('uniacid' => $_W['uniacid'], 'module' => 'ewei_shopv2', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => $data['status']);

			if (empty($rule)) {
				pdo_insert('rule', $rule_data);
				$keyword_data['rid'] = pdo_insertid();
				pdo_insert('rule_keyword', $keyword_data);
			}
			else {
				pdo_update('rule_keyword', $keyword_data, array('rid' => $rule['id']));
			}

			$ruleauto = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:task:auto'));

			if (empty($ruleauto)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:task:auto', 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => 'EWEI_SHOPV2_TASK', 'type' => 1, 'displayorder' => 0, 'status' => 1);
				pdo_insert('rule_keyword', $keyword_data);
			}

			show_json(1, array('url' => webUrl('task')));
		}

		$imgroot = $_W['attachurl'];

		if (empty($_W['setting']['remote'])) {
			setting_load('remote');
		}

		if (!empty($_W['setting']['remote']['type'])) {
			$imgroot = $_W['attachurl_remote'];
		}

		if (empty($item['timestart'])) {
			$starttime = time();
			$endtime = strtotime(date('Y-m-d H:i', $starttime) . '+30 days');
		}
		else {
			$type = $item['coupontype'];
			$starttime = $item['timestart'];
			$endtime = $item['timeend'];
		}

		if (!empty($item)) {
			$reward = unserialize($item['reward_data']);
			$rec_reward = $reward['rec'];
			$sub_reward = $reward['sub'];
		}
		else {
			$rec_reward = '';
			$sub_reward = '';
		}

		$default_text = pdo_fetchcolumn('SELECT `data` FROM ' . tablename('ewei_shop_task_default') . ' WHERE uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		if (!empty($default_text)) {
			$default_text = unserialize($default_text);

			if (empty($item['starttext'])) {
				$item['starttext'] = $default_text['poster']['starttext'];
			}

			if (empty($item['endtext'])) {
				$item['endtext'] = $default_text['poster']['endtext'];
			}

			if (empty($item['waittext'])) {
				$item['waittext'] = $default_text['poster']['waittext'];
			}

			if (empty($item['opentext'])) {
				$item['opentext'] = $default_text['poster']['opentext'];
			}
		}

		include $this->template('task/rankpost');
	}

	public function delete()
	{
		if ($this->new) {
			$this->delete_new();
			exit();
		}

		global $_GPC;
		global $_W;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

		$posters = pdo_fetchall('SELECT id,title,keyword FROM ' . tablename('ewei_shop_task_poster') . (' WHERE id in ( ' . $id . ' ) and uniacid=') . $_W['uniacid']);

		foreach ($posters as $poster) {
			$rule = pdo_fetchall('SELECT id,rid FROM ' . tablename('rule_keyword') . (' WHERE uniacid=:uniacid AND content IN (\'' . $poster['keyword'] . '\')'), array(':uniacid' => $_W['uniacid']), 'rid');
			$rule = array_keys($rule);
			m('common')->delrule($rule);
			pdo_delete('ewei_shop_task_poster', array('id' => $poster['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_task_log', array('taskid' => $poster['id'], 'task_type' => 1, 'uniacid' => $_W['uniacid']));
			pdo_delete('ewei_shop_task_join', array('taskid' => $poster['id'], 'task_type' => 1, 'uniacid' => $_W['uniacid']));
			pdo_delete("ewei_shop_task_record", array("taskid" => $poster["id"], "uniacid" => $_W["uniacid"]));
			plog('task.delete', '删除任务海报 ID: ' . $id . ' 海报名称: ' . $poster['title']);
		}

		show_json(1, array('url' => webUrl('task')));
	}

	public function clear()
	{
		global $_W;
		global $_GPC;
		load()->func('file');
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/task/poster/' . $_W['uniacid']);
		@rmdirs(IA_ROOT . '/addons/ewei_shopv2/data/task/qrcode/' . $_W['uniacid']);
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		pdo_update('ewei_shop_task_poster_qr', array('mediaid' => ''), array('acid' => $acid));
		plog('task.clear', '清除任务海报缓存');
		show_json(1, array('url' => webUrl('task', array('op' => 'display'))));
	}

	public function delreward()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$type = intval($_GPC['del_type']);
		$datatype = intval($_GPC['data_type']);
		$data = $_GPC['data_value'];

		if ($type == 1) {
			$item = pdo_fetch('SELECT `id`,`reward_data` FROM ' . tablename('ewei_shop_task_poster') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$item['reward_data'] = unserialize($item['reward_data']);

			if ($datatype == 1) {
				$item['reward_data']['rec']['credit'] = 0;
			}

			if ($datatype == 2) {
				$item['reward_data']['rec']['money']['num'] = 0;
			}

			if ($datatype == 3) {
				$item['reward_data']['rec']['bribery'] = 0;
			}

			if ($datatype == 4) {
				$is_spec = strpos($data, '-');

				if ($is_spec) {
					$data = explode('_', $data);

					if (isset($item['reward_data']['rec']['goods'][$data[0]]['spec'][$data[1]])) {
						unset($item['reward_data']['rec']['goods'][$data[0]]['spec'][$data[1]]);
					}

					if (isset($item['reward_data']['rec']['goods'][$data[0]]['spec']) && empty($item['reward_data']['rec']['goods'][$data[0]]['spec'])) {
						unset($item['reward_data']['rec']['goods'][$data[0]]);
					}
				}
				else {
					if (isset($item['reward_data']['rec']['goods'][$data[0]])) {
						unset($item['reward_data']['rec']['goods'][$data[0]]);
					}
				}
			}

			if ($datatype == 5) {
				if (isset($item['reward_data']['rec']['coupon'][$data])) {
					unset($item['reward_data']['rec']['coupon'][$data]);
				}
			}

			$item['reward_data'] = serialize($item['reward_data']);
			pdo_update('ewei_shop_task_poster', array('reward_data' => $item['reward_data']), array('id' => $id, 'uniacid' => $_W['uniacid']));
			$item['reward_data'] = unserialize($item['reward_data']);
			echo json_encode(array('status' => 1, 'info' => $item['reward_data']['rec']));
			exit();
		}
		else if ($type == 2) {
			$item = pdo_fetch('SELECT `id`,`reward_data` FROM ' . tablename('ewei_shop_task_poster') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
			$item['reward_data'] = unserialize($item['reward_data']);

			if ($datatype == 1) {
				$item['reward_data']['sub']['credit'] = 0;
			}

			if ($datatype == 2) {
				$item['reward_data']['sub']['money']['num'] = 0;
			}

			if ($datatype == 3) {
				$item['reward_data']['sub']['bribery'] = 0;
			}

			if ($datatype == 5) {
				if (isset($item['reward_data']['sub']['coupon'][$data])) {
					unset($item['reward_data']['sub']['coupon'][$data]);
				}
			}

			$item['reward_data'] = serialize($item['reward_data']);
			pdo_update('ewei_shop_task_poster', array('reward_data' => $item['reward_data']), array('id' => $id, 'uniacid' => $_W['uniacid']));
			$item['reward_data'] = unserialize($item['reward_data']);
			echo json_encode(array('status' => 1, 'info' => $item['reward_data']['sub']));
			exit();
		}
		else {
			echo json_encode(array('status' => 0, 'info' => '删除类型不存在'));
			exit();
		}
	}

	/**
     * 任务概况
     */
	public function main_new()
	{
		global $_W;
		global $_GPC;
		$date = date('Y-m-d H:i:s');
		$taskS = array();
		$taskS[0] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_task_record') . (' where uniacid = ' . $_W['uniacid']));
		$taskS[1] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_task_record') . (' where uniacid = ' . $_W['uniacid'] . ' and finishtime > \'0000-00-00 00:00:00\' '));
		$taskS[2] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_task_record') . (' where uniacid = ' . $_W['uniacid'] . ' and finishtime = \'0000-00-00 00:00:00\' and stoptime < \'' . $date . '\' and stoptime <> \'0000-00-00 00:00:00\''));
		$taskS[3] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_task_record') . (' where uniacid = ' . $_W['uniacid'] . ' and finishtime = \'0000-00-00 00:00:00\' and stoptime > \'' . $date . '\''));
		$rewardS = array();
		$rewardS[0] = (int) pdo_fetchcolumn('select sum(reward_data) from ' . tablename('ewei_shop_task_reward') . (' where uniacid = ' . $_W['uniacid'] . ' and `get` = 1 and reward_type = \'credit\''));
		$rewardS[1] = (double) pdo_fetchcolumn('select sum(reward_data) from ' . tablename('ewei_shop_task_reward') . (' where uniacid = ' . $_W['uniacid'] . ' and `get` = 1 and reward_type = \'redpacket\''));
		$rewardS[2] = (double) pdo_fetchcolumn('select sum(reward_data) from ' . tablename('ewei_shop_task_reward') . (' where uniacid = ' . $_W['uniacid'] . ' and `get` = 1 and reward_type = \'balance\''));
		$rewardS[3] = (int) pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_task_reward') . (' where uniacid = ' . $_W['uniacid'] . ' and `get` = 1 and reward_type = \'coupon\''));
		include $this->template('task/new/index');
	}

	/**
     * 任务列表
     */
	public function tasklist()
	{
		global $_W;
		global $_GPC;
		$page = (int) $_GPC['page'];
		$list = $this->model->getAllTask($page);
		include $this->template('task/new/tasklist');
	}

	/**
     * 任务记录
     */
	public function record()
	{
		global $_W;
		global $_GPC;
		$page = (int) $_GPC['page'];
		$records = $this->model->getAllRecords($page);
		include $this->template('task/new/record');
	}

	/**
     * 任务奖励
     */
	public function reward()
	{
		global $_W;
		global $_GPC;
		$page = (int) $_GPC['page'];
		$rewards = $this->model->getAllRewards($page);
		include $this->template('task/new/reward');
	}

	/**
     * 任务消息通知
     */
	public function notice()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('notice', false);
		$salers = array();

		if (isset($data['openid'])) {
			if (!empty($data['openid'])) {
				$openids = array();
				$strsopenids = explode(',', $data['openid']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		if ($_W['ispost']) {
			ca('sysset.notice.edit');
			$top_notice = intval($_GPC['top_notice']);
			pdo_update('ewei_shop_task_set', array('top_notice' => $top_notice), array('uniacid' => $_W['uniacid']));
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (is_array($_GPC['openids'])) {
				$data['openid'] = implode(',', $_GPC['openids']);
			}
			else {
				$data['openid'] = '';
			}

			if (empty($data['willcancel_close_advanced'])) {
				$uniacids = m('cache')->get('willcloseuniacid', 'global');

				if (!is_array($uniacids)) {
					$uniacids = array();
				}

				if (!in_array($_W['uniacid'], $uniacids)) {
					$uniacids[] = $_W['uniacid'];
					m('cache')->set('willcloseuniacid', $uniacids, 'global');
				}
			}
			else {
				$uniacids = m('cache')->get('willcloseuniacid', 'global');

				if (is_array($uniacids)) {
					if (in_array($_W['uniacid'], $uniacids)) {
						$datas = array();

						foreach ($uniacids as $uniacid) {
							if ($uniacid != $_W['uniacid']) {
								$datas[] = $uniacid;
							}
						}

						m('cache')->set('willcloseuniacid', $datas, 'global');
					}
				}
			}

			m('common')->updateSysset(array('notice' => $data));
			show_json(1);
		}

		$top_notice = pdo_getcolumn('ewei_shop_task_set', array('uniacid' => $_W['uniacid']), 'top_notice');
		$template_list = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_list as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		include $this->template('task/new/notice');
	}

	/**
     * 编辑任务设置
     */
	public function setting()
	{
		global $_W;
		global $_GPC;
		$set = pdo_get('ewei_shop_task_set', array('uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			$set['entrance'] = intval($_GPC['entrance']);
			$set['keyword'] = trim($_GPC['keyword']);
			$set['cover_title'] = trim($_GPC['cover_title']);
			$set['cover_img'] = trim($_GPC['cover_img']);
			$set['bg_img'] = trim($_GPC['bg_img']);
			$set['cover_desc'] = trim($_GPC['cover_desc']);
			$saveCover = $this->saveCover($set['keyword'], $set['cover_img'], $set['cover_desc'], $set['cover_title']);
			empty($saveCover) && show_json(0, '回复设置失败');
			$saveRet = $this->model->taskSave('ewei_shop_task_set', $set);
			empty($saveRet) && show_json(0, '保存失败');
			show_json(1);
		}

		include $this->template('task/new/setting');
	}

	/**
     * 设置封面入口
     * @param $keyword
     * @param $img
     * @param $desc
     * @return bool
     */
	protected function saveCover($keyword, $img, $desc, $title)
	{
		global $_W;
		$entranceName = 'ewei_shop:任务中心入口封面';
		$rid = pdo_fetchcolumn('select id from ' . tablename('rule') . (' where uniacid = ' . $_W['uniacid'] . ' and `name` = \'' . $entranceName . '\''));

		if (empty($rid)) {
			if (pdo_insert('rule', array('uniacid' => $_W['uniacid'], 'name' => $entranceName, 'module' => 'cover', 'status' => 1))) {
				$rid = pdo_insertid();
			}
		}

		if (pdo_fetchcolumn('select count(1) from ' . tablename('rule_keyword') . (' where content = \'' . $keyword . '\' and uniacid = ' . $_W['uniacid'] . ' and rid <> ' . $rid))) {
			show_json(0, '关键词已存在，请更换');
		}

		$kid = pdo_fetchcolumn('select id from ' . tablename('rule_keyword') . (' where rid = ' . $rid));

		if (empty($kid)) {
			pdo_insert('rule_keyword', array('rid' => $rid, 'uniacid' => $_W['uniacid'], 'module' => 'cover', 'content' => $keyword, 'type' => 1, 'status' => 1));
		}
		else {
			pdo_update('rule_keyword', array('rid' => $rid, 'uniacid' => $_W['uniacid'], 'module' => 'cover', 'content' => $keyword, 'type' => 1, 'status' => 1), array('id' => $kid));
		}

		$cid = pdo_fetchcolumn('select id from ' . tablename('cover_reply') . (' where rid = ' . $rid . ' and uniacid = ' . $_W['uniacid']));

		if (empty($cid)) {
			pdo_insert('cover_reply', array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'title' => $title, 'description' => $desc, 'thumb' => $img, 'url' => mobileUrl('task', NULL, 1)));
		}
		else {
			pdo_update('cover_reply', array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'title' => $title, 'description' => $desc, 'thumb' => $img, 'url' => mobileUrl('task', NULL, 1)), array('id' => $cid));
		}

		return true;
	}

	/**
     * 添加/编辑任务
     */
	public function post_new()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$task = NULL;

		if (!empty($id)) {
			$task = $this->model->getThisTask($id);
		}

		$uniacid = $_W['uniacid'];

		if (!empty($task['reward'])) {
			$data = json_decode($task['reward'], true);
			$coupons = &$data['coupon'];
			$sql = 'SELECT id from ' . tablename('ewei_shop_coupon') . ('where `uniacid` = ' . $uniacid);
			$allCoupons = pdo_fetchall($sql);

			foreach ($allCoupons as $item) {
				$allCouponsIds[] = $item['id'];
			}

			foreach ($coupons as $index => $coupon) {
				if (!in_array($coupon['id'], $allCouponsIds)) {
					unset($coupons[$index]);
				}
			}

			$coupons = array_values($coupons);
			$task['reward'] = json_encode($data);
			pdo_update('ewei_shop_task_list', array('reward' => $task['reward']), array('id' => $id, 'uniacid' => $uniacid));
			unset($data);
			unset($coupons);
		}

		if (empty($task) && !empty($id)) {
			header('location:' . webUrl('task.post'));
			exit();
		}

		if (!empty($task['requiregoods'])) {
			$task['requiregoods'] = trim($task['requiregoods'], ',');
			$goods = pdo_fetchall('select id,title,thumb from ' . tablename('ewei_shop_goods') . (' where id in (' . $task['requiregoods'] . ') and status=1 and deleted=0 and uniacid=' . $_W['uniacid'] . ' order by instr(\'' . $task['requiregoods'] . '\',id)'));
		}

		if ($_W['ispost']) {
			$diy = $_GPC['diy'];
			$data['verb'] = empty($diy['verb']) ? '转发海报并吸引' : $diy['verb'];
			$data['unit'] = empty($diy['unit']) ? '人关注' : $diy['unit'];
			$rewardgoods = $_GPC['rewardgoods'];
			$native_data = htmlspecialchars_decode($rewardgoods);
			$rewardgoods = json_decode(htmlspecialchars_decode($rewardgoods), 1);

			if (is_array($rewardgoods)) {
				foreach ($rewardgoods as $key => $val) {
					if (empty($val['column']) || empty($val['column']['title']) || empty($val['column']['num'])) {
						if (!empty($val['options'])) {
							foreach ($val['options'] as $opc) {
								if (empty($opc['column']) || empty($opc['column']['title']) || empty($opc['column']['num'])) {
									show_json(0, '存在未填写商品设置的特惠商品');
								}
							}
						}
						else {
							show_json(0, '存在未填写商品设置的特惠商品');
						}
					}

					if (is_array($val['column'])) {
						foreach ($val['column'] as $k => $v) {
							$temp_rewardgoods[$k] = $v;
							$temp_rewardgoods['id'] = $val['id'];
						}
					}

					$to_rewardgoods[] = $temp_rewardgoods;
					$temp_rewardgoods = NULL;
				}
			}

			$rewardgoods = $_GPC['rewardgoods2'];
			$native_data2 = htmlspecialchars_decode($rewardgoods);
			$rewardgoods = json_decode(htmlspecialchars_decode($rewardgoods), 1);

			if (is_array($rewardgoods)) {
				foreach ($rewardgoods as $key => $val) {
					if (empty($val['column']) || empty($val['column']['title']) || empty($val['column']['num'])) {
						if (!empty($val['options'])) {
							foreach ($val['options'] as $opc) {
								if (empty($opc['column']) || empty($opc['column']['title']) || empty($opc['column']['num'])) {
									show_json(0, '存在未填写商品设置的特惠商品');
								}
							}
						}
						else {
							show_json(0, '存在未填写商品设置的特惠商品');
						}
					}

					if (is_array($val['column'])) {
						foreach ($val['column'] as $k => $v) {
							$temp_rewardgoods[$k] = $v;
							$temp_rewardgoods['id'] = $val['id'];
						}
					}

					$to_rewardgoods2[] = $temp_rewardgoods;
					$temp_rewardgoods = NULL;
				}
			}

			$rewardgoods = $_GPC['rewardgoods3'];
			$native_data3 = htmlspecialchars_decode($rewardgoods);
			$rewardgoods = json_decode(htmlspecialchars_decode($rewardgoods), 1);

			if (is_array($rewardgoods)) {
				foreach ($rewardgoods as $key => $val) {
					if (empty($val['column']) || empty($val['column']['title']) || empty($val['column']['num'])) {
						if (!empty($val['options'])) {
							foreach ($val['options'] as $opc) {
								if (empty($opc['column']) || empty($opc['column']['title']) || empty($opc['column']['num'])) {
									show_json(0, '存在未填写商品设置的特惠商品');
								}
							}
						}
						else {
							show_json(0, '存在未填写商品设置的特惠商品');
						}
					}

					if (is_array($val['column'])) {
						foreach ($val['column'] as $k => $v) {
							$temp_rewardgoods[$k] = $v;
							$temp_rewardgoods['id'] = $val['id'];
						}
					}

					$to_rewardgoods3[] = $temp_rewardgoods;
					$temp_rewardgoods = NULL;
				}
			}

			if ($id) {
				$data['id'] = $id;
			}

			$data['native_data'] = $native_data;
			$data['native_data2'] = $native_data2;
			$data['native_data3'] = $native_data3;
			$posttype = trim($_GPC['posttype']);
			$data['title'] = trim($_GPC['title']);
			empty($data['title']) && show_json(0, '请填写标题');
			$data['image'] = trim($_GPC['image']);
			empty($data['image']) && show_json(0, '请上传任务图');
			$data['type'] = trim($_GPC['type']);
			empty($data['type']) && show_json(0, '请选择任务类型');
			$taskType = $this->model->getTaskType($data['type']);
			empty($taskType) && show_json(0, '任务类型错误');

			if ($taskType['type_key'] == 'goods') {
				$data['requiregoods'] = json_decode(htmlspecialchars_decode($_GPC['requiregoods']), 1);
				$data['design_data'] = $data['requiregoods'];
			}

			if (is_array($data['requiregoods'])) {
				$requiregoods = array();

				foreach ($data['requiregoods'] as $k => $v) {
					$requiregoods[] = $k;
				}

				empty($requiregoods) && show_json(0, '请选择指定商品');
				$data['requiregoods'] = implode(',', $requiregoods);
			}

			$opentime = $_GPC['opentime'];
			$data['starttime'] = $opentime['start'];
			empty($data['starttime']) && show_json(0, '请选择开始时间');
			$data['endtime'] = $opentime['end'];
			empty($data['endtime']) && show_json(0, '请选择结束时间');
			$interval = strtotime($data['endtime']) - strtotime($data['starttime']);

			if (0 < $interval - 86400 * 30) {
			}

			$data['demand'] = max(intval($_GPC['requirenumber']), 1);

			if (empty($taskType['unit'])) {
				$data['demand'] = 1;
			}

			$data['picktype'] = intval($_GPC['picktype']);

			if ($data['picktype'] != '1') {
				$data['stop_type'] = intval($_GPC['stoptype']);

				switch ($data['stop_type']) {
				case 1:
					$data['stop_limit'] = max(3600, 3600 * (int) $_GPC['stoplimit']);
					break;

				case 2:
					$data['stop_time'] = $_GPC['stoptime'];
					empty($data['stop_time']) && show_json(0, '请选择截止日期');
					break;

				case 3:
					$data['stop_cycle'] = intval($_GPC['stopcycle']);
					break;
				}

				$data['repeat_type'] = intval($_GPC['repeattype']);

				switch ($data['repeat_type']) {
				case 2:
					$data['repeat_interval'] = max(3600, 3600 * (int) $_GPC['repeatinterval']);
					break;

				case 3:
					$data['repeat_cycle'] = intval($_GPC['repeatcycle']);
					break;
				}
			}

			$reward['credit'] = max(0, intval($_GPC['rewardcredit']));
			$reward['balance'] = max(0, floatval($_GPC['rewardbalance']));
			$reward['redpacket'] = floatval($_GPC['rewardredpacket']);
			$reward['coupon'] = json_decode(htmlspecialchars_decode($_GPC['rewardcoupon']), 1);
			$reward['goods'] = $to_rewardgoods;
			if (empty($reward['credit']) && empty($reward['balance']) && empty($reward['redpacket']) && empty($reward['coupon']) && empty($reward['goods'])) {
				show_json(0, '请先设置完成奖励');
			}

			$data['reward'] = json_encode($reward);
			$level2 = intval($_GPC['level_2']);

			if ($level2) {
				if ($level2 <= $data['demand']) {
					show_json(0, '二级需求需要大于一级需求');
				}

				$reward2['credit'] = max(0, intval($_GPC['rewardcredit2']));
				$reward2['balance'] = max(0, floatval($_GPC['rewardbalance2']));
				$reward2['redpacket'] = floatval($_GPC['rewardredpacket2']);
				$reward2['coupon'] = json_decode(htmlspecialchars_decode($_GPC['rewardcoupon2']), 1);
				$reward2['goods'] = $to_rewardgoods2;
				if (empty($reward2['credit']) && empty($reward2['balance']) && empty($reward2['redpacket']) && empty($reward2['coupon']) && empty($reward2['goods'])) {
					show_json(0, '请先设置二级奖励');
				}

				$data['level2'] = $level2;
				$data['reward2'] = json_encode($reward2);
				$level3 = intval($_GPC['level_3']);

				if ($level3) {
					$data['level3'] = $level3;
					if ($level3 <= $data['demand'] || $level3 <= $level2) {
						show_json(0, '三级需求必须大于一级和二级需求');
					}

					$reward3['credit'] = max(0, intval($_GPC['rewardcredit3']));
					$reward3['balance'] = max(0, floatval($_GPC['rewardbalance3']));
					$reward3['redpacket'] = floatval($_GPC['rewardredpacket3']);
					$reward3['coupon'] = json_decode(htmlspecialchars_decode($_GPC['rewardcoupon3']), 1);
					$reward3['goods'] = $to_rewardgoods3;
					if (empty($reward3['credit']) && empty($reward3['balance']) && empty($reward3['redpacket']) && empty($reward3['coupon']) && empty($reward3['goods'])) {
						show_json(0, '请先设置三级奖励');
					}

					$data['reward3'] = json_encode($reward3);
				}
				else {
					$data['level3'] = 0;
					$data['reward3'] = '';
					$data['native_data3'] = '';
				}
			}
			else {
				$data['level2'] = 0;
				$data['reward2'] = '';
				$data['native_data2'] = '';
				$data['level3'] = 0;
				$data['reward3'] = '';
				$data['native_data3'] = '';
			}

			$followreward['beagent'] = intval($_GPC['beagent']);
			$followreward['credit'] = intval($_GPC['followrewardcredit']);
			$followreward['balance'] = floatval($_GPC['followrewardbalance']);
			$followreward['redpacket'] = floatval($_GPC['followrewardredpacket']);
			$followreward['coupon'] = json_decode(htmlspecialchars_decode($_GPC['followrewardcoupon']), 1);
			$data['followreward'] = json_encode($followreward);
			$data['design_bg'] = trim($_GPC['design_bg']);

			if ($data['type'] == 'poster') {
				$data['design_data'] = htmlspecialchars_decode($_GPC['design_data']);
				$data['keyword_pick'] = trim($_GPC['keyword_pick']);

				if (!empty($_GPC['member_group'])) {
					$data['member_group'] = implode(',', $_GPC['member_group']);
				}
				else {
					$data['member_group'] = '';
				}

				if (!empty($_GPC['member_level'])) {
					$data['member_level'] = intval($_GPC['member_level']);
				}
				else {
					$data['member_level'] = 0;
				}

				$data['auto_pick'] = intval($_GPC['auto_pick']);
			}

			if ($data['type'] == 'poster' && ($data['design_data'] == '[]' || empty($data['design_data']))) {
				show_json(0, '请先设计海报样式');
			}

			if ($data['type'] == 'poster' && empty($data['keyword_pick'])) {
				show_json(0, '触发关键字不能为空');
			}

			$tasks = pdo_fetchall('select * from ' . tablename('ewei_shop_task_list') . ' where `uniacid` = :uniacid ', array(':uniacid' => $_W['uniacid']));
			$keywords = array_column($tasks, 'keyword_pick', 'id');
			$tips = '关键字已存在,请修改后重试!';
			$isPoster = $data['type'] == 'poster' ? true : false;

			if ($isPoster) {
				if (is_null($task)) {
					in_array($data['keyword_pick'], $keywords) && show_json(0, $tips);
				}
				else {
					$taskid = $task['id'];
					unset($keywords[$taskid]);
					in_array($data['keyword_pick'], $keywords) && show_json(0, $tips);
				}
			}

			$saveRet = $this->model->taskSave('ewei_shop_task_list', $data);

			if ($isPoster) {
				$currentVersion = md5($task['design_data']);
				$postVersion = md5(html_entity_decode($_GPC['design_data']));

				if ($currentVersion != $postVersion) {
					pdo_update('ewei_shop_task_list', array('poster_version' => $postVersion), array('id' => $id));
				}
			}

			if (empty($saveRet)) {
				show_json(0, '数据保存失败，请检查');
			}

			$task = $this->model->getThisTask($saveRet);

			if (!empty($task['keyword_pick'])) {
				$this->replyRule($data['keyword_pick'], $task);
			}

			show_json(1, array('message' => '保存成功', 'url' => webUrl('task.post', array('id' => $saveRet))));
		}
		else {
			!empty($task['followreward']) && ($followreward = json_decode($task['followreward'], 1));
			!empty($task['reward']) && ($reward = json_decode($task['reward'], 1));
			!empty($task['reward2']) && ($reward2 = json_decode($task['reward2'], 1));
			!empty($task['reward3']) && ($reward3 = json_decode($task['reward3'], 1));
			empty($reward['coupon']) && $reward['coupon'] = array();
			empty($reward2['coupon']) && $reward2['coupon'] = array();
			empty($reward3['coupon']) && $reward3['coupon'] = array();
			!empty($task['design_data']) && ($design_data = json_decode(str_replace('&quot;', '\'', $task['design_data']), true));

			if (empty($task)) {
				$task['starttime'] = date('Y-m-d H:i:s');
				$task['endtime'] = date('Y-m-d H:i:s', time() + 86400 * 7);
			}

			$member_groups = m('member')->getGroups();
			$member_levels = m('member')->getLevels();
			$task['verb'] = empty($task['verb']) ? '转发海报并吸引' : $task['verb'];
			$task['unit'] = empty($task['unit']) ? '人关注' : $task['unit'];
			$tradeSet = m('common')->getSysset('trade');
			$tradeSet['credittext'] = empty($tradeSet['credittext']) ? '积分' : $tradeSet['credittext'];
			$tradeSet['moneytext'] = empty($tradeSet['moneytext']) ? '余额' : $tradeSet['moneytext'];
			include $this->template('task/new/post');
		}
	}

	/**
     * 保存回复关键字
     * @param $keyword
     * @task $task
     */
	public function replyRule($keyword, $task = NULL)
	{
		global $_W;
		global $_GPC;
		$taskid = $task['id'];
		$we7_rule_keyword_id = $task['we7_rule_keyword_id'];
		$rid = $this->createRuleIfNotExists();

		if ($we7_rule_keyword_id) {
			$success = pdo_update('rule_keyword', array('content' => $keyword), array('id' => $we7_rule_keyword_id));
			!$success && $this->createReplyRule($rid, $task, $keyword);
			return NULL;
		}

		$this->createReplyRule($rid, $task, $keyword);
	}

	/**
     * 创建任务回复关键字
     * @param $rid int
     * @param $task array 任务
     * @param $keyword string 任务关键字
     */
	protected function createReplyRule($rid, $task, $keyword)
	{
		global $_W;
		$keywordRuleExists = pdo_fetch('select * from ' . tablename('rule_keyword') . 'where id = :id', array(':id' => $task['we7_rule_keyword_id']));

		if ($keywordRuleExists) {
			pdo_update('rule_keyword', array('content' => $keyword), array('id' => $task['we7_rule_keyword_id']));
		}
		else {
			$_keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'type' => 1, 'content' => $keyword, 'status' => 1);
			pdo_insert('rule_keyword', $_keyword_data);
			$insert_id = pdo_insertid();
			pdo_update('ewei_shop_task_list', array('we7_rule_keyword_id' => $insert_id), array('id' => $task['id']));
		}
	}

	/**
     * 创建回复规则
     * @return bool
     */
	protected function createRuleIfNotExists()
	{
		global $_W;
		$rid = pdo_fetchcolumn('select id from ' . tablename('rule') . (' where `name` = :name and uniacid = ' . $_W['uniacid'] . ' and module = \'ewei_shopv2\' '), array(':name' => 'ewei_shopv2:task'));

		if (empty($rid)) {
			$_rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:task', 'module' => 'ewei_shopv2', 'status' => 1);

			if (pdo_fieldexists('rule', 'reply_type')) {
				$_rule_data['reply_type'] = '1';
			}

			pdo_insert('rule', $_rule_data);
			$rid = pdo_insertid();
		}

		return $rid;
	}

	/**
     * 预览任务详情
     */
	public function preview()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$sql = 'select rc.*,rw.* from ' . tablename('ewei_shop_task_record') . ' rc left join ' . tablename('ewei_shop_task_reward') . (' rw on rc.id = rw.recordid where rc.id = ' . $id . ' and rc.uniacid = ' . $_W['uniacid']);
		$data = pdo_fetchall($sql);
		include $this->template('task/new/preview');
	}

	/**
     * 删除任务
     */
	public function delete_new()
	{
		global $_W;
		global $_GPC;
		$ids = $_GPC['ids'];
		$this->model->deleteTask($ids);
		show_json(1);
	}

	/**
     * 分页获取商品或者优惠券
     */
	public function selectlist()
	{
		global $_GPC;
		$type = $_GPC['type'];
		$page = max(1, (int) $_GPC['page']);
		$keyword = trim($_GPC['keyword']);

		if ($type) {
			$this->model->getGoods_new($keyword, $page);
		}
		else {
			$this->model->getCoupon($keyword, $page);
		}
	}

	/**
     * 排序设置
     */
	public function setdisplayorder()
	{
		global $_W;
		global $_GPC;
		$id = (int) $_GPC['id'];
		$value = (int) $_GPC['value'];
		pdo_update('ewei_shop_task_list', array('displayorder' => $value), array('id' => $id, 'uniacid' => $_W['uniacid']));
		show_json(1);
	}

	/**
     * 判断是什么类型的任务
     * @param $task
     * @return string
     */
	private function whatType($type)
	{
		if (empty($type)) {
			return '其他';
		}

		$tasktype = $this->model->getTaskType($type);
		$typeText = $tasktype['type_name'];
		$color = $tasktype['theme'];
		$return = '<span class=\'label label-' . $color . '\'>' . $typeText . '</span>';
		return $return;
	}

	/**
     * 判断当前任务是什么状态
     * @param $task
     * @return string
     */
	private function whatStatus($task)
	{
		$color = ' label-primary';
		$statusText = '进行中';
		$time = time();

		if (strtotime($task['endtime']) < $time) {
			$statusText = '已结束';
			$color = ' label-default';
		}
		else {
			if ($time < strtotime($task['starttime'])) {
				$statusText = '未开始';
				$color = ' label-warning';
			}
		}

		$return = '<span class=\'label' . $color . '\'>' . $statusText . '</span>';
		return $return;
	}

	/**
     * 判断当前进度
     * @return string
     */
	private function whatProgress($record)
	{
		$color = ' label-primary';

		if ($record['task_demand'] <= $record['task_process']) {
			$statusText = '已完成';
		}
		else {
			$statusText = '进度 ' . $record['task_progress'] . '/' . $record['task_demand'];
		}

		$return = '<span class=\'label' . $color . '\'>' . $statusText . '</span>';
		return $return;
	}

	/**
     * 判断奖励类型
     * @param $reward
     * @return string
     */
	private function whatRewardType($reward)
	{
		switch ($reward) {
		case 'goods':
			$color = ' label-success';
			$statusText = '特惠商品';
			break;

		case 'coupon':
			$color = ' label-info';
			$statusText = '优惠券';
			break;

		case 'balance':
			$color = ' label-primary';
			$statusText = '余额';
			break;

		case 'credit':
			$color = ' label-warning';
			$statusText = '积分';
			break;

		case 'redpacket':
			$color = ' label-danger';
			$statusText = '微信红包';
			break;
		}

		$return = '<span class=\'label' . $color . '\'>' . $statusText . '</span>';
		return $return;
	}

	/**
     * 判断是奖励是否发放
     * @param $reward
     * @return string
     */
	private function whatRewardStatus($reward)
	{
		if ($reward['sent'] == 1) {
			$color = ' label-primary';
			$statusText = '已领取';
		}
		else {
			if ($reward['get'] == 1 && $reward['sent'] != 1) {
				$color = ' label-warning';
				$statusText = '未领取';
			}
			else {
				if ($reward['get'] == 0) {
					$color = ' label-defalt';
					$statusText = '未发放';
				}
			}
		}

		$return = '<a class=\'label' . $color . '\'>' . $statusText . '</a>';
		return $return;
	}

	public function version()
	{
		global $_W;
		$new = intval($this->model->isnew());
		$new = 1;
		pdo_update('ewei_shop_task_set', array('isnew' => $new), array('uniacid' => $_W['uniacid']));
		$type = array('INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'1\', \'poster\', \'任务海报\', \'把生成的海报并分享给朋友，朋友扫描并关注公众号即可获得奖励。\', \'转发海报并吸引\', \'1\', \'人关注\', \'0\', \'primary\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'2\', \'info_phone\', \'绑定手机\', \'在个人中心中，绑定手机号，即可完成任务获得奖励。\', \'绑定手机\', \'0\', \'\', \'0\', \'warning\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'3\', \'order_first\', \'首次购物\', \'在商城中首次下单，即可获得奖励，必须确认收货。\', \'首次在商城中下单购物\', \'0\', \'\', \'0\', \'warning\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'4\', \'recharge_full\', \'单笔充值满额\', \'在商城中充值余额，单笔充值满额，即可获得奖励。\', \'单笔充值满\', \'1\', \'元\', \'0\', \'success\', \'1\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'5\', \'order_full\', \'单笔满额\', \'在商城中下单，单笔满额即可获得奖励，必须确认收货。\', \'单笔订单满\', \'1\', \'元\', \'0\', \'success\', \'1\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'6\', \'order_all\', \'累计消费\', \'在商城中购物消费，累计满额即可获得奖励，无需确认收货。\', \'购物总消费额达到\', \'1\', \'元\', \'0\', \'success\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'7\', \'pyramid_money\', \'分销佣金\', \'只有分销商可接此任务。累计分销佣金满额，即可完成任务。\', \'分销商获得佣金金额达\', \'1\', \'元\', \'0\', \'primary\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'8\', \'pyramid_num\', \'下级人数\', \'只有分销商可接此任务。累计下级人数达标，即可完成任务。\', \'分销商推荐下级人数达\', \'1\', \'人\', \'0\', \'primary\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'9\', \'comment\', \'商品好评\', \'任意给一个商品五星好评，即可完成任务获得奖励。\', \'给商品好评\', \'0\', \'\', \'0\', \'warning\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'10\', \'post\', \'社区发帖\', \'在社区中发表指定篇帖子，即可完成任务获得奖励。\', \'在论坛中发表\', \'1\', \'篇帖子\', \'0\', \'warning\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'11\', \'goods\', \'购买指定商品\', \'购买指定商品后即可完成任务，必须确认收货。\', \'购买指定商品\', \'0\', \'\', \'1\', \'info\', \'0\');', 'INSERT INTO ' . tablename('ewei_shop_task_type') . ' (`id`, `type_key`, `type_name`, `description`, `verb`, `numeric`, `unit`, `goods`, `theme`, `once`) VALUES (\'12\', \'recharge_count\', \'累计充值满额\', \'在商城中充值余额，累计充值满额，即可获得奖励。\', \'累计充值满\', \'1\', \'元\', \'0\', \'success\', \'0\');');

		foreach ($type as $t) {
			pdo_query($t);
		}

		pdo_delete('ewei_shop_task_poster', array('uniacid' => $_W['uniacid']));
		pdo_delete('ewei_shop_task_join', array('uniacid' => $_W['uniacid']));
		pdo_delete('ewei_shop_task_joiner', array('uniacid' => $_W['uniacid']));
		pdo_delete('ewei_shop_task_extension_join', array('uniacid' => $_W['uniacid']));
		header('location:' . webUrl('task'));
		exit();
	}
}

?>
