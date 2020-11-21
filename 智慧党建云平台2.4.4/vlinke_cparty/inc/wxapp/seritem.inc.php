<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {
    $id = intval($_GPC['id']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$id,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        $this->result(1, '志愿服务信息不存在！');
    }
    $sercate = pdo_get($this->table_sercate, array('id'=>$seritem['cateid'],'uniacid'=>$_W['uniacid']));
    $branch = pdo_get($this->table_branch, array('id'=>$seritem['branchid'],'uniacid'=>$_W['uniacid']));

    $userid = intval($_GPC['userid']);
    $myuser = pdo_get($this->table_serlog, array('userid'=>$userid,'itemid'=>$id,'uniacid'=>$_W['uniacid']));
    $myuser = empty($myuser) ? array() : $myuser;

    $userlist = pdo_fetchall("SELECT l.*, u.realname, u.headpic FROM ".tablename($this->table_serlog)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE l.itemid=:itemid AND l.uniacid=:uniacid ORDER BY l.id ASC", array(':itemid'=>$id,':uniacid'=>$_W['uniacid']));
    if (!empty($userlist)) {
        foreach ($userlist as $k => $v) {
            $userlist[$k]['headpic'] = tomedia($v['headpic']);
        }
    }

    $usersubmitarr = array('status'=>false,'msg'=>"");
    if ($seritem['status']==3) {
        $usersubmitarr['msg'] = "项目已结束";
    }elseif (!empty($myuser)) {
        $usersubmitarr['msg'] = "你已报名此项目";
    }elseif ($seritem['unumber']<=count($userlist)) {
        $usersubmitarr['msg'] = "招募人数已达上限";
    }else{
        $usersubmitarr['status'] = true;
        $usersubmitarr['msg'] = "我要报名参与";
    }

    $seritem['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($seritem['details']));
    $seritem['createtime'] = date("Y-m-d H:i", $seritem['createtime']);
    $seritem['starttime'] = date("m-d H:i", $seritem['starttime']);
    $seritem['endtime'] = date("m-d H:i", $seritem['endtime']);

    $this->result(0, '', array(
        'seritem'       => $seritem,
        'sercate'       => $sercate,
        'branch'        => $branch,
        'myuser'        => $myuser,
        'userlist'      => $userlist,
        'usersubmitarr' => $usersubmitarr
        ));


}elseif ($op=="usersubmit") {

    $userid = intval($_GPC['userid']);
    $itemid = intval($_GPC['itemid']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$itemid,'status'=>array(2,3),'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        $this->result(1, '将要报名的志愿服务项目不存在！');
    }
    if ($seritem['status']==3) {
        $this->result(1, '该志愿服务项目已招募完成！');
    }
    $myserlog = pdo_get($this->table_serlog, array('userid'=>$userid,'itemid'=>$itemid,'uniacid'=>$_W['uniacid']));
    if (!empty($myserlog)) {
        $this->result(1, '该志愿服务项目你已认领过了！');
    }

    $serlogtol = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->table_serlog)." WHERE itemid=:itemid AND uniacid=:uniacid",array(':itemid'=>$itemid,':uniacid'=>$_W['uniacid']));
    $serlogtol = intval($serlogtol);

    if ($serlogtol<$seritem['unumber']) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'userid'     => $userid,
            'itemid'     => $itemid,
            'getval'     => $seritem['getval'],
            'createtime' => time()
            );
        pdo_insert($this->table_serlog, $data);
        $data['id'] = pdo_insertid();
        if ($seritem['unumber']<=($serlogtol+1)) {
            pdo_update($this->table_seritem, array('status'=>3), array('id'=>$itemid,'uniacid'=>$_W['uniacid']));
        }
        if ($seritem['getval']>0) {
            $intdata = array(
                'userid'    => $userid,
                'channel'   => "serlog",
                'foreignid' => $data['id'],
                'integral'  => $seritem['getval'],
                'remark'    => "报名志愿服务《".$seritem['title']."》奖励",
                );
            $this->setIntegral($intdata);
        }

        $userlist = pdo_fetchall("SELECT l.*, u.realname, u.headpic FROM ".tablename($this->table_serlog)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id WHERE l.itemid=:itemid AND l.uniacid=:uniacid ORDER BY l.id ASC", array(':itemid'=>$itemid,':uniacid'=>$_W['uniacid']));
        if (!empty($userlist)) {
            foreach ($userlist as $k => $v) {
                $userlist[$k]['headpic'] = tomedia($v['headpic']);
            }
        }

        $usersubmitarr = array('status'=>false,'msg'=>"成功报名此项目");
        $this->result(0, '成功报名参与该志愿服务项目！', array('myuser'=>$data,'userlist'=>$userlist,'usersubmitarr'=>$usersubmitarr));

    }else{
        pdo_update($this->table_seritem, array('status'=>3), array('id'=>$itemid,'uniacid'=>$_W['uniacid']));
        $this->result(1, '该志愿服务项目已招募完成！');
    }

}
?>