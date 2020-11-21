<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $userscort = trim($_GPC['userscort']);
    
    $cate1 = pdo_fetchall("SELECT * FROM ".tablename($this->table_bbscate)." WHERE ishot=1 AND isshow=1 AND branchid IN (".$userscort.") AND uniacid=:uniacid ORDER BY priority DESC, id DESC ", array(':uniacid'=>$_W['uniacid']));
    if (!empty($cate1)) {
        foreach ($cate1 as $k => $v) {
            $cate1[$k]['cicon'] = tomedia($v['cicon']);
        }
    }

    $cate2 = pdo_fetchall("SELECT * FROM ".tablename($this->table_bbscate)." WHERE ishot=2 AND isshow=1 AND branchid IN (".$userscort.")  AND uniacid=:uniacid ORDER BY priority DESC, id DESC ", array(':uniacid'=>$_W['uniacid']));
    if (!empty($cate2)) {
        foreach ($cate2 as $k => $v) {
            $cate2[$k]['cicon'] = tomedia($v['cicon']);
        }
    }

    $this->result(0, '', array(
        'cate1' => $cate1,
        'cate2' => $cate2
        ));

}
?>