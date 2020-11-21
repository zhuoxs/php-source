<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzkm_sun_member',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){   

            if($_GPC['name_card']==null){
                // if($_GPC['gname']==null) {
                    message('请您写完整会员卡名称', '', 'error');
                // }
            }elseif($_GPC['money']==null){
                message('会员卡价格不能为空','','error');
            }elseif($_GPC['discount']==null){
                message('会员折扣不能为空','','error');
            }elseif($_GPC['day_yxq']==null){
                message('day_yxq不能为空','','error');
            }

    $data['day_yxq']=$_GPC['day_yxq'];
    $data['money']=$_GPC['money'];
    $data['name_card']=$_GPC['name_card'];
    $data['uniacid']=$_W['uniacid'];
    $data['img']=$_GPC['img'];
    $data['discount']=$_GPC['discount'];
    $danhao = date('Ymd') . str_pad(mt_rand(1, 9), 5, '0', STR_PAD_LEFT);
    $data['number']=$danhao;
    
    if($_GPC['id']==''){
        $res = pdo_insert('yzkm_sun_member', $data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('member',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzkm_sun_member', $data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('修改成功',$this->createWebUrl('member',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }
}
include $this->template('web/member');