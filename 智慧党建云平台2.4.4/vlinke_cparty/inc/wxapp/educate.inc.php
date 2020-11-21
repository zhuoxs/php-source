<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $catelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_educate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');
    if (!empty($catelist)) {
        foreach ($catelist as $k => $v) {
            $catelist[$k]['cicon'] = tomedia($v['cicon']);
        }
    }
    $this->result(0, '', array(
        'catelist' => $catelist
        ));

}elseif ($op=="getmore") {

    $con = " WHERE tab.status IN (1,2) AND tab.uniacid=:uniacid ";
    $par = array(':uniacid'=>$_W['uniacid']);
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND tab.cateid=:cateid ";
        $par['cateid'] = $cateid;
    }
    $stustatus = intval($_GPC['stustatus']);
    if ($stustatus!=0) {
        $con .= " AND tab.stustatus=:stustatus ";
        $par['stustatus'] = $stustatus;
    }
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));   
    $list = pdo_fetchall("SELECT tab.* FROM ".tablename($this->table_edulesson)." tab ".$con." ORDER BY tab.priority DESC, tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par);

    $userid = intval($_GPC['userid']);
    if (!empty($list)) {
        $lessonidarr = array_column($list,"id");
        $lessonidstr = implode(",",$lessonidarr);
        $edustudy = pdo_fetchall("SELECT * FROM ".tablename($this->table_edustudy)." WHERE userid=:userid AND uniacid=:uniacid AND lessonid IN (".$lessonidstr.") ", array(':userid'=>$userid,':uniacid'=>$_W['uniacid']), "lessonid");
        foreach ($list as $k => $v) {
            $list[$k]['tilpic'] = tomedia($v['tilpic']);
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
            if (empty($edustudy[$v['id']])) {
                $list[$k]['studystatus'] = "未开始";
            }else{
                $list[$k]['studystatus'] = $edustudy[$v['id']]['status']==1?"学习中":"已完成";
            }
        }
    }
    $this->result(0, '', $list);

}
include $this->template('educate');
?>