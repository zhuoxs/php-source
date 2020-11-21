<?php
global $_W,$_GPC;
$op = $operation = $_GPC['op']?$_GPC['op']:'display';
$channelarr = array(
    "system"    => "系统设置",
    "article"   => "阅读奖励",
    "edustudy"  => "学习知识",
    "exaday"    => "每日测试",
    "exaanswer" => "在线考试",
    "serlog"    => "认领服务",
    "actenroll" => "报名活动"
    );

load()->func('tpl');
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $con = ' WHERE i.uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND i.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $channel = trim($_GPC['channel']);
    if (!empty($channel)) {
        $con .= " AND i.channel=:channel ";
        $par[':channel'] = $channel;
    }
    $realname = trim($_GPC['realname']);
    if (!empty($realname)) {
        $con .= " AND u.realname=:realname ";
        $par[':realname'] = $realname;
    }
    $list = pdo_fetchall("SELECT i.*,u.nickname,u.realname,u.mobile,u.headpic FROM ".tablename($this->table_integral)." i LEFT JOIN ".tablename($this->table_user)." u ON i.userid=u.id ".$con." ORDER BY id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(i.id) as tol, sum(i.integral) as integraltol FROM ".tablename($this->table_integral)." i LEFT JOIN ".tablename($this->table_user)." u ON i.userid=u.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);
    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT i.*,u.openid,u.nickname,u.realname,u.mobile FROM ".tablename($this->table_integral)." i LEFT JOIN ".tablename($this->table_user)." u ON i.userid=u.id ".$con." ORDER BY id DESC ", $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['channel']    = $channelarr[$v['channel']];
            $data[$k]['integral']   = $v['integral'];
            $data[$k]['remark']     = str_replace(",", "，", $v['remark']);
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
        }
        $arrhead = array("ID","姓名","手机号","积分类型","积分变动值","备注","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

} elseif ($op=='statistics') {

    $con = ' WHERE uniacid=:uniacid AND recycle=0 ';
    $par[':uniacid'] = $_W['uniacid'];
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $limit = $_GPC['output']==1 ? "" : " LIMIT ".($pindex-1) * $psize.",".$psize;
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_user).$con." ORDER BY id DESC ".$limit, $par, "id");
        
    if (!empty($list)) {
        $idstr = implode(",", array_keys($list));
        $icon = " WHERE userid IN (".$idstr.") AND uniacid=:uniacid AND isrank=1 ";
        $ipar[':uniacid'] = $_W['uniacid'];
        $itype = trim($_GPC['itype']);
        $ivalue = trim($_GPC['ivalue']);
        $icon .= empty($itype) ? "" : " AND ".$itype."=".$ivalue;
        $channel = trim($_GPC['channel']);
        if (!empty($channel)) {
            $icon .= " AND channel=:channel ";
            $ipar[':channel'] = $channel;
        }
        $integrallist = pdo_fetchall("SELECT sum(integral) as inttol, userid FROM ".tablename($this->table_integral).$icon." GROUP BY userid ", $ipar, "userid");
    }

    if ($_GPC['output']==1) {
        foreach($list as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['integral']   = intval($integrallist[$v['id']]['inttol']);
        }
        $arrhead = array("ID","姓名","手机号","积分值");
        export_excel($data,$arrhead,time());
        exit();
    }
    $total = pdo_fetchcolumn("SELECT count(id) FROM ".tablename($this->table_user).$con, $par);
    $pager = pagination($total, $pindex, $psize);


} elseif ($op=='userlog') {
    $userid = intval($_GPC['userid']);
    $icon = " WHERE uniacid=:uniacid AND userid=:userid ";
    $ipar[':uniacid'] = $_W['uniacid'];
    $ipar[':userid'] = $userid;

    $itype = trim($_GPC['itype']);
    $ivalue = trim($_GPC['ivalue']);
    $icon .= empty($itype) ? "" : " AND ".$itype."=".$ivalue;
    $channel = trim($_GPC['channel']);
    if (!empty($channel)) {
        $icon .= " AND channel=:channel ";
        $ipar[':channel'] = $channel;
    }
    $user = pdo_get($this->table_user,array('id'=>$userid));
    $list = pdo_fetchall("SELECT * FROM ".tablename($this->table_integral).$icon." ORDER BY id DESC ", $ipar);

    if ($_GPC['output']==1) {
        foreach($list as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['channel']    = $channelarr[$v['channel']];
            $data[$k]['integral']   = $v['integral'];
            $data[$k]['iyear']      = $v['iyear'];
            $data[$k]['iseason']    = $v['iseason'];
            $data[$k]['imonth']     = $v['imonth'];
            $data[$k]['remark']     = str_replace(",", "，", $v['remark']);
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
        }
        $arrhead = array("ID","积分类型","积分变动值","年份","季度","月份","备注","创建时间");
        export_excel($data,$arrhead,$user['realname']."_".time());
        exit();
    }
    $htmlcon = '';
    if (!empty($list)) {
        foreach($list as $k=>$v){
            $htmlcon .= '<tr>';
            $htmlcon .= '<td></td>';
            $htmlcon .= '<td>'.$v['id'].'</td>';
            $htmlcon .= '<td><span class="label label-default">'.$channelarr[$v['channel']].'</span></td>';
            $htmlcon .= '<td>'.$v['integral'].'</td>';
            $htmlcon .= '<td style="text-align:right;">'.date('Y-m-d H:i',$v['createtime']).'</td>';
            $htmlcon .= '</tr>';
        }
    }else{
        $htmlcon .= '<tr>';
        $htmlcon .= '<td></td>';
        $htmlcon .= '<td colspan="4">未有对应的积分记录...</td>';
        $htmlcon .= '</tr>';
    }
    exit($htmlcon);

} elseif ($op=='delete') {
    $id = intval($_GPC['id']);
    $integral = pdo_fetch("SELECT * FROM ".tablename($this->table_integral)." WHERE id=:id AND uniacid=:uniacid ",array(':id'=>$id,':uniacid'=>$_W['uniacid']));
    if (empty($integral)) {
        message('要删除的积分记录不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_integral, array('id' => $id));
    message('积分记录信息删除成功！', referer(), 'success');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_integral)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template('integral');

?>