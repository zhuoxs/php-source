<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$op = $operation = $_GPC['op']?$_GPC['op']:'display';

load()->func('tpl');
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = ' WHERE m.uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND m.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $articleid = intval($_GPC['articleid']);
    if ($articleid!=0) {
        $con .= " AND m.articleid=:articleid ";
        $par[':articleid'] = $articleid;
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT m.*,u.nickname,u.realname,u.mobile,u.headpic,a.title FROM ".tablename($this->table_artmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id LEFT JOIN ".tablename($this->table_article)." a ON m.articleid=a.id ".$con." ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(m.id) as tol FROM ".tablename($this->table_artmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id LEFT JOIN ".tablename($this->table_article)." a ON m.articleid=a.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);
    foreach ($list as $k => $v) {
        $list[$k]['picall'] = iunserializer($v['picall']);
    }

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT m.*,u.branchid,u.openid,u.nickname,u.realname,u.mobile,u.headpic,a.title FROM ".tablename($this->table_artmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id LEFT JOIN ".tablename($this->table_article)." a ON m.articleid=a.id ".$con." ORDER BY m.id DESC ", $par);
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
    $artmessage = pdo_get($this->table_artmessage,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($artmessage)) {
        message('要删除的评论记录不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_artmessage, array('id' => $id));
    message('评论信息删除成功！', referer(), 'success');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_artmessage)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template('artmessage');

?>