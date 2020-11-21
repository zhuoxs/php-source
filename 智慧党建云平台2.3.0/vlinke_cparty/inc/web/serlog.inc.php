<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$op = $operation = $_GPC['op']?$_GPC['op']:'display';

load()->func('tpl');
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = ' WHERE l.uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND l.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $itemid = intval($_GPC['itemid']);
    if ($itemid!=0) {
        $con .= " AND l.itemid=:itemid ";
        $par[':itemid'] = $itemid;
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT l.*,u.nickname,u.realname,u.mobile,u.headpic,i.title FROM ".tablename($this->table_serlog)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id LEFT JOIN ".tablename($this->table_seritem)." i ON l.itemid=i.id ".$con." ORDER BY l.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(l.id) as tol, sum(l.getval) as getvaltol FROM ".tablename($this->table_serlog)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id LEFT JOIN ".tablename($this->table_seritem)." i ON l.itemid=i.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT l.*,u.branchid,u.openid,u.nickname,u.realname,u.mobile,u.headpic,i.title FROM ".tablename($this->table_serlog)." l LEFT JOIN ".tablename($this->table_user)." u ON l.userid=u.id LEFT JOIN ".tablename($this->table_seritem)." i ON l.itemid=i.id ".$con." ORDER BY l.id DESC ", $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['branchid']   = $v['branchid'];
            $data[$k]['openid']     = $v['openid'];
            $data[$k]['nickname']   = $v['nickname'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['title']      = $v['title'];
            $data[$k]['getval']     = $v['getval'];
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
        }
        $arrhead = array("ID","组织ID","OpenID","昵称","姓名","手机号","志愿服务标题","所得积分","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

} elseif ($op=='delete') {
    $id = intval($_GPC['id']);
    $edustudy = pdo_get($this->table_serlog,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($edustudy)) {
        message('要删除的认领记录不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_serlog, array('id' => $id));
    message('认领记录信息删除成功！', referer(), 'success');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_serlog)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template('serlog');

?>