<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$answer=isset($_GPC['is_answer'])?$_GPC['is_answer']:2;
//$status=$_GPC['status'];
load()->func('tpl');

if($_GPC['keywords']) {
    $op = $_GPC['keywords'];
    $list = pdo_get('zhls_sun_lawyer',array('lawyers like'=>'%'.$op.'%'));
    $sql = ' SELECT * FROM ' . tablename('zhls_sun_mproblem') . ' mp ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l '  .  ' ON ' . ' mp.ls_id=l.id'. ' WHERE ' . ' mp.ls_id='.$list['id'];
    $info = pdo_fetchall($sql);
}elseif ($_GPC['op']=='answer'){
    $answer = $_GPC['is_answer'];
    if($_GPC['is_answer']==2){
        $list = pdo_getall('zhls_sun_mproblem',['uniacid'=>$_W['uniacid']],'','','time DESC');
    }else{
        $list = pdo_getall('zhls_sun_mproblem',['uniacid'=>$_W['uniacid'],'is_answer'=>$_GPC['is_answer']],'','','time DESC');
    }

    $info = [];
    foreach ($list as $k=>$v){
        if($v['ls_id']){
            $sql = ' SELECT * FROM ' . tablename('zhls_sun_mproblem') . ' mp ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l '  .  ' ON ' . ' mp.ls_id=l.id' . ' WHERE ' . ' mp.mid='.$v['mid'];
            $info[$k] = pdo_fetch($sql);
        }else{
            $info[$k] = $v;
        }
    }
}else{
    $list = pdo_getall('zhls_sun_mproblem',['uniacid'=>$_W['uniacid']],'','','time DESC');

    $info = [];
    foreach ($list as $k=>$v){

        if($v['ls_id']){
            $sql = ' SELECT * FROM ' . tablename('zhls_sun_mproblem') . ' mp ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l '  .  ' ON ' . ' mp.ls_id=l.id' . ' WHERE ' . ' mp.uniacid='.$_W['uniacid'] . ' AND ' . ' mp.mid=' .$v['mid'];
            $info[$k] = pdo_fetch($sql);
        }else{
            $info[$k] = $v;
        }
    }
//    p($info);die;
}

include $this->template('web/ddgl');