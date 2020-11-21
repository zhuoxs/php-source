<?php
global $_GPC, $_W;
// 分店数据
$sql = ' SELECT * FROM '  . tablename('ymktv_sun_servies') . ' s '  . ' JOIN ' . tablename('ymktv_sun_building') . ' b ' . ' ON ' . ' b.id=s.b_id' . ' WHERE ' . ' b.uniacid=' . $_W['uniacid'] . ' AND ' . ' s.uniacid=' . $_W['uniacid'];
$build = pdo_fetchall($sql);
$building = [];
foreach ($build as $k=>$v){
    $building[$v['b_id']][] = $v;
}

echo json_encode($building);
