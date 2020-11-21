<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$info = pdo_get('zhls_sun_type',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));

$lawyer = pdo_getall('zhls_sun_lawyer',['uniacid'=>$_W['uniacid']]);
$type = pdo_getall('zhls_sun_type',['uniacid'=>$_W['uniacid']]);
if($_GPC['pid']){
    $sql = ' SELECT * FROM ' . tablename('zhls_sun_problem') . ' p ' . ' JOIN ' . tablename('zhls_sun_lawyer') . ' l ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' p.an_id=t.id' . ' AND ' . ' p.ls_id=l.id' . ' WHERE ' . ' p.uniacid=' . $_W['uniacid'] . ' AND ' . ' p.pid=' . $_GPC['pid'];
    $info = pdo_fetch($sql);
}

if(checksubmit('submit')){
    $data['an_id']=$_GPC['an_id'];
    $data['ls_id']=$_GPC['ls_id'];
    $data['user_name']=$_GPC['user_name'];
    $data['problem']=$_GPC['problem'];
    $data['answer']=$_GPC['answer'];
    $data['uniacid']=$_W['uniacid'];
    $data['time']=date('Y-m-d H:i:s',time());
    if(!$data['an_id']){
        message('请选择案例类型！');
    }
    if($_GPC['pid']==''){
        $res=pdo_insert('zhls_sun_problem',$data);
        if($res){
            message('添加成功',$this->createWebUrl('ancontent',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('zhls_sun_problem', $data, array('pid' => $_GPC['pid']));
        if($res){
            message('编辑成功',$this->createWebUrl('ancontent',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/addanswer');