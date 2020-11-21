<?php
	defined('IN_IA') or exit('Access Denied');
    global $_GPC, $_W;
    $uniacid = $_W['uniacid'];
    $stype = $_GPC['stype'];
    $zid = $_GPC['zid'];
    $op = $_GPC['op'];
    if($op=='display'){
	    $res = pdo_fetchall('SELECT * from' . tablename('hyb_yl_docshoushu') . "WHERE uniacid ='{$uniacid}' AND zid='{$zid}' AND stype='{$stype}'");
	    foreach ($res as $key => $value) {
	        $res[$key]['spic'] = unserialize($res[$key]['spic']);
	        $res[$key]['sthumb'] = unserialize($res[$key]['sthumb']);
	        $res[$key]['suoltu'] = $_W['attachurl'] . $res[$key]['suoltu'];
	        $num = count($res[$key]['spic']);
	        $num1 = count($res[$key]['sthumb']);
	        for ($i = 0;$i < $num;$i++) {
	            $res[$key]['spic'][$i] = $_W['attachurl'] . $res[$key]['spic'][$i];
	        }
	        for ($i = 0;$i < $num1;$i++) {
	            $res[$key]['sthumb'][$i] = $_W['attachurl'] . $res[$key]['sthumb'][$i];
	        }
	    }
	    return $this->result(0, 'success', $res);
    }
  if($op=='allfuwu'){
	    $res = pdo_fetchall('SELECT * from' . tablename('hyb_yl_docshoushu') . "WHERE uniacid ='{$uniacid}' AND stype='{$stype}'");
	    foreach ($res as $key => $value) {
	        $res[$key]['spic'] = unserialize($res[$key]['spic']);
	        $res[$key]['sthumb'] = unserialize($res[$key]['sthumb']);
	        $res[$key]['suoltu'] = $_W['attachurl'] . $res[$key]['suoltu'];
	        $num = count($res[$key]['spic']);
	        $num1 = count($res[$key]['sthumb']);
	        for ($i = 0;$i < $num;$i++) {
	            $res[$key]['spic'][$i] = $_W['attachurl'] . $res[$key]['spic'][$i];
	        }
	        for ($i = 0;$i < $num1;$i++) {
	            $res[$key]['sthumb'][$i] = $_W['attachurl'] . $res[$key]['sthumb'][$i];
	        }
	    }
	    return $this->result(0, 'success', $res);
  }