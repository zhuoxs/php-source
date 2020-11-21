<?php
require '../../../../framework/bootstrap.inc.php';
require '../../../../addons/weliam_merchant/core/common/defines.php';
require '../../../../addons/weliam_merchant/core/common/autoload.php';
require '../../../../addons/weliam_merchant/core/function/global.func.php';
global $_W,$_GPC;
ignore_user_abort();
set_time_limit(0);

$input['time'] = date('Y-m-d H:i:s',time());
$input['siteroot'] = $_W['siteroot'];
Util::wl_log('sinaTask',PATH_DATA."tasklog", $input);
$on = $_GPC['on'] ? intval($_GPC['on']) : 0;

$queue = new Queue;
$queue -> queueMain($on);