<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $lessonid = intval($_GPC['lessonid']);
    $edulesson = pdo_get($this->table_edulesson, array('id'=>$lessonid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($edulesson)) {
        message("学习课程信息不存在！",referer(),'error');
    }

    $educatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_educate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');

    $edumessagetol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_edumessage)." WHERE lessonid=:lessonid AND uniacid=:uniacid ", array(':lessonid'=>$lessonid,':uniacid'=>$_W['uniacid']));
    $edumessagetol = intval($edumessagetol);

}elseif ($op=="getmore") {
    $lessonid = intval($_GPC['lessonid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_edumessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.lessonid=:lessonid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':lessonid'=>$lessonid,':uniacid'=>$_W['uniacid']));
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
    $lessonid = intval($_GPC['lessonid']);
    $edulesson = pdo_get($this->table_edulesson, array('id'=>$lessonid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($edulesson)) {
        $ret['msg'] = "学习课程信息不存在！";
        exit(json_encode($ret));
    }
    $picall = empty($_GPC['picall'])?array():$_GPC['picall'];
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'lessonid'   => $lessonid,
        'userid'     => $user['id'],
        'details'    => $details,
        'picall'     => iserializer($picall),
        'createtime' => time()
        );
    pdo_insert($this->table_edumessage, $data);
    $ret['status'] = "success";
    $ret['msg'] = "留言评论信息提交成功！";
    exit(json_encode($ret));


}elseif ($op=="delete") {
    $ret = array('status'=>"error",'msg'=>"error");
    $id = intval($_GPC['id']);
    $edumessage = pdo_get($this->table_edumessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($edumessage)) {
        $ret['msg'] = "留言评论信息不存在！";
        exit(json_encode($ret));
    }
    if ($edumessage['userid']!=$user['id']) {
        $ret['msg'] = "该留言评论信息不是你所写，无权做删除操作！";
        exit(json_encode($ret));
    }
    pdo_delete($this->table_edumessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    $ret['status'] = "success";
    $ret['msg'] = "留言评论信息删除成功！";
    exit(json_encode($ret));

}
include $this->template('edumessage');
?>