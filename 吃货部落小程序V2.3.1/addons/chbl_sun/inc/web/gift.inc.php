<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pindex = max(1, intval($_GPC['page']));
$psize = 15;
$condition = ' WHERE `uniacid` = :uniacid ';
$params = array(':uniacid' => $_W['uniacid']);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';



if (!empty($_GPC['keyword'])) {
    $condition .= ' AND `title` LIKE :title';
    $params[':title'] = '%' . trim($_GPC['keyword']) . '%';
}


$sql = 'SELECT COUNT(*) FROM ' . tablename('chbl_sun_gift') .$condition ;

$total = pdo_fetchcolumn($sql, $params);

if (!empty($total)) {
    $sql = 'SELECT * FROM  ' . tablename('chbl_sun_gift') .$condition.' ORDER BY  `sort`  DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
    $list = pdo_fetchall($sql, $params);

    if($list)
    {
        foreach($list as $k=>$v)
        {

            $actives = pdo_fetch("SELECT title FROM " . tablename('chbl_sun_active') . " WHERE id = :id", array(':id' => $v['pid']));
            $list[$k]['activetitle'] = $actives['title'];
        }
    }
    $pager = pagination($total, $pindex, $psize);
}

if($operation == 'delete'){
    $id = intval($_GPC['id']);
    $res = pdo_delete('chbl_sun_gift',array('id'=>$id));
    if($res){
        message('删除成功！',referer(), 'success');
    }else{
        message('删除失败！');
    }
}

include $this->template('web/gift');