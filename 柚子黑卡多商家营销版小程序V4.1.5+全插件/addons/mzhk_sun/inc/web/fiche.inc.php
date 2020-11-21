<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE   uniacid=".$_W['uniacid'];

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select * from " . tablename("mzhk_sun_gift") ." ".$where." order by gid desc,sort asc ";
$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_gift") . " " .$where." ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);


if($_GPC['op']=='delete'){

    $res=pdo_delete('mzhk_sun_gift',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

    if($res){
        message('删除成功！', $this->createWebUrl('fiche'), 'success');
    }else{
        message('删除失败！','','error');
    }
}

include $this->template('web/fiche');