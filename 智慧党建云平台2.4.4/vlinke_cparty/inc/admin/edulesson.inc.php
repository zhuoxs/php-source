<?php
if ($op == 'display') { 
    $con = ' WHERE uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    $keyword = $_GPC['keyword'];
    if (!empty($keyword)) {
        $con .= " AND title LIKE :keyword ";
        $par[':keyword'] = "%".$keyword."%";
    }
    $cateid = intval($_GPC['cateid']);
    if ($cateid!=0) {
        $con .= " AND cateid=:cateid ";
        $par[':cateid'] = $cateid;
    }
    $stustatus = intval($_GPC['stustatus']);
    if ($stustatus!=0) {
        $con .= " AND stustatus=:stustatus ";
        $par[':stustatus'] = $stustatus;
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND status=:status ";
        $par[':status'] = $status;
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;

    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_edulesson).$con.' ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par,'id');
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_edulesson).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        $keys = implode(",", array_keys($list));
        $educhaptertol = pdo_fetchall("SELECT count(*) as tol, lessonid FROM ".tablename($this->table_educhapter)." WHERE lessonid IN (".$keys.") AND uniacid=:uniacid GROUP BY lessonid ", array(':uniacid'=>$_W['uniacid']), "lessonid");
        $edustudytol = pdo_fetchall("SELECT count(s.id) as tol,s.lessonid,u.branchid FROM ".tablename($this->table_edustudy)." s LEFT JOIN ".tablename($this->table_user)." u ON s.userid=u.id WHERE s.lessonid IN (".$keys.") AND u.branchid IN (".$lbrancharrid.") AND s.uniacid=:uniacid GROUP BY s.lessonid ", array(':uniacid'=>$_W['uniacid']), "lessonid");
    }else{
        $educhaptertol = array();
        $edustudytol = array();
    }
    $educate = pdo_getall($this->table_educate, array('uniacid'=>$_W['uniacid']), '', 'id');

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT * FROM '.tablename($this->table_edulesson).$con.' ORDER BY priority DESC, id DESC',$par,"","id");
        $statusarr = array(1=>"待续中",2=>"已结课",3=>"已隐藏");
        $stustatusarr = array(1=>"必修",2=>"选修");
        $educhaptertol = pdo_fetchall("SELECT count(*) as tol, lessonid FROM ".tablename($this->table_educhapter)." WHERE uniacid=:uniacid GROUP BY lessonid ", array(':uniacid'=>$_W['uniacid']), "lessonid");
        $edustudytol = pdo_fetchall("SELECT count(s.id) as tol,s.lessonid,u.branchid FROM ".tablename($this->table_edustudy)." s LEFT JOIN ".tablename($this->table_user)." u ON s.userid=u.id WHERE u.branchid IN (".$lbrancharrid.") AND s.uniacid=:uniacid GROUP BY s.lessonid ", array(':uniacid'=>$_W['uniacid']), "lessonid");
        foreach($list_out as $k=>$v){
            $data[$k] = array(
                'id'            => $v['id'],
                'cateid'        => $educate[$v['cateid']]['name'],
                'title'         => $v['title'],
                'integral'      => $v['integral'],
                'stustatus'     => $stustatusarr[$v['stustatus']],
                'status'        => $statusarr[$v['status']],
                'educhaptertol' => intval($educhaptertol[$v['id']]['tol']),
                'edustudytol'   => intval($edustudytol[$v['id']]['tol']),
                'createtime'    => date('Y-m-d H:i:s',$v['createtime'])."\t",
                'priority'      => $v['priority'],
                );
        }
        $arrhead = array("ID","分类","标题","学习积分","必选修","状态","章节数","学习数","时间","排序ID");
        export_excel($data,$arrhead,time());
        exit();
    }


} elseif ($op == 'checklesson') {
    $edulessontitle = trim($_GPC['edulessontitle']);
    $edulessonlist = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulesson)." WHERE uniacid=:uniacid AND title LIKE :title ORDER BY id DESC ", array(':uniacid'=>$_W['uniacid'],':title'=>"%".$edulessontitle."%"), "id");


}
include $this->template('admin/edulesson');
?>