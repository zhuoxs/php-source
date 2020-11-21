<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {
    $id = intval($_GPC['id']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$id,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        message("志愿服务信息不存在！",referer(),'error');
    }
    $sercatelist = pdo_fetchall("SELECT * FROM ".tablename($this->table_sercate)." WHERE uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']),'id');
    $sercate = $sercatelist[$seritem['cateid']];
    $branch = pdo_get($this->table_branch, array('id'=>$seritem['branchid'],'uniacid'=>$_W['uniacid']));

    $myserlog = pdo_get($this->table_serlog, array('userid'=>$user['id'],'itemid'=>$id,'uniacid'=>$_W['uniacid']));

    $serlog = pdo_fetchall("SELECT l.*, u.realname, u.headpic FROM ".tablename($this->table_serlog)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE l.itemid=:itemid AND l.uniacid=:uniacid ORDER BY l.id DESC", array(':itemid'=>$id,':uniacid'=>$_W['uniacid']));

    $sermessage = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_sermessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.itemid=:itemid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT 6 ", array(':itemid'=>$id,':uniacid'=>$_W['uniacid']));
    if (!empty($sermessage)) {
        foreach ($sermessage as $k => $v) {
            $sermessage[$k]['picall'] = iunserializer($v['picall']);
        }
    }
    $sermessagetol = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_sermessage)." WHERE itemid=:itemid AND uniacid=:uniacid ", array(':itemid'=>$id,':uniacid'=>$_W['uniacid']));
    $sermessagetol = intval($sermessagetol);

}elseif ($op=="claim") {
    $ret = array('status'=>"error",'msg'=>"error");
    $itemid = intval($_GPC['itemid']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$itemid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        $ret['msg'] = "将要认领的志愿服务项目不存在！";
        exit(json_encode($ret));
    }
    if ($seritem['status']==3) {
        $ret['msg'] = "该志愿服务项目已认领完成！";
        exit(json_encode($ret));
    }

    $myserlog = pdo_get($this->table_serlog, array('userid'=>$user['id'],'itemid'=>$itemid,'uniacid'=>$_W['uniacid']));
    if (!empty($myserlog)) {
        $ret['msg'] = "该志愿服务项目你已认领过了！";
        exit(json_encode($ret));
    }

    $serlogtol = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->table_serlog)." WHERE itemid=:itemid AND uniacid=:uniacid",array(':itemid'=>$itemid,':uniacid'=>$_W['uniacid']));
    $serlogtol = intval($serlogtol);

    if ($serlogtol<$seritem['unumber']) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $user['id'],
            'itemid'     => $itemid,
            'getval'     => $seritem['getval'],
            'createtime' => time()
            );
        pdo_insert($this->table_serlog, $data);
        $id = pdo_insertid();
        if ($seritem['unumber']<=($serlogtol+1)) {
            pdo_update($this->table_seritem, array('status'=>3), array('id'=>$itemid,'uniacid'=>$_W['uniacid']));
        }
        if ($seritem['getval']>0) {
            $intdata = array(
                'userid'    => $user['id'],
                'channel'   => "serlog",
                'foreignid' => $id,
                'integral'  => $seritem['getval'],
                'remark'    => "认领志愿服务《".$seritem['title']."》奖励",
                );
            $this->setIntegral($intdata);
        }
        $ret['status'] = "success";
        $ret['msg'] = "该志愿服务项目认领成功！";
        exit(json_encode($ret));
    }

}
include $this->template('seritem');
?>