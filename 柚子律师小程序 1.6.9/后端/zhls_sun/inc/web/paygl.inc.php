<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$answer=isset($_GPC['is_answer'])?$_GPC['is_answer']:2;
//$status=$_GPC['status'];
load()->func('tpl');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
if($_GPC['keywords']) {
    $op = $_GPC['keywords'];
    $list = pdo_get('zhls_sun_lawyer',array('lawyers like'=>'%'.$op.'%'));
    $sql = ' SELECT *,mp.mobile as mobile FROM ' . tablename('zhls_sun_fproblem') . ' mp ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l '  .  ' ON ' . ' mp.ls_id=l.id'. ' WHERE ' . ' mp.ls_id='.$list['id'];
    $info = pdo_fetchall($sql);
}elseif ($_GPC['op']=='answer'){
    $answer = $_GPC['is_answer'];
    if($_GPC['is_answer']==2){
        $list = pdo_getall('zhls_sun_fproblem',['uniacid'=>$_W['uniacid']],'','','time DESC');
    }else{
        $list = pdo_getall('zhls_sun_fproblem',['uniacid'=>$_W['uniacid'],'is_answer'=>$_GPC['is_answer']],'','','time DESC');
    }
    $info = [];
    foreach ($list as $k=>$v){
        if($v['ls_id']){
            $sql = ' SELECT *,mp.mobile as mobile FROM ' . tablename('zhls_sun_fproblem') . ' mp ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l '  .  ' ON ' . ' mp.ls_id=l.id' . ' WHERE ' . ' mp.fid='.$v['fid'];
            $info[$k] = pdo_fetch($sql);
        }else{
            $info[$k] = $v;
        }
    }
}else{
    $list = pdo_getall('zhls_sun_fproblem',['uniacid'=>$_W['uniacid']],'','','time DESC');
    $info = [];
    foreach ($list as $k=>$v){
        if($v['ls_id']){
            $sql = ' SELECT *,mp.mobile as mobile FROM ' . tablename('zhls_sun_fproblem') . ' mp ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l '  .  ' ON ' . ' mp.ls_id=l.id' . ' WHERE ' . ' mp.fid='.$v['fid'];
            $info[$k] = pdo_fetch($sql);
        }else{
            $info[$k] = $v;
        }
    }

}

if($_GPC['op'] == 'delete'){
    $res = pdo_delete('zhls_sun_fproblem',array('uniacid'=>$_W['uniacid'],'fid'=>$_GPC['fid']));
    if($res){
        pdo_delete('zhls_sun_fanswer',array('uniacid'=>$_W['uniacid'],'fpro_id'=>$_GPC['fid']));
        message('编辑成功！', $this->createWebUrl('paygl'), 'success');
    }else{
        message('编辑失败！');
    }
}

include $this->template('web/paygl');