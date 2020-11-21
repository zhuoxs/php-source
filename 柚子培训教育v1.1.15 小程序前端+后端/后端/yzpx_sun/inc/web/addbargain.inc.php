<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/4
 * Time: 9:32
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['id']){
    $info=pdo_get('yzpx_sun_course',array('id'=>$_GPC['id']));
    if($info['cid']>0){
        $nowtype=pdo_get('yzpx_sun_courseclassify',array('id'=>$info['cid']));
    }
    if($info['tid']>0){
        $nowteacher=pdo_get('yzpx_sun_teacher',array('id'=>$info['tid']),array('id','name'));
    }

    $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
    $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);

}
$class=pdo_getall('yzpx_sun_courseclassify',array('uniacid'=>$_W['uniacid']));
$teacher=pdo_getall('yzpx_sun_teacher',array('uniacid'=>$_W['uniacid'],'status'=>1,'sid'=>0));
$school=pdo_getall('yzpx_sun_school',array('uniacid'=>$_W['uniacid'],'status'=>1));
foreach ($school as $key =>$value){
    $school[$key]['teacher']=pdo_getall('yzpx_sun_teacher',array('uniacid'=>$_W['uniacid'],'sid'=>$value['id'],'status'=>1));
}
//var_dump($school);exit;
if (checksubmit('submit')){

    $data['type']=2;
    if($_GPC['title']==null){
        message('请输入课程名称','','error');
    }elseif($_GPC['start_time']==null){
        message('请选择开课时间','','error');
    }elseif($_GPC['end_time']==null){
        message('请选择结束时间','','error');
    }elseif($_GPC['img']==null){
        message('请上传封面图','','error');
    } elseif($_GPC['cid']==null){
        message('请选择课程分类','','error');
    }
//    var_dump((($_GPC['money']-$_GPC['nowmoney'])/$_GPC['bargain_num']));exit;
    if((($_GPC['money']-$_GPC['nowmoney'])/$_GPC['bargain_num']) < 0.01){

        message('请输入正确的砍价金额，每人至少砍0.01元','','error');
    }
    $data['cid']=$_GPC['cid'];
    $data['title']=$_GPC['title'];
//    $data['tid']=$_GPC['tid'];
    $data['start_time']=strtotime($_GPC['start_time']);
    $data['end_time']=strtotime($_GPC['end_time']);
    $data['content']=$_GPC['content'];
    $data['money']=$_GPC['money'];
    $data['nowmoney']=$_GPC['nowmoney'];
    $data['signnum_xn']=$_GPC['signnum_xn']?$_GPC['signnum_xn']:0;
    $data['ordertime']=$_GPC['ordertime']?$_GPC['ordertime']:0;
    $data['uniacid']=$_W['uniacid'];
    $data['createtime']=time();
    $data['rec']=$_GPC['rec'];
    $data['img']=$_GPC['img'];
//    $data['sid']=$_GPC['sid'];
    $data['bargain_num']=$_GPC['bargain_num'];
    $data['is_floor_price']=$_GPC['is_floor_price'];
    $data['share_title']=$_GPC['share_title']?$_GPC['share_title']:'今日砍价之恩，他日必定涌泉相报';
    if($_GPC['id']==''){
        $join=$_GPC['signchoose'];
//    var_dump($join);exit;
        $sinfo= explode('-',$join[0]);
        $sid=$sinfo[0];
        $tid=$sinfo[1];
        if(($sid==null)||$tid==null){
            message('请选择校区跟老师','','error');
        }else{
            $data['sid']=$sid;
            $data['tid']=$tid;
        }
        $res=pdo_insert('yzpx_sun_course',$data);
        $cid=pdo_insertid();
        if($res){
//            $join=$_GPC['signchoose'];
//            foreach ($join as $key=>$value){
//                $join[$key]=explode('-', $value);
//                $sid=$join[$key][0];
//                $tid=$join[$key][1];
//                $tea['tid']=$tid;
//                $tea['sid']=$sid;
//                $tea['cid']=$cid;
//                $tea['createtime']=time();
//                $tea['uniacid']=$_W['uniacid'];
//                pdo_insert('yzpx_sun_course_teach',$tea);
//            }
            message('添加成功,请继续添加课时',$this->createWebUrl('lessonlist',array('couid'=>$cid,'type'=>2)),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $join=$_GPC['signchoose'];
        if($join){
            $sinfo= explode('-',$join[0]);
            $sid=$sinfo[0];
            $tid=$sinfo[1];
            if(($sid==null)||$tid==null){
                message('请选择校区跟老师','','error');
            }else{
                $data['sid']=$sid;
                $data['tid']=$tid;
            }
        }
        $res=pdo_update('yzpx_sun_course',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('bargainlist',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
if($_GPC['op']=='select_school'){
    $teacher=pdo_getall('yzpx_sun_teacher',array('uniacid'=>$_W['uniacid'],'sid'=>$_GPC['sid'],'status'=>1));

    echo json_encode($teacher);exit;
}
include $this->template('web/addbargain');