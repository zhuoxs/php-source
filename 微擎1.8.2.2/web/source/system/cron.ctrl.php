<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
$dos = array('list', 'post', 'del', 'run');
$do = in_array($do, $dos) ? $do : 'list';

if($do == 'post') {
	$id = intval($_GPC['id']);
	if(!empty($id)) {
		$cron = pdo_fetch('SELECT * FROM ' . tablename('cron') . ' WHERE cronid = :id', array(':id' => $id));
		if(empty($cron)) {
			message('任务不存在或已删除', '', 'error');
		}
		$cron['minute'] = str_replace("\t", ',', $cron['minute']);
	} else {
		$cron = array('weekday' => -1, 'day' => -1, 'hour' => -1);
	}

	if(checksubmit('submit')) {
		$data['name'] = trim($_GPC['name']) ? trim($_GPC['name']) : message('请填写任务名称', '', 'error');
		$data['filename'] = trim($_GPC['filename']) ? trim($_GPC['filename']) : message('请填写任务脚本文件名称', '', 'error');
		$data['available'] = intval($_GPC['available']);
		$data['day'] = intval($_GPC['weekday']) == -1 ? intval($_GPC['day']) : -1;
		$data['weekday'] = intval($_GPC['weekday']);
		$data['hour'] = intval($_GPC['hour']);
		$data['module'] = 'system';

		if(strpos($_GPC['minute'], ',') !== FALSE) {
			$minutenew = explode(',', $_GPC['minute']);
			foreach($minutenew as $key => $val) {
				$minutenew[$key] = $val = intval($val);
				if($val < 0 || $var > 59) {
					unset($minutenew[$key]);
				}
			}
			$minutenew = array_slice(array_unique($minutenew), 0, 12);
			$minutenew = implode("\t", $minutenew);
		} else {
			$minutenew = intval($_GPC['minute']);
			$minutenew = $minutenew >= 0 && $minutenew < 60 ? $minutenew : '';
		}
		$data['minute'] = $minutenew;
		if($id > 0) {
			pdo_update('cron', $data, array('cronid' => $id));
			message('编辑计划任务成功', url('system/cron'), 'success');
		} else {
			pdo_insert('cron', $data);
			message('添加计划任务成功', url('system/cron'), 'success');
		}
	}
}

if($do == 'list') {
	$crons = pdo_fetchall('SELECT * FROM ' . tablename('cron') . ' ORDER BY cronid ASC');
	$weekday_cn = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
	if(!empty($crons)) {
		foreach($crons as &$cron) {
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
			$cron['lastrun'] = $cron['lastrun'] ? date('Y-m-d H:i:s', $cron['lastrun']) : 'N/A';
			$cron['nextrun'] = $cron['nextrun'] ? date('Y-m-d H:i:s', $cron['nextrun']) : 'N/A';
			$cron['run'] = $cron['available'];

			$cron['cn'] = $cn;
		}
	}
}
if($do == 'del') {
	if(checksubmit('submit')) {
		echo 90;
		$ids = $_GPC['cronid'];
		if(!empty($ids)) {
			$idstr = implode(',', $ids);
			if(preg_match('/^(\d{1,10},)*(\d{1,10})$/', $idstr)) {
				$state = pdo_query('DELETE FROM ' . tablename('cron') . " WHERE cronid IN ({$idstr})");
				if($state !== false) {
										message('删除计划任务成功', url('system/cron'), 'success');
				} else {
					message('删除计划任务失败', url('system/cron'), 'error');
				}
			}
		}
	}
}

if($do == 'run') {
	$id = intval($_GPC['id']);
	load()->func('cron');
	cron_run($id);
	message('执行计划任务成功', url('system/cron/list'), 'success');
}
template('system/cron');
