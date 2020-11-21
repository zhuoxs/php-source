<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {



}elseif ($op=="getmore") {

    $branchid = intval($_GPC['branchid']); 
    $branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
    if (!empty($branch)) {
    	$par = " tab.branchid in ( ".$branch['scort']." ) AND ";
    }

    $pindex = max(1, intval($_GPC['pindex']));
    $psize = max(1, intval($_GPC['psize']));    
    $list = pdo_fetchall("SELECT tab.*,b.name FROM ".tablename($this->table_notice)." tab LEFT JOIN ".tablename($this->table_branch)." b ON tab.branchid=b.id WHERE ".$par." tab.uniacid=:uniacid ORDER BY tab.priority DESC, tab.id DESC LIMIT ".($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid']));
    if (!empty($list)) {
    	foreach ($list as $k => $v) {
    		$list[$k]['createtime'] = date("Y-m-d H:i", $v['createtime']);
    	}
    }

    $this->result(0, '', $list);

    
}elseif ($op=="details") {

    $id = intval($_GPC['id']);
    $notice = pdo_get($this->table_notice, array('id'=>$id,'uniacid'=>$_W['uniacid']));
    if (empty($notice)) {
        $this->result(1, '要查看的通知公告不存在，请重新进入！');
    }
    $notice['details'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($notice['details']));
    $notice['createtime'] = date("Y-m-d H:i", $notice['createtime']);

    $branch = pdo_get($this->table_branch,array('id'=>$notice['branchid'],'uniacid'=>$_W['uniacid']));

    $this->result(0, '', array(
        'notice' => $notice,
        'branch' => $branch
        ));
}
?>