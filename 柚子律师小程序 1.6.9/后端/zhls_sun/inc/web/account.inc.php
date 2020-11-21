<?php
global $_GPC, $_W;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$where=" where a.weid = :weid AND a.role=1 $strwhere";
$data[':weid']=$_W['uniacid'];
if($_W['role']=='operator'){
    //查找商家ID;
    $account=pdo_get('zhls_sun_account',array('weid'=>$_W['uniacid'],'uid'=>$_W['user']['uid']));
    /*$cityname=$account['cityname'];
    $where.=" and a.cityname =:cityname";
    $data[':cityname']=$cityname;*/
    $id=$account['id'];
    $where.=" and a.id =:id";
    $data[':id']=$id;
}
$GLOBALS['frames'] = $this->getMainMenu();
if ($operation == 'display') {
    $strwhere = '';
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT a.*,b.username AS username,b.status AS status FROM " . tablename('zhls_sun_account') . " a LEFT JOIN
" . tablename('users') . " b ON a.uid=b.uid  ".$where." ORDER BY id DESC LIMIT
" . ($pindex - 1) * $psize . ',' . $psize, $data);

    if (!empty($list)) {
        $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename('zhls_sun_account') . " WHERE weid = :weid $strwhere", array(':weid' =>$_W['uniacid']));
        $pager = pagination($total, $pindex, $psize);
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename('zhls_sun_account') . " WHERE id = '$id'");
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('account', array('op' => 'display')), 'error');
    }
    pdo_delete('zhls_sun_account', array('id' => $id, 'weid' => $_W['uniacid']));
    message('删除成功！', $this->createWebUrl('account', array('op' => 'display')), 'success');
}
include $this->template('web/account');