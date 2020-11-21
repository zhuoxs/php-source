<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzfc_sun_news',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
//if($info['cid']>0){
//    $nowclassify=pdo_get('yzfc_sun_newsclassify',array('id'=>$info['cid']));
//}
//$class=pdo_getall('yzfc_sun_newsclassify',array('uniacid'=>$_W['uniacid']));
$house=pdo_getall('yzfc_sun_house',array('uniacid'=>$_W['uniacid'],'status'=>1));
if (checksubmit('submit')){
    if($_GPC['title']==null){
        message('请输入资讯标题','','error');
    }
    if($_GPC['img']==null){
        message('请上传封面图','','error');
    }
    $data['hid']=$_GPC['hid'];
    $data['title']=$_GPC['title'];
    $data['img']=$_GPC['img'];
    $data['content']=$_GPC['content'];
    $data['author']=$_GPC['author'];
    $data['uniacid']=$_W['uniacid'];
    $data['createtime']=time();
    if($_GPC['id']==''){
        $res=pdo_insert('yzfc_sun_news',$data);
        if($res){
            message('添加成功',$this->createWebUrl('newslist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzfc_sun_news',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('newslist',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/addnews');