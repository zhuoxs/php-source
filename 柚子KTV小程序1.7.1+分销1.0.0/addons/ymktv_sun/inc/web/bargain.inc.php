<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//
$info=pdo_get('ymktv_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
$servies = pdo_getall('ymktv_sun_servies',array('uniacid'=>$_W['uniacid']));
// 分店数据
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));

if($info['build_id']){
    $build_id = explode(',',$info['build_id']);
    if($info['sid']){
        $sid = explode(',',$info['sid']);
        $sids = [];
        foreach ($build_id as $k=>$v){
            foreach ($sid as $kk=>$vv){
                if($k==$kk){
                    $sids[$v]=$vv;
                }
            }
        }
    }
}


if($info['zs_imgs']){
    if(strpos($info['zs_imgs'],',')){
        $zs_imgs= explode(',',$info['zs_imgs']);
    }else{
        $zs_imgs=array(
            0=>$info['zs_imgs']
        );
    }
}
if($info['lb_imgs']){
    if(strpos($info['lb_imgs'],',')){
        $lb_imgs= explode(',',$info['lb_imgs']);
    }else{
        $lb_imgs=array(
            0=>$info['lb_imgs']
        );
    }
}

if(checksubmit('submit')){
//     p($_GPC);die;

    if($_GPC['gname']==null) {
        message('请您写商品名称', '', 'error');
    }
    elseif($_GPC['goods_cost']==null){
        message('请您写商品价格','','error');
    }
    elseif($_GPC['goods_price']==null){
        message('请您写商品价格','','error');
    }
    elseif($_GPC['starttime']==null){
        message('请您写砍价时间','','error');

    }elseif($_GPC['endtime']==null){
        message('请您写砍价时间','','error');

    }elseif($_GPC['content']==null){
        message('请您完整写完详情','','error');
    }
    elseif($_GPC['pic']== null){
        message('请您写上传图片','','error');
    }
    if ($_GPC['lb_imgs']) {
        $data['lb_imgs'] = implode(",", $_GPC['lb_imgs']);
    } else {
        $data['lb_imgs'] = '';
    }

    $data['uniacid']=$_W['uniacid'];
    $data['gname']=$_GPC['gname'];
    $data['num']=$_GPC['num'];
    $data['marketprice']=$_GPC['goods_cost'];
    $data['shopprice']=$_GPC['goods_price'];
    $data['status']=2;
    $data['starttime']=$_GPC['starttime'];
    $data['endtime']=$_GPC['endtime'];
    $data['sort']=$_GPC['sort'];

    $data['selftime']=date('Y-m-d', time());
    $data['content']=html_entity_decode($_GPC['content']);
    $data['pic'] = $_GPC['pic'];
    $data['sid'] = implode(',',$_GPC['sid']);
    $data['build_id'] = implode(',',$_GPC['build_id']);
    $data['showindex'] = $_GPC['showindex'];

    if($_GPC['showindex']==1){
        pdo_update('ymktv_sun_new_bargain',array('showindex'=>0),array('uniacid'=>$_W['uniacid'],'showindex'=>1));
    }
    if(empty($_GPC['id'])){
        $res = pdo_insert('ymktv_sun_new_bargain', $data ,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('bargainlist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('ymktv_sun_new_bargain', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('bargainlist',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/bargain');