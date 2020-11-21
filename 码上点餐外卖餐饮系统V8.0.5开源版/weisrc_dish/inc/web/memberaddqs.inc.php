<?php
global $_W, $_GPC;
$weid = $this->_weid;
load()->func('tpl');
$GLOBALS['frames'] = $this->getMainMenu();
$action = 'memberaddqs';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$days = intval($_GPC['days']);
if (empty($_GPC['search'])) {
    $days = 7;
}
$years        = array();
$current_year = date('Y');
$year         = $_GPC['year'];
for ($i = $current_year - 10; $i <= $current_year; $i++) {
    $years[] = array('data' => $i, 'selected' => ($i == $year));
}
$months        = array();
$current_month = date('m');
$month         = $_GPC['month'];
for ($i = 1; $i <= 12; $i++) {
    $months[] = array('data' => $i, 'selected' => ($i == $month));
}
if ($operation == 'display') {
    $commoncondition = " weid = '{$_W['uniacid']}' ";
    $timefield = empty($isagent) ? 'createtime' : 'agenttime';
    $datas     = array();
    $title     = '';
    if (!empty($days)) {
        $charttitle = "最近{$days}天增长趋势图";
        for ($i = $days; $i >= 0; $i--) {
            $time = date("Y-m-d", strtotime("-" . $i . " day"));
            ///$commoncondition .= "  and {$timefield}>=:starttime and {$timefield}<=:endtime";
            $params = array(':starttime' => strtotime("{$time} 00:00:00"), ':endtime' => strtotime("{$time} 23:59:59"));
            $mcount = pdo_fetchcolumn("select count(*) from " . tablename($this->table_fans) . " where  {$commoncondition} and dateline >=:starttime and dateline <=:endtime", $params);
            $mcount = empty($mcount)? 0 :$mcount;

            $params2 = array(':uniacid' => $_W['uniacid'],':starttime' => strtotime("{$time} 00:00:00"), ':endtime' => strtotime("{$time} 23:59:59"));
            $acount =  pdo_fetchcolumn("select count(*) from " . tablename('mc_members') . " where uniacid =:uniacid and createtime >=:starttime and createtime <=:endtime", $params2);
            $acount = empty($acount)? 0 :$acount;
            
            $datas[] = array('date' => $time, 'mcount' => $mcount, 'acount' =>$acount);
        }
    } else if (!empty($year) && !empty($month)) {
    $charttitle = "{$year}年{$month}月增长趋势图";
    $lastday = date('t', strtotime("{$year}-{$month} -1"));    
    for ($d = 1; $d <= $lastday; $d++) {
       // $commoncondition .= " and uniacid=:uniacid and {$timefield}>=:starttime and {$timefield}<=:endtime";
        $params = array(':starttime' => strtotime("{$year}-{$month}-{$d} 00:00:00"), ':endtime' => strtotime("{$year}-{$month}-{$d} 23:59:59"));

        $mcount = pdo_fetchcolumn("select count(*) from " . tablename($this->table_fans) . " where  {$commoncondition} and dateline >=:starttime and dateline <=:endtime", $params);
        $mcount = empty($mcount)? 0 :$mcount;

        $params2 = array(':uniacid' => $_W['uniacid'],':starttime' => strtotime("{$year}-{$month}-{$d} 00:00:00"), ':endtime' => strtotime("{$year}-{$month}-{$d} 23:59:59"));

        $acount =  pdo_fetchcolumn("select count(*) from " . tablename('mc_members') . " where uniacid =:uniacid and createtime >=:starttime and createtime <=:endtime", $params2);
        $acount = empty($acount)? 0 :$acount;

        $datas[] = array('date' => "{$d}日", 'mcount' => $mcount, 'acount' => $acount);
    }
} else if (!empty($year)) {
    $charttitle = "{$year}年增长趋势图";
    foreach ($months as $m) {
        $lastday = date('t', strtotime("{$year}-{$m['data']} -1"));
        //$lastday = get_last_day($year, $m['data']);
        $params = array(':starttime' => strtotime("{$year}-{$m['data']}-01 00:00:00"), ':endtime' => strtotime("{$year}-{$m['data']}-{$lastday} 23:59:59"));

        $mcount = pdo_fetchcolumn("select count(*) from " . tablename($this->table_fans) . " where  {$commoncondition} and dateline >=:starttime and dateline <=:endtime", $params);
        $mcount = empty($mcount)? 0 :$mcount;

        $params2 = array(':uniacid' => $_W['uniacid'],':starttime' => strtotime("{$year}-{$m['data']}-01 00:00:00"), ':endtime' => strtotime("{$year}-{$m['data']}-{$lastday} 23:59:59"));

        $acount =  pdo_fetchcolumn("select count(*) from " . tablename('mc_members') . " where uniacid =:uniacid and createtime >=:starttime and createtime <=:endtime", $params2);
        $acount = empty($acount)? 0 :$acount;

        $datas[] = array('date' =>$m['data'] . "月", 'mcount' => $mcount, 'acount' => $acount);
        
    }   
}    

}
include $this->template('web/memberaddqs');