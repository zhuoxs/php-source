<?php 
global $_GPC, $_W;
// 分店数据
$sql = 'SELECT a.`id`,a.`coach_name`,b.`mid`,c.`name` as mallname FROM ' . tablename('byjs_sun_coach') . ' a '.'left JOIN' . tablename('byjs_sun_mallcoach') . 'b on a.id=b.cid ' . ' left JOIN ' . tablename('byjs_sun_mall') . ' c ' . ' ON  c.id=b.mid' . ' WHERE ' . ' a.uniacid='.$_W['uniacid'] . ' AND ' . ' b.uniacid='.$_W['uniacid'] . ' AND ' . ' c.uniacid='.$_W['uniacid'];
$build = pdo_fetchall($sql);
// p($sql);
$building = [];
foreach ($build as $k=>$v){
	
    $building[$v['mid']][] = $v;
}
// echo 1;
// exit;
// p($building);
// ob_start();
echo json_encode($building);
// ob_end_flush();

