<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

 global $_W, $_GPC;
 $sql = ' SELECT * FROM ' . tablename('zhls_sun_problem') . ' p ' . ' JOIN ' . tablename('zhls_sun_lawyer') . ' l ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' p.an_id=t.id' . ' AND ' . ' p.ls_id=l.id' . ' WHERE ' . ' p.uniacid=' . $_W['uniacid'] . ' ORDER BY ' . ' p.time DESC';
    $type=pdo_fetchall($sql);
    foreach ($type as $k=>$v){
        $type[$k]['cate'] = pdo_getcolumn('zhls_sun_lawtype',array('uniacid'=>$_W['uniacid'],'id'=>$v['cate']),'lawtype_name');
    }
if($_GPC['op']=='delete'){
    $res=pdo_delete('zhls_sun_problem',array('pid'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('ancontent',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('zhls_sun_problem',array('state'=>$_GPC['state']),array('pid'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('ancontent',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/ancontent');