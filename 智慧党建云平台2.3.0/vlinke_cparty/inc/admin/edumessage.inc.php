<?php
load()->func('tpl');
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = " WHERE m.uniacid=:uniacid AND u.branchid IN (".$lbrancharrid.") ";
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = $lbranchall[$branchid];
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND m.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $lessonid = intval($_GPC['lessonid']);
    if ($lessonid!=0) {
        $con .= " AND m.lessonid=:lessonid ";
        $par[':lessonid'] = $lessonid;
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT m.*,u.branchid,u.nickname,u.realname,u.mobile,u.headpic,l.title FROM ".tablename($this->table_edumessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON m.lessonid=l.id ".$con." ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(m.id) as tol,u.branchid FROM ".tablename($this->table_edumessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON m.lessonid=l.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);
    foreach ($list as $k => $v) {
        $list[$k]['picall'] = iunserializer($v['picall']);
    }

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT m.*,u.branchid,u.openid,u.nickname,u.realname,u.mobile,u.headpic,l.title FROM ".tablename($this->table_edumessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id LEFT JOIN ".tablename($this->table_edulesson)." l ON m.lessonid=l.id ".$con." ORDER BY m.id DESC ", $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['branchid']   = $v['branchid'];
            $data[$k]['openid']     = $v['openid'];
            $data[$k]['nickname']   = $v['nickname'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['title']      = $v['title'];
            $data[$k]['details']    = $v['details'];
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
        }
        $arrhead = array("ID","组织ID","OpenID","昵称","姓名","手机号","文章标题","留言信息","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

} elseif ($op=='delete') {
    $id = intval($_GPC['id']);
    $edumessage = pdo_fetch("SELECT m.*, u.branchid FROM ".tablename($this->table_edumessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.id=:id AND u.branchid IN (".$lbranchallid.") AND m.uniacid=:uniacid LIMIT 1 ", array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($edumessage)) {
        message_tip("你无权限删除该评论信息！", $this->createWebUrl('admin', array('r'=>'edumessage')), 'error');
    }
    pdo_delete($this->table_edumessage, array('id' => $id));
    message('评论信息删除成功！', referer(), 'success');

}
include $this->template('admin/edumessage');

?>