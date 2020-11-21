<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//课程
$info=pdo_get('byjs_sun_course',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

$coach=pdo_getall('byjs_sun_coach',array('uniacid'=>$_W['uniacid']));

// $spec=pdo_getall('byjs_sun_course_spec');
$type=pdo_getall('byjs_sun_course_type',array('uniacid'=>$_W['uniacid'],'type_status'=>1));
//$coach = pdo_getall('byjs_sun_coach',array('uniacid'=>$_W['uniacid']));
//门店
$mall = pdo_getall('byjs_sun_mall',array('uniacid'=>$_W['uniacid'],'stutes'=>1));

if($info['mall']){
    $mall_id = explode(',',$info['mall']);
    if($info['course_id']){
        $sid = explode(',',$info['course_id']);
        $sids = [];
        foreach ($mall_id as $k=>$v){
            foreach ($sid as $kk=>$vv){
                if($k==$kk){
                    $sids[$v]=$vv;
                }
            }
        }
    }
}


if(strpos($info['course_step_img'],',')){
    $info['course_step_img'] = explode(',',$info['course_step_img']);
    $info['course_step_title'] = explode(',',$info['course_step_title']);
    $info['course_step_describe'] = explode(',',$info['course_step_describe']);
}

//print_r($info['course_step_title']);die;
if(checksubmit('submit')){
    if(empty($_GPC['course_name'])){
        message('请填写课程名称');
    }
//    print_r($_GPC);die;   对步骤图做一个修改
    if($_GPC['course_step_img1']){
        $data['course_step_img'] = $_GPC['course_step_img1'].','.$_GPC['course_step_img2'].','.$_GPC['course_step_img3'].','.$_GPC['course_step_img4'];
        $data['course_step_title'] = $_GPC['course_step_title1'].','.$_GPC['course_step_title2'].','.$_GPC['course_step_title3'].','.$_GPC['course_step_title4'];
        $data['course_step_describe'] = $_GPC['course_step_describe1'].','.$_GPC['course_step_describe2'].','.$_GPC['course_step_describe3'].','.$_GPC['course_step_describe4'];
    }
//    if($_GPC['course_img']){
//        $data['course_img']=implode(",",$_GPC['course_img']);
//    }else{
//        $data['course_img']='';
//    }
  
    $data['uniacid']=$_W['uniacid'];
    $data['course_name']=$_GPC['course_name'];
    $data['course_coach']=$_GPC['course_coach'];
    $data['course_price']=$_GPC['course_price'];
    $data['course_adapt_people']=$_GPC['course_adapt_people'];
    $data['course_time']=$_GPC['course_time'];
  	$data['backimg']=$_GPC['backimg'];
    $data['course_type']=$_GPC['course_type'];
    $data['course_adapt_people']=$_GPC['course_adapt_people'];
    //$data['course_step_title']=$_GPC['course_step_title'];
    //$data['course_step_describe']=$_GPC['course_step_describe'];
    $data['course_describe']=htmlspecialchars_decode($_GPC['course_describe']);
    $data['course_img'] = $_GPC['course_img'];
 	 $data['logo'] = $_GPC['logo'];
     $data['course_id'] = implode(',',$_GPC['sid']);
  	 $data['mall'] = implode(',',$_GPC['mall']);
   $data['top'] = 1;
    // p($_GPC['sid']);
    // p(implode(',',$_GPC['sid']));die;
    


    if(empty($_GPC['id'])){
		
        $res = pdo_insert('byjs_sun_course', $data);
        $cid1=pdo_insertid();
        foreach ($_GPC['sid'] as $key => $value) {
            $data1['cid']=$value;
            $data1['cid1']=$cid1;
            $data1['uniacid']=$_W['uniacid'];
            pdo_insert('byjs_sun_coachcourse', $data1);
        }
    }else{
		$result=pdo_delete("byjs_sun_coachcourse",array('uniacid'=>$_W['uniacid'],'cid1'=>$_GPC['id']));
        $res = pdo_update('byjs_sun_course', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        foreach ($_GPC['sid'] as $key => $value) {
            $data1['cid']=$value;
            $data1['cid1']=$_GPC['id'];
            $data1['uniacid']=$_W['uniacid'];
            $result = pdo_insert('byjs_sun_coachcourse', $data1);
        }
    }
    if($res){
        message('编辑成功',$this->createWebUrl('course',array()),'success');
    }else{
        message('编辑失败','','error');
    }
}
include $this->template('web/addcourse');