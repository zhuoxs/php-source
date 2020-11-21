<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $id = intval($_GPC['id']);
    $edulesson = pdo_get($this->table_edulesson, array('id'=>$id,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($edulesson)) {
        message("课程信息不存在！",referer(),'error');
    }
    $educatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_educate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');

    $edustudy = pdo_get($this->table_edustudy, array('lessonid'=>$id,'userid'=>$user['id'],'uniacid'=>$_W['uniacid']));
    if (empty($edustudy)) {
        $edustudy = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $user['id'],
            'lessonid'   => $id,
            'getval'     => 0,
            'status'     => 1,
            'createtime' => time(),
            );
        pdo_insert($this->table_edustudy, $edustudy);
        $edustudy['id'] = pdo_insertid();
    }


    $educhapterall = pdo_fetchall("SELECT * FROM ".tablename($this->table_educhapter)." WHERE status=2 AND lessonid=:lessonid AND uniacid=:uniacid ORDER BY priority DESC , id ASC ", array(':lessonid'=>$id,':uniacid'=>$_W['uniacid']),"id");
    $edulogall = pdo_fetchall("SELECT * FROM ".tablename($this->table_edulog)." WHERE status=2 AND lessonid=:lessonid AND userid=:userid AND uniacid=:uniacid ", array(':lessonid'=>$id,':userid'=>$user['id'],':uniacid'=>$_W['uniacid']),"chapterid");
    $edumessageall = pdo_fetchall("SELECT m.*,u.nickname,u.realname,u.mobile,u.headpic FROM ".tablename($this->table_edumessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.lessonid=:lessonid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT 6 ", array(':lessonid'=>$id,':uniacid'=>$_W['uniacid']));
    if (!empty($edumessageall)) {
        foreach ($edumessageall as $k => $v) {
            $edumessageall[$k]['picall'] = iunserializer($v['picall']);
        }
    }

    $nostu_chapterid = 0;
    foreach ($educhapterall as $k => $v) {
        if (empty($edulogall[$k])) {
            $nostu_chapterid = $k;
            break;
        }
    }

    if ($edulesson['status']==2 && $edustudy['status']==1 && $nostu_chapterid==0) {
        pdo_update($this->table_edustudy,array('status'=>2,'getval'=>$edulesson['integral']),array('id'=>$edustudy['id']));
        $integral = pdo_get($this->table_integral,array('userid'=>$user['id'],'channel'=>'edustudy','foreignid'=>$edustudy['id'],'uniacid'=>$_W['uniacid']));
        if (empty($integral)) {
            $data = array(
                'userid'    => $user['id'],
                'channel'   => "edustudy",
                'foreignid' => $edustudy['id'],
                'integral'  => $edulesson['integral'],
                'remark'    => "学习《".$edulesson['title']."》课程",
                );
            $this->setIntegral($data);
        }
        $edustudy['status'] = 2;
    }
    $edustudytol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_edustudy)." WHERE status=2 AND lessonid=:lessonid AND uniacid=:uniacid ", array(':lessonid'=>$id,'uniacid'=>$_W['uniacid']));



}
include $this->template('edulesson');
?>