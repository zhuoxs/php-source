<?php
if ($op == "display") {
    
    $parentid = intval($_GPC['parentid']);
    $plevel = intval($_GPC['plevel']);
    $list = array();
    if ($parentid==0) {
        foreach ($lbranchall as $k => $v) {
            if (empty($lbranchall[$v['parentid']])) {
                $list[$k] = $v;
            }
        }
    }else{
        foreach ($lbranchall as $k => $v) {
            if ($v['parentid']==$parentid) {
                $list[$k] = $v;
            }
        }
    }
    $tolarr = array();
    foreach($lbranchall as $item) {
        $tolarr[$item['parentid']][$item['id']] = $item;
    }

}elseif ($op == "post") {

    $branchid = intval($_GPC['branchid']);
    if ($branchid==0) {

        $_SESSION['cparty']['lbranch'] = array();

        $_SESSION['cparty']['lbrancharr'] = $lbranchall;
        $_SESSION['cparty']['lbrancharrid'] = $lbranchallid;

    }else{
        $lbranch = $lbranchall[$branchid];
        $lbrancharr = array();
        $lbrancharrid = "";
        foreach($lbranchall as $item) {
            if (strpos($item['scort'],$lbranch['scort']) !== false) {
                $lbrancharr[$item['id']] = $item;
                $lbrancharrid .= $item['id'].",";
            }
        }
        $lbrancharrid = rtrim($lbrancharrid,',');

        $_SESSION['cparty']['lbrancharr'] = $lbrancharr;
        $_SESSION['cparty']['lbranch'] = $lbranch;
        $_SESSION['cparty']['lbrancharrid'] = $lbrancharrid; 
    }
    header('location:'.$_SERVER['HTTP_REFERER']);
    exit();
    
}
include $this->template("admin/switch");
?>