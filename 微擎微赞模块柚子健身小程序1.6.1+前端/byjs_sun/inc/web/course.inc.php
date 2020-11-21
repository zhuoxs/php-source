<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];

//---------搜索开始-------------

//----------------审核状态--------------
if($_GPC['course_status']&&$_GPC['keywords']==null){
  	$course_status = $_GPC['course_status'];
    $where.=" and course_status=$course_status";
    
}
//-------------名字搜索--------------
if($_GPC['keywords']&&$_GPC['course_status']==null){
    $op=$_GPC['keywords'];
    $where.=" and course_name LIKE concat('%',:name,'%')";
    $data[':name']=$op;
 
}
else if($_GPC['course_status']&&$_GPC['keywords']){
    $status = $_GPC['course_status'];
    $keywords=$_GPC['keywords'];
    $where = " and course_status=$status AND course_name LIKE concat('%',:name,'%')";
    $data[':name']=$keywords;
    
}

//-------------------搜索结束------------
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$type=isset($_GPC['type'])?$_GPC['type']:'all';
$sql="SELECT * FROM ".tablename('byjs_sun_course').$where." ORDER BY id DESC";

$total=pdo_fetchcolumn("select count(*) from " .tablename('byjs_sun_course').$where,$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
//print_r($select_sql);die;
$list=pdo_fetchall($select_sql,$data);
// $coach_name=array();
foreach ($list as $key => $value) {
  $course_id = explode(',',$value['course_id']);
  // $list[$key]['course_id'] = pdo_getcolumn('byjs_sun_coach',array('uniacid'=>$_W['uniacid'],'id'=>$value['course_id']),'coach_name');

  foreach ($course_id as $k => $v) {
    $list[$key]['coach_name'] .= pdo_getcolumn('byjs_sun_coach',array('uniacid'=>$_W['uniacid'],'id'=>$v),'coach_name').'　';
     // $data['course_id'] = implode(',',$_GPC['sid']);

    // $coach_name .=pdo_get('byjs_sun_coach',array('uniacid'=>$_W['uniacid'],'id'=>$v),'coach_name')['coach_name'];
    // p($coach['coach_name']);

  }
      // array_push($coach_name, $coach['coach_name']);
} 
// p($list);
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_course',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('删除成功！', $this->createWebUrl('course'), 'success');
        }else{
              message('删除失败！','','error');
        }
}

if($_GPC['op']=='tg'){
  $rst=pdo_get('byjs_sun_course',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
  $time='';
  if($rst['time_type']==1){
    $time=24*60*60*7;

  }
  if($rst['time_type']==2){
    $time=24*30*60*60;

  }
  if($rst['time_type']==3){
    $time=24*91*60*60;

  }
  if($rst['time_type']==4){
      $time=24*182*60*60;

  }
  if($rst['time_type']==5){
      $time=24*365*60*60;

    }

    $res=pdo_update('byjs_sun_course',array('course_status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

    if($res){
         message('通过成功！', $this->createWebUrl('course'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('byjs_sun_course',array('course_status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('course'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/course');