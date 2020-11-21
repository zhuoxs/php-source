<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('byjs_sun_coach',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));

$mall = pdo_getall('byjs_sun_mall',array('uniacid' => $_W['uniacid'],'stutes'=>1));

$mallcoach = pdo_get('byjs_sun_mallcoach',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['id']));

if(checksubmit('submit')){
    if($_GPC['star']>5){
        message('星级不能大于5！');
        return;
    }
    $data['logo']=$_GPC['img'];
    $data['num']=$_GPC['num'];
    $data['coach_name']=$_GPC['coach_name'];
    $data['state']=$_GPC['state'];
    
    $data['star']=$_GPC['star'];
    $data['life']=$_GPC['life'];
    $data['parise']=$_GPC['parise'];
    $data['uniacid']=$_W['uniacid'];
    $data['appoint'] = $_GPC['appoint'];
    $data['appmoney'] = $_GPC['appmoney'];
    $data['background'] = $_GPC['background'];
    $data['account'] = $_GPC['account'];
    $data['password'] = $_GPC['password'];
    $data['mobile'] = $_GPC['mobile'];
    $data['msg'] = $_GPC['msg'];
    $data['detail'] = $_GPC['detail'];
    $data['mall'] = $_GPC['mall'];
   	$data['coach_detail']=htmlspecialchars_decode($_GPC['coach_detail']);

    $data1['mid']=$_GPC['mall'];
    $data1['uniacid']=$_W['uniacid'];
    if(!$data['appmoney']){
        message('请填写预约金额!');
    }
	
    if($_GPC['id']==''){
      
        $re = pdo_get('byjs_sun_coach',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['account']));
        if($re){
            message('该账号已存在！');
        }else{
          	//print_r($data);die;
            $res = pdo_insert('byjs_sun_coach',$data);          	
            $data1['cid'] = pdo_insertid();
            
            $result = pdo_insert('byjs_sun_mallcoach',$data1);
            if($res&&$result){
                message('添加成功',$this->createWebUrl('coachlist',array()),'success');
            }else{
                message('添加失败','','error');
            }
        }
    }else{
        $b = pdo_getall('byjs_sun_coach',array('uniacid'=>$_W['uniacid']));
        $c = [];
        foreach ($b as $k=>$v){
            if($v['id']!=$_GPC['id']){
                if($_GPC['account']==$v['account']){
                    $c[] = $v;
                }
            }
        }
        if(empty($c)){
            $res = pdo_update('byjs_sun_coach', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            $is = pdo_get('byjs_sun_mallcoach',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['id']));
            if($is){
                $result = pdo_update('byjs_sun_mallcoach',$data1, array('cid' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            }else{
                $result = pdo_insert('byjs_sun_mallcoach', array('mid'=>$_GPC['mall'],'uniacid'=>$_W['uniacid'],'cid'=>$_GPC['id']));
            }
            
            
        }else{
            message('该账号已存在！');
        }
        // p($data1);
        if($res||$result){
            message('编辑成功',$this->createWebUrl('coachlist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/addcoach');