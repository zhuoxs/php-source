<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 10:54
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['id']){
    $info=pdo_get('yzfc_sun_question',array('id'=>$_GPC['id']));
    $classify=pdo_getall('yzfc_sun_question_classify',array('uniacid'=>$_W['uniacid']));
}
if (checksubmit('submit')){
    if($_GPC['answer']==null){
        message('请输入回答内容','','error');
    }elseif($_GPC['cid']==null){
        message('请选择分类','','error');
    }
    $data['answer']=$_GPC['answer'];
    $data['cid']=$_GPC['cid'];
    $data['isshow']=$_GPC['isshow'];
    $data['answertime']=time();
    if($_GPC['id']>0){

        $res=pdo_update('yzfc_sun_question',$data,array('id'=>$_GPC['id']));
        if($res){
            message('回答成功',$this->createWebUrl('questionlist',array()),'success');
        }else{
            message('回答失败','','error');
        }
    }

}

include $this->template('web/addquestion');