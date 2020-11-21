<?php
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = " WHERE log.uniacid=:uniacid AND u.branchid IN (".$lbrancharrid.") ";
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = $lbranchall[$branchid];
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND log.status=:status ";
        $par[':status'] = $status;
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND log.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $lessonid = intval($_GPC['lessonid']);
    if ($lessonid!=0) {
        $con .= " AND log.lessonid=:lessonid ";
        $par[':lessonid'] = $lessonid;
    }
    $chapterid = intval($_GPC['chapterid']);
    if ($chapterid!=0) {
        $con .= " AND log.chapterid=:chapterid ";
        $par[':chapterid'] = $chapterid;
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT log.*,u.branchid,u.nickname,u.realname,u.mobile,u.headpic,l.title as ltitle,c.title as ctitle FROM ".tablename($this->table_edulog)." log LEFT JOIN ".tablename($this->table_user)." u ON log.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON log.lessonid=l.id LEFT JOIN ".tablename($this->table_educhapter)." c ON log.chapterid=c.id ".$con." ORDER BY log.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(log.id) as tol FROM ".tablename($this->table_edulog)." log LEFT JOIN ".tablename($this->table_user)." u ON log.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON log.lessonid=l.id LEFT JOIN ".tablename($this->table_educhapter)." c ON log.chapterid=c.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT log.*,u.branchid,u.openid,u.nickname,u.realname,u.mobile,u.headpic,l.title as ltitle,c.title as ctitle FROM ".tablename($this->table_edulog)." log LEFT JOIN ".tablename($this->table_user)." u ON log.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON log.lessonid=l.id LEFT JOIN ".tablename($this->table_educhapter)." c ON log.chapterid=c.id ".$con." ORDER BY log.id DESC ", $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['branchid']   = $lbranchall[$v['branchid']]['name'];
            $data[$k]['openid']     = $v['openid'];
            $data[$k]['nickname']   = $v['nickname'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['ltitle']     = $v['ltitle'];
            $data[$k]['ctitle']     = $v['ctitle'];
            $data[$k]['getval']     = $v['getval'];
            $data[$k]['status']     = $v['status']==1?"学习中":"已学完";
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
        }
        $arrhead = array("ID","组织","OpenID","昵称","姓名","手机号","课程标题","章节标题","所得积分","状态","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

}
include $this->template('admin/edulog');

?>