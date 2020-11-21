<?php
if ($op=='display') {

    $branchname = trim($_GPC['branchname']);
    $branchlist = array();
    if (empty($branchname)) {
        $branchlist = $lbrancharr;
    }else{
        foreach($lbrancharr as $item) {
            if (strpos($item['name'],$branchname) !== false) {
                $branchlist[$item['id']] = $item;
            }
        }
    }
    $blevelarr = array(1=>"党支部",2=>"党总支",3=>"党委",4=>"单位");
}
include $this->template('admin/checkbranch');
?>