<?php
//获取门店课程
global $_GPC, $_W;
$name = $_GPC['name'];
$res = pdo_getall('byjs_sun_coach',array('uniacid'=>$_W['uniacid'],'mall'=>$name),'coach_name');
echo json_encode($res) ;