<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$id = intval($_W['cron']['extra']);
$data = pdo_get('mc_mass_record', array('uniacid' => $_W['uniacid'], 'id' => $id));
if(empty($data)) {
	$this->addCronLog($id, -1100, '未找到群发的设置信息');
}
$acc = WeAccount::createByUniacid();
if(is_error($acc)) {
	$this->addCronLog($id, -1101, '创建公众号操作对象失败');
}

$status = $acc->fansSendAll($data['group'], $data['msgtype'], $data['media_id']);
if(is_error($status)) {
	pdo_update('mc_mass_record', array('status' => 2, 'finalsendtime' => TIMESTAMP), array('uniacid' => $_W['uniacid'], 'id' => $id));
	$this->addCronLog($id, -1102, $status['message']);
}
pdo_update('mc_mass_record', array('status' => 0, 'finalsendtime' => TIMESTAMP), array('uniacid' => $_W['uniacid'], 'id' => $id));
pdo_delete('core_cron', array('uniacid' => $_W['uniacid'], 'id' => $_W['cron']['id']));
$this->addCronLog($id, 0, 'success');


