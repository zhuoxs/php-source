<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('cloud');
load()->func('cron');
$_W['page']['title'] = '计划任务 - 公众号选项';
$dos = array('list', 'post', 'del', 'run', 'status', 'sync');
$do = in_array($do, $dos) ? $do : 'list';
if($do == 'sync') {
	$id = intval($_GPC['id']);
	$data = pdo_get('core_cron', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($data)) {
		message('任务不存在或已经删除', referer(), 'error');
	}
	$result = cloud_cron_get($data['cloudid']);
	if(is_error($result)) {
		message($result['message'], referer(), 'error');
	}
	$cron = $result['message'];
	if(!is_array($cron)) {
		message('从云服务同步数据出错', referer(), 'error');
	}
	$cron['id'] = $data['id'];
	unset($cron['siteid'], $cron['failed_number'], $cron['extra']);
	pdo_update('core_cron', $cron, array('uniacid' => $_W['uniacid'], 'id' => $id));
	message('同步计划任务成功', referer(), 'success');
}

if($do == 'post') {
	$id = intval($_GPC['id']);
	if(!empty($id)) {
		$data = pdo_get('core_cron', array('uniacid' => $_W['uniacid'], 'id' => $id));
		if(empty($data)) {
			message('任务不存在或已经删除', referer(), 'error');
		}
		$result = cloud_cron_get($data['cloudid']);
		if(is_error($result)) {
			message("从云服务获取任务失败，详情：{$result['message']}", referer(), 'error');
		}
		$cron = $result['message'];
		$cron['minute'] = str_replace("\t", ',', $cron['minute']);
	} else {
		$cron = array('weekday' => -1, 'day' => -1, 'hour' => -1, 'type' => 1, 'lastruntime' => TIMESTAMP + 86400, 'minute' => rand(1, 59));
	}

	if(checksubmit('form')) {
		$data['uniacid'] = $_W['uniacid'];
		$data['createtime'] = TIMESTAMP;
		$data['name'] = trim($_GPC['name']) ? trim($_GPC['name']) : message('请填写任务名称', '', 'error');
		$data['filename'] = trim($_GPC['filename']) ? trim($_GPC['filename']) : message('请填写任务脚本文件名称', '', 'error');
		$data['type'] = intval($_GPC['type']);
		if($data['type'] == 1) {
			$data['lastruntime'] = $data['nextruntime'] = strtotime($_GPC['executetime']);
			if($data['lastruntime'] <= TIMESTAMP + 3600) {
				message('定时任务的执行时间不能早于当前时间', '', 'error');
			}
		}
		$data['status'] = intval($_GPC['status']);
		$data['day'] = intval($_GPC['weekday']) == -1 ? intval($_GPC['day']) : -1;
		$data['weekday'] = intval($_GPC['weekday']);
		$data['hour'] = intval($_GPC['hour']);
		$data['module'] = trim($_GPC['module']);
		$_GPC['minute'] = str_replace('，', ',', $_GPC['minute']);
		if(strpos($_GPC['minute'], ',') !== FALSE) {
			$minutenew = explode(',', $_GPC['minute']);
			foreach($minutenew as $key => $val) {
				$minutenew[$key] = $val = intval($val);
				if($val < 0 || $var > 59) {
					unset($minutenew[$key]);
				}
			}
			$minutenew = array_slice(array_unique($minutenew), 0, 2);
			$minutenew = implode("\t", $minutenew);
		} else {
			$minutenew = intval($_GPC['minute']);
			$minutenew = $minutenew >= 0 && $minutenew < 60 ? $minutenew : '';
		}
		$data['minute'] = $minutenew;
		if($id > 0) {
			$data['id'] = $cron['cloudid'];
			$status = cloud_cron_update($data);
			if(is_error($status)) {
				message($status['message'], '', 'error');
			}
			$data['id'] = $id;
			unset($data['cloudid']);
			pdo_update('core_cron', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			message('编辑计划任务成功', url('cron/display/list'), 'success');
		} else {
			$status = cloud_cron_create($data);
			if(is_error($status)) {
				message($status['message'], '', 'error');
			}
			$data['cloudid'] = $status['cron_id'];
			pdo_insert('core_cron', $data);
			message('添加计划任务成功', url('cron/display/list'), 'success');
		}
	}

		$modules_temp = uni_modules();
	$modules['task'] = array('name' => 'task', 'title' => '系统任务');
	foreach($modules_temp as $module) {
		if(!$module['issystem']) {
			$modules[$module['name']] = array('name' => $module['name'], 'title' => $module['title']);
		}
	}
}

if($do == 'list') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('core_cron') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
	$crons = pdo_fetchall('SELECT * FROM ' . tablename('core_cron') . ' WHERE uniacid = :uniacid ORDER BY id DESC LIMIT ' . ($pindex - 1) * $psize . ", {$psize}", array(':uniacid' => $_W['uniacid']));
	$pager = pagination($total, $pindex, $psize);
	if(!empty($crons)) {
		foreach($crons as &$cron) {
			$id = $cron['id'];
			$result = array();
			$result = cloud_cron_get($cron['cloudid']);
			if(!is_error($result) && is_array($result['message'])) {
				$cron = $result['message'];
				$cron['id'] = $id;
				unset($cron['siteid'], $cron['failed_number'], $cron['extra']);
				pdo_update('core_cron', $cron, array('uniacid' => $_W['uniacid'], 'id' => $id));
			}
		}
	}
	$weekday_cn = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
	if(!empty($crons)) {
		foreach($crons as &$cron) {
			$modules[] = $cron['module'];
			$cn = '';
			if($cron['day'] > 0 && $cron['day'] < 32) {
				$cn = '每月' . $cron['day'] . '日';
			} elseif($cron['weekday'] >= 0 &&  $cron['weekday'] < 7) {
				$cn = '每' . $weekday_cn[$cron['weekday']];
			} elseif($cron['hour'] >= 0 && $cron['hour'] < 24) {
				$cn = '每天';
			} else{
				$cn = '每小时';
			}
			$cn .= ($cron['hour'] >= 0 && $cron['hour'] < 24) ? sprintf('%02d', $cron['hour']) . '时' : '';
			if(!in_array($cron['minute'], array(-1, ''))) {
				foreach($cron['minute'] = explode("\t", $cron['minute']) as $k => $v) {
					$cron['minute'][$k] = sprintf('%02d', $v);
				}
				$cron['minute'] = implode(',', $cron['minute']);
				$cn .= $cron['minute'] . '分';
			} else {
				$cn .= '00分';
			}
			$cron['lastruntime'] = $cron['lastruntime'] ? date('Y-m-d H:i:s', $cron['lastruntime']) : 'N/A';
			$cron['nextruntime'] = $cron['nextruntime'] ? date('Y-m-d H:i:s', $cron['nextruntime']) : 'N/A';
			$cron['run'] = $cron['status'];

			$cron['cn'] = $cn;
		}
		if(!empty($modules)) {
			$modules = "'" . implode($modules, "','") .  "'";
			$modules = pdo_fetchall('SELECT title,name FROM ' .tablename('modules') . " WHERE name IN ({$modules})", array(), 'name');
			$modules['task'] = array('name' => 'task', 'title' => '系统任务');
		}
	}
}
if($do == 'del') {
	$ids = $_GPC['id'];
	if(!is_array($ids)) {
		$ids = array($ids);
	}
	if(!empty($ids)) {
		foreach($ids as $id) {
			$id = intval($id);
			if($id > 0) {
				$cron = pdo_get('core_cron', array('uniacid' => $_W['uniacid'], 'id' => $id));
				if(!empty($cron)) {
					$result = cloud_cron_remove($cron['cloudid']);
					if(!is_error($result)) {
						pdo_delete('core_cron', array('uniacid' => $_W['uniacid'], 'id' => $id));
					} else {
						message("删除{$cron['title']}失败", url('cron/display/list'), 'error');
					}
				}
			}
		}
		message('删除计划任务成功', url('cron/display/list'), 'success');
	} else {
		message('没有选择要删除的任务', referer(), 'error');
	}
}

if($do == 'run') {
	$id = intval($_GPC['id']);
	$status = cron_run($id);
	if(is_error($status)) {
		message($status['message'], referer(), 'error');
	}
	message('执行计划任务成功', referer(), 'success');
}

if($do == 'status') {
	$id = intval($_GPC['id']);
	$status = intval($_GPC['status']);
	if(!in_array($status, array(0, 1))) {
		exit('状态码错误');
	}
	$cron = pdo_get('core_cron', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($cron)) {
		exit('任务不存在或已删除');
	}
	$result = cloud_cron_change_status($cron['cloudid'], $status);
	if(is_error($result)) {
		exit($result['message']);
	}
	pdo_update('core_cron', array('status' => $status), array('uniacid' => $_W['uniacid'], 'id' => $id));
	exit('success');
}

template('cron/display');

