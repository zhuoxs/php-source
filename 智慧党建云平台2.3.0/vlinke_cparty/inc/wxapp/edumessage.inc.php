<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {
    $lessonid = intval($_GPC['lessonid']);
    $edulesson = pdo_get($this->table_edulesson, array('id'=>$lessonid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($edulesson)) {
        $this->result(1, '课程信息不存在！');
    }
    $educate = pdo_get($this->table_educate, array('id'=>$edulesson['cateid'],'uniacid'=>$_W['uniacid']));

    $edulesson['createtime'] = date("Y-m-d H:i", $edulesson['createtime']);
    $this->result(0, '', array(
        'edulesson' => $edulesson,
        'educate' => $educate
        ));

}elseif ($op=="getmore") {
    $lessonid = intval($_GPC['lessonid']);
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize'])); 

    $list = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_edumessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.lessonid=:lessonid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':lessonid'=>$lessonid,':uniacid'=>$_W['uniacid']));

    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['headpic'] = tomedia($v['headpic']);
            $list[$k]['picall'] = iunserializer($v['picall']);
            if (!empty($list[$k]['picall'])) {
                foreach ($list[$k]['picall'] as $key => $value) {
                    $list[$k]['picall'][$key] = tomedia($value);
                }
            }
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
        }
    }
    $this->result(0, '', $list);

}elseif ($op=="addmessage") {
    $details = trim($_GPC['details']);
    if (empty($details)) {
        $this->result(1, '请输入评论内容！');
    }
    $lessonid = intval($_GPC['lessonid']);
    $article = pdo_get($this->table_edulesson, array('id'=>$lessonid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($article)) {
        $this->result(1, '课程信息不存在！');
    }
    $picall = str_replace(array('[','"',']','&quot;'),"",$_GPC['picall']);
    $picallarr = trim($picall)=="" ? array() : explode(",", $picall);
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'lessonid'   => $lessonid,
        'userid'     => intval($_GPC['userid']),
        'details'    => $details,
        'picall'     => iserializer($picallarr),
        'createtime' => time()
        );
    pdo_insert($this->table_edumessage, $data);
    $this->result(0, '', array());

}elseif ($op=="delmessage") {
    $messageid = intval($_GPC['messageid']);
    $userid = intval($_GPC['userid']);
    $edumessage = pdo_get($this->table_edumessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
    if (empty($edumessage)) {
        $this->result(1, '留言评论记录不存在！');
    }
    if ($edumessage['userid']!=$userid) {
        $this->result(1, '该留言评论记录不是你所写，无权做删除操作！');
    }
    pdo_delete($this->table_edumessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
    $this->result(0, '', array());

}
?>

