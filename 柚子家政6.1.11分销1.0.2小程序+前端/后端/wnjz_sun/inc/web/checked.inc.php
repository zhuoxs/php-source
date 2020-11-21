<?php
global $_GPC, $_W;
// 分店数据
$sql = 'SELECT * FROM ' . tablename('wnjz_sun_servies') . ' s '.' JOIN' . tablename('wnjz_sun_buildservies') . ' bs ' . ' JOIN ' . tablename('wnjz_sun_branch') . ' b ' . ' ON ' . ' s.sid=bs.s_id' . ' AND ' . ' b.id=bs.build_id' . ' WHERE ' . ' bs.uniacid='.$_W['uniacid'] . ' AND ' . ' b.uniacid='.$_W['uniacid'] . ' AND ' . ' s.uniacid='.$_W['uniacid'];
$build = pdo_fetchall($sql);
$building = [];
foreach ($build as $k=>$v){
    $building[$v['build_id']][] = $v;
}

echo json_encode($building);
