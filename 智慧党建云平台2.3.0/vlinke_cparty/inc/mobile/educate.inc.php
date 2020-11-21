<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $cateid = intval($_GPC['cateid']);
    $stustatus = intval($_GPC['stustatus']);

    $keywords = trim($_GPC['keywords']);
    $dostudy = trim($_GPC['dostudy']);

    $educatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_educate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');
    $educate = $educatelist[$cateid];

}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $con = " WHERE status IN (1,2) AND uniacid=:uniacid ";
    $par = array(':uniacid'=>$_W['uniacid']);

    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND title LIKE :keywords ";
        $par['keywords'] = "%".$keywords."%";
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND cateid=:cateid ";
        $par['cateid'] = $cateid;
    }
    $stustatus = intval($_GPC['stustatus']);
    if ($stustatus!=0) {
        $con .= " AND stustatus=:stustatus ";
        $par['stustatus'] = $stustatus;
    }
    $dostudy = trim($_GPC['dostudy']);
    if ($dostudy=="nostudy") {
        $studyall = pdo_fetchall("SELECT id, lessonid FROM ".tablename($this->table_edustudy)." WHERE userid=:userid AND uniacid=:uniacid ", array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']), "lessonid");
        if (!empty($studyall)) {
            $stukeys = array_keys($studyall);
            $stukeysstr = implode(",",$stukeys);
            $con .= " AND id NOT IN (".$stukeysstr.") ";
        }
    }elseif ($dostudy=="dostudy") {
        $studyall = pdo_fetchall("SELECT id, lessonid FROM ".tablename($this->table_edustudy)." WHERE status=1 AND userid=:userid AND uniacid=:uniacid ", array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']), "lessonid");
        if (!empty($studyall)) {
            $stukeys = array_keys($studyall);
            $stukeysstr = implode(",",$stukeys);
            $con .= " AND id IN (".$stukeysstr.") ";
        }
    }elseif ($dostudy=="okstudy") {
        $studyall = pdo_fetchall("SELECT id, lessonid FROM ".tablename($this->table_edustudy)." WHERE status=2 AND userid=:userid AND uniacid=:uniacid ", array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']), "lessonid");
        if (!empty($studyall)) {
            $stukeys = array_keys($studyall);
            $stukeysstr = implode(",",$stukeys);
            $con .= " AND id IN (".$stukeysstr.") ";
        }
    }
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulesson).$con." ORDER BY priority DESC, id DESC LIMIT ".($pindex-1) * $psize.','.$psize, $par, "id");

    if (empty($list)) {
        exit("NOTHAVE");
    }

    $keys = array_keys($list);
    $keysstr = implode(",",$keys);
    $edustudy = pdo_fetchall("SELECT * FROM ".tablename($this->table_edustudy)." WHERE lessonid IN (".$keysstr.") AND userid=:userid AND uniacid=:uniacid ", array(':userid'=>$user['id'],':uniacid'=>$_W['uniacid']), "lessonid");

}
include $this->template('educate');
?>