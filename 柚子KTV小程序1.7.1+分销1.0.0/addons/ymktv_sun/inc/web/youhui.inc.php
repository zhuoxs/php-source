<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('ymktv_sun_youhui',array('uniacid' => $_W['uniacid']));
if(checksubmit('submit')){
        if($_GPC['lb_imgs']){

            $data['lb_imgs']= implode(',',$_GPC['lb_imgs']);
        }else{
            $data['lb_imgs']='';
        }

        $data['uniacid'] = $_W['uniacid'];
        $data['location'] = 2; //此处添加的是酒水页轮播图
        if ($_GPC['id'] ==  null || $_GPC['id'] == ''){
            $res = pdo_insert('ymktv_sun_banner',$data);
        }else{
            $res = pdo_update('ymktv_sun_banner',$data,array('id' => $_GPC['id'],'location' => 2));
        }

    if ($res){
        message('添加成功',$this->createWebUrl('youhui'),'success');
    }else{
        message('添加失败',$this->createWebUrl('youhui'),'error');
    }

}
include $this->template('web/youhui');