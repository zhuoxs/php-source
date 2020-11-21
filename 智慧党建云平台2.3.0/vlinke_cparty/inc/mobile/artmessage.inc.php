<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $articleid = intval($_GPC['articleid']);
    $article = pdo_get($this->table_article, array('id'=>$articleid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        message("党建动态不存在！",referer(),'error');
    }
    $branch = pdo_get($this->table_branch, array('id'=>$article['branchid'],'uniacid'=>$_W['uniacid']));

    $artmessagetol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_artmessage)." WHERE articleid=:articleid AND uniacid=:uniacid ", array(':articleid'=>$articleid,':uniacid'=>$_W['uniacid']));
    $artmessagetol = intval($artmessagetol);

    $artcatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_artcate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');
    $artcate = $artcatelist[$article['cateid']];

}elseif ($op=="getmore") {
    $articleid = intval($_GPC['articleid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_artmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.articleid=:articleid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':articleid'=>$articleid,':uniacid'=>$_W['uniacid']));
    if (empty($list)) {
        exit("NOTHAVE");
    }
    foreach ($list as $k => $v) {
        $list[$k]['picall'] = iunserializer($v['picall']);
    }

}elseif ($op=="post") {
    $ret = array('status'=>"error",'msg'=>"error");
    $details = trim($_GPC['details']);
    if (empty($details)) {
        $ret['msg'] = "请输入评论内容！";
        exit(json_encode($ret));
    }
    $articleid = intval($_GPC['articleid']);
    $article = pdo_get($this->table_article, array('id'=>$articleid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        $ret['msg'] = "文章信息不存在！";
        exit(json_encode($ret));
    }
    $picall = empty($_GPC['picall'])?array():$_GPC['picall'];
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'articleid'  => $articleid,
        'userid'     => $user['id'],
        'details'    => $details,
        'picall'     => iserializer($picall),
        'createtime' => time()
        );
    pdo_insert($this->table_artmessage, $data);
    $ret['status'] = "success";
    $ret['msg'] = "评论信息提交成功！";
    exit(json_encode($ret));

}elseif ($op=="delete") {
    $ret = array('status'=>"error",'msg'=>"error");
    $id = intval($_GPC['id']);
    $artmessage = pdo_get($this->table_artmessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($artmessage)) {
        $ret['msg'] = "评论记录不存在！";
        exit(json_encode($ret));
    }
    if ($artmessage['userid']!=$user['id']) {
        $ret['msg'] = "该评论记录不是你所写，无权做删除操作！";
        exit(json_encode($ret));
    }
    pdo_delete($this->table_artmessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    $ret['status'] = "success";
    $ret['msg'] = "评论记录删除成功！";
    exit(json_encode($ret));

}
include $this->template('artmessage');
?>