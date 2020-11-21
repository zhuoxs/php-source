<?php
/**
* [拾光授权系统 System] Copyright (c) 2018 33f3.cn
 */
defined('IN_IA') or exit('Access Denied');
if ($do == 'online') {
	header('Location: //33f3.cn/app/api.php?referrer='.$_W['setting']['site']['key']);
	exit;
} elseif ($do == 'offline') {
	header('Location: //33f3.cn/app/api.php?referrer='.$_W['setting']['site']['key'].'&standalone=1');
	exit;
} else {
}
template('cloud/device');
