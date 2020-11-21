<?php
global $_W, $_GPC;
load()->func('tpl');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') { 
    $con = " WHERE uniacid=:uniacid ";
    $par = array(':uniacid'=>$_W['uniacid']);
    $keywords = trim($_GPC['keywords']);
    if (!empty($keywords)) {
        $con .= " AND title LIKE :keywords ";
        $par[':keywords'] = '%'.$keywords.'%';
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = pdo_fetchall('SELECT * FROM '.tablename($this->table_exapaper).$con.' ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize, $par, "id");
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_exapaper).$con, $par);
    $pager = pagination($total, $pindex, $psize);

    $idstr = implode(",", array_keys($list));
    if (!empty($idstr)) {
        $exapeverytol = pdo_fetchall('SELECT paperid, count(id) as tol FROM '.tablename($this->table_exapevery).' WHERE paperid IN ('.$idstr.') GROUP BY paperid', array(), "paperid");
        $exaanswertol = pdo_fetchall('SELECT paperid, count(id) as tol FROM '.tablename($this->table_exaanswer).' WHERE paperid IN ('.$idstr.') GROUP BY paperid', array(), "paperid");
    }

    if ($_GPC['output']==1) {
        $list_out = pdo_fetchall('SELECT d.*,u.realname,u.mobile,u.branchid,b.name FROM '.tablename($this->table_exapaper).' d LEFT JOIN '.tablename($this->table_user).' u ON d.userid=u.id LEFT JOIN '.tablename($this->table_branch).' b ON u.branchid=b.id '.$con.' ORDER BY d.id DESC ', $par, "id");
        foreach($list_out as $k=>$v){
            $data[$k]['id']         = $v['id'];
            $data[$k]['title']      = $v['title'];
            $data[$k]['status']     = $v['status']==1?"未完成":"已完成";
            $data[$k]['aright']     = $v['aright'];
            $data[$k]['awrong']     = $v['awrong'];
            $data[$k]['integral']   = $v['integral'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['name']       = $v['name'];
            $data[$k]['finishtime'] = $v['finishtime']==0?"未完成":date("Y-m-d H:i",$v['finishtime'])."\t";
            $data[$k]['createtime'] = date("Y-m-d H:i",$v['createtime'])."\t";
        }
        $arrhead = array("ID","标题","状态","答对数目","答错数目","所得积分","姓名","手机号","组织名称","完成时间","创建时间");
        export_excel($data,$arrhead,time());
        exit();
    }

}elseif ($op == 'post') {
    $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $data = array(
            'uniacid'    => $_W['uniacid'],
            'title'      => trim($_GPC['title']),
            'singlenum'  => intval($_GPC['singlenum']),
            'singleval'  => intval($_GPC['singleval']),
            'multinum'   => intval($_GPC['multinum']),
            'multival'   => intval($_GPC['multival']),
            'integral'   => intval($_GPC['integral']),
            'timelimit'  => intval($_GPC['timelimit']),
            'details'    => $_GPC['details'],
            'starttime'  => strtotime($_GPC['datelimit']['start']),
            'endtime'    => strtotime($_GPC['datelimit']['end']),
            'createtime' => time(),
        );
        if (!empty($id)) {
            pdo_update($this->table_exapaper, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_exapaper, $data);
        }
        message('信息更新成功！', $this->createWebUrl('exapaper'), 'success');
    }
    $exapaper = pdo_get($this->table_exapaper, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($exapaper)) {
        $exapaper = array(
            'singlenum' => 30,
            'singleval' => 2,
            'multinum'  => 10,
            'multival'  => 4,
            'integral'  => 5,
            'timelimit' => 30,
            'starttime' => time()+10800,
            'endtime'   => time()+86400*7,
        );
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $exapaper = pdo_get($this->table_exapaper,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($exapaper)) {
        message('要删除的信息不存在或是已经被删除！', referer(), 'error');
    }
    $exaanswer = pdo_get($this->table_exaanswer,array('paperid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($exaanswer)) {
        message('项目下存在考试记录，请先删除其考试记录！', referer(), 'error');
    }
    pdo_delete($this->table_exapevery, array('paperid'=>$id));
    pdo_delete($this->table_exapaper, array('id' => $id));
    message('信息删除成功！', referer(), 'success');

} elseif ($op=='deleteall') {
    $idstr = implode(",", $_GPC['idArr']);
    $exaanswerall = pdo_getall($this->table_exaanswer,array('paperid'=>$id,'uniacid'=>$_W['uniacid']));
    if (!empty($exaanswerall)) {
        message('项目下存在考试记录，请先删除其考试记录！', referer(), 'error');
    }
    pdo_query("delete from ".tablename($this->table_exapevery)." WHERE paperid IN (".$idstr.")");
    $result = pdo_query("delete from ".tablename($this->table_exapaper)." WHERE id IN (".$idstr.")");
    if (!empty($result)) {
        exit("success");
    }
    exit("error");
}
include $this->template('exapaper');
?>