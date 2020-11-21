<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('wnjz_sun_servies',array('uniacid' => $_W['uniacid'],'sid'=>$_GPC['sid']));
// 获取分店数据
$branch = pdo_getall('wnjz_sun_branch',array('uniacid'=>$_W['uniacid']));
// 门店和技师关联数据
$buildhair = pdo_get('wnjz_sun_buildservies',array('uniacid'=>$_W['uniacid'],'s_id'=>$_GPC['sid']));
if(checksubmit('submit')){
    $data['z_imgs']=$_GPC['z_imgs'];
    $data['uniacid']=$_W['uniacid'];
    $data['servies_name'] = $_GPC['servies_name'];
    $data['servies_details'] = htmlspecialchars_decode($_GPC['servies_details']);
    $data['login'] = $_GPC['login'];
    $data['password'] = $_GPC['password'];
    $data['mobile'] = $_GPC['mobile'];
    $data['s_time'] = time();

    if($_GPC['sid']==''){
        $re = pdo_get('wnjz_sun_servies',array('uniacid'=>$_W['uniacid'],'login'=>$_GPC['login']));
        if($re){
            message('该账号已存在！');
        }else{
            $res=pdo_insert('wnjz_sun_servies',$data);
            $sid = pdo_insertid();
            pdo_insert('wnjz_sun_buildservies',array('uniacid'=>$_W['uniacid'],'s_id'=>$sid,'build_id'=>$_GPC['build_id']));
            if($res){
                message('添加成功',$this->createWebUrl('servies',array()),'success');
            }else{
                message('添加失败','','error');
            }
        }
    }else{
        $b = pdo_getall('wnjz_sun_servies',array('uniacid'=>$_W['uniacid']));
        $c = [];
        foreach ($b as $k=>$v){
            if($v['sid']!=$_GPC['sid']){
                if($_GPC['login']==$v['login']){
                    $c[] = $v;
                }
            }
        }
        if(empty($c)){
            $res = pdo_update('wnjz_sun_servies', $data, array('sid' => $_GPC['sid']));
            $iscun = pdo_get('wnjz_sun_buildservies',array('uniacid'=>$_W['uniacid'],'s_id'=>$_GPC['sid']));
            if($iscun){
                pdo_update('wnjz_sun_buildservies', array('build_id'=>$_GPC['build_id'],'uniacid'=>$_W['uniacid']), array('s_id' => $_GPC['sid']));
            }else{
                pdo_insert('wnjz_sun_buildservies', array('build_id'=>$_GPC['build_id'],'uniacid'=>$_W['uniacid'],'s_id'=>$_GPC['sid']));
            }

        }else{
            message('该账号已存在！');
        }
        if($res){
            message('编辑成功',$this->createWebUrl('servies',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/serviesinfo');