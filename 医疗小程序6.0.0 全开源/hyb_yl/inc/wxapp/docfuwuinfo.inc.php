<?php
	defined('IN_IA') or exit('Access Denied');
	global $_GPC, $_W;
	$uniacid = $_W['uniacid'];//hyb_yl_fuwutime
	$sid = $_GPC['sid'];
	$zid = $_GPC['zid'];
	$res = pdo_fetch("SELECT * FROM".tablename("hyb_yl_docshoushu")."as a left join".tablename("hyb_yl_fuwutime")."as b on b.sid=a.sid where a.uniacid ='{$uniacid}' AND a.sid='{$sid}'");
	$res['spic'] = unserialize($res['spic']);
	$res['sthumb'] = unserialize($res['sthumb']);
	$res['suoltu'] = $_W['attachurl'] . $res['suoltu'];
	$num = count($res['spic']);
	$num1 = count($res['sthumb']);
	for ($i = 0;$i < $num;$i++) {
	    $res['spic'][$i] = $_W['attachurl'] . $res['spic'][$i];
	}
	for ($i = 0;$i < $num1;$i++) {
	    $res['sthumb'][$i] = $_W['attachurl'] . $res['sthumb'][$i];
	}

   $rows = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_fuwutime") . " where uniacid ='{$uniacid}' and zid ='{$zid}' and sid='{$sid}'");
	$time = time();
	$neardate = date("Y-m-d", TIMESTAMP);
	$ga = date("w");
	foreach ($rows as $key => $value) {
	    $week['week'] = unserialize($value['week']);
	    $week['week1'] = unserialize($value['week1']);
	    $week['week2'] = unserialize($value['week2']);
	    $week['week3'] = unserialize($value['week3']);
	    $week['week4'] = unserialize($value['week4']);
	    $week['week5'] = unserialize($value['week5']);
	    $week['week6'] = unserialize($value['week6']);
	    $week['tid'] = $value['tid'];
	    echo json_encode($week);
	}
   
