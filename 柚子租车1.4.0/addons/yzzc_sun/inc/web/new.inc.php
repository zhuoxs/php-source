<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:48
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzzc_sun_new',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    if($_GPC['title']==null) {
        message('请您标题', '', 'error');
    }elseif($_GPC['content']==null) {
        message('请您填写内容', '', 'error');
    }
    $data['uniacid'] = $_W['uniacid'];
    $data['pic'] = $_GPC['pic'];
    $data['title']=$_GPC['title'];
    $data['content']=$_GPC['content'];
    $data['selftime']=date('Y-m-d H:i:s', time());
    if($_GPC['id']==''){
        $res=pdo_insert('yzzc_sun_new',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('new',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzzc_sun_new', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('new',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/new');