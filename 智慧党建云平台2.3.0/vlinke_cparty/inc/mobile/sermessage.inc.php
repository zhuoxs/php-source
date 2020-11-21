<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $itemid = intval($_GPC['itemid']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$itemid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        message("志愿项目信息不存在！",referer(),'error');
    }

    $sercatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_sercate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');

    $sermessagetol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_sermessage)." WHERE itemid=:itemid AND uniacid=:uniacid ", array(':itemid'=>$itemid,':uniacid'=>$_W['uniacid']));
    $sermessagetol = intval($sermessagetol);

    $sercate = $sercatelist[$seritem['cateid']];
    $sercatenav = pdo_fetchall("SELECT * FROM ".tablename($this->table_sercate)." WHERE navnumber>0 AND uniacid=:uniacid ORDER BY navnumber DESC, id DESC", array(':uniacid'=>$_W['uniacid']));

}elseif ($op=="getmore") {
    $itemid = intval($_GPC['itemid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_sermessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.itemid=:itemid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':itemid'=>$itemid,':uniacid'=>$_W['uniacid']));
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
        $ret['msg'] = "请输入留言评论内容！";
        exit(json_encode($ret));
    }
    $itemid = intval($_GPC['itemid']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$itemid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        $ret['msg'] = "志愿项目信息不存在！";
        exit(json_encode($ret));
    }
    $picall = empty($_GPC['picall'])?array():$_GPC['picall'];
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'itemid'     => $itemid,
        'userid'     => $user['id'],
        'details'    => $details,
        'picall'     => iserializer($picall),
        'createtime' => time()
        );
    pdo_insert($this->table_sermessage, $data);
    $ret['status'] = "success";
    $ret['msg'] = "留言评论信息提交成功！";
    exit(json_encode($ret));


}elseif ($op=="delete") {
    $ret = array('status'=>"error",'msg'=>"error");
    $id = intval($_GPC['id']);
    $sermessage = pdo_get($this->table_sermessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($sermessage)) {
        $ret['msg'] = "留言评论信息不存在！";
        exit(json_encode($ret));
    }
    if ($sermessage['userid']!=$user['id']) {
        $ret['msg'] = "该留言评论信息不是你所写，无权做删除操作！";
        exit(json_encode($ret));
    }
    pdo_delete($this->table_sermessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    $ret['status'] = "success";
    $ret['msg'] = "留言评论信息删除成功！";
    exit(json_encode($ret));

}
include $this->template('sermessage');
?>