<?php
global $_W,$_GPC;
$GLOBALS['frames'] = $this->getMainMenu();

$ar = [
    '编号','红包金额','创建时间','操作'
];


$list = pdo_getall('byjs_sun_redpacket',array('uniacid'=>$_W['uniacid']),array('id','total','create_time','status'));
































include $this->template('web/redpacket');