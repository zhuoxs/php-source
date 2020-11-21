<?php
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = " WHERE s.uniacid=:uniacid AND u.branchid IN (".$lbrancharrid.") ";
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = $lbranchall[$branchid];
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND s.status=:status ";
        $par[':status'] = $status;
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND s.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $lessonid = intval($_GPC['lessonid']);
    if ($lessonid!=0) {
        $con .= " AND s.lessonid=:lessonid ";
        $par[':lessonid'] = $lessonid;
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT s.*,u.branchid,u.nickname,u.realname,u.mobile,u.headpic,l.title FROM ".tablename($this->table_edustudy)." s LEFT JOIN ".tablename($this->table_user)." u ON s.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON s.lessonid=l.id ".$con." ORDER BY s.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(s.id) as tol, sum(s.getval) as getvaltol FROM ".tablename($this->table_edustudy)." s LEFT JOIN ".tablename($this->table_user)." u ON s.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON s.lessonid=l.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT s.*,u.branchid,u.openid,u.branchid,u.nickname,u.realname,u.mobile,u.headpic,l.title FROM ".tablename($this->table_edustudy)." s LEFT JOIN ".tablename($this->table_user)." u ON s.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON s.lessonid=l.id ".$con." ORDER BY s.id DESC ", $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['branchid']   = $lbranchall[$v['branchid']]['name'];
            $data[$k]['openid']     = $v['openid'];
            $data[$k]['nickname']   = $v['nickname'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['title']      = $v['title'];
            $data[$k]['getval']     = $v['getval'];
            $data[$k]['status']     = $v['status']==1?"学习中":"已学完";
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
        }
        $arrhead = array("ID","组织","OpenID","昵称","姓名","手机号","课程标题","所得积分","状态","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

}
include $this->template('admin/edustudy');

?>