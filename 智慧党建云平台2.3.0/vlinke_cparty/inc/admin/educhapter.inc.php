<?php
if ($op == 'display') { 
    $con = ' WHERE uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    $keyword = $_GPC['keyword'];
    if (!empty($keyword)) {
        $con .= " AND title LIKE :keyword ";
        $par[':keyword'] = "%".$keyword."%";
    }
    $lessonid = intval($_GPC['lessonid']);
    if ($lessonid!=0) {
        $con .= " AND lessonid=:lessonid ";
        $par[':lessonid'] = $lessonid;
        $edulesson = pdo_get($this->table_edulesson,array('id'=>$lessonid,'uniacid'=>$_W['uniacid']));
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND status=:status ";
        $par[':status'] = $status;
    }
    
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_educhapter).$con.' ORDER BY priority DESC, id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par,'id');
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_educhapter).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        $lessonids = implode(",", array_column($list,'lessonid'));
        $edulessonarr = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulesson)." WHERE id IN (".$lessonids.") AND uniacid=:uniacid ", array(':uniacid'=>$_W['uniacid']), "id");
        $keys = implode(",", array_keys($list));
        $edulogtol = pdo_fetchall("SELECT count(l.id) as tol,l.chapterid,u.branchid FROM ".tablename($this->table_edulog)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE l.chapterid IN (".$keys.") AND u.branchid IN (".$lbrancharrid.") AND l.uniacid=:uniacid GROUP BY l.chapterid ", array(':uniacid'=>$_W['uniacid']), "chapterid");
    }else{
        $edulessonarr = array();
        $edulogtol = array();
    }

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT * FROM '.tablename($this->table_educhapter).$con.' ORDER BY priority DESC, id DESC',$par);
        $statusarr = array(1=>"待审核",2=>"已归档",3=>"已隐藏");

        $edulessonarr = pdo_fetchall("SELECT id, title FROM ".tablename($this->table_edulesson)." WHERE uniacid=:uniacid ", array(':uniacid'=>$_W['uniacid']), "id");
        $edulogtol = pdo_fetchall("SELECT count(l.id) as tol,l.chapterid,u.branchid FROM ".tablename($this->table_edulog)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE u.branchid IN (".$lbrancharrid.") AND l.uniacid=:uniacid GROUP BY l.chapterid ", array(':uniacid'=>$_W['uniacid']), "chapterid");

        foreach($list_out as $k=>$v){
            $data[$k] = array(
                'id'         => $v['id'],
                'lesson'     => $edulessonarr[$v['lessonid']]['title'],
                'title'      => $v['title'],
                'needtime'   => $v['needtime'],
                'status'     => $statusarr[$v['status']],
                'edulogtol'  => intval($edulogtol[$v['id']]['tol']),
                'createtime' => date('Y-m-d H:i:s',$v['createtime'])."\t",
                'priority'   => $v['priority'],
                'link'       => $v['link'],
                );
        }
        $arrhead = array("ID","所属课程","章节标题","学习时长","状态","学习数","发布时间","排序ID","外链");
        export_excel($data,$arrhead,time());
        exit();
    }

}
include $this->template('admin/educhapter');
?>