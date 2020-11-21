<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzkm_sun_addnews',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

//var_dump($info);die;
if(checksubmit('submit')){
    if($_GPC['title']==null) {
        message('标题不能微空哦', '', 'error');
    }
        $data['title']=$_GPC['title'];//
        $data['state']=$_GPC['state'];
        $data['type']=$_GPC['type'];//
        $data['time']=time();
        $data['uniacid']=$_W['uniacid'];

     if($_GPC['id']==''){  
        $res=pdo_insert('yzkm_sun_addnews',$data,array('uniacid'=>$_W['uniacid']));

        if($res){
             message('添加成功！', $this->createWebUrl('news'), 'success');
        }else{
        message('添加失败！','','error');
    }
}else{
        $res=pdo_update('yzkm_sun_addnews',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
             message('编辑成功！', $this->createWebUrl('news'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}
include $this->template('web/addnews');