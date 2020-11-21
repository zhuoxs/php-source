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
    $info=pdo_get('yzfc_sun_question_classify',array('id'=>$_GPC['id']));

}
if (checksubmit('submit')){
    if($_GPC['name']==null){
        message('请输入分类名称','','error');
    }elseif($_GPC['imga']==null){
        message('请上传选中前图标','','error');
    }elseif($_GPC['imgb']==null){
        message('请上传选中后图标','','error');
    }
    $data['name']=$_GPC['name'];
    $data['imga']=$_GPC['imga'];
    $data['imgb']=$_GPC['imgb'];
    $data['sort']=$_GPC['sort']?$_GPC['sort']:0;
    $data['uniacid']=$_W['uniacid'];
    if($_GPC['id']==''){
        $total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_question_classify"));
        if($total<3){
            $data['createtime']=time();
            $res=pdo_insert('yzfc_sun_question_classify',$data);
            if($res){
                message('添加成功',$this->createWebUrl('questionclassify',array()),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            message('最多只能添加三个','','error');
        }

    }else{
        $res=pdo_update('yzfc_sun_question_classify',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('questionclassify',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}

include $this->template('web/addquestionclassify');