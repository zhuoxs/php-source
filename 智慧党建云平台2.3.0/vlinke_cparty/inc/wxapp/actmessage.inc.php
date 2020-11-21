<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>2,'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $this->result(1, '组织活动项目不存在！');
    }
    $branch = pdo_get($this->table_branch, array('id'=>$activity['branchid'],'uniacid'=>$_W['uniacid']));

    $activity['createtime'] = date("Y-m-d H:i", $activity['createtime']);
    $this->result(0, '', array(
        'activity' => $activity,
        'branch' => $branch,
        ));


}elseif ($op=="getmore") {

    $activityid = intval($_GPC['activityid']);
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize'])); 

    $list = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_actmessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.activityid=:activityid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':activityid'=>$activityid,':uniacid'=>$_W['uniacid']));

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
    $activityid = intval($_GPC['activityid']);
    $activity = pdo_get($this->table_activity, array('id'=>$activityid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $this->result(1, '组织活动项目不存在！');
    }
    $picall = str_replace(array('[','"',']','&quot;'),"",$_GPC['picall']);
    $picallarr = trim($picall)=="" ? array() : explode(",", $picall);
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'activityid' => $activityid,
        'userid'     => intval($_GPC['userid']),
        'details'    => $details,
        'picall'     => iserializer($picallarr),
        'createtime' => time()
        );
    pdo_insert($this->table_actmessage, $data);
    $this->result(0, '', array());

}elseif ($op=="delete") {
    $messageid = intval($_GPC['messageid']);
    $userid = intval($_GPC['userid']);
    $actmessage = pdo_get($this->table_actmessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
    if (empty($actmessage)) {
        $this->result(1, '留言评论记录不存在！');
    }
    if ($actmessage['userid']!=$userid) {
        $this->result(1, '该留言评论记录不是你所写，无权做删除操作！');
    }
    pdo_delete($this->table_actmessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
    $this->result(0, '', array());
}
include $this->template('actmessage');
?>