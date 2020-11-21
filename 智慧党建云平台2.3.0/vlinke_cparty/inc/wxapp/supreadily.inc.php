<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

}elseif ($op=="getmore") {
    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));
    $userid = intval($_GPC['userid']);
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_supreadily)." WHERE userid=:userid AND uniacid=:uniacid ORDER BY id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':userid'=>$userid,':uniacid'=>$_W['uniacid']));
    if (!empty($list)) {
        foreach ($list as $k => $v) {
            $list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
        }
    }
    $this->result(0, '', $list);

}elseif ($op=="post") {
    $picall = str_replace(array('[','"',']','&quot;'),"",$_GPC['picall']);
    $picallarr = trim($picall)=="" ? array() : explode(",", $picall);
    $data = array(
        'uniacid'    => $_W['uniacid'],
        'userid'     => intval($_GPC['userid']),
        'title'      => trim($_GPC['title']),
        'picall'     => iserializer($picallarr),
        'details'    => trim($_GPC['details']),
        'createtime' => time()
        );
    pdo_insert($this->table_supreadily, $data);
    $this->result(0, '', array());


}elseif ($op=="details") {

    $id = intval($_GPC['id']);
    $userid = intval($_GPC['userid']);
    $supreadily = pdo_get($this->table_supreadily, array('id'=>$id,'userid'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($supreadily)) {
        $this->result(1, '上报信息不存在！');
    }
    $supreadily['createtime'] = date("Y-m-d H:i", $supreadily['createtime']);
    $supreadily['picall'] = iunserializer($supreadily['picall']);
    if (!empty($supreadily['picall'])) {
        foreach ($supreadily['picall'] as $key => $value) {
            $supreadily['picall'][$key] = tomedia($value);
        }
    }
    $this->result(0, '', array(
        'supreadily' => $supreadily
        ));

}
?>