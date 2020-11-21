<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$op = $operation = $_GPC['op']?$_GPC['op']:'display';

load()->func('tpl');
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $con = ' WHERE e.uniacid=:uniacid ';
    $par[':uniacid'] = $_W['uniacid'];
    
    $branchid = intval($_GPC['branchid']);
    if ($branchid!=0) {
        $con .= " AND u.branchid=:branchid ";
        $par[':branchid'] = $branchid;
        $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    }
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND (a.title LIKE :keywords OR u.realname LIKE :keywords)";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $userid = intval($_GPC['userid']);
    if ($userid!=0) {
        $con .= " AND e.userid=:userid ";
        $par[':userid'] = $userid;
    }
    $activityid = intval($_GPC['activityid']);
    if ($activityid!=0) {
        $con .= " AND e.activityid=:activityid ";
        $par[':activityid'] = $activityid;
    }
    $utype = intval($_GPC['utype']);
    if ($utype!=0) {
        $con .= " AND e.utype=:utype ";
        $par[':utype'] = $utype;
    }
    $list = pdo_fetchall("SELECT e.*,u.nickname,u.realname,u.mobile,u.headpic,a.title,a.utype as autype FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_activity)." a ON e.activityid=a.id ".$con." ORDER BY e.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
    $total = pdo_fetch("SELECT count(e.id) as tol FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_activity)." a ON e.activityid=a.id ".$con ,$par);
    $pager = pagination($total['tol'], $pindex, $psize);

    $utypearr = array(1=>"自由报名",2=>"指定党员",3=>"指定党员&自由报名");
    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall("SELECT e.*,u.branchid,u.openid,u.nickname,u.realname,u.mobile,u.headpic,a.title FROM ".tablename($this->table_actenroll)." e LEFT JOIN ".tablename($this->table_user)." u ON e.userid=u.id LEFT JOIN ".tablename($this->table_activity)." a ON e.activityid=a.id ".$con." ORDER BY e.id DESC ", $par);
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['branchid']   = $v['branchid'];
            $data[$k]['openid']     = $v['openid'];
            $data[$k]['nickname']   = $v['nickname'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['title']      = $v['title'];
            $data[$k]['utype']      = $utypearr[$v['utype']];
            $data[$k]['getval']     = $v['getval'];
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
            $data[$k]['signintime'] = $v['signintime']==0?"未签到":date('Y-m-d H:i:s',$v['signintime'])."\t";
        }
        $arrhead = array("ID","组织ID","OpenID","昵称","姓名","手机号","活动标题","报名类型","得分值","创建时间","签到时间");
        export_excel($data,$arrhead,time());
        exit();
    }

} elseif ($op=='setutype') {
    $ret = array('status'=>'error','msg'=>'error');
    $id = intval($_GPC['id']);
    $actenroll = pdo_get($this->table_actenroll,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($actenroll)) {
        $ret['msg'] = "要修改的报名记录不存在！";
        exit(json_encode($ret));
    }
    $activity = pdo_get($this->table_activity, array('id'=>$actenroll['activityid'],'uniacid'=>$_W['uniacid']));
    if (empty($activity)) {
        $ret['msg'] = "活动项目信息不存在！";
        exit(json_encode($ret));
    }
    if ($actenroll['utype']==1 && $activity['utype']!=1) {
        pdo_update($this->table_actenroll, array('utype'=>2), array('id'=>$id));
        $ret['status'] = "success";
        $ret['msg'] = "2";
        exit(json_encode($ret));
    }elseif ($actenroll['utype']==2 && $activity['utype']!=2) {
        pdo_update($this->table_actenroll, array('utype'=>1), array('id'=>$id));
        $ret['status'] = "success";
        $ret['msg'] = "1";
        exit(json_encode($ret));
    }else{
        $ret['msg'] = "活动为单一报名类型方式，报名类型要与活动报名类型一致！";
        exit(json_encode($ret));
    }
    



} elseif ($op=='delete') {
    $id = intval($_GPC['id']);
    $actenroll = pdo_get($this->table_actenroll,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($actenroll)) {
        message('要删除的报名记录不存在或是已经被删除！', referer(), 'error');
    }
    pdo_delete($this->table_actenroll, array('id' => $id));
    message('报名记录信息删除成功！', referer(), 'success');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $result = pdo_query("delete from ".tablename($this->table_actenroll)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template('actenroll');

?>