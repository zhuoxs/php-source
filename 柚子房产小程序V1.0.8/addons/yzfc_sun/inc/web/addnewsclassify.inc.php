<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/1
 * Time: 10:39
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['id']){
    $info=pdo_get('yzfc_sun_newsclassify',array('id'=>$_GPC['id']));

}
if (checksubmit('submit')){
    if($_GPC['name']==null){
        message('请输入分类名称','','error');
    }
    $data['name']=$_GPC['name'];
    $data['sort']=$_GPC['sort']?$_GPC['sort']:0;
    $data['uniacid']=$_W['uniacid'];
    if($_GPC['id']==''){
        $data['createtime']=time();
        $res=pdo_insert('yzfc_sun_newsclassify',$data);
        if($res){
            message('添加成功',$this->createWebUrl('newsclassify',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzfc_sun_newsclassify',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('newsclassify',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}

include $this->template('web/addnewsclassify');