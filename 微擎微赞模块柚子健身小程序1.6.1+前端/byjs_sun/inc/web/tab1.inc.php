<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('byjs_sun_tab',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
//        p($_GPC);die;
            $data['course']=$_GPC['course'];
            if($_GPC['courseimg']==''){
                $data['courseimg']='../../../../byjs_sun/resource/images/index/myUser.png';
            }else{
                $data['courseimg']=$_GPC['courseimg'];
            }
            
            $data['coach']=$_GPC['coach'];
            if($_GPC['coachimg']==''){
                $data['coachimg']='../../../../byjs_sun/resource/images/update/icon_coach.png';
            }else{
                $data['coachimg']=$_GPC['coachimg'];
            }
            
            $data['vip']=$_GPC['vip'];
            if($_GPC['vipimg']==''){
                $data['vipimg']='../../../../byjs_sun/resource/images/index/Fitness.png';
            }else{
                $data['vipimg']=$_GPC['vipimg'];
            }
            

        if($_GPC['id']==''){
                $res=pdo_insert('byjs_sun_tab',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('tab1',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('byjs_sun_tab', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('tab1',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/tab1');