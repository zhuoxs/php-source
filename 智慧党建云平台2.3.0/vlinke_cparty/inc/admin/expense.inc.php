<?php
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = " WHERE e.uniacid=:uniacid AND u.branchid IN (".$lbrancharrid.") ";
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $status = intval($_GPC['status']);
    if ($status!=0) {
        $con .= " AND e.status=:status ";
        $par[':status'] = $status;
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND e.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $cateid = intval($_GPC['cateid']);
    $cate = array();
    if ($cateid!=0) {
        $con .= " AND e.cateid=:cateid ";
        $par[':cateid'] = $cateid;
        $cate = pdo_get($this->table_expcate, array('id'=>$cateid,'uniacid'=>$_W['uniacid']));
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT e.*,u.branchid,u.nickname,u.realname,u.mobile,u.headpic,c.name,c.status as cstatus FROM ".tablename($this->table_expense)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_expcate)." c ON e.cateid=c.id ".$con." ORDER BY e.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(e.id) as tol, sum(e.paymoney) as paymoneytol FROM ".tablename($this->table_expense)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_expcate)." c ON e.cateid=c.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT e.*,u.branchid,u.openid,u.nickname,u.realname,u.mobile,c.name FROM ".tablename($this->table_expense)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_expcate)." c ON e.cateid=c.id ".$con." ORDER BY e.id DESC ", $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['branchid']   = $lbranchall[$v['branchid']]['name'];
            $data[$k]['openid']     = $v['openid'];
            $data[$k]['nickname']   = $v['nickname'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['name']       = $v['name'];
            $data[$k]['paymoney']   = $v['paymoney'];
            $data[$k]['remark']     = str_replace(",", "，", $v['remark']);
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
        }
        $arrhead = array("ID","组织","OpenID","昵称","姓名","手机号","党费类目","金额","备注","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

}
include $this->template('admin/expense');

?>