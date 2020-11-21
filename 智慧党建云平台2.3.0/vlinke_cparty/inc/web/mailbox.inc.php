<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$op = $operation = $_GPC['op']?$_GPC['op']:'display';

load()->func('tpl');
if ($op=='display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 50;
    $condition = ' WHERE uniacid=:uniacid ';
    $params[':uniacid'] = $_W['uniacid'];
    
    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']);
        $condition .= " AND createtime >= :starttime AND createtime <= :endtime ";
        $params[':starttime'] = $starttime;
        $params[':endtime'] = $endtime+86400;
    }else{
        $starttime = strtotime('-1 month');
        $endtime = TIMESTAMP;
    }

    $sql = 'SELECT * FROM '.tablename($this->table_mailbox).$condition.' ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize ;
    $list = pdo_fetchall($sql,$params);
    $total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_mailbox).$condition,$params);
    $pager = pagination($total, $pindex, $psize);
    foreach ($list as $k => $v) {
        $list[$k]['user'] = pdo_fetch('SELECT * FROM '.tablename($this->table_user).' WHERE id=:id ',array(":id"=>$v['userid']));
    }

    if ($_GPC['output']==1) {
        $sql_out = 'SELECT * FROM '.tablename($this->table_mailbox). $condition . ' ORDER BY id DESC ';
        $list_out = pdo_fetchall($sql_out,$params);
        foreach($list_out as $k=>$v){
            $user = pdo_fetch('SELECT * FROM '.tablename($this->table_user).' WHERE id=:id ',array(":id"=>$v['userid']));
            $data[$k]['id']         = $v['id'];
            $data[$k]['openid']     = $user['openid'];
            $data[$k]['nickname']   = $user['nickname'];
            $data[$k]['realname']   = $v['realname'];
            $data[$k]['mobile']     = $v['mobile']."\t";
            $data[$k]['department'] = $v['department'];
            $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime'])."\t";
            $data[$k]['content']    = $v['content'];
        }
        $arrhead = array("ID","OpenID","昵称","姓名","手机号","单位部门","创建时间","内容描述");
        $this->exportexcel($data,$arrhead,time());
        exit();
    }

} elseif ($op=='delete') {
    $id = intval($_GPC['id']);
    $sql = 'SELECT * FROM '.tablename($this->table_mailbox).' WHERE uniacid=:uniacid AND id=:id LIMIT 1 ';
    $params[':uniacid'] = $_W['uniacid'];
    $params[':id'] = $id;
    $mailbox = pdo_fetch($sql,$params);
    if (empty($mailbox)) {
        message('抱歉，要删除的数据不存在或是已经被删除！', $this->createWebUrl('mailbox'), 'error');
    }
    pdo_delete($this->table_mailbox,array('id'=>$id,'uniacid'=>$_W['uniacid']));
    message('数据删除成功！！！', $this->createWebUrl('mailbox'), 'success');
} elseif ($op=='deleteall') {
    $delnum = 0; 
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if ($id == 0) continue;
        $num = pdo_delete($this->table_mailbox,array('id'=>$id,'uniacid'=>$_W['uniacid']));
        $delnum = $num+$delnum;
        if (!$num) {
            message('抱歉，要删除的数据不存在或是已经被删除！');
        }
    }
    echo $delnum;
}
include $this->template('mailbox');

?>