<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzpx_sun_news',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
if($info['cid']>0){
    $nowclassify=pdo_get('yzpx_sun_newsclassify',array('id'=>$info['cid']));
}
$class=pdo_getall('yzpx_sun_newsclassify',array('uniacid'=>$_W['uniacid']));
if (checksubmit('submit')){
    if($_GPC['title']==null){
        message('请输入新闻标题','','error');
    }
    if($_GPC['cid']==null){
        message('请选择新闻分类','','error');
    }
    $data['cid']=$_GPC['cid'];
    $data['title']=$_GPC['title'];
    $data['info']=$_GPC['info'];
    $data['content']=$_GPC['content'];
    $data['uniacid']=$_W['uniacid'];
    $data['createtime']=time();
    if($_GPC['id']==''){
        $res=pdo_insert('yzpx_sun_news',$data);
        if($res){
            message('添加成功',$this->createWebUrl('newslist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzpx_sun_news',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('newslist',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/addnews');