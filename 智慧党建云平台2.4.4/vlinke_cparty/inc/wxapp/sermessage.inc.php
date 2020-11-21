<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {


    $itemid = intval($_GPC['itemid']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$itemid,'status'=>2,'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        $this->result(1, '志愿服务项目不存在！');
    }
    $sercate = pdo_get($this->table_sercate, array('id'=>$seritem['cateid'],'uniacid'=>$_W['uniacid']));
    $branch = pdo_get($this->table_branch, array('id'=>$seritem['branchid'],'uniacid'=>$_W['uniacid']));

    $seritem['createtime'] = date("Y-m-d H:i", $seritem['createtime']);
    $this->result(0, '', array(
        'seritem' => $seritem,
        'sercate' => $sercate,
        'branch' => $branch,
        ));


}elseif ($op=="getmore") {

    $itemid = intval($_GPC['itemid']);
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize'])); 

    $list = pdo_fetchall("SELECT m.*, u.realname, u.headpic FROM ".tablename($this->table_sermessage)." m LEFT JOIN ".tablename($this->table_user)." u ON m.userid=u.id WHERE m.itemid=:itemid AND m.uniacid=:uniacid ORDER BY m.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':itemid'=>$itemid,':uniacid'=>$_W['uniacid']));

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
    $itemid = intval($_GPC['itemid']);
    $seritem = pdo_get($this->table_seritem, array('id'=>$itemid,'status'=>array(1,2),'uniacid'=>$_W['uniacid']));
    if (empty($seritem)) {
        $this->result(1, '志愿服务项目不存在！');
    }
    $picall = str_replace(array('[','"',']','&quot;'),"",$_GPC['picall']);
    $picallarr = trim($picall)=="" ? array() : explode(",", $picall);
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'itemid'  => $itemid,
        'userid'     => intval($_GPC['userid']),
        'details'    => $details,
        'picall'     => iserializer($picallarr),
        'createtime' => time()
        );
    pdo_insert($this->table_sermessage, $data);
    $this->result(0, '', array());

}elseif ($op=="delmessage") {
    $messageid = intval($_GPC['messageid']);
    $userid = intval($_GPC['userid']);
    $sermessage = pdo_get($this->table_sermessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
    if (empty($sermessage)) {
        $this->result(1, '留言评论记录不存在！');
    }
    if ($sermessage['userid']!=$userid) {
        $this->result(1, '该留言评论记录不是你所写，无权做删除操作！');
    }
    pdo_delete($this->table_sermessage, array('id'=>$messageid,'uniacid'=>$_W['uniacid']));
    $this->result(0, '', array());

}
?>