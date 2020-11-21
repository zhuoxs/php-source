<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('byjs_sun_vipcard',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
$type=pdo_getall('byjs_sun_storein',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['card_name']=$_GPC['card_name'];
            $data['card_price']=$_GPC['card_price'];
            $data['card_logo']=$_GPC['card_logo'];
            $data['uniacid']=$_W['uniacid'];
//        时间判断操作
            $data['type']=$_GPC['time'];
        // if($_GPC['time'] == 1){
        //     $ban_time = date("Y-m-d H:i:s",strtotime("+1 Months"));
        //     $data['ban_time'] = $ban_time;
        // }elseif($_GPC['time'] == 2){
        //     $ban_time = date("Y-m-d H:i:s",strtotime("+3 Months"));
        //     $data['ban_time'] = $ban_time;
        // }else{
        //     $ban_time = date("Y-m-d H:i:s",strtotime("+1 Years"));
        //     $data['ban_time'] = $ban_time;
        // }
            if($_GPC['id']==''){
                $res=pdo_insert('byjs_sun_vipcard',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('vipcardlist',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{

                $res = pdo_update('byjs_sun_vipcard', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('vipcardlist',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
	
include $this->template('web/addvipcard');