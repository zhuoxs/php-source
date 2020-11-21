<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/1
 * Time: 15:10
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzfc_sun_card',array('id'=>$_GPC['id']));
if($info){
    $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
    $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
    if(strpos($info['img'],',')){
        $lb_imgs= explode(',',$info['img']);
    }else{
        $lb_imgs=array(
            0=>$info['img']
        );
    }
    if(strpos($info['branch'],',')){
        $info['branch']= explode(',',$info['branch']);
    }else{
        $info['branch']=array(
            0=>$info['branch']
        );
    }
}

$branch=pdo_getall('yzfc_sun_branch',array('uniacid'=>$_W['uniacid'],'status'=>1));
if (checksubmit('submit')){
    if($_GPC['title']==null){
        message('请输入标题','','error');
    }elseif($_GPC['title_small']==null){
        message('请输入副标题','','error');
    }elseif($_GPC['end_time']==null){
        message('请输入结束时间','','error');
    }elseif($_GPC['start_time']==null){
        message('请输入开始时间','','error');
    }elseif($_GPC['prizenum']==null){
        message('请输入奖品数量','','error');
    }elseif($_GPC['prizename']==null){
        message('请输入奖品名称','','error');
    }
    if($_GPC['img']){
        if(count($_GPC['img'])<5){
            $data['img']=implode(",",$_GPC['img']);
        }else{
            message('图片最多只能上传三张','','error');
        }
    }else{
        $data['img']='';
    }
    if($_GPC['branch']){
        $data['branch']=implode(",",$_GPC['branch']);
    }
    $data['title']=$_GPC['title'];
    $data['title_small']=$_GPC['title_small'];
    $data['img_cover']=$_GPC['img_cover'];
    $data['start_time']=strtotime($_GPC['start_time']);
    $data['end_time']=strtotime($_GPC['end_time']);
    $data['prizenum']=$_GPC['prizenum'];
    $data['prizename']=$_GPC['prizename'];
    $data['prizetype']=$_GPC['prizetype'];
    $data['helptimes']=$_GPC['helptimes'];
    $data['drawtimes']=$_GPC['drawtimes'];
    $data['joinnum_xn']=$_GPC['joinnum_xn'];
    $data['winnum_xn']=$_GPC['winnum_xn'];
    $data['prize_details']=$_GPC['prize_details'];
    $data['rule']=$_GPC['rule'];
    $data['check_color_one']=$_GPC['check_color_one'];
    $data['check_color_two']=$_GPC['check_color_two'];
    $data['createtime']=time();
    $data['uniacid']=$_W['uniacid'];
//    var_dump($data);exit;
    if($_GPC['id']==''){
        $res=pdo_insert('yzfc_sun_card',$data);
        if($res){
            message('添加成功，请继续添加图片才能进行抽奖',$this->createWebUrl('cardfont',array('cid'=>pdo_insertid())),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res=pdo_update('yzfc_sun_card',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('cardlist',array('cid'=>$_GPC['id'])),'success');
        }else{
            message('修改失败','','error');
        }
    }
}
include $this->template('web/addcard');