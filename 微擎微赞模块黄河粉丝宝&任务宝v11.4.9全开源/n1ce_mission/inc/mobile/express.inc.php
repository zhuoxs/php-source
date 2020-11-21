<?php
global $_W,$_GPC;
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (strpos($user_agent, 'MicroMessenger') === false) {
	message('请在微信客户端打开','','error');
}
include $this->template('n1ce-express');