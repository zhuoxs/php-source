<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');
load()->model('module');
load()->model('account');
load()->func('communication');
load()->model('setting');

$dos = array('display', 'post', 'list', 'del', 'extend', 'SubDisplay', 'check_scene_str', 'down_qr', 'change_status');
$do = !empty($_GPC['do']) && in_array($do, $dos) ? $do : 'list';

if ($do == 'check_scene_str') {
	$scene_str = trim($_GPC['scene_str']);
	$is_exist = pdo_fetchcolumn('SELECT id FROM ' . tablename('qrcode') . ' WHERE uniacid = :uniacid AND acid = :acid AND scene_str = :scene_str AND model = 2', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':scene_str' => $scene_str));
	if (!empty($is_exist)) {
		iajax(1, 'repeat', '');
	}
	iajax(0, 'success', '');
}

if ($do == 'list') {
	$_W['page']['title'] = '二维码管理 - 高级功能';
	$wheresql = " WHERE uniacid = :uniacid AND acid = :acid AND type = 'scene'";
	$param = array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']);
	$keyword = trim($_GPC['keyword']);
	if(!empty($keyword)) {
		$wheresql .= " AND name LIKE '%{$keyword}%'";
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('qrcode'). $wheresql . ' ORDER BY `id` DESC LIMIT '.($pindex - 1) * $psize.','. $psize, $param);
	if (!empty($list)) {
		foreach ($list as $index => &$qrcode) {
			$qrcode['showurl'] = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($qrcode['ticket']);
			$qrcode['endtime'] = $qrcode['createtime'] + $qrcode['expire'];
			if (TIMESTAMP > $qrcode['endtime']) {
				$qrcode['endtime'] = '<font color="red">已过期</font>';
			} else {
				$qrcode['endtime'] = date('Y-m-d H:i:s',$qrcode['endtime']);
			}
			if ($qrcode['model'] == 2) {
				$qrcode['modellabel']="永久";
				$qrcode['expire']="永不";
				$qrcode['endtime'] = '<font color="green">永不</font>';
			} else {
				$qrcode['modellabel']="临时";
			}
		}
		unset($qrcode);
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('qrcode') . $wheresql, $param);
	$pager = pagination($total, $pindex, $psize);

		pdo_query("UPDATE ".tablename('qrcode')." SET status = '0' WHERE uniacid = '{$_W['uniacid']}' AND model = '1' AND createtime < '{$_W['timestamp']}' - expire");
	template('platform/qr-list');
}

if ($do == 'del') {
	if ($_GPC['scgq']) {
		$list = pdo_fetchall("SELECT id FROM ".tablename('qrcode')." WHERE uniacid = :uniacid AND acid = :acid AND status = '0' AND type='scene'", array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']), 'id');
		if (!empty($list)) {
			pdo_delete('qrcode', array('id' => array_keys($list)));
			pdo_delete('qrcode_stat', array('id' => array_keys($list)));
		}
		itoast('执行成功<br />删除二维码：'.count($list), url('platform/qr/list'),'success');
	} else {
		$id = intval($_GPC['id']);
		pdo_delete('qrcode', array('id' =>$id, 'uniacid' => $_W['uniacid']));
		pdo_delete('qrcode_stat',array('qid' => $id, 'uniacid' => $_W['uniacid']));
		itoast('删除成功',url('platform/qr/list'),'success');
	}
}

if ($do == 'post') {
	$_W['page']['title'] = '生成二维码 - 二维码管理 - 高级功能';

	if (checksubmit('submit')){
				$barcode = array(
			'expire_seconds' => '',
			'action_name' => '',
			'action_info' => array(
				'scene' => array(),
			),
		);
		$qrctype = intval($_GPC['qrc-model']);
		$acid = intval($_W['acid']);
		$uniacccount = WeAccount::create($acid);
		$id = intval($_GPC['id']);
		$keyword_id = intval(trim(htmlspecialchars_decode($_GPC['reply']['reply_keyword']), "\""));;
		$keyword = pdo_get('rule_keyword', array('id' => $keyword_id), array('content'));
		if (!empty($id)) {
			$update = array(
				'keyword' => $keyword['content'],
				'name' => trim($_GPC['scene-name'])
			);
			pdo_update('qrcode', $update, array('uniacid' => $_W['uniacid'], 'id' => $id));
			itoast('恭喜，更新带参数二维码成功！', url('platform/qr/list'), 'success');
		}

		if ($qrctype == 1) {
			$qrcid = pdo_fetchcolumn("SELECT qrcid FROM ".tablename('qrcode')." WHERE acid = :acid AND model = '1' AND type = 'scene' ORDER BY qrcid DESC LIMIT 1", array(':acid' => $acid));
			$barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid + 1) : 100001;
			$barcode['expire_seconds'] = intval($_GPC['expire-seconds']);
			$barcode['action_name'] = 'QR_SCENE';
			$result = $uniacccount->barCodeCreateDisposable($barcode);
		} else if ($qrctype == 2) {
			$scene_str = trim($_GPC['scene_str']) ? trim($_GPC['scene_str'])  : itoast('场景值不能为空', '', '');
			$is_exist = pdo_fetchcolumn('SELECT id FROM ' . tablename('qrcode') . ' WHERE uniacid = :uniacid AND acid = :acid AND scene_str = :scene_str AND model = 2', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':scene_str' => $scene_str));
			if (!empty($is_exist)) {
				itoast("场景值:{$scene_str}已经存在,请更换场景值", '', 'error');
			}
			$barcode['action_info']['scene']['scene_str'] = $scene_str;
			$barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
			$result = $uniacccount->barCodeCreateFixed($barcode);
		} else {
			itoast('抱歉，此公众号暂不支持您请求的二维码类型！', '', '');
		}

		if (!is_error($result)) {
			$insert = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $acid,
				'qrcid' => $barcode['action_info']['scene']['scene_id'],
				'scene_str' => $barcode['action_info']['scene']['scene_str'],
				'keyword' => $keyword['content'],
				'name' => $_GPC['scene-name'],
				'model' => $_GPC['qrc-model'],
				'ticket' => $result['ticket'],
				'url' => $result['url'],
				'expire' => $result['expire_seconds'],
				'createtime' => TIMESTAMP,
				'status' => '1',
				'type' => 'scene',
			);
			pdo_insert('qrcode', $insert);
			itoast('恭喜，生成带参数二维码成功！', url('platform/qr/list', array('name' => 'qrcode')), 'success');
		} else {
			itoast("公众平台返回接口错误. <br />错误代码为: {$result['errorcode']} <br />错误信息为: {$result['message']}", '', '');
		}
	}

	if (!empty($_GPC['id'])) {
		$id = intval($_GPC['id']);
		$row = pdo_fetch("SELECT * FROM ".tablename('qrcode')." WHERE uniacid = {$_W['uniacid']} AND id = '{$id}'");
		$rid = pdo_get('rule_keyword', array('uniacid' => $_W['uniacid'], 'content' => $row['keyword']), array('rid'));
		$rid = $rid['rid'];
				$setting_keyword = $row['keyword'];
	}
	template('platform/qr-post');
}

