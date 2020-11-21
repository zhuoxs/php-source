<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

	$itype = empty($_GPC['itype'])?'iyear':trim($_GPC['itype']);
	$ivalue = "";
	$itypestr = "";
	switch ($itype) {
		case 'iyear':
			$itypestr = "年";
			$ivalue = empty($_GPC['ivalue'])?date('Y'):trim($_GPC['ivalue']);
			break;
        case 'iseason':
            $itypestr = "季";
            $ivalue = empty($_GPC['ivalue'])?date("Y").ceil(date("m")/3):trim($_GPC['ivalue']);
            break;
		case 'imonth':
			$itypestr = "月";
			$ivalue = empty($_GPC['ivalue'])?date('Ym'):trim($_GPC['ivalue']);
			break;
	}

    $syear = pdo_fetchcolumn("SELECT min(iyear) FROM ".tablename($this->table_integral)." WHERE isrank=1 AND uniacid=:uniacid LIMIT 0,1 ",array(':uniacid'=>$_W['uniacid']));
    $eyear = pdo_fetchcolumn("SELECT max(iyear) FROM ".tablename($this->table_integral)." WHERE isrank=1 AND uniacid=:uniacid LIMIT 0,1 ",array(':uniacid'=>$_W['uniacid']));
    $syear = empty($syear)?date("Y"):$syear;
    $eyear = empty($eyear)?date("Y"):$eyear;
    
    $iyeararr = range($eyear, $syear, 1);
    $iseasonarr = range(1, 4, 1);
    $imontharr = range(1, 12, 1);

    $userall = pdo_fetchall("SELECT id as userid, realname, '0' as intsum, priority FROM ".tablename($this->table_user)." WHERE branchid=:branchid AND uniacid=:uniacid AND recycle=0 ORDER BY priority DESC, userid DESC ", array(':branchid'=>$user['branchid'],':uniacid'=>$_W['uniacid']), 'userid');
    $uidarr = array_column($userall, 'userid');
    $uidstr = implode(',', $uidarr);

    $intlist = pdo_fetchall("SELECT userid, uniacid, ".$itype.", sum(integral) as intsum FROM ".tablename($this->table_integral)." WHERE userid IN ( ".$uidstr." ) AND isrank=1 AND ".$itype."=".$ivalue." AND uniacid=:uniacid GROUP BY userid ORDER BY intsum DESC, userid DESC ", array(':uniacid'=>$_W['uniacid']),'userid');

    foreach ($intlist as $k => $v) {
        $intlist[$k]['realname'] = $userall[$k]['realname'];
        $intlist[$k]['priority'] = $userall[$k]['priority'];
        unset($userall[$k]);
    }
    $list = $intlist + $userall;
    array_multisort(array_column($list,'intsum'),SORT_DESC,array_column($list,'priority'),SORT_DESC,$list);

}
include $this->template('intrank');
?>