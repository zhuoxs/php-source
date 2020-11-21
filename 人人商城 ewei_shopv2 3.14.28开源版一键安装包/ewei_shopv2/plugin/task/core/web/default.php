<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Default_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$this->post($_GPC);
		}

		$db_data = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		$res = '';

		if (!empty($db_data)) {
			$res = unserialize($db_data);
		}

		$tooltip = '[任务名称]:海报标题<br/>[任务阶段]:多级海报任务阶段<br/>[任务领取时间]:海报领取日期<br/>[海报有效期]:海报有效日期<br/>[任务执行者昵称]:任务执行者<br/>[海报扫描者昵称]:海报扫描者<br/>[任务目标]:任务目标人数<br/>[完成数量]:已推广人数<br/>[还需完成数量]:未完成人数<br/>[关注奖励列表]:奖励列表<br/>[积分奖励]:奖励积分数<br/>[余额奖励]:奖励余额<br/>[优惠券奖励]:奖励优惠卷数量';
		include $this->template();
	}

	private function post($data)
	{
		global $_W;
		$defaultcount = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		$default = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		if (0 < $defaultcount) {
			$default = unserialize($default);
			$default['starttext'] = $data['starttext'];
			$default['endtext'] = $data['endtext'];
			$default['waittext'] = $data['waittext'];
			$default['opentext'] = $data['opentext'];
			$default['templateid'] = $data['templateid'];
			$default['taskinfotitle'] = $data['taskinfotitle'];
			$default['taskinfo'] = serialize($data['taskinfo']);
			$default['menu_state'] = $data['menu_state'];
			$default['is_posterall'] = $data['is_posterall'];
			$default['taskranktitle'] = trim($data['taskranktitle']);
			$default['taskranktype'] = intval($data['taskranktype']);
			$default['getposter'] = array('value' => $data['getposter'], 'color' => $data['getpostercolor']);
			$default['successtasker'] = array(
				'first'    => array('value' => $data['succestaskerfirst'], 'color' => $data['succestaskerfirstcolor']),
				'keyword1' => array('value' => $data['succestaskername'], 'color' => $data['succestaskernamecolor']),
				'keyword2' => array('value' => $data['succestaskertype'], 'color' => $data['succestaskertypecolor']),
				'remark'   => array('value' => $data['succestaskerremark'], 'color' => $data['succestaskerremarkcolor'])
			);
			$default['successscaner'] = array(
				'first'    => array('value' => $data['successcanerfirst'], 'color' => $data['successcanerfirstcolor']),
				'keyword1' => array('value' => $data['successcanername'], 'color' => $data['successcanernamecolor']),
				'keyword2' => array('value' => $data['successcanertype'], 'color' => $data['successcanertypecolor']),
				'remark'   => array('value' => $data['successcanerremark'], 'color' => $data['successcanerremarkcolor'])
			);
			$default['complete'] = array(
				'first'    => array('value' => $data['completefirst'], 'color' => $data['completefirstcolor']),
				'keyword1' => array('value' => $data['completetaskname'], 'color' => $data['completetasknamecolor']),
				'keyword2' => array('value' => $data['completetype'], 'color' => $data['completetypecolor']),
				'remark'   => array('value' => $data['completeremark'], 'color' => $data['completeremarkcolor'])
			);
			$default['rankcomplete'] = array(
				'first'    => array('value' => $data['rankcompletefirst'], 'color' => $data['rankcompletefirstcolor']),
				'keyword1' => array('value' => $data['rankcompletetaskname'], 'color' => $data['rankcompletetasknamecolor']),
				'keyword2' => array('value' => $data['rankcompletetype'], 'color' => $data['rankcompletetypecolor']),
				'remark'   => array('value' => $data['rankcompleteremark'], 'color' => $data['rankcompleteremarkcolor'])
			);
			$default['completed'] = array(
				'first'    => array('value' => $data['completedfirst'], 'color' => $data['completedfirstcolor']),
				'keyword1' => array('value' => $data['completedtaskname'], 'color' => $data['completedtasknamecolor']),
				'keyword2' => array('value' => $data['completedtype'], 'color' => $data['completedtypecolor']),
				'remark'   => array('value' => $data['completedremark'], 'color' => $data['completedremarkcolor'])
			);
			$default['is_completed'] = intval($data['is_completed']);
			$default['fail'] = array(
				'first'    => array('value' => '', 'color' => ''),
				'keyword1' => array('value' => $data['failtaskname'], 'color' => $data['failtasknamecolor']),
				'keyword2' => array('value' => $data['failtasknametype'], 'color' => $data['failtasknametypecolor']),
				'remark'   => array('value' => $data['failtasknameremark'], 'color' => $data['failtasknameremarkcolor'])
			);
			$default['self'] = array(
				'first'    => array('value' => '', 'color' => ''),
				'keyword1' => array('value' => $data['scanselftaskname'], 'color' => $data['scanselftasknamecolor']),
				'keyword2' => array('value' => $data['scanselftype'], 'color' => $data['scanselftypecolor']),
				'remark'   => array('value' => $data['scanselfremark'], 'color' => $data['scanselfremarkcolor'])
			);
			$default = serialize($default);
			$update_data = array('data' => $default);
			$result = pdo_update('ewei_shop_task_default', $update_data, array('uniacid' => $_W['uniacid']));

			if ($result !== false) {
				show_json(1, array('url' => webUrl('task/default')));
			}
			else {
				show_json(0, '更新失败');
			}
		}
		else {
			$default = array();
			$default['starttext'] = $data['starttext'];
			$default['endtext'] = $data['endtext'];
			$default['waittext'] = $data['waittext'];
			$default['opentext'] = $data['opentext'];
			$default['templateid'] = $data['templateid'];
			$default['taskinfo'] = $data['taskinfo'];
			$default['taskinfotitle'] = $data['taskinfotitle'];
			$default['menu_state'] = $data['menu_state'];
			$default['is_posterall'] = $data['is_posterall'];
			$default['taskranktitle'] = trim($data['taskranktitle']);
			$default['taskranktype'] = intval($data['taskranktype']);
			$default['getposter'] = array('value' => $data['getposter'], 'color' => $data['getpostercolor']);
			$default['successtasker'] = array(
				'first'    => array('value' => $data['succestaskerfirst'], 'color' => $data['succestaskerfirstcolor']),
				'keyword1' => array('value' => $data['succestaskername'], 'color' => $data['succestaskernamecolor']),
				'keyword2' => array('value' => $data['succestaskertype'], 'color' => $data['succestaskertypecolor']),
				'remark'   => array('value' => $data['succestaskerremark'], 'color' => $data['succestaskerremarkcolor'])
			);
			$default['successscaner'] = array(
				'first'    => array('value' => $data['successcanerfirst'], 'color' => $data['successcanerfirstcolor']),
				'keyword1' => array('value' => $data['successcanername'], 'color' => $data['successcanernamecolor']),
				'keyword2' => array('value' => $data['successcanertype'], 'color' => $data['successcanertypecolor']),
				'remark'   => array('value' => $data['successcanerremark'], 'color' => $data['successcanerremarkcolor'])
			);
			$default['complete'] = array(
				'first'    => array('value' => $data['completefirst'], 'color' => $data['completefirstcolor']),
				'keyword1' => array('value' => $data['completetaskname'], 'color' => $data['completetasknamecolor']),
				'keyword2' => array('value' => $data['completetype'], 'color' => $data['completetypecolor']),
				'remark'   => array('value' => $data['completeremark'], 'color' => $data['completeremarkcolor'])
			);
			$default['completed'] = array(
				'first'    => array('value' => $data['completedfirst'], 'color' => $data['completedfirstcolor']),
				'keyword1' => array('value' => $data['completedtaskname'], 'color' => $data['completedtasknamecolor']),
				'keyword2' => array('value' => $data['completedtype'], 'color' => $data['completedtypecolor']),
				'remark'   => array('value' => $data['completedremark'], 'color' => $data['completedremarkcolor'])
			);
			$default['is_completed'] = intval($data['is_completed']);
			$default['fail'] = array(
				'first'    => array('value' => '', 'color' => '#4a5077'),
				'keyword1' => array('value' => $data['failtaskname'], 'color' => $data['failtasknamecolor']),
				'keyword2' => array('value' => $data['failtasknametype'], 'color' => $data['failtasknametypecolor']),
				'remark'   => array('value' => $data['failtasknameremark'], 'color' => $data['failtasknameremarkcolor'])
			);
			$default['self'] = array(
				'first'    => array('value' => '', 'color' => ''),
				'keyword1' => array('value' => $data['scanselftaskname'], 'color' => $data['scanselftasknamecolor']),
				'keyword2' => array('value' => $data['scanselftype'], 'color' => $data['scanselftypecolor']),
				'remark'   => array('value' => $data['scanselfremark'], 'color' => $data['scanselfremarkcolor'])
			);
			$default = serialize($default);
			$insert_data = array('uniacid' => $_W['uniacid'], 'data' => $default, 'addtime' => time());
			$result = pdo_insert('ewei_shop_task_default', $insert_data);

			if (!empty($result)) {
				show_json(1, array('url' => webUrl('task/default')));
			}
			else {
				show_json(0, '更新失败');
			}
		}
	}

	public function setstart()
	{
		global $_W;
		global $_GPC;
		$defaultcount = pdo_fetchcolumn('select COUNT(*) from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		$default = pdo_fetchcolumn('select `data` from ' . tablename('ewei_shop_task_default') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		if ($_W['ispost']) {
			cv('task.edit');

			if (0 < $defaultcount) {
				$default = unserialize($default);
				$default['keyword'] = trim($_GPC['keyword']);
				$default['title'] = trim($_GPC['title']);
				$default['thumb'] = trim($_GPC['thumb']);
				$default['desc'] = trim($_GPC['desc']);

				if (empty($default['keyword'])) {
					show_json(0, '请填写关键词!');
				}

				$keyword = m('common')->keyExist($default['keyword']);

				if (!empty($keyword)) {
					if ($keyword['name'] != 'ewei_shopv2:task') {
						show_json(0, '关键字已存在!');
					}
				}

				$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2:task'));

				if (!empty($rule)) {
					$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
					$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
				}

				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:task', 'module' => 'cover', 'displayorder' => 0, 'status' => 1);

				if (empty($rule)) {
					pdo_insert('rule', $rule_data);
					$rid = pdo_insertid();
				}
				else {
					pdo_update('rule', $rule_data, array('id' => $rule['id']));
					$rid = $rule['id'];
				}

				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($default['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => 1);

				if (empty($keyword)) {
					pdo_insert('rule_keyword', $keyword_data);
				}
				else {
					pdo_update('rule_keyword', $keyword_data, array('id' => $keyword['id']));
				}

				$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'title' => $default['title'], 'description' => $default['desc'], 'thumb' => $default['thumb'], 'url' => mobileUrl('task'));

				if (empty($cover)) {
					pdo_insert('cover_reply', $cover_data);
				}
				else {
					pdo_update('cover_reply', $cover_data, array('id' => $cover['id']));
				}

				$default = serialize($default);
				$update_data = array('data' => $default, 'bgimg' => trim($_GPC['bgimg']), 'open' => intval($_GPC['open']));
				pdo_update('ewei_shop_task_default', $update_data, array('uniacid' => $_W['uniacid']));
				plog('task.set.edit', '修改入口设置');
				show_json(1);
			}
			else {
				$default = array();
				$default['keyword'] = trim($_GPC['keyword']);
				$default['title'] = trim($_GPC['title']);
				$default['thumb'] = trim($_GPC['thumb']);
				$default['desc'] = trim($_GPC['desc']);

				if (empty($default['keyword'])) {
					show_json(0, '请填写关键词!');
				}

				$keyword = m('common')->keyExist($default['keyword']);

				if (!empty($keyword)) {
					if ($keyword['name'] != 'ewei_shopv2:task') {
						show_json(0, '关键字已存在!');
					}
				}

				$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => 'ewei_shopv2:task'));

				if (!empty($rule)) {
					$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
					$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
				}

				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:task', 'module' => 'cover', 'displayorder' => 0, 'status' => 1);

				if (empty($rule)) {
					pdo_insert('rule', $rule_data);
					$rid = pdo_insertid();
				}
				else {
					pdo_update('rule', $rule_data, array('id' => $rule['id']));
					$rid = $rule['id'];
				}

				$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($default['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => 1);

				if (empty($keyword)) {
					pdo_insert('rule_keyword', $keyword_data);
				}
				else {
					pdo_update('rule_keyword', $keyword_data, array('id' => $keyword['id']));
				}

				$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'title' => $default['title'], 'description' => $default['desc'], 'thumb' => $default['thumb'], 'url' => mobileUrl('task'));

				if (empty($cover)) {
					pdo_insert('cover_reply', $cover_data);
				}
				else {
					pdo_update('cover_reply', $cover_data, array('id' => $cover['id']));
				}

				$default = serialize($default);
				$insert_data = array('uniacid' => $_W['uniacid'], 'data' => $default, 'addtime' => time());
				pdo_insert('ewei_shop_task_default', $insert_data);
			}
		}

		$set = unserialize($default);
		$bgimg = pdo_get('ewei_shop_task_default', array('uniacid' => $_W['uniacid']), array('bgimg', 'open'));
		$url = mobileUrl('task', NULL, true);
		$qrcode = m('qrcode')->createQrcode($url);
		include $this->template();
	}
}

?>
