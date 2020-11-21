<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhd_sun_vip',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
        if(empty($_GPC['title'])) {
            message('请填写会员卡类型名称', '', 'error');
        }
        if(empty($_GPC['day'])){
            message('请填写会员卡售价','','error');
        }
        if(empty($_GPC['price'])){
            message('请填写会员卡售价','','error');
        }

        if(empty($_GPC['prefix'])){
            message('激活码前缀不能为空','','error');
        }
        $isTure=preg_match('/^[0-9a-zA-Z]+$/',$_GPC['prefix']);
        if(!$isTure){
            message('激活码前缀只允许输入数字、英文和字母！！！','','error');
        }
        $data['uniacid']=$_W['uniacid'];
        $data['title']=$_GPC['title'];
        $data['day']=$_GPC['day'];
        $data['price']=$_GPC['price'];
        $data['prefix']=$_GPC['prefix'];
        $data['status']=1;
        $data['time']=time();

        if(empty($_GPC['id'])){
            $num = count(pdo_getall('yzhd_sun_vip',array('uniacid'=>$_W['uniacid'])));
            if($num>=3){
                message('最多只能添加三个','','error');
            }else{
                $res = pdo_insert('yzhd_sun_vip', $data,array('uniacid'=>$_W['uniacid']));
            }
            if($res){
                message('添加成功',$this->createWebUrl('vip',array()),'success');
            }else{
                message('添加失败','','error');
            }
        }else{

            $res = pdo_update('yzhd_sun_vip', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        }
        if($res){
            message('修改成功',$this->createWebUrl('vip',array()),'success');
        }else{
            message('修改失败','','error');
        }
        }
include $this->template('web/addvipcard');