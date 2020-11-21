<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

//获取腾讯地图key
$developkey=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']),array('qqkey'));
$key1 = $developkey['qqkey'];

//查出已是商家用户
$sjuser=pdo_getall('yzhd_sun_user',array('uniacid'=>$_W['uniacid']));
$yuser = i_array_column($sjuser,'user_id');
$user=pdo_getall('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'id !='=>$yuser));
if(checksubmit('submit')){

    if($_GPC['name']==null) {
        message('请您写店铺名称', '', 'error');
    }elseif($_GPC['address']==null) {
        message('请您写店铺详细地址', '', 'error');
    }

    if($_GPC['start_time']>=$_GPC['end_time']){
        message('开始时间不得大于结束时间');
    }
    if($_GPC['stars']>5){
        message('评价最多设置5星！');
    }
//    if($_GPC['status']==1){
//        $data['stutes'] = 2;
//    }else{
//        $data['stutes'] = 1;
//    }
    $data['stutes']=$_GPC['stutes'];
    $data['stars']=$_GPC['stars'];
    $data['user_id']=$_GPC['user_id'];
    $data['cover']=$_GPC['cover'];
    $data['logo']=$_GPC['logo'];
    $data['name']=$_GPC['name'];
    $data['status']=$_GPC['status'];
    $data['uniacid']=$_W['uniacid'];
    $data['address']=$_GPC['address'];
    $data['phone']=$_GPC['phone'];
	$data['lng'] = $_GPC['lng'];
	$data['lat'] = $_GPC['lat'];
    $data['start_time'] = $_GPC['start_time'];
    $data['end_time'] = $_GPC['end_time'];
    $data['recommend_num'] = $_GPC['recommend_num'];
    $data['average'] = $_GPC['average'];
    $data['is_open_book'] = $_GPC['is_open_book'];
    $data['is_open_group'] = $_GPC['is_open_group'];
    $data['is_open_comment'] = $_GPC['is_open_comment'];
    if($_GPC['id']==''){
        $reture= pdo_get("yzhd_sun_branch" ,array('status'=>1,'uniacid'=>$_W['uniacid']));

        if($reture){
            $datas['status']=2;
            $reture= pdo_update("yzhd_sun_branch" ,$datas,array('uniacid'=>$_W['uniacid']));
            $res=pdo_insert('yzhd_sun_branch',$data,array('uniacid'=>$_W['uniacid']));
        }else{
           $res=pdo_insert('yzhd_sun_branch',$data,array('uniacid'=>$_W['uniacid']));
        }
        if($res){
            $auth = array(
                'bid' => $_GPC['id'],
                'auth' => 1,
                'uid' => $_GPC['user_id'],
                'uniacid' => $_W['uniacid'],
                'create_time' => time(),
            );
            pdo_insert('yzhd_sun_auth',$auth);
            message('添加成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $reture= pdo_get("yzhd_sun_branch" ,array('status'=>1,'uniacid'=>$_W['uniacid']));
        if($reture){
            $datas['status']=2;
            $reture= pdo_update("yzhd_sun_branch" ,$datas);
            $res = pdo_update('yzhd_sun_branch', $data, array('id' => $_GPC['id']));
        }else{
            $res = pdo_update('yzhd_sun_branch', $data, array('id' => $_GPC['id']));
        }
        if($res){
            pdo_update('yzhd_sun_auth',array('uid'=>$_GPC['user_id']),array('bid'=>$_GPC['id'],'auth'=>1,'uniacid'=>$_W['uniacid']));
            message('编辑成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
function i_array_column($input, $columnKey, $indexKey=null){
    if(!function_exists('array_column')){
        $columnKeyIsNumber  = (is_numeric($columnKey))?true:false;
        $indexKeyIsNull            = (is_null($indexKey))?true :false;
        $indexKeyIsNumber     = (is_numeric($indexKey))?true:false;
        $result = array();
        foreach((array)$input as $key=>$row){
            if($columnKeyIsNumber){
                $tmp= array_slice($row, $columnKey, 1);
                $tmp= (is_array($tmp) && !empty($tmp))?current($tmp):null;
            }else{
                $tmp= isset($row[$columnKey])?$row[$columnKey]:null;
            }
            if(!$indexKeyIsNull){
                if($indexKeyIsNumber){
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key))?current($key):null;
                    $key = is_null($key)?0:$key;
                }else{
                    $key = isset($row[$indexKey])?$row[$indexKey]:0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }else{
        return array_column($input, $columnKey, $indexKey);
    }
}
include $this->template('web/branch');