if ($do == 'extend') {
	$id = intval($_GPC['id']);
	if (!empty($id)) {
		$qrcrow = pdo_fetch("SELECT * FROM ".tablename('qrcode')." WHERE uniacid = :uniacid AND id = :id LIMIT 1", array(':uniacid' => $_W['uniacid'], ':id' => $id));
		$update = array();
		if ($qrcrow['model'] == 1) {
			$uniacccount = WeAccount::create($qrcrow['acid']);
			$barcode['action_info']['scene']['scene_id'] = $qrcrow['qrcid'];
			$barcode['expire_seconds'] = 2592000;
			$barcode['action_name'] = 'QR_SCENE';
			$result = $uniacccount->barCodeCreateDisposable($barcode);
			if (is_error($result)) {
				itoast($result['message'], '', 'error');
			}
			$update['ticket'] = $result['ticket'];
			$update['url'] = $result['url'];
			$update['expire'] = $result['expire_seconds'];
			$update['createtime'] = TIMESTAMP;
			pdo_update('qrcode', $update, array('id' => $id, 'uniacid' => $_W['uniacid']));
		}
		itoast('恭喜，延长临时二维码时间成功！', referer(), 'success');
	}
}

if ($do == 'display' || $do == 'change_status') {
	$status_setting = setting_load('qr_status');
	$status = $status_setting['qr_status']['status'];
}

if ($do == 'display') {
	$_W['page']['title'] = '扫描统计 - 二维码管理 - 高级功能';
	$pindex = max(1, intval($_GPC['page']));
	$psize = 30;
	$qrcode_table = table('qrcode');
	$starttime = empty($_GPC['time']['start']) ? TIMESTAMP -  86399 * 30 : strtotime($_GPC['time']['start']);
	$endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 6*86400 : strtotime($_GPC['time']['end']) + 86399;

	$qrcode_table->searchTime($starttime, $endtime);
	$keyword = trim($_GPC['keyword']);
	if (!empty($keyword)) {
		$qrcode_table->searchKeyword($keyword);
	}
	$qrcode_table->searchWithPage($pindex, $psize);
	$list = $qrcode_table->qrcodeStaticList($status);
	$total = $count = $qrcode_table->getLastQueryTotal();

	if (!empty($list)) {
		$openid = array();
		foreach ($list as $qrcode) {
			if (!in_array($qrcode['openid'], $openid)) {
				$openid[] = $qrcode['openid'];
			}
		}
		unset($qrcode);
		$fans_table = table('fans');
		$nickname = $fans_table->fansAll($openid);
	}
	$pager = pagination($total, $pindex, $psize);
	template('platform/qr-display');
}

if ($do == 'down_qr') {
	$id = intval($_GPC['id']);
	$down = pdo_get('qrcode', array('id' => $id));
	$pic = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($down['ticket']);
	header("Cache-control:private");
	header('content-type:image/jpeg');
	header('content-disposition: attachment;filename="'.$down['name'].'.jpg"');
	readfile($pic);
	exit();
}

if ($do == 'change_status') {
	$up_status['status'] = empty($status) ? 1 : 0;
	$update = setting_save($up_status, 'qr_status');
	if ($update) {
		iajax(0, '');
	}
	iajax(-1, '更新失败', url('platform/qr/display'));
}
