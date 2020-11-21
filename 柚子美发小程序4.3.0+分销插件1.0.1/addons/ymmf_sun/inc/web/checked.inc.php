<?php
global $_GPC, $_W;
// 分店数据
$sql = ' SELECT * FROM '  . tablename('ymmf_sun_hairers') . ' s '  . ' JOIN ' . tablename('ymmf_sun_branch') . ' b ' . ' JOIN ' . tablename('ymmf_sun_buildhair') . ' bh ' . ' ON ' . ' s.id=bh.hair_id ' . ' AND ' . ' b.id=bh.build_id' . ' WHERE ' . ' s.uniacid='.$_W['uniacid'] . ' AND ' . ' b.uniacid=' . $_W['uniacid'] . ' AND ' . ' bh.uniacid='.$_W['uniacid'];
$build = pdo_fetchall($sql);

$building = [];
foreach ($build as $k=>$v){
    $building[$v['build_id']][] = $v;
}
echo json_encode($building);
